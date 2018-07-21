<?php
require("assets/php/includes/steamauth/steamauth.php");
if(isset($_SESSION['steamid'])) {
	$logged = true;
	include ('steamauth/userInfo.php');
} else {
	$logged = false;
}