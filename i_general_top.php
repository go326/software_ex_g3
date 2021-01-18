<?php
$auth = $_POST['auth'];
echo ($auth);

function IAuthCheckP($auth,$auth_check){

    if(strpos($manual_file_name, $auth_check) !== false){    
        return true;
    }else{
        return false;
    }
}
?>