<?php
/** Include path **/
ini_set('include_path', ini_get('include_path').';Classes/');

include './excel/Classes/PHPExcel.php';
include './excel/Classes/PHPExcel/Writer/Excel2007.php';
include './script_licemp_web.php';

// Creando nuevo objeto
$objPHPExcel = new PHPExcel();

// Propiedades
$objPHPExcel->getProperties()->setCreator("Jaime Farfan");
$objPHPExcel->getProperties()->setLastModifiedBy("Jaime Farfan");
$objPHPExcel->getProperties()->setTitle("Lista de Productos");
$objPHPExcel->getProperties()->setSubject("Lista de productos por categorias de Enero");
$objPHPExcel->getProperties()->setDescription("Ejemplo desarrollado con PHPExcel.");


// Agregando datos
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Computador');

$objPHPExcel->getActiveSheet()->SetCellValue('A1', utf8_encode('N° EXPEDIENTE'));
$objPHPExcel->getActiveSheet()->SetCellValue('B1', utf8_encode('N° LICENCIA'));
$objPHPExcel->getActiveSheet()->SetCellValue('C1', utf8_encode('N° RESOL'));
$objPHPExcel->getActiveSheet()->setCellValue('D1','FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('E1','RAZON SOCIAL');
$objPHPExcel->getActiveSheet()->setCellValue('F1','GIRO');
$objPHPExcel->getActiveSheet()->setCellValue('G1',utf8_encode('UBICACIÓN'));
$objPHPExcel->getActiveSheet()->setCellValue('H1','GRUPO');
$objPHPExcel->getActiveSheet()->setCellValue('I1',utf8_encode('ÁREA DEL LOCAL(M2)'));
$objPHPExcel->getActiveSheet()->setCellValue('J1','RUC');
$objPHPExcel->getActiveSheet()->setCellValue('K1',utf8_encode('OBSERVACIÓN'));

$indice = 2;
foreach ($lista as $registro) {
    $objPHPExcel->getActiveSheet()->SetCellValue("A$indice", $registro->expediente);
    $objPHPExcel->getActiveSheet()->SetCellValue("B$indice", $registro->licencia);
    $objPHPExcel->getActiveSheet()->SetCellValue("C$indice", $registro->resolucion);
    $objPHPExcel->getActiveSheet()->setCellValue("D$indice", $registro->fecha);
    $objPHPExcel->getActiveSheet()->setCellValue("E$indice", $registro->razon_social);
    $objPHPExcel->getActiveSheet()->setCellValue("F$indice", $registro->giro);
    $objPHPExcel->getActiveSheet()->setCellValue("G$indice", $registro->direccion);
    $objPHPExcel->getActiveSheet()->setCellValue("H$indice", $registro->nro_grupo);
    $objPHPExcel->getActiveSheet()->setCellValue("I$indice", $registro->area);
    $objPHPExcel->getActiveSheet()->setCellValue("J$indice", $registro->ruc);
    $objPHPExcel->getActiveSheet()->setCellValue("K$indice", $registro->observacion);

    $indice++;
}

//Formato
$headStyle = $objPHPExcel->getActiveSheet()->getStyle('A1:K1');
$headStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
$headStyle->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$headStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$headStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

$numberStyle = $objPHPExcel->getActiveSheet()->getStyle('C2:C3');
$numberStyle->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

//Ancho de columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(32);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

// Guardar Excel 2007 
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_web_licemp.xlsx");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",FALSE);
$objWriter->save('php://output');
?>
