debug = false;

function joinServer(){
    buttonLoadingF();
    $.get("play/join?map[de_cpl_strike_v2]=1&map[de_cache]=1&map[de_dust2]=1&map[de_inferno]=1&map[de_train]=1", function(data) {
        if(data=="joined"){
            buttonLeaveMatchF();
        } else if(data=="noservers"){
            //mostra que não há servidores disponíveis
            alert("Desculpe, mas no momento não há servidores disponíveis.");
            buttonFindMatchF();
        } else if(data=="already_playing"){
            //não faz nada, somente deixa o update ficar atualizando
        } else {
            //mostra um erro de rede
            buttonLoadingF();
            if(window.confirm("Ocorreu um erro desconhecido. Verifique a sua rede.")) {
                //sim
                window.location.reload();
            } else {
                //nao
            }
        }
        if(debug===true){
            console.log("joinServer: "+data);
        }
    });
}
function readyServer(){
    ready = true;
    buttonLoadingF();
    $.get("play/ready", function(data) {
        if(data=="readyok"){
            //mostra o botao de espera de ready dos outros
            ready = true;
        } else {
            ready = false;
            //mostra um erro de rede
            buttonLoadingF();
            if(window.confirm("Ocorreu um erro desconhecido. Verifique a sua rede.")) {
                //sim
                window.location.reload();
            } else {
                //nao
            }
        }
        buttonReadyF();
        if(debug===true){
            console.log("readyServer: "+data);
        }
    });
}
function leaveServer(){
    buttonLoadingF();
    $.get("play/leave", function(data) {
        if(data=="removed"){
            buttonFindMatchF();
        } else {
            //mostra um erro de rede
            buttonLoadingF();
            if(window.confirm("Ocorreu um erro desconhecido. Verifique a sua rede.")) {
                //sim
                window.location.reload();
            } else {
                //nao
            }
        }
        if(debug===true){
            console.log("leaveServer: "+data);
        }
    });
}
function updateServer(){
    $.get("play/update", function(data) {
        if(data=="waiting..."){
            //mostra o botao de sair da partida
            buttonLeaveMatchF();
        } else if(data=="nomatch"){
            //mostra que você não está em uma partida
            buttonFindMatchF();
            if(data!==lastdata){
                //console.log("TOCA O AUDIO QUE NÃO ESTÁ EM UMA PARTIDA");
            }
        } else if(data=="ready"){
            //mostra botao de ready
            buttonReadyF();
            if(data!==lastdata){
                //console.log("TOCA O AUDIO DE READY");
            }
        } else {
            //mostra informações de conexao da partida
            if(data===""){
                if(data!=lastdata){
                    if(lastdata!="removed"&&lastdata!="waiting..."){
                        alert("Fim da partida! Obrigado por jogar na GamersHub");
                        //console.log("TOCA O AUDIO DE FIM DA PARTIDA");
                    }
                } else {
                    buttonFindMatchF();
                }
            } else {
                connectionLink      = data.match(/[^\n]+/g)[0];
                connectionCommand   = data.match(/[^\n]+/g)[1];
                if(data!==lastdata){
                    buttonJoinGameF();
                    //console.log("TOCA O AUDIO DA PARTIDA PRONTA");
                } else {
                    document.getElementById("joinGameLink").href = connectionLink;
                    document.getElementById("joinGameCommand").value = connectionCommand;
                }
            }
        }
        if(debug===true){
            console.log("updateServer: (lastdata)"+data);
        }
        lastdata = data;
        if(debug===true){
            console.log("updateServer: (data)"+data);
        }
    });
}
function buttonJoinGameF(){
    //document.querySelector(".mapSelector").style.display = "none";
    var buttonJoinGame = "";
    buttonJoinGame = buttonJoinGame+'<a id="joinGameLink" href="'+connectionLink+'">';
    buttonJoinGame = buttonJoinGame+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
    buttonJoinGame = buttonJoinGame+'        <div class="playButtonTextContainer">';
    buttonJoinGame = buttonJoinGame+'            <h1 class="playButtonTextContent">Pronto!</h1>';
    buttonJoinGame = buttonJoinGame+'            <h6 class="subtitle" id="connect">Clique aqui para conectar</h6>';
    buttonJoinGame = buttonJoinGame+'        </div>';
    buttonJoinGame = buttonJoinGame+'    </div>';
    buttonJoinGame = buttonJoinGame+'</a>';
    buttonJoinGame = buttonJoinGame+'<input type="text" id="joinGameCommand" value="'+connectionCommand+'" onclick="this.select();document.execCommand(\'copy\');">';
    document.getElementById("games").innerHTML = buttonJoinGame;
}
function buttonReadyF(){
    //document.querySelector(".mapSelector").style.display = "none";
    var buttonReady = "";
    if(ready===false){
        buttonReady = buttonReady+'<a href="javascript:void(0)" onclick="readyServer()">';
        buttonReady = buttonReady+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
        buttonReady = buttonReady+'        <div class="playButtonTextContainer">';
        buttonReady = buttonReady+'            <h1 class="playButtonTextContent">PRONTO?</h1>';
        buttonReady = buttonReady+'            <h4 class="subtitle" id="ready">Clique para jogar!</h4>';
        buttonReady = buttonReady+'        </div>';
        buttonReady = buttonReady+'    </div>';
        buttonReady = buttonReady+'</a>';
        document.getElementById("games").innerHTML = buttonReady;
    } else {
        buttonReady = buttonReady+'<a href="javascript:void(0)" onclick="readyServer()">';
        buttonReady = buttonReady+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
        buttonReady = buttonReady+'        <div class="playButtonTextContainer">';
        buttonReady = buttonReady+'            <h1 class="playButtonTextContent">PRONTO!</h1>';
        buttonReady = buttonReady+'            <h6 class="subtitle" id="ready">Esperando os outros jogadores...</h6>';
        buttonReady = buttonReady+'        </div>';
        buttonReady = buttonReady+'    </div>';
        buttonReady = buttonReady+'</a>';
        document.getElementById("games").innerHTML = buttonReady;
    }
}

