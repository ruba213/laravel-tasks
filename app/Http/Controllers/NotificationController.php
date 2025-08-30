<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
public function index(Request $request)
{
    return $request->user()->notifications;
}
public function unread(Request $request)
{
    return $request->user()->unreadNotifications;
}
public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'تم وضع الإشعار كمقروء']);
        }
        return response()->json(['message' => 'الإشعار غير موجود'], 404);
    }
}
