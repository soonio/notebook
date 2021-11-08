<?php

define('TARDIR', './TAR');

if (!is_dir(TARDIR)) mkdir(TARDIR, 0777, true);

/**
 * 创建纯色图片
 * @return false|resource
 */
function getPurePic()
{
    $s = imagecreatetruecolor(270, 270);
    imagecolorallocate($s, 10, 20 , 40);
    return $s;
}

function combine($master, $son, $wrapLength, $newName)
{
    // 创建两个图片对象
    $m = imagecreatefromjpeg($master);
    $s = imagecreatefrompng($son);

    // 获得二维码图片的宽高
    list($mw, $mh) = getimagesize($son);

    // 生成标准图片
    $stander = imagecreatetruecolor($wrapLength, $wrapLength);
    imagecopyresampled($stander, $s, 0, 0, 0, 0, $wrapLength, $wrapLength, $mw, $mh);

    // 合并标准图片和原生图片
    imagecopymerge($m, $stander, 20, 1164, 0, 0, $wrapLength, $wrapLength, 100);

    imagejpeg($m,TARDIR. "/{$newName}.jpeg");
}

$templateHome = './Template';
$QrCodeHome = './QrCode';

$templates = scandir($templateHome);
$QrCodes = scandir($QrCodeHome);

$templates = array_filter($templates, function ($name) use ($templateHome) {
    return is_file("{$templateHome}/{$name}");
});

$QrCodes = array_filter($QrCodes, function ($name) use ($QrCodeHome) {
    return is_file("{$QrCodeHome}/{$name}");
});

foreach ($templates as $template) {
    foreach ($QrCodes as $qrCode) {
        combine("{$templateHome}/{$template}", "{$QrCodeHome}/{$qrCode}", 270, "{$qrCode}-{$template}");
    }
}
