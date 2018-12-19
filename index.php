<html>
<head>
    <title>File Manager</title>
    <link rel="stylesheet" href="css/master.css">
</head>
<body>
<?php
/*
 * @param string $file FilePath
 * @param int $digits Digits to display
 * @return string|bool Size (KB, MB, GB, TB) or boolean
 */

function getNiceFileSize($file, $digits = 2)
{
    if (is_file($file)) {
        $filePath = $file;
        if (!realpath($filePath)) {
            $filePath = $_SERVER["DOCUMENT_ROOT"] . $filePath;
        }
        $fileSize = filesize($filePath);
        $sizes = array("TB", "GB", "MB", "KB", "B");
        $total = count($sizes);
        while ($total-- && $fileSize > 1024) {
            $fileSize /= 1024;
        }
        return round($fileSize, $digits) . " " . $sizes[$total];
    }
    return false;
}
function rmDirectory($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rmDirectory($file);
        else unlink($file);
    }// remove every file in directory
    rmdir($dir); // and finally remove this directory
}
if (isset($_GET['rm'])) {
    $file2Remove = $_GET['rm'];
    if(is_dir($file2Remove)){
        rmDirectory($file2Remove);
        echo "<div class='msg'>Directory <b>$file2Remove</b> and its content successfully deleted ...</div>";
    }else{
        @unlink($file2Remove);
        echo "<div class='msg'>File <b>$file2Remove</b> successfully deleted ...</div>";
    }
}
if(isset($_POST['filepath'],$_POST['filecontent'])){
    file_put_contents($_POST['filepath'],$_POST['filecontent']);
    echo "<div class='msg'>File {$_POST['filepath']} successfully saved ...</div>";
}
if (isset($_GET['edit'])) {
    $file2edit = $_GET['edit'];
    if (!file_exists($file2edit)) {
        echo "<div class='msg'><b>Error :</b> File $file2edit not exists !</div>";
    } else {
        echo "Editing file $file2edit : <br>";
        ?>
        <form action="" method="post">
            <textarea name="filecontent" cols="100" rows="10"><?php echo file_get_contents($file2edit); ?></textarea><br>
            <input name="filepath" type="hidden" value="<?php echo $file2edit; ?>"/>
            <input type="submit" name="" value=" Save ">
        </form>

        <?php
    }
}

(isset($_GET['dir'])) ? $currDir = $_GET['dir'] : $currDir = 'files'; // check dir and set default dir
if (substr($currDir, strlen($currDir) - 1) != "/") {
    $currDir .= '/';
} // is value dir has / or not



echo '<h3>List of files in folder : <span style="color:brown">' . $currDir . '</span></h3>';
echo '<ul>';
echo '<li class="folder back">';
    $parentDir = dirname($currDir);
    echo '<span class="filename"><a href="?dir=' . $parentDir . '">Go Back To '. str_replace($currDir,'',$parentDir) .' </a></span>';
echo '</li>';
foreach (glob($currDir . '*') as $filename) {
    $fileFormat = '';
    if (is_dir($filename)) {
        $type = 'folder';
    } else {
        $type = 'file';
        $dotPosition = strrpos($filename, ".");
        if ($dotPosition !== false) {
            $fileFormat = substr($filename, $dotPosition + 1);
        }
    }

    echo '<li class="' . $type . " $fileFormat" . '">';
    if (is_dir($filename)) {
        echo '<span class="filename"><a href="?dir=' . $filename . '">' . str_replace($currDir, '', $filename) . '</a></span>';
    } else {
        echo '<span class="filename">' . str_replace($currDir, '', $filename) . "</span>";
    }

    echo '<span class="actions">';
    echo "<a href='?dir={$currDir}&rm={$filename}' " . ' onclick="return confirm(\'Are you sure to remove ' . $filename . ' \')" ' . "> delete </a>";
    if (in_array($fileFormat, array('txt', 'php', 'html', 'htm'))) {
        echo "<a href='?dir={$currDir}&edit={$filename}' > &nbsp; &nbsp;  edit </a>";
    }
    echo '</span>';
    echo '<span class="infos">';
    echo getNiceFileSize($filename);
    echo '</span>';
    echo '</li>';

}
echo '</ul>';

?>
</body>
</html>

