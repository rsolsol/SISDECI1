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

$id_interno = $_GET['idregistro'];
$id_expediente = $_GET['idexpediente'];
$licen_muni="SELECT nNUMERO_EXP_SOL,lic_solicitud.ID_AEC,vNOM_RAZON_SOL,vRUC_SOL,vDIRECCION_EST,nNUMERO_EST,nINT_EST,vMZ_EST,nLOTE_EST,vDENODES_EST,nAREA_LOCAL_EST,vDESC_GIRO, vDESC_AEO,res_deseco,lic_desa_eco,vDESC_TTR,fecha_des_eco FROM lic_solicitud
         INNER JOIN lic_establecimiento 	ON lic_establecimiento.ID_ESTABLEC_EST = lic_solicitud.ID_ESTABLEC_EST
         INNER JOIN lic_clasifica_giro 		ON lic_clasifica_giro.ID_SOLICITUD_SOL = lic_solicitud.ID_SOLICITUD_SOL
		 INNER JOIN lic_giro 				ON lic_giro.ID_GIRO = lic_clasifica_giro.ID_GIRO
         INNER JOIN lic_actividad_economica ON lic_actividad_economica.ID_AEC = lic_solicitud.ID_AEC
         INNER JOIN lic_desa_econo 			ON lic_desa_econo.id_solicitud_sol = lic_solicitud.ID_SOLICITUD_SOL
         INNER JOIN lic_tipo_tramite		ON lic_tipo_tramite.ID_TRAMITE_TTR = lic_solicitud.ID_TRAMITE_TTR
         WHERE lic_solicitud.ID_SOLICITUD_SOL = $id_interno;" ;
$licenc_consulta  = $db->consulta($licen_muni);
$licenc_resultado = $db->fetch_assoc($licenc_consulta);
$licenc_num     = $db->num_rows($licenc_consulta);
$licenciamuni   = $licenc_resultado['lic_desa_eco'];
//$expedimuni     = $licenc_resultado['expediente'];
$resolmuni      = $licenc_resultado['res_deseco'];

//es temporal o permantente la licencia
switch($licenc_resultado['ID_AEC']){
    case "1":
        $tipomuni="Indeterminada";
        break;
    case "3":
        $tipomuni="Temporal";
        break;
}

$nombremuni     = $licenc_resultado['vNOM_RAZON_SOL'];
//campos relacionados con la direccion//
$ubicacionmuni  = $licenc_resultado['vDIRECCION_EST']; 
$nr             = $licenc_resultado['nNUMERO_EST'];
$nrInt         = $licenc_resultado['nINT_EST'];
$mz             = $licenc_resultado['vMZ_EST'];
$lt             = $licenc_resultado['nLOTE_EST'];
$asoc           = $licenc_resultado['vDENODES_EST'];
if ($mz!=" "){
    $manzanita="Mz.: '$mz' Lt.: '$lt' $asoc";
   // echo $manzanita;
}

$giromuni       = $licenc_resultado['vDESC_GIRO'];
$actimuni       = $licenc_resultado['vDESC_AEO'];
$areamuni       = $licenc_resultado['nAREA_LOCAL_EST'];
$rucmuni        = $licenc_resultado['vRUC_SOL'];
//configura la impresion de la fecha
$fechalic       = strtotime($licenc_resultado['fecha_des_eco']);
$diamuni        = date("d",$fechalic);
switch(date("m",$fechalic)){
    case "1":
        $mesmuni="Enero";
        break;
    case "2":
        $mesmuni="Febrero";
        break;
    case "3":
        $mesmuni="Marzo";
        break;
    case "4":
        $mesmuni="Abril";
        break;
    case "5":
        $mesmuni="Mayo";
        break;
    case "6":
        $mesmuni="Junio";
        break;
    case "7":
        $mesmuni="Julio";
        break;
    case "8":
        $mesmuni="Agosto";
        break;
    case "9":
        $mesmuni="Setiembre";
        break;
    case "10":
        $mesmuni="Octubre";
        break;
    case "11":
        $mesmuni="Noviembre";
        break;
    case "12":
        $mesmuni="Diciembte";
        break;
}
$aniomuni       = date("Y",$fechalic);

$pdf->ezText("\n");
$pdf->ezImage('./img/munipuentepiedra.jpg',4,156,'center');
$pdf->ezText("\n");
$pdf->ezText("LICENCIA MUNICIPAL",28,array('justification'=>'center','width' => 896));
$pdf->ezText("APERTURA PARA ESTABLECIMIENOS COMERCIALES,",16,array('justification'=>'center','width' => 896));
$pdf->ezText("INDUSTRIAS Y DE SERVICIOS\n",16,array('justification'=>'center','width' => 896));
$pdf->ezText("                 LICENCIA : " .$licenciamuni. "        EXPEDIENTE : " .$id_expediente."         RESOLUCION : " .$resolmuni. "          TIPO : ".$tipomuni."\n",12);
$pdf->ezText(utf8_decode("Habiendo cumplido con todos los requisitos para obtener la Licencia de Apertura a que se refiere el Art. 7 de la Ley N° 28976 Ley Marco de la Licencia de Funcionamiento, concordancte con el Art. 24 de la Ordenanza Municipal N° 223-MDPP que reguló los procedimientos de autorización municipal al funcionamiento de establecimientos en el Distrito, otorgamos la presente a:\n"),12);
$pdf->ezText("                   NOMBRE     : ".$nombremuni."\n",12);
//$pdf->ezText(utf8_decode("                   UBICACIÓN : ").$ubicacionmuni." ".$nr." ".$nrInt." ".$mz." ".$lt." ".$asoc. " - Puente Piedra.\n",12);
$pdf->ezText(utf8_decode("                   UBICACIÓN : ").$ubicacionmuni." ".$manzanita. " - Puente Piedra.\n",12);

$pdf->ezText("                   GIRO            : ".$giromuni."\n",12);
$pdf->ezText("                   ACTIVIDAD  : ".$actimuni."\n",12);
$pdf->ezText("                   AREA            : ".$areamuni." Mt2\n",12);
$pdf->ezText("                   R.U.C            : ".$rucmuni."                                                                                            Puente Piedra, ".$diamuni." de ".$mesmuni." del ".$aniomuni."\n",12);
$pdf->ezText("NOTA :\n",5);
$pdf->ezText(utf8_decode("- EL PRESENTE, SOLO ES VÁLIDO PARA EL TITULAR Y DEBERÁ MANTENERSE EN LUGAR VISIBLE.\n"),5);
$pdf->ezText(utf8_decode("- EL CESE DE ACTIVIDADES DEBERÁ COMUNICARSE A LA MUNICIPALIDAD DISTRITAL DE PUENTE PIEDRA.\n"),5);
$pdf->ezText(utf8_decode("- ESTA LICENCIA NO AUTORIZA EL USO DE LA VÍA PÚBLICA.\n"),5);
$pdf->ezText(utf8_decode("- EL CAMBIO DE GIRO, QUEJA DE VECINOS TODO AQUELLO QUE ATENTE CONTRA LA TRANQUILIDAD DEL \n"),5);
$pdf->ezText(utf8_decode("VECINDARIO SERÁ CAUSAL DE REVOCATORIA DE LA LICENCIA."),5);
$pdf->ezStream();
