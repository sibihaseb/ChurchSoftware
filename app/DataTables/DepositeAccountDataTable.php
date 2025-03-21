<?php

namespace App\DataTables;

use App\Models\DepositeAccount;
use App\Models\TemporaryAppCode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DepositeAccountDataTable extends DataTable
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
            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DepositeAccount $model): QueryBuilder
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
                    ->setTableId('depositeaccount-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('id'),
            Column::make('name'),
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
        return 'DepositeAccount_' . date('YmdHis');
    }
}
