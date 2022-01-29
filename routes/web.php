<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Personcontroller;
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

Route::get('/',[Personcontroller::class,'index']);

Route::Post('/add-person',[Personcontroller::class,'store']);

Route::Post('/edit-person',[Personcontroller::class,'edit']);

Route::post('/delete-person', [Personcontroller::class, 'destroy']);


