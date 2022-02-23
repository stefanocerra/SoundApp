<?php
    require 'connector.php';

    $id = $_GET['id'];

    //$test = dir(unlink("/uk-307/files/$id"));

    $test = '1';

    Select ausprobieren!!!


    $query = $mysqli->prepare("DELETE FROM album WHERE id_album = ?");
    $query->bind_param('i', $test);
    $query->execute();

    /*
    $query = $mysqli->prepare("DELETE FROM songs WHERE fid_album=?");
    $query->bind_param('i', $id);
    $query->execute();
    header("Location: album.php");
    /*
?>

