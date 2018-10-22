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

$EXP_SOL = $_GET['nNUMERO_EXP_SOL'];
$soli_sol = $_GET['ID_SOLICITUD_SOL'];

$sqlimplic = "SELECT  lic_solicitud.ID_SOLICITUD_SOL,
                        lic_tipo_tramite.ID_TRAMITE_TTR,
                        lic_tipo_tramite.vDESC_TTR,
                        lic_solicitud.nNUMERO_EXP_SOL,
                        lic_solicitud.vNOM_RAZON_SOL,
                        lic_tipo_doc.ID_TIPO_DOC,
                        lic_tipo_doc.vDESC_TIPO,
                        lic_solicitud.vDNI_SOL,
                        lic_solicitud.vCORREO_SOL,
                        lic_solicitud.vTEL_SOL,
                        lic_solicitud.nu_cntrbynte,
                        lic_solicitud.vAVDA_SOL,
                        lic_solicitud.nNUMCASA_SOL,
                        lic_solicitud.nINT_SOL,
                        lic_solicitud.vMZ_SOL,
                        lic_solicitud.nLOTE_SOL,
                        lic_solicitud.vDENODES_SOL,
                        lic_solicitud.nNUMCERT_INDECI_SOL,
                        lic_denomina_loc.ID_DENOMI,
                        lic_denomina_loc.vNOM_DENOMI,
                        lic_distrito.ID_DISTRITO_DIS,
                        lic_distrito.vDESC_DIS,
                        lic_provincia.ID_PROV,
                        lic_provincia.vDE_PROV,
                        lic_departamento.ID_DEPA,
                        lic_departamento.vDE_DEPA,
                        lic_tipo_doc_sunat.ID_TIPO_DOC_SUNAT,
                        lic_tipo_doc_sunat.vDESC_TIPO,
                        lic_solicitud.vRUC_SOL,
                        lic_tipo_doc2.ID_TIPO_DOC AS ID_TIPO_DOC_REL,
                        lic_tipo_doc2.vDESC_TIPO AS vDESC_TIPO_REL,
                        lic_solicitud.nDNI_REL,
                        lic_solicitud.vTEL_REL,
                        lic_solicitud.vNOM_REL,
                        lic_solicitud.vNOM_ESTABLE_SOL,
                        lic_establecimiento.ID_ESTABLEC_EST,
                        lic_condicion_local.ID_CONDICLOC_CLO,
                        lic_condicion_local.vDESC_CLO,
                        lic_dato_establecimiento.ID_DATEST_DES,
                        lic_dato_establecimiento.vDESC_DES,
                        lic_denomina_loc_est.ID_DENOMI AS ID_DENOMI_EST,
                        lic_denomina_loc_est.vNOM_DENOMI AS vNOM_DENOMI_EST,
                        lic_establecimiento.vDENODES_EST,
                        lic_establecimiento.vDIRECCION_EST,
                        lic_establecimiento.nNUMERO_EST,
                        lic_establecimiento.nINT_EST,
                        lic_establecimiento.vMZ_EST,
                        lic_establecimiento.nLOTE_EST,
                        lic_establecimiento.vNUM_PUESTO_SOL,
                        lic_establecimiento.vNUM_STAND_SOL,
                        lic_establecimiento.vREFEREN_EST,
                        lic_establecimiento.nAREA_LOCAL_EST,
                        lic_establecimiento.nAREA_VIA_PUB_EST,
                        lic_establecimiento.nAREA_TOTAL_EST,
                        lic_zonas.ID_ZONA_ZON,
                        lic_zonas.vDESC_ZON,
                        lic_zonas.vCODI_ZON,
                        lic_actividad_economica.ID_AEC,
                        lic_actividad_economica.vDESC_AEO,
                        lic_establecimiento.nCAPAC_FORO_EST,
                        lic_establecimiento.nCAPAC_EST,
                        lic_solicitud.nTOXICO_SOL,
                        lic_giro.ID_GIRO,
                        lic_giro.vDESC_GIRO,
                        lic_clasifica_giro.de_espcfcion_giro,
                        lic_solicitud.vCOMPAT_USO_SOL,
                        lic_solicitud.ID_CEST AS ID_GRUPO,
                        lic_solicitud.nNUMCERT_INDECI_SOL,
                        lic_solicitud.vDESC_LIC,
                        lic_solicitud.dFECHA_INGRESO,
                        lic_solicitud.id_usu
                FROM lic_solicitud
                                                                                LEFT JOIN lic_denomina_loc 
                                                                                    ON lic_solicitud.ID_DENOMI = lic_denomina_loc.ID_DENOMI
                                                                            INNER JOIN lic_tipo_doc_sunat 
                                                                                ON lic_tipo_doc_sunat.ID_TIPO_DOC_SUNAT = lic_solicitud.ID_TIPO_DOC_SUNAT
                                                                        LEFT JOIN lic_tipo_doc 
                                                                            ON lic_tipo_doc.ID_TIPO_DOC = lic_solicitud.ID_TIPO_DOC
                                                                    INNER JOIN lic_distrito 
                                                                        ON lic_solicitud.ID_DISTRITO_DIS = lic_distrito.ID_DISTRITO_DIS
                                                                INNER JOIN lic_provincia 
                                                                    ON lic_provincia.ID_PROV = lic_distrito.ID_PROV
                                                            INNER JOIN lic_departamento 
                                                                ON lic_departamento.ID_DEPA = lic_provincia.ID_DEPA
                                                        LEFT JOIN lic_tipo_doc AS lic_tipo_doc2 
                                                            ON lic_tipo_doc2.ID_TIPO_DOC = lic_solicitud.ID_TIPO_DOC2
                                                    INNER JOIN lic_tipo_tramite 
                                                        ON lic_tipo_tramite.ID_TRAMITE_TTR = lic_solicitud.ID_TRAMITE_TTR
                                                INNER JOIN lic_establecimiento 
                                                    ON lic_solicitud.ID_ESTABLEC_EST = lic_establecimiento.ID_ESTABLEC_EST
                                            INNER JOIN lic_condicion_local 
                                                ON lic_solicitud.ID_CONDICLOC_CLO = lic_condicion_local.ID_CONDICLOC_CLO
                                        INNER JOIN lic_dato_establecimiento 
                                            ON lic_dato_establecimiento.ID_DATEST_DES = lic_solicitud.ID_DATEST_DES
                                    INNER JOIN lic_denomina_loc AS lic_denomina_loc_est 
                                        ON lic_establecimiento.ID_DENOMI = lic_denomina_loc_est.ID_DENOMI
                                LEFT JOIN lic_zonas 
                                    ON lic_establecimiento.ID_ZONA_ZON = lic_zonas.ID_ZONA_ZON
                            INNER JOIN lic_actividad_economica 
                                ON lic_actividad_economica.ID_AEC = lic_solicitud.ID_AEC
                        LEFT JOIN lic_clasifica_giro 
                            ON lic_solicitud.ID_SOLICITUD_SOL = lic_clasifica_giro.ID_SOLICITUD_SOL
                    LEFT JOIN lic_giro 
                        ON lic_clasifica_giro.ID_GIRO = lic_giro.ID_GIRO
                WHERE lic_solicitud.IN_ESTA != '0' and lic_solicitud.nNUMERO_EXP_SOL like '%2016'
                and lic_solicitud.nNUMERO_EXP_SOL = '$EXP_SOL';";

