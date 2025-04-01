<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\ServiceInvoice;
use App\Models\DonationHistory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class DonationHistoryDataTable extends DataTable
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
            ->skipAutoFilter()
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

            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ServiceInvoice $model): QueryBuilder
    {
        $data = $model::where('user_id', Auth::user()->id)->with('items')->select();
        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('donationhistory-table')
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
        return 'DonationHistory_' . date('YmdHis');
    }
}
