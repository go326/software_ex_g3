<?php

include("../db_connect.php");
global $pdo;

$sql = "SELECT * FROM room ";
echo $sql;
$smt = $pdo->query($sql);
$data = $smt->fetch();
var_dump($data);
?>
<script type="text/javascript">
    import Rein from "./maketable.js";
    let room = <?php echo $data; ?>;
</script>
<?php
header("Location:./f_top.html");
