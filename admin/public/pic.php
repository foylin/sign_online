<?php

if (!extension_loaded('imagick')) {
    // return false;
    echo 'false';
}
if (!file_exists('test999.pdf')) {
    return false;
}
$im = new Imagick();
$im->setResolution(120, 120); //设置分辨率 值越大分辨率越高
$im->setCompressionQuality(100);
$im->readImage('test999.pdf');
foreach ($im as $k => $v) {
    $v->setImageFormat('png');
    $fileName = md5($k . time()) . '.png';
    if ($v->writeImage($fileName) == true) {
        $return[] = $fileName;
    }
}
return $return;