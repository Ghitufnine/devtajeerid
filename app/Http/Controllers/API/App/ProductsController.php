<?php

namespace App\Http\Controllers\API\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Food;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\FoodRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UploadRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;
use Prettus\Validator\Exceptions\ValidatorException;


class ProductsController extends Controller
{
    /** @var  FoodRepository */
    private $foodRepository;
    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;
    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(FoodRepository $foodRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->foodRepository = $foodRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
    }
    public function index()
    {        
        $product = $this->foodRepository
                    ->join('user_restaurants', 'foods.restaurant_id', '=', 'user_restaurants.restaurant_id')
                    ->where('user_restaurants.user_id', auth()->user()->id)->get();
        return response()->json($product);
        }
        public function show(Request $request, $id)
    {
        /** @var Food $food */
        if (!empty($this->foodRepository)) {
            try{
                $this->foodRepository->pushCriteria(new RequestCriteria($request));
                $this->foodRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $food = $this->foodRepository->findWithoutFail($id);
        }

        if (empty($food)) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($food->toArray(), 'Product retrieved successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['users'] = [auth()->id()];

            $product = $this->foodRepository->create($input);
            $product->addMedia($request->image)->toMediaCollection('image');

        return response()->json([
            'data'=>$product, 
            'message'=>'Produk berhasil tersimpan.',
            'status'=>1]);
    }
    public function update(Request $request, $id)
    {
        $product = $this->foodRepository->findWithoutFail($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $input = $request->all();
        $input['users'] = [auth()->id()];

        $product = $this->foodRepository->update($input, $id);
        $media = DB::table('media')
                ->where('model_id', $id)
                ->where('model_type', 'App\Models\Food')
                ->delete();
        $product->addMedia($request->image)->toMediaCollection('image');

        return response()->json([
            'data' => $product,
            'message' => 'Product berhasil di update!',
            'status' => 1,
        ]);
    }
    
    public function destroy($id)
    {
        $data = DB::table('foods')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Deleted successfully',
            'status' => 1,
            'data' => $data
        ]);
    }
    }
