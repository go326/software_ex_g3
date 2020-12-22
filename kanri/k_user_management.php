<!--  -->

<?php

class User
{
    public function KUserManagementP()
    {
        $dsn = 'mysql:dbname=admin;host=localhost';
        $user = 'admin';
        $password = 'software_ex_g3';
        $ukum = "";
        try {
            // DB接続
            $pdo = new PDO($dsn, $user, $password);
            // echo ('接続に成功');

            // SELECT (costomer) 
            $sql = "SELECT user_id,user_name FROM user";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // $user_id .= $row['user_id'] . "<br>";
                // $user_name .= $row['user_name'] . "<br>";
                $ukum .= "</tr><td>"
                    . $row['user_id'] . "</td><td>"
                    . $row['user_name'] . "</td><\tr>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
$kum = new User();
$kum->ukum;
echo $kum


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>infoPHP</title>
</head>

<body>
    <table>
        <tr>
            <?php
            echo $kum;
            ?>
        </tr>
    </table>

</body>

</html>