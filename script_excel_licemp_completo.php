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
        $sql = "select solicitud.nnumero_exp_sol as expediente,
       solicitud.dfecha_ingreso as fecha_expedi,
       desarrollo.lic_desa_eco as licencia,
       desarrollo.res_deseco as resolucion,
       civil.num_resol_defcvl as resol_defcvl,
       substring(desarrollo.fecha_des_eco,1,10) as fecha,
       desarrollo.razon_social_desaeco as razon_social,
       desarrollo.giro_desaeco as giro,
       eco.vdesc_aeo as actividad,
       (case solicitud.id_tipo_doc when '1' then 'PERSONA NATURAL'
       WHEN '0' THEN 'PERSONA JURIDICA' END) as personeria,
       desarrollo.direccion_desaeco as direccion,
       desarrollo.sector as sector,
       desarrollo.area_desaeco as area,
       solicitud.vRUC_SOL as ruc,
       (case solicitud.id_condicloc_clo when '1' then 'GRUPO 1' 
       WHEN '2' THEN 'GRUPO 2' WHEN '3' THEN 'GRUPO 3' END) AS nro_grupo,
       estado.obser_estado as observacion
from lic_solicitud solicitud
left join lic_desa_econo desarrollo
on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
left join estado_desaeco estado
on desarrollo.id_solicitud_sol = estado.id_solicitud_sol 
left join lic_defensa_civl civil
on solicitud.id_solicitud_sol = civil.id_solicitud_sol
left join lic_actividad_economica eco
on solicitud.id_aec = eco.id_aec
where not exists (select * from lic_defensa_civl where estado.estado_anulado = '1')
and date(solicitud.dfecha_ingreso) between '$v_fecha_ini' AND '$v_fecha_fin';";
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
