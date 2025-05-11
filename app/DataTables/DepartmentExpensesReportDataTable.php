<?php

namespace App\DataTables;

use App\Models\Department;
use App\Models\DepartmentExpensesReport;
use App\Models\Expenses;
use App\Models\ExpensesTypes;
use App\Models\TemporaryAppCode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DepartmentExpensesReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Clone the query to calculate the total from filtered data
        $totalBudget = (clone $query)->sum('amount');
        return datatables()
            ->eloquent($query)
            ->addColumn('deprtment', function ($data) {
                $departmentIds = explode(',', $data->department_id); // convert comma-separated string to array

                $departments = Department::whereIn('id', $departmentIds)->pluck('name'); // fetch department names

                $title = '';
                foreach ($departments as $department) {
                    $title .= '<span class="badge text-bg-primary mb-1" role="button" style="font-size: 12px;">' . $department . '</span> ';
                }

                return $title ?: '<span class="text-muted">No Departments</span>';
            })
            ->addColumn('Expenses Types', function ($data) {
                $typeIds = explode(',', $data->type_id); // convert comma-separated string to array

                $types = ExpensesTypes::whereIn('id', $typeIds)->pluck('name'); // fetch type names

                $title = '';
                foreach ($types as $type) {
                    $title .= '<span class="badge text-bg-success mb-1" role="button" style="font-size: 12px;">' . $type . '</span> ';
                }

                return $title ?: '<span class="text-muted">No Budget Types</span>';
            })
            ->addColumn('Total Expenses', function () use ($totalBudget) {
                return '<span class="text-success fw-bold">' . number_format($totalBudget, 2) . '</span>';
            })
            ->addIndexColumn()
            ->escapeColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Expenses $model, Request $request): QueryBuilder
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;

        $data = $model::where('church_id', $currentAppCode)
            ->when($request->code, function ($query) use ($request) {
                $query->whereRaw('FIND_IN_SET(?, department_id)', [$request->code]);
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
            });

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('departmentexpensesreport-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1, 'asc')
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
            Column::computed('DT_RowIndex')
                ->title('Id'),
            Column::make('name'),
            Column::make('amount'),
            Column::make('deprtment'),
            Column::make('Expenses Types'),
            Column::make('purpose'),
            Column::make('Total Expenses'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DepartmentExpensesReport_' . date('YmdHis');
    }
}
