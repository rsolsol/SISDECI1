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
        (case solicitud.id_condicloc_clo when '1' then 'GRUPO 1' 
        WHEN '2' THEN 'GRUPO 2' WHEN '3' THEN 'GRUPO 3' END) AS nro_grupo,
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
$nro_grupo = $result_row['nro_grupo'];
}

if (isset($_POST["enviar"]))
{
    // esto es para el grabado de la tabla nombre_inspector
    $v_nominsp_defcvl = $_POST['nominsp_defcvl'];
    $v_sigla_defcvl = $_POST['sigla_defcvl']; 
    $sql_nominsp ="insert into nombre_inspector(nominsp_defcvl,sigla_defcvl,fecha_nominsp,estado_nominsp)
           values(upper('$v_nominsp_defcvl'),upper('$v_sigla_defcvl'),now(),1);";
    $modificar = $db ->consulta($sql_nominsp);
    $nombre_inspector = $db->id_ultimo();     
    
    //grabado de la tabla lic_defensa_civl
    $v_num_resol_defcvl = $_POST['num_resol_defcvl']; 
    $v_num_cart_defcvl = $_POST['num_cart_defcvl'];
    $v_razon_social = $_POST['razon_social'];
    $v_direccion_defcvl = $_POST['direccion_defcvl'];
    $v_area_defcvl = $_POST['area_defcvl'];
    $v_capa_aforo_numero = $_POST['capa_aforo_numero'];
    $v_capa_aforo_letra = $_POST['capa_aforo_letra'];
    $v_nro_memo = $_POST['nro_memo'];
    $sql ="insert into lic_defensa_civl(id_solicitud_sol,num_resol_defcvl,num_cart_defcvl,razon_social,direccion_defcvl,area_defcvl,capa_aforo_numero,capa_aforo_letra,fecha_defcvl,estado_defencvl,nro_memo)
           values('$sol','$v_num_resol_defcvl','$v_num_cart_defcvl',upper('$v_razon_social'),upper('$v_direccion_defcvl'),'$v_area_defcvl','$v_capa_aforo_numero',upper('$v_capa_aforo_letra'),now(),1,'$v_nro_memo');";
    $modificar = $db ->consulta($sql); 
    $cert_defcv = $db->id_ultimo();
    
    //grabado de la tabla estado_defcvl
    $v_infotecnico = $_POST['infotecnico'];
    $sqlobs = "insert into estado_defcvl(id_def_civl,infotecnico,id_nombre_inspector,fecha_defcvl,estado_obs_defcvl)
               values('$cert_defcv','$v_infotecnico','$nombre_inspector',now(),1); ";
    $resultado = $db ->consulta($sqlobs);


echo "<script language='javascript'>window.open('http://192.168.2.77/sisdeci/licenciaDefensaCivil.php?id_solicitud_sol=$sol','_blank', 'scrollbars=yes,width=950,height=700');</script>";
echo "<script language='javascript'>window.location=('http://192.168.2.77/sisdeci/verdefcivil.html')</script>";
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
</head>
<script>
    //scrip para validar los numero de las resoluciones o licencias//
      function validarSiNumero(numero){
        if (!/^([0-9]{4,4}[-. ]?[0-9]{4,4})*$/.test(numero))
          alert("El valor " + numero + " no es un valor autorizado; Verifique el valor ingresado ");
      }
      function validarNumero(numero){
        if (!/^([0-9])*$/.test(numero))
          alert("El valor " + numero + " no es un valor autorizado; Verifique el valor ingresado ");
      }
</script>
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
           <h2>Ingrese la solicitud para el Certificado de  Licencia</h2>
          </header>
       <form name="formulario" id="formulario" method="post" class="row" enctype="multipart/form-data">
          
           <div class="parte1">
               <label for="nombre1" hidden="hidden">Nombres:</label>
                <input type="text" name="nombre1" id="nombre1" placeholder="expediente" value="<?php echo $expediente; ?>" required disabled>
                <input type="text" name="nombre3" id="nombre3" placeholder="ruc" value="<?php echo $ruc; ?>" required disabled>
           </div>
                <label for="razon_social" hidden="hidden">Razon Social:</label>
                <input type="text" name="razon_social" id="asunto" placeholder="Ingrese la Raz&oacute;n Social" value="<?=$razon_social?>" required>
           
                <label for="area_defcvl" hidden="hidden">Area :</label>
                <input type="text" name="area_defcvl" id="nombre1" placeholder="Ingrese el &Aacute;rea del establecimiento" value="<?=$area?>" required>
 
                <label for="giro" hidden="hidden">Descrip. Giro</label>
                <input type="text" name="giros" id="giros"value="<?php echo utf8_encode($desc_giro); ?>" disabled>

                <label for="giro" hidden="hidden">Descrip. Giro</label>
                <input type="text" name="giros" id="giros"value="<?php echo utf8_encode($nro_grupo); ?>" disabled>
                
                <label for="direccion_defcvl" hidden="hidden">Direccion Local</label>
                <input type="text" name="direccion_defcvl" id="asunto" placeholder="Ingrese la Direcci&oacute;n del establecimiento" value="<?=utf8_encode($direccion)?>" required> 
             <div class="aforo">
                <label for="capa_aforo_numero"></label>
                <input type="text" name="capa_aforo_numero" id="capa_aforo_numero" placeholder="Capacidad de Aforo de n&uacute;meros" required onChange="validarNumero(this.value);" maxlength="6">
                
                <label for="capa_aforo_letra"></label>
                <input type="text" name="capa_aforo_letra" id="capa_aforo_letra" placeholder="Capacidad de Aforo en letras" required>
             </div>
            <div class="inspector">
                <label for="nominsp_defcvl"></label>
                <input type="text" name="nominsp_defcvl" id="nominsp_defcvl" placeholder="Ingrese el Nombre del encargado de Inspecci&oacute;n T&eacute;cnico " required>

                <label for="sigla_defcvl"></label>
                <input type="text" name="sigla_defcvl" id="sigla_defcvl" placeholder="Ingrese las siglas del encargado de Inspecci&oacute;n" required>
             </div>   
            <div class="aprobacion">
                <label for="num_cart_des"></label>
                <input type="text" name="num_resol_defcvl" id="asunto" placeholder="Ingrese el N&uacute;mero de Resol. Def. Civil." required onChange="validarSiNumero(this.value);" maxlength="9">

                <label for="num_cart_des"></label>
                <input type="text" name="infotecnico" id="asunto" placeholder="Ingrese el N&uacute;mero de informe T&eacute;cnico." required onChange="validarNumero(this.value);" maxlength="6">
                
                <label for="lic_desa_eco"></label>
                <input type="text" name="num_cart_defcvl" id="num_cart_defcvl" placeholder="Ingrese el N&uacute;mero de carton Def. Civil." required onChange="validarSiNumero(this.value);" maxlength="9">

                <label for="lic_desa_eco"></label>
                <input type="text" name="nro_memo" id="num_cart_defcvl" placeholder="Ingrese el N&uacute;mero de Memorandum." required maxlength="9">

            </div>               
           <div style="text-align: center; margin: 0 auto;">
                <input type="submit" name="enviar" id="enviar" value="Aprobar solicitud">
                <input type="submit" name="salir" id="salir" value="Salir" OnClick="window.location.href='verdefcivil.html'">
           </div>
       </form>
        </section>
    </div>
</body>
</html>
