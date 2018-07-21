<?php
$thispage = "my";
include("assets/php/includes/verifyLogin.php");
include("assets/php/includes/pageConfigs.php");

header("Location: ".alinks('profile', $steamprofile['steamid']));