<?php
$file_dir = "C:\Users\Administrator\Desktop\NewFile";
echo $_COOKIE['vegetable'] . "<br/>";
foreach ($_FILES as $file_name => $file_array) {
    echo "path: " . $file_array['tmp_name'] . "<br/>";
    echo "name: " . $file_array['name'] . "<br/>";
    echo "type: " . $file_array['type'] . "<br/>";
    echo "size: " . $file_array['size'] . "<br/>";
    if (is_uploaded_file($file_array['tmp_name'])) {
        move_uploaded_file($file_array['tmp_name'],
            "$file_dir/" . $file_array['name'])
        or die ("Coundn't move file");
        echo "File was moved";
    } else {
        echo "NO file found";
    }
}
?>