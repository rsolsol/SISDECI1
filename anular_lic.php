<?php
//insertamos la clase
require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

//recibimos los valores que nos envia el formulario
//recibimos el id del contacto que enviamos dese el archivo ver.php

$expe = $_GET['nNUMERO_EXP_SOL'];
$sol = $_GET['ID_SOLICITUD_SOL'];

$sqlregistro = "select  solicitud.id_solicitud_sol, 
        solicitud.nnumero_exp_sol,
		solicitud.id_tramite_ttr,
        tramite.vdesc_ttr,
        solicitud.ndni_rel,
        solicitud.vruc_sol,
		solicitud.vnom_rel, 
        solicitud.vnom_razon_sol,
        establecimiento.vdenodes_est,
        solicitud.vavda_sol,
        solicitud.nnumcasa_sol,
        solicitud.vmz_sol,
        solicitud.nlote_sol,
        establecimiento.narea_total_est,
        establecimiento.ncapac_est,
        giro.id_giro,
	    giro.vdesc_giro,
        clasifica_giro.de_espcfcion_giro
from lic_solicitud solicitud
inner join lic_establecimiento establecimiento
on solicitud.id_establec_est = establecimiento.id_establec_est
inner join lic_clasifica_giro  clasifica_giro
on  solicitud.id_solicitud_sol = clasifica_giro.id_solicitud_sol
inner join lic_giro giro
on clasifica_giro.id_giro = giro.id_giro
inner join lic_tipo_tramite tramite
on tramite.ID_TRAMITE_TTR = solicitud.ID_TRAMITE_TTR
where  solicitud.nnumero_exp_sol = '$expe' 
and  solicitud.id_solicitud_sol = '$sol';";
$result = $db->consulta($sqlregistro);
$result_row = $db->fetch_assoc($result);
$result_row_num = $db->num_rows($result);
if($result_row_num != 0)
{
$expediente = $result_row['nnumero_exp_sol'];
$ruc = $result_row['vruc_sol'];
//$nombre = $result_row['vnom_rel'];
$razon_social = $result_row['vnom_razon_sol'];
$area = $result_row['narea_total_est'];
//$capacidad = $result_row['ncapac_est'];
$desc_giro = $result_row['vdesc_giro'];
//$esp_giro = $result_row['de_espcfcion_giro'];
$deno_lo = $result_row['vdenodes_est'];
$av_local = $result_row['vavda_sol'];
$num_local = $result_row['nnumcasa_sol'];
$mz_local = $result_row['vmz_sol'];
$lote_local = $result_row['nlote_sol'];
$direccion =  $deno_lo." ".$av_local." # ".$num_local." MZ ".$mz_local." Lte.".$lote_local;
    
}

if (isset($_POST["enviar"]))
{
      
    $v_razon_social_desaeco = $_POST['razon_social_desaeco'];
    $v_direccion_desaeco = $_POST['direccion_desaeco'];
    $v_area_desaeco = $_POST['area_desaeco'];
    $v_giro_desaeco = $_POST['giro_desaeco'];
    $v_sector = $_POST['sector'];
    
    $sql ="insert into lic_desa_econo(id_solicitud_sol,razon_social_desaeco,direccion_desaeco,area_desaeco,giro_desaeco,fecha_des_eco,sector,estado_desa_eco)
           values('$sol',upper('$v_razon_social_desaeco'),upper('$v_direccion_desaeco'),'$v_area_desaeco',upper('$v_giro_desaeco'),now(),upper('$v_sector'),1);";
    $modificar = $db ->consulta($sql);
  
    $v_observacion_estado_desaeco = $_POST['obser_estado'];

    $sqlobs = "INSERT INTO estado_desaeco(id_solicitud_sol,obser_estado,fecha_desaeco,estado_desaeco,estado_anulado)
               values('$sol','$v_observacion_estado_desaeco',now(),1,1);";
    $resultado = $db ->consulta($sqlobs);

echo "<script language='javascript'>alert('Registro anulado correctamente.')</script>";
echo "<script language='javascript'>window.location=('http://192.168.2.77/sisdeci/ver_lic_de_eco.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portafolio</title>
    <link rel="stylesheet" href="css/vendor/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <!-- aqui pondremos el contenido html -->
</head>
<body>
    <section class="lateral">
        <div class="perfil">
            <figure class="perfil__circulo">
                <img src="img/perfil.png" alt="" class="perfil__foto">
            </figure>
            <h1 class="perfil__nombres">SISDECI</h1><br>
            <a class="botonera" href="verdeseco.html">Ver Desarrollo Economico</a><br>
            <a class="botonera" href="verdefcivil.html">Ver Defensa Civil</a><br>
        </div>
    </section>
    <div class="registro">
    <section class="proyectos">
          <header class="proyecto__titulo">
           <h2>Ingrese la sustentaci&oacute;n para anular el expediente</h2>
          </header>
       <form name="formulario" id="formulario" method="post" class="row" enctype="multipart/form-data">
          
           <div class="parte1">
               <label for="nombre1" hidden="hidden">Nombres:</label>
                <input type="text" name="nombre1" id="nombre1" placeholder="expediente" value="<?php echo $expediente; ?>" required disabled>
                <input type="text" name="nombre3" id="nombre3" placeholder="ruc" value="<?php echo $ruc; ?>" required disabled>
           </div>
                <label for="razon_social" hidden="hidden">Razon Social:</label>
                <input type="text" name="razon_social_desaeco" id="asunto" placeholder="Ingrese la Raz&oacute;n Social" value="<?php  echo utf8_decode($razon_social); ?>" required>
           <div class="domicilio">
               <label for="direc_predial" hidden="hidden">Area :</label>
                <input type="text" name="area_desaeco" id="direc_predial" placeholder="Ingrese el &Aacute;rea" value="<?php echo $area." mt2 "; ?>" required>
        
           </div>
                <label for="giros" hidden="hidden">Descrip. Giro</label>
                <input type="text" name="giro_desaeco" id="asunto" placeholder="Ingrese el Giro" value="<?php echo utf8_decode($desc_giro); ?>" required>
                <label for="observaciones" hidden="hidden">Direccion Local</label>
            <input type="text" name="direccion_desaeco" id="asunto" placeholder="Ingrese la Direcci&oacute;n del local" value="<?php  echo utf8_encode($direccion); ?>" required>
            
            <label for="sector_desaeco" hidden="hidden">Sector :</label>
            <input type="text" name="sector" id="asunto" placeholder="Ingrese el Sector" required>            

            <div class="aprobacion">
                <label for="observacion_estado_desaeco" hidden="hidden">Resolucion de Desar. Eco</label>
                <input type="text" name="obser_estado" id="observacion_estado_desaeco" placeholder="Ingrese la sustentaci&oacute;n para anular" autofocus required>
            </div>
            <div style="text-align: center; margin: 0 auto;">
                <input type="submit" name="enviar" id="enviar" value="Anular solicitud">
                <input type="submit" name="salir" id="salir" value="Salir" OnClick="window.location.href='verdeseco.html'">
       </form>
        </section>
    </div>
</body>
</html>
