<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Member;
use App\Models\PaymentMethod;
use App\Models\ServiceInvoice;
use App\Models\TemporaryAppCode;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

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
                return '$' . collect($data->items)->sum('amount');
            })
            ->addColumn('email', function ($data) {
                $text = null;
                if ($data->email) {
                    $text = $data->email;
                } else {
                    $text = User::find($data->user_id)->email;
                }
                return $text;
            })
            ->addColumn('name', function ($data) {
                $text = null;
                $member = User::find($data->user_id);
                $text = $member->name;
                return $text;
            })
            ->addColumn('payment_method', function ($data) {
                $paymentmethod = PaymentMethod::findOrFail($data->payment_method);
                return $paymentmethod->name;
            })
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" class="row-select" value="' . $data->id . '">';
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ServiceInvoice $model): QueryBuilder
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;
        $data = $model::where('church_id', $currentAppCode)->with('items')->select();
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
            Column::computed('checkbox')
            ->title('<div class="text-center"><input type="checkbox" id="checkall" class="ml-2"></div>') // Center header checkbox
            ->exportable(false)
            ->printable(false)
            ->width(30)
            ->addClass('text-center align-middle'),
            Column::make('id'),
            Column::make('name'),
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
