<?php
function IAuthCheckP($auth,$auth_check){
    
    if(strpos(strval($auth), strval($auth_check)) !== false){   
        return true;
    }else{
        return false;
    }
}
?>