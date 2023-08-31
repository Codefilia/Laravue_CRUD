<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $employee = Employee::select('employee.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name as department')
        
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->paginate(10);

        $departments = Department::all();
        return Inertia::render('Employees/Index', ['employee' => $employee,
        'departments' => $departments]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'emial' => 'required|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric'
        ]);

        $employee = new Employee($request->input());
        $employee->save();
        return redirect('employees');
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'emial' => 'required|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric',
        ]);

        $employee->update($request->input());
        return redirect('employees');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function EmployeeByDepartment()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))

        ->join('departments', 'departments.id', '=', 'employees.department_id')->groupBy('departments.name')->get();

        return Inertia::render('Employee/Graphic', ['data' => $data]);
    }

    public function reports()
    {
        $employee = Employee::select('employee.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name as department')

        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->get();

        $departments = Department::all();

        return Inertia::render('Employees/Reports', ['employee' => $employee,
        'departments' => $departments]);
    }
}
