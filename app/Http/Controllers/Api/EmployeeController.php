<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // GET ALL EMPLOYEES
    public function index()
    {
        return response()->json(Employee::all(), 200);
    }

    // STORE EMPLOYEE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'department' => 'required',
            'salary' => 'required',
            'photo'  => 'nullable|image',
        ]);

        $path = $request->file('photo')->store('employees', 'public');
        
        $employee = Employee::create(array_merge($request->all(), ['photo' => $path]));

        
        


        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    // GET SINGLE EMPLOYEE
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        return response()->json($employee, 200);
    }

    // UPDATE EMPLOYEE
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->update($request->all());

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    // DELETE EMPLOYEE
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}