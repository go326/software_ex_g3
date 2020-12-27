<?php
    
    include '../db_connect.php';
    
function SCleanManagemantP(){
    global $pdo,$room_number,$room_clean;
    $stmt = $pdo -> query("SELECT * FROM room");
    //fetch
    while ($row = $stmt -> fetch()){
        $room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        echo ($room_number.",".$room_clean."<br>");
    }
    //return [$room_number,$room_clean];
}

function SCleanNumberP(){
    echo 'test';
}

function SCleanEditP(){
    echo 'test';
}

SCleanManagemantP();

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>seisou</title>
    </head>

    <body>
    <h1> 清掃情報管理画面php </h1>

    <input type="button" value="201" name="room_number"　><!--onclick="SCleanManagemantP()">-->
    </body>
</html>
