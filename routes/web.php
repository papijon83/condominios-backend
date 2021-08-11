<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->group(['prefix' => 'v1'], function() use ($router){
        $router->group(['prefix' => 'catalogos'], function() use ($router){
            $router->get('GetCatIndiviso', 'CondominioController@getCatIndiviso');
            $router->get('GetCatRangoNivelesUso','CondominioController@getCatRangoNivelesUso');
            $router->get('GetCatRangoNiveles','CondominioController@getCatRangoNiveles');
            $router->get('ObtenerEstadosPorCodApliyActivo','CondominioController@obtenerEstadosPorCodApliyActivo');            
            $router->get('ObtenerUsosMatriz','CondominioController@obtenerUsosMatriz');
            $router->get('ObtenerCategoriasMatriz','CondominioController@obtenerCategoriasMatriz');
            $router->get('ObtenerTiposLocalidad','CondominioController@ObtenerTiposLocalidad');
        });

        $router->group(['prefix' => 'condominios'], function() use ($router){
            $router->get('ObtenerDireccionPorId','CondominioController@obtenerDireccionPorId');
            $router->get('ObtenerDatosDSCondMantRellenosPorIdSolicitud','CondominioController@obtenerDatosDSCondMantRellenosPorIdSolicitud');
            $router->get('ObtenerIdSolicitudPorUnidadPredial','CondominioController@obtenerIdSolicitudPorUnidadPredial');
            $router->get('ObtenerIdSolicitudPorUnidadPredial2','CondominioController@obtenerIdSolicitudPorUnidadPredial2');
            $router->get('ObtenerSolicitudPorFechaEstado','CondominioController@obtenerSolicitudPorFechaEstado');
            $router->get('ObtenerSolicitudPorCuentaPredialEstado','CondominioController@obtenerSolicitudPorCuentaPredialEstado');
            $router->get('ObtenerSolicitudPorFechaCuentaPredial','CondominioController@obtenerSolicitudPorFechaCuentaPredial');
            $router->get('ObtenerSolicitudPorFechaDomicilio','CondominioController@obtenerSolicitudPorFechaDomicilio');
            $router->get('ObtenerPropietarios','CondominioController@obtenerPropietarios');
            $router->get('ObtenerIsPropietarios','CondominioController@obtenerIsPropietarios');
            $router->get('ObtenerSolicitudPorIdSolicitud','CondominioController@obtenerSolicitudPorIdSolicitud');
            $router->get('ObtenerSolicitudesDocPorIdSolicitud','CondominioController@obtenerSolicitudesDocPorIdSolicitud');
            $router->get('ObtenerInstEspecPorIdSolicyIdUnidadCond','CondominioController@obtenerInstEspecPorIdSolicyIdUnidadCond');
            $router->get('ObtenerPropietariosPorIdSolicitud','CondominioController@obtenerPropietariosPorIdSolicitud');
            $router->get('ObtenerPropietariosInmueblePorIdSolicitud','CondominioController@obtenerPropietariosInmueblePorIdSolicitud');
            $router->get('ObtenerPropietariosPorIdUnidadCondominal','CondominioController@obtenerPropietariosPorIdUnidadCondominal');
            $router->get('ObtenerPropietarioPorIdPersona','CondominioController@obtenerPropietarioPorIdPersona');
            $router->get('ObtenerPropietarioFexnotPorIdPersona','CondominioController@obtenerPropietarioFexnotPorIdPersona');
            $router->get('ObtenerCaracteristicasPorIdUnidadCondominal','CondominioController@obtenerCaracteristicasPorIdUnidadCondominal');
            $router->get('ObtenerUnidadCondPorIdSolicitud','CondominioController@obtenerUnidadCondPorIdSolicitud');
            $router->get('ObtenerUnidadCondPorIdUnidadCond','CondominioController@obtenerUnidadCondPorIdUnidadCond');
            $router->get('ObtenerClasePorIdClase','CondominioController@obtenerClasePorIdClase');
            $router->get('ObtenerClasePorValor','CondominioController@obtenerClasePorValor');
            $router->get('ObtenerClasesEjercicioPorRangoIdClaseEjercicio','CondominioController@obtenerClasesEjercicioPorRangoIdClaseEjercicio');
            $router->get('ObtenerDatosCatastrales','CondominioController@obtenerDatosCatastrales');
            $router->get('ObtenerJustificanteCondominios','CondominioController@obtenerJustificanteCondominios');
            $router->get('ObtenerCaract','CondominioController@obtenerCaract');
            $router->get('ObtenerCaracteristicasBase','CondominioController@obtenerCaracteristicasBase');
            $router->get('ObtenerSolicitudMatriz','CondominioController@obtenerSolicitudMatriz');
            $router->get('ObtenerPropietariosNoRCON','CondominioController@obtenerPropietariosNoRCON');

            $router->post('CambiarPersona','CondominioController@cambiarPersona');
            $router->post('CambiarIdPersonaRCON','CondominioController@cambiarIdPersonaRCON');
            $router->post('CambiarProcedenciaPersona','CondominioController@cambiarProcedenciaPersona');
            $router->post('CambiarEstadoSolicitud','CondominioController@cambiarEstadoSolicitud');
            $router->post('CambiarIdExpediente','CondominioController@cambiarIdExpediente');
            $router->post('CambiarUnidadesCondominales','CondominioController@cambiarUnidadesCondominales');
            

        });

    });
});
