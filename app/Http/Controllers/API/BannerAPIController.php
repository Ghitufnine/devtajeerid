<?php

namespace App\Http\Controllers\API;


use App\Models\Banner;
use App\Repositories\UploadRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;
use DB;

/**
 * Class BannerController
 * @package App\Http\Controllers\API
 */

class BannerAPIController extends Controller
{
    /** @var  BannerRepository */
    private $bannerRepository;

     /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    public function __construct(BannerRepository $bannerRepo, 
                                CustomFieldRepository $customFieldRepo, 
                                UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->bannerRepository = $bannerRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
    }

    /**
     * Display a listing of the Banner.
     * GET|HEAD /banners
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->bannerRepository->pushCriteria(new RequestCriteria($request));
            $this->bannerRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            Flash::error($e->getMessage());
        }
        $banners = $this->bannerRepository->all();

        return $this->sendResponse($banners->toArray(), 'Banners retrieved successfully');
    }

    /**
     * Display the specified Banner.
     * GET|HEAD /banners/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function store(Request $request)
     {
         $input = $request->all();

         $banner = $this->bannerRepository->create($input);
         $banner->addMedia($request->banner)->toMediaCollection('banner');

         return response()->json([
             'data'=>$banner,
             'message'=>'Banner succesfully uploaded',
             'status'=>1
         ]);
     }
    public function show($id)
    {
        /** @var Banner $banner */
        if (!empty($this->bannerRepository)) {
            $banner = $this->bannerRepository->findWithoutFail($id);
        }

        if (empty($banner)) {
            return $this->sendError('Banner not found');
        }

        return $this->sendResponse($banner->toArray(), 'Banner retrieved successfully');
    }
    public function destroy($id)
    {
        $banner = DB::table('banners')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Deleted succesfully',
            'status' => 1
        ]);
    }
    public function popUp($id)
    {
        $popups = $this->bannerRepository->findWithoutFail($id);

        return $this->sendResponse($popups->toArray(), 'Popups retrieved successfully');
    }
}
