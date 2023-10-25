<?php

$folderPath = "/var/www/html/asset/captcha/";
$imageFolders = array_diff(scandir($folderPath), array('..', '.'));
$selectedFolder = $imageFolders[array_rand($imageFolders)];
$imageFiles = array_merge(glob($folderPath . $selectedFolder . '/*.png'), glob($folderPath . $selectedFolder . '/*.jpg'), glob($folderPath . $selectedFolder . '/*.jpeg'));
$imageFileNames = [];
foreach ($imageFiles as $imageFile) {
    $imageFileNames[] = $selectedFolder . '/' . basename($imageFile);
}
header('Content-Type: application/json');
echo json_encode($imageFileNames);