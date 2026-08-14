<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SalaryDetailsController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\SalaryPeriodController;
use App\Models\SalaryPayment;
use Illuminate\Support\Facades\Route;

// Route::any('/', [RegistrationController::class, 'Login'])->name('login');
// Route::any('/register', [RegistrationController::class, 'Register'])->name('register');

// Route::middleware(['admin'])->prefix('Admin')->group(function () {
    Route::any('/', [DashboardController::class, 'Dashboard'])->name('dashboard');
    Route::any('/department', [DepartmentController::class, 'Department'])->name('department');
    Route::any('/designation', [DesignationController::class, 'Designation'])->name('designation');
    Route::any('/employee', [EmployeesController::class, 'Employees'])->name('employee');
    Route::any('/attendance', [AttendanceController::class, 'Attendance'])->name('attendance');
    Route::any('/salary_period', [SalaryPeriodController::class, 'SalaryPeriod'])->name('salary_period');
    Route::any('/salary_details', [SalaryDetailsController::class, 'SalaryDetails'])->name('salary_details');
    Route::any('/salary_details_export', [SalaryDetailsController::class, 'SalaryDetailsPDF'])->name('salary_details_export');
    // Route::any('/salary_payment', [SalaryPaymentController::class, 'SalaryPayment'])->name('salary_payment');

// });

// Route::middleware(['employee'])->prefix('Employee')->group(function () {});
