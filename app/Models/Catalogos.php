<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exeption;
use Log;

class Catalogos
{
    public function GetCatIndiviso(){
        $arrResCat = DB::select("SELECT * FROM FEXNOT_CATTIPOSINDIVISO");
        return json_decode(json_encode($arrResCat),true);
    }

    
    public function GetCatRangoNivelesUso($idUsoEjercicio){
        $cursor = null;
        $procedure = 'BEGIN 
        FEXNOT.FEXNOT_CATRANGONIVELES_PKG_MX.getrangonivelesxuso_ejercicio(
            :P_IDUSOSEJERCICIO,
            :C_CONSULTA);
        END;';

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);
        $stmt->bindParam(':P_IDUSOSEJERCICIO',$idUsoEjercicio,\PDO::PARAM_INT,10);
        $stmt->bindParam(':C_CONSULTA',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrResCat,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrResCat;
    }

    public function GetCatRangoNiveles(){
        $cursor = null;
        $procedure = 'BEGIN 
        FEXNOT.FEXNOT_CATRANGONIVELES_PKG_MX.CONSULTACATRANGONIVELES_P(       
            :c_CATRANGONIVELES);
        END;';

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':c_CATRANGONIVELES',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrResCat,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrResCat;
    }

    public function ObtenerEstadosPorCodApliyActivo($codAplicacion,$activo){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CATCONDOMINIOS_PKG.FEXNOT_SELECT_CATESTBYAPLIC_P
        (           
            :PAR_CODAPLICACION,
            :PAR_ACTIVO,
            :C_CATCONDOMINIO
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':PAR_CODAPLICACION',$codAplicacion,\PDO::PARAM_STR,3);
        $stmt->bindParam(':PAR_ACTIVO',$activo,\PDO::PARAM_STR,3);
        $stmt->bindParam(':C_CATCONDOMINIO',$cursor,\PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrResCat,0,-1,OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);
        return $arrResCat;
    }

    public function ObtenerUsosMatriz(){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_MATRICES_V_PKG.FEXNOT_SEL_USOSMATRIZ_P
        (                   
            :C_MATRIZ
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':C_MATRIZ',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }

    public function ObtenerTiposLocalidad(){
        
        $cursor = null;
        $procedure = 'BEGIN    
        FEXNOT.FEXNOT_CATTIPOLOCALIDAD_PKG.FEXNOT_SELECT_CATTIPOLOC_P
        (                   
            :C_CATTIPOLOCALIDAD
        );
        END;';
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($procedure);    
        $stmt->bindParam(':C_CATTIPOLOCALIDAD',$cursor,\PDO::PARAM_STMT);  
        $stmt->execute();
        oci_execute($cursor,OCI_DEFAULT);
        oci_fetch_all($cursor,$arrInfoSolicitudes,0,-1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($cursor);

        return $arrInfoSolicitudes;
    }
}