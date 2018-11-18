<?php


define('FPDF_FONTPATH','FPDI/font/');

// require_once('./FPDI/fpdf.php');
require_once('./FPDI/chinese.php');
require_once('./FPDI/fpdi.php');



// $pdf = new FPDI();
$pdf=new PDF_Chinese();

// $pageCount = $pdf->setSourceFile('test999.pdf');

// $pdf->image("test.png", 75, 85, 100, 200);

// $pdf->AddGBFont('simsun','宋体'); 
// $pdf->AddGBFont('simhei','黑体'); 
// $pdf->AddGBFont('simkai','楷体_GB2312'); 
$pdf->AddGBFont('sinfang','仿宋_GB2312'); 
// $pdf->Open(); 
$pdf->AddPage(); 
$pdf->SetFont('sinfang','',20); 


// 插入图片
// $pageCount = $pdf->setSourceFile('test999.pdf');


// $pdf->SetFont('Helvetica', '', 8);
// $pdf->SetFont('Big5','',20);
// for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++){
//     $templateId = $pdf->importPage($pageNo);
//     $size = $pdf->getTemplateSize($templateId);
//     if ($size['w'] > $size['h']) 
//        $pdf->AddPage('L', array($size['w'], $size['h']));
//     else 
//        $pdf->AddPage('P', array($size['w'], $size['h']));

//     $pdf->useTemplate($templateId);


//     $pdf->GetX();
// var_dump($pdf->GetX());

    //加上图片水印，后为坐标
        //     $pdf->image("test.png", 75, 85, 50);
        $pdf->Text(10, 10, iconv('UTF-8', 'GBK', '2018年22月22日'));
// }


$pdf->Output('I');

// $filename = '/home/lin/下载/四书模板/四书模板/xxxx保密工作责任书（通用部门）.doc';

        // $content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);
        // echo $content;
        // print_r(shell_exec("ls"));
// $result = shell_exec("xvfb-run wkhtmltopdf http://www.baidu.com 1.pdf");
// $result = shell_exec('ls');
// echo $result;
// echo exec('whoami');
// if(file_exists("sign.pdf")){
//     header("Content-type:application/pdf");
//     header("Content-Disposition:attachment;filename=sign.pdf");
//     echo file_get_contents("1.pdf");
//     //echo "{$filename}.pdf";
// }else{
//     exit;
// }

// 生成 pdf
// $cd = "cd /www/wwwroot/wwfnba01/sign_online/admin/public/jodconverter-2.2.2/lib && ";
// $dir = "/www/wwwroot/wwfnba01/sign_online/admin/public/test999.pdf";
// $sh = $cd . " java -jar jodconverter-cli-2.2.2.jar test.doc ".$dir;
// $result = shell_exec($sh);
// var_dump($result);