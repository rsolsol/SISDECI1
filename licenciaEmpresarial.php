<?php
error_reporting(0);
require_once './PDF/ezpdf/class.ezpdf.php';
$pdf = new Cezpdf('a4','landscape');
$pdf->selectFont('./PDF/ezpdf/fonts/Helvetica.afm');
$datacreator = array (
                    'Title'=>'Licencia Funcionamiento',
                    'Author'=>'Gerencia de Tecnologias de Informacion y Gobierno Electronico',
                    'Subject'=>'Licencia Municipal',
                    'Creator'=>'ricardo.ypflores@gmail.com',
                    'Producer'=>'http://www.munipuentepiedra.gob.pe/'
                    );
$pdf->addInfo($datacreator);

require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

//recibimos los valores que nos envia el formulario
//recibimos el id del contacto que enviamos dese el archivo ver.php

$id_solicitud_sol = $_GET['id_solicitud_sol'];

$licen_muni="select solicitud.id_solicitud_sol,
	     desarrollo.lic_desa_eco,
             solicitud.nnumero_exp_sol,
             desarrollo.res_deseco,
             (case tramite.ID_TRAMITE_TTR when '1' then 'INDETERMINADO'
             when '2' then 'INDETERMINADO'
             WHEN '3' THEN 'TEMPORAL' when '4' then 'INDETERMINADO' END) AS tipo,
             desarrollo.razon_social_desaeco as razon_social,
             desarrollo.direccion_desaeco as ubicacion,
             desarrollo.giro_desaeco as giro,
             econo.vdesc_aeo as actividad,
             desarrollo.area_desaeco as area,
             solicitud.vRUC_SOL,
             DAY(desarrollo.fecha_des_eco) as dia,
             (case MONTH(desarrollo.fecha_des_eco) when '01' then 'ENERO' 
             WHEN '02' THEN 'FEBRERO' WHEN '03' THEN 'MARZO' WHEN '04' THEN 'ABRIL' WHEN '05' THEN 'MAYO' WHEN '06' THEN 'JUNIO'
             WHEN '07' THEN 'JULIO' WHEN '08' THEN 'AGOSTO' WHEN '09' THEN 'SEPTIEMBRE' WHEN '10' THEN 'OCTUBRE' WHEN '11' THEN 'NOVIEMBRE' WHEN '12' THEN 'DICIEMBRE' END) as mes ,
             YEAR(desarrollo.fecha_des_eco) as anio
             from lic_solicitud solicitud
             inner join lic_desa_econo desarrollo
             on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
             inner join estado_desaeco estado
             on estado.id_solicitud_sol = desarrollo.id_solicitud_sol
             inner join lic_tipo_tramite tramite
             on tramite.id_tramite_ttr = solicitud.id_tramite_ttr
             inner join lic_actividad_economica econo
             on econo.id_aec = solicitud.id_aec
             where solicitud.id_solicitud_sol = '$id_solicitud_sol';";
$licenc_consulta  = $db->consulta($licen_muni);
$licenc_resultado = $db->fetch_assoc($licenc_consulta);
$licenc_num     = $db->num_rows($licenc_consulta);
$licenciamuni   = $licenc_resultado['lic_desa_eco'];
//$expedimuni     = $licenc_resultado['expediente'];
$resolmuni      = $licenc_resultado['res_deseco'];
$id_expediente      = $licenc_resultado['nNUMERO_EXP_SOL'];

$nombremuni     = $licenc_resultado['razon_social'];
//campos relacionados con la direccion//
$ubicacionmuni  = $licenc_resultado['ubicacion']; 
$tipomuni = $licenc_resultado['tipo'];

$giromuni       = $licenc_resultado['giro'];
$actimuni       = $licenc_resultado['actividad'];
$areamuni       = $licenc_resultado['area'];
$rucmuni        = $licenc_resultado['vRUC_SOL'];
//configura la impresion de la fecha
$fechalic       = strtotime($licenc_resultado['fecha_des_eco']);
$diamuni        = $licenc_resultado['dia'];
$mesmuni         = $licenc_resultado['mes'];     
$aniomuni       = $licenc_resultado['anio'];
$pdf->ezText("\n");
$pdf->ezImage('./img/munipuentepiedra.jpg',4,156,'center');
$pdf->ezText("\n");
$pdf->ezText("LICENCIA MUNICIPAL",28,array('justification'=>'center','width' => 896));
$pdf->ezText("APERTURA PARA ESTABLECIMIENOS COMERCIALES,",16,array('justification'=>'center','width' => 896));
$pdf->ezText("INDUSTRIAS Y DE SERVICIOS\n",16,array('justification'=>'center','width' => 896));
$pdf->ezText("                 LICENCIA : " .$licenciamuni. "        EXPEDIENTE : " .$id_expediente."         RESOLUCION : " .$resolmuni. "          TIPO : ".$tipomuni."\n",12);
$pdf->ezText(utf8_decode("Habiendo cumplido con todos los requisitos para obtener la Licencia de Apertura a que se refiere el Art. 7 de la Ley N° 28976 Ley Marco de la Licencia de Funcionamiento, concordante con el Art. 24 de la Ordenanza Municipal N° 223-MDPP que reguló los procedimientos de autorización municipal al funcionamiento de establecimientos en el Distrito, otorgamos la presente a:\n"),13);
$pdf->ezText("                   NOMBRE     : ".$nombremuni."\n",12);
$pdf->ezText("                   UBICACION : ".$ubicacionmuni." \n",12);
$pdf->ezText("                   GIRO            : ".$giromuni."\n",12);
$pdf->ezText("                   ACTIVIDAD  : ".$actimuni."\n",12);
$pdf->ezText("                   AREA            : ".$areamuni." Mt2\n",12);
$pdf->ezText("                   R.U.C            : ".$rucmuni."\n",12);
$pdf->ezText("                                                                                                                                              Puente Piedra, ".$diamuni." de ".$mesmuni." del ".$aniomuni."\n",12);
$pdf->ezText("\n\n");
$pdf->ezText("NOTA :\n",5);
$pdf->ezText(utf8_decode("- EL PRESENTE, SOLO ES VÁLIDO PARA EL TITULAR Y DEBERÁ MANTENERSE EN LUGAR VISIBLE.\n"),5);
$pdf->ezText(utf8_decode("- EL CESE DE ACTIVIDADES DEBERÁ COMUNICARSE A LA MUNICIPALIDAD DISTRITAL DE PUENTE PIEDRA.\n"),5);
$pdf->ezText(utf8_decode("- ESTA LICENCIA NO AUTORIZA EL USO DE LA VÍA PÚBLICA.\n"),5);
$pdf->ezText(utf8_decode("- EL CAMBIO DE GIRO, QUEJA DE VECINOS TODO AQUELLO QUE ATENTE CONTRA LA TRANQUILIDAD DEL \n"),5);
$pdf->ezText(utf8_decode("VECINDARIO SERÁ CAUSAL DE REVOCATORIA DE LA LICENCIA."),5);
$pdf->ezStream();
?>