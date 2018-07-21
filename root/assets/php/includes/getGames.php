<?php
require_once("assets/php/includes/databaseConnection.php");


$stmt = mysqli_prepare($link, "SELECT `id`, `ip`, `port`, `status`, `userCt1`, `userCt2`, `userCt3`, `userCt4`, `userCt5`, `userT1`, `userT2`, `userT3`, `userT4`, `userT5` FROM `servers` /* WHERE `status` = 1*/"); // status 1 = ligado, 0 = desligado, 2 = em jogo
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $currentserver['id'], $currentserver['ip'], $currentserver['port'], $currentserver['status'], $currentserver['userCt1'], $currentserver['userCt2'], $currentserver['userCt3'], $currentserver['userCt4'], $currentserver['userCt5'], $currentserver['userT1'], $currentserver['userT2'], $currentserver['userT3'], $currentserver['userT4'], $currentserver['userT5']);
while(mysqli_stmt_fetch($stmt)){
    $server[$currentserver['id']]["ip"] = $currentserver['ip'];
    $server[$currentserver['id']]["port"] = $currentserver['port'];
    $server[$currentserver['id']]["status"] = $currentserver['status'];
    $server[$currentserver['id']]["userCt1"] = $currentserver['userCt1'];
    $server[$currentserver['id']]["userCt2"] = $currentserver['userCt2'];
    $server[$currentserver['id']]["userCt3"] = $currentserver['userCt3'];
    $server[$currentserver['id']]["userCt4"] = $currentserver['userCt4'];
    $server[$currentserver['id']]["userCt5"] = $currentserver['userCt5'];
    $server[$currentserver['id']]["userT1"] = $currentserver['userT1'];
    $server[$currentserver['id']]["userT2"] = $currentserver['userT2'];
    $server[$currentserver['id']]["userT3"] = $currentserver['userT3'];
    $server[$currentserver['id']]["userT4"] = $currentserver['userT4'];
    $server[$currentserver['id']]["userT5"] = $currentserver['userT5'];
}
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);

//ESSE ARQUIVO FAZ PARTE DO ARQUIVO play.php
//ELE FUNCIONARÁ COMO UM ARQUIVO QUE LÊ O BANCO DE DADOS E RETORNA AS INFORMAÇÕES DOS SERVIDORES.
