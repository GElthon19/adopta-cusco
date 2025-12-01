<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ConexionController;
use App\Http\Controllers\AnimalesController;
use App\Http\Controllers\AdopcionesController;
use App\Http\Controllers\DonacionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SolicitudAdopcionController;
use App\Http\Controllers\SolicitudDonacionAnimalController;
use App\Http\Controllers\SolicitudDonacionEconomicaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContentBlockController;

// Controladores Admin
use App\Http\Controllers\Admin\AdopcionesController as AdminAdopcionesController;
use App\Http\Controllers\Admin\DonacionesAnimalesController;
use App\Http\Controllers\Admin\DonacionesController as AdminDonacionesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (sin autenticación)
|--------------------------------------------------------------------------
*/

// Ruta para forzar logout - TEMPORAL
Route::get('/forzar-logout', function () {
    Auth::logout();
    session()->flush();
    return redirect('/login')->with('message', 'Sesión cerrada forzadamente');
});

// Ruta principal - Landing Page Pública
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta de login - MOSTRAR SIEMPRE EL FORMULARIO
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Ruta de Google login - pública
Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Home real - protegida (SOLO accesible si estás logeado)
    Route::get('/home', [IndexController::class, 'index'])->name('home');

    //Ruta unica de usuario
    Route::get('/usuario', [IndexController::class, 'usuario'])->name('usuario.index');
    Route::get('/usuario/animal/create', [UsuarioController::class, 'createAnimal'])->name('usuario.animal.create');
    Route::post('/usuario/animal', [UsuarioController::class, 'storeAnimal'])->name('usuario.animal.store');

    // Animales adoptados
    Route::get('/animales-adoptados', [\App\Http\Controllers\AnimalesAdoptadosController::class, 'index'])->name('animales-adoptados.index');

    // Otras rutas protegidas
    Route::get('/index', [IndexController::class, 'index'])->name('index.index');
    Route::get('/index/{id}', [IndexController::class, 'show'])->name('index.show');
    Route::get('/conexion', [ConexionController::class, 'index'])->name('conexion.index');
    Route::get('/conexion/{id}', [ConexionController::class, 'show'])->name('conexion.show');

    Route::resource('animales', AnimalesController::class)
        ->parameters(['animales' => 'animal']);     

    Route::resource('adopciones', AdopcionesController::class)
        ->parameters(['adopciones' => 'adopcion']);

    Route::resource('donaciones', DonacionesController::class)
        ->parameters(['donaciones' => 'donacion']);
    
    // Solicitudes de adopción (usuarios)
    Route::get('/solicitudes-adopcion/create', [SolicitudAdopcionController::class, 'create'])->name('solicitudes_adopcion.create');
    Route::post('/solicitudes-adopcion', [SolicitudAdopcionController::class, 'store'])->name('solicitudes_adopcion.store');

    // Solicitudes de donación de animales (usuarios)
    Route::get('/solicitudes-donacion-animal/create', [SolicitudDonacionAnimalController::class, 'create'])->name('solicitudes-donacion-animal.create');
    Route::post('/solicitudes-donacion-animal', [SolicitudDonacionAnimalController::class, 'store'])->name('solicitudes-donacion-animal.store');

    // Solicitudes de donación económica (usuarios)
    Route::get('/solicitudes-donacion-economica/create', [SolicitudDonacionEconomicaController::class, 'create'])->name('solicitudes-donacion-economica.create');
    Route::post('/solicitudes-donacion-economica', [SolicitudDonacionEconomicaController::class, 'store'])->name('solicitudes-donacion-economica.store');

    // Animales adoptados (usuarios)
    Route::get('/animales-adoptados', [\App\Http\Controllers\AnimalesAdoptadosController::class, 'index'])->name('animales-adoptados.index');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR (requieren autenticación + rol admin)
|--------------------------------------------------------------------------
*/

// Notificaciones (fuera del prefijo admin para simplificar las rutas)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/dropdown', [NotificationController::class, 'getDropdownNotifications'])->name('notifications.dropdown');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // ========== GESTIÓN DE CONTENIDO ==========
    Route::resource('content-blocks', ContentBlockController::class);

    // ========== GESTIÓN DE ADOPCIONES ==========
    Route::get('/adopciones', [AdminAdopcionesController::class, 'index'])->name('admin.adopciones.index');
    Route::get('/adopciones/{id}', [AdminAdopcionesController::class, 'show'])->name('admin.adopciones.show');
    
    // Adopción presencial
    Route::get('/adopciones/presencial/create', [AdminAdopcionesController::class, 'createPresencial'])->name('admin.adopciones.presencial.create');
    Route::post('/adopciones/presencial', [AdminAdopcionesController::class, 'storePresencial'])->name('admin.adopciones.presencial.store');
    
    // Aprobar/Rechazar solicitudes online
    Route::post('/adopciones/{id}/aprobar', [AdminAdopcionesController::class, 'aprobar'])->name('admin.adopciones.aprobar');
    Route::post('/adopciones/{id}/rechazar', [AdminAdopcionesController::class, 'rechazar'])->name('admin.adopciones.rechazar');
    
    // Eliminar/Cancelar adopción
    Route::delete('/adopciones/{id}', [AdminAdopcionesController::class, 'destroy'])->name('admin.adopciones.destroy');

    // ========== GESTIÓN DE DONACIONES DE ANIMALES ==========
    Route::get('/donaciones-animales', [DonacionesAnimalesController::class, 'index'])->name('admin.donaciones-animales.index');
    Route::get('/donaciones-animales/{id}', [DonacionesAnimalesController::class, 'show'])->name('admin.donaciones-animales.show');
    
    // Donación presencial de animales
    Route::get('/donaciones-animales/presencial/create', [DonacionesAnimalesController::class, 'createPresencial'])->name('admin.donaciones-animales.presencial.create');
    Route::post('/donaciones-animales/presencial', [DonacionesAnimalesController::class, 'storePresencial'])->name('admin.donaciones-animales.presencial.store');
    
    // Aprobar/Rechazar solicitudes online
    Route::post('/donaciones-animales/{id}/aprobar', [DonacionesAnimalesController::class, 'aprobar'])->name('admin.donaciones-animales.aprobar');
    Route::post('/donaciones-animales/{id}/rechazar', [DonacionesAnimalesController::class, 'rechazar'])->name('admin.donaciones-animales.rechazar');

    // ========== GESTIÓN DE DONACIONES ECONÓMICAS/BIENES ==========
    Route::get('/donaciones', [AdminDonacionesController::class, 'index'])->name('admin.donaciones.index');
    Route::get('/donaciones/{id}', [AdminDonacionesController::class, 'show'])->name('admin.donaciones.show');
    Route::patch('/donaciones/{id}/verificar', [AdminDonacionesController::class, 'verificar'])->name('admin.donaciones.verificar');
    
    // Donación presencial (efectivo o bienes)
    Route::get('/donaciones/presencial/create', [AdminDonacionesController::class, 'createPresencial'])->name('admin.donaciones.presencial.create');
    Route::post('/donaciones/presencial', [AdminDonacionesController::class, 'storePresencial'])->name('admin.donaciones.presencial.store');

    // ========== GESTIÓN DE CAMPAÑAS ==========
    Route::resource('campanas', \App\Http\Controllers\Admin\CampanaController::class);
});
