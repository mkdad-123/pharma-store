<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderNotificationController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::find(auth()->guard('warehouse')->id());

        return response()->json([
            'status' => 200,
            'message' => 'all notifications',
            'data'=>$warehouse->notifications
        ]);
    }

    public function unread()
    {
        $warehouse = Warehouse::find(auth()->guard('warehouse')->id());

        return response()->json([
            'status' => 200,
            'message' => 'Unread notifications',
            'data'=>$warehouse->unreadNotifications
        ]);
    }

    public function markReadAll()
    {
        $warehouse = Warehouse::find(auth()->guard('warehouse')->id());

        $warehouse->unreadNotifications()->update(['read_at' => now()]);

        return response()->json([
            'status' => 200,
            'message' => 'All unread notifications are marked',
            'data'=> response()
        ]);
    }

    public function markRead($id)
    {
        DB::table('notifications')->where('id' , $id)->update(['read_at' => now()]);

        return response()->json([
            'status' => 200,
            'message' => 'A unread notifications are marked',
            'data'=> response()
        ]);
    }

    public function deleteAll()
    {
        $warehouse = Warehouse::find(auth()->guard('warehouse')->id());

        $warehouse->notifications()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'All notifications have been deleted',
            'data'=> response()
        ]);
    }

    public function delete($id)
    {
        DB::table('notifications')->where('id' , $id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'A notification have been deleted',
            'data'=> response()
        ]);
    }
}
