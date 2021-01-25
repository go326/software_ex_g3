    <?php 
	session_save_path("/var/tmp/");
    session_start();
    $dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
    $user = 'admin';
    $password = 'software_ex_g3';
    $sql = "";
    $date = "";

    try {
        $pdo = new PDO($dsn, $user, $password);

        // ログの記録
        function KLogRecodeP($name, $work, $table, $line, $attribute, $befor, $after)
        {
            global $pdo, $sql, $date;
            $date = date('Y-m-d H:i:s');

            if ($name != "" and $work != "" and $table != "" and $line != "" and $attribute != "" and $befor != "" and $after != "") {
                $sql = "INSERT INTO log VALUES('$date','$name','$work','$table','$line','$attribute','$befor','$after')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    ?>
