<?php
    function IFormSecurityP($form){
        $form = htmlentities($form, ENT_QUOTES, "UTF-8");
        return $form;
    }

?>