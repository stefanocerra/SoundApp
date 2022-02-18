<?php
    require 'connector.php';

    $id = $_GET['id'];

    dir(unlink("/uk-307/files/$id"));

    $query = $mysqli->prepare("DELETE FROM album WHERE bild_id=?");
    $query->bind_param('i', $id);
    $query->execute();

    $query = $mysqli->prepare("DELETE FROM songs WHERE fid_album=?");
    $query->bind_param('i', $id);
    $query->execute();
    header("Location: album.php");
?>