$impli_consulta = $db->consulta($sqlimplic);
$impli_resultado = $db->fetch_assoc($impli_consulta);
$impli_num = $db->num_rows($impli_consulta);
$expe = $impli_resultado['nNUMERO_EXP_SOL'];
$dni = $impli_resultado['vDNI_SOL'];
$nombre = $impli_resultado['vNOM_REL'];
$ruc = $impli_resultado['vRUC_SOL'];
$telefono = $impli_resultado['vTEL_REL'];
$depa = $impli_resultado['vDE_DEPA'];
$prov = $impli_resultado['vDE_PROV'];
$distrito = $impli_resultado['vDESC_DIS'];
$referencia = $impli_resultado['vREFEREN_EST'];
$telefono = $impli_resultado['vTEL_REL'];
$contribuyente = $impli_resultado['nu_cntrbynte'];
$establecimiento = $impli_resultado['vNOM_ESTABLE_SOL'];
$tipo_au = $impli_resultado['vDESC_TTR'];

$resolcivil = $impli_resultado['nun_resol_defcivil'];
$vigencivl = $impli_resultado['desc_vigencia'];
$nom_razon = $impli_resultado["vNOM_RAZON_SOL"];
$dir_est = $impli_resultado["vDIRECCION_EST"];
$condicion = $impli_resultado["vDESC_CLO"];
$tipo = $impli_resultado["vDESC_DES"];
$area = $impli_resultado["nAREA_TOTAL_EST"];
$obs = $impli_resultado["vDESC_LIC"];

