<?php

namespace App\DataTables;

use App\Models\DonerReport;
use App\Models\ServiceInvoice;
use App\Models\TemporaryAppCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\PaymentMethod;

class DonerReportDataTable extends DataTable
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
                return '$' . number_format($data->total_amount, 2);
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

            ->escapeColumns([]);
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(ServiceInvoice $model, Request $request): QueryBuilder
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;
    
        $data = $model::where('church_id', $currentAppCode)
            ->with('items')
            ->withSum('items as total_amount', 'amount') // Add this line to get total amount per invoice
            ->when($request->code, function ($query) use ($request) {
                $query->whereRaw('FIND_IN_SET(?, user_id)', [$request->code]);
            })
            ->when($request->filled('date_from') && $request->filled('date_to'), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->date_from . ' 00:00:00',
                    $request->date_to . ' 23:59:59',
                ]);
            })
            ->when($request->filled('date_from') && !$request->filled('date_to'), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
            })
            ->when(!$request->filled('date_from') && $request->filled('date_to'), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            })
            ->when($request->filled('amount'), function ($query) use ($request) {
                $query->having('total_amount', '<=', $request->amount);
            })
            ->when($request->filled('payment_method'), function ($query) use ($request) {
                $query->where('payment_method', $request->payment_method);
            });
    
        return $this->applyScopes($data);
    }
    



    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('donerreport-table')
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
            Column::make('email'),
            Column::make('sales_receipt_date'),
            Column::make('amount'),
            Column::make('payment_method'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DonerReport_' . date('YmdHis');
    }
}
