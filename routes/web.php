<?php

use App\Http\Controllers\ProfileController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserBookingController;

Route::get('/', function () {
    return view('welcome');
});

//ruta para discriminar el usuario al loguearse
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboardAdmin');
    }

    return redirect()->route('user.dashboardUser'); 
})->middleware(['auth', 'verified'])->name('dashboard');

//rutas para el control de perfiles 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//rutas para el control de los sevicios 
Route::get('/services', [ServiceController::class, 'index'])
    ->middleware(['auth', 'verified']) 
    ->name('admin.services');

Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
Route::get('/services/{service}', [ServiceController::class, 'edit'])->name('services.edit');
Route::patch('/services/{service}', [ServiceController::class, 'update'])->name('services.update');

//rutas para el control de reservas
Route::get('/admin/booking', [BookingController::class, 'index'])
    ->middleware(['auth', 'verified']) 
    ->name('admin.booking');

Route::post('/admin/booking', [BookingController::class, 'store'])->name('booking.store');
Route::delete('/admin/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
Route::get('/admin/booking/{booking}', [BookingController::class, 'edit'])->name('booking.edit');
Route::patch('/admin/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');


//rutas para el control de publicaciones
Route::get('/activity', [ActivityController::class, 'index'])
    ->middleware(['auth', 'verified']) 
    ->name('admin.activity');

Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
Route::delete('/activity/{activity}', [ActivityController::class, 'destroy'])->name('activity.destroy');
Route::get('/activity/{activity}', [ActivityController::class, 'edit'])->name('activity.edit');
Route::patch('/activity/{activity}', [ActivityController::class, 'update'])->name('activity.update');

//ruta para cargar el panel de graficos en el dashboard de admin
Route::get('/dashboardAdmin', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified']) 
    ->name('admin.dashboardAdmin');

//ruta para cargar las tarjetas de reservas en el panel de usuarios
Route::get('dashboardUser', [UserDashboardController::class, 'dashboard']) // Por ejemplo
    ->middleware(['auth', 'verified'])
    ->name('user.dashboardUser');

Route::get('dashboardUser', [UserDashboardController::class, 'index']) // Por ejemplo
    ->middleware(['auth', 'verified'])
    ->name('user.dashboardUser');

//ruta para el control de reservas de usuario
Route::get('/user/booking', [UserBookingController::class, 'index'])
    ->middleware('auth')
    ->name('user.booking');

Route::post('/user/booking', [UserBookingController::class, 'store'])->name('bookings.store');
Route::delete('/user/booking/{booking}', [UserDashboardController::class, 'destroy'])->name('bookings.destroy');


//ruta para cargar los modelos de vehiculos al reservar
Route::get('/api/models/{brand}', function ($brandId) {
    return \App\Models\VehicleModel::where('brand_id', $brandId)->get();
});

//ruta para llamar la función del controlador del switch
Route::put('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])
    ->name('bookings.updateStatus')
    ->middleware('auth');

//ruta para cargar las publicaciones en el muro
Route::get('/wall/activity', [ActivityController::class, 'wall'])
    ->name('wall.activity');    

//ruta para cargar los servicios en el inicio de la página
Route::get('/', [ServiceController::class, 'showServices'])->name('services');


require __DIR__.'/auth.php';
