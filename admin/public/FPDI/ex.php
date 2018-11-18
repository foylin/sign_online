<?php


require('chinese.php');

$pdf=new PDF_Chinese();
// $pdf->AddBig5Font();
// $pdf->AddGBFont();

$pdf=new PDF_Chinese(); 
$pdf->AddGBFont('simsun','宋体'); 
$pdf->AddGBFont('simhei','黑体'); 
$pdf->AddGBFont('simkai','楷体_GB2312'); 
$pdf->AddGBFont('sinfang','仿宋_GB2312'); 
// $pdf->Open(); 
$pdf->AddPage(); 
$pdf->SetFont('simsun','',20); 
$pdf->Write(10,iconv("utf-8","gbk",'中文')); 
$pdf->SetFont('simhei','',20); 
$pdf->Write(10,'ʱ��'); 
$pdf->SetFont('simkai','',20); 
$pdf->Write(10,'����'); 
$pdf->Write(10,'����'); 
$pdf->Output(); 
?>
