<?php
    function IFormSecurityP($form){
        echo ($form."<br>");
        $form = htmlentities($form, ENT_QUOTES, "UTF-8");
        echo ("変換後".$form."<br>");
        return $form;
    }

?>