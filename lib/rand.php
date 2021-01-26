<?php
    function randomStr(){
        $data = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789";
        $text = "";
        for($i=0; $i <= 7; $i++){
            $text .= $data[rand(0,60)];
        }
        return $text;
    }
    http_response_code(404);
?>