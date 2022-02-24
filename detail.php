<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styledetail.css">
    <title>Album Detail</title>
</head>
<body>
    <div class="detail">
        <?php
            require 'connector.php';

            $id = $_GET['id'];

            $query_album = $mysqli->prepare("SELECT * FROM album WHERE id_album = ?");
            $query_album->bind_param('i',$id);
            $query_album->execute();

            $result = $query_album->get_result();

            $row = mysqli_fetch_assoc($result);

            $folderid = $id;
            $covername = $row['cover_file'];
            $path = "/uk-307/files/$folderid";
            $songs_number = $row['number_songs'];
        ?>
        <div class="deteilInfo">
            <a href="index.php"><input type="button" value="Zurück"></a>
            <a href='delete.php?id=<?=$id?>'><input type="button" value="Album löschen"></a>
            <h2><?=$row['titel']?></h2>
            <p><?=$row['description']?></p>
        </div>
        <div class="deteilContent">
            <div class="deteilCover">
                <img src=<?="$path/$covername"?> style='width: 400px'>
            </div>
            <div class="deteilSongs">
                <?php
                $query = $mysqli->prepare("SELECT * FROM songs WHERE fid_album = ?");
                $query->bind_param('i',$id);
                $query->execute();

                $result_song = $query->get_result();

                while ($row_song = mysqli_fetch_assoc($result_song)): ?>
                    <div class="song">
                        <h3><?=$row_song['song_file']?></h3>
                        <audio controls>
                            <source src="<?=$path . '/' . $row_song['song_file']?>">
                        </audio>
                    </div>
                <?php endwhile;
                ?>
            </div>
        </div>
    </div>
</body>
</html>
