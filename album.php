<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meine Alben</title>
</head>
<body>
    <a href="newalbum.php"><input type="button" value="Neues Album hinzufügen"></a>
    <br>
    <h1>Meine Alben</h1>
</body>
</html>

<?php
    require 'connector.php';

    $result = $mysqli->query("SELECT * FROM album");

    while ($row = mysqli_fetch_assoc($result)) {

        $folderid = $row['id_album'];
        $covername = $row['cover_file'];
        $path = "/uk-307/files/$folderid";
        $songs_number = $row['number_songs'];

        echo "<img src='$path/$covername' style='width: 400px'>";
        echo "$row[titel] ";
        echo "<br>";

        $album_id = $row['id_album'];
        $query = $mysqli->prepare("SELECT * FROM songs WHERE fid_album = ?");
        $query->bind_param('i',$album_id);
        $query->execute();
        $result_song = $query->get_result();

        while ($row_song = mysqli_fetch_assoc($result_song)): ?>
            <h3><?=$row_song['song_file']?></h3>
            <audio controls>
                <source src="<?=$path . '/' . $row_song['song_file']?>">
            </audio>
            <br>
        <?php endwhile;

        echo "<a href='detail.php?id=$row[id_album]'><input type='button' value='Album ansehen'></a>";
    }
?>

