<?php

namespace App\Repositories;

use App\Models\ShopCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Interface ShopCategoriesRepository.
 *
 * @package namespace App\Repositories;
 */
class ShopCategoriesRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    public function model()
    {
        return ShopCategory::class;
    }
}
