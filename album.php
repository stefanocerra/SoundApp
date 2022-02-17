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
        $path = "/uk-307/files/$folderid/$covername";

        echo "<img src='$path' style='width: 400px'>";
        echo "$row[titel] ";
        echo "<br>";

        for ($i = 1; $i < 3; $i++):?>
            <audio controls>
                <source>
            </audio>


        <?php endfor;
        //echo "<a href='loeschen.php?id=$row[bild_id]'>Löschen</a>";

        $resultsong = $mysqli->query("SELECT * FROM songs");
    }

