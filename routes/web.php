<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::any('/', [RegistrationController::class, 'Login'])->name('login');
Route::any('/register', [RegistrationController::class, 'Register'])->name('register');

Route::middleware(['admin'])->prefix('Admin')->group(function () {
    Route::any('dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');
    Route::any('department', [DepartmentController::class, 'Department'])->name('department');
    Route::any('designation', [DesignationController::class, 'Designation'])->name('designation');
    Route::any('employee', [EmployeesController::class, 'Employees'])->name('employee');
    Route::any('attendance', [AttendanceController::class, 'Attendance'])->name('attendance');
});

Route::middleware(['employee'])->prefix('Employee')->group(function () {});
