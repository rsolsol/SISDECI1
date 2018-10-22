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
    $v_obser_defcvl_anular = $_POST['obser_defcvl_anular'];


    $sql ="insert into lic_defcvl_anular(id_solicitud_sol,obser_defcvl_anular,fecha_defcvl_anular,estado_defcvl_anular)
values('$sol','$v_obser_defcvl_anular',now(),1);";
    $modificar = $db ->consulta($sql);

//echo "<script language='javascript'>window.open('http://localhost:8080/proyecto1/licenciaEmpresarial.php?idregistro=$v_id_registro','_blank', 'scrollbars=yes,width=950,height=700');</script>";
//echo "<script language='javascript'>window.location=('http://localhost:8080/proyecto1/verdeseco.html')</script>";
echo "<script language='javascript'>alert('Registro correcto de la Ficha.')</script>";
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
                <img src="img/perfil1.jpg" alt="" class="perfil__foto">
            </figure>
            <h1 class="perfil__nombres">Roger Diaz Sol Sol</h1><br>
            <a href="verdeseco.html">Ver Desarrollo Economico</a><br>
            <a href="verdefcivil.html">Ver Defensa Civil</a><br>
        </div>
        <div class="informacion">
            <h2 class="informacion__titulo">Desarrollador Frontend</h2>
            <p class="informacion_descripcion">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga eveniet voluptatibus a, dolores quasi voluptate totam, sint sed minus saepe harum commodi tempore distinctio architecto corporis, unde fugiat tempora quis.</p>
            <ul class="habilidades">
                <li class="habilidad">html 5</li>
                <li class="habilidad">Css 3</li>
                <li class="habilidad">Python</li>
                <li class="habilidad">Django</li>
            </ul>
        </div>
    </section>
    <div class="registro">
    <section class="proyectos">
          <header class="proyecto__titulo">
           <h2>Ingrese la sustentacion para anular la Licencia</h2>
          </header>
       <form name="formulario" id="formulario" method="post" class="row" enctype="multipart/form-data">
          
           <div class="parte1">
               <label for="nombre1" hidden="hidden">Nombres:</label>
                <input type="text" name="nombre1" id="nombre1" placeholder="expediente" value="<?php echo $expediente; ?>" required disabled>
                <input type="text" name="nombre3" id="nombre3" placeholder="ruc" value="<?php echo $ruc; ?>" required disabled>
           </div>
                <label for="asunto" hidden="hidden">Razon Social:</label>
                <input type="text" name="asunto" id="asunto" value="<?php  echo utf8_decode($razon_social); ?>" disabled>
           <div class="domicilio">
               <label for="direc_predial" hidden="hidden">Area :</label>
                <input type="text" name="direc_predial" id="direc_predial" value="<?php echo $area." mts2 "; ?>" disabled>
        
           </div>
                <label for="impr_voucher" hidden="hidden">Descrip. Giro</label>
                <input type="text" name="asunto" id="asunto"value="<?php echo $desc_giro; ?>" disabled>
                <label for="observaciones" hidden="hidden">Direccion Local</label>
            <input type="text" name="asunto" id="asunto" value="<?php  echo $direccion; ?>" disabled>
            
            <div class="aprobacion">
                <label for="obser_defcvl_anular" hidden="hidden">Resolucion de Desar. Eco</label>
                <input type="text" name="obser_defcvl_anular" id="obser_defcvl_anular" placeholder="Ingrese la sustentación para anular Def. Civil" autofocus required>
            </div>
            <input type="submit" name="enviar" id="enviar" value="Aprobar solicitud">
       </form>
        </section>
    </div>
</body>
</html>
<?php // header("Location: ver_lic_def_civil.php"); ?>
