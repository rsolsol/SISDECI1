<?php

function obtenerReporteProductos(){
    $lista = array();
    try{
        // Conexion
        $con = new PDO('mysql:host=localhost;dbname=bd_licencia', 'root', 'mdpp@gtige');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $v_fecha_ini = $_GET['iday'];
        $v_fecha_fin = $_GET['fday'];        

        // Consulta
        $sql = "select solicitud.nnumero_exp_sol,
                year(solicitud.dfecha_ingreso) as dia,
                giro.vdesc_giro,
                (case solicitud.id_condicloc_clo when '1' then 'EXPOST' 
                WHEN '2' THEN 'EXANTE' WHEN '3' THEN 'DETALLE' END) AS tipo_establecimiento,
                solicitud.dfecha_ingreso,
                (case estado.estado_obs_defcvl
	        WHEN '1' THEN 'APROBADO' 
	        WHEN '2' THEN 'DESAPROBADO' END) AS estado,
	        civil.num_resol_defcvl,
                civil.fecha_defcvl,
                civil.num_cart_defcvl as certificado,
                substring(civil.fecha_defcvl,1,4) as año_cert,
                (case tramite.ID_TRAMITE_TTR when '1' then 'INDETERMINADO'
                WHEN '2' THEN 'INDETERMINADO'
                WHEN '3' THEN 'INDETERMINADO' 
                WHEN '4' THEN 'INDETERMINADO' END) AS vigencia,
                civil.area_defcvl as area,
                civil.razon_social as razon_social,
                civil.direccion_defcvl as direccion,
                actividad.vdesc_aeo,
                (case solicitud.id_condicloc_clo when '1' then 'GRUPO 1' 
                WHEN '2' THEN 'GRUPO 2' WHEN '3' THEN 'GRUPO 3' END) AS nro_grupo,
                civil.capa_aforo_numero as aforo,
                civil.capa_aforo_letra as aforo_letra,
                estado.infotecnico as info_tecnico,
                estado.infoacta as info_acta,
                inspector.nominsp_defcvl as nombre_inspector ,
                inspector.sigla_defcvl as sigla_inspector,
                estado.obs_defcvl as observacion,
                civil.pers_recibe_certificado as persona_certificado,
                civil.fecha_entrega,
                civil.nro_memo
                from lic_solicitud solicitud
                left join lic_defensa_civl civil
                on civil.id_solicitud_sol = solicitud.ID_SOLICITUD_SOL
                left join lic_clasifica_giro clasifica
                on clasifica.id_solicitud_sol = solicitud.id_solicitud_sol
                left join lic_giro giro
                on giro.id_giro = clasifica.id_giro
                left join estado_defcvl estado
                on civil.id_def_civl = estado.id_def_civl
                left join lic_tipo_tramite tramite
                on tramite.id_tramite_ttr = solicitud.id_tramite_ttr
                left join lic_actividad_economica actividad
                on solicitud.id_aec= actividad.id_aec
                left join nombre_inspector inspector
                on inspector.id_nombre_inspector = estado.id_nombre_inspector
                where substring(solicitud.dfecha_ingreso,1,4) = '2016'
                and date(solicitud.dfecha_ingreso) between '$v_fecha_ini' and '$v_fecha_fin';";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        while($objeto = $stmt->fetchObject()){
            $lista[] = $objeto;
        }
        
    }  catch (Exception $e){
        echo 'ERROR en el sistema: ' . $e->getMessage();
    }
    return $lista;
}

$lista = obtenerReporteProductos();