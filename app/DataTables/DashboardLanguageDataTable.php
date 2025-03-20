<?php

namespace App\DataTables;

use App\Models\DashboardLanguage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DashboardLanguageDataTable extends DataTable
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
                //     $button = '<i id="' . $data->id . '" class="edit ri-pencil-line text-info m-2"></i>';
                // }
                // if (auth()->user()->hasPermissionTo('Delete Content')) {
                    $button .= '<i id="' . $data->id . '" class="delete ri-delete-bin-line text-danger m-2"></i>';
                // }
                return $button;
            })
            ->addColumn('flag_image', function ($data) {
                if ($data->flag_image) {
                    $url = asset('storage/' . $data->flag_image); // Correct URL for public storage
                } else {
                    $url = asset('images/actor/dummy.png');
                }
                return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" class="row-select" value="' . $data->id . '">';
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DashboardLanguage $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('dashboardlanguage-table')
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
            ->orderBy(1, 'desc')
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
                ->title('<input type="checkbox" id="checkall">')  // "Select All" checkbox in the header
                ->exportable(false)
                ->printable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('title'),
            Column::make('code'),
            Column::make('flag_image')->orderable(false),
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
        return 'DashboardLanguage_' . date('YmdHis');
    }
}
