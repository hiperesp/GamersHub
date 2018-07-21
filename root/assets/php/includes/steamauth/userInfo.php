<?php
if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname'])) {
	require 'SteamConfig.php';
	$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']); 
	$content = json_decode($url, true);
	$_SESSION['steam_steamid'] = $content['response']['players'][0]['steamid'];
	$_SESSION['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
	$_SESSION['steam_profilestate'] = @$content['response']['players'][0]['profilestate'];
	$_SESSION['steam_personaname'] = $content['response']['players'][0]['personaname'];
	$_SESSION['steam_lastlogoff'] = @$content['response']['players'][0]['lastlogoff'];
	$_SESSION['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
	$_SESSION['steam_avatar'] = $content['response']['players'][0]['avatar'];
	$_SESSION['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
	$_SESSION['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
	$_SESSION['steam_personastate'] = $content['response']['players'][0]['personastate'];
	if (isset($content['response']['players'][0]['realname'])) { 
		   $_SESSION['steam_realname'] = $content['response']['players'][0]['realname'];
	   } else {
		   $_SESSION['steam_realname'] = "Real name not given";
	}
	$_SESSION['steam_primaryclanid'] = @$content['response']['players'][0]['primaryclanid'];
	$_SESSION['steam_timecreated'] = @$content['response']['players'][0]['timecreated'];
	$_SESSION['steam_uptodate'] = time();
	
	
    $steamprofile['steamid'] = (string)$_SESSION['steam_steamid'];
    $steamprofile['communityvisibilitystate'] = (string)@$_SESSION['steam_communityvisibilitystate'];
    $steamprofile['profilestate'] = (string)@$_SESSION['steam_profilestate'];
    $steamprofile['personaname'] = (string)htmlspecialchars(@$_SESSION['steam_personaname']);
    $steamprofile['lastlogoff'] = (string)@$_SESSION['steam_lastlogoff'];
    $steamprofile['profileurl'] = (string)@$_SESSION['steam_profileurl'];
    $steamprofile['avatar'] = (string)@$_SESSION['steam_avatar'];
    $steamprofile['avatarmedium'] = (string)htmlspecialchars(@$_SESSION['steam_avatarmedium']);
    $steamprofile['avatarfull'] = (string)htmlspecialchars(@$_SESSION['steam_avatarfull']);
    $steamprofile['personastate'] = (string)@$_SESSION['steam_personastate'];
    $steamprofile['realname'] = (string)htmlspecialchars(@$_SESSION['steam_realname']);
    $steamprofile['primaryclanid'] = (string)@$_SESSION['steam_primaryclanid'];
    $steamprofile['timecreated'] = (string)@$_SESSION['steam_timecreated'];
    $steamprofile['uptodate'] = (string)@$_SESSION['steam_uptodate'];
    
    if(isset($_SESSION['steamid'])){
        require_once("assets/php/includes/databaseConnection.php");
        $stmt = mysqli_prepare($link, "SELECT `steamid` FROM `users` WHERE `steamid` = ?");
        mysqli_stmt_bind_param($stmt, 's', $steamprofile['steamid']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        if($rows>0){ //USUÁRIO TEM CONTA
            $stmt = mysqli_prepare($link, "UPDATE `users` SET `personaname` = ?, `realname` = ?, `profilestate` = ?, `communityvisibilitystate` = ?, `profileurl` = ?, `personastate` = ?, `lastlogoff` = ?, `primaryclanid` = ?, `timecreated` = ?, `uptodate` = ?, `avatar` = ?, `avatarmedium` = ?, `avatarfull` = ? WHERE `users`.`steamid` = ? ;");
            mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $steamprofile['personaname'], $steamprofile['realname'], $steamprofile['profilestate'], $steamprofile['communityvisibilitystate'], $steamprofile['profileurl'], $steamprofile['personastate'], $steamprofile['lastlogoff'], $steamprofile['primaryclanid'], $steamprofile['timecreated'], $steamprofile['uptodate'], $steamprofile['avatar'], $steamprofile['avatarmedium'], $steamprofile['avatarfull'], $steamprofile['steamid']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else { //USUÁRIO NÃO TEM CONTA
            /*
            if(!isset($steamprofile['primaryclanid'])){
                $primaryclanid = 0;
            } else {
                $primaryclanid = $steamprofile['primaryclanid'];
            }
            if(!isset($steamprofile['timecreated'])){
                $timecreated = 0;
            } else {
                $timecreated = $steamprofile['timecreated'];
            }
            if(!isset($steamprofile['uptodate'])){
                $uptodate = 0;
            } else {
                $uptodate = $steamprofile['uptodate'];
            }
            */
            $stmt = mysqli_prepare($link, "INSERT INTO `users` (`steamid`, `personaname`, `realname`, `profilestate`, `communityvisibilitystate`, `profileurl`, `personastate`, `avatar`, `avatarmedium`, `avatarfull`, `primaryclanid`, `timecreated`, `uptodate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sssssssssssss', $steamprofile['steamid'], $steamprofile['personaname'], $steamprofile['realname'], $steamprofile['profilestate'], $steamprofile['communityvisibilitystate'], $steamprofile['profileurl'], $steamprofile['personastate'], $steamprofile['avatar'], $steamprofile['avatarmedium'], $steamprofile['avatarfull'], $steamprofile['primaryclanid'], $steamprofile['timecreated'], $steamprofile['uptodate']);
            mysqli_stmt_execute($stmt);
            if(!$stmt) {
                printf("Cannot prepare query <%s>. Error message: %s\n", $stmt, mysqli_error($link));
            }
            mysqli_stmt_close($stmt);
            //MEDALHAS
            $stmt = mysqli_prepare($link, "INSERT INTO `users_medalhas` (`userid`, `medalhaid`) VALUES (?, 1)");
            mysqli_stmt_bind_param($stmt, 's', $steamprofile['steamid']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

$steamprofile['steamid'] = $_SESSION['steam_steamid'];
$steamprofile['communityvisibilitystate'] = $_SESSION['steam_communityvisibilitystate'];
$steamprofile['profilestate'] = $_SESSION['steam_profilestate'];
$steamprofile['personaname'] = htmlspecialchars($_SESSION['steam_personaname']);
$steamprofile['lastlogoff'] = $_SESSION['steam_lastlogoff'];
$steamprofile['profileurl'] = $_SESSION['steam_profileurl'];
$steamprofile['avatar'] = $_SESSION['steam_avatar'];
$steamprofile['avatarmedium'] = $_SESSION['steam_avatarmedium'];
$steamprofile['avatarfull'] = $_SESSION['steam_avatarfull'];
$steamprofile['personastate'] = $_SESSION['steam_personastate'];
$steamprofile['realname'] = htmlspecialchars($_SESSION['steam_realname']);
$steamprofile['primaryclanid'] = $_SESSION['steam_primaryclanid'];
$steamprofile['timecreated'] = $_SESSION['steam_timecreated'];
$steamprofile['uptodate'] = $_SESSION['steam_uptodate'];

// Version 3.2