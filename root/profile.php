<?php
$thispage = "profile";
include("assets/php/includes/verifyLogin.php");
include("assets/php/includes/getProfiles.php");
include("assets/php/includes/pageConfigs.php");



if($profile['exists']==false){
    header("Location: ".alinks("profile", "0"));
    exit;
}



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
        <div class="background">
            <div class="paddingcontainer container">
                <div class="profileInfo">
                    <div class="profileImage">
                        <img src="<?php echo $profile['avatarfull']; ?>">
                    </div>
                    <div class="profileAbstract">
                        <h1 class="profileName"><?php echo $profile['personaname']; ?></h1>
                        <h6 class="profileSubtitle subtitle"><span class="bold">GamersHub ID: </span><?php echo $profile['steamid']; ?></h6>
                        <h1 class="profileSubtitle subtitle"><span class="bold">Level: </span><?php
if($profile['level']==0){
    echo '<span class="upper">Unranked</span>';
} else {
    echo '<span class="badge badge-huge level-'.$profile['level'].'"><p></p></span>';
} ?></h1>
                        <h1 class="profileSubtitle subtitle"><?php
switch ($profile['rank']){
    case -1:
        echo "Banido";
        break;
    case 0:
        echo "Player";
        break;
    case 1:
        echo "Vip";
        break;
    case 100:
        echo "Admin";
        break;
    case 1000:
        echo "own";
        break;
}
?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="paddingtopcontainer container">
                <div class="profileInfo2">
                    <h1 class="profileRealName"><?php
if($profile['realname']=="Real name not given") {
    echo $profile['personaname'];
} else {
    echo $profile['realname'];
}
?></h1>
                    <a href="<?php echo $profile['profileurl']; ?>" target="_blank">
                        <h5 class="profileSteam">Ver perfil Steam</h5>
                    </a>
                    <br>
                    <div class="section">
                        <h2 id="medalhas">Medalhas obtidas</h2>
                        <div class="sectionItemList">
<?php
    $stmt = mysqli_prepare($link, "SELECT `medalhaid`, `obtidaem` FROM `users_medalhas` WHERE `userid` = ? ORDER BY `id` DESC");
    mysqli_stmt_bind_param($stmt, 's', $profile['steamid']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $medalha['medalhaid'], $medalha['obtidaem']);
    while (mysqli_stmt_fetch($stmt)) {
        $stmt2 = mysqli_prepare($link, "SELECT `medalha`, `descricao` FROM `medalhas` WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt2, 's', $medalha['medalhaid']);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);
        mysqli_stmt_bind_result($stmt2, $medalha['name'], $medalha['description']);
        mysqli_stmt_fetch($stmt2);
            echo '<div class="sectionItem" title="'.$medalha['description'].'" style="background-color: rgba(0,0,0,0.0);background-image: url(\''.alinks('base', null).'assets/images/medalhas/'.strtolower($medalha['name']).'.png\');">';
            echo '  <p class="sectionItemTitle">'.$medalha['name'].'</p>';
            echo '  <p class="sectionItemSubTitle">'.$medalha['obtidaem'].'</p>';
            echo '</div>';
        mysqli_stmt_free_result($stmt2);
        mysqli_stmt_close($stmt2);
    }
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
?>
                        </div>
                    </div>
                    <div class="section">
                        <h2 id="medalhas">Estatísticas</h2>
                        <div class="sectionItemList">
                            <div class="sectionItem" title="Matou: <?php echo $profile['kills']; ?>" style="background-image: url('<?php echo alinks('base', null); ?>assets/images/estatisticas/kills.png');">
                                <p class="sectionItemTitle">Abates</p>
                                <p class="sectionItemSubTitle"><?php echo $profile['kills']; ?></p>
                            </div>
                            <div class="sectionItem" title="Morreu: <?php echo $profile['deaths']; ?>" style="background-image: url('<?php echo alinks('base', null); ?>assets/images/estatisticas/deaths.png');">
                                <p class="sectionItemTitle">Mortes</p>
                                <p class="sectionItemSubTitle"><?php echo $profile['deaths']; ?></p>
                            </div>
                            <div class="sectionItem" title="Relação entre Abates e Mortes: <?php
if($profile['deaths']!=0){
    echo $profile['kills']/$profile['deaths'];
} else {
    echo 1;
}
?>" style="background-image: url('<?php echo alinks('base', null); ?>assets/images/estatisticas/relation.png');">
                                <p class="sectionItemTitle">Relação</p>
                                <p class="sectionItemSubTitle"><?php
if($profile['deaths']!=0){
    echo $profile['kills']/$profile['deaths'];
} else {
    echo 1;
}
?></p>
                            </div>
                        </div>
                    </div>
                    <!--div class="sectionFixed">
                        <h2 id="historico">Últimas Partidas</h2>
                        <div class="sectionItemList">
                            <table class="historyTable">
                                <thead>
                                    <tr class="historyLine historyTitle">
                                        <td></td>
                                        <td>Data</td>
                                        <td>Horário</td>
                                        <td>Modo</td>
                                        <td>Mapa</td>
                                        <td>PTS</td>
                                        <td>V</td>
                                        <td>M</td>
                                        <td>Destaques</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="historyLine historyWin">
                                        <td class="historyTitle titleWin">Vencedor</td>
                                        <td>10/05/2018</td>
                                        <td>10:01</td>
                                        <td>Competitivo</td>
                                        <td>de_dust2</td>
                                        <td>15</td>
                                        <td>10</td>
                                        <td>20</td>
                                        <td>2<span class="star">★</span></td>
                                    </tr>
                                    <tr class="historyLine historyLose">
                                        <td class="historyTitle titleLose">Perdedor</td>
                                        <td>10/05/2018</td>
                                        <td>09:01</td>
                                        <td>Competitivo</td>
                                        <td>de_dust2</td>
                                        <td>15</td>
                                        <td>10</td>
                                        <td>20</td>
                                        <td>2<span class="star">★</span></td>
                                    </tr>
                                    <tr class="historyLine historyDraw">
                                        <td class="historyTitle titleDraw">Empate</td>
                                        <td>10/05/2018</td>
                                        <td>08:01</td>
                                        <td>Competitivo</td>
                                        <td>de_dust2</td>
                                        <td>15</td>
                                        <td>10</td>
                                        <td>20</td>
                                        <td>2<span class="star">★</span></td>
                                    </tr>
                                    <tr class="historyLine">
                                        <td class="historyTitle titleWin">Parabéns!</td>
                                        <td>Se você está vendo isso, </td>
                                        <td>aguarde... Em breve</td>
                                        <td>tentaremos aplicar</td>
                                        <td>um histórico de partidas</td>
                                        <td>contendo as suas</td>
                                        <td>últimas 5 partidas.</td>
                                        <td>Caso tenha alguma sugestão</td>
                                        <td>Entre em contato <span class="star">★</span></td>
                                        <td style="display:none">gabrielramos149@gmail.com</td>
                                    </tr>
                                </table>
                            </tbody>
                        </div>
                    </div-->
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