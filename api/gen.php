<?php
if(@$_GET['password']!="password"){
    exit;
}
include("../private_server/validate_key.php");
echo generate_key(@$_GET['key']);