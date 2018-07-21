<?php
$thispage = "play";
include("assets/php/includes/verifyLogin.php");
include("assets/php/includes/getGames.php");
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
        <div class="main background">
            <div class="paddingcontainer container">
                <div class="profileInfo2 play">
                    <h1 class="title playText">Jogar</h1>
                    <p>Atenção: Todos os servidores são destinados ao modo competitivo, então jogar com o intuito de prejudicar alguém ou destinar o servidor para outros modos resulta em punições.</p>
                    <!--div class="mapSelector">
                        <div class="map" id="mapSelectorMap_de_dust2" style="border-color: #00ff00;background-image: linear-gradient(to right, rgba(0,150,0,1),rgba(0,150,0,0.2), rgba(0,150,0,.5)),url(assets/images/background/de_dust2/1.jpg);">
                            <input type="checkbox" id="mapSelector_de_dust2" title="Clique para alternar a seleção deste mapa.">
                            <p>de_dust2</p>
                        </div>
                    </div-->
                    <div class="games" id="games">

                    </div>
                </div>
            </div>
        </div>
<?php
include("assets/html/footer.php");
?>
        <div>
            <script type="text/javascript" src="<?php echo alinks('base', null); ?>assets/js/script.js"></script>
            <script type="text/javascript" src="<?php echo alinks('base', null); ?>assets/js/play.js"></script>
        </div>
    </body>
</html>