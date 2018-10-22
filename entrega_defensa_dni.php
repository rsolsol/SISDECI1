<?php
//insertamos la clase
require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

//recibimos los valores que nos envia el formulario
//recibimos el id del contacto que enviamos dese el archivo ver.php

$cod_defcivl = $_GET['id_def_civl'];

$sqlregistro = "select solicitud.nnumero_exp_sol as expediente,
       civil.id_def_civl as cod_defcvl,
       civil.num_resol_defcvl as resol,
       substring(civil.fecha_defcvl,1,10) as fecha,
       civil.razon_social as razon_social,
       civil.direccion_defcvl as direccion,
       civil.area_defcvl as area,
       civil.capa_aforo_numero as aforonum,
       civil.capa_aforo_letra as aforole
from lic_solicitud solicitud
inner join lic_defensa_civl civil
on solicitud.id_solicitud_sol = civil.id_solicitud_sol
where civil.id_def_civl = '$cod_defcivl';";
$result = $db->consulta($sqlregistro);
$result_row = $db->fetch_assoc($result);
$result_row_num = $db->num_rows($result);
if($result_row_num != 0)
{
$expediente = $result_row['expediente'];
$resol = $result_row['resol'];
$direccion = $result_row['direccion'];
$razon_social = $result_row['razon_social'];   
$area = $result_row['area'];
$aforonum = $result_row['aforonum']; 
}

if (isset($_POST["enviar"]))
{
      
    $v_pers_recibe_certificado = $_POST['pers_recibe_certificado'];
    $v_dni_defcivl = $_POST['dni_defcivl'];

    $sql ="update lic_defensa_civl set pers_recibe_certificado = upper('$v_pers_recibe_certificado'),
           fecha_entrega = now() , dni_defcivl = '$v_dni_defcivl'
           where id_def_civl = '3';";
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
           <h2>Entrega del Certificado de ITSE</h2>
          </header>
       <form name="formulario" id="formulario" method="post" class="row" enctype="multipart/form-data">
          
           <div class="parte1">
               <label for="nombre1" hidden="hidden">Nombres:</label>
                <input type="text" name="nombre1" id="nombre1" value="<?php echo $expediente; ?>" disabled>
                <input type="text" name="nombre2" id="nombre2" value="<?php echo $resol; ?>" disabled>
                <input type="text" name="nombre3" id="nombre3" value=" Aforo :<?php echo utf8_decode($aforonum ); ?>" disabled>
           </div>
                <label for="razon_social" hidden="hidden">Razon Social:</label>
                <input type="text" name="razon_social_desaeco" id="asunto" value="Razon Social: <?php  echo utf8_decode($razon_social); ?>" disabled>
           <div class="domicilio">
               <label for="direc_predial" hidden="hidden">Direccion :</label>
                <input type="text" name="area_desaeco" id="direc_predial" value="<?php echo utf8_decode($direccion); ?>" disabled>
           </div>
            
            <label for="sector_desaeco" hidden="hidden">Nombres y Apellidos :</label>
            <input type="text" name="pers_recibe_certificado" id="asunto" placeholder="Ingrese el Nombre y Apellidos" required>            

            <div class="aprobacion">
                <label for="observacion_estado_desaeco" hidden="hidden">D.N.I.</label>
                <input type="text" name="dni_defcivl" id="observacion_estado_desaeco" placeholder="Ingrese su D.N.I." autofocus required>
            </div>
            <div style="text-align: center; margin: 0 auto;">
                <input type="submit" name="enviar" id="enviar" value="Anular solicitud">
                <input type="submit" name="salir" id="salir" value="Salir" OnClick="window.location.href='listado_licencia_aprobado.php'">
       </form>
        </section>
    </div>
</body>
</html>
