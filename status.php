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
 *  corrected querys  		-allan	12Jan14
 *  updated for DB mods		-allan	13Aug14
 ************************************/

// You MUST set these up, or the script will die.
$database = array(
'host'=>'localhost',			// Your DNS hostname or IP address
'user'=>'eve',				// MySQL User account with access to SELECT on your Eve database
'password'=>'onlyme',			// MySQL Password
'db'=>'EVE_Dev'			// Name of your EVE Emulator database
);
foreach($database as $db_check) {
	if( $db_check=="" ) die("CHANGE YOUR DB CONFIGS!");
}

// Init the database connection and other vars
$db = mysql_connect($database['host'], $database['user'], $database['password']); mysql_select_db($database['db']);
$online=0;
$uptime="Offline";
$players=0;
$accts=0;
$chars=0;

// get current status
$query="select startTime from srvStatus";
if($result=mysql_query($query,$db)) {
	$row=mysql_fetch_array($result);
	if( $row['startTime'] ) {
		$online=1;
		// might need to do some local time translations if your server is in a different timezone than your webhost
		$time=time()-$row['StartTime'];
		$uptime=' Online for 'GetTime2($time);
	}
} else {
	die("StartTime SQL error");
}

// get count of accounts
$aquery="SELECT count(accountID) AS accounts FROM account";
if( $result=mysql_query($aquery,$db) ) {
	$row=mysql_fetch_array($result);
	$accts = $row['accounts'];
} else {
	die("Account SQL error");
}

// get count of active players
if( $online ) {
	global $players;
	$query="SELECT count(Online) AS online FROM chrCharacter WHERE Online = 1;";
	if( $result=mysql_query($query,$db) ) {
		$row=mysql_fetch_array($result);
		$players = $row['online'];
	} else {
		die("Player SQL error");
	}
	global $chars;
	$cquery="SELECT count(characterID) AS chars FROM chrCharacter ;";
	if( $result=mysql_query($cquery,$db) ) {
		$row=mysql_fetch_array($result);
		$chars = $row['chars'];
	} else {
		die("Characters SQL error");
	}
}
// Start the server status table, showing server uptime and player count
print('<BR><BR><table align="center" cellspacing="2" border="1" width="60%">');
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
				FROM chrCharacter AS c
					LEFT JOIN entity AS e ON e.itemID = c.characterID
					LEFT JOIN chrSchools AS s ON s.schoolID = c.schoolID
					LEFT JOIN chrRaces AS r ON r.raceID = s.raceID
					LEFT JOIN corporation AS co ON co.corporationID = c.corporationID
					LEFT JOIN mapRegions AS mr ON mr.regionID = c.regionID
				WHERE Online=1;";
	if($result=mysql_query($query,$db)) {
		while($row=mysql_fetch_array($result)) {
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
		die("SP SQL error");
	}
}
print("</table>");
mysql_free_result($result);

?>
