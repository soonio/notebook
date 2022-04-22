# 压缩mysql文件
# php sql-compress.php old.sql 6

<?php

if (!isset($argv[1])) {
    echo "please input the dot sql filename\n";
    exit();
}

if (!is_file($argv[1])) {
    echo "{$argv[1]} is not a file\n";
    exit();
}

if (!is_readable($argv[1])) {
    echo "the file {$argv[1]} is not readable\n";
    exit();
}

if (isset($argv[2]) && is_numeric($argv[2])) {
    $batchMax = $argv[2];
} else {
    $batchMax = 200;
}

$file = $argv[1];

$newFile = preg_replace('/\.sql/', '-compress.sql', $file);

if (is_file($newFile)) {
    echo "the file $newFile is exist\n";
    exit();
}

$sourceFileHandle = fopen($file, 'r');
$targetFileHandle = fopen($newFile, 'a');

$explain = false;
$insert = false;

$tmp = [];

while (!feof($sourceFileHandle)) {
    $line = fgets($sourceFileHandle);

    if ($explain) {
        fwrite($targetFileHandle, $line);
        continue;
    }

    $realLine = rtrim($line, "\n");

    if (strpos($realLine, 'INSERT') !== 0) {
        if (isset($tmp['tableData']) && $tmp['tableData']) {
            echo date('Y-m-d H:i:s') .  "INSERT分段结束， 开始写入{$tmp['tableName']}数据\n";
            fwrite(
                $targetFileHandle,
                "INSERT INTO `{$tmp['tableName']}` VALUES " . implode(',', $tmp['tableData']) . ";\n"
            );
            $tmp['tableData'] = [];
        }
        $insert = false;
    }

    if ($insert) {
        $td = preg_replace([
            '/INSERT INTO `.*?` VALUES /',
            '/;/'
        ], '', $realLine);

        $tmp['tableData'][] = trim($td);

        if (count($tmp['tableData']) >= $batchMax) { // 大于$max条，就写入一次
//            echo date('Y-m-d H:i:s') . "大于{$batchMax}条， 开始写入{$tmp['tableName']}数据\n";
            fwrite(
                $targetFileHandle,
                "INSERT INTO `{$tmp['tableName']}` VALUES " . implode(',', $tmp['tableData']) . ";\n"
            );
            $tmp['tableData'] = [];
        }
        continue;
    }

    if (strpos($line, '--') === 0) {
        fwrite($targetFileHandle, $line);
        continue;
    }

    if ($realLine == '/*') {
        $explain = true;
        fwrite($targetFileHandle, $line);
        continue;
    }

    if ($realLine == '*/') {
        $explain = false;
        fwrite($targetFileHandle, $line);
        continue;
    }

    // 优化insert语句
    if (strpos($realLine, 'INSERT') === 0) {
        preg_match('|`(.*?)`|', $realLine, $m);

        echo date('Y-m-d H:i:s') . "开始处理数据表{$m[1]} \n";

        $tmp['tableName'] = $m[1];

        $td = preg_replace([
            '/INSERT INTO `.*?` VALUES /',
            '/;/',
        ], '', $realLine);
        $tmp['tableData'][] = trim($td);
        $insert = true;
        continue;
    }

    // 一般语句，直接复制
    fwrite($targetFileHandle, $line);
}

fclose($sourceFileHandle);
fclose($targetFileHandle);

