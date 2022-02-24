<?php
    require 'connector.php';

    $id = $_GET['id'];

    $result = $mysqli->query("SELECT * FROM album where id_album = $id");
    $row = mysqli_fetch_assoc($result);
    $cover_file = $row['cover_file'];

    $path = "files/$id";
    $files = glob($path . '/*');

    foreach($files as $file){
        if(is_file($file)) {
            unlink($file);
        }
    }

    rmdir("$path");

    $query = $mysqli->prepare("DELETE FROM album WHERE id_album=?");
    $query->bind_param('i', $id);
    $query->execute();

    $query = $mysqli->prepare("DELETE FROM songs WHERE fid_album=?");
    $query->bind_param('i', $id);
    $query->execute();

    header("Location: index.php");
