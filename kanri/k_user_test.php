<?php require ("k_user_management"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>user</title>
    </head>

    <body>

    <!-- Input -->
    <form action="" method="post">
    <p>edit_id<input type="text" name="kue_id"></p>
    <p>input_id<input type="text" name="ku_id"></p>
    <p>name<input type="text" name="ku_name"></p> 
    <p>pass<input type="text" name="ku_pass"></p>

    <p>
    front<input type="checkbox" name="ku_auth[]" value="1">   
    seiso<input type="checkbox" name="ku_auth[]" value="2">
    resto<input type="checkbox" name="ku_auth[]" value="3">  
    arbai<input type="checkbox" name="ku_auth[]" value="4">   
    kanri<input type="checkbox" name="ku_auth[]" value="5">
    </p>  
    <p>
    <input type="submit" name="ku_input" value="input">
    <input type="submit" name="ku_edit" value="edit">
    <input type="submit" name="ku_del" value="del">
    </p>

    <?php KUserInputP(); ?>
    <?php KUserEditP(); ?>
    <?php KUserDelP(); ?>

    </form>

    
    <!-- Management -->
    <table>
    <?php KUserManagementP(); echo $k_res; ?>
    </table>
    
</body>
</html>