$impli_resultado["nNUMERO_EST"]?$num_est = " Nº " .$impli_resultado["nNUMERO_EST"] : $num_est;
$impli_resultado["nINT_EST"]?$inte_est = " INT. ".$impli_resultado["nINT_EST"] : $inte_est;
$impli_resultado["vMZ_EST"]?$mz_est = " MZ. ".$impli_resultado["vMZ_EST"] : $mz_est;
$impli_resultado["nLOTE_EST"]?$lt_est = " LT. ".$impli_resultado["nLOTE_EST"] : $lt_est;
$impli_resultado["vNUM_PUESTO_SOL"]?$psto_est = " PSTO. ".$impli_resultado["vNUM_PUESTO_SOL"] : $psto_est;
$impli_resultado["vNUM_STAND_SOL"]?$stnd_est = " STND. ".$impli_resultado["vNUM_STAND_SOL"] : $stnd_est;
$ah_est = $impli_resultado["vNOM_DENOMI_EST"]. " " .$impli_resultado["vDENODES_EST"];
$direstablecimiento = $dir_est . $num_est . $inte_est . $mz_est . $lt_est . $psto_est . $stnd_est . " - " . $ah_est;

$sececono = $impli_resultado['vDESC_AEO'];
//vDESC_AEO
$toxico=$impli_resultado["nTOXICO_SOL"]=='2' ? $img_tox = "/img/cancel.png" : $img_tox = "/img/confirmar.png";
$capa_foro = $impli_resultado['nCAPAC_FORO_EST'];

$descri_giro = $impli_resultado['vDESC_GIRO'];
$esp_giro = $impli_resultado['de_espcfcion_giro'];
$descri_zona = $impli_resultado['vDESC_ZON'];

$impli_resultado["vCOMPAT_USO_SOL"]=='1' ? $img_com = '/confirmar.png' : $img_com = '/cangel.png';
if($impli_resultado["ID_GRUPO"]=='1') $grupo = "GRUPO 1"; 
if($impli_resultado["ID_GRUPO"]=='2') $grupo = "GRUPO 2"; 
if($impli_resultado["ID_GRUPO"]=='3') $grupo = "GRUPO 3";

if($impli_resultado["ID_GRUPO"]=='3' and $indeci){
        $pdf->SetXY(87,$y_a);
        $pdf->SetWidths(array(60, 30));
        $pdf->Row(array(utf8_decode("CERTIFICADO INDECI"), "$indeci"), 0);
    }

