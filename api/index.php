<?php
include("../private_server/validate_key.php");
require_once("../root/assets/php/includes/databaseConnection.php");

$port   	= @$_GET['port'];
$id  		= @$_GET['id'];
$key	    = @$_GET['key'];
$action 	= @$_GET['action'];
$gameid 	= @$_GET['gameid'];
$t_score 	= @$_GET['t_score'];
$ct_score 	= @$_GET['ct_score'];
$killer 	= @$_GET['killer'];
$dead 		= @$_GET['dead'];
if(validate_key($key, $port)!=true){
    exit;
}
function action($action){
    global $link;
    global $port;
    switch($action){
//PING
        case "ping":
            $gameid = @$_GET['gameid'];
            $id   = @$_GET['id'];
            $stmt = mysqli_prepare($link, "SELECT `status` FROM `servers` WHERE `id` = ".$id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $server['status']);
            $rows = mysqli_stmt_num_rows($stmt);
            if($rows>0){
                mysqli_stmt_fetch($stmt);
                if($server['status']==0){
                    action("start");
                }
            }
            mysqli_stmt_close($stmt);
            if($gameid>0){
                $stmt = mysqli_prepare($link, "UPDATE `games` SET `ping` = ".(time()+60)." WHERE `games`.`gameid` = ".$gameid.";");
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `ping` = ".(time()+60)." WHERE `servers`.`id` = ".$id.";");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            break;
//COMPETITIVE
        case "competitive":
            $gameid = @$_GET['gameid'];
            $stmt = mysqli_prepare($link, "UPDATE `games` SET `game_status` = '1' WHERE `games`.`gameid` = ".$gameid.";");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            break;
//WARMUP
        case "warmup":
            $gameid = @$_GET['gameid'];
            $stmt = mysqli_prepare($link, "UPDATE `games` SET `game_status` = '0' WHERE `games`.`gameid` = ".$gameid.";");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            break;
//FINISHGAME
        case "finish":
            $gameid = @$_GET['gameid'];
            $id   = @$_GET['id'];
            $port;
            $t_score = @$_GET['t_score'];
            $ct_score = @$_GET['ct_score'];
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `status` = 0,  `readyTime` = 0, `gameid` = 0, `userCt1` = 0,  `userCt2` = 0, `userCt3` = 0, `userCt4` = 0, `userCt5` = 0, `userT1` = 0, `userT2` = 0, `userT3` = 0, `userT4` = 0, `userT5` = 0, `userCtReady1` = 0, `userCtReady2` = 0, `userCtReady3` = 0, `userCtReady4` = 0, `userCtReady5` = 0, `userTReady1` = 0, `userTReady2` = 0, `userTReady3` = 0, `userTReady4` = 0, `userTReady5` = 0, `userCtLastUpdate1` = 0, `userCtLastUpdate2` = 0, `userCtLastUpdate3` = 0, `userCtLastUpdate4` = 0, `userCtLastUpdate5` = 0, `userTLastUpdate1` = 0, `userTLastUpdate2` = 0, `userTLastUpdate3` = 0, `userTLastUpdate4` = 0, `userTLastUpdate5` = 0 WHERE `servers`.`id` = ".$id." ;");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if($ct_score>$t_score){
                $winner = "1";
            } else {
                $winner = "2";
            }
            $stmt = mysqli_prepare($link, "UPDATE `games` SET `team_ct_win_count` = '".$ct_score."', `team_t_win_count`= '".$t_score."', `match_result` = '".$winner."', `game_status` = '2' WHERE `games`.`gameid` = ".$gameid.";");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            include("../private_server/validate_key.php");
        	$rcon_password = generate_key($port);
        	require_once('../private_server/rcon.php');
        	
        	$rcon_command = "";
            $rcon_command = $rcon_command."sm plugins unload_all";
            $rcon_command = $rcon_command.";sm plugins refresh";
            nl2br($rcon->command($rcon_command));
            break;
//CANCELGAME
        case "gameCancel":
            $gameid = @$_GET['gameid'];
            $id   = @$_GET['id'];
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `status` = 0,  `readyTime` = 0, `gameid` = 0, `userCt1` = 0,  `userCt2` = 0, `userCt3` = 0, `userCt4` = 0, `userCt5` = 0, `userT1` = 0, `userT2` = 0, `userT3` = 0, `userT4` = 0, `userT5` = 0, `userCtReady1` = 0, `userCtReady2` = 0, `userCtReady3` = 0, `userCtReady4` = 0, `userCtReady5` = 0, `userTReady1` = 0, `userTReady2` = 0, `userTReady3` = 0, `userTReady4` = 0, `userTReady5` = 0, `userCtLastUpdate1` = 0, `userCtLastUpdate2` = 0, `userCtLastUpdate3` = 0, `userCtLastUpdate4` = 0, `userCtLastUpdate5` = 0, `userTLastUpdate1` = 0, `userTLastUpdate2` = 0, `userTLastUpdate3` = 0, `userTLastUpdate4` = 0, `userTLastUpdate5` = 0 WHERE `servers`.`id` = ".$id." ;");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($link, "UPDATE `games` SET `game_status` = '2', `match_result` = '3' WHERE `gameid` = ".$gameid.";");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            include("../private_server/validate_key.php");
        	$rcon_password = generate_key($port);
        	require_once('../private_server/rcon.php');
        	
        	$rcon_command = "";
            $rcon_command = $rcon_command."sm plugins unload_all";
            $rcon_command = $rcon_command.";sm plugins refresh";
            nl2br($rcon->command($rcon_command));
            break;
//START
        case "start":
            $gameid = @$_GET['gameid'];
            $id   = @$_GET['id'];
            $stmt = mysqli_prepare($link, "SELECT `gameid` FROM `servers` WHERE `id` = ".$id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $server['gameid']);
            while(mysqli_stmt_fetch($stmt)){
                $stmt2 = mysqli_prepare($link, "UPDATE `games` SET `game_status` = '2', `match_result` = '3' WHERE `games`.`gameid` = ".$gameid.";");
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            }
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `status` = 1,  `readyTime` = 0, `password` = '', `gameid` = 0, `userCt1` = 0,  `userCt2` = 0, `userCt3` = 0, `userCt4` = 0, `userCt5` = 0, `userT1` = 0, `userT2` = 0, `userT3` = 0, `userT4` = 0, `userT5` = 0, `userCtReady1` = 0, `userCtReady2` = 0, `userCtReady3` = 0, `userCtReady4` = 0, `userCtReady5` = 0, `userTReady1` = 0, `userTReady2` = 0, `userTReady3` = 0, `userTReady4` = 0, `userTReady5` = 0, `userCtLastUpdate1` = 0, `userCtLastUpdate2` = 0, `userCtLastUpdate3` = 0, `userCtLastUpdate4` = 0, `userCtLastUpdate5` = 0, `userTLastUpdate1` = 0, `userTLastUpdate2` = 0, `userTLastUpdate3` = 0, `userTLastUpdate4` = 0, `userTLastUpdate5` = 0, `ping` = ".(time()+60)." WHERE `servers`.`id` = ".$id." ;");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            break;
//KILL
        case "kill":
            $killer = @$_GET['killer'];
            $dead = @$_GET['dead'];
            if(strlen($killer)<17){
                $killer = "0";
            }
            if(strlen($dead)<17){
                $dead = "0";
            }
            $stmt = mysqli_prepare($link, "UPDATE `users` SET `kills` = kills+1 WHERE `steamid` = ".$killer);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $stmt = mysqli_prepare($link, "UPDATE `users` SET `deaths` = deaths+1 WHERE `steamid` = ".$dead);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            break;
//FIM
    }
}
action($action);