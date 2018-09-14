<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return $request->user()->notifications;
    }

    public function markAsRead(Request $request, $notification_id)
    {
        return $request->user()->notifications()->findOrFail($notification_id)->markAsRead();
    }
}
