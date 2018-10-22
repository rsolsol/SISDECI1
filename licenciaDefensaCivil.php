<?php
error_reporting(0);
require_once './PDF/ezpdf/class.ezpdf.php';
$pdf = new Cezpdf('letter');
$pdf->selectFont('./PDF/ezpdf/fonts/Helvetica.afm');
$datacreator = array (
                    'Title'=>'Licencia Funcionamiento',
                    'Author'=>'Gerencia de Tecnologias de Informacion y Gobierno Electronico',
                    'Subject'=>'Licencia Muniicpal',
                    'Creator'=>'ricardo.ypflores@gmail.com',
                    'Producer'=>'http://www.munipuentepiedra.gob.pe/'
                    );
$pdf->addInfo($datacreator);

require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

$id_solicitud_sol = $_GET['id_solicitud_sol'];

$sqldefencvl="select solicitud.id_solicitud_sol,
                     civil.num_resol_defcvl,
                     actividad.vdesc_aeo,
                     civil.direccion_defcvl,
	             civil.razon_social,
                     civil.capa_aforo_numero,
                     civil.capa_aforo_letra,
	             clasifica.id_giro, 
                     giro.vdesc_giro,
                     civil.area_defcvl,
                     solicitud.nNUMERO_EXP_SOL,
                     solicitud.id_tramite_ttr,
                     DAY(civil.fecha_defcvl) as dia,
                     (case MONTH(civil.fecha_defcvl) when '01' then 'ENERO' 
                     WHEN '02' THEN 'FEBRERO' WHEN '03' THEN 'MARZO' WHEN '04' THEN 'ABRIL' WHEN '05' THEN 'MAYO' WHEN '06' THEN 'JUNIO'
                     WHEN '07' THEN 'JULIO' WHEN '08' THEN 'AGOSTO' WHEN '09' THEN 'SEPTIEMBRE' WHEN '10' THEN 'OCTUBRE' WHEN '11' THEN 'NOVIEMBRE' WHEN '12' THEN 'DICIEMBRE' END) as mes ,
                     YEAR(civil.fecha_defcvl) as anio
from lic_solicitud solicitud
inner join lic_actividad_economica actividad
on solicitud.id_aec= actividad.id_aec
inner join lic_clasifica_giro clasifica
on clasifica.id_solicitud_sol = solicitud.id_solicitud_sol
inner join lic_giro giro
on giro.id_giro = clasifica.id_giro
inner join lic_defensa_civl civil
on solicitud.id_solicitud_sol = civil.id_solicitud_sol
inner join estado_defcvl defensa
on defensa.id_def_civl = civil.id_def_civl
inner join lic_tipo_tramite tramite
on tramite.id_tramite_ttr = solicitud.id_tramite_ttr
where  LENGTH(defensa.infotecnico) >= 1
and solicitud.id_solicitud_sol = '$id_solicitud_sol';";
$defensa_consulta = $db->consulta($sqldefencvl);
$defensa_resultado = $db->fetch_assoc($defensa_consulta);
$defensa_num = $db->num_rows($defensa_consulta);
$numero_resolucion = $defensa_resultado['num_resol_defcvl'];
$socialcivil = $defensa_resultado['razon_social'];
$direccion = $defensa_resultado['direccion_defcvl'];
$actividad = $defensa_resultado['vdesc_aeo'];
$cap_aforo_numero = $defensa_resultado['capa_aforo_numero'];
$cap_aforo_letra = $defensa_resultado['capa_aforo_letra'];
$girocivil = $defensa_resultado['vdesc_giro'];
$areacivil = $defensa_resultado['area_defcvl'];
$expcivil = $defensa_resultado['nNUMERO_EXP_SOL'];

switch($defensa_resultado['id_tramite_ttr']){
    case "1":
        $vigencivl="Indeterminada";
        break;
    case "3":
        $vigencivl="Temporal";
        break;
}

$diamuni       = $defensa_resultado['dia'];
$mesmuni        = $defensa_resultado['mes'];
$aniomuni       = $defensa_resultado['anio'];



$pdf->ezText("\n\n\n\n\n\n\n\n\n\n\n");
$pdf->ezText("No ".$numero_resolucion."\n",24,array('justification'=>'center','width' => 896));
$pdf->ezText(utf8_decode("La Sub Gerencia de Inspecciones Técnicas de Seguridad y Gestion de Riesgos de Desastres, el órgano ejecutante de la Inspección Técnica de Seguridad en Edificaciones, en cumplimiento de lo establecido en la Ley D.S. N° 058-2014-PCM, ha realizado la Inspección Técnica de Seguridad en edificaciones Ex ante al:\n"),14,array('justificaction'=>'justification'));
$pdf->ezText("$actividad.",12,array('justification'=>'center','width' => 896));
$pdf->ezText("ubicado en " .utf8_decode($direccion).". \n",12);
$pdf->ezText("distrito Puente Piedra, Provincia y Departamento de Lima .\n",10);
$pdf->ezText(utf8_decode("El que suscribe CERTIFICA que el objeto de inspección antes señalado CUMPLE con la Normativa en materia de Seguridad en Edificaciones, otorgandose el presente CERTIFICADO DE ITSE.\n"),14);
$pdf->ezText(utf8_decode("Solicitante               : ").$socialcivil."\n",10);
$pdf->ezText(utf8_decode("Capacidad m�xima : ").$cap_aforo_numero."  ".$cap_aforo_letra." personas.\n",10);
$pdf->ezText("Giro o actividad       : ".$girocivil."\n",10);
$pdf->ezText(utf8_decode("Área                        : ").$areacivil." Mt2. \n",10);
$pdf->ezText("Solicitud                  : Exp. N ".$expcivil."\n",10);
$pdf->ezText(utf8_decode("                                                                              Resolución              : ").$numero_resolucion." SGITSGRD-GDE/MDPP. \n",10);
$pdf->ezText("Vigencia                  : ".$vigencivl."\n\n\n",10);
$pdf->ezText("                                                                                                                              Puente Piedra, ".$diamuni." de ".$mesmuni." del ".$aniomuni.".\n",10);
$pdf->ezText(utf8_decode("El presente Certificado de ITSE no constituye autorización alguna para el funcionamiento del objeto de la presente Inspección ."),8);
$pdf->ezStream();