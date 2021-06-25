<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Employee;
use App\Models\Area;
use App\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Employee::with(['area']);

            
            $employees = $query->paginate($request->length);

            return response()->json($employees, 200);
        }

        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::forDropdown();
        $roles = Role::forDropdown();
        
        return view('employees.create', compact('areas','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = new Employee();
        $employee = $this->createOrUpdate($employee, $request);

        return redirect()->route('employees.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Empleado creado exitosamente'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::with(['employee_rol'])->where('id', $id)->first();
        $areas = Area::forDropdown();
        $roles = Role::forDropdown();
        

        $roles_id = array();
        
        foreach($employee['employee_rol'] as $employee_rol){
            $roles_id[] = $employee_rol['role_id'];            
        }

        if (!$employee)
            return redirect()->route('employees.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Empleado'
                ]
            ]);

        return view('employees.edit', compact('employee','areas','roles','roles_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee)
            return redirect()->route('employees.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Empleado'
                ]
            ]);

        $employee->employee_rol()->delete();
        $employee = $this->createOrUpdate($employee, $request);

        return redirect()->route('employees.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Empleado actualizado exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee)
            return redirect()->route('employees.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Empleado'
                ]
            ]);

        $employee->employee_rol()->delete();
        $employee->delete();

        return redirect()->route('employees.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Empleado eliminado'
            ]
        ]);
    }

    public function createOrUpdate(Employee $employee, Request $request)
    {
        $employee->fill($request->all());
        $employee->save();

        $employee->createOrUpdateEmployeeRol($request);

        return $employee;
    }

}
