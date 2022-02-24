<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/stylealbum.css">
    <title>Meine Alben</title>
</head>
<body>
        <div class="album">
            <a href="newalbum.php"><input type="button" value="Neues Album hinzufügen" class="button"></a>
            <?php
                require 'connector.php';

                $result = $mysqli->query("SELECT * FROM album");

                while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        $folderid = $row['id_album'];
                        $covername = $row['cover_file'];
                        $path = "/uk-307/files/$folderid";
                        $songs_number = $row['number_songs'];
                        $album_id = $row['id_album'];
                        $album_title = $row['titel'];
                    ?>
                    <div class="albumContent">
                        <div class="albumCover">
                            <img src='<?="$path/$covername"?>' style="width: 400px; height: 400px">
                        </div>
                        <div class="albumSongs">
                            <h2><?=$album_title?></h2>
                            <a href="detail.php?id=<?=$album_id?>"><input type='button' value='Album ansehen'></a>
                            <?php
                                $query = $mysqli->prepare("SELECT * FROM songs WHERE fid_album = ? LIMIT 3");
                                $query->bind_param('i',$album_id);
                                $query->execute();
                                $result_song = $query->get_result();
                            ?>
                            <?php
                                while ($row_song = mysqli_fetch_assoc($result_song)): ?>
                                    <h3><?=$row_song['song_file']?></h3>
                                    <audio controls>
                                        <source src="<?=$path . '/' . $row_song['song_file']?>">
                                    </audio>
                                <?php endwhile;
                            ?>
                        </div>
                    </div>
                <?php endwhile;
            ?>
        </div>
</body>
</html>

