#include <sourcemod>
#include <sdkhooks>
#include <sdktools>
#include <socket>
#include <httpreq>
#include <cstrike>
#pragma semicolon 1

#define SV_ID			"4"
#define SV_PORT			"27020"
#define SV_KEY			"a9f8209e40532cb34928f7794d1b167f"
#define HOST4SV			"http://api.hiperteam.ga/server/cs_source/server.php"
#define DEBUG			false

public Plugin myinfo =
{
	name = "Core",
	author = "hiperesp",
	description = "HiperTeam Game Core",
	version = "1.0",
	url = "http://hiperteam.ga/"
};
//Definição da GamersHub vars {
new Handle:gameId;
new Handle:gameStatus;
new Handle:userCt1;
new Handle:userCt2;
new Handle:userCt3;
new Handle:userCt4;
new Handle:userCt5;
new Handle:userT1;
new Handle:userT2;
new Handle:userT3;
new Handle:userT4;
new Handle:userT5;
//}

public void OnPluginStart() {
	PrintToServer("Core by hiperesp loaded");

	//Inicialização das variáveis GamersHub {
	gameId 		= CreateConVar("gameId"		, "0", "ID do jogo");
	gameStatus	= CreateConVar("gameStatus"	, "0", "status atual (0 = aquecimento, 1 = jogo)");

	userCt1 	= CreateConVar("userCt1", "0", "ID do Player para Whitelist");
	userCt2 	= CreateConVar("userCt2", "0", "ID do Player para Whitelist");
	userCt3 	= CreateConVar("userCt3", "0", "ID do Player para Whitelist");
	userCt4 	= CreateConVar("userCt4", "0", "ID do Player para Whitelist");
	userCt5 	= CreateConVar("userCt5", "0", "ID do Player para Whitelist");
	
	userT1 		= CreateConVar("userT1", "0", "ID do Player para Whitelist");
	userT2 		= CreateConVar("userT2", "0", "ID do Player para Whitelist");
	userT3 		= CreateConVar("userT3", "0", "ID do Player para Whitelist");
	userT4 		= CreateConVar("userT4", "0", "ID do Player para Whitelist");
	userT5 		= CreateConVar("userT5", "0", "ID do Player para Whitelist");
	//}
	
	//Registro de comandos RCON {
	RegServerCmd("core_startwarmup"		, Command_StartWarmup);
	RegServerCmd("core_startmatch"		, Command_StartMatch);
	RegServerCmd("core_ping"			, Command_Ping);
	RegServerCmd("core_internalping"	, Command_InternalPing);
	RegServerCmd("serverinfo"			, Command_ServerInfo);
	//}
	
	//Registro de eventos {
	HookEvent("cs_win_panel_match"	, Event_FimDaPartida);
	HookEvent("round_end"			, Event_RoundEnd);
	HookEvent("player_death"		, Event_PlayerDeath);
	//}
	
	//Remover a mensagem dos eventos {
	HookEvent("player_team"			, OnPlayerTeam, EventHookMode_Pre);
	HookEvent("player_disconnect"	, OnPlayerDisconnect, EventHookMode_Pre);
	HookEvent("player_connect"		, OnPlayerConnect, EventHookMode_Pre);
	HookEvent("server_cvar"			, Event_ServerCvar, EventHookMode_Pre);
	//}
	
	//Registra na GamersHub que o Servidor está ligado {
	//url do serviço GamersHub {
	HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
	//}
	
	//true mostra req no console, false não. {
	req.debug = DEBUG;
	//}
	
	//Não mostra nenhum header {
	req.headers.SetString("", "");
	//}
	
	//Define parâmetros {
	req.params.SetString("id", SV_ID);
	req.params.SetString("port", SV_PORT);
	req.params.SetString("key", SV_KEY);
	req.params.SetString("action", "start");
	
	//Obtêm o valor da id do jogo {
	char[] reqgameId = "";
	IntToString(GetConVarInt(gameId), reqgameId, 64);
	//}
	
	req.params.SetString("gameid", reqgameId);
	//}
	
	//Faz a requisição {
	req.SendRequest();
	//}
	//}
	RegConsoleCmd("joingame", Join);
	RegConsoleCmd("jointeam", Join);
	ServerCommand("rcon_password %s", SV_KEY);
	ServerCommand("wait 1000;core_internalping");
}

