<?php require("r_fee.php");  ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>user</title>
    </head>
<body>    
    <form action="" method="post">

    <p>
    fid<input type="text" name="fid">
    fac<input type="text" name="fac">
    fae<input type="text" name="fae">
    </p>
    <p>
    place<input type="text" name="rf_place">
    add<input type="text" name="rf_add">
    </p>
    <p>
    naiyou<input type="text" name="rf_contents">
    bikou<input type="text" name="rf_remark">
    </p>
<p> <input type="submit" name="rf_reg" value="reg"></p>
    
    </form>
    <!-- Management -->
    <table>
    <?php FeeSelectP(); echo $rf_res; ?>
    </table>
    <?php FeeInsertP(); ?>
</body>
</html>