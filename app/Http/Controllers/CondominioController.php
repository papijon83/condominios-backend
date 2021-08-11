<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Catalogos;
use App\Models\Condominios;
use Carbon\Carbon;
use Exeption;
use Log;

/**
 * El controlador Condominio representa los metodos principales para gestionar el servicio Web de Condominios.
 *
 * @author Jonathan Giovanni Palacios Gómez
 */

 class CondominioController extends Controller
 {
    /**
     * Create a new controller instance.
     *
     * @return void 
     */
   protected $modelCatalogos;
   protected $modelCondominios;

     /**
     * El constructor que inicializa los modelos para consulta a BD
     * 
     * @return void 
     */
    public function __construct()
    {
         $this->modelCatalogos = new Catalogos();
         $this->modelCondominios = new Condominios();          
    }

    /************************************************************GET***********************************************************/
    
    /**
     * Método para obtener un dataset con la información del catalogo de rango niveles
     *    
     * @return json $infoCatalogo contiene los datos del catalogo de indivisos
     */
    public function getCatIndiviso(){
      try{
        $infoCatalogo = $this->modelCatalogos->GetCatIndiviso();
        return response()->json($infoCatalogo,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['mensaje' => '1 Error al obtener la información'], 500);
      }
    }

    /**
     * Método que devuelve el DataTable de la dirección proporcionada
     *
     * @param array $request
     * $params ['idDireccion' => (int) identificador de la direccion]
     *   
     * @return json $infoCatalogo contiene los datos del catalogo de indivisos
     */
    public function obtenerDireccionPorId(Request $request){
      try{
        $idDireccion = $request->query('idDireccion');
        $infoDireccion = $this->modelCondominios->ObtenerDireccionPorId($idDireccion);
        return response()->json($infoDireccion,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['mensaje'=>'2 Error al obtener la información'],500);
      }
    }

    /**
     * Metodo para obtener el catalogo de indivisos
     *
     * @param array $request
     * $params ['idUsoEjercicio' => (int) identificador del usoEjericio]
     *     
     * @return json $infoCatalogo contiene un data set Generico con los campos RANGOSUPERIOR Y DESCRIPCIÓN
     */
    public function getCatRangoNivelesUso(Request $request){
      try{
        $idUsoEjercicio = $request->query('idUsoEjercicio');
        $infoCatalogo = $this->modelCatalogos->GetCatRangoNivelesUso($idUsoEjercicio);
        return response()->json($infoCatalogo,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'3 Error al obtener la información'],500);
      }
    }

    public function getCatRangoNiveles(Request $request){
      try{        
        $infoCatalogo = $this->modelCatalogos->GetCatRangoNiveles();
        return response()->json($infoCatalogo,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'3 Error al obtener la información'],500);
      }
    }

    /**
     * Metodo para obtener el dataset de condominios mantenimiento relleno pasandole el idSolicitud
     *
     * @param array $request
     * $params ['idSolicitud' => (int) identificador de la solicitud]
     *     
     * @return json $infoCondominiosMant contiene un data set con FEXNOT_SOLICITUDES_M, FEXNOT_SOLICITUDESDOC_M, FEXNOT_UNIDADCONDOMINAL_M, FEXNOT_PROPIETARIOSINMUEBLE_M, FEXNOT_PERSONASCOND_M, FEXNOT_DOMICILIO_M, FEXNOT_INSTESPECIALESCUENTA_M, FEXNOT_CARACTUNIDADCOND_M
     */
    public function obtenerDatosDSCondMantRellenosPorIdSolicitud(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');
        $arr = array();
        $arr['FEXNOT_SOLICITUDES_M'] = $this->modelCondominios->Fexnot_solicitudes_m($idSolicitud);
        $arr['FEXNOT_SOLICITUDESDOC_M'] = $this->modelCondominios->Fexnot_solicitudesdoc_m($idSolicitud);
        $arr['FEXNOT_UNIDADCONDOMINAL_M'] = $this->modelCondominios->Fexnot_unidadcondominal_m($idSolicitud);
        $arr['FEXNOT_PROPIETARIOSINMUEBLE_M'] = $this->modelCondominios->Fexnot_propietariosinmueble_m($idSolicitud);
        $arr['FEXNOT_PERSONASCOND_M'] = $this->modelCondominios->Fexnot_personascond_m($idSolicitud);

        $arr['FEXNOT_DOMICILIO_M'] = $this->modelCondominios->ObtenerDireccionPorId($arr['FEXNOT_SOLICITUDES_M'][0]['IDDIRECCION']);
        
        if($arr['FEXNOT_SOLICITUDES_M'][0]['IDDIRECCIONNOTIFICACIONES'] != NULL){          
          $arr['FEXNOT_DOMICILIO_M'][] = $this->modelCondominios->ObtenerDireccionPorId($arr['FEXNOT_SOLICITUDES_M'][0]['IDDIRECCIONNOTIFICACIONES']);
        }

        $arrIdsUnidadCondominal = array();
        foreach($arr['FEXNOT_UNIDADCONDOMINAL_M'] as $unidadCondominal){
          $arrIdsUnidadCondominal[] = $unidadCondominal['IDUNIDADCONDOMINAL'];
        }
        $strIdsUnidadCondominal = $this->arrAstr($arrIdsUnidadCondominal);
        $arr['FEXNOT_INSTESPECIALESCUENTA_M'] = $this->modelCondominios->Fexnot_instespecialescuenta_m($idSolicitud,$strIdsUnidadCondominal);
        $arr['FEXNOT_CARACTUNIDADCOND_M'] = $this->modelCondominios->Fexnot_caractunidadcond_m($strIdsUnidadCondominal);

        return response()->json($arr,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'4 Error al obtener la información'],500);
      }
    }

    /**
     * Metodo para buscar una solicitud por unidad predial
     *
     * @param array $request
     * $params ['region' => (string) identificador de la solicitud,
     *          'manzana' => (string) identificador de la solicitud,
     *          'lote' => (string) identificador de la solicitud,
     *          'unidadPrivativa' => (string) identificador de la solicitud]
     *     
     * @return json $infoSolicitud contiene el numero de solicitudes encontradas o -1 si no encuentra información
     */
    public function obtenerIdSolicitudPorUnidadPredial(Request $request){
      try{
        $region = $request->query('region');
        $manzana = $request->query('manzana');
        $lote = $request->query('lote');
        $unidadPrivativa = $request->query('unidadPrivativa');

        $infoSolicitud = $this->modelCondominios->GetDataByUnidadPredial($region,$manzana,$lote,$unidadPrivativa);
        return response()->json($infoSolicitud,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'5 Error al obtener la información'],500);
      } 
    }

    /**
     * Metodo para buscar una solicitud por unidad predial Regresa el ID de la Solicitud
     *
     * @param array $request
     * $params ['region' => (string) identificador de la solicitud,
     *          'manzana' => (string) identificador de la solicitud,
     *          'lote' => (string) identificador de la solicitud,
     *          'unidadPrivativa' => (string) identificador de la solicitud]
     *     
     * @return json $infoSolicitud contiene el identificador de la unidad privativa
     */
    public function obtenerIdSolicitudPorUnidadPredial2(Request $request){
      try{
        $region = $request->query('region');
        $manzana = $request->query('manzana');
        $lote = $request->query('lote');
        $unidadPrivativa = $request->query('unidadPrivativa');

        $infoSolicitud = $this->modelCondominios->GetDataByUnidadPredial2($region,$manzana,$lote,$unidadPrivativa);
        return response()->json($infoSolicitud,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'6 Error al obtener la información'],500);
      } 
    }

    /**
     * Metodo para realizar una búsqueda por los campos de fecha y estado de una solicitud.
     *
     * @param array $request
     * $params ['fechaInicio' => (string) Fecha de inicio para el rango,
     *          'fechaFin' => (string) Fecha fin para el rango,
     *          'codestado' => (int) Código de estado,
     *          'idPersona' => (int) Identificador de persona,
     *          'pageSize' => (int) Tamaño de la página,
     *          'indice' => (int) Índice de la página,
     *          'rowsTotal' => (int) [in,out]. Número de registros totales,
     *          'codestados' => (string) Códigos de estado,
     *          'SortExpression' => (string) Expresión de ordenación
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudPorFechaEstado(Request $request){
      try{
        $fechaInicio = $request->query('fechaInicio');
        $fechaFin = $request->query('fechaFin');
        $codestado = $request->query('codestado');
        $idPersona = $request->query('idPersona');
        $pageSize = $request->query('pageSize');
        $indice = $request->query('indice');
        $rowsTotal = $request->query('rowsTotal');
        $codestados = $request->query('codestados');
        $sortExpression = $request->query('sortExpression');

        $infoConsulta = $this->modelCondominios->ObtenerSolicitudPorFechaEstado($fechaInicio,$fechaFin,$codestado,$idPersona,$pageSize,$indice,$rowsTotal,$codestados,$sortExpression);
        //echo "<pre>"; print_r($infoConsulta);
        $rowsTotal = 0;
        if(count($infoConsulta) > 0){
          $rowsTotal = count($infoConsulta);
          $infoConsulta[0]['ROWS_TOTAL'] = $rowsTotal;
        }  
        //print_r($infoSolicitud); exit();
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'7 Error al obtener la información'],500);
      }
      
    }

    /**
     * Metodo para realizar una búsqueda por los campos de fecha y estado de una solicitud.
     *
     * @param array $request
     * $params ['region' => (string) Región de la cuenta predial,
     *          'manzana' => (string) Manzana de la cuenta predial,
     *          'lote' => (string) Lote de la cuenta predial,
     *          'unidadprivativa' => (string) Unidad privativa,
     *          'codestado' => (int) Código de estado,
     *          'idPersona' => (int) Identificador de persona,
     *          'pageSize' => (int) Tamaño de la página,
     *          'indice' => (int) Índice de la página,
     *          'rowsTotal' => (int) [in,out]. Número de registros totales,
     *          'codestados' => (string) Códigos de estado,
     *          'SortExpression' => (string) Expresión de ordenación
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudPorCuentaPredialEstado(Request $request){
      try{
        $region = $request->query('region');
        $manzana = $request->query('manzana');
        $lote = $request->query('lote');
        $unidadprivativa = $request->query('unidadprivativa');
        $codestado = $request->query('codestado');
        $idPersona = $request->query('idPersona');
        $pageSize = $request->query('pageSize');
        $indice = $request->query('indice');
        $rowsTotal = $request->query('rowsTotal');
        $codestados = $request->query('codestados');
        $sortExpression = $request->query('sortExpression');

        $infoConsulta = $this->modelCondominios->ObtenerSolicitudPorCuentaPredialEstado($region,$manzana,$lote,$unidadprivativa,$codestado,$idPersona,$pageSize,$indice,$sortExpression,$codestados);
        $rowsTotal = 0;
        if(count($infoConsulta) > 0){
          $rowsTotal = count($infoConsulta);
          $infoConsulta[0]['ROWS_TOTAL'] = $rowsTotal;
        }        
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'8 Error al obtener la información'],500);
      }
    }

    /**
     * Realizamos una búsqueda por los campos de fecha y cuenta predial de una solicitud.
     *
     * @param array $request
     * $params ['fechaInicio' => (string) Fecha de inicio para el rango,
     *          'fechaFin' => (string) Fecha fin para el rango,
     *          'region' => (string) Región de la cuenta predial,
     *          'manzana' => (string) Manzana de la cuenta predial,
     *          'lote' => (string) Lote de la cuenta predial,
     *          'unidadprivativa' => (string) Unidad privativa,
     *          'idPersona' => (int) Identificador de persona,
     *          'pageSize' => (int) Tamaño de página,
     *          'indice' => (int) [in,out]. Índice de la página,
     *          'rowsTotal' => (int) [in,out]. Número de filas totales,
     *          'SortExpression' => (string) Expresión de ordenación
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudPorFechaCuentaPredial(Request $request){
      try{
        $fechaInicio = $request->query('fechaInicio');
        $fechaFin = $request->query('fechaFin');
        $region = $request->query('region');
        $manzana = $request->query('manzana');
        $lote = $request->query('lote');
        $unidadprivativa = $request->query('unidadprivativa');       
        $idPersona = $request->query('idPersona');
        $pageSize = $request->query('pageSize');
        $indice = $request->query('indice');
        $rowsTotal = $request->query('rowsTotal');       
        $sortExpression = $request->query('sortExpression');

        $infoConsulta = $this->modelCondominios->ObtenerSolicitudPorFechaCuentaPredial($fechaInicio,$fechaFin,$region,$manzana,$lote,$unidadprivativa,$idPersona,$pageSize,$indice,$sortExpression);
        $rowsTotal = 0;
        if(count($infoConsulta) > 0){
          $rowsTotal = count($infoConsulta);
          $infoConsulta[0]['ROWS_TOTAL'] = $rowsTotal;
        }        
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'9 Error al obtener la información'],500);
      }
    }

    /**
     * Realizamos una búsqueda por los campos de fecha y domicilio de una solicitud.
     *
     * @param array $request
     * $params ['fechaInicio' => (string) Fecha de inicio para el rango,
     *          'fechaFin' => (string) Fecha fin para el rango,
     *          'via' => (string) Vía,
     *          'delegacion' => (string) Delegación,
     *          'colonia' => (string) Colonia,
     *          'andador' => (string) Andador,
     *          'edificio' => (string) Edificio,
     *          'seccion' => (string) Sección,
     *          'entrada' => (string) Entrada,
     *          'codigoPostal' => (string) Código postal,
     *          'numeroExterior' => (string) Número exterior,
     *          'idPersona' => (int) Identificador de persona,
     *          'pageSize' => (int) Tamaño de página,
     *          'indice' => (int) [in,out]. Índice de la página,
     *          'rowsTotal' => (int) [in,out]. Número de filas totales,
     *          'SortExpression' => (string) Expresión de ordenación
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    //con este no pude lograr obtener informacion
    public function obtenerSolicitudPorFechaDomicilio(Request $request){
      try{
        $fechaInicio = $request->query('fechaInicio');
        $fechaFin = $request->query('fechaFin');
        $via = $request->query('via');
        $delegacion = $request->query('delegacion');
        $colonia = $request->query('colonia');
        $andador = $request->query('andador');
        $edificio = $request->query('edificio');
        $seccion = $request->query('seccion');
        $entrada = $request->query('entrada');
        $codPostal = $request->query('codPostal');
        $numExterior = $request->query('numExterior');
        $idPersona = $request->query('idPersona');
        $pageSize = $request->query('pageSize');
        $indice = $request->query('indice');
        $sortExpression = $request->query('sortExpression');

        $infoConsulta = $this->modelCondominios->ObtenerSolicitudPorFechaDomicilio($fechaInicio,$fechaFin,$via,$delegacion,$colonia,$andador,$edificio,$seccion,$entrada,$codPostal,$numExterior,$idPersona,$pageSize,$indice,$sortExpression);
        $rowsTotal = 0;
        if(count($infoConsulta) > 0){
          $rowsTotal = count($infoConsulta);
          $infoConsulta[0]['ROWS_TOTAL'] = $rowsTotal;
        }        
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'10 Error al obtener la información'],500);
      }
    }

    /**
     * Realizamos una búsqueda por los campos de un propietario
     *
     * @param array $request
     * $params ['nombre' => (string) Nombre,
     *          'apellidoPaterno' => (string) Apellido Paterno,
     *          'apellidoMaterno' => (string) Apellido Materno,
     *          'rfc' => (string) rfc,
     *          'curp' => (string) curp,
     *          'claveIfe' => (string) Clave IFE,         
     *          'pageSize' => (int) Tamaño de página,
     *          'indice' => (int) [in,out]. Índice de la página,
     *          'rowsTotal' => (int) [in,out]. Número de filas totales,
     *          'SortExpression' => (string) Expresión de ordenación
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietarios(Request $request){
      try{
        $nombre = $request->query('nombre');
        $apellidoPaterno = $request->query('apellidoPaterno');
        $apellidoMaterno = $request->query('apellidoMaterno');
        $rfc = $request->query('rfc');
        $curp = $request->query('curp');
        $claveIfe = $request->query('claveIfe');       
        $pageSize = $request->query('pageSize');
        $indice = $request->query('indice');
        $sortExpression = $request->query('sortExpression');

        $infoConsulta = $this->modelCondominios->ObtenerPropietarios($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveIfe,$pageSize,$indice,$sortExpression);
        $rowsTotal = 0;
        if(count($infoConsulta) > 0){
          $rowsTotal = count($infoConsulta);
          $infoConsulta[0]['ROWS_TOTAL'] = $rowsTotal;
        }        
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'11 Error al obtener la información'],500);
      }
    }

    /**
     * Realizamos una búsqueda por los campos de un propietario sin paginación
     *
     * @param array $request
     * $params ['nombre' => (string) Nombre,
     *          'apellidoPaterno' => (string) Apellido Paterno,
     *          'apellidoMaterno' => (string) Apellido Materno,
     *          'rfc' => (string) rfc,
     *          'curp' => (string) curp,
     *          'claveIfe' => (string) Clave IFE,         
     *          'activPrincip' => (int) Actividad principal,
     *          'codTipoPersona' => (int) Codigo de tipo persona
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerIsPropietarios(Request $request){
      try{
        $nombre = $request->query('nombre');
        $apellidoPaterno = $request->query('apellidoPaterno');
        $apellidoMaterno = $request->query('apellidoMaterno');
        $rfc = $request->query('rfc');
        $curp = $request->query('curp');
        $claveIfe = $request->query('claveIfe');       
        $activPrincip = $request->query('activPrincip');
        $codTipoPersona = $request->query('codTipoPersona');
        
        $infoConsulta = $this->modelCondominios->ObtenerIsPropietarios($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveIfe,$activPrincip,$codTipoPersona);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'12 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos un DataTable de Base de datos con los estados correspondientes de una determinada aplicación y vigencia
     *
     * @param array $request
     * $params ['codAplicacion' => (int) Aplicación de la que se quieren tener los estados,
     *          'activo' => (string) Vigencia de los estados. S: Activo
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerEstadosPorCodApliyActivo(Request $request){
      try{
        $codAplicacion = $request->query('codAplicacion');
        $activo = $request->query('activo');
                
        $infoConsulta = $this->modelCatalogos->ObtenerEstadosPorCodApliyActivo($codAplicacion,$activo);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'13 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos una determinada solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudPorIdSolicitud(Request $request){      
      try{
        $idSolicitud = $request->query('idSolicitud');
        $infoConsulta = $this->modelCondominios->Fexnot_solicitudes_m($idSolicitud);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'14 Error al obtener la información'],500);
      }
    }
    
    /**
     * Obtenemos una determinada solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudesDocPorIdSolicitud(Request $request){      
      try{
        $idSolicitud = $request->query('idSolicitud');

        $infoConsulta = $this->modelCondominios->Fexnot_solicitudesdoc_m($idSolicitud);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'15 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos unas determinadas Instalaciones Especiales.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'idUnidalCondominal' => (int) Identificador de la unidad condominal
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerInstEspecPorIdSolicyIdUnidadCond(Request $request){
      
      try{
        $idSolicitud = $request->query('idSolicitud');
        $idUnidalCondominal = $request->query('idUnidadCondominal');

        $infoConsulta = $this->modelCondominios->ObtenerInstEspecPorIdSolicyIdUnidadCond($idSolicitud,$idUnidalCondominal);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'16 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los propietarios del inmueble de una determinada solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietariosPorIdSolicitud(Request $request){
      
      try{
        $idSolicitud = $request->query('idSolicitud');        

        $infoConsulta = $this->modelCondominios->ObtenerPropietariosPorIdSolicitud($idSolicitud);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'17 Error al obtener la información'],500);
      }
    }
   
    /**
     * Obtenemos los propietarios del inmueble de una determinada solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietariosInmueblePorIdSolicitud(Request $request){
      
      try{
        $idSolicitud = $request->query('idSolicitud');        

        $infoConsulta = $this->modelCondominios->ObtenerPropietariosInmueblePorIdSolicitud($idSolicitud);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'18 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los propietarios del inmueble de una determinada solicitud.
     *
     * @param array $request
     * $params ['idUnidadCondominal' => (int) Identificador de la unidad condominal]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietariosPorIdUnidadCondominal(Request $request){
      
      try{
        $idUnidadCondominal = $request->query('idUnidadCondominal');        

        $infoConsulta = $this->modelCondominios->ObtenerPropietariosPorIdUnidadCondominal($idUnidadCondominal);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'19 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los datos de un propietario en particular.
     *
     * @param array $request
     * $params ['idPersona' => (int) Identificador de la persona]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietarioPorIdPersona(Request $request){
      
      try{
        $idPersona = $request->query('idPersona');        

        $infoConsulta = $this->modelCondominios->ObtenerPropietarioPorIdPersona($idPersona);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'20 Error al obtener la información'],500);
      }
    }

     /**
     * Obtenemos los datos de un propietario en particular cogiendo los datos de fexnot.
     *
     * @param array $request
     * $params ['idPersona' => (int) Identificador de la persona]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietarioFexnotPorIdPersona(Request $request){
      
      try{
        $idPersona = $request->query('idPersona');        

        $infoConsulta = $this->modelCondominios->ObtenerPropietarioFexnotPorIdPersona($idPersona);  
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'21 Error al obtener la información'],500);
      }
    }

    /**
     * Listamos todos las características pertenecientes a una unidad condominal en concreto.
     *
     * @param array $request
     * $params ['idUnidadCondominal' => (int) Identificador de la unidad condominal]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerCaracteristicasPorIdUnidadCondominal(Request $request){
      try{
        $idUnidadCondominal = $request->query('idUnidadCondominal');

        $infoConsulta = $this->modelCondominios->ObtenerCaracteristicasPorIdUnidadCondominal($idUnidadCondominal);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'22 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos las Unidades Condominales de una solicitud concreta.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerUnidadCondPorIdSolicitud(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');

        $infoConsulta = $this->modelCondominios->ObtenerUnidadCondPorIdSolicitud($idSolicitud);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'23 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los datos de una Unidad Condominal concreta.
     *
     * @param array $request
     * $params ['idUnidadCondominal' => (int) Identificador de la unidad condominal]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerUnidadCondPorIdUnidadCond(Request $request){
      try{
        $idUnidadCondominal = $request->query('idUnidadCondominal');

        $infoConsulta = $this->modelCondominios->ObtenerUnidadCondPorIdUnidadCond($idUnidadCondominal);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'24 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos la clase en función del IDClase.
     *
     * @param array $request
     * $params ['idClase' => (int) Identificador de clase]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerClasePorIdClase(Request $request){
      try{
        $idClase = $request->query('idClase');

        $infoConsulta = $this->modelCondominios->ObtenerClasePorIdClase($idClase);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'25 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos la clase en la que un determinado valor queda contenido dentro del rango de la clase.
     *
     * @param array $request
     * $params ['valor' => (int) Valor que debe estar entre el valor minimo y maximo de la clase,
     *          'codTipoMatriz' => (int) Codigo del Tipo de Matriz]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerClasePorValor(Request $request){
      try{
        $valor = $request->query('valor');
        $codTipoMatriz = $request->query('codTipoMatriz');

        $infoConsulta = $this->modelCondominios->ObtenerClasePorValor($valor,$codTipoMatriz);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'26 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos la clase en la que un determinado valor queda contenido dentro del rango de la clase.
     *
     * @param array $request
     * $params ['idInicial' => (int) Identificador inicial,
     *          'idFinal' => (int) Identificador final]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerClasesEjercicioPorRangoIdClaseEjercicio(Request $request){
      try{
        $idInicial = $request->query('idInicial');
        $idFinal = $request->query('idFinal');

        $infoConsulta = $this->modelCondominios->ObtenerClasesEjercicioPorRangoIdClaseEjercicio($idInicial,$idFinal);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'27 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los datos catastrales de las unidades condominales de una solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerDatosCatastrales(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');  

        $infoConsulta = $this->modelCondominios->ObtenerDatosCatastrales($idSolicitud);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'28 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los datos del justificante de condominios.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerJustificanteCondominios(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');  

        $infoConsulta = $this->modelCondominios->ObtenerJustificanteCondominios($idSolicitud);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'29 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos los usos matriz.
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerUsosMatriz(Request $request){
      try{  

        $infoConsulta = $this->modelCatalogos->ObtenerUsosMatriz();
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'30 Error al obtener la información'],500);
      }
    }

    /**
     * Obtenemos las categorias por matriz.
     *
     * @param array $request
     * $params ['codmatriz' => (int) Código matriz
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerCategoriasMatriz(Request $request){
      
      try{
        $codmatriz = $request->query('codmatriz');  

        $infoConsulta = $this->modelCondominios->ObtenerCategoriasMatriz($codmatriz);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'31 Error al obtener la información'],500);
      }
    }

    /**
     * Obtiene las caracteristicas por matriz y categoría.
     *
     * @param array $request
     * $params ['codMatriz' => (int) Código matriz,
     *          'codCategoria' => (int) Código categoría]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerCaract(Request $request){
      try{
        $codMatriz = $request->query('codMatriz');
        $codCategoria = $request->query('codCategoria');

        $infoConsulta = $this->modelCondominios->ObtenerCaract($codMatriz,$codCategoria);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'32 Error al obtener la información'],500);
      }
    }

    /**
     * Obtiene los tipos de localidad existentes.
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerTiposLocalidad(Request $request){
      try{
        
        $infoConsulta = $this->modelCatalogos->ObtenerTiposLocalidad();
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'33 Error al obtener la información'],500);
      }
    }

    /**
     * Obtiene las caracteristicas base por solicitud y matriz.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'codmatriz' => (int) Código de la matriz]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function ObtenerCaracteristicasBase(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');
        $codmatriz = $request->query('codmatriz');
        $infoConsulta = $this->modelCondominios->ObtenerCaracteristicasBase($idSolicitud,$codmatriz);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Obtiene la solicitudMatriz de una solicitud.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerSolicitudMatriz(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');        
        $infoConsulta = $this->modelCondominios->ObtenerSolicitudMatriz($idSolicitud);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'35 Error al obtener la información'],500);
      }
    }

    /**
     * Método que devuelve todos los propietarios de inmuebles que no son de RCON.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function obtenerPropietariosNoRCON(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');        
        $infoConsulta = $this->modelCondominios->ObtenerPropietariosNoRCON($idSolicitud);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'36 Error al obtener la información'],500);
      }
    }

    /**********************************************************UPDATE*****************************************************/

     /**
     * Método que actualiza una persona.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'idPersonaRCON' => (int) Identificador de persona de RCON,
     *          'codTipoPersona' => (int) Código de tipo de persona,
     *          'codSituacionPersona' => (int) Código de situación de persona,
     *          'nombre' => (string) Nombre,
     *          'apellidoPaterno' => (string) Apellido paterno,
     *          'apellidoMaterno' => (string) Apellido materno,
     *          'rfc' => (string) rfc,
     *          'curp' => (string) curp,
     *          'claveife' => (string) Clave ife,
     *          'actPrin' => (string) Actividad principal
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarPersona(Request $request){
      try{
        $idPersona = $request->query('idPersona');
        $idPersonaRCON = $request->query('idPersonaRCON');
        $codTipoPersona = $request->query('codTipoPersona');
        $codSituacionPersona = $request->query('codSituacionPersona');
        $nombre = $request->query('nombre');
        $apellidoPaterno = $request->query('apellidoPaterno');
        $apellidoMaterno = $request->query('apellidoMaterno');
        $rfc = $request->query('rfc');
        $curp = $request->query('curp');
        $claveife = $request->query('claveife');
        $actPrin = $request->query('actPrin');
        
        $infoConsulta = $this->modelCondominios->cambiarPersona($idPersona,$idPersonaRCON,$codTipoPersona,$codSituacionPersona,$nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveife,$actPrin);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Método que actualiza una persona.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'idPersonaRCON' => (int) Identificador de persona de RCON
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarIdPersonaRCON(Request $request){
      try{
        $idPersona = $request->query('idPersona');
        $idPersonaRCON = $request->query('idPersonaRCON');
          
        $infoConsulta = $this->modelCondominios->CambiarIdPersonaRCON($idPersona,$idPersonaRCON);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Cambia la procedencia de la persona en la tabla de propietarios inmueble.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'esNueva' => (string) Valor para el campo esNueva,
     *          'esRconModificada' => (string) Valor para el campo esRconModificada
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarProcedenciaPersona(Request $request){
      try{
        $idPersona = $request->query('idPersona');
        $esNueva = $request->query('esNueva');
        $esRconModificada = $request->query('esRconModificada');
          
        $infoConsulta = $this->modelCondominios->CambiarProcedenciaPersona($idPersona,$esNueva,$esRconModificada);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Cambia el estado de la solicitud seleccionada.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'codEstado' => (int) Código de estado
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarEstadoSolicitud(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');
        $codEstado = $request->query('codEstado');
            
        $infoConsulta = $this->modelCondominios->CambiarEstadoSolicitud($idSolicitud,$codEstado);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Cambia el ID Expediente de la solicitud seleccionada.
     *
     * @param array $request
     * $params ['idSolicitud' => (int) Identificador de la solicitud,
     *          'idExpediente' => (int) Identificador de expediente
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarIdExpediente(Request $request){
      try{
        $idSolicitud = $request->query('idSolicitud');
        $idExpediente = $request->query('idExpediente');
            
        $infoConsulta = $this->modelCondominios->CambiarIdExpediente($idSolicitud,$idExpediente);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

    /**
     * Actualiza las unidades condominales.
     *
     * @param array $request
     * $params ['idUnidadCondominal' => (int) Identificador único para implementación física de la BD. PK de la tabla,
     *          'idSolicitud' => (int) Identificador de la solicitud. FK a la tabla Solicitudes,
     *          'nombreEdificio' => (string) Nombre edificio,
     *          'numeroInterior' => (string) Número interior,
     *          'porcentajeIndiviso' => (int) Porcentaje de indiviso,
     *          'supConstAreaPrivativa' => (int) Superficie construcción área privativa,
     *          'supConstAreaComun' => (int) Superficie construcción área común,
     *          'calificacion' => (int) Resultado basado en la selección realizada en la matriz de clases,
     *          'valorUnitarioSuelo' => (int) Valor unitario de suelo,
     *          'valorUnitarioConstruccion' => (int) Valor unitario de construcción,
     *          'valorSuelo' => (int) Valor de suelo,
     *          'valorConstruccion' => (int) Valor de construcción,
     *          'valorCatastral' => (int) Valor catastral,
     *          'impuesto' => (int) Impuesto,
     *          'idClase' => (int) Identifica la clase. FK a la tabla Clases,
     *          'region' => (string) Región de la cuenta,
     *          'manzana' => (string) Manzana de la cuenta,
     *          'lote' => (string) Lote de la cuenta,
     *          'unidadPrivativa' => (string) Unidad de la cuenta,
     *          'idUsosMatriz' => (int) Identifica el uso-matrizFK a la tabla UsosMatriz,
     *          'supTerreno' => (int) LA CANTIDAD DE SUELO QUE TIENE EL PREDIAL,
     *          'andador' => (string) Andador,
     *          'seccion' => (string) Sección,
     *          'entrada' => (string) Entrada,
     *          'numNiveles' => (int) Número de niveles,
     *          'esRangoUnico' => (string) Indica si es rango único,
     *          'codTiposLocalidad' => (string) Identifica el tipo de localidad. FK a la tabla CatTiposLocalidad,
     *          'idGiros' => (int) Identificador del giro. FK a la tabla CatGiros,
     *          'digitoVerificador' => (string) Dígito verificador,
     *          'codTiposUnidades' => (int) CÓDIGO PARA LA TIPIFICACIÓN DE UNIDADES SEGÚN EL TIPO DE CONDOMINIO
     * ]
     *     
     * @return json $infoConsulta contiene la informacion resultado de la consulta 
     */
    public function cambiarUnidadesCondominales(Request $request){
      try{
        $arr = array(
        'PAR_IDUNIDADCONDOMINAL' => $request->query('idUnidadCondominal'),
        'PAR_IDSOLICITUD' => $request->query('idSolicitud'),
        'PAR_NOMBREEDIFICIO' => $request->query('nombreEdificio'),
        'PAR_NUMEROINTERIOR' => $request->query('numeroInterior'),
        'PAR_PORCENTAJEINDIVISO' => $request->query('porcentajeIndiviso'),
        'PAR_SUPCONSTAREAPRIVATIVA' => $request->query('supConstAreaPrivativa'),
        'PAR_SUPCONSTAREACOMUN' => $request->query('supConstAreaComun'),
        'PAR_CALIFICACION' => $request->query('calificacion'),
        'PAR_VALORUNITARIOSUELO' => $request->query('valorUnitarioSuelo'),
        'PAR_VALORUNITARIOCONSTRUCCION' => $request->query('valorUnitarioConstruccion'),
        'PAR_VALORSUELO' => $request->query('valorSuelo'),
        'PAR_VALORCONSTRUCCION' => $request->query('valorConstruccion'),
        'PAR_VALORCATASTRAL' => $request->query('valorCatastral'),
        'PAR_IMPUESTO' => $request->query('impuesto'),
        'PAR_IDCLASE' => $request->query('idClase'),
        'PAR_REGION' => $request->query('region'),
        'PAR_MANZANA' => $request->query('manzana'),
        'PAR_LOTE' => $request->query('lote'),
        'PAR_UNIDADPRIVATIVA' => $request->query('unidadPrivativa'),
        'PAR_IDUSOSMATRIZ' => $request->query('idUsosMatriz'),
        'PAR_SUPTERRENO' => $request->query('supTerreno'),
        'PAR_ANDADOR' => $request->query('andador'),
        'PAR_SECCION' => $request->query('seccion'),
        'PAR_ENTRADA' => $request->query('entrada'),
        'PAR_NUMNIVELES' => $request->query('numNiveles'),
        'PAR_ESRANGOUNICO' => $request->query('esRangoUnico'),
        'PAR_CODTIPOSLOCALIDAD' => $request->query('codTiposLocalidad'),
        'PAR_IDGIROS' => $request->query('idGiros'),
        'PAR_DIGITOVERIFICADOR' => $request->query('digitoVerificador'),                       
        'PAR_CODTIPOSUNIDADES' => $request->query('codTiposUnidades')
        );          

        $infoConsulta = $this->modelCondominios->CambiarUnidadesCondominales($arr);
               
        return response()->json($infoConsulta,200);
      }catch (\Throwable $th){
        Log::info($th);
        error_log($th);
        return response()->json(['Error'=>'34 Error al obtener la información'],500);
      }
    }

     /**********************************************************INSERT*****************************************************/

     public function GuardarDatosDSCondMantenimiento(Request $request){
        try{
          $dseCondMantenimiento = $request->query('dseCondMantenimiento');
          $xmlDoc = $request->query('xmlDoc');
          $tipoDocumentoDigital = $request->query('tipoDocumentoDigital');
          $listaFicheros = $request->query('listaFicheros');
          $xmlDocPlano = $request->query('xmlDocPlano');
          $tipoDocumentoDigitalPlano = $request->query('tipoDocumentoDigitalPlano');
          $listaFicherosPlano = $request->query('listaFicherosPlano');
          $magno = $request->query('magno');
          $datosMagno = $request->query('datosMagno');
          $superficies = $request->query('superficies');
          $indivisos = $request->query('indivisos');
          
              
          $infoConsulta = $this->modelCondominios->CambiarIdExpediente($idSolicitud,$idExpediente);
                
          return response()->json($infoConsulta,200);
        }catch (\Throwable $th){
          Log::info($th);
          error_log($th);
          return response()->json(['Error'=>'34 Error al obtener la información'],500);
        }
     }

    public function arrAstr($arr){
      $str = '';
      foreach($arr as $elemento){
        $str .= $elemento.",";
      }
      $str = substr($str,0,strlen($str)-1);
      return $str;
    }
 }