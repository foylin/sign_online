<?php

// Set the enviroment variable for GD
putenv('GDFONTPATH=' . realpath('.'));

// Name the font to be used (note the lack of the .ttf extension)
$font = 'simfang0';

$img = ImageCreate(200,40);   //创建一个宽400 高60的图片
 
//创建以bg.jpg为背景的图片
//$img = ImageCreateFromJpeg('./bg.jpg');
 
//创建颜色
$black = imagecolorallocate($img, 0, 0, 0); //创建颜色
$red = imagecolorallocate($img,255,0,0);
$white = imagecolorallocate($img,255,255,255);
 
//绘制了矩形的轮廓
// imagerectangle($img, 10, 10, 30, 30, $white);
 
//填充矩形
imagefilledrectangle($img, 0, 0, 200, 40, $white);
 
//填写文字
imagettftext($img, 18, 0, 20, 28, $black, $font, '2018年11月18日');
 
//生成图片
header('Content-type:image/png');
ImagePng($img);
ImageDestroy($img);