$sql_anexo = "select lic_doc_anexo.ID_DOCANEX_DAN , lic_doc_anexo.vDESC_DAN 
from lic_doc_anexo lic_doc_anexo
inner join lic_solic_doc_anex lic_solic_doc_anex
on lic_doc_anexo.ID_DOCANEX_DAN = lic_solic_doc_anex.ID_DOCANEX_DAN
where lic_solic_doc_anex.ID_SOLICITUD_SOL = '$soli_sol';";
$implane_consulta = $db->consulta($sql_anexo);
$implane_resultado = $db->fetch_assoc($implane_consulta);
$implane_num = $db->num_rows($implane_consulta);
$doc_asigna = $implane_resultado['vDESC_DAN'];

$pdf->ezText("MUNICIPALIDAD DISTRITAL DE PUENTE PIEDRA");
$pdf->ezText(utf8_decode("Año de la consolidación del Mar de Grau"));
$pdf->ezText("GERENCIA DE DESARROLLO ECONOMICO");
$pdf->ezText("Sub-Gerencia de Desarrollo Empresarial y Comercial");
$pdf->ezText(utf8_decode("Calle 9 de Junio 100 - Puente Piedra Central Telefónica : 219-6200 Anexo:6235"));
$pdf->ezText("                                                   EXPEDIENTE : " .$expe);
$pdf->ezText(utf8_decode("TIPO DE AUTORIZACIÓN MUNICIPAL : ".$tipo_au));
$pdf->ezText("DATOS DEL SOLICITANTE");
$pdf->ezText("DNI                   NOMBRE                                      R.U.C.              TELEFONO");
$pdf->ezText($dni."           ".$nombre."                                 ".$ruc."                 ".$telefono);
$pdf->ezText(utf8_decode("DIRECCIÓN                                                    DISTRITO                           PROVINCIA               DEPARTAMENTO"));
$pdf->ezText($nom_razon."                     ".$distrito."               ".$prov."                           ".$depa);
$pdf->ezText("DATOS DEL ESTABLECIMIENTO");
$pdf->ezText(utf8_decode("ESTABLECIMIENTO                         CONDICIÓN              TIPO                          AREA TOTAL"));
$pdf->ezText(utf8_decode($establecimiento."                           ".$condicion."                  ".$tipo."                          ".$area));
$pdf->ezText(utf8_decode("DIRECCIÓN                                         REFERENCIA"));
$pdf->ezText(utf8_decode($direstablecimiento."                                         ".$referencia));
$pdf->ezText(utf8_decode("SECTOR ECONÓMICO           MANIPULACIÓN DE COMBUSTIBLE/TÓXICOS INFLAMABLES              CAPACIDAD"));
$pdf->ezImage("./img/cancel.png",4,12,'center');
//$pdf->ezImage($impli_resultado["nTOXICO_SOL"]=='2' ? $img_tox = "/img/cancel.png" : $img_tox = "/img/confirmar.png",4,156,'center');
$pdf->ezText($sececono."                                                              ".$capa_foro);
$pdf->ezText(utf8_decode("CLASIFICACIÓN DE GIROS"));
$pdf->ezText(utf8_decode("GIRO                                  DETALLE                           ZONIFICACIÓN"));
$pdf->ezText(utf8_decode($descri_giro."                         ".$esp_giro."                           ".$descri_zona));
$pdf->ezText(utf8_decode("CLASIFICACIÓN DEL NEGOCIO     ".$grupo));

if($implane_num>0){
    $pdf->ezText(utf8_decode("DOCUMENTACIÓN QUE SE ASIGNA"));
    $pdf->ezText(utf8_decode($doc_asigna));
}