public Action:Command_ServerInfo(int args) {
	new pieces[4];
	new longip = GetConVarInt(FindConVar("hostip"));
	//new String:NetIp[15];
	
	pieces[0] = (longip >> 24) & 0x000000FF;
	pieces[1] = (longip >> 16) & 0x000000FF;
	pieces[2] = (longip >> 8) & 0x000000FF;
	pieces[3] = longip & 0x000000FF;
	
	ServerCommand("say %d.%d.%d.%d", pieces[0], pieces[1], pieces[2], pieces[3]);
	//status retorna tudo, inclusive o ip publico
}
//Quando recebe o comando de ping{
public Action:Command_Ping(int args){
	HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
	req.debug = DEBUG;
	req.headers.SetString("", "");
	req.params.SetString("id", SV_ID);
	req.params.SetString("port", SV_PORT);
	req.params.SetString("key", SV_KEY);
	
	req.params.SetString("action", "ping");
	
	char[] reqgameId = "";
	IntToString(GetConVarInt(gameId), reqgameId, 64);
	
	req.params.SetString("gameid", reqgameId);
	
	req.SendRequest();
}

public Action:Command_InternalPing(int args){
	HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
	req.debug = DEBUG;
	req.headers.SetString("", "");
	req.params.SetString("id", SV_ID);
	req.params.SetString("port", SV_PORT);
	req.params.SetString("key", SV_KEY);
	
	req.params.SetString("action", "ping");
	
	char[] reqgameId = "";
	IntToString(GetConVarInt(gameId), reqgameId, 64);
	
	req.params.SetString("gameid", reqgameId);
	
	req.SendRequest();
	ServerCommand("wait 1000;core_internalping");
}
//}

//Quando recebe o comando de iniciar a partida competitiva{
public Action:Command_StartMatch(int args){
	ServerCommand("mp_restartgame 1");
	ServerCommand("gameStatus 1");
	ServerCommand("mp_halftime 1");
	ServerCommand("exec competitivo");
	ServerCommand("say A partida iniciou.");
	
	HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
	req.debug = DEBUG;
	req.headers.SetString("", "");
	req.params.SetString("id", SV_ID);
	req.params.SetString("port", SV_PORT);
	req.params.SetString("key", SV_KEY);
	
	req.params.SetString("action", "competitive");
	
	char[] reqgameId = "";
	IntToString(GetConVarInt(gameId), reqgameId, 64);
	
	req.params.SetString("gameid", reqgameId);
	
	req.SendRequest();
	for (new client = 1; client <= MaxClients; client++) {
		if (IsClientInGame(client)) {
			CS_RespawnPlayer(client);
		}
	}
}
//}

