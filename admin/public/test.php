<?php

// $filename = '/home/lin/下载/四书模板/四书模板/xxxx保密工作责任书（通用部门）.doc';

        // $content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);
        // echo $content;
        // print_r(shell_exec("ls"));
$result = shell_exec("xvfb-run wkhtmltopdf http://www.baidu.com 1.pdf");
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