if($impli_resultado["ID_GRUPO"]=='1'){
    $pdf->ezText("CONDICIONES DE SEGURIDAD DE DEFENSA CIVIL");
    $pdf->ezText("DECLARO BAJO JURAMENTO ESTABLECIDO POR EL CUAL ESTOY SOLICITANDO ME OTORGUEN LICENCIA DE FUNCIONAMIENTO, CUENTA CON LAS CONDICIONES BASICAS DE INFRAESTRUCTURA Y EQUIPOS DE SEGURIDAD EN DEFENSA CIVIL");
    $pdf->ezText("I. CONDICIONES: ARQUITECTURA");
    $sql_conarq = "SELECT lic_obs_concepto.ID_CONCEP_OCO,
                    lic_obs_concepto.vDESC_OCO,
                    lic_obs_concepto.cCONDICI_OCO,
                    lic_concepto_seguridad.nVALOR_OCO
                FROM lic_obser_seguridad
                        INNER JOIN lic_concepto_seguridad 
                            ON lic_concepto_seguridad.ID_OBSERVA_OBS = lic_obser_seguridad.ID_OBSERVA_OBS
                    INNER JOIN lic_obs_concepto 
                        ON lic_concepto_seguridad.ID_CONCEP_OCO = lic_obs_concepto.ID_CONCEP_OCO
                        WHERE lic_obser_seguridad.ID_SOLICITUD_SOL = '$soli_sol' AND lic_obs_concepto.cCONDICI_OCO = '1';";
    $conarq_consulta = $db->consulta($sql_conarq);
    $conarq_resultado = $db->fetch_assoc($conarq_consulta);
    $conarq_num = $db->num_rows($conarq_consulta);
    $conarq_resultado["nVALOR_OCO"]=='1'? $valor3 = 'SI' : $valor3 = 'NO';
    $conq = $conarq_resultado["vDESC_OCO"];
    $pdf->ezText($conq."      ".$valor3);
    
    $pdf->ezText("II. CONDICIONES: ESTRUCTURAS");
    $sql_conest = "SELECT lic_obs_concepto.ID_CONCEP_OCO,
                    lic_obs_concepto.vDESC_OCO,
                    lic_obs_concepto.cCONDICI_OCO,
                    lic_concepto_seguridad.nVALOR_OCO
                FROM lic_obser_seguridad
                        INNER JOIN lic_concepto_seguridad 
                            ON lic_concepto_seguridad.ID_OBSERVA_OBS = lic_obser_seguridad.ID_OBSERVA_OBS
                    INNER JOIN lic_obs_concepto 
                        ON lic_concepto_seguridad.ID_CONCEP_OCO = lic_obs_concepto.ID_CONCEP_OCO
                        WHERE lic_obser_seguridad.ID_SOLICITUD_SOL = '$soli_sol' AND lic_obs_concepto.cCONDICI_OCO = '2';";
    $conest_consulta = $db->consulta($sql_conest);
    $conest_resultado = $db->fetch_assoc($conest_consulta);
    $conest_num = $db->num_rows($conest_consulta);
    $conest_resultado["nVALOR_OCO"]=='1'? $valor3 = 'SI' : $valor3 = 'NO';
    $condes = $conest_resultado["vDESC_OCO"];
    $pdf->ezText($condes."      ".$valor3);
    
    $pdf->ezText(utf8_decode("III. CONDICIONES: INSTALACIONES ELÉCTRICAS"));
    $sql_condins = "SELECT lic_obs_concepto.ID_CONCEP_OCO,
                    lic_obs_concepto.vDESC_OCO,
                    lic_obs_concepto.cCONDICI_OCO,
                    lic_concepto_seguridad.nVALOR_OCO
                FROM lic_obser_seguridad
                        INNER JOIN lic_concepto_seguridad 
                            ON lic_concepto_seguridad.ID_OBSERVA_OBS = lic_obser_seguridad.ID_OBSERVA_OBS
                    INNER JOIN lic_obs_concepto 
                        ON lic_concepto_seguridad.ID_CONCEP_OCO = lic_obs_concepto.ID_CONCEP_OCO
                        WHERE lic_obser_seguridad.ID_SOLICITUD_SOL = '$soli_sol' AND lic_obs_concepto.cCONDICI_OCO = '3';";
    $condins_consulta = $db->consulta($sql_condins);
    $condins_resultado = $db->fetch_assoc($condins_consulta);
    $condins_num = $db->num_rows($condins_consulta);
    $condins_resultado["nVALOR_OCO"]=='1'? $valor3 = 'SI' : $valor3 = 'NO';
    $condinse = $condins_resultado["vDESC_OCO"];
    $pdf->ezText($condinse."      ".$valor3);
    
    $pdf->ezText(utf8_decode("IV. CONDICIONES: SEGURIDAD Y PROTECCIÓN CONTRA INCENDIO"));
    $sql_condseg = "SELECT lic_obs_concepto.ID_CONCEP_OCO,
                    lic_obs_concepto.vDESC_OCO,
                    lic_obs_concepto.cCONDICI_OCO,
                    lic_concepto_seguridad.nVALOR_OCO
                FROM lic_obser_seguridad
                        INNER JOIN lic_concepto_seguridad 
                            ON lic_concepto_seguridad.ID_OBSERVA_OBS = lic_obser_seguridad.ID_OBSERVA_OBS
                    INNER JOIN lic_obs_concepto 
                        ON lic_concepto_seguridad.ID_CONCEP_OCO = lic_obs_concepto.ID_CONCEP_OCO
                        WHERE lic_obser_seguridad.ID_SOLICITUD_SOL = '$soli_sol' AND lic_obs_concepto.cCONDICI_OCO = '4';";
    $condseg_consulta = $db->consulta($sql_condseg);
    $condseg_resultado = $db->fetch_assoc($condseg_consulta);
    $condseg_num = $db->num_rows($condseg_consulta);
    $condseg_resultado["nVALOR_OCO"]=='1'? $valor3 = 'SI' : $valor3 = 'NO';
    $condseg = $conarq_resultado["vDESC_OCO"];
    $pdf->ezText($condseg."      ".$valor3);
}