//Quando recebe o comando de iniciar o aquecimento{
public Action:Command_StartWarmup(int args){
	//Quando inicia o aquecimento, executa os comandos abaixo{
	ServerCommand("mp_restartgame 1");
	ServerCommand("mp_halftime 0");
	ServerCommand("gameStatus 0");
	ServerCommand("exec warmup");
	ServerCommand("say Aquecimento...");
	//}
	
	//Registra na GamersHub o início do aquecimento{
	HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
	req.debug = DEBUG;
	req.headers.SetString("", "");
	
	//Parametros{
	req.params.SetString("id", SV_ID);
	req.params.SetString("port", SV_PORT);
	req.params.SetString("key", SV_KEY);

	req.params.SetString("action", "warmup");
	
	char[] reqgameId = "";
	IntToString(GetConVarInt(gameId), reqgameId, 64);
	
	req.params.SetString("gameid", reqgameId);
	//}
	
	req.SendRequest();
	//}

	ServerCommand("wait 1000;say Aquecimento...;say A partida inicia em 4 minutos e 50 segundos;"); //100 = 1 sec, 1000 = 10 sec, 6000 = 1 min, 30000 = 5 mins
	ServerCommand("wait 2000;say Aquecimento...;say A partida inicia em 4 minutos e 40 segundos;");
	ServerCommand("wait 3000;say Aquecimento...;say A partida inicia em 4 minutos e 30 segundos;");
	ServerCommand("wait 4000;say Aquecimento...;say A partida inicia em 4 minutos e 20 segundos;");
	ServerCommand("wait 5000;say Aquecimento...;say A partida inicia em 4 minutos e 10 segundos;");
	ServerCommand("wait 6000;say Aquecimento...;say A partida inicia em 4 minutos;");
	ServerCommand("wait 7000;say Aquecimento...;say A partida inicia em 3 minutos e 50 segundos;");
	ServerCommand("wait 8000;say Aquecimento...;say A partida inicia em 3 minutos e 40 segundos;");
	ServerCommand("wait 9000;say Aquecimento...;say A partida inicia em 3 minutos e 30 segundos;");
	ServerCommand("wait 10000;say Aquecimento...;say A partida inicia em 3 minutos e 20 segundos;");
	ServerCommand("wait 11000;say Aquecimento...;say A partida inicia em 3 minutos e 10 segundos;");
	ServerCommand("wait 12000;say Aquecimento...;say A partida inicia em 3 minutos;");
	ServerCommand("wait 13000;say Aquecimento...;say A partida inicia em 2 minutos e 50 segundos;");
	ServerCommand("wait 14000;say Aquecimento...;say A partida inicia em 2 minutos e 40 segundos;");
	ServerCommand("wait 15000;say Aquecimento...;say A partida inicia em 2 minutos e 30 segundos;");
	ServerCommand("wait 16000;say Aquecimento...;say A partida inicia em 2 minutos e 20 segundos;");
	ServerCommand("wait 17000;say Aquecimento...;say A partida inicia em 2 minutos e 10 segundos;");
	ServerCommand("wait 18000;say Aquecimento...;say A partida inicia em 2 minutos;");
	ServerCommand("wait 19000;say Aquecimento...;say A partida inicia em 1 minuto e 50 segundos;");
	ServerCommand("wait 20000;say Aquecimento...;say A partida inicia em 1 minuto e 40 segundos;");
	ServerCommand("wait 21000;say Aquecimento...;say A partida inicia em 1 minuto e 30 segundos;");
	ServerCommand("wait 22000;say Aquecimento...;say A partida inicia em 1 minuto e 20 segundos;");
	ServerCommand("wait 23000;say Aquecimento...;say A partida inicia em 1 minuto e 10 segundos;");
	ServerCommand("wait 24000;say Aquecimento...;say A partida inicia em 1 minuto;");
	ServerCommand("wait 25000;say Aquecimento...;say A partida inicia em 50 segundos;");
	ServerCommand("wait 26000;say Aquecimento...;say A partida inicia em 40 segundos;");
	ServerCommand("wait 27000;say Aquecimento...;say A partida inicia em 30 segundos;");
	ServerCommand("wait 28000;say Aquecimento...;say A partida inicia em 20 segundos;");
	ServerCommand("wait 29000;say Aquecimento...;say A partida inicia em 10 segundos;");
	ServerCommand("wait 29100;say Aquecimento...;say A partida inicia em 9 segundos;");
	ServerCommand("wait 29200;say Aquecimento...;say A partida inicia em 8 segundos;");
	ServerCommand("wait 29300;say Aquecimento...;say A partida inicia em 7 segundos;");
	ServerCommand("wait 29400;say Aquecimento...;say A partida inicia em 6 segundos;");
	ServerCommand("wait 29500;say Aquecimento...;say A partida inicia em 5 segundos;");
	ServerCommand("wait 29600;say Aquecimento...;say A partida inicia em 4 segundos;");
	ServerCommand("wait 29700;say Aquecimento...;say A partida inicia em 3 segundos;");
	ServerCommand("wait 29800;say Aquecimento...;say A partida inicia em 2 segundos;");
	ServerCommand("wait 29900;say Aquecimento...;say A partida inicia em 1 segundo;");
	ServerCommand("wait 30000;say Aquecimento...;say Iniciando partida...; core_startmatch");	//100 = 1 sec, 1000 = 10 sec, 6000 = 1 min, 30000 = 5 mins
}
//}

//Desativa  a c4 no aquecimento {
public OnEntityCreated(entity, const String:classname[]) {
	if(GetConVarInt(gameStatus)==0){
		if(StrEqual(classname, "weapon_c4")) { 
			AcceptEntityInput(entity, "Kill"); 
		}
	}		
} 
//}

//Quando a partida acabar, registra na GamersHub{
public void Event_FimDaPartida(Event event, const char[] name, bool dontBroadcast) {
	if(GetConVarInt(gameStatus)==1){
		new Handle:mp_halftime	= FindConVar("mp_halftime");
		new Handle:mp_halftime_firsthalf	= FindConVar("mp_halftime_firsthalf");
		new bool:halftime = GetConVarBool(mp_halftime);
		new bool:firsthalf = GetConVarBool(mp_halftime_firsthalf);
		
		int  t_score;
		int ct_score;
		if(halftime){
			if(firsthalf){
				t_score = event.GetInt("t_score");
				ct_score = event.GetInt("ct_score");
			} else {
				t_score = event.GetInt("ct_score");
				ct_score = event.GetInt("t_score");
			}
		} else {
			t_score = event.GetInt("t_score");
			ct_score = event.GetInt("ct_score");
		}
		
		HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
		req.debug = DEBUG;
		req.headers.SetString("", "");
		req.params.SetString("id", SV_ID);
		req.params.SetString("port", SV_PORT);
		req.params.SetString("key", SV_KEY);
		
		req.params.SetString("action", "finish");
		
		char[] reqgameId = "";
		char[] reqt_score = "";
		char[] reqct_score = "";
		IntToString(GetConVarInt(gameId), reqgameId, 64);
		IntToString(t_score, reqt_score, 64);
		IntToString(ct_score, reqct_score, 64);
		
		req.params.SetString("gameid", reqgameId);
		req.params.SetString("t_score", reqt_score);
		req.params.SetString("ct_score", reqct_score);
		
		req.SendRequest();
		ResetGame();
	}
}
//}

