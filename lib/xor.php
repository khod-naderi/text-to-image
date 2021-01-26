<?php
    function xor_this($string, $key = "$") {
        #$key = ('$');
        $outText = '';
        for($i=0; $i<strlen($string); $i++){
            $outText .= $string[$i] ^ $key;
        }
        return $outText;
    }
    http_response_code(404);
?>