if($obs){
    $pdf->ezText("OBSERVACION");
    $pdf->ezText(utf8_decode($obs));
}

$pdf->ezText("\n");
$pdf->ezText(utf8_decode("DECLARO BAJO JURAMENTO QUE LOS DATOS CONSIGNADOS EN LA PRESENTE SOLICITUD EXPRESAN LA VERDAD Y SOY RESPONSABLE DE LA VERACIDAD DE LOS DOCUMENTOS E INFORMACIÓN, EN VIRTUD AL PRINCIPIO DE PRESUNCIÓN DE VERACIDAD ESTIPULADA EN LA LEY DE PROCEDIMIENTOS ADMINISTRATIVOS GENERALES 27444, POR LO TANTO ME SUJETO A LA VERIFICACIÓN POSTERIOR POR PARTE DE LA GERENCIA DE FISCALIZACIÓN Y/O DEFENSA CIVIL DE LA MUNICIPALIDAD. EN CASO DE HABER PROPORCIONADO INFORMACIÓN, DOCUMENTOS Y/O DECLARACIONES QUE NO RESPONDAN A LA VERDAD, TENGO PLENO CONOCIMIENTO QUE SE ME PODRÁ APLICAR LAS SANCIONES ADMINISTRATIVAS Y/O INICIAR LAS ACCIONES PENALES CORRESPONDIENTES POR DELITO CONTRA LA ADMINISTRACIÓN PÚBLICA, REVOCÁNDOSE AUTOMÁTICAMENTE LAS AUTORIZACIONES QUE SE ME OTORGUEN COMO CONSECUENCIA DE ESTA SOLICITUD. ASIMISMO, ME COMPROMETO A BRINDAR LAS FACILIDADES NECESARIAS PARA LAS ACCIONES DE FISCALIZACIÓN Y CONTROL DE LAS AUTORIDADES COMPETENTES."));

$pdf->ezText("_______________________________________________");
$pdf->ezText("NOMBRE: ");
$pdf->ezText("DNI: ");

$pdf->ezStream();