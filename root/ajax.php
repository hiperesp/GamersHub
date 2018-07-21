<?php
$thispage = "ajax_play";
include("assets/php/includes/verifyLogin.php");
include("assets/php/includes/pageConfigs.php");
require_once("assets/php/includes/databaseConnection.php");

$mapList = [
    "de_cache",
    "de_dust2",
    "de_inferno",
    "de_train",
];


function JoinServer(){
    global $link;
    global $logged;
    global $steamprofile;
    global $mapList;
    if(playerIsPlaying()==false){
        $queryMaps = "";
        if(isset($_GET['map'])){
            foreach($_GET['map'] as $key => $value){
                if($value=="1"){
                    if(in_array($key, $mapList)){
                        if(strlen($queryMaps)!=0) {
                            $queryMaps = $queryMaps." OR ";
                        }
                        $queryMaps = $queryMaps."`map` = '".$key."'";
                    }
                }
            }
        }
        if(strlen($queryMaps)==0) {
            $queryMaps = "1=1";
        }
        $stmt = mysqli_prepare($link, "SELECT `id`, `status`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5` FROM `servers` WHERE `status` = 1 AND (`userCt1` = 0 OR `userCt2` = 0 OR `userCt3` = 0 OR `userCt4` = 0 OR `userCt5` = 0 OR `userT1` = 0 OR `userT2` = 0 OR `userT3` = 0 OR `userT4` = 0 OR `userT5` = 0 OR `userCtLastUpdate1` < ".time()." OR `userCtLastUpdate2` < ".time()." OR `userCtLastUpdate3` < ".time()." OR `userCtLastUpdate4` < ".time()." OR `userCtLastUpdate5` < ".time()." OR `userTLastUpdate1` < ".time()." OR `userTLastUpdate2` < ".time()." OR `userTLastUpdate3` < ".time()." OR `userTLastUpdate4` < ".time()." OR `userTLastUpdate5` < ".time().") AND (".$queryMaps.") ORDER BY `id` ASC LIMIT 1");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $rows = mysqli_stmt_num_rows($stmt);
        if($rows>0){
            mysqli_stmt_bind_result($stmt, $server['id'], $server['status'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5']);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
            $slot = 0;
            switch(0){
                case $server['userCt1']:
                    $slot = 1;
                    $team = "Ct";
                    break;
                case $server['userT1']:
                    $slot = 1;
                    $team = "T";
                    break;
                case $server['userT2']:
                    $slot = 2;
                    $team = "T";
                    break;
                case $server['userCt2']:
                    $slot = 2;
                    $team = "Ct";
                    break;
                case $server['userCt3']:
                    $slot = 3;
                    $team = "Ct";
                    break;
                case $server['userT3']:
                    $slot = 3;
                    $team = "T";
                    break;
                case $server['userT4']:
                    $slot = 4;
                    $team = "T";
                    break;
                case $server['userCt4']:
                    $slot = 4;
                    $team = "Ct";
                    break;
                case $server['userCt5']:
                    $slot = 5;
                    $team = "Ct";
                    break;
                case $server['userT5']:
                    $slot = 5;
                    $team = "T";
                    break;
            }
            if($slot!=0){
                $stmt = mysqli_prepare($link, "UPDATE `servers` SET `user".$team.$slot."` = ".$steamprofile['steamid'].", `user".$team."LastUpdate".$slot."` = ".(time()+10)." WHERE `servers`.`id` = ".$server['id']." ;");
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "joined";
            } else {
                echo "noservers";
            }
        } else {
            echo "noservers";
        }
    } else {
        echo "already_playing";
    }
}
function playerIsPlaying(){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "SELECT `id`, `status`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5` FROM `servers` WHERE `userCt1` = ".$steamprofile['steamid']." OR `userCt2` = ".$steamprofile['steamid']." OR `userCt3` = ".$steamprofile['steamid']." OR `userCt4` = ".$steamprofile['steamid']." OR `userCt5` = ".$steamprofile['steamid']." OR `userT1` = ".$steamprofile['steamid']." OR `userT2` = ".$steamprofile['steamid']." OR `userT3` = ".$steamprofile['steamid']." OR `userT4` = ".$steamprofile['steamid']." OR `userT5` = ".$steamprofile['steamid']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $server['id'], $server['status'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5']);
    if(mysqli_stmt_num_rows($stmt)>0){
        return true;
    } else {
        return false;
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
}

function Ready(){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "SELECT `id`, `status`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5` FROM `servers` WHERE `userCt1` = ".$steamprofile['steamid']." OR `userCt2` = ".$steamprofile['steamid']." OR `userCt3` = ".$steamprofile['steamid']." OR `userCt4` = ".$steamprofile['steamid']." OR `userCt5` = ".$steamprofile['steamid']." OR `userT1` = ".$steamprofile['steamid']." OR `userT2` = ".$steamprofile['steamid']." OR `userT3` = ".$steamprofile['steamid']." OR `userT4` = ".$steamprofile['steamid']." OR `userT5` = ".$steamprofile['steamid']." LIMIT 1");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $server['id'], $server['status'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5']);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    if($server['status']==2){
        $slot = 0;
        switch($steamprofile['steamid']){
            case $server['userCt1']:
                $slot = 1;
                $team = "Ct";
                break;
            case $server['userCt2']:
                $slot = 2;
                $team = "Ct";
                break;
            case $server['userCt3']:
                $slot = 3;
                $team = "Ct";
                break;
            case $server['userCt4']:
                $slot = 4;
                $team = "Ct";
                break;
            case $server['userCt5']:
                $slot = 5;
                $team = "Ct";
                break;
            case $server['userT1']:
                $slot = 1;
                $team = "T";
                break;
            case $server['userT2']:
                $slot = 2;
                $team = "T";
                break;
            case $server['userT3']:
                $slot = 3;
                $team = "T";
                break;
            case $server['userT4']:
                $slot = 4;
                $team = "T";
                break;
            case $server['userT5']:
                $slot = 5;
                $team = "T";
                break;
        }
        if($slot!=0){
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `user".$team."Ready".$slot."` = '1', `user".$team."LastUpdate".$slot."` = ".(time()+10)." WHERE `servers`.`id` = ".$server['id']." ;");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "readyok";
        }
    }
}
function RemovePlayerFromAllServers($silent){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "SELECT `id`, `status`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5` FROM `servers` WHERE `status` = 1");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $server['id'], $server['status'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5']);
    while(mysqli_stmt_fetch($stmt)){
        $slot = 0;
        switch($steamprofile['steamid']){
            case $server["userCt1"]:
                $slot = "1";
                $team = "Ct";
                break;
            case $server["userCt2"]:
                $slot = "2";
                $team = "Ct";
                break;
            case $server["userCt3"]:
                $slot = "3";
                $team = "Ct";
                break;
            case $server["userCt4"]:
                $slot = "4";
                $team = "Ct";
                break;
            case $server["userCt5"]:
                $slot = "5";
                $team = "Ct";
                break;
            case $server["userT1"]:
                $slot = "1";
                $team = "T";
                break;
            case $server["userT2"]:
                $slot = "2";
                $team = "T";
                break;
            case $server["userT3"]:
                $slot = "3";
                $team = "T";
                break;
            case $server["userT4"]:
                $slot = "4";
                $team = "T";
                break;
            case $server["userT5"]:
                $slot = "5";
                $team = "T";
                break;
        }
        if($slot!=0){
            RemovePlayerFromServer($server['id'], $team, $slot);
        }
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    if($silent!=true){
        echo "removed";
    }
}
function RemovePlayerFromServer($id, $team, $slot){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "UPDATE `servers` SET `user".$team.$slot."` = 0, `user".$team."Ready".$slot."` = 0, `user".$team."LastUpdate".$slot."` = 0 WHERE `servers`.`id` = ".$id." ;");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function UpdatePlayerAndServer(){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "SELECT `id`, `ip`, `port`, `password`, `status`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5` FROM `servers` WHERE `userCt1` = ".$steamprofile['steamid']." OR `userCt2` = ".$steamprofile['steamid']." OR `userCt3` = ".$steamprofile['steamid']." OR `userCt4` = ".$steamprofile['steamid']." OR `userCt5` = ".$steamprofile['steamid']." OR `userT1` = ".$steamprofile['steamid']." OR `userT2` = ".$steamprofile['steamid']." OR `userT3` = ".$steamprofile['steamid']." OR `userT4` = ".$steamprofile['steamid']." OR `userT5` = ".$steamprofile['steamid']." LIMIT 1");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $server['id'], $server['ip'], $server['port'], $server['password'], $server['status'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5']);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    if($server['status']==1){
        $slot = 0;
        switch($steamprofile['steamid']){
            case $server['userCt1']:
                $slot = 1;
                $team = "Ct";
                break;
            case $server['userCt2']:
                $slot = 2;
                $team = "Ct";
                break;
            case $server['userCt3']:
                $slot = 3;
                $team = "Ct";
                break;
            case $server['userCt4']:
                $slot = 4;
                $team = "Ct";
                break;
            case $server['userCt5']:
                $slot = 5;
                $team = "Ct";
                break;
            case $server['userT1']:
                $slot = 1;
                $team = "T";
                break;
            case $server['userT2']:
                $slot = 2;
                $team = "T";
                break;
            case $server['userT3']:
                $slot = 3;
                $team = "T";
                break;
            case $server['userT4']:
                $slot = 4;
                $team = "T";
                break;
            case $server['userT5']:
                $slot = 5;
                $team = "T";
                break;
        }
        if($slot!=0){
            $stmt = mysqli_prepare($link, "UPDATE `servers` SET `user".$team.$slot."` = ".$steamprofile['steamid'].", `user".$team."LastUpdate".$slot."` = ".(time()+10)." WHERE `servers`.`id` = ".$server['id']." ;");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "waiting...";
        } else {
            echo "nomatch";
        }
    } else if($server['status']==2){
        echo "ready";
        /*
        READY
        */
    } else if($server['status']==3){
        if(strlen(@$server['password'])==32) {
            echo 'steam://connect/', $server['ip'], ':', $server['port'], '/', $server['password'], "\n";
            echo "connect ", $server['ip'], ":", $server['port'], ";password ", $server['password'];
        } else {
            echo "javascript:alert('Estamos preparando o servidor para receber a partida.')", "\n";
            echo "Configurando o servidor...";
        }
    }
}
function updateAll(){
    global $link;
    global $logged;
    global $steamprofile;
    $stmt = mysqli_prepare($link, "SELECT `id`, `ip`, `port`, `map`, `status`, `readyTime`, `gameid`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5`, `userCtReady1`, `userCtReady2`, `userCtReady3`, `userCtReady4`, `userCtReady5`, `userTReady1`, `userTReady2`, `userTReady3`, `userTReady4`, `userTReady5`, `userCtLastUpdate1`, `userCtLastUpdate2`, `userCtLastUpdate3`, `userCtLastUpdate4`, `userCtLastUpdate5`, `userTLastUpdate1`, `userTLastUpdate2`, `userTLastUpdate3`, `userTLastUpdate4`, `userTLastUpdate5`, `ping` FROM `servers`");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $server['id'], $server['ip'], $server['port'], $server['map'], $server['status'], $server['readyTime'], $server['gameid'], $server['userCt1'], $server['userCt2'], $server['userCt3'], $server['userCt4'], $server['userCt5'], $server['userT1'], $server['userT2'], $server['userT3'], $server['userT4'], $server['userT5'], $server['userCtReady1'], $server['userCtReady2'], $server['userCtReady3'], $server['userCtReady4'], $server['userCtReady5'], $server['userTReady1'], $server['userTReady2'], $server['userTReady3'], $server['userTReady4'], $server['userTReady5'],  $server['userCtLastUpdate1'], $server['userCtLastUpdate2'], $server['userCtLastUpdate3'], $server['userCtLastUpdate4'], $server['userCtLastUpdate5'], $server['userTLastUpdate1'], $server['userTLastUpdate2'], $server['userTLastUpdate3'], $server['userTLastUpdate4'], $server['userTLastUpdate5'], $server['ping']);
    $rows = mysqli_stmt_num_rows($stmt);
    if($rows>0){
        while(mysqli_stmt_fetch($stmt)){
            if($server['status']==1||$server['status']==2||$server['status']==3){
                if(time()>$server['ping']){
                    $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `status` = 0, `ping` = 0, `userCt1` = 0, `userCt2` = 0, `userCt3` = 0, `userCt4` = 0, `userCt5` = 0, `userT1` = 0, `userT2` = 0, `userT3` = 0, `userT4` = 0, `userT5` = 0, `userCtReady1` = 0, `userCtReady2` = 0, `userCtReady3` = 0, `userCtReady4` = 0, `userCtReady5` = 0, `userTReady1` = 0, `userTReady2` = 0, `userTReady3` = 0, `userTReady4` = 0, `userTReady5` = 0, `userCtLastUpdate1` = 0, `userCtLastUpdate2` = 0, `userCtLastUpdate3` = 0, `userCtLastUpdate4` = 0, `userCtLastUpdate5` = 0, `userTLastUpdate1` = 0, `userTLastUpdate2` = 0, `userTLastUpdate3` = 0, `userTLastUpdate4` = 0, `userTLastUpdate5` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);
                    $stmt2 = mysqli_prepare($link, "SELECT `gameid`,`game_status`, `ping` FROM `games`");
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_store_result($stmt2);
                        mysqli_stmt_bind_result($stmt2, $game['id'], $game['status'], $game['ping']);
                    $rows = mysqli_stmt_num_rows($stmt2);
                    if($rows>0){
                        while(mysqli_stmt_fetch($stmt2)){
                            if($game['status']==0||$game['status']==1){
                                $stmt3 = mysqli_prepare($link, "UPDATE `games` SET `game_status` = 2, `match_result` = 3 WHERE `games`.`gameid` = ".$game['id'].";");
                                mysqli_stmt_execute($stmt3);
                                mysqli_stmt_close($stmt3);
                            }
                        }
                    }
                    mysqli_stmt_close($stmt2);
                } else {
                    if($server['status']==1){
                        if(time()>$server['userCtLastUpdate1']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userCt1` = 0, `userCtReady1` = 0, `userCtLastUpdate1` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userCtLastUpdate2']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userCt2` = 0, `userCtReady2` = 0, `userCtLastUpdate2` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userCtLastUpdate3']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userCt3` = 0, `userCtReady3` = 0, `userCtLastUpdate3` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userCtLastUpdate4']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userCt4` = 0, `userCtReady4` = 0, `userCtLastUpdate4` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userCtLastUpdate5']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userCt5` = 0, `userCtReady5` = 0, `userCtLastUpdate5` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userTLastUpdate1']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userT1` = 0, `userTReady1` = 0, `userTLastUpdate1` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userTLastUpdate2']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userT2` = 0, `userTReady2` = 0, `userTLastUpdate2` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userTLastUpdate3']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userT3` = 0, `userTReady3` = 0, `userTLastUpdate3` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userTLastUpdate4']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userT4` = 0, `userTReady4` = 0, `userTLastUpdate4` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['userTLastUpdate5']){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `userT5` = 0, `userTReady5` = 0, `userTLastUpdate5` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else {
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `readyTime` = '".(time()+60)."', `status` = 2 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                            //*readybutton
                        }
                    }
                    if($server['status']==2){
                        $uCt1R = 0;
                        $uCt2R = 0;
                        $uCt3R = 0;
                        $uCt4R = 0;
                        $uCt5R = 0;
                        $uT1R = 0;
                        $uT2R = 0;
                        $uT3R = 0;
                        $uT4R = 0;
                        $uT5R = 0;
                        if(1==$server['userCtReady1']){
                            $uCt1R = 1;
                        }
                        if(1==$server['userCtReady2']){
                            $uCt2R = 1;
                        }
                        if(1==$server['userCtReady3']){
                            $uCt3R = 1;
                        }
                        if(1==$server['userCtReady4']){
                            $uCt4R = 1;
                        }
                        if(1==$server['userCtReady5']){
                            $uCt5R = 1;
                        }
                        if(1==$server['userTReady1']){
                            $uT1R = 1;
                        }
                        if(1==$server['userTReady2']){
                            $uT2R = 1;
                        }
                        if(1==$server['userTReady3']){
                            $uT3R = 1;
                        }
                        if(1==$server['userTReady4']){
                            $uT4R = 1;
                        }
                        if(1==$server['userTReady5']){
                            $uT5R = 1;
                        }
                        if($uCt1R==1&&$uCt2R==1&&$uCt3R==1&&$uCt4R==1&&$uCt5R==1&&$uT1R==1&&$uT2R==1&&$uT3R==1&&$uT4R==1&&$uT5R==1){
                            $stmt2 = mysqli_prepare($link, "INSERT INTO `games` (`gameid`, `game_status`, `team_ct_id`, `team_ct_win_count`, `team_t_id`, `team_t_win_count`, `team_ct_player1`, `team_ct_player2`, `team_ct_player3`, `team_ct_player4`, `team_ct_player5`, `team_t_player1`, `team_t_player2`, `team_t_player3`, `team_t_player4`, `team_t_player5`, `winner_of_round1`, `winner_of_round2`, `winner_of_round3`, `winner_of_round4`, `winner_of_round5`, `winner_of_round6`, `winner_of_round7`, `winner_of_round8`, `winner_of_round9`, `winner_of_round10`, `winner_of_round11`, `winner_of_round12`, `winner_of_round13`, `winner_of_round14`, `winner_of_round15`, `winner_of_round16`, `winner_of_round17`, `winner_of_round18`, `winner_of_round19`, `winner_of_round20`, `winner_of_round21`, `winner_of_round22`, `winner_of_round23`, `winner_of_round24`, `winner_of_round25`, `winner_of_round26`, `winner_of_round27`, `winner_of_round28`, `winner_of_round29`, `winner_of_round30`, `winner_of_round31`, `match_result`) VALUES (NULL, '0', '0', '0', '0', '0', '".$server['userCt1']."','".$server['userCt2']."','".$server['userCt3']."','".$server['userCt4']."','".$server['userCt5']."','".$server['userT1']."','".$server['userCt2']."','".$server['userT3']."','".$server['userCt4']."','".$server['userT5']."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');");
                            mysqli_stmt_execute($stmt2);
                            $gameid = mysqli_stmt_insert_id($stmt2);
                            mysqli_stmt_close($stmt2);
                            
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `status` = 3, `gameid` = ".$gameid." WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        	$rcon_server    = $server['ip'];
                        	$rcon_port		= $server['port'];
                            include("../private_server/validate_key.php");
                        	$rcon_password = generate_key($rcon_port);
                        	require_once('../private_server/rcon.php');
                        	
                        	$rcon_command = "";
                            //Altera a senha do Servidor para receber conexões de usuários
                                $password = md5(rand());
                                //nl2br($rcon->command("sv_password ".$password));
                                $rcon_command = $rcon_command.";sv_password ".$password;
                            //Manda o servidor carregar o Mapa.
                                //nl2br($rcon->command("map ".$server['map']));
                                $rcon_command = $rcon_command.";map ".$server['map'];
                                
                            //Define a id do jogo que será rodado no servidor
                                //nl2br($rcon->command("gameId ".$gameid));
                                $rcon_command = $rcon_command.";gameId ".$gameid;
                                
                            //Adiciona os jogadores na whitelist do servidor
                                //CT
                                    //nl2br($rcon->command("userCt1 ".$server['userCt1']));
                                    //nl2br($rcon->command("userCt2 ".$server['userCt2']));
                                    //nl2br($rcon->command("userCt3 ".$server['userCt3']));
                                    //nl2br($rcon->command("userCt4 ".$server['userCt4']));
                                    //nl2br($rcon->command("userCt5 ".$server['userCt5']));
                                    $rcon_command = $rcon_command.";userCt1 ".$server['userCt1'];
                                    $rcon_command = $rcon_command.";userCt2 ".$server['userCt2'];
                                    $rcon_command = $rcon_command.";userCt3 ".$server['userCt3'];
                                    $rcon_command = $rcon_command.";userCt4 ".$server['userCt4'];
                                    $rcon_command = $rcon_command.";userCt5 ".$server['userCt5'];
                                //TR
                                    //nl2br($rcon->command("userT1 ".$server['userT1']));
                                    //nl2br($rcon->command("userT2 ".$server['userT2']));
                                    //nl2br($rcon->command("userT3 ".$server['userT3']));
                                    //nl2br($rcon->command("userT4 ".$server['userT4']));
                                    //nl2br($rcon->command("userT5 ".$server['userT5']));
                                    $rcon_command = $rcon_command.";userT1 ".$server['userT1'];
                                    $rcon_command = $rcon_command.";userT2 ".$server['userT2'];
                                    $rcon_command = $rcon_command.";userT3 ".$server['userT3'];
                                    $rcon_command = $rcon_command.";userT4 ".$server['userT4'];
                                    $rcon_command = $rcon_command.";userT5 ".$server['userT5'];
                            
                            //Executa o warmup no servidor.
                                //nl2br($rcon->command("core_startwarmup"));
                                $rcon_command = $rcon_command.";core_startwarmup";
                                
                            
                            nl2br($rcon->command($rcon_command));
                            
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `password` = '".$password."' WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else if(time()>$server['readyTime']+20){
                            $stmt2 = mysqli_prepare($link, "UPDATE `servers` SET `status` = 1,  `readyTime` = 0, `gameid` = 0, `userCt1` = 0,  `userCt2` = 0, `userCt3` = 0, `userCt4` = 0, `userCt5` = 0, `userT1` = 0, `userT2` = 0, `userT3` = 0, `userT4` = 0, `userT5` = 0, `userCtReady1` = 0, `userCtReady2` = 0, `userCtReady3` = 0, `userCtReady4` = 0, `userCtReady5` = 0, `userTReady1` = 0, `userTReady2` = 0, `userTReady3` = 0, `userTReady4` = 0, `userTReady5` = 0, `userCtLastUpdate1` = 0, `userCtLastUpdate2` = 0, `userCtLastUpdate3` = 0, `userCtLastUpdate4` = 0, `userCtLastUpdate5` = 0, `userTLastUpdate1` = 0, `userTLastUpdate2` = 0, `userTLastUpdate3` = 0, `userTLastUpdate4` = 0, `userTLastUpdate5` = 0 WHERE `servers`.`id` = ".$server['id']." ;");
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        }
                    }
                }
            }
        }
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    
}
switch(@$_GET["action"]){
    case "join":
        updateAll();
        JoinServer();
        break;
    case "leave":
        updateAll();
        RemovePlayerFromAllServers("");
        break;
    case "ready":
        updateAll();
        Ready();
        break;
    case "update":
        UpdatePlayerAndServer();
        updateAll();
        break;
    default:
        updateAll();
        break;
}