<?php

use App\Http\Controllers\InicioControlador;
use App\Http\Controllers\PrincipalControlador;
use App\Http\Controllers\ControladorSolicitud;
use App\Http\Controllers\ControladorReporte;
use App\Http\Controllers\ControladorInforme;
use App\Http\Controllers\ControladorActivo;
use App\Http\Controllers\ControladorPersonal;
use App\Http\Controllers\ControladorSalir;
use App\Http\Controllers\HomeIncidencias;
use App\Http\Controllers\ControladorCategoria;

use Illuminate\Support\Facades\Route;


Route::get('/inicio', [InicioControlador::class,'verinicio'])->name('home');


//rutas incidencias
Route::get('/Incidencia', [HomeIncidencias::class,'Inicio'])->name('Incidencia');
Route::get('/ListaIncidencia', [HomeIncidencias::class,'Ver'])->name('ListaIncidencia');
Route::get('/incidencia/{id}/marcarVistoYVer', [HomeIncidencias::class, 'marcarVistoYVer'])->name('marcarVistoYVer');
Route::post('/registrarincidencia', [HomeIncidencias::class, 'registrarIncidencia'])->name('reg.inci');
// web.php
Route::put('/incidencias/{id}/estado', [HomeIncidencias::class, 'actualizarEstado']);
Route::put('/incidencias/{id}/resolver', [HomeIncidencias::class, 'resolverIncidencia']);
Route::get('/incidencias/{id}', [HomeIncidencias::class, 'obtenerIncidencia']);
// Ruta para marcar como vista una incidencia
Route::get('/ver-incidencia/{id}', [HomeIncidencias::class, 'verIncidencia'])->name('verIncidencia');




//---------//

    
//rutas generales

Route::get('/Principal', [PrincipalControlador::class,'PanelControl'])->name('principal')->middleware('auth:web');

Route::get('/Reporte', [ControladorReporte::class,'Reporte'])->name('reporte')->middleware('auth:web');
Route::post('/reporte/buscar', [ControladorReporte::class, 'Reporte'])->name('reporte.buscar');
Route::get('/reporte/datos', [ControladorReporte::class, 'getDatosReporte'])->name('reporte.datos');







//fichas
//1 administrador, 2 logistica, 3 TI

Route::middleware(['check.tipo:1,3'])->group(function () {
Route::get('/FichaSolicitud', [ControladorSolicitud::class,'FichaSolicitud'])->name('ficha');
Route::post('/FichaSolicitud', [ControladorSolicitud::class,'buscar'])->name('ficha.buscar');
Route::get('/Ficha-Asignacion', [ControladorSolicitud::class,'VenAsignacion'])->name('asignacion');
Route::get('/buscar-persona/{dni}', [ControladorSolicitud::class, 'buscarPersona']);
Route::get('/buscar-activo/{codigo}', [ControladorSolicitud::class, 'buscarActivo']);
Route::post('/registrar-ficha', [ControladorSolicitud::class, 'registrarFicha']);
Route::post('/generar-ficha', [ControladorSolicitud::class, 'generarFicha']);
Route::get('/ficha/descargar/{ficha}', [ControladorSolicitud::class, 'descargarFicha'])->name('ficha.descargar');


});        


//
//informe tecnico

Route::middleware(['check.tipo:1,3'])->group(function () {

Route::get('/Informe', [ControladorInforme::class,'Informe'])->name('informe');
Route::get('/Informe-busqueda', [ControladorInforme::class,'InformeBusqueda'])->name('historial');
Route::get('/Informe-Tecnico', [ControladorInforme::class,'VenCrearFicha'])->name('crearFicha');
Route::post('/Informe-tecnico',[ControladorInforme::class,'buscarFicha'])->name('buscar.p.a.iTecnico');
Route::get('informe/{fichaId}/descargar', [ControladorInforme::class, 'descargarInforme'])->name('informe.descargar');
Route::post('/Informe', [ControladorInforme::class,'busqueda'])->name('busqueda.informe');
Route::post('/cambiarestado',[ControladorInforme::class,'cambiarEstado'])->name('cambiar.estado');
Route::post('/crear-informe', [ControladorInforme::class, 'generarInforme'])->name('generarInforme');
    
        
 });



//------------------///

//rutas de activos

Route::middleware(['check.tipo:1,3'])->group(function () {

    Route::get('/Activo', [ControladorActivo::class,'VenActivo'])->name('activo');
    Route::post('/guardar-activos', [ControladorActivo::class, 'guardarActivos'])->name('guardar.activos');
    Route::get('/lista-de-activos', [ControladorActivo::class,'listaActivo'])->name('lista.activos');
    Route::post('/lista-activos', [ControladorActivo::class,'buscar'])->name('buscar.activos');
    //------CATEGORIA------------///

    Route::get('/lista-categoria', [ControladorCategoria::class,'listaCategoria'])->name('lista.categoria');
    Route::post('/lista-categorias', [ControladorCategoria::class,'buscar'])->name('buscar.categoria');
    Route::post('/categoria/guardar', [ControladorCategoria::class, 'guardarCategoria'])->name('categoria.guardar');
    Route::post('/categoria/actualizar', [ControladorCategoria::class, 'actualizarCategoria'])->name('categoria.actualizar');



  
 });


//<<------->//

//rutas de personal

Route::middleware(['check.tipo:1'])->group(function () {

Route::get('/Personal', [ControladorPersonal::class,'VenPersonal'])->name('personal');
Route::post('/Personal', [ControladorPersonal::class,'buscar'])->name('buscar.personal');
Route::post('/registrarpersonal',[ControladorPersonal::class,'regPersonal'])->name('reg.perso');
Route::post('/personal/actualizar/{id}', [ControladorPersonal::class, 'actualizarPersonal']);
    
});




//login, NO PROTEGER ESTAS RUTAS
Route::get('/IniciarSesion', [ControladorSalir::class,'VenSalir'])->name('salir');

Route::post('/IniciarSesion', [ControladorSalir::class, 'login'])->name('login');
Route::post('/logout', [ControladorSalir::class, 'logout'])->name('logout');




///<<----->////
 