<?php
/**
 * File name: ClothesOrderDataTable.php
 * Last modified: 2020.06.11 at 16:10:52
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\ClothesOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ClothesOrderDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];
    public $id = 0;

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
            ->editColumn('updated_at', function ($clothes_order) {
                return getDateColumn($clothes_order, 'updated_at');
            })
            ->editColumn('extras', function ($clothesOrder) {
                return getArrayColumn($clothesOrder->extras, 'name');
            })
            ->editColumn('price', function ($clothesOrder) {
                foreach ($clothesOrder->extras as $extra) {
                    $clothesOrder['price'] += $extra->price;
                }
                return getPriceColumn($clothesOrder);
            })
            ->rawColumns(array_merge($columns));

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ClothesOrder $model)
    {
        return $model->newQuery()->with("clothes")
            ->where('clothes_orders.order_id', $this->id)
            ->select('clothes_orders.*')->orderBy('clothes_orders.id', 'desc');

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
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'dom' => 'rt',
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
                'data' => 'clothes.name',
                'title' => trans('lang.clothes_order_clothes_id'),
                'orderable' => false,
                'searchable' => false,

            ],
            [
                'data' => 'extras',
                'title' => trans('lang.clothes_order_extras'),
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'data' => 'price',
                'title' => trans('lang.clothes_order_price'),
                'orderable' => false,

            ],
            [
                'data' => 'quantity',
                'title' => trans('lang.clothes_order_quantity'),
                'orderable' => false,

            ]
        ];

        $hasCustomField = in_array(ClothesOrder::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', ClothesOrder::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.clothes_order_' . $field->name),
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
        return 'clothes_ordersdatatable_' . time();
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