<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('admin.dashboard', compact('notifications'));
    }

    public function markNotification(Request $request)
    {
        // error_log($request->id);
        Auth::user()
            ->unreadNotifications
            ->when($request->id, function($query) use ($request) {
                return $query->where('id', $request->id);
            })
            ->markAsRead();
        return response()->noContent();
    }
}
