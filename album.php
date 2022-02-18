<?php
require 'connector.php';

$result = $mysqli->query("SELECT * FROM album");

    while ($row = mysqli_fetch_assoc($result)) {

        $folderid = $row['id_album'];
        $covername = $row['cover_file'];
        $path = "/uk-307/files/$folderid";
        $songs_number = $row['number_songs'];

        $album_id = $row['id_album'];
        $query = $mysqli->prepare("SELECT * FROM songs WHERE fid_album = ? LIMIT 3");
        $query->bind_param('i',$album_id);
        $query->execute();
        $result_song = $query->get_result();
    }
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylealbum.css">
    <title>Meine Alben</title>
</head>
<body>
    <div class="alleAlben">
        <div class="alleAlbenContent">
            <a href="index.php"><input type="button" value="Neues Album hinzufügen"></a>
        </div>
        <div class="alleAlbenContent">
            <h1>Meine Alben</h1>
        </div>
        <div class="alleAlbenContent">
            <img src='<?="$path/$covername"?>' style='width: 400px'>
        </div>
        <div class="alleAlbenContent">
            <?php
            while ($row_song = mysqli_fetch_assoc($result_song)):
                $songtitle = $row_song['song_file'];
                ?>
                <h3><?=$row_song['song_file']?></h3>
                <audio controls>
                    <source src="<?=$path . '/' . $row_song['song_file']?>">
                </audio>

            <?php endwhile; ?>
        </div>
        <p><?=$songtitle?></p>
        <div class="alleAlbenContent">
            <a href="detail.php?id=<?=$album_id?>"><input type='button' value='Album ansehen'></a>
        </div>
    </div>
</body>
</html>

