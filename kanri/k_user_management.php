<?php

$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'root';
$password = 'prac.lampp';
$k_res = "";
$ku_id = 0;
$ku_name = "";
$ku_pass = "";
$ku_auth = 1;

try {
    // DB接続
    $pdo = new PDO($dsn, $user, $password);
    //echo ('接続に成功');

    // SELECT (user) 
    function KUserManagementP()
    {
        global $pdo, $k_res;
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $k_res .= "</tr><td>"
                . $row['user_id'] . "</td><td>"
                . $row['user_name'] . "</td></tr>";
        }
    }

    // INSERT(user)
    function KUserInputP()
    {
        global $pdo, $ku_id, $ku_name, $ku_pass, $ku_auth;
        if (isset($_POST['ku_id']) and isset($_POST['ku_name']) and isset($_POST['ku_pass'])) {
            if (isset($_POST['ku_auth'])) {
                $ku_id = $_POST['ku_id'];
                $ku_name = $_POST['ku_name'];
                $ku_pass = $_POST['ku_pass'];

                //$hash = password_hash($ku_pass, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO user VALUES('$ku_id','$ku_name','$ku_pass','$ku_auth')");
                $stmt->bindValue('$ku_id', $ku_id, PDO::PARAM_STR);
                $stmt->bindValue('$ku_name', $ku_name, PDO::PARAM_STR);
                $stmt->bindValue('$ku_pass', $ku_pass, PDO::PARAM_STR);
                $stmt->bindValue('$ku_auth', $ku_auth, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>user</title>
</head>

<body>
    <!-- Input -->
    <form action="" method="post">
        <p>i<input type="text" name="ku_id"></p>
        <p>n<input type="text" name="ku_name"></p>
        <p>p<input type="text" name="ku_pass"></p>

        <p>f<input type="checkbox" name="ku_auth[]" value="1"></p>
        <p>s<input type="checkbox" name="ku_auth[]" value="2"></p>
        <p>r<input type="checkbox" name="ku_auth[]" value="3"></p>
        <p>a<input type="checkbox" name="ku_auth[]" value="4"></p>
        <p>k<input type="checkbox" name="ku_auth[]" value="5"></p>

        <p><input type="submit" value="submit"></p>
    </form>


    <!-- Management -->
    <table>
        <?php KUserManagementP();
        echo $k_res; ?>
    </table>
</body>

</html>