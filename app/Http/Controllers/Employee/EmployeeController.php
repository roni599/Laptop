<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'salary' => 'required|numeric',
            'join_date' => 'required|date',
            'nid' => 'required|string|max:20',
            'image' => 'nullable|string',
        ]);

        $employee = new Employee();

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;
        $employee->join_date = $request->join_date;
        $employee->nid = $request->nid;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/employee/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/employee'))) {
                File::makeDirectory(public_path('backend/images/employee'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $employee->image = $imageName;
        }

        $employee->save();

        return response()->json(['message' => 'Employee created successfully']);
    }
    public function delete($id)
    {
        $employee = Employee::find($id);
        $image = $employee->image;
        $imagePath = public_path('backend/images/employee/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $employee->delete();
        } else {
            $employee->delete();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $request->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'salary' => 'required|numeric',
            'join_date' => 'required|date',
            'nid' => 'required|string|max:20',
            'image' => 'nullable|string',
        ]);

        $employee = Employee::find($request->id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->update($request->only('name', 'email', 'address', 'phone', 'salary', 'join_date', 'nid'));

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/employee/' . $employee->image);
            if ($employee->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/employee/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/employee'))) {
                File::makeDirectory(public_path('backend/images/employee'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $employee->image = $imageName;
        }

        $employee->save();

        return response()->json(['message' => 'Employee updated successfully']);
    }
}
