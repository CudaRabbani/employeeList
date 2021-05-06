<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Employee;

class EmployeeController extends Controller
{
    public function __construct() {
        if (!$this->checkIfFileExists()) {
            $newEmployees = factory(Employee::class, 20)->make();
            Storage::disk('public')->put('employees.json', json_encode($newEmployees));
        }
    }

    private function writeToFile($employeeList) : void {
        Storage::disk('public')->put('employees.json', json_encode($employeeList));
    }

    private function checkIfFileExists() : bool {
        return Storage::exists('public/employees.json');
    }

    private function getEmployeesFromFile() {
        return Storage::disk('public')->get('employees.json');
    }

    public function index() {
        $employees = $this->getEmployeesFromFile();
        return response()->json(['data' => json_decode($employees)], 200);
    }

    public function get(Request $request) {
        $employeeId = $request->route('employee');
        $employees = collect(json_decode($this->getEmployeesFromFile()));
        $foundEmployee = $employees->firstWhere('id', $employeeId);

        if (!$foundEmployee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json($foundEmployee, 200);
    }

    public function store(Request $request) {
        $existingEmployees = json_decode($this->getEmployeesFromFile(), true);

        //assuming all input data are valid for now
        //ToDo: Add input validation
        $employee = new Employee();
        $employee->id = collect($existingEmployees)->max('id')+1;
        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->email = $request->input('email');
        $employee->address = $request->input('address');
        $employee->job_role = $request->input('job_role');

        array_push($existingEmployees, $employee);

        $this->writeToFile($existingEmployees);
        return response()->json(['created' => true, 'data' => $employee], 201);
    }

    public function update(Request $request) {
        $employeeId = $request->route('employee');

        $employees = collect(json_decode($this->getEmployeesFromFile()));
        $foundEmployee = $employees->firstWhere('id', $employeeId);

        $indexOfEmployee = $employees->search(function ($employee) use ($employeeId){
            return $employee->id == $employeeId;
        });

        if (!$foundEmployee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $foundEmployee->first_name = $request->input('first_name') ?? $foundEmployee->first_name;
        $foundEmployee->last_name = $request->input('last_name') ?? $foundEmployee->last_name;
        $foundEmployee->email = $request->input('email') ?? $foundEmployee->email;
        $foundEmployee->address = $request->input('address') ?? $foundEmployee->address;
        $foundEmployee->job_role = $request->input('job_role') ?? $foundEmployee->job_role;

        $employees = $employees->replace([$indexOfEmployee => $foundEmployee]);
        $employees->all();
        $this->writeToFile($employees);
        return response()->json(['message' => 'Employee updated', 'data' => $foundEmployee]);
    }

    public function destroy(Request $request) {
        $employeeId = $request->route('employee');
        $employees = collect(json_decode($this->getEmployeesFromFile()));
        $indexOfEmployee = $employees->search(function ($employee) use ($employeeId){
            return $employee->id == $employeeId;
        });

        if (!$indexOfEmployee && $indexOfEmployee !== 0) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        if ($indexOfEmployee === 0) {
            $updatedList = $employees->shift();
            $updatedList = $employees->all();
        }
        elseif($indexOfEmployee > 0) {
            $employeeList = $employees->slice(0, $indexOfEmployee);
            $employeeListRemaining = $employees->slice($indexOfEmployee+1, $employees->count());
            $updatedList = $employeeList->merge($employeeListRemaining);
        }

        $this->writeToFile($updatedList);

        return response()->json(['message' => 'Employee deleted']);
    }


}
