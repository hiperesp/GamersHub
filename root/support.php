<?php
$thispage = "support";
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
<?php
if(isset($_SESSION['steamid'])){
?>
        <div class="background">
            <div class="paddingcontainer container">
                <div class="profileInfo">
                    <div class="profileImage">
                        <img class="pc" src="<?php echo $steamprofile['avatarmedium']; ?>">
                        <img class="mobile" src="<?php echo $steamprofile['avatarfull']; ?>">
                    </div>
                    <div class="profileAbstract">
                        <h1 class="profileName"><?php echo $steamprofile['personaname']; ?></h1>
                        <h6 class="profileSubtitle subtitle"><span class="bold">GamersHub ID: </span><?php echo $steamprofile['steamid']; ?></h6>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?>
        <div class="main">
            <div class="paddingtopcontainer container">
                <div class="profileInfo2">
                    <h1 class="titleSitetitle"><span>S</span><span class="lower">uporte </span><span>GAMERS</span><span class="siteColor">HUB</span></h1>
                    <br>
                    <div class="section">
                        <div id="quest1">
                            <h2>Olá<?php
if(isset($_SESSION['steamid'])){
    echo " ", strtok(@$steamprofile['realname'], " ");
} ?>, como podemos ajudar?</h2>
                            <div class="sectionItemListSuporte">
                                <a href="mailto:gabrielramos149@gmail.com">
                                    <p class="supportLink" title="gabrielramos149@gmail.com">Entrar em contato por email</p>
                                </a>
                            </div>
                        </div>
<?php
/*
                        <div id="quest1">
                            <h2>Olá <?php echo strtok($steamprofile['realname'], " "); ?>, como podemos ajudar?</h2>
                            <div class="sectionItemListSuporte">
                                <a href="javascript:void(0)" onclick="supportAction('reportPlayer', null, null)">
                                    <p class="supportLink">Reportar um jogador</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Reportar um erro/falha</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Fazer uma crítica/Sugestão</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Fazer uma proposta</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Minha dúvida não está na lista</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-1">
                            <h2>Quem você quer reportar?</h2>
                            <p>Você só pode reportar jogadores de sua última partida.</p>
                            <div class="sectionItemListSuporte">
                                <a href="javascript:void(0)" data-playerid="7355608" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkT">Jogador 1</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355609" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkT">Jogador 2</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355610" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkT">Jogador 3</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355611" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkT">Jogador 4</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355612" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkT">Jogador 5</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355613" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkCt">Jogador 6</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355614" onclick="supportAction('reportPlayer', this.dataset.playerid, null)" data-playerid="7355608" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkCt">Jogador 7</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355615" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkCt">Jogador 8</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355616" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLinkCt">Jogador 9</p>
                                </a>
                                <a href="javascript:void(0)" data-playerid="7355617" onclick="supportAction('reportPlayer', this.dataset.playerid, null)">
                                    <p class="supportLink" onclick="supportAction('quest1', null, null)">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-1-any">
                            <h2>Qual é o motivo para reportar o jogador escolhido?</h2>
                            <div class="sectionItemListSuporte">
                                <textarea id="reportText" class="supportLink" rows="10"></textarea>
                                <a href="javascript:void(0)" onclick="supportAction('reportPlayer', playerid, 'text')">
                                    <p class="supportLink">Enviar</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-1-any-sent">
                            <h2>Jogador reportado com sucesso.</h2>
                            <p>Ele será avaliado pela moderação.</p>
                            <p>Obrigado por ajudar a manter a comunidade <span class="upper">Gamers</span><span class="upper siteColor">Hub</span> sem jogadores mal-intencionados.</p>
                            <div class="sectionItemListSuporte">
                                <a href="index.html">
                                    <p class="supportLink">Voltar para a Página Inicial</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-2">
                            <h2>Onde você encontrou o erro/falha?</h2>
                            <div class="sectionItemListSuporte">
                                <a href="javascript:void(0)">
                                    <p class="supportLink">No site</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Em um servidor</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Em ambos</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-2-any">
                            <h2>Digite abaixo informações sobre o erro/falha.</h2>
                            <div class="sectionItemListSuporte">
                                <textarea class="supportLink" rows="10"></textarea>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Enviar</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-2-any-sent">
                            <h2>Erro/falha reportado com sucesso.</h2>
                            <p>Ele será avaliado pela equipe de programação.</p>
                            <p>Obrigado por ajudar a manter a comunidade <span class="upper">Gamers</span><span class="upper siteColor">Hub</span> sem bugs.</p>
                            <div class="sectionItemListSuporte">
                                <a href="index.html">
                                    <p class="supportLink">Voltar para a Página Inicial</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-3">
                            <h2>Digite abaixo a sua crítica/sugestão.</h2>
                            <div class="sectionItemListSuporte">
                                <textarea class="supportLink" rows="10"></textarea>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Enviar</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-3-sent">
                            <h2>Crítica/Sugestão enviada com sucesso.</h2>
                            <p>Recebemos sua(s) crítica(s)/sugestão(ões).</p>
                            <p>Obrigado pela iniciativa de tornar a comunidade <span class="upper">Gamers</span><span class="upper siteColor">Hub</span> em um lugar melhor.</p>
                            <div class="sectionItemListSuporte">
                                <a href="index.html">
                                    <p class="supportLink">Voltar para a Página Inicial</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-4">
                            <h2>Digite abaixo a sua proposta.</h2>
                            <p>Não esqueça de colocar algum email para obter um retorno.</p>
                            <div class="sectionItemListSuporte">
                                <textarea class="supportLink" rows="10"></textarea>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Enviar</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-3-any-sent">
                            <h2>Proposta enviada com sucesso.</h2>
                            <p>Recebemos sua proposta.</p>
                            <p>Obrigado!</p>
                            <div class="sectionItemListSuporte">
                                <a href="index.html">
                                    <p class="supportLink">Voltar para a Página Inicial</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-5">
                            <h2>Digite abaixo informações sobre sua dúvida.</h2>
                            <p>Não esqueça de colocar algum email para obter um retorno.</p>
                            <div class="sectionItemListSuporte">
                                <textarea class="supportLink" rows="10"></textarea>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Enviar</p>
                                </a>
                                <a href="javascript:void(0)">
                                    <p class="supportLink">Voltar</p>
                                </a>
                            </div>
                        </div>
                        <div class="hidden" id="quest1-3-any-sent">
                            <h2>Dúvida enviada com sucesso.</h2>
                            <p>Recebemos sua dúvida.</p>
                            <p>Em breve responderemos.</p>
                            <div class="sectionItemListSuporte">
                                <a href="index.html">
                                    <p class="supportLink">Voltar para a Página Inicial</p>
                                </a>
                            </div>
                        </div>
*/
?>
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