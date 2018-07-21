<?php
function validate_key($key, $value){
    if($key==generate_key($value)){
        return true;
    } else {
        return false;
    }
}
function generate_key($value){
    return strrev(md5("9ac5e23ab210272319fe6e3bef09309d".md5($value)));
}