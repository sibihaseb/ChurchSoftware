<?php

namespace App\DataTables;

use App\Models\ContactU;
use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactUsDataTable extends DataTable
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
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" class="row-select" value="' . $data->id . '">';
            })
            ->addColumn('action', function ($data) {
                return '<i class="delete ri-delete-bin-line text-danger m-2" data-id="' . $data->id . '" style="cursor:pointer;"></i>';
            })
            ->rawColumns(['checkbox', 'action']); // Important: don't escape HTML
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ContactUs $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contact-table') // Changed ID to something more appropriate
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'order' => [[1, 'desc']], // Order by ID (skip checkbox column)
                'responsive' => true,
                'autoWidth' => false,
                'language' => [
                    'search' => 'Filter:',
                    'lengthMenu' => 'Show _MENU_ entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'infoEmpty' => 'No entries found',
                    'zeroRecords' => 'No matching records found',
                ],
                'drawCallback' => 'function() {
                // Rebind events if necessary
                $("#checkall").on("click", function () {
                    $(".row-select").prop("checked", this.checked);
                });
            }',
            ])
            ->dom('Bfrtip') // Enables full control (buttons, filters, etc.)
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
                ->title('<input type="checkbox" id="checkall">')
                ->exportable(false)
                ->printable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::computed('DT_RowIndex')
                ->title('Id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('subject'),
            Column::make('message'),
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
        return 'ContactMessages_' . date('YmdHis');
    }
}
