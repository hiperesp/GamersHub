<?php
if($page['must_be_logged']==true){
    if(!isset($_SESSION['steamid'])) {
        header("Location: /?login");
        exit;
    }
}