public ResetGame(){
	//Script de resetar o game
	
	ServerCommand("userCt1 0");
	ServerCommand("userCt2 0");
	ServerCommand("userCt3 0");
	ServerCommand("userCt4 0");
	ServerCommand("userCt5 0");
	ServerCommand("userT1 0");
	ServerCommand("userT2 0");
	ServerCommand("userT3 0");
	ServerCommand("userT4 0");
	ServerCommand("userT5 0");
	
	ServerCommand("gameId 0");
	ServerCommand("gameStatus 0");
	
	ServerCommand("wait 500;kickall Fim da Partida. Obrigado por jogar na GamersHub. (hiperteam.ga)");
	
	ServerCommand("wait 600;map de_dust2");
	
	ServerCommand("wait 600;mp_restartgame 1");
	ServerCommand("sv_password 8da8f2b906a7f52152ebaff65193dec9");
	//Fim do script de resetar
}
public OnClientPostAdminCheck(client) {
	if(!IsFakeClient(client)) {
		new String:auth[64];
		GetClientAuthId(client, AuthId_SteamID64, auth, sizeof(auth));
		
		new String:SuserCt1[64] ;
		new String:SuserCt2[64];
		new String:SuserCt3[64];
		new String:SuserCt4[64];
		new String:SuserCt5[64];
		new String:SuserT1[64];
		new String:SuserT2[64];
		new String:SuserT3[64];
		new String:SuserT4[64];
		new String:SuserT5[64];
		GetConVarString(userCt1, SuserCt1, 64);
		GetConVarString(userCt2, SuserCt2, 64);
		GetConVarString(userCt3, SuserCt3, 64);
		GetConVarString(userCt4, SuserCt4, 64);
		GetConVarString(userCt5, SuserCt5, 64);
		GetConVarString(userT1, SuserT1, 64);
		GetConVarString(userT2, SuserT2, 64);
		GetConVarString(userT3, SuserT3, 64);
		GetConVarString(userT4, SuserT4, 64);
		GetConVarString(userT5, SuserT5, 64);
		if(
			  StrEqual(auth, SuserCt1)
			||StrEqual(auth, SuserCt2)
			||StrEqual(auth, SuserCt3)
			||StrEqual(auth, SuserCt4)
			||StrEqual(auth, SuserCt5)
			||StrEqual(auth, SuserT1)
			||StrEqual(auth, SuserT2)
			||StrEqual(auth, SuserT3)
			||StrEqual(auth, SuserT4)
			||StrEqual(auth, SuserT5)
		) {
			//ServerCommand("say %s entrou.", auth);
		} else {
			KickClient(client, "Registre-se em GamersHub, hiperteam.ga. (%s)", auth);
		}
	}
}

public void OnRequestComplete(bool bSuccess, int iStatusCode, StringMap tHeaders, const char[] sBody, int iErrorType, int iErrorNum, any data) {
}

public Action:OnPlayerTeam(Handle:event, const String:name[], bool:dontBroadcast) {
	return Plugin_Handled;
}

public Action:OnPlayerDisconnect(Handle:event, const String:name[], bool:dontBroadcast) {
	return Plugin_Handled;
}

public Action:OnPlayerConnect(Handle:event, const String:name[], bool:dontBroadcast) {
	return Plugin_Handled;
}

public Action:Event_ServerCvar(Handle:event, const String:name[], bool:dontBroadcast) {
    return Plugin_Handled;
}

