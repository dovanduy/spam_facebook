<?php
$files=scandir("cookies");
unset($files[0]);
unset($files[1]);
foreach ($files as $file) {
    $file = "cookies/" . $file;
    if (filesize($file) < 500)unlink($file);
}
?>