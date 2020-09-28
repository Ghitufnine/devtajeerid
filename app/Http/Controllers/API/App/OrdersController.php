<?php

namespace App\Http\Controllers\API\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        $data = DB::table('orders')
        ->join('food_orders', 'orders.id', '=', 'food_orders.order_id')
        ->join('foods', 'foods.id', '=', 'food_orders.food_id')
        ->join('restaurants', 'restaurants.id', '=', 'foods.restaurant_id')
        ->join('user_restaurants', 'restaurants.id', '=', 'user_restaurants.restaurant_id')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
        ->join('delivery_addresses', 'delivery_addresses.id', '=', 'delivery_address_id')
        ->join('payments', 'payments.id', '=', 'orders.payment_id')
        ->select(
            'orders.id as order_id', 'orders.created_at as tanggal',
            'orders.delivery_fee',
            'delivery_addresses.address as address', 'delivery_addresses.latitude', 'delivery_addresses.longitude',
            'payments.status as paymen_status',
            'payments.price as total_price',
            'order_statuses.status as Status',
            'restaurants.name as shop',
            'users.name as buyer')
        ->where('user_restaurants.user_id', auth()->user()->id)
        ->groupBy('orders.id')
        ->orderBy('orders.created_at', 'asc')
        ->get();

        return response()->json([
            'message' => 'Data retrieved succesfully',
            'status' => 1,
            'data' => $data
    ]);
        
    }
    public function update($id, Request $request)
    {
        $data = DB::table('orders')->update([
            'user_id' => $request->user_id,
            'order_status_id' => $request->order_status_id,
            'tax' => $request->tax,
            'hint' => $request->hint,
            'delivery_fee' => $request->delivery_fee,
            'payment_id' => $request->payment_id,
            'delivery_address_id' => $request->delivery_address_id,
            'driver_id' => $request->driver_id
        ]);

        return response()->json([
            'message' => 'Update data succesffully',
            'status' => 1,
            'data' => $data
        ]);
    }
    public function show($id)
    {
        // return $this->sendResponse(
        //     DB::table('food_orders', 'orders')
        //     ->join('foods', 'foods.id', '=', 'food_orders.food_id')
        //     ->join('restaurants', 'restaurants.id', '=', 'foods.restaurant_id')
        //     ->join('user_restaurants', 'restaurants.id', '=', 'user_restaurants.restaurant_id')
        //     ->join('orders', 'orders.id', '=', 'food_orders.order_id')
        //     ->join('users', 'users.id', '=', 'orders.user_id')
        //     ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
        //     ->select(
        //         'order_statuses.status as Status',
        //         'foods.name as Product',
        //         'restaurants.name as shop',
        //         'users.name as Buyer',
        //         'orders.tax','orders.hint',
        //         'food_orders.price as price', 'food_orders.quantity as quantity')
        //     ->where('orders.id', $id)
        //     ->where('user_restaurants.user_id', auth()->user()->id)
        //     ->groupBy('foods.id')
        //     ->orderBy('foods.id', 'asc')
        //     ->get()
        // , 'Orders retrieved succesfully');
        $productOrder = DB::table('food_orders')
            ->join('orders', 'orders.id', '=', 'food_orders.order_id')
            ->join('foods', 'foods.id', 'food_orders.food_id')
            ->select('foods.name as product', 'foods.price',
                      'food_orders.quantity')
            ->where('orders.id', $id)
            
            ->get();
        $orders = DB::table('orders')
            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            ->join('payments', 'payments.id', '=', 'orders.payment_id')
            ->join('delivery_addresses', 'delivery_addresses.id', '=', 'orders.delivery_address_id')
            ->join('users', 'users.id', '=','orders.user_id')
            ->select('order_statuses.status as status',
                     'orders.tax', 'orders.hint', 'orders.delivery_fee',
                     'delivery_addresses.address', 'delivery_addresses.description', 'delivery_addresses.latitude', 'delivery_addresses.longitude',
                     'users.name as buyer',
                     'payments.price as subtotal',
                    )
            ->where('orders.id', $id)
            ->groupBy('orders.id')
            ->get();

        return response()->json([
            'message' => 'Detail order retrieved',
            'status' => 1,
            'data' =>
                $orders,
                'product' => $productOrder
        ]);
    }

    public function destroy($id)
    {
        $data = DB::table('orders')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Deleted Succesfully!',
            'status' => 1,
            'data' => $data
        ]);
    }
}
