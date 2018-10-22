<?php
//insertamos la clase
require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

//recibimos los valores que nos envia el formulario
//recibimos el id del contacto que enviamos dese el archivo ver.php

$cod_licencia = $_GET['id_desa_eco'];

$sqlregistro = "select solicitud.nnumero_exp_sol as expediente,
	   desarrollo.id_desa_eco as cod_licencia,
       desarrollo.lic_desa_eco as licencia,
       desarrollo.res_deseco as resolucion,
       substring(desarrollo.fecha_des_eco,1,10) as fecha,
       desarrollo.razon_social_desaeco as razon_social,
	   solicitud.vruc_sol as ruc,
       desarrollo.giro_desaeco as giro,
       (case solicitud.id_condicloc_clo when '1' then 'GRUPO 1' 
       WHEN '2' THEN 'GRUPO 2' WHEN '3' THEN 'GRUPO 3' END) AS nro_grupo
from lic_solicitud solicitud
inner join lic_desa_econo desarrollo
on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
inner join estado_desaeco estado
on desarrollo.id_solicitud_sol = estado.id_solicitud_sol 
where desarrollo.id_desa_eco = '$cod_licencia';";
$result = $db->consulta($sqlregistro);
$result_row = $db->fetch_assoc($result);
$result_row_num = $db->num_rows($result);
if($result_row_num != 0)
{
$expediente = $result_row['expediente'];
$ruc = $result_row['ruc'];
$licencia = $result_row['licencia'];
$razon_social = $result_row['razon_social'];   
$giro = $result_row['giro']; 
}

if (isset($_POST["enviar"]))
{
      
    $v_persona_recepc_desaeco = $_POST['persona_recepc_desaeco'];
    $v_dni_desaeco = $_POST['dni_desaeco'];

    $sql ="update lic_desa_econo set persona_recepc_desaeco = upper('$v_persona_recepc_desaeco') , 
           dni_desaeco = '$v_dni_desaeco' , fecha_entrega_desaeco = now()
           where id_desa_eco = '$cod_licencia';";
    $modificar = $db ->consulta($sql);

echo "<script language='javascript'>alert('Recepción correcta.')</script>";
echo "<script language='javascript'>window.location=('http://192.168.2.77/sisdeci/index.php')</script>";

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
                <input type="text" name="nombre1" id="nombre1" value="<?php echo $expediente; ?>" disabled>
                <input type="text" name="nombre3" id="nombre3" value="<?php echo $ruc; ?>" disabled>
                <input type="text" name="nombre3" id="nombre3" value="<?php echo $licencia; ?>" disabled>
           </div>
                <label for="razon_social" hidden="hidden">Razon Social:</label>
                <input type="text" name="razon_social_desaeco" id="asunto" value="<?php  echo utf8_decode($razon_social); ?>" disabled>
           <div class="domicilio">
               <label for="direc_predial" hidden="hidden">Giro :</label>
                <input type="text" name="area_desaeco" id="direc_predial" value="<?php echo utf8_decode($giro); ?>" disabled>
           </div>
            
            <label for="sector_desaeco" hidden="hidden">Nombres y Apellidos :</label>
            <input type="text" name="persona_recepc_desaeco" id="asunto" placeholder="Ingrese el Nombre y Apellidos" required>            

            <div class="aprobacion">
                <label for="observacion_estado_desaeco" hidden="hidden">D.N.I.</label>
                <input type="text" name="dni_desaeco" id="observacion_estado_desaeco" placeholder="Ingrese su D.N.I." autofocus required>
            </div>
            <div style="text-align: center; margin: 0 auto;">
                <input type="submit" name="enviar" id="enviar" value="Anular solicitud">
                <input type="submit" name="salir" id="salir" value="Salir" OnClick="window.location.href='listado_licencia_aprobado.php'">
       </form>
        </section>
    </div>
</body>
</html>
