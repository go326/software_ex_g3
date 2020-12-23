<?php
    
    include '../db_connect.php';
    
function SCleanManagemantP(){
    $stmt = $pdo -> query("SELECT * FROM room");
    while ($row = $stmt -> fetch()){
        $room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        echo "($room_number) $room_clean"
    }

}

SCleanManagemantP();


?>