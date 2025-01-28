<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Controllers\ClientController;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairsController;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RepairTypeController;
use App\Http\Controllers\UnauthorizedController;
use App\Http\Middleware\IsWorkingHereMiddleware;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\CheckIfClientsDataMiddleware;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/unauthorized', [UnauthorizedController::class, 'show'])->name('unauthorized');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    /**
     * Logged user routes START
     */
    Route::post('/repairs/available-times', [RepairsController::class, 'getAvailableRepairTimes'])->name('repairs.available-times');
    /**
     * Logged user routes STOP
     */
});

Route::middleware([EmployeeMiddleware::class])->group(function () {
    /**
     * Employee routes START
     */
    
    Route::get('/employeePanel', [EmployeeController::class, 'index'])->name('employeePanel');
    /**
     * Employee routes STOP
     */
});

Route::middleware([ClientMiddleware::class])->group(function () {
    /**
     * Client routes START
     */
    
    Route::get('/addRepair', [RepairsController::class, 'create'])->name('addRepair');
    Route::post('/addRepair', [RepairsController::class, 'store'])->name('storeRepair');
    /**
     * Client routes STOP
     */
    /**
     * Client API routes START
     */
    
    /**
     * Client API routes STOP
     */
});

Route::middleware([ManagerMiddleware::class])->group(function () {
    /**
     * Manager routes START
     */
    
    Route::get('/managerPanel', [ManagerController::class, 'index'])->name('managerPanel');
    Route::get('/listRepairTypes', [RepairTypeController::class, 'listRepairTypes'])->name('repairTypes.list');
    Route::delete('/listRepairTypes/{id}', [RepairTypeController::class, 'destroy'])->name('repairTypes.destroy');
    Route::get('/addRepairType', [RepairTypeController::class, 'create'])->name('repairTypes.create');
    Route::post('/addRepairType', [RepairTypeController::class, 'store'])->name('repairTypes.store');
    Route::get('/editRepairType/{id}', [RepairTypeController::class, 'edit'])->name('repairTypes.edit');
    Route::put('/editRepairType/{id}', [RepairTypeController::class, 'update'])->name('repairTypes.update');

    Route::get('/listEmployees', [EmployeeController::class, 'listEmployees'])->name('employees.list');
    Route::get('/editEmployee/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/editEmployee/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/editEmployee/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/clients/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/edit/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/paymentsPanel', [PaymentController::class, 'index'])->name('payments.panel');
    Route::get('/paymentsDay', [PaymentController::class, 'listByDate'])->name('payments.day');
    Route::get('/paymentHistory/{repair_id}', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/pendingPayments', [PaymentController::class, 'listPendingPastTerm'])->name('payments.pending');
    Route::get('/paymentsSummary', [PaymentController::class, 'summarizeMonth'])->name('payments.summary');

    /**
     * Manager routes STOP
     */
});

Route::middleware([IsWorkingHereMiddleware::class])->group(function () {
    /**
     * IsWorkingHere routes START
     */
    Route::get('/clients', [ClientController::class, 'getClientsList'])->name('clients.list');
    Route::get('/repairs', [RepairsController::class, 'listRepairsForDate'])->name('repairs.list');
    Route::get('/repairs/{id}', [RepairsController::class, 'edit'])->name('repairs.edit');
    Route::put('/repairs/{id}', [RepairsController::class, 'update'])->name('repairs.update');
    Route::delete('/repairs/{id}', [RepairsController::class, 'destroy'])->name('repairs.destroy');
    Route::get('/clients/preview/{id}', [ClientController::class, 'showClientDetails'])->name('clients.show')->middleware(CheckIfClientsDataMiddleware::class)->withoutMiddleware(IsWorkingHereMiddleware::class);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    /**
     * IsWorkingHere routes STOP
     */
});