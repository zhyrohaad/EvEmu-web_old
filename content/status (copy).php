<?php
/************************************
 * EVE Emulator: Server Status Script
 * Copyright 2008
 * No license - do whatever you want with it
 * ------------------
 * status.php
 * Began: Wed Apr 2 2008
 *
 * $Id: status.php,v 1.03 2008/04/02 19:18:17 john adams Exp $
 *
 *  corrected querys  -allan  12Jan14
 ************************************/

// You MUST set these up, or the script will die.
$database = array(
'host'=>'localhost',			// Your DNS hostname or IP address
'user'=>'eve',				// MySQL User account with access to SELECT on your Eve database
'password'=>'onlyme',			// MySQL Password
'db'=>'EVE_Crucible'			// Name of your EVE Emulator database
);
foreach($database as $db_check) {
	if( $db_check=="" ) die("CHANGE YOUR DB CONFIGS!");
}

// Init the database connection and other vars
$db = mysqli_connect($database['host'], $database['user'], $database['password']); mysqli_select_db($database['db']);
$online=0;
$uptime="Offline";
$conns=0;
$players=0;
$accts=0;
$chars=0;

// get current status 
$query="select config_value as StartTime from srvStatus where config_name = 'serverStartTime';";
$query2="select config_value as Connections from srvStatus where config_name = 'connectSinceStartup';";
if($result=mysqli_query($query,$db)) {
	$row=mysqli_fetch_array($result);
	if( $row['StartTime'] ) {
		$online=1;
		// might need to do some local time translations if your server is in a different timezone than your webhost
		$time=time()-$row['StartTime'];
		// probably a better way to dice up the seconds since 1970... but I was in a hurry
		$weeks=$time/604800;
		$days=($time%604800)/86400;
		$hours=(($time%604800)%86400)/3600;
		$minutes=((($time%604800)%86400)%3600)/60;
		$seconds=(((($time%604800)%86400)%3600)%60);

		$uptime=' Online for ';
		if(intval($days)) $uptime .= ( intval($days)>1 ) ? intval($days) . " Days " : intval($days) . " Day ";
		if(intval($hours)) $uptime .= ( intval($hours)>1 ) ? intval($hours) . " Hours " : intval($hours) . " Hour ";
		if(intval($minutes)) $uptime .= ( intval($minutes)>1 ) ? intval($minutes) . " Minutes " : intval($minutes) . " Minutes ";
		if(!intval($minutes)&&!intval($hours)&&!intval($days)) $uptime.=" ".intval($seconds)." Seconds";
	}
} else {
	die("StartTime SQL error");
}

// get count of connections
$query2="select config_value as connections from srvStatus where config_name = 'connectSinceStartup';";
if( $result=mysqli_query($query2,$db) ) {
	$row=mysqli_fetch_array($result);
	$conns = $row['connections'];
} else {
	die("Connection SQL error");
}

// get count of accounts
$aquery="SELECT count(accountID) AS accounts FROM account";
if( $result=mysqli_query($aquery,$db) ) {
	$row=mysqli_fetch_array($result);
	$accts = $row['accounts'];
} else {
	die("Account SQL error");
}

// get count of active players
if( $online ) {
	global $players;
	$query="SELECT count(Online) AS online FROM character_ WHERE Online = 1;";
	if( $result=mysqli_query($query,$db) ) {
		$row=mysqli_fetch_array($result);
		$players = $row['online'];
	} else {
		die("OnlinePlayers SQL error");
	}
	global $chars;
	$cquery="SELECT count(characterID) AS chars FROM character_ ;";
	if( $result=mysqli_query($cquery,$db) ) {
		$row=mysqli_fetch_array($result);
		$chars = $row['chars'];
	} else {
		die("PC Count error");
	}
}
// Start the server status table, showing server uptime and player count
print('<BR><BR><table align="center" cellspacing="2" border="1" width="100%">');
printf('<tr><td colspan="3" align="center"><strong>Server Status:</strong> %s</td>',$uptime);
printf('<td colspan="3" align="center"><strong>Server Accounts:</strong> %s</td></tr>',$accts);
printf('<tr><td colspan="6">&nbsp;</td></tr>');

// If there is at least 1 player online, draw the Player Status stuff
if( $players && $online ) {
	printf('<tr><td colspan="3" align="center"><strong>Players Online:</strong> %s</td>',$players);
	printf('<td colspan="3" align="center"><strong>PCs:</strong> %s</td></tr>',$chars);
	printf('<tr><td colspan="6">&nbsp;</td></tr>');

	print('
		<tr>
			<td align="left" width="20%">&nbsp;<strong>Name</strong></td>
			<td align="center" width="10%">&nbsp;<strong>Race</strong></td>
			<td align="center" width="40%">&nbsp;<strong>Corporation</strong></td>
			<td align="right" width="15%"><strong>SP</strong>&nbsp;</td>
			<td align="right" width="15%"><strong>Security</strong>&nbsp;</td>
			<td align="right" width="15%"><strong>Region</strong>&nbsp;</td>
		</tr>');
	$query="SELECT
			e.itemName,
			r.raceName,
			c.securityRating,
			c.skillPoints,
			co.corporationName,
			co.tickerName,
			mr.regionName
				FROM character_ AS c
					LEFT JOIN entity AS e ON e.itemID = c.characterID
					LEFT JOIN chrSchools AS s ON s.schoolID = c.schoolID
					LEFT JOIN chrRaces AS r ON r.raceID = s.raceID  
					LEFT JOIN corporation AS co ON co.corporationID = c.corporationID
					LEFT JOIN mapRegions AS mr ON mr.regionID = c.regionID
				WHERE Online=1;";
	if($result=mysqli_query($query,$db)) {
		while($row=mysqli_fetch_array($result)) {
			print('<tr>');
			printf('<td>&nbsp;%s</td>',$row[0]);
			printf('<td>&nbsp;%s</td>',$row[1]);
			printf('<td>&nbsp;%s&nbsp;(%s)</td>',$row[4],$row[5]);
			printf('<td align="right">%s&nbsp;</td>',number_format($row[3],1));
			printf('<td align="right">%s&nbsp;</td>',number_format($row[2],2));
			printf('<td>&nbsp;%s</td>',$row[6]);
			print('</tr>');
		}
	} else {
		die("Player SQL error");
	}
}
print("</table>");
mysqli_free_result($result);

?>
