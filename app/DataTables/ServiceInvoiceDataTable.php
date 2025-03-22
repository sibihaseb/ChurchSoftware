<?php

namespace App\DataTables;

use App\Models\PaymentMethod;
use App\Models\ServiceInvoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServiceInvoiceDataTable extends DataTable
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
                $button = '<div style="display:flex"><a href="' . url('admin/invoice/' . $data->id . '/edit') . '">
                        <i class="edit ri-pencil-line text-info m-2"></i>
                    </a>';
                // }
                // if (auth()->user()->hasPermissionTo('Edit Content')) {
                $button .= '<i id="' . $data->id . '" class="delete ri-delete-bin-line text-danger m-2"></i></div>';
                // }
                return $button;
            })
            ->addColumn('amount', function ($data) {
                return collect($data->items)->sum('amount');
            })
            ->addColumn('payment_method', function ($data) {
                $paymentmethod = PaymentMethod::findOrFail($data->payment_method);
                return $paymentmethod->name;
            })

            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ServiceInvoice $model): QueryBuilder
    {
        $data = $model::with('items')->select();
        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('serviceinvoice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
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
            Column::make('email'),
            Column::make('sales_receipt_date'),
            Column::make('amount'),
            Column::make('payment_method'),
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
        return 'ServiceInvoice_' . date('YmdHis');
    }
}
