<?php

namespace App\Http\Controllers\API\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ShopCategoryController extends Controller {
    public function index()
    {
        $data = DB::table('shop_categories')->get();
        return response()->json([
            'message' => 'Data retrieved successfully!',
            'status' => 1,
            'data' => $data
        ]);
    }
}