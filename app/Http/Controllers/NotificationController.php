<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    //admin
    function one(Request $request){
        $data = $request->all();
        $notification = Notification::find($data['id']);
        // dd($notification);
        $notification->is_read = 1;
        $update = $notification->update();
        if($update){
            $count = Notification::where('is_read',0)->get();
            return response()->json(['res' => 'success', 'count' => count($count), 'link' => $notification->link]);
        }
    }

    function load(Request $request){
        $data = $request->all();
        $offset = intval($data['page']) * 7;
        // DB::enableQueryLog();
        if($data['isCustomer']){
            $notification = Notification::where('id_customer',$data['id'])->orderBy('id_notification','desc')->skip($offset)->take(7)->get();
        }else{
            // dd(1);
            $notification = Notification::where('id_account',$data['id'])->orderBy('id_notification','desc')->skip($offset)->take(7)->get();
        }
        // $db = DB::getQueryLog();
        // dd($db);
        return response()->json(['res' => 'success', 'list' => $notification, 'page' => intval($data['page']), 'count' => count($notification)]);
    }
}
