<?php

namespace App\DataTables;

use App\Models\Restaurant;
use App\Models\CustomField;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Barryvdh\DomPDF\Facade as PDF;

class RestaurantDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('image', function ($restaurant) {
                return getMediaColumn($restaurant, 'image');
            })
            ->editColumn('updated_at', function ($restaurant) {
                return getDateColumn($restaurant, 'updated_at');
            })
            ->addColumn('action', 'restaurants.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Restaurant $model)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery();
        } else {
            return $model->newQuery()
                ->join("user_restaurants", "restaurant_id", "=", "restaurants.id")
                ->where('user_restaurants.user_id', auth()->id());
                // ->orderBy('restaurants.id');
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true)
                ]
            ));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'name',
                'title' => trans('lang.restaurant_name'),

            ],
            [
                'data' => 'image',
                'title' => trans('lang.restaurant_image'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
            [
                'data' => 'address',
                'title' => trans('lang.restaurant_address'),

            ],
            [
                'data' => 'phone',
                'title' => trans('lang.restaurant_phone'),

            ],
            [
                'data' => 'shop_category_id',
                'title' => trans('lang.shop_category_id'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.restaurant_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(Restaurant::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', Restaurant::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.restaurant_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'restaurantsdatatable_' . time();
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }
}