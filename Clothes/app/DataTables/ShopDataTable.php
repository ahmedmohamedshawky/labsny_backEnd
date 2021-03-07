<?php
/**
 * File name: ShopDataTable.php
 * Last modified: 2020.04.30 at 08:21:09
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ShopDataTable extends DataTable
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
            ->editColumn('image', function ($shop) {
                return getMediaColumn($shop, 'image');
            })
            ->editColumn('updated_at', function ($shop) {
                return getDateColumn($shop, 'updated_at');
            })
            ->editColumn('closed', function ($clothes) {
                return getNotBooleanColumn($clothes, 'closed');
            })
            ->editColumn('available_for_delivery', function ($clothes) {
                return getBooleanColumn($clothes, 'available_for_delivery');
            })
            ->editColumn('active', function ($shop) {
                return getBooleanColumn($shop, 'active');
            })
            ->addColumn('action', 'shops.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shop $model)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery();
        } else if (auth()->user()->hasRole('manager')){
            return $model->newQuery()
                ->join("user_shops", "shop_id", "=", "shops.id")
                ->where('user_shops.user_id', auth()->id())
                ->groupBy("shops.id")
                ->select("shops.*");
        }else if(auth()->user()->hasRole('driver')){
            return $model->newQuery()
                ->join("driver_shops", "shop_id", "=", "shops.id")
                ->where('driver_shops.user_id', auth()->id())
                ->groupBy("shops.id")
                ->select("shops.*");
        } else if (auth()->user()->hasRole('client')) {
            return $model->newQuery()
                ->join("clothes", "clothes.shop_id", "=", "shops.id")
                ->join("clothes_orders", "clothes.id", "=", "clothes_orders.clothes_id")
                ->join("orders", "orders.id", "=", "clothes_orders.order_id")
                ->where('orders.user_id', auth()->id())
                ->groupBy("shops.id")
                ->select("shops.*");
        } else {
            return $model->newQuery();
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
            ->addAction(['title'=>trans('lang.actions'),'width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
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
                'data' => 'image',
                'title' => trans('lang.shop_image'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
            [
                'data' => 'name',
                'title' => trans('lang.shop_name'),

            ],
            [
                'data' => 'address',
                'title' => trans('lang.shop_address'),

            ],
            [
                'data' => 'phone',
                'title' => trans('lang.shop_phone'),

            ],
            [
                'data' => 'mobile',
                'title' => trans('lang.shop_mobile'),

            ],
            [
                'data' => 'available_for_delivery',
                'title' => trans('lang.shop_available_for_delivery'),

            ],
            [
                'data' => 'closed',
                'title' => trans('lang.shop_closed'),

            ],
            [
                'data' => 'active',
                'title' => trans('lang.shop_active'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.shop_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(Shop::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', Shop::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.shop_' . $field->name),
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
        return 'shopsdatatable_' . time();
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