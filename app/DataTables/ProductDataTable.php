<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\TemporaryAppCode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $button = null;
                // if (auth()->user()->hasPermissionTo('Edit Content')) {
                    $button = '<i id="' . $data->id . '" class="edit ri-pencil-line text-info m-2"></i>';
                // }
                // if (auth()->user()->hasPermissionTo('Delete Content')) {
                    $button .= '<i id="' . $data->id . '" class="delete ri-delete-bin-line text-danger m-2"></i>';
                // }
                return $button;
            })
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" class="row-select" value="' . $data->id . '">';
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->diffForHumans() : '-';
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;
        $query = $model::where('church_id', $currentAppCode)->select();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'drawCallback' => 'function() {
                            var table = this.api(); // Store the DataTable API instance
                            let checkedCount = 0;
                            $(".row-select").each(function() {
                                // Check if the checkbox should be checked based on selectedIds
                                if (selectedIds.has($(this).val())) {
                                console.log($(this).val())
                                    $(this).prop("checked", true);
                                    checkedCount++;
                                } else {
                                    $(this).prop("checked", false); // Optionally reset unchecked
                                }
                            });
        
                            if ($(".row-select").length === checkedCount) {
                                $("#checkall").prop("checked", true);
                            } else {
                                $("#checkall").prop("checked", false);
                            }
                        }',
                    ])
                    //->dom('Bfrtip')
                   ->orderBy(1,'asc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                      
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('checkbox')
            ->title('<div class="text-center"><input type="checkbox" id="checkall" class="ml-2"></div>') // Center header checkbox
            ->exportable(false)
            ->printable(false)
            ->width(30)
            ->addClass('text-center align-middle'),
            // Column::make('id'),
            Column::make('name'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
