<?php
    require 'connector.php';

    $id = $_GET['id'];
    $album_id = $_GET['album'];

    $file = "files/$id";

    unlink($file);

    $query = $mysqli->prepare("DELETE FROM songs WHERE id_song=?");
    $query->bind_param('i', $id);
    $query->execute();

    $result = $mysqli->query("SELECT * FROM album where id_album = $album_id");
    $row = mysqli_fetch_assoc($result);
    $number_songs = $row['number_songs'] -1;

    $query = $mysqli->prepare("UPDATE album SET number_songs=? WHERE id_album=?");
    $query->bind_param('ss',$number_songs, $album_id);
    $query->execute();

    header("Location: detail.php?id=$album_id");