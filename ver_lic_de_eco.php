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

    </section>
    <div class="registro">
        <section class="proyectos">
            <header class="proyecto__titulo">
                <h2>Seleccionar Expediente de Licencias para aprobar</h2>
            </header>
        <div class="visualizar">
            <?php

              require_once("clases/conexion.php");
                //instanciamos en $db la clase de conexcion
                $db= new MySQL();
               
                $value = filter_input(INPUT_GET, 'pag');
           
  if(isset($value)){ 
   $pag =  filter_input(INPUT_GET, 'pag');   
} 

   else{ 
 $pag = 0; 
   } 
  $limite = 10;  
 $inicial = ($pag * $limite); 
 $resultados_mostrados = 0;  
 
 	  		

 $c = "select *
from lic_solicitud solicitud
left join lic_desa_econo desarrollo
on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
left join estado_desaeco estado
on solicitud.id_solicitud_sol = estado.id_solicitud_sol
where not exists (SELECT * from lic_defensa_civl WHERE estado.estado_anulado='1')
and solicitud.id_cest in('1') and right(solicitud.nnumero_exp_sol,4) = '2016'  GROUP BY solicitud.ID_SOLICITUD_SOL
ORDER BY solicitud.ID_SOLICITUD_SOL DESC";
 $r = $db->consulta($c);
 $rm = $db->num_rows($r);
 $total_paginas = ceil($rm / $limite); 	
 
   $sql = "select *
from lic_solicitud solicitud
left join lic_desa_econo desarrollo
on solicitud.id_solicitud_sol = desarrollo.id_solicitud_sol
left join estado_desaeco estado
on solicitud.id_solicitud_sol = estado.id_solicitud_sol
where not exists (SELECT * from lic_defensa_civl WHERE estado.estado_anulado='1')
and solicitud.id_cest in('1') and right(solicitud.nnumero_exp_sol,4) = '2016'  GROUP BY solicitud.ID_SOLICITUD_SOL
ORDER BY solicitud.ID_SOLICITUD_SOL DESC LIMIT $inicial,$limite"; 
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
                     $id_desa_eco = $result_row['id_desa_eco'];
                    
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
                        <a href="anular_lic.php?nNUMERO_EXP_SOL=<?php  echo $expediente; ?>&ID_SOLICITUD_SOL=<?=$id_solicitud?>&id_desa_eco=<?=$id_desa_eco?>">&nbsp;&nbsp;Anular</a></strong></td>
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
                    
                 <!--  //paginacion -->  
                                        
<?php

  
if (($pag - 1) >= 0) {
				echo "<a href='ver_lic_de_eco.php?pag=".($pag-1)."'>< Anterior</a>";
			} else {
				echo "<a href='#'>< Anterior</a>";
			}
 
			// Generamos el ciclo para mostrar la cantidad de paginas que tenemos.
			for ($i = 0; $i < $total_paginas; $i++) {
				if ($pag === $i) {
					echo "<a href='#'>". ($pag+1) ."</a>"; 
				} else {
					echo "<a href='ver_lic_de_eco.php?pag=$i'> ".($i+1)." </a> "; 
				}	
			}
 
	  		/**
	  		 * Igual que la opción primera de "< Anterior", pero acá para la opción "Siguiente >", si estamos en la ultima pagina no podremos
	  		 * utilizar esta opción.
	  		 */
			if (($pag)<$total_paginas-1) {
				echo "<a href='ver_lic_de_eco.php?pag=".($pag+1)."'>Siguiente ></a>";
			} else {
				echo "<a href='#'>Siguiente ></a>";
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
<?php 

?>