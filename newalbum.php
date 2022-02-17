<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Neues Album</title>
</head>
<body>
    <h1>Neus Album</h1>
    <div class="newAlbum">
        <form action="newalbum.php" method="POST" enctype="multipart/form-data">
            <label>Titel</label>
            <br>
            <input type="text" name="titel" required>
            <br>
            <label>Beschreibung</label>
            <br>
            <textarea name="imagedescription" rows="4" cols="50"></textarea>
            <br>
            <label>Bild</label>
            <br>
            <input type="file" name="bild" accept=".png, .jpg, .gif, .jpeg" required>
            <br>
            <label>Musiktitel</label>
            <br>
            <input type="file" name="music[]" multiple accept=".mp3, .ogg" required>
            <br>
            <br>
            <input type="submit" value="Save">
        </form>
    </div>
</body>
</html>

<?php
    require 'connector.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['titel'];
        $description = $_POST['imagedescription'];

        $query = $mysqli->prepare("INSERT INTO album (titel, description) VALUES (?, ?)");
        $query->bind_param('ss',$title, $description);
        $query->execute();

        $folderid = $query->insert_id;

        $dir = $_SERVER['DOCUMENT_ROOT'];
        mkdir("$dir/uk-307/files/$folderid", 0777, true);

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $bild = $finfo->file($_FILES['bild']['tmp_name']);

        if ($bild === 'image/jpeg' OR $bild === 'image/jpg' OR $bild === 'image/png' OR $bild === 'image/gif') {
            $covername = uniqid().'.jpg';
            $path = dirname(__FILE__)."/files/$folderid/".$covername;

            $query = $mysqli->prepare("UPDATE album SET cover_file=? WHERE id_album=?");
            $query->bind_param('ss',$covername, $folderid);
            $query->execute();

            if (move_uploaded_file($_FILES['bild']['tmp_name'], $path)) {
                $count_files = count($_FILES['music']['name']);
                $song_number = 0;
                for($i = 0; $i < $count_files ; $i++){
                    $music = $finfo->file($_FILES['music']['tmp_name'][$i]);
                    if ($music === 'audio/mpeg' OR $music === 'audio/ogg') {
                        $musictitle = $_FILES['music']['name'][$i];
                        $path = dirname(__FILE__)."/files/$folderid/".$musictitle;

                        $query = $mysqli->prepare("INSERT INTO songs (fid_album, song_file) VALUES (?, ?)");
                        $query->bind_param('is',$folderid, $musictitle);
                        $query->execute();

                        if (move_uploaded_file($_FILES['music']['tmp_name'][$i], $path)){
                            $song_number++;
                        }
                    }

                }
                $query = $mysqli->prepare("UPDATE album SET number_songs=? WHERE id_album=?");
                $query->bind_param('is',$song_number, $folderid);
                $query->execute();
                echo "Die Dateien wurden erfolgreich hinzugefügt!";
            }
        }
    }
?>

