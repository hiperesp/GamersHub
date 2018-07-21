<?php
$thispage = "inicio";
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
        <div class="background">
            <div class="paddingcontainer container">
<?php
if($logged==true){
?>
                <h2 class="subtitle">Ficamos felizes que você faz parte do melhor clube sério de <span class="bold">Counter-Strike: Source*</span> do mundo**</h2>
                <h1 class="title titlecontent">O que está perdendo?</h1>
				<a href="<?php echo alinks('play', null); ?>">
					<div class="playButton" style="margin-left:auto;margin-right:auto;">
						<div class="playButtonTextContainer">
							<h1 class="playButtonTextContent">Comece a jogar</h1>
							<h4 class="subtitle">na GamersHub!</h4>
						</div>
					</div>
				</a>
                <h6 class="subtitle subtitleasterisk">*Somente para PC;</h6>
                <h6 class="subtitle subtitleasterisk">**Fonte: expectativa.</h6>
<?php
} else {
?>
                <h2 class="subtitle">Falta pouco para você fazer parte do melhor clube sério de <span class="bold">Counter-Strike: Source</span>* do mundo**</h2>
                <h1 class="title titlecontent">Inscreva-se,<br><span class="siteColor">é Grátis!</span></h1>
				<a href="<?php echo alinks('login', null); ?>">
					<div class="signInThroughSteam" style="margin-left:auto;margin-right:auto;">
						<div class="signInThroughSteamImage">
							<img src="<?php echo alinks('base', null); ?>assets/images/steam.png" width="120px">
						</div>
						<div class="signInThroughSteamTextContainer">
							<h1 class="signInThroughSteamTextContent">Sign in through STEAM&reg;</h1>
							<h4 class="subtitle">This site is not associated with Valve Corp.</h4>
						</div>
					</div>
				</a>
                <h6 class="subtitle subtitleasterisk">*Somente para PC;</h6>
                <h6 class="subtitle subtitleasterisk">**Fonte: expectativa.</h6>
<?php
}
?>
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