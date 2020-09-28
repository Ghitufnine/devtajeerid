<?php

namespace App\Http\Controllers\API\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Repositories\CustomFieldRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UploadRepository;
use App\Http\Controllers\UploadController;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;
use Prettus\Validator\Exceptions\ValidatorException;
use DB;

class ShopsController extends Controller
{
    /** @var  RestaurantRepository */
    private $restaurantRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(RestaurantRepository $restaurantRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->restaurantRepository = $restaurantRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;

    }
    public function index()
    {
        $data = $this->restaurantRepository
                ->join('user_restaurants', 'restaurants.id', '=', 'user_restaurants.restaurant_id')
                ->where('user_restaurants.user_id', auth()->user()->id)
                ->get();

        return response()->json([
            'message' => 'Shops retrieved successfully!',
            'status' => 1,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
     $input = $request->all();
     $input['users'] = [auth()->id()];
        
        $restaurant = $this->restaurantRepository->create($input);
        $restaurant->addMedia($request->image)->toMediaCollection('image');  

        return response()->json([
            'data'=>$restaurant, 
            'message' => 'Toko berhasil disimpan.',
            'status' => 1]);
    }
    public function update($id, Request $request)
    {
        $shop = $this->restaurantRepository->findWithoutFail($id);

        $input = $request->all();
        $input['users'] = [auth()->id()];

        $shop = $this->restaurantRepository->update($input, $id);
        $media = DB::table('media')
                ->where('model_id', $id)
                ->where('model_type', 'App\Models\Restaurant')
                ->delete();
        $shop->addMedia($request->image)->toMediaCollection('image');

        
        return response()->json([
            'data' => $shop,
            'message' => 'Toko Berhasil di update',
            'status' => 1,
        ]);
    }
    public function show(Request $request, $id)
    {
        if (!empty($this->restaurantRepository)) {
            try{
                $this->restaurantRepository->pushCriteria(new RequestCriteria($request));
                $this->restaurantRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $restaurant = $this->restaurantRepository->findWithoutFail($id);
        }

        if (empty($restaurant)) {
            return $this->sendError('Shop not found');
        }

        return $this->sendResponse($restaurant->toArray(), 'Shop retrieved successfully');
    }

    public function destroy($id)
    {
        $data = DB::table('restaurants')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Deleted successfully!',
            'status' => 1,
            'data' => $data
        ]);
    }
}
