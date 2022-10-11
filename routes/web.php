<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function() {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('categories', 'App\Http\Controllers\CategoryController');

    Route::resource('companies', 'App\Http\Controllers\CompanyController');

    Route::resource('customers', 'App\Http\Controllers\CustomerController');

    Route::name('reports.index')->get('reports',[\App\Http\Controllers\ReportController::class, 'index']);
    Route::name('reports.generate')->post('reports',[\App\Http\Controllers\ReportController::class, 'show']);

    Route::prefix('tasks/{task}/sessions')
        ->name('tasks.sessions.')
        ->group(function() {
            Route::name('index')->get('/', [\App\Http\Controllers\TaskSessionController::class, 'index']);
            Route::name('start')->post('/start', [\App\Http\Controllers\TaskSessionController::class, 'start']);
            Route::name('stop')->post('/{taskSession}/stop', [\App\Http\Controllers\TaskSessionController::class, 'stop']);
    });
    Route::prefix('tasks/{task}')
        ->name('tasks.status.')
        ->group(function() {
            Route::name('set')->post('/set', [\App\Http\Controllers\TaskStatusController::class, 'update']);
            Route::name('complete')->post('/complete', [\App\Http\Controllers\TaskStatusController::class, 'complete']);
            Route::name('archive')->post('/archive', [\App\Http\Controllers\TaskStatusController::class, 'archive']);

    });
    Route::resource('tasks', 'App\Http\Controllers\TaskController');

    Route::resource('tickets/{ticket}/note', 'App\Http\Controllers\TicketNoteController')->names('tickets.notes');
    Route::resource('tickets/{ticket}/user', 'App\Http\Controllers\TicketAssignUserController')->only(['index', 'store'])->names('tickets.assign-user');
    Route::resource('tickets/{ticket}/status', 'App\Http\Controllers\TicketStatusController')->only(['index', 'store'])->names('tickets.status');
    Route::resource('tickets/{ticket}/task', 'App\Http\Controllers\TicketTaskController')->only(['index', 'store'])->names('tickets.tasks');
    Route::resource('tickets', 'App\Http\Controllers\TicketController');

    Route::resource('users', 'App\Http\Controllers\UserController');


});

Route::get('test.html', function() {

    return response(file_get_contents(public_path('text.html')));

});

