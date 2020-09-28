<?php

namespace App\Http\Controllers\API\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DashboardAPIController extends Controller
{
    public function index()
    {
        
        $orderCount = DB::table('orders')
            ->join('food_orders', 'orders.id', '=', 'food_orders.order_id')
            ->join('foods', 'foods.id', '=', 'food_orders.food_id')
            ->join('restaurants', 'restaurants.id', '=', 'foods.restaurant_id')
            ->join('user_restaurants', 'user_restaurants.restaurant_id', '=', 'restaurants.id')
            ->where('user_restaurants.user_id', auth()->user()->id)
            ->count();
        $shopsCount = DB::table('restaurants')
            ->join('user_restaurants', 'restaurants.id', '=', 'user_restaurants.restaurant_id')
            ->where('user_restaurants.user_id', auth()->user()->id)    
            ->count();
        $shops = DB::table('restaurants', 'user_restaurants')
            ->join('user_restaurants', 'restaurants.id', '=', 'user_restaurants.restaurant_id')
            ->join('users', 'users.id', '=', 'user_restaurants.user_id')
            ->select('restaurants.*', 'users.name as owner')
            ->where('users.id', auth()->user()->id)
            ->get();

        $earning = DB::table('payments')
            ->where('payments.user_id', auth()->user()->id)
            ->sum('price');
        $ajaxEarningUrl = route('payments.byMonth',['api_token'=>auth()->user()->api_token]);
    
        return response()->json([
            'message' => 'Retrieved Data Successfully',
            'status' => 1,
            'data' => [
                'total_order' => $orderCount,
                'total_shop' => $shopsCount,
                'shop_data' => $shops,
                'earningPerMonth' => $ajaxEarningUrl
            ]
        ]);
    }
}
