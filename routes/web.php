<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\MateriaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function() {
        return redirect('/inicio');
    });

    Route::get('/inicio', [HomeController::class, 'inicio'])->name('inicio');

    Route::group(['prefix' => 'usuarios'], function(){
        Route::get('/', [HomeController::class, 'panel_usuarios'])->name('panel_usuarios');
        Route::post('/update_rol/{role}/{id}/{estado}', [HomeController::class, 'update_rol']);
        Route::post('/update_estudiante/{id}/{materia}', [HomeController::class, 'update_estudiante']);
    });

    Route::group(['prefix' => 'examenes'], function(){
        Route::get('/', [ExamenController::class, 'all'])->name('examenes');
        Route::get('/create', [ExamenController::class, 'create']);
        Route::get('/completados', [ExamenController::class, 'all_completados'])->name('examenes-completador');
        Route::post('/store', [ExamenController::class, 'store']);
        Route::post('/delete/{id}', [ExamenController::class, 'delete_examen']);
        Route::get('/editar/{id}', [ExamenController::class, 'editar_examen']);
        Route::post('/save_edit/{id}', [ExamenController::class, 'save_edit']);
        Route::get('/llenar/{id}', [ExamenController::class, 'llenar_examen']);
        Route::get('/completado/{id}', [ExamenController::class, 'examen_completado']);
        Route::get('/completado/calificar/{id}', [ExamenController::class, 'calificar_completado']);
        Route::post('/store/respuestas', [ExamenController::class, 'store_respuestas']);
        Route::post('/store/calificacion', [ExamenController::class, 'store_calificacion']);
        Route::post('/update_campo/{campo}/{id}/{estado}', [ExamenController::class, 'update_campo']);
        Route::post('/completados/update_campo/{campo}/{id}/{estado}', [ExamenController::class, 'completados_update_campo']);
    });

    Route::group(['prefix' => 'materias'], function(){
        Route::get('/', [MateriaController::class, 'all'])->name('materias');
        Route::post('/store', [MateriaController::class, 'store']);
        Route::post('/update/{id}', [MateriaController::class, 'update']);
        Route::post('/delete/{id}', [MateriaController::class, 'delete']);
        Route::get('/llenar/{id}', [MateriaController::class, 'llenar_examen']);
        Route::get('/completado/{id}', [MateriaController::class, 'examen_completado']);
        Route::post('/store/respuestas', [MateriaController::class, 'store_respuestas']);
        Route::post('/update_campo/{campo}/{id}/{estado}', [MateriaController::class, 'update_campo']);

    });
});

require __DIR__.'/auth.php';
