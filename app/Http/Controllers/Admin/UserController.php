<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    public function getUser()
    {
        $notifications = Auth::user()->unreadNotifications;
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                echo '<div class="p-4 mb-4 text-sm bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800 flex flex-wrap justify-between
                 alert" role="alert" id="mark-'.$notification->id.'">
                <p class="text-slate-700 text-sm">
                <span class="text-slate-500">[' . $notification->created_at . '] </span>
                <span class="font-bold">' . $notification->data['name'] . '</span>
                <span class="font-thin"> (' .$notification->data['email']. ') </span>has just registered</p>
                <a class="text-sm hover:text-sky-800"  href="#" onclick="markAsRead('."'".$notification->id ."'".')">Mark as read</a></div>';
            };

            echo '<a href="#" id="mark-all" onclick="markAll('."'".$notification->id."'".')" class="text-sm">Mark all as read</a>';
        } else {
            echo 'No New User Found';
        }

        // return response()->json(['data' => $data, 'action' => $action]);
    }
}
