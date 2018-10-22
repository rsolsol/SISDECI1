<?php
/** Include path **/
ini_set('include_path', ini_get('include_path').';Classes/');

include './excel/Classes/PHPExcel.php';
include './excel/Classes/PHPExcel/Writer/Excel2007.php';
include './script_excel_defcivl_completo.php';

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
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ANIO EXPEDIENTE');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'GIRO');
$objPHPExcel->getActiveSheet()->setCellValue('D1','TIPO DE INSPECION');
$objPHPExcel->getActiveSheet()->setCellValue('E1','FECHA DE INGRESO DE LA SOLICITUD(EXPED.)');
$objPHPExcel->getActiveSheet()->setCellValue('F1','RESULTADO DE LA SOLICITUD(APROBADO/DESAPROBADO)');
$objPHPExcel->getActiveSheet()->setCellValue('G1',utf8_encode('N° RESOLUCION'));
$objPHPExcel->getActiveSheet()->setCellValue('H1','FECHA DE RESOLUCION');
$objPHPExcel->getActiveSheet()->setCellValue('I1','CERTIFICADO');
$objPHPExcel->getActiveSheet()->setCellValue('J1','ANIO CERTIFICADO');
$objPHPExcel->getActiveSheet()->setCellValue('K1','VIGENCIA DE LA RESOLUCION');
$objPHPExcel->getActiveSheet()->setCellValue('L1','AREA(M2)');
$objPHPExcel->getActiveSheet()->setCellValue('M1','NOMBRE/RAZON SOCIAL');
$objPHPExcel->getActiveSheet()->setCellValue('N1','DIRECCION');
$objPHPExcel->getActiveSheet()->setCellValue('O1','TIPO DE ESTABLECIMIENTO');
$objPHPExcel->getActiveSheet()->setCellValue('P1',utf8_encode('N° GRUPO'));
$objPHPExcel->getActiveSheet()->setCellValue('Q1','AFORO');
$objPHPExcel->getActiveSheet()->setCellValue('R1','AFORO EN LETRAS');
$objPHPExcel->getActiveSheet()->setCellValue('S1','INFORME TECNICO');
$objPHPExcel->getActiveSheet()->setCellValue('T1','N° INFORME/ACTA');
$objPHPExcel->getActiveSheet()->setCellValue('U1','NOMBRE DEL INSPECTOR');
$objPHPExcel->getActiveSheet()->setCellValue('V1','SIGLAS INSPECTOR');
$objPHPExcel->getActiveSheet()->setCellValue('W1','IMPROCEDENTE MOTIVO');
$objPHPExcel->getActiveSheet()->setCellValue('X1','CERTIFICADO ENTREGADO AS SR/SRA');
$objPHPExcel->getActiveSheet()->setCellValue('Y1','FECHA DE ENTREGA');
$objPHPExcel->getActiveSheet()->setCellValue('Z1','MEMORANDUM');


$indice = 2;
foreach ($lista as $registro) {
    $objPHPExcel->getActiveSheet()->SetCellValue("A$indice", $registro->nnumero_exp_sol);
    $objPHPExcel->getActiveSheet()->SetCellValue("B$indice", $registro->dia);
    $objPHPExcel->getActiveSheet()->SetCellValue("C$indice", $registro->vdesc_giro);
    $objPHPExcel->getActiveSheet()->setCellValue("D$indice", $registro->tipo_establecimiento);
    $objPHPExcel->getActiveSheet()->setCellValue("E$indice", $registro->dfecha_ingreso);
    $objPHPExcel->getActiveSheet()->setCellValue("F$indice", $registro->estado);
    $objPHPExcel->getActiveSheet()->setCellValue("G$indice", $registro->num_resol_defcvl);
    $objPHPExcel->getActiveSheet()->setCellValue("H$indice", $registro->fecha_defcvl);
    $objPHPExcel->getActiveSheet()->setCellValue("I$indice", $registro->certificado);
    $objPHPExcel->getActiveSheet()->setCellValue("J$indice", $registro->año_cert);
    $objPHPExcel->getActiveSheet()->setCellValue("K$indice", $registro->vigencia);
    $objPHPExcel->getActiveSheet()->setCellValue("L$indice", $registro->area);
    $objPHPExcel->getActiveSheet()->setCellValue("M$indice", $registro->razon_social);
    $objPHPExcel->getActiveSheet()->setCellValue("N$indice", $registro->direccion);
    $objPHPExcel->getActiveSheet()->setCellValue("O$indice", $registro->vdesc_aeo);
    $objPHPExcel->getActiveSheet()->setCellValue("P$indice", $registro->nro_grupo);
    $objPHPExcel->getActiveSheet()->setCellValue("Q$indice", $registro->aforo);
    $objPHPExcel->getActiveSheet()->setCellValue("R$indice", $registro->aforo_letra);
    $objPHPExcel->getActiveSheet()->setCellValue("S$indice", $registro->info_tecnico);
    $objPHPExcel->getActiveSheet()->setCellValue("T$indice", $registro->info_acta);
    $objPHPExcel->getActiveSheet()->setCellValue("U$indice", $registro->nombre_inspector);
    $objPHPExcel->getActiveSheet()->setCellValue("V$indice", $registro->sigla_inspector);
    $objPHPExcel->getActiveSheet()->setCellValue("W$indice", $registro->observacion);
    $objPHPExcel->getActiveSheet()->setCellValue("X$indice", $registro->persona_certificado);
    $objPHPExcel->getActiveSheet()->setCellValue("Y$indice", $registro->fecha_entrega);
    $objPHPExcel->getActiveSheet()->setCellValue("Z$indice", $registro->nro_memo);

    $indice++;
}

//Formato
$headStyle = $objPHPExcel->getActiveSheet()->getStyle('A1:Z1');
$headStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
$headStyle->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$headStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$headStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

$numberStyle = $objPHPExcel->getActiveSheet()->getStyle('C2:C3');
$numberStyle->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

//Ancho de columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(50);

// Guardar Excel 2007 
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_defcivl_completo.xlsx");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",FALSE);
$objWriter->save('php://output');
?>