function buttonFindMatchF(){
    //document.querySelector(".mapSelector").style.display = "inherit";
    ready = false;
    var buttonFindMatch = "";
    buttonFindMatch = buttonFindMatch+'<a href="javascript:void(0)" onclick="joinServer()">';
    buttonFindMatch = buttonFindMatch+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
    buttonFindMatch = buttonFindMatch+'        <div class="playButtonTextContainer">';
    buttonFindMatch = buttonFindMatch+'            <h1 class="playButtonTextContent">Buscar partida</h1>';
    buttonFindMatch = buttonFindMatch+'            <h4 class="subtitle">competitivo (alpha)</h4>';
    buttonFindMatch = buttonFindMatch+'        </div>';
    buttonFindMatch = buttonFindMatch+'    </div>';
    buttonFindMatch = buttonFindMatch+'</a>';
    if(document.getElementById("games").innerHTML!=buttonFindMatch){
        document.getElementById("games").innerHTML = buttonFindMatch;
    }
}

function buttonLeaveMatchF(){
    //document.querySelector(".mapSelector").style.display = "none";
    ready = false;
    var buttonLeaveMatch = "";
    buttonLeaveMatch = buttonLeaveMatch+'<a href="javascript:void(0)" onclick="leaveServer()" title="Clique para sair da partida">';
    buttonLeaveMatch = buttonLeaveMatch+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
    buttonLeaveMatch = buttonLeaveMatch+'        <div class="playButtonTextContainer">';
    buttonLeaveMatch = buttonLeaveMatch+'            <h1 class="playButtonTextContent">Partida Encontrada</h1>';
    buttonLeaveMatch = buttonLeaveMatch+'            <h4 class="subtitle">Esperando jogadores...</h4>';
    buttonLeaveMatch = buttonLeaveMatch+'        </div>';
    buttonLeaveMatch = buttonLeaveMatch+'    </div>';
    buttonLeaveMatch = buttonLeaveMatch+'</a>';
    document.getElementById("games").innerHTML = buttonLeaveMatch;
}

function buttonLoadingF(){
    //document.querySelector(".mapSelector").style.display = "none";
    ready = false;
    var buttonLoading = "";
    buttonLoading = buttonLoading+'<a href="javascript:void(0)">';
    buttonLoading = buttonLoading+'    <div class="playButton" style="margin-left:auto;margin-right:auto;">';
    buttonLoading = buttonLoading+'        <div class="playButtonTextContainer">';
    buttonLoading = buttonLoading+'            <h1 class="playButtonTextContent">Carregando...</h1>';
    buttonLoading = buttonLoading+'            <h4 class="subtitle">Esperando resposta do servidor...</h4>';
    buttonLoading = buttonLoading+'        </div>';
    buttonLoading = buttonLoading+'    </div>';
    buttonLoading = buttonLoading+'</a>';
    document.getElementById("games").innerHTML = buttonLoading;
}

ready = false;
lastdata = "";
buttonLoadingF();
updateServer();
updateInterval = setInterval(function(){
    updateServer();
}, 1000);

/*
document.getElementById("mapSelector_de_dust2").onchange = function(){
    var checked = document.getElementById("mapSelector_de_dust2").checked;
    if(checked==true){
        //desativa
        document.getElementById("mapSelectorMap_de_dust2").style.borderColor = "#880000";
        document.getElementById("mapSelectorMap_de_dust2").style.backgroundImage = "linear-gradient(to right, rgba(75,0,0,1),rgba(75,0,0,0.2), rgba(75,0,0,.5)),url(assets/images/background/de_dust2/1.jpg)";
    } else {
        //ativa
        document.getElementById("mapSelectorMap_de_dust2").style.borderColor = "#00ff00";
        document.getElementById("mapSelectorMap_de_dust2").style.backgroundImage = "linear-gradient(to right, rgba(0,150,0,1),rgba(0,150,0,0.2), rgba(0,150,0,.5)),url(assets/images/background/de_dust2/1.jpg)";
    }
}
*/