<?php

abstract class fileProcessor{
    const MOVIE = "movie";
    const ACTOR = "actor";

    public static function process($filename, $directory){
        $target_dir = "images/".$directory."/";
        $target_file = $target_dir . basename($_FILES[$filename]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES[$filename]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        return basename($_FILES[$filename]["name"]);
    }

}