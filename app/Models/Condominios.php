<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exeption;
use Log;

class Condominios {

    public function ObtenerDireccionPorId($idDireccion){
        $cursor = null;
        $procedure = 'BEGIN 
        FEXNOT.FEXNOT_DOMICILIO_PKG.fexnot_select_rcondirecbyid_p(
            :PAR_IDDIRECCION,
            :C_DOMICILIORCON);
        END;';
        
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDDIRECCION',$idDireccion,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_DOMICILIORCON',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrDireccion,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrDireccion;
    }

    public function Fexnot_solicitudes_m($idSolicitud){
        $cursor = null;        
        $procedure = 'BEGIN 
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_SELECT_SOLICITUDBYID_P(
            :PAR_IDSOLICITUD,
            :C_SOLICITUDES);
        END;';

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_SOLICITUDES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrSolicitudesM,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrSolicitudesM;
    }

    public function Fexnot_solicitudesdoc_m($idSolicitud){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDESDOC_PKG.FEXNOT_SEL_SOLDOCBYIDSOL_P(
            :PAR_IDSOLICITUD,
            :C_SOLICITUDDOC
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_SOLICITUDDOC',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrSolicitudesDocM,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrSolicitudesDocM;
    }

    public function Fexnot_unidadcondominal_m($idSolicitud){        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_UNIDADCONDOMINAL_PKG.FEXNOT_SELECT_UNIDCBYIDSOL_P(
            :PAR_IDSOLICITUD,
            :C_UNIDADCONDOMINAL
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_UNIDADCONDOMINAL',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrSolicitudesDocM,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrSolicitudesDocM;
    }

    public function Fexnot_propietariosinmueble_m($idSolicitud){        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PROPIETARIOSINMUE_PKG.FEXNOT_SELECT_PROPINMBYIDSOL_P(
            :PAR_IDSOLICITUD,
            :C_PROPIETARINMUE
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_PROPIETARINMUE',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrPropietariosInm,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrPropietariosInm;
    }

    public function Fexnot_personascond_m($idSolicitud){        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCONBYIDSOL_P(
            :PAR_IDSOLICITUD,
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrPersonasCond,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrPersonasCond;
    }

    public function Fexnot_domicilio_m($idDireccion){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCONBYIDSOL_P(
            :PAR_IDSOLICITUD,
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idDireccion,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrPersonasCond,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrPersonasCond;
    }

    public function Fexnot_instespecialescuenta_m($idSolicitud,$ids){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_INSTESPCUENTA_PKG.FEXNOT_SELECT_INTBYSOLYUNIDS_P(
            :PAR_IDSOLICITUD,
            :PAR_IDSUNIDADCONDOMINAL,
            :C_INSTESPECIALESCUENTA
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAR_IDSUNIDADCONDOMINAL',$ids,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_INSTESPECIALESCUENTA',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInstEspeciales,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrInstEspeciales;
    }

    public function Fexnot_caractunidadcond_m($ids){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_CARACTUNIDADCOND_PKG.FEXNOT_SEL_CARUNDCONBYIDUCON_P(           
            :PAR_IDSUNIDADCONDOMINAL,
            :C_CARACTUNIDADCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_IDSUNIDADCONDOMINAL',$ids,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_CARACTUNIDADCOND',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrUnidadCond,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrUnidadCond;
    }

    public function GetDataByUnidadPredial($region,$manzana,$lote,$unidadPrivativa){
        
        $idSolicitud = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_IDSOLBYUNIDADPREDIA_P(           
            :PAR_REGION,
            :PAR_MANZANA,
            :PAR_LOTE,
            :PAR_UNIDADPRIVATIVA,
            :P_IDSOLICITUD
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_REGION',$region,\PDO::PARAM_STR,3);
        $stmt->bindParam(':PAR_MANZANA',$manzana,\PDO::PARAM_STR,3);
        $stmt->bindParam(':PAR_LOTE',$lote,\PDO::PARAM_STR,2);
        $stmt->bindParam(':PAR_UNIDADPRIVATIVA',$unidadPrivativa,\PDO::PARAM_STR,3);
        $stmt->bindParam(':P_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT);
        $stmt->execute();
        
        return $idSolicitud;
    }

    public function GetDataByUnidadPredial2($region,$manzana,$lote,$unidadPrivativa){
        
        $idSolicitud = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_IDSOLBYUNIDADPREDIA_P2
        (           
            :PAR_REGION,
            :PAR_MANZANA,
            :PAR_LOTE,
            :PAR_UNIDADPRIVATIVA,
            :P_IDSOLICITUD
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_REGION',$region,\PDO::PARAM_STR,3);
        $stmt->bindParam(':PAR_MANZANA',$manzana,\PDO::PARAM_STR,3);
        $stmt->bindParam(':PAR_LOTE',$lote,\PDO::PARAM_STR,2);
        $stmt->bindParam(':PAR_UNIDADPRIVATIVA',$unidadPrivativa,\PDO::PARAM_STR,3);
        $stmt->bindParam(':P_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT);
        $stmt->execute();
        
        return $idSolicitud;
    }

    public function ObtenerSolicitudPorFechaEstado($fechaInicio,$fechaFin,$codestado,$idPersona,$pageSize,$indice,$rowsTotal,$codestados,$sortExpression){
        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_SEL_V_FECHAESTADOS_P
        (           
            to_date(:PAR_FECHAINICIAL,\'YYYY-MM-DD\'),
            to_date(:PAR_FECHAFINAL,\'YYYY-MM-DD\'),
            :PAR_CODESTADO,
            :PAR_IDPERSONA,
            :PAGE_SIZE,
            :PAGE,
            :SORTEXPRESSION,
            :CODESTADOS,
            :C_SOLICITUDES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_FECHAINICIAL',$fechaInicio,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_FECHAFINAL',$fechaFin,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CODESTADO',$codestado,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE_SIZE',$pageSize,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE',$indice,\PDO::PARAM_INT,3);
        $stmt->bindParam(':SORTEXPRESSION',$sortExpression,\PDO::PARAM_STR,50);
        $stmt->bindParam(':CODESTADOS',$codestados,\PDO::PARAM_STR,200);
        $stmt->bindParam(':C_SOLICITUDES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerSolicitudPorCuentaPredialEstado($region,$manzana,$lote,$unidadprivativa,$codestado,$idPersona,$pageSize,$indice,$sortExpression,$codestados){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_SEL_V_CUENTPREDESTAD_P
        (           
            :PAR_REGION,
            :PAR_MANZANA,
            :PAR_LOTE,
            :PAR_UNIDADPRIVATIVA,
            :PAR_CODESTADO,
            :PAR_IDPERSONA,
            :PAGE_SIZE,
            :PAGE,
            :SORTEXPRESSION,
            :CODESTADOS,
            :C_SOLICITUDES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_REGION',$region,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_MANZANA',$manzana,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_LOTE',$lote,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_UNIDADPRIVATIVA',$unidadprivativa,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CODESTADO',$codestado,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE_SIZE',$pageSize,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE',$indice,\PDO::PARAM_INT,3);
        $stmt->bindParam(':SORTEXPRESSION',$sortExpression,\PDO::PARAM_STR,50);
        $stmt->bindParam(':CODESTADOS',$codestados,\PDO::PARAM_STR,200);
        $stmt->bindParam(':C_SOLICITUDES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerSolicitudPorFechaCuentaPredial($fechaInicio,$fechaFin,$region,$manzana,$lote,$unidadprivativa,$idPersona,$pageSize,$indice,$sortExpression){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_SEL_V_FECHCUENTPRED_P
        (   
            to_date(:PAR_FECHAINICIAL,\'YYYY-MM-DD\'),
            to_date(:PAR_FECHAFINAL,\'YYYY-MM-DD\'),     
            :PAR_REGION,
            :PAR_MANZANA,
            :PAR_LOTE,
            :PAR_UNIDADPRIVATIVA,           
            :PAR_IDPERSONA,
            :PAGE_SIZE,
            :PAGE,
            :SORTEXPRESSION,       
            :C_SOLICITUDES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_FECHAINICIAL',$fechaInicio,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_FECHAFINAL',$fechaFin,\PDO::PARAM_STR,10);   
        $stmt->bindParam(':PAR_REGION',$region,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_MANZANA',$manzana,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_LOTE',$lote,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_UNIDADPRIVATIVA',$unidadprivativa,\PDO::PARAM_STR,10);       
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE_SIZE',$pageSize,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE',$indice,\PDO::PARAM_INT,3);
        $stmt->bindParam(':SORTEXPRESSION',$sortExpression,\PDO::PARAM_STR,50);        
        $stmt->bindParam(':C_SOLICITUDES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    
    public function ObtenerSolicitudPorFechaDomicilio($fechaInicio,$fechaFin,$via,$delegacion,$colonia,$andador,$edificio,$seccion,$entrada,$codPostal,$numExterior,$idPersona,$pageSize,$indice,$sortExpression){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_SEL_V_FECHDOMICILIO_P
        (   
            to_date(:PAR_FECHAINICIAL,\'YYYY-MM-DD\'),
            to_date(:PAR_FECHAFINAL,\'YYYY-MM-DD\'),
            :PAR_VIA,
            :PAR_DELEGACION,
            :PAR_COLONIA,
            :PAR_ANDADOR,
            :PAR_EDIFICIO,
            :PAR_SECCION,
            :PAR_ENTRADA,
            :PAR_CODIGOPOSTAL,
            :PAR_NUMEROEXTERIOR,
            :PAR_IDPERSONA,            
            :PAGE_SIZE,
            :PAGE,
            :SORTEXPRESSION,       
            :C_SOLICITUDES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_FECHAINICIAL',$fechaInicio,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_FECHAFINAL',$fechaFin,\PDO::PARAM_STR,10);   
        $stmt->bindParam(':PAR_VIA',$via,\PDO::PARAM_STR,100);
        $stmt->bindParam(':PAR_DELEGACION',$delegacion,\PDO::PARAM_STR,50);
        $stmt->bindParam(':PAR_COLONIA',$colonia,\PDO::PARAM_STR,50);
        $stmt->bindParam(':PAR_ANDADOR',$andador,\PDO::PARAM_STR,30);       
        $stmt->bindParam(':PAR_EDIFICIO',$edificio,\PDO::PARAM_STR,30);
        $stmt->bindParam(':PAR_SECCION',$seccion,\PDO::PARAM_STR,100);
        $stmt->bindParam(':PAR_ENTRADA',$entrada,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CODIGOPOSTAL',$codPostal,\PDO::PARAM_STR,5);
        $stmt->bindParam(':PAR_NUMEROEXTERIOR',$numExterior,\PDO::PARAM_STR,25);
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,15);
        $stmt->bindParam(':PAGE_SIZE',$pageSize,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE',$indice,\PDO::PARAM_INT,3);
        $stmt->bindParam(':SORTEXPRESSION',$sortExpression,\PDO::PARAM_STR,50);        
        $stmt->bindParam(':C_SOLICITUDES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    
    public function ObtenerPropietarios($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveIfe,$pageSize,$indice,$sortExpression){    
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_BUS_V_PERSONCOND_P
        (
            :PAR_NOMBRE,
            :PAR_APELLIDOPATERNO,     
            :PAR_APELLIDOMATERNO,
            :PAR_RFC,
            :PAR_CURP,
            :PAR_CLAVEIFE,
            :PAGE_SIZE,
            :PAGE,
            :SORTEXPRESSION,       
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_NOMBRE',$nombre,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_APELLIDOPATERNO',$apellidoPaterno,\PDO::PARAM_STR,10);   
        $stmt->bindParam(':PAR_APELLIDOMATERNO',$apellidoMaterno,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_RFC',$rfc,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CURP',$curp,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CLAVEIFE',$claveIfe,\PDO::PARAM_STR,10);        
        $stmt->bindParam(':PAGE_SIZE',$pageSize,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAGE',$indice,\PDO::PARAM_INT,3);
        $stmt->bindParam(':SORTEXPRESSION',$sortExpression,\PDO::PARAM_STR,50);        
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerIsPropietarios($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveIfe,$activPrincip,$codTipoPersona){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_ISPERSONCOND_P
        (
            :PAR_NOMBRE,
            :PAR_APELLIDOPATERNO,     
            :PAR_APELLIDOMATERNO,
            :PAR_RFC,
            :PAR_CURP,
            :PAR_CLAVEIFE,
            :PAR_ACTIVPRINCIP,
            :PAR_CODTIPOPERSONA,            
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_NOMBRE',$nombre,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_APELLIDOPATERNO',$apellidoPaterno,\PDO::PARAM_STR,10);   
        $stmt->bindParam(':PAR_APELLIDOMATERNO',$apellidoMaterno,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_RFC',$rfc,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CURP',$curp,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CLAVEIFE',$claveIfe,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_ACTIVPRINCIP',$activPrincip);
        $stmt->bindParam(':PAR_CODTIPOPERSONA',$activPrincip);
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;        
    }

    public function ObtenerInstEspecPorIdSolicyIdUnidadCond($idSolicitud,$idUnidalCondominal){
        
        if(trim($idSolicitud) == ''){
            $idSolicitud = 'NULL';
        }else{
            $idSolicitud = (int) $idSolicitud;
        }

        if(trim($idUnidalCondominal) == ''){
            $idUnidalCondominal = 'NULL';
        }else{
            $idUnidalCondominal = (int) $idUnidalCondominal;
        }
        
        /*$cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_INSTESPCUENTA_PKG.FEXNOT_SELECT_INSTBYSOLYUNID_P
        (
            :PAR_IDSOLICITUD,
            :PAR_IDUNIDADCONDOMINAL,                   
            :C_INSTESPECIALESCUENTA
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
        $stmt->bindParam(':PAR_IDUNIDADCONDOMINAL',$idUnidalCondominal,\PDO::PARAM_INT,10);           
        $stmt->bindParam(':C_INSTESPECIALESCUENTA',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);*/

        $queryEjecutar = "SELECT f.idinstespecialescuenta,
        f.codinstespeciales,
        f.idsolicitud,
        f.idunidadcondominal,
        f.codtipoinstespeciales,
        f.descripcion,
        f.activo
 FROM   fexnot.fexnot_instesp_v f
 WHERE  ((($idSolicitud IS NOT NULL) AND
        f.idsolicitud = $idSolicitud) OR $idSolicitud IS NULL) AND
        ((($idUnidalCondominal IS NOT NULL) AND
        f.idunidadcondominal = $idUnidalCondominal) OR
        $idUnidalCondominal IS NULL)"; 

        $info = DB::select($queryEjecutar);
        $arrInfoSolicitudes = json_decode(json_encode($info),true);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietariosPorIdSolicitud($idSolicitud){
        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCONBYIDSOL_P
        (
            :PAR_IDSOLICITUD,              
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietariosInmueblePorIdSolicitud($idSolicitud){
        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PROPIETARIOSINMUE_PKG.FEXNOT_SELECT_PROPINMBYIDSOL_P
        (
            :PAR_IDSOLICITUD,              
            :C_PROPIETARINMUE
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PROPIETARINMUE',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietariosPorIdUnidadCondominal($idUnidadCondominal){
        
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCONBYIDUNIC_P
        (
            :PAR_IDUNIDADCONDOMINAL,              
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDUNIDADCONDOMINAL',$idUnidadCondominal,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietarioPorIdPersona($idPersona){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCONBYID_P
        (
            :PAR_IDPERSONA,              
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietarioFexnotPorIdPersona($idPersona){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_SEL_V_PERSCBYIDPFEX_P
        (
            :PAR_IDPERSONA,              
            :C_PERSONASCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PERSONASCOND',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerCaracteristicasPorIdUnidadCondominal($idUnidadCondominal){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CARACTERISTICAS_PKG.FEXNOT_SEL_CARACTERBYIDUCOND_P
        (
            :PAR_IDUNIDADCONDOMINAL,              
            :C_CARACTERISTICAS
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDUNIDADCONDOMINAL',$idUnidadCondominal,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_CARACTERISTICAS',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerUnidadCondPorIdSolicitud($idSolicitud){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_UNIDADCONDOMINAL_PKG.FEXNOT_SELECT_UNIDCBYIDSOL_P
        (
            :PAR_IDSOLICITUD,              
            :C_UNIDADCONDOMINAL
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_UNIDADCONDOMINAL',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerUnidadCondPorIdUnidadCond($idUnidadCondominal){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_UNIDADCONDOMINAL_PKG.FEXNOT_SELECT_UNIDCONDOMBYID_P
        (
            :PAR_IDUNIDADCONDOMINAL,              
            :C_UNIDADCONDOMINAL
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDUNIDADCONDOMINAL',$idUnidadCondominal,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_UNIDADCONDOMINAL',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerClasePorIdClase($idClase){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CLASES_PKG.FEXNOT_SELECT_CLASESBYID_P
        (
            :PAR_IDCLASE,              
            :C_CLASES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDCLASE',$idClase,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_CLASES',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerClasePorValor($valor,$codTipoMatriz){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CLASES_PKG.FEXNOT_SELECT_CLASESBYVALOR_P
        (
            :PAR_VALOR,
            :PAR_CODTIPOSMATRIZ,
            :C_CLASES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_VALOR',$valor,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CODTIPOSMATRIZ',$codTipoMatriz,\PDO::PARAM_STR,10);  
        $stmt->bindParam(':C_CLASES',$cursor,\PDO::PARAM_STMT);     
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;  
    } 
   
    public function ObtenerClasesEjercicioPorRangoIdClaseEjercicio($idInicial,$idFinal){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CLASES_PKG.FEXNOT_SELECT_CLASESBYEJ_P
        (
            :PAR_INICIO,
            :PAR_FIN,
            :C_CLASES
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_INICIO',$idInicial,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_FIN',$idFinal,\PDO::PARAM_STR,10);  
        $stmt->bindParam(':C_CLASES',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes; 
    }

    public function ObtenerDatosCatastrales($idSolicitud){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_DATOSCATASTRALES_PKG.FEXNOT_SELECT_DATOSCATBYID_P
        (
            :PAR_IDSOLICITUD,       
            :C_DATOSCATASTRALES_CURSOR
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_DATOSCATASTRALES_CURSOR',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes; 
    }

    public function ObtenerJustificanteCondominios($idSolicitud){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_INFORMES_PKG.FEXNOT_INF_CONS_JUSTCOND_P
        (
            :PAR_IDSOLICITUD,       
            :C_DATOSCATASTRALES_CURSOR
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_DATOSCATASTRALES_CURSOR',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }
    
    public function ObtenerCategoriasMatriz($codmatriz){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_MATRICES_V_PKG.FEXNOT_SEL_CATEGORIASMATRIZ_P
        (
            :PAR_CODTIPOSMATRIZ,       
            :¿C_MATRIZ
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_CODTIPOSMATRIZ',$codmatriz,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_MATRIZ',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }
   
    public function ObtenerCaract($codMatriz,$codCategoria){
        
        if(trim($codMatriz) == ''){
            $codMatriz = 'NULL';
        }else{
            $codMatriz = (int) $codMatriz;
        }

        if(trim($codCategoria) == ''){
            $codCategoria = 'NULL';
        }else{
            $codCategoria = (int) $codCategoria;
        }      
        
        $queryEjecutar = "SELECT *
        FROM   fexnot.fexnot_caracteristicas 
        WHERE  ((($codMatriz IS NOT NULL) AND
        codtiposmatriz = $codMatriz) OR $codMatriz IS NULL) AND
        ((($codCategoria IS NOT NULL) AND
        codcategorias = $codCategoria) OR
        $codCategoria IS NULL)"; 

        $info = DB::select($queryEjecutar);
        $arrInfoSolicitudes = json_decode(json_encode($info),true);

        return $arrInfoSolicitudes;
    }

    public function ObtenerCaracteristicasBase($idSolicitud,$codmatriz){
        $cursor = null;
        $procedure = 'BEGIN
        FEXNOT.FEXNOT_CARACTUNIDADCOND_PKG.FEXNOT_SEL_CARACTBASE_P
        (
            :PAR_IDSOLICITUDMATRIZ,
            :PAR_CODTIPOSMATRIZ,       
            :C_CARACTUNIDADCOND
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUDMATRIZ',$idSolicitud,\PDO::PARAM_STR,10);
        $stmt->bindParam(':PAR_CODTIPOSMATRIZ',$codmatriz,\PDO::PARAM_STR,10);
        $stmt->bindParam(':C_CARACTUNIDADCOND',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerSolicitudMatriz($idSolicitud){
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_SOLICITUDMATRIZ_PKG.FEXNOT_SELECT_SOLIMATBYIDSOL_P
        (
            :PAR_IDSOLICITUD,        
            :C_SOLICITUDMATRIZ
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_SOLICITUDMATRIZ',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerPropietariosNoRCON($idSolicitud){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_PROPIETARIOSINMUE_PKG.FEXNOT_SELECT_PROPNORCON_P
        (
            :PAR_IDSOLICITUD,        
            :C_PROPIETARINMUE
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_STR,10);    
        $stmt->bindParam(':C_PROPIETARINMUE',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }


    /**********************************************************UPDATE*****************************************************/

    public function cambiarPersona($idPersona,$idPersonaRCON,$codTipoPersona,$codSituacionPersona,$nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$curp,$claveife,$actPrin){
        try{
            $procedure = 'BEGIN    
            FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_UPDATE_PERSONCOND_P    
            (
                :PAR_IDPERSONA,
                :PAR_IDPERSONARCON,
                :PAR_CODTIPOPERSONA,
                :PAR_CODSITTUACIONESPERSONA,
                :PAR_NOMBRE,
                :PAR_APELLIDOPATERNO,
                :PAR_APELLIDOMATERNO,
                :PAR_RFC,
                :PAR_CURP,
                :PAR_CLAVEIFE,
                :PAR_ACTIVPRINCIP
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_IDPERSONARCON',$idPersonaRCON,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_CODTIPOPERSONA',$codTipoPersona,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_CODSITTUACIONESPERSONA',$codSituacionPersona,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_NOMBRE',$nombre,\PDO::PARAM_STR,100);
            $stmt->bindParam(':PAR_APELLIDOPATERNO',$apellidoPaterno,\PDO::PARAM_STR,100);
            $stmt->bindParam(':PAR_APELLIDOMATERNO',$apellidoMaterno,\PDO::PARAM_STR,100);
            $stmt->bindParam(':PAR_RFC',$rfc,\PDO::PARAM_STR,18);
            $stmt->bindParam(':PAR_CURP',$curp,\PDO::PARAM_STR,20);
            $stmt->bindParam(':PAR_CLAVEIFE',$claveife,\PDO::PARAM_STR,20);
            $stmt->bindParam(':PAR_ACTIVPRINCIP',$actPrin,\PDO::PARAM_INT,10);
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
          }
    }

    public function CambiarIdPersonaRCON($idPersona,$idPersonaRCON){
        try{
            $procedure = 'BEGIN    
            FEXNOT.FEXNOT_PERSONASCOND_PKG.FEXNOT_UPDATE_IDPERSRCON_P
            (
                :PAR_IDPERSONA,
                :PAR_IDPERSONARCON
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_IDPERSONARCON',$idPersonaRCON,\PDO::PARAM_INT,10);    
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
        }
    }

    public function CambiarProcedenciaPersona($idPersona,$esNueva,$esRconModificada){
        try{
            $procedure = 'BEGIN
            FEXNOT.FEXNOT_PROPIETARIOSINMUE_PKG.FEXNOT_UPDATE_PROCEDENCIA_P    
            (
                :PAR_IDPERSONA,
                :PAR_ESNUEVA,
                :PAR_ESRCONMODIFICADA
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDPERSONA',$idPersona,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_ESNUEVA',$esNueva,\PDO::PARAM_STR,10);
            $stmt->bindParam(':PAR_ESRCONMODIFICADA',$esRconModificada,\PDO::PARAM_STR,10);   
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
        }
    }
    
    public function CambiarEstadoSolicitud($idSolicitud,$codEstado){
        try{
            $procedure = 'BEGIN            
            FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_UPD_SOLICITUDESTADO_P  
            (
                :PAR_IDSOLICITUD,
                :PAR_CODESTADO
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_CODESTADO',$codEstado,\PDO::PARAM_STR,10);    
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
        }
    }

    public function CambiarIdExpediente($idSolicitud,$idExpediente){
        try{
            $procedure = 'BEGIN
            FEXNOT.FEXNOT_SOLICITUDES_PKG.FEXNOT_UPD_IDEXPEDIENTE_P
            (
                :PAR_IDSOLICITUD,
                :PAR_IDEXPEDIENTE
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDSOLICITUD',$idSolicitud,\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_IDEXPEDIENTE',$idExpediente,\PDO::PARAM_INT,10);
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
        }
    }

    public function CambiarUnidadesCondominales($arr){
        try{
            $procedure = 'BEGIN    
            FEXNOT.FEXNOT_UNIDADCONDOMINAL_PKG.FEXNOT_UPDATER_UNIDCONDOMIN_P
            (
                :PAR_IDUNIDADCONDOMINAL,
                :PAR_IDSOLICITUD,
                :PAR_NOMBREEDIFICIO,
                :PAR_NUMEROINTERIOR,
                :PAR_PORCENTAJEINDIVISO,
                :PAR_SUPCONSTAREAPRIVATIVA,
                :PAR_SUPCONSTAREACOMUN,
                :PAR_CALIFICACION,
                :PAR_VALORUNITARIOSUELO,
                :PAR_VALORUNITARIOCONSTRUCCION,
                :PAR_VALORSUELO,
                :PAR_VALORCONSTRUCCION,
                :PAR_VALORCATASTRAL,
                :PAR_IMPUESTO,
                :PAR_IDCLASE,
                :PAR_REGION,
                :PAR_MANZANA,
                :PAR_LOTE,
                :PAR_UNIDADPRIVATIVA,
                :PAR_IDUSOSMATRIZ,
                :PAR_SUPTERRENO,
                :PAR_ANDADOR,
                :PAR_SECCION,
                :PAR_ENTRADA,
                :PAR_NUMNIVELES,
                :PAR_ESRANGOUNICO,
                :PAR_CODTIPOSLOCALIDAD,
                :PAR_IDGIROS,
                :PAR_DIGITOVERIFICADOR,
                :PAR_CODTIPOSUNIDADES
            );
            END;';
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($procedure);
            $stmt->bindParam(':PAR_IDUNIDADCONDOMINAL',$arr['PAR_IDUNIDADCONDOMINAL'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_IDSOLICITUD',$arr['PAR_IDSOLICITUD'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_NOMBREEDIFICIO',$arr['PAR_NOMBREEDIFICIO'],\PDO::PARAM_STR,100);
            $stmt->bindParam(':PAR_NUMEROINTERIOR',$arr['PAR_NUMEROINTERIOR'],\PDO::PARAM_STR,100);
            $stmt->bindParam(':PAR_PORCENTAJEINDIVISO',$arr['PAR_PORCENTAJEINDIVISO'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_SUPCONSTAREAPRIVATIVA',$arr['PAR_SUPCONSTAREAPRIVATIVA'],\PDO::PARAM_STR,25);
            $stmt->bindParam(':PAR_SUPCONSTAREACOMUN',$arr['PAR_SUPCONSTAREACOMUN'],\PDO::PARAM_STR,25);
            $stmt->bindParam(':PAR_CALIFICACION',$arr['PAR_CALIFICACION'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_VALORUNITARIOSUELO',$arr['PAR_VALORUNITARIOSUELO'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_VALORUNITARIOCONSTRUCCION',$arr['PAR_VALORUNITARIOCONSTRUCCION'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_VALORSUELO',$arr['PAR_VALORSUELO'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_VALORCONSTRUCCION',$arr['PAR_VALORCONSTRUCCION'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_VALORCATASTRAL',$arr['PAR_VALORCATASTRAL'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_IMPUESTO',$arr['PAR_IMPUESTO'],\PDO::PARAM_INT,20);
            $stmt->bindParam(':PAR_IDCLASE',$arr['PAR_IDCLASE'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_REGION',$arr['PAR_REGION'],\PDO::PARAM_STR,3);
            $stmt->bindParam(':PAR_MANZANA',$arr['PAR_MANZANA'],\PDO::PARAM_STR,3);
            $stmt->bindParam(':PAR_LOTE',$arr['PAR_LOTE'],\PDO::PARAM_STR,2);
            $stmt->bindParam(':PAR_UNIDADPRIVATIVA',$arr['PAR_UNIDADPRIVATIVA'],\PDO::PARAM_STR,3);
            $stmt->bindParam(':PAR_IDUSOSMATRIZ',$arr['PAR_IDUSOSMATRIZ'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_SUPTERRENO',$arr['PAR_SUPTERRENO'],\PDO::PARAM_STR,25);
            $stmt->bindParam(':PAR_ANDADOR',$arr['PAR_ANDADOR'],\PDO::PARAM_STR,30);
            $stmt->bindParam(':PAR_SECCION',$arr['PAR_SECCION'],\PDO::PARAM_STR,10);
            $stmt->bindParam(':PAR_ENTRADA',$arr['PAR_ENTRADA'],\PDO::PARAM_STR,10);
            $stmt->bindParam(':PAR_NUMNIVELES',$arr['PAR_NUMNIVELES'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_ESRANGOUNICO',$arr['PAR_ESRANGOUNICO'],\PDO::PARAM_STR,1);
            $stmt->bindParam(':PAR_CODTIPOSLOCALIDAD',$arr['PAR_CODTIPOSLOCALIDAD'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_IDGIROS',$arr['PAR_IDGIROS'],\PDO::PARAM_INT,10);
            $stmt->bindParam(':PAR_DIGITOVERIFICADOR',$arr['PAR_DIGITOVERIFICADOR'],\PDO::PARAM_STR,1);
            $stmt->bindParam(':PAR_CODTIPOSUNIDADES',$arr['PAR_CODTIPOSUNIDADES'],\PDO::PARAM_STR,1);
            $stmt->execute();
            
            return true;
        }catch (\Throwable $th){
            Log::info($th);
            error_log($th);
            return $th;
        }
    }
}