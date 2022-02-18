<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Album Detail</title>
</head>
<body>
    <div class="detail">
        <div class="detailContent">
            <a href="album.php"><input type="button" value="Zurück"></a>
        </div>
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

            <div class="deteilContent">
                <p><?=$row['titel']?></p>
            </div>
            <div class="deteilContent">
                <p><?=$row['description']?></p>
            </div>
            <div class="deteilContent">
                <img src=<?="$path/$covername"?> style='width: 400px'>
            </div>
        <?php
            $query = $mysqli->prepare("SELECT * FROM songs WHERE fid_album = ?");
            $query->bind_param('i',$id);
            $query->execute();

            $result_song = $query->get_result();

            while ($row_song = mysqli_fetch_assoc($result_song)): ?>
                <h3><?=$row_song['song_file']?></h3>
                <audio controls>
                    <source src="<?=$path . '/' . $row_song['song_file']?>">
                </audio>
                <br>
            <?php endwhile;
        ?>
    </div>
</body>
</html>
