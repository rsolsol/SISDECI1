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
        </div>
        <!--<div class="informacion">
            <h2 class="informacion__titulo">Desarrollador Frontend</h2>
             <p class="informacion_descripcion">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga eveniet voluptatibus a, dolores quasi voluptate totam, sint sed minus saepe harum commodi tempore distinctio architecto corporis, unde fugiat tempora quis.</p>
            <ul class="habilidades">
                <li class="habilidad">html 5</li>
                <li class="habilidad">Css 3</li>
                <li class="habilidad">Python</li>
                <li class="habilidad">Django</li>
            </ul>
        </div>-->
    </section>
    <div class="registro">
        <section class="proyectos">
            <header class="proyecto__titulo">
                <h2>Seleccionar Expediente de Licencias para aprobar</h2>
            </header>
        <div class="visualizar">
            <?php
//fin de la rutina antigua para buscar licencias ingresadas//            
                require_once("clases/conexion.php");
                //instanciamos en $db la clase de conexcion
                $db= new MySQL();
                $sql ="SELECT lic_defensa_civl.id_solicitud_sol,lic_solicitud.ID_SOLICITUD_SOL,nNUMERO_EXP_SOL,vNOM_RAZON_SOL,dFECHA_INGRESO,estado_desaeco,estado_anulado  FROM lic_defensa_civl
INNER JOIN lic_solicitud ON lic_solicitud.ID_SOLICITUD_SOL=lic_defensa_civl.id_solicitud_sol
LEFT JOIN estado_desaeco ON estado_desaeco.id_solicitud_sol=lic_solicitud.id_solicitud_sol
WHERE not exists (SELECT * from lic_defensa_civl WHERE lic_defensa_civl.id_solicitud_sol=estado_desaeco.id_solicitud_sol)
and id_cest in('2') and right(nnumero_exp_sol,4) = '2016';";
                $result = $db->consulta($sql);
                $result_row = $db->fetch_assoc($result);
                $result_row_num = $db->num_rows($result);        
                                           
            //busca el giro de la licencia
            
            //fin de la busca el giro de la licencia
            ?>
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                    <td width="8%" align="center" bgcolor="#FFFF99"> Fecha </td>
                    <td width="10%" align="center" bgcolor="#FFFF99"># Expediente</td>
                    <td width="36%" align="center" bgcolor="#FFFF99">Empresa</td>
                    <td width="39%" align="center" bgcolor="#FFFF99">Giro</td>
                    <!--<td width="6%" align="center" bgcolor="#FFFF99">Zoni.</td>-->
                    <td colspan="3" width="15%" align="center" bgcolor="#FFFF99">Cert. Lic.</td>
                </tr>
                <?php
                
                if($result_row_num!=0)
                {
                    
                do{

                ?>

                <tr>
                    <?php 
                        $fechexpe = substr($result_row["dFECHA_INGRESO"], 8, 2) . '/' . substr($result_row["dFECHA_INGRESO"], 5, 2) . '/' . substr($result_row["dFECHA_INGRESO"], 0, 4);
                    ?>
                    
                    <td align="left" bgcolor="#E6E6E6"><?php echo $fechexpe." " ; ?></td>
                    <!-- quitar el - del expediente-->
                    <?php
                        $expe = explode("-",$result_row["nNUMERO_EXP_SOL"]);
                        $expediente = $expe[0] . '-' . substr($expe[1],0,4);
                    ?>
                    <!-- quitar el - del expediente-->
                    <td align="right" bgcolor="#E6E6E6"><?php echo " ".$expediente; ?></td>
                    <td align="center" bgcolor="#E6E6E6"><?php echo  utf8_encode($result_row['vNOM_RAZON_SOL']); ?></td>
                    <?php 
                     $id_solicitud = $result_row['ID_SOLICITUD_SOL'];
                    
                    //rutina que busca el giro del expediente mostrados en la menu
                    $db= new MySQL();
                    $sqlgiros = "SELECT lic_giro.vDESC_GIRO FROM lic_giro INNER JOIN lic_clasifica_giro ON lic_clasifica_giro.ID_GIRO = lic_giro.ID_GIRO WHERE lic_clasifica_giro.ID_SOLICITUD_SOL = $id_solicitud";
                    $result1 = $db->consulta($sqlgiros);
                    $result_row1 = $db->fetch_assoc($result1);
                    
                    ?>  
                    <td align="center" bgcolor="#E6E6E6"><?php echo $result_row1['vDESC_GIRO']; ?></td>
                    
                    <!--<td align="center" bgcolor="#E6E6E6"><strong><a href="ver_declaracion_pdf.php?nNUMERO_EXP_SOL=<?php  echo $expediente; ?>&ID_SOLICITUD_SOL=<?=$id_solicitud?>" target="_blank">Ver</a></strong></td> --> 
                    <td align="center" bgcolor="#E6E6E6"><strong>
                        <a href="aprobar_lic_de.php?nNUMERO_EXP_SOL=<?php  echo $expediente; ?>&ID_SOLICITUD_SOL=<?=$id_solicitud?>">Aprobado</a></strong></td>
                    <td align="center" bgcolor="#E6E6E6"><strong>
                        <a href="anular_lic.php?nNUMERO_EXP_SOL=<?php  echo $expediente; ?>&ID_SOLICITUD_SOL=<?=$id_solicitud?>&id_desa_eco=<?=$id_desa_eco?>">&nbsp;&nbsp;Improcedente</a></strong></td>
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