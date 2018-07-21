<?php
require_once("assets/php/includes/databaseConnection.php");

if(!isset($theprofile)){
    $theprofile = @$_GET['profile'];
}
$stmt = mysqli_prepare($link, "SELECT `steamid`, `personaname`, `realname`, `level`, `rank`, `profilestate`, `communityvisibilitystate`, `profileurl`, `personastate`, `lastlogoff`, `primaryclanid`, `timecreated`, `uptodate`, `avatar`, `avatarmedium`, `avatarfull`, `kills`, `deaths` FROM `users` WHERE `steamid` = ?");
mysqli_stmt_bind_param($stmt, 's', $theprofile);
mysqli_stmt_execute($stmt);
//LOOP NOS RESULTADOS: while (mysqli_stmt_fetch($stmt)) { printf("%s\n", $steamid); } //
//ATIVAR UM ÚNICO RESULTADO: mysqli_stmt_fetch($stmt);
mysqli_stmt_store_result($stmt);
$rows = mysqli_stmt_num_rows($stmt);
if($rows==1){ //1 PERFIL EXISTE (CORRETO)
    mysqli_stmt_bind_result($stmt, $profile['steamid'], $profile['personaname'], $profile['realname'], $profile['level'], $profile['rank'], $profile['profilestate'], $profile['communityvisibilitystate'], $profile['profileurl'], $profile['personastate'], $profile['lastlogoff'], $profile['primaryclanid'], $profile['timecreated'], $profile['uptodate'], $profile['avatar'], $profile['avatarmedium'], $profile['avatarfull'], $profile['kills'], $profile['deaths']);
    mysqli_stmt_fetch($stmt);
    $profile['exists'] = true;
} else { //PERFIL NÃO EXISTE
    $profile['exists'] = false;
}
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);