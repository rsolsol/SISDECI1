<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Portafolio</title>
    <link rel="stylesheet" href="css/vendor/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/component1.css" /><!--incluido para el menu -->
    <script src="js/modernizr-2.6.2.min.js"></script><!--incluido para el menu -->
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
            <a class="botonera" href="listado_licencia_aprobado.php">Licencias por Entregar</a><br>
        </div>
    </section>
    <div class="registro">
        <section class="proyectos">
            <header class="proyecto__titulo">
                <h2>Entrega de Licencia al Administrado</h2>
            </header>
        <div class="visualizar">
            <?php
//fin de la rutina antigua para buscar licencias ingresadas//            
                require_once("clases/conexion.php");
                //instanciamos en $db la clase de conexcion
                $db= new MySQL();
                $sql ="select solicitud.nnumero_exp_sol as expediente,
	               desarrollo.id_desa_eco as cod_licencia,
                       desarrollo.lic_desa_eco as licencia,
                       desarrollo.res_deseco as resolucion,
                       substring(desarrollo.fecha_des_eco,1,10) as fecha,
                       desarrollo.razon_social_desaeco as razon_social,
                       desarrollo.giro_desaeco as giro,
                       (case solicitud.id_condicloc_clo when '1' then 'GRUPO 1' 
                       WHEN '2' THEN 'GRUPO 2' WHEN '3' THEN 'GRUPO 3' END) AS nro_grupo
                       from lic_solicitud solicitud
                       inner join lic_desa_econo desarrollo
                       on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
                       inner join estado_desaeco estado
                       on desarrollo.id_solicitud_sol = estado.id_solicitud_sol 
                       where not exists (select * from lic_defensa_civl where estado.estado_anulado = '1')
                       and desarrollo.dni_desaeco is null;";
                $result = $db->consulta($sql);
                $result_row = $db->fetch_assoc($result);
                $result_row_num = $db->num_rows($result);        
                                           
            //busca el giro de la licencia
            
            //fin de la busca el giro de la licencia
            ?>
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                    <td width="10%" align="center" bgcolor="#FFFF99"># Expediente</td>
                    <td width="10%" align="center" bgcolor="#FFFF99"># Licencia</td>
                    <td width="10%" align="center" bgcolor="#FFFF99"># Resol</td>
                    <td width="10%" align="center" bgcolor="#FFFF99">Fecha</td>
                    <td width="36%" align="center" bgcolor="#FFFF99">Razon Social</td>
                    <td width="6%" align="center" bgcolor="#FFFF99">Giro</td>
                    <td width="15%" align="center" bgcolor="#FFFF99">GRUPO</td>
                    <td colspan="15" width="15%" align="center" bgcolor="#FFFF99">Entrega Lic.</td>
                </tr>
                <?php
                
                if($result_row_num!=0)
                {
                    
                do{

                ?>

                <tr>
                    <?php 
                        $expediente = $result_row["expediente"];
                        $cod_licencia = $result_row["cod_licencia"];
                        $licencia = $result_row["licencia"];
                        $resolucion = $result_row["resolucion"];
                        $fecha = substr($result_row["fecha"], 8, 2) . '/' . substr($result_row["fecha"], 5, 2) . '/' . substr($result_row["fecha"], 0, 4);
                        $razon_social = $result_row["razon_social"];
                        $giro = $result_row["giro"];
                        $nro_grupo = $result_row["nro_grupo"];
                    ?>
                    
                    <td align="center" bgcolor="#E6E6E6"><?=$expediente?></td>
                    <td align="right" bgcolor="#E6E6E6"><?php echo $licencia; ?></td>
                    <td align="center" bgcolor="#E6E6E6"><?php echo  $resolucion; ?></td>
                    <td align="center" bgcolor="#E6E6E6"><?php echo $fecha; ?></td>
                    <td align="center" bgcolor="#E6E6E6"><?=$razon_social?></td>
                    <td align="center" bgcolor="#E6E6E6"><?=$giro?></td>
                    <td align="center" bgcolor="#E6E6E6"><?=$nro_grupo?></td>
                    <td align="center" bgcolor="#E6E6E6"><a href="entrega_licencia_dni.php?id_desa_eco=<?=$cod_licencia?>">Licencia</a></td>
                </tr>
                <?php
                }
                    while($result_row = $db->fetch_assoc($result));
                }
                else
                {
                ?>
                    <tr>
                       <td colspan="6" align="center" bgcolor="#E6E6E6">NO EXISTE NINGUN REGISTRO EN LA BASE DE DATOS</td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        </section>

         <div class="component">

            <!-- Start Nav Structure -->
				<button class="cn-button" id="cn-button">+</button>
				<div class="cn-wrapper" id="cn-wrapper">
				    <ul>
				      <li><a href="ver_lic_de_eco.php?id_menu=1">Expost</a></li>
				      <li><a href="ver_licencia_desaeco.php?id_menu=2">Exante</a></li>
				      <li><a href="ver_licencia_detalic.php?id_menu=3">Detalle</a></li>
				     </ul>
				</div>
				<div id="cn-overlay" class="cn-overlay"></div>
				<!-- End Nav Structure -->
            
        </div>
    </div>
    <!-- /container -->
		<script src="js/polyfills.js"></script>
		<script src="js/demo1.js"></script>
    <!-- For the demo ad only -->  
</body>
</html>