<?php

namespace App\Http\Controllers\ActivityLogController;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index($user_id)
    {
        $logs = ActivityLog::with('user')->where('user_id', $user_id)->get();
        return response()->json($logs);
    }
    public function create(Request $request)
    {
        
        ActivityLog::create([
            'user_id' => $request->user_id,
            'type' => 'logout',
            'status' => '0'
        ]);
    }
}
