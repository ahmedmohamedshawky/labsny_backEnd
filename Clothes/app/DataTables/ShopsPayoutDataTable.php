<?php

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\ShopsPayout;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ShopsPayoutDataTable extends DataTable
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
            ->editColumn('updated_at', function ($shops_payout) {
                return getDateColumn($shops_payout, 'updated_at');
            })
            ->editColumn('amount', function ($shops_payout) {
                return getPriceColumn($shops_payout, 'amount');
            })
            //->addColumn('action', 'shops_payouts.datatables_actions')
            ->rawColumns(array_merge($columns));

        return $dataTable;
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
                'data' => 'shop.name',
                'title' => trans('lang.shops_payout_shop_id'),

            ],
            [
                'data' => 'method',
                'title' => trans('lang.shops_payout_method'),

            ],
            [
                'data' => 'amount',
                'title' => trans('lang.shops_payout_amount'),

            ],
            [
                'data' => 'paid_date',
                'title' => trans('lang.shops_payout_paid_date'),

            ],
            [
                'data' => 'note',
                'title' => trans('lang.shops_payout_note'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.shops_payout_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(ShopsPayout::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', ShopsPayout::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.shops_payout_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShopsPayout $model)
    {
        if(auth()->user()->hasRole('admin')){
            return $model->newQuery()->with("shop")->select('shops_payouts.*');
        }elseif (auth()->user()->hasRole('manager')){
            return $model->newQuery()->with("shop")->join('user_shops','user_shops.shop_id','=','shops_payouts.shop_id')
                ->where('user_shops.user_id',auth()->id())->select('shops_payouts.*');
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
            //->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true)
                ]
            ));
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

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'shops_payoutsdatatable_' . time();
    }
}