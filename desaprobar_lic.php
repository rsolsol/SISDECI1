<?php
//insertamos la clase
require_once("clases/conexion.php");

//creamos el objeto de base de datos y le colocamos $db
$db = new MySQL();

//recibimos los valores que nos envia el formulario
//recibimos el id del contacto que enviamos dese el archivo ver.php

$id_interno = $_GET['id_interno'];

$sqlregistro = "SELECT * FROM licencias_defcivl WHERE id_num_interno = $id_interno";
$result = $db->consulta($sqlregistro);
$result_row = $db->fetch_assoc($result);
$result_row_num = $db->num_rows($result);
if($result_row_num != 0)
{
$v_expediente = $result_row['id_expediente'];
$v_ano_exped = $result_row['ano_expediente'] ;
//$v_fech_ingreso = date("Y-m-d");
$v_asunto = $result_row['asunto'];
$v_giro = $result_row['id_giro'];
$v_grupo = $result_row['id_grupo'];
$v_direc_predial = $result_row['direccion_predial'];
$v_ref_domic = $result_row['referencia_domicilio'];
$v_voucher = $result_row['cod_voucher'];
$v_impr_voucher = $result_row['imp_voucher'];
$v_observacion_lic = $result_row['observacion_lic'];
$v_ruc = $result_row['id_ruc'];
$v_razon_social = $result_row['razon_social'];
$v_area = $result_row['area_local'];
$v_cap_max = $result_row['cap_max_per'];
$v_vigencia = $result_row['vigencia_lic'];
$v_arrendar = $result_row['id_arrendar'];
$v_direccion_predial = $result_row['direccion_predial'];
$v_img_voucher = $result_row['img_voucher'];
$v_img_solicitud = $result_row['img_solicitud'];
$v_imp_dec_jur = $result_row['imp_dec_jur'];
    
    //=======completa los datos del solicitante============
    $sqldatos = "SELECT * FROM datos_solicitante WHERE id_expediente = $v_expediente AND id_ano = $v_ano_exped ";
    $result1 = $db->consulta($sqldatos);
    $result_row1 = $db->fetch_assoc($result1);
    $result_row_num1 = $db->num_rows($result1);
    $v_id_dni = $result_row1['id_dni'];
    $v_nombre1 = $result_row1['nombre1'];
    $v_nombre2 = $result_row1['nombre2'];
    $v_nombre3 = $result_row1['nombre3'];
    $v_apel_pater = $result_row1['apellido_paterno'];
    $v_apel_mater = $result_row1['apellido_materno']; 
    //=======fin que completa los datos del solicitante=====
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
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
            <h1 class="perfil__nombres">Roger Diaz Sol Sol</h1>
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
           <h2>Ingrese la solicitud para la Licencia de Defenza Civil</h2>
          </header>
       <form action="ga_nolic_civil.php" name="formulario" id="formulario" method="post" class="row" enctype="multipart/form-data">
          
           <div class="parte1">
               <!--<label for="expediente">Número de Expediente:</label>-->
               <input type="text" name="idregistro" id="idregistro" value="<?php echo $id_interno; ?>" hidden="hidden">
                <input type="text" name="expediente" id="expediente"  maxlength="10" value="<?php echo $v_expediente; ?>" disabled>

               <!--<label for="dni">DNI:</label>-->
                <input type="text" name="dni" id="dni" value="<?php echo $v_id_dni; ?>"  disabled>
           </div>
           <div class="nombres">
               <label for="nombre1" hidden="hidden">Nombres:</label>
                <input type="text" name="nombre1" id="nombre1" value="<?php echo $v_nombre1;?>" disabled>
                <input type="text" name="nombre2" id="nombre2" value="<?php echo $v_nombre2;?>" disabled>
                <input type="text" name="nombre3" id="nombre3" value="<?php echo $v_nombre3;?>" disabled>
           </div>
           <div class="apellidos">
               <label for="apell_pater" hidden="hidden">Apellido Paterno:</label>
                <input type="text" name="apell_pater" id="apell_pater" value="<?php echo $v_apel_pater; ?>" disabled>

               <label for="apell_mater" hidden="hidden">Apellido Materno:</label>
                <input type="text" name="apell_mater" id="apell_mater" value="<?php echo $v_apel_mater; ?>" disabled>
            </div>
           <div class="empresa">
                <label for="ruc" hidden="hidden">Voucher:</label>
                <input type="text" name="ruc" id="ruc" value="<?php echo $v_ruc; ?>" disabled>

                <label for="razon_social" hidden="hidden">Importe del Voucher</label>
                <input type="text" name="razon_social" id="razon_social" value="<?php echo $v_razon_social; ?>" disabled >
           </div>          
               <label for="asunto" hidden="hidden">Asunto:</label>
                <input type="text" name="asunto" id="asunto" value="<?php echo $v_asunto; ?>" disabled>
            
           <div class="giros_grupos">
               <?php 
                    require_once("clases/conexion.php");
                    $db = new MySQL();
                    $sqlgiros = "SELECT * FROM giro WHERE id_giro = $v_giro";
                    $result2 = $db->consulta($sqlgiros);
                    $result_row2 = $db->fetch_assoc($result2);
                    $result_row_num2 = $db->num_rows($result2);
                    $v_descripcion_giro = $result_row2['vdesc_giro'];
               ?>              
               <input type="text" name="giros" id="giros" value="<?php echo  utf8_encode($v_descripcion_giro); ?>" disabled>

              <?php 
                 //   require_once("clases/conexion.php");
                    $db = new MySQL();
                    $sqlgrupos = "SELECT * FROM grupo WHERE id_grupo = $v_grupo";
                    $result3 = $db->consulta($sqlgrupos);
                    $result_row3 = $db->fetch_assoc($result3);
                    $result_row_num3 = $db->num_rows($result3);
                    $v_descripcion_giro = $result_row3['descripcion_grupo'];
               ?>    
               <input type="text" name="grupo" id="grupo" value="<?php echo utf8_encode($v_descripcion_giro); ?>" disabled>
               
           </div>
           <div class="domicilio">
               <label for="direc_predial" hidden="hidden">Direccion Predial:</label>
                <input type="text" name="direc_predial" id="direc_predial" value="<?php echo $v_direc_predial; ?>" disabled>
        
               <label for="referencia_domicilio" hidden="hidden">Referencias:</label>
                <input type="text" name="referencia_domicilio" id="referencia_domicilio" value="<?php echo $v_ref_domic; ?>" disabled >
           </div>
           
           <div class="datos_domic">
            <div class="col1">
               <label for="area" hidden="hidden"></label>
               <input type="text" name="area" id="area" value="<?php echo $v_area; ?> mt" disabled>
               
               <label for="cap_max" hidden="hidden"></label>
               <input type="text" name="cap_max" id="cap_max" value="<?php echo $v_cap_max; ?> personas" disabled>
            </div>
            <div class="col2">
                <?php 
                    require_once("clases/conexion.php");
                    $db = new MySQL();
                    $sqlvigencia = "SELECT * FROM tpo_vigencia WHERE id_vigencia = $v_vigencia";
                    $result4 = $db->consulta($sqlvigencia);
                    $result_row4 = $db->fetch_assoc($result4);
                    $result_row_num4 = $db->num_rows($result4);
                    $v_desc_vigencia = $result_row4['desc_vigencia'];
               ?> 
              <input type="text" name="vigencia" id="vigencia" value="<?php echo $v_desc_vigencia;?>" disabled >
                           
              <?php 
                    require_once("clases/conexion.php");
                    $db = new MySQL();
                    $sqlarrendar = "SELECT * FROM arrendar WHERE id_arrendar = $v_arrendar";
                    $result5 = $db->consulta($sqlarrendar);
                    $result_row5 = $db->fetch_assoc($result5);
                    $result_row_num5 = $db->num_rows($result5);
                    $v_detalle_arrendar = $result_row5['detalle_arrendar'];
               ?> 
               <input type="text" name="arrendar" id="arrendar" value="<?php echo $v_detalle_arrendar;?>" disabled>  
            </div>    
           </div>
           
           <div class="vouchers">
                <label for="voucher" hidden="hidden">Voucher:</label>
                <input type="text" name="voucher" id="voucher" value="<?php echo $v_voucher; ?>" disabled>

                <label for="impr_voucher" hidden="hidden">Importe del Voucher</label>
                <input type="text" name="impr_voucher" id="impr_voucher" value="<?php echo $v_impr_voucher; ?>" disabled>
           </div>
           <label for="observaciones" hidden="hidden">Observaciones</label>
            <input type="text" name="observaciones" id="observaciones" value="<?php echo $v_observacion_lic; ?>" disabled>
            
            <label for="arch_voucher" hidden="hidden">Adjuntar Voucher:</label>
            <input type="text" name="arch_voucher" id="arch_voucher" value="<?php echo $v_img_voucher; ?>" disabled >
            
            <label for="arch_solicitud" hidden="hidden">Adjuntar Solicitud:</label>
            <input type="text" name="arch_solicitud" id="arch_solicitud" value="<?php echo $v_img_solicitud; ?>" disabled>
            
            <label for="arch_dec_jur" hidden="hidden">Adjuntar Declaración Jurada</label>
            <input type="text" name="arch_dec_jur" id="arch_dec_jur" value="<?php echo $v_imp_dec_jur; ?>" disabled>
            
            <div class="Desaprobacion">
                <label for="det_noacepta_DC" hidden="hidden">Detalles x que no procede</label>
                <input type="text" name="det_noacepta_DC" id="det_noacepta_DC" placeholder="Ingrese los detalles porque no procede" autofocus required>
               
            </div>
            <input type="submit" id="enviar" value="Aprobar solicitud">
       </form>
        </section>
    </div>
</body>
</html>