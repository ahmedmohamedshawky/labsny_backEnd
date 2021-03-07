<?php
/**
 * File name: ClothesReviewDataTable.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\DataTables;

use App\Criteria\ClothesReviews\OrderClothesReviewsOfUserCriteria;
use App\Criteria\ClothesReviews\ClothesReviewsOfUserCriteria;
use App\Models\CustomField;
use App\Models\ClothesReview;
use App\Repositories\ClothesReviewRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ClothesReviewDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];
    private $clothesReviewRepo;
    private $myReviews;


    public function __construct(ClothesReviewRepository $clothesReviewRepo)
    {
        $this->clothesReviewRepo = $clothesReviewRepo;
        $this->myReviews = $this->clothesReviewRepo->getByCriteria(new ClothesReviewsOfUserCriteria(auth()->id()))->pluck('id')->toArray();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('updated_at', function ($clothes_review) {
                return getDateColumn($clothes_review, 'updated_at');
            })
            ->addColumn('action', function ($clothes_review) {
                return view('clothes_reviews.datatables_actions', ['id' => $clothes_review->id, 'myReviews' => $this->myReviews])->render();
            })
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function query(ClothesReview $model)
    {
        $this->clothesReviewRepo->resetCriteria();
        $this->clothesReviewRepo->pushCriteria(new OrderClothesReviewsOfUserCriteria(auth()->id()));
        return $this->clothesReviewRepo->with("user")->with("clothes")->newQuery();
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
                'title' => trans('lang.clothes_review_review'),

            ],
            [
                'data' => 'rate',
                'title' => trans('lang.clothes_review_rate'),

            ],
            [
                'data' => 'user.name',
                'title' => trans('lang.clothes_review_user_id'),

            ],
            [
                'data' => 'clothes.name',
                'title' => trans('lang.clothes_review_clothes_id'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.clothes_review_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(ClothesReview::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', ClothesReview::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.clothes_review_' . $field->name),
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
        return 'clothes_reviewsdatatable_' . time();
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