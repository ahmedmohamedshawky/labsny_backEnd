<?php
/**
 * File name: ShopReviewDataTable.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\DataTables;

use App\Criteria\ShopReviews\ShopReviewsOfUserCriteria;
use App\Criteria\ShopReviews\OrderShopReviewsOfUserCriteria;
use App\Models\CustomField;
use App\Models\ShopReview;
use App\Repositories\ShopReviewRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

/**
 * Class ShopReviewDataTable
 * @package App\DataTables
 */
class ShopReviewDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * @var ShopReviewRepository
     */
    private $shopReviewRepo;

    private $myReviews;


    /**
     * ShopReviewDataTable constructor.
     * @param ShopReviewRepository $shopReviewRepo
     */
    public function __construct(ShopReviewRepository $shopReviewRepo)
    {
        $this->shopReviewRepo = $shopReviewRepo;
        $this->myReviews = $this->shopReviewRepo->getByCriteria(new ShopReviewsOfUserCriteria(auth()->id()))->pluck('id')->toArray();
    }

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
            ->editColumn('updated_at', function ($shop_review) {
                return getDateColumn($shop_review, 'updated_at');
            })->addColumn('action', function ($shop_review) {
                return view('shop_reviews.datatables_actions', ['id' => $shop_review->id, 'myReviews' => $this->myReviews])->render();
            })
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShopReview $model
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function query(ShopReview $model)
    {
        $this->shopReviewRepo->pushCriteria(new OrderShopReviewsOfUserCriteria(auth()->id()));
        return $this->shopReviewRepo->with("user")->with("shop")->newQuery();

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
                'data' => 'review',
                'title' => trans('lang.shop_review_review'),

            ],
            [
                'data' => 'rate',
                'title' => trans('lang.shop_review_rate'),

            ],
            [
                'data' => 'user.name',
                'title' => trans('lang.shop_review_user_id'),

            ],
            [
                'data' => 'shop.name',
                'title' => trans('lang.shop_review_shop_id'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.shop_review_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(ShopReview::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', ShopReview::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.shop_review_' . $field->name),
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
        return 'shop_reviewsdatatable_' . time();
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