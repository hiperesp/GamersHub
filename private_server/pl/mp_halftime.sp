#pragma semicolon 1

#include <sourcemod>
#include <sdktools>
#include <cstrike>

new Handle:mp_halftime		= INVALID_HANDLE;
new Handle:mp_maxrounds		= INVALID_HANDLE;
new Handle:mp_startmoney	= INVALID_HANDLE;

new bool:halftime;
new bool:mp_halftime_firsthalf;
new maxrounds;
new startmoney;

new bool:firsthalf = false;
new bool:swap = false;

new g_iAccount = -1;

public Plugin:myinfo = 
{
	name = "[CS:S] mp_halftime",
	author = "GabenNewell (Bad Kitty)",
	description = "Determines whether the match switches sides in a halftime event.",
	version = "1.1.0",
	url = "https://forums.alliedmods.net/showthread.php?t=241716"
};

public OnPluginStart()
{
	mp_halftime				= CreateConVar("mp_halftime", "0", "Determines whether the match switches sides in a halftime event.", FCVAR_PLUGIN|FCVAR_NOTIFY, true, 0.0, true, 1.0);
	mp_halftime_firsthalf	= CreateConVar("mp_halftime_firsthalf", "0", "Determines if the match is in first half.", FCVAR_PLUGIN|FCVAR_NOTIFY, true, 0.0, true, 1.0);
	mp_maxrounds	= FindConVar("mp_maxrounds");
	mp_startmoney	= FindConVar("mp_startmoney");
	
	HookConVarChange(mp_halftime,	ConVarChange);
	HookConVarChange(mp_maxrounds,	ConVarChange);
	HookConVarChange(mp_startmoney,	ConVarChange);
	
	halftime	= GetConVarBool(mp_halftime);
	maxrounds	= GetConVarInt(mp_maxrounds);
	startmoney	= GetConVarInt(mp_startmoney);
	
	g_iAccount	= FindSendPropOffs("CCSPlayer", "m_iAccount");
	
	if (halftime)
	{
		HookEvent("round_start",	Event_RoundStart);
		HookEvent("round_end",		Event_RoundEnd);
	}
}

public ConVarChange(Handle:cvar, const String:oldValue[], const String:newValue[])
{
	new nval = StringToInt(newValue);
	
	if (cvar == mp_halftime)
	{
		halftime = (nval == 1) ? true : false;
		
		if (halftime)
		{
			HookEvent("round_start",	Event_RoundStart);
			HookEvent("round_end",		Event_RoundEnd);
		}
		else
		{
			UnhookEvent("round_start",	Event_RoundStart);
			UnhookEvent("round_end",	Event_RoundEnd);
		}
	}
	else if (cvar == mp_maxrounds)
	{
		maxrounds = nval;
	}
	else if (cvar == mp_startmoney)
	{
		startmoney = nval;
	}
}

public Action:Event_RoundStart(Handle:event, const String:name[], bool:dontBroadcast)
{
	if ((CS_GetTeamScore(2) + CS_GetTeamScore(3)) == 0)
	{
		firsthalf = true;
		ServerCommand("mp_halftime_firsthalf 1");
	}
	
	if (swap)
	{
		for (new client = 1; client <= MaxClients; client++)
		{
			if (IsClientInGame(client) && GetClientTeam(client) > 1)
			{
				for (new weapon, i = 0; i < 5; i++)
				{
					if (i != 2 && i != 4)
					{
						while ((weapon = GetPlayerWeaponSlot(client, i)) != -1)
						{
							RemovePlayerItem(client, weapon);
						}
					}
				}
				
				GivePlayerItem(client, (GetClientTeam(client) == 2) ? "weapon_glock" : "weapon_usp");
				
				SetEntProp(client, Prop_Send, "m_ArmorValue", 0);
				SetEntProp(client, Prop_Send, "m_bHasHelmet", 0);
				SetEntProp(client, Prop_Send, "m_bHasDefuser", 0);
				SetEntData(client, g_iAccount, startmoney, 4, true);
			}
		}		
		swap = false;
	}
}

public Action:Event_RoundEnd(Handle:event, const String:name[], bool:dontBroadcast)
{
	if (firsthalf)
	{
		new timeleft;
		new timelimit;
		GetMapTimeLeft(timeleft);
		GetMapTimeLimit(timelimit);
		
		if ((maxrounds != 0 && (CS_GetTeamScore(2) + CS_GetTeamScore(3)) == (maxrounds / 2)) || (timelimit != 0 && timeleft <= (timelimit * 30)))
		{
			for (new client = 1; client <= MaxClients; client++)
			{
				if (IsClientInGame(client) && GetClientTeam(client) > 1)
				{				
					CS_SwitchTeam(client, (GetClientTeam(client) == 2) ? 3 : 2);
				}
			}
			
			new tmp = CS_GetTeamScore(2);
			CS_SetTeamScore(2, CS_GetTeamScore(3));
			CS_SetTeamScore(3, tmp);
			
			SetTeamScore(2, CS_GetTeamScore(2));
			SetTeamScore(3, CS_GetTeamScore(3));
			
			swap = true;
			firsthalf = false;
			ServerCommand("mp_halftime_firsthalf 0");
		}
	}
}