<?php

use App\Http\Livewire\Pages\Admin\AddUser;
use App\Http\Livewire\Pages\Admin\ViewUser;
use App\Http\Livewire\Pages\Cuti;
use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\Tugas;
use App\Http\Livewire\Pages\ViewTugas;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', Dashboard::class)->middleware(['auth'])->name('dashboard');
Route::get('/admin/view-user', ViewUser::class)->middleware(['auth'])->name('view-user');
Route::get('/admin/add-user', AddUser::class)->middleware(['auth'])->name('add-user');
Route::get('/cuti', Cuti::class)->middleware(['auth'])->name('cuti');
Route::get('/surat-tugas', Tugas::class)->middleware(['auth'])->name('surat-tugas');
Route::get('/surat-tugas/view', ViewTugas::class)->middleware(['auth'])->name('view-tugas');

require __DIR__ . '/auth.php';