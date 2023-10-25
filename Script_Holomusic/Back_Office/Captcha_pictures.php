<?php
session_start();
include '../includes/connexion_check_admin.php';
$link = "../CSS/Captcha.css";
$script = '';
$titre = "Captcha pictures";
include '../includes/header_backoffice.php'; 
?>

<div class="form">
<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="image" id="image" accept="image/png, image/jpeg">
   <input type="submit" value="Submit">
</form>
</div>

    <?php
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $filename = $file['tmp_name'];
        $filetype = $file['type'];
    
        if ($filetype == 'image/png' || $filetype == 'image/jpeg') {

            $source = imagecreatefromstring(file_get_contents($filename));
            $width = 360;
            $height = (imagesy($source) * $width) / imagesx($source);
            $resized = imagecreatetruecolor($width, $height);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $width, $height, imagesx($source), imagesy($source));
    
            $parts = [];
            for ($x = 0; $x < 2; $x++) {
                for ($y = 0; $y < 2; $y++) {
                    $part = imagecreatetruecolor(180, 180);
                    imagecopy($part, $resized, 0, 0, $x * 180, $y * 180, 180, 180);
                    $parts[] = $part;
                }
            }
            
            $folderName = uniqid();
            $fullFolderPath ='/var/www/html/asset/captcha/' . $folderName;
            mkdir($fullFolderPath);

            foreach ($parts as $index => $part) {
                $outputFilename = $fullFolderPath . '/' . ($index + 1) . '.jpg';
                imagejpeg($part, $outputFilename);
            }
            echo '<script>';
            echo 'alert("The picture has been successfully sent.");';
            echo '</script>';
            
            imagedestroy($source);
            imagedestroy($resized);
            foreach ($parts as $part) {
                imagedestroy($part);
            }
        
          }  else {
            echo '<script>';
            echo 'alert("Please select an image in PNG or JPG format.");';
            echo '</script>';
        }
    }
    ?>

    
<div class="form">
    <form action="" method="post">
        <label for="folder">Select a folder:</label>
        <select name="folder" id="folder">
            <?php
            $captchaPath = '/var/www/html/asset/captcha/';
            $folders = array_diff(scandir($captchaPath), array('..', '.'));
            foreach ($folders as $folder) {
                echo '<option value="' . $folder . '">' . $folder . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="delete" value="Delete Folder">
    </form>
</div>

<?php
if (isset($_POST['delete'])) {
    $selectedFolder = $_POST['folder'];
    $folderPath = '/var/www/html/asset/captcha/' . $selectedFolder;

    if (is_dir($folderPath)) {
        $files = glob($folderPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($folderPath);
        echo '<script>';
        echo 'alert("The folder and its images have been successfully deleted.");';
        echo '</script>';
    }
}
?>

</body>
</html>