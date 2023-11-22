<?php

use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//name();はURL（任意）の名前をしているだけなので、name()の中は適当な名前でよい

Route::post('todo/create', [TodoController::class, 'store'])->name('api.todo.create');
Route::get("todo/{id}", [TodoController::class, "edit"])->name("api.todo.edit");
Route::put("todo/{id}/edit", [TodoController::class, "update"])->name("api.todo.update");
Route::delete("todo/{id}", [TodoController::class, "destroy"])->name("api.todo.delete");
