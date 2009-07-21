<?php

include_once("api.php");
include_once("fpdf_ch.php");

//print_r($_REQUEST);

$strAddress = isset($_POST['address']) ? trim($_REQUEST['address']) : "";
$strComment	= isset($_POST['comment']) ? trim($_REQUEST['comment']) : "";
$strDate	= isset($_POST['date']) ? trim($_REQUEST['date']) : date("Y m d");
$iExpress	= isset($_REQUEST['express']) ? intval($_REQUEST['express']) : 0;

$arrInfo	= parseAddress($strAddress);
$arrPos		= array_key_exists($iExpress, $arrPosition) ? $arrPosition[$iExpress] : $arrPosition[0];
$objPDF		= new PDF_Chinese("Landscape", "mm", $arrPos['size']->toArray());

$objPDF->AddGBFont();
$objPDF->SetFontSize(11);

$objPDF->AddPage();

$objPDF->SetFont("Arial");
$objPDF->Text($arrPos['sendDate']->x, $arrPos['sendDate']->y, parseDate($strDate, $arrPos['dateFormat']));
$objPDF->Text($arrPos['srcPhone']->x, $arrPos['srcPhone']->y, "0571-85790698");
if ($arrPos['srcPCode'] != NULL) $objPDF->Text($arrPos['srcPCode']->x, $arrPos['srcPCode']->y, "310053");

$objPDF->Text($arrPos['dstPhone1']->x, $arrPos['dstPhone1']->y, $arrInfo['phone1']);
if (isset($arrInfo['phone2'])) $objPDF->Text($arrPos['dstPhone2']->x, $arrPos['dstPhone2']->y, $arrInfo['phone2']);
if ($arrPos['dstPCode'] != NULL) $objPDF->Text($arrPos['dstPCode']->x, $arrPos['srcPCode']->y, $arrInfo['pcode']);

$objPDF->SetFont("GB");
$oSize = $objPDF->GetFontSize();

if ($arrPos['srcAddrSize'] != NULL) $objPDF->SetFontSize($arrPos['srcAddrSize']);
$objPDF->SetXY($arrPos['srcAddr']->x, $arrPos['srcAddr']->y);
$objPDF->MultiCell($arrPos['srcAddrArea']->x, $arrPos['srcAddrArea']->y, "浙江省杭州市滨江区\n请确认商品无缺损后签收\n签收后申述缺损,恕我们无法承担责任", 0);
$objPDF->SetFontSize($oSize);

if ($arrPos['dstAddrSize'] != NULL) $objPDF->SetFontSize($arrPos['dstAddrSize']);
$objPDF->SetXY($arrPos['dstAddr']->x, $arrPos['dstAddr']->y);
$objPDF->MultiCell($arrPos['dstAddrArea']->x, $arrPos['dstAddrArea']->y, convert($arrInfo['address']) . "\n" . convert($strComment), 0);
$objPDF->SetFontSize($oSize);

$objPDF->Text($arrPos['srcName']->x, $arrPos['srcName']->y, "李立林");

$objPDF->SetFontSize(14);
$objPDF->Text($arrPos['dstName']->x, $arrPos['dstName']->y, convert($arrInfo['name']));
$objPDF->SetFontSize($oSize);

$objPDF->Output();

?>