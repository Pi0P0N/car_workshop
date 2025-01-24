<?php
use App\Http\Middleware\IsWorkingHereMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Controllers\ClientController;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RepairsController;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UnauthorizedController;
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

    Route::get('/clients/{id}', [ClientController::class, 'showClientDetails'])->name('clients.show')->middleware(CheckIfClientsDataMiddleware::class)->withoutMiddleware(EmployeeMiddleware::class);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
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
    /**
     * IsWorkingHere routes STOP
     */
});