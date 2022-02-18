<?php
    require 'connector.php';

    $id = $_GET['id'];

    $result = $mysqli->query("SELECT * FROM album where id_album = $id");
    $row = mysqli_fetch_assoc($result);
    $cover_file = $row['cover_file'];
    unlink($cover_file);

    $query = $mysqli->prepare("DELETE FROM album WHERE bild_id=?");
    $query->bind_param('i', $id);
    $query->execute();
    header("Location: album.php");
?>