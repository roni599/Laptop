<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return response()->json($role);
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|min:3|max:255|unique:roles,role_name',
            'privilege' => 'required',
        ]);
        $role = new Role();
        $role->role_name = $request['role_name'];
        $role->permissions = $request['privilege'];
        $role->save();
        return response()->json(['message' => 'Role created successfully']);
    }
    public function update(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string',
            'privilege' => 'required',
        ]);

        $role = Role::find($request->id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->role_name = $request['role_name'];
        $role->permissions = $request['privilege'];

        $role->save();

        return response()->json(['message' => 'Role updated successfully']);
    }
    public function delete($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $role->delete();
        return response()->json(['message' => 'Role delete successfully']);
    }
    public function all()
    {
        $user = User::with(['role'])->get();
        return response()->json($user);
    }

    public function userUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|string',
        ]);

        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/users/' . $user->image);
            if ($user->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/users/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/users'))) {
                File::makeDirectory(public_path('backend/images/users'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $user->profile_img = $imageName;
        }
        $user->update([
            'user_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'User updated successfully']);
    }
    public function deleted($id)
    {
        $user = User::find($id);
        $image = $user->profile_img;
        $imagePath = public_path('backend/images/users/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $user->delete();
        } else {
            $user->delete();
        }
    }
}