/*
loop all players and respawn
for (new client = 1; client <= MaxClients; client++) {
	if (IsClientInGame(client)) {
		CS_RespawnPlayer(client);
	}
}
*/
public Event_RoundEnd(Handle:event, const String:name[], bool:dontBroadcast) {
	if(GetConVarInt(gameStatus)==1){
		if(GetEventInt(event, "winner")==1){
			HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
			req.debug = DEBUG;
			req.headers.SetString("", "");
			req.params.SetString("id", SV_ID);
			req.params.SetString("port", SV_PORT);
			req.params.SetString("key", SV_KEY);
			
			req.params.SetString("action", "gameCancel");
			req.SendRequest();
			ResetGame();
		}
	}
}

public Event_PlayerDeath(Handle:event, const String:name[], bool:dontBroadcast){
	if(GetConVarInt(gameStatus)==1){
		new dead				= GetEventInt(event, "userid");
		new killer				= GetEventInt(event, "attacker");
		new String:deadAuth[64];
		GetClientAuthId(dead, AuthId_SteamID64, deadAuth, sizeof(deadAuth));
		new String:killerAuth[64];
		GetClientAuthId(killer, AuthId_SteamID64, killerAuth, sizeof(killerAuth));
		//new String:weapon[32]	= GetEventInt(event, "weapon");
		//new headshot			= GetEventInt(event, "headshot");
		
		HTTPRequest req = HTTPRequest("GET", HOST4SV, "OnRequestComplete");
		req.debug = DEBUG;
		req.headers.SetString("", "");
		req.params.SetString("id", SV_ID);
		req.params.SetString("port", SV_PORT);
		req.params.SetString("key", SV_KEY);
		
		req.params.SetString("action", "kill");
		
		//Obtêm o valor da id do jogo {
		char[] reqgameId = "";
		IntToString(GetConVarInt(gameId), reqgameId, 64);
		//}
		
		req.params.SetString("gameid", reqgameId);
		req.params.SetString("killer", killerAuth);
		req.params.SetString("dead", deadAuth);
		//ServerCommand("say %s matou %s", killerAuth, deadAuth);
		req.SendRequest();
	}
}

public Action:Join(client, args) {
	
	new Handle:mp_halftime	= FindConVar("mp_halftime");
	new Handle:mp_halftime_firsthalf	= FindConVar("mp_halftime_firsthalf");
	new bool:halftime = GetConVarBool(mp_halftime);
	new bool:firsthalf = GetConVarBool(mp_halftime_firsthalf);
	
	new String:auth[64];
	GetClientAuthId(client, AuthId_SteamID64, auth, sizeof(auth));
	
	new String:SuserCt1[64] ;
	new String:SuserCt2[64];
	new String:SuserCt3[64];
	new String:SuserCt4[64];
	new String:SuserCt5[64];
	new String:SuserT1[64];
	new String:SuserT2[64];
	new String:SuserT3[64];
	new String:SuserT4[64];
	new String:SuserT5[64];
	GetConVarString(userCt1, SuserCt1, 64);
	GetConVarString(userCt2, SuserCt2, 64);
	GetConVarString(userCt3, SuserCt3, 64);
	GetConVarString(userCt4, SuserCt4, 64);
	GetConVarString(userCt5, SuserCt5, 64);
	GetConVarString(userT1, SuserT1, 64);
	GetConVarString(userT2, SuserT2, 64);
	GetConVarString(userT3, SuserT3, 64);
	GetConVarString(userT4, SuserT4, 64);
	GetConVarString(userT5, SuserT5, 64);
	
	if(									//CT TEAM 3
		  StrEqual(auth, SuserCt1)
		||StrEqual(auth, SuserCt2)
		||StrEqual(auth, SuserCt3)
		||StrEqual(auth, SuserCt4)
		||StrEqual(auth, SuserCt5)
	) {
		if(halftime){
			if(firsthalf){
				ChangeClientTeam(client, CS_TEAM_CT);
			} else {
				ChangeClientTeam(client, CS_TEAM_T);
			}
		} else {
			ChangeClientTeam(client, CS_TEAM_CT);
		}
	} else if(							//T TEAM 2
		  StrEqual(auth, SuserT1)
		||StrEqual(auth, SuserT2)
		||StrEqual(auth, SuserT3)
		||StrEqual(auth, SuserT4)
		||StrEqual(auth, SuserT5)
	) {
		if(halftime){
			if(firsthalf){
				ChangeClientTeam(client, CS_TEAM_T);
			} else {
				ChangeClientTeam(client, CS_TEAM_CT);
			}
		} else {
			ChangeClientTeam(client, CS_TEAM_T);
		}
	} else {
		KickClient(client, "Registre-se em GamersHub, hiperteam.ga. (%s)", auth);
	}
	if(GetConVarInt(gameStatus)==0){
		CS_RespawnPlayer(client);
	}
	return Plugin_Handled;
}
