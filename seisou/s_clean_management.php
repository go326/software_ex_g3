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
    
    return [$room_number , $room_clean];
}

list($room_number,$room_clean) = SCleanManagemantP();
print_r($room_number);
print_r($room_clean);


?>