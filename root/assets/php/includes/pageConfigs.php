<?php
$pages = [
    "inicio" => [
        "title" => "Venha jogar sério!",
        "must_be_logged" => false,
    ],
    "profile" => [
        "title" => @$profile['personaname'],
        "must_be_logged" => false,
    ],
    "play" => [
        "title" => "Jogar",
        "must_be_logged" => true,
    ],
    "support" => [
        "title" => "Suporte",
        "must_be_logged" => false,
    ],
    "servers" => [
        "title" => "Servidores",
        "must_be_logged" => false,
    ],
        "ajax_play" => [
            "title" => "ajax",
            "must_be_logged" => true,
        ],
        "my" => [
            "title" => "my",
            "must_be_logged" => true,
        ],
];
function alinks($alink, $arg){
    switch($alink){
        case "steamDomainName":
            return "ghub.ga";
            //NÃO UTILIZADO, CONFIGURE O ARQUIVO
            // steamauth/SteamConfigs.php
            
        case "base":
            return "https://ghub.ga/";
            
        case "index":
        case "paginaInicial":
            return alinks('base', null);
            
        case "profile":
        case "perfil":
            return alinks('base', null)."profile/".$arg;
            
        case "play":
        case "jogar":
            return alinks('base', null)."play";
            
        case "login":
            return alinks('base', null)."?login=login";
            
        case "logout":
            return alinks('base', null)."?logout=logout";
            
        case "contact":
        case "contato":
            return alinks('base', null)."contact";
            
        case "support":
        case "suporte":
            return alinks('base', null)."support";
            
        case "servers":
        case "servidores":
            return alinks('base', null)."servers";
    }
}




if(isset($thispage)){
    $page = $pages[$thispage];
}
include("assets/php/includes/defineTitle.php");
include("assets/php/includes/security.php");
