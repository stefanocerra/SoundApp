<?php
    require 'connector.php';

    $folderid = $_POST['album'];

    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $count_files = count($_FILES['addsong']['name']);
    $song_number = 0;
    for($i = 0; $i < $count_files ; $i++){
        $music = $finfo->file($_FILES['addsong']['tmp_name'][$i]);
        if ($music === 'audio/mpeg' OR $music === 'audio/ogg') {
            $musictitle = $_FILES['addsong']['name'][$i];
            $path = dirname(__FILE__)."/files/$folderid/".$musictitle;

            $query = $mysqli->prepare("INSERT INTO songs (fid_album, song_file) VALUES (?, ?)");
            $query->bind_param('is',$folderid, $musictitle);
            $query->execute();

            if (move_uploaded_file($_FILES['addsong']['tmp_name'][$i], $path)){
                $song_number++;
            }
        }
    }

    $result = $mysqli->query("SELECT * FROM album where id_album = $folderid");
    $row = mysqli_fetch_assoc($result);
    $number_songs = $row['number_songs'] + $song_number;

    $query = $mysqli->prepare("UPDATE album SET number_songs=? WHERE id_album=?");
    $query->bind_param('is',$number_songs, $folderid);
    $query->execute();

    header("Location: detail.php?id=$folderid");