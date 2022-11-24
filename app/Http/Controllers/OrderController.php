<?php

namespace App\Http\Controllers;

use App\Models\Order;

 use App\Models\Darzelis;
use App\Models\Tevai;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();

        $generatedOrders = [];

        foreach ($orders as $order) {
            $school = Tevai::find($order->tevai_id);
            if($school->darzelis_id) {
                $country = Darzelis::find($school->darzelis_id);
                // $order['tevai_name'] = $country->name;
                $order['tevai_lname'] = $country->lname;

            } else {
                $order['tevai_name'] = 'Not assigned';
            }

            $order['tevai_name'] = $school->name;
            $order['tevai_lname'] = $country->lname;

            $order['class'] = $school->class;
            $order['birthday'] = $school->birthday;
            $order['personalCode'] = $school->personalCode;
             $generatedOrders[] = $order;
        }

        if ($generatedOrders) {
            return response()->json([
                'success' => true,
                'message' => $generatedOrders
            ]);
        } else {
            return response()->json([
                'success' => false,
                'Failed to get order list'
            ], 500);
        }
    }

    public function all()
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $orders = Order::all();

        $generatedOrders = [];

        foreach ($orders as $order) {
            $school = Tevai::find($order->tevai_id);
            if($school->tevai_id) {
                $country = Darzelis::find($school->darzelis_id);
                $order['tevai_name'] = $country->name;
                $order['tevai_lname'] = $country->lname;

            } else {
                $order['tevai_name'] = 'Not assigned';
                $order['tevai_lname'] = 'Not assigned';

            }
            $order['tevai_name'] = $school->name;
            $order['class'] = $school->class;
            $order['birthday'] = $school->birthday;
            $order['personalCode'] = $school->personalCode;
            $generatedOrders[] = $order;
        }

        return response()->json([
            'success' => true,
            'message' => $generatedOrders
        ]);
    }



    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'tevai_id' => 'required'
        // ]);


        $order = new Order();
        $order->tevai_id = $request->tevai_id;
        $order->approved = 0;
        $order->user_id = auth()->user()->id;

        if ($order->save())
            return response()->json([
                'success' => true,
                'message' => $order->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order'
            ], 500);
    }

    public function status($id, Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $order = Order::find($id);
        if ($order->update(['approved' => $order->approved === 0 ? 1 : 0]))
            return response()->json([
                'success' => true,
                'message' => 'The order has been successfully confirmed'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to confirm order'
            ], 500);
    }



    public function destroy($id, Order $orders)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $order = Order::where('id', $id);

        if ($order->delete())
            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order'
            ], 500);
    }
}
