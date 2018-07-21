<?php
$thispage = "servers";
include("assets/php/includes/verifyLogin.php");
include("assets/php/includes/pageConfigs.php");





?>
<!DOCTYPE html>
<html>
    <head>
<?php
include("assets/html/head_meta.php");
?>
        <title>GamersHub<?php echo $title; ?></title>
<?php
include("assets/html/head_linkrel.php");
include("assets/html/head_script.php");
?>
    </head>
    <body>
<?php
include("assets/html/header.php");
?>
        <div class="main">
            <div class="paddingtopcontainer container">
                <div class="profileInfo2">
                    <h1 class="titleSitetitle"><span>Nossos</span> <span class="siteColor">Servidores</span></h1>
                    <br>
                    <div class="section">
                        <div id="quest1">
                            <h2>Veja abaixo todos os nossos servidores.</h2>
                            <div class="sectionItemListSuporte">
<?php
require_once("assets/php/includes/databaseConnection.php");

$stmt = mysqli_prepare($link, "SELECT `id`, `ip`, `port`, `map`, `status`, `phisical_state` FROM `servers`");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$rows = mysqli_stmt_num_rows($stmt);
if($rows>1){
    mysqli_stmt_bind_result($stmt, $server['id'], $server['ip'], $server['port'], $server['map'], $server['status'], $server['phisical_state']);
    while(mysqli_stmt_fetch($stmt)){
        if($server['status']==0){               //DESLIGADO
            if($server['phisical_state']==0){   //NÃO IMPLANTADO
                $status = "Não implementado";
                $statusColor = "inherit";
            } else {
                $status = "Desligado";
                $statusColor = "#990000";
            }
        } else if($server['status']==1||$server['status']==2||$server['status']==3){        //LIGADO OU EM READY (mas ligado) OU EM PARTIDA (mas ligado)
            if($server['phisical_state']==0){                                               //NÃO IMPLANTADO
                $status = "BETA";
                $statusColor = "#999900";
            } else {
                $status = "Disponível";
                $statusColor = "#009900";
            }
        } else {
            $status = "Em configuração";
            $statusColor = "inherit";
        }
        $ip = $server['ip'].":".$server['port'];
        echo '                                <a href="'.alinks("play", null).'">';
        echo '                                    <p class="supportLink">Servidor '.$server['id'].' ('.$server['map'].'): <span style="font-weight: 700;color: '.$statusColor.'">'.$status.'</span> '.$ip.'</p>';
        echo '                                </a>';
    }
} else {
    
}
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
include("assets/html/footer.php");
?>
        <div>
            <script type="text/javascript" src="<?php echo alinks('base', null); ?>assets/js/script.js"></script>
        </div>
    </body>
</html>