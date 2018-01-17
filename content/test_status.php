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
'db'=>'EVE_Official'			// Name of your EVE Emulator database
);
foreach($database as $db_check) {
	if( $db_check=="" ) die("CHANGE YOUR DB CONFIGS!");
}

// Init the database connection and other vars
$db = mysql_connect($database['host'], $database['user'], $database['password']); mysql_select_db($database['db']);
$online=0;
$uptime="<font color=red>Offline</font>";
$conns=0;
$players=0;
$accts=0;
$chars=0;

//  is server online?
$status = @fsockopen( $test_server, $test_port, $ERROR_NO, $ERROR_STR, ( float ) 0.5 );
if( $status )
{
	fclose( $status );
	// yes, server online.  get current status
	$query="select config_value as StartTime from srvStatus where config_name = 'serverStartTime';";
	if($result=mysql_query($query,$db)) {
		$row=mysql_fetch_array($result);
		if( $row['StartTime'] ) {
			$online=1;
			// might need to do some local time translations if your server is in a different timezone than your webhost
			$time=time()-$row['StartTime'];
			$uptime=" <font color=green>Online for ";
       		 	$uptime .= GetTime2( $time ) ."</font>";
		}
	} else {
		die("StartTime SQL error");
	}

}

// get count of connections
$query2="select config_value as connections from srvStatus where config_name = 'connectSinceStartup';";
if( $result=mysql_query($query2,$db) ) {
	$row=mysql_fetch_array($result);
	$conns = $row['connections'];
} else {
	die("Connection SQL error");
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
	$query="SELECT count(Online) AS online FROM character_ WHERE Online = 1;";
	if( $result=mysql_query($query,$db) ) {
		$row=mysql_fetch_array($result);
		$players = $row['online'];
	} else {
		die("OnlinePlayers SQL error");
	}
	global $chars;
	$cquery="SELECT count(characterID) AS chars FROM character_ WHERE characterID > 139000000;";
	if( $result=mysql_query($cquery,$db) ) {
		$row=mysql_fetch_array($result);
		$chars = $row['chars'];
	} else {
		die("PC Count error");
	}
}
?>
<tr><td colspan="6" align="center" class="content"><font color=orange><strong><h3>EvEmu Official (Crucible)</h3></strong></font></td></tr>
<?php
// Start the server status table, showing server uptime and player count
printf('<tr><td colspan="3" align="left" class="content">&nbsp;&nbsp;&nbsp;<strong>Server Status:</strong> %s</td>',$uptime);
printf('<td colspan="3" align="center" class="content"><strong>Server Accounts:</strong> %s</td></tr>',$accts);
printf('<tr><td colspan="2" align="center" class="content"><strong>Players Online:</strong> %s</td>',$players);
printf('<td colspan="2" align="center" class="content"><strong>PCs:</strong> %s</td>',$chars);
printf('<td colspan="2" align="center" class="content"><strong>Connections:</strong> %s</td></tr>',$conns);
printf('<tr><td colspan="6">&nbsp;</td></tr>');

// If server is online and there is at least 1 player, draw the Player Status stuff
if( $players && $online ) {
	print('<tr><td align="left" width="20%" class="content">&nbsp;<strong>Name</strong></td>
		<td align="center" width="10%" class="content">&nbsp;<strong>Race</strong></td>
		<td align="center" width="40%" class="content">&nbsp;<strong>Corporation</strong></td>
		<td align="center" width="15%" class="content"><strong>SP</strong>&nbsp;</td>
		<td align="right" width="15%" class="content"><strong>Security</strong>&nbsp;</td>
		<td align="right" width="15%" class="content"><strong>Location</strong>&nbsp;</td></tr>');
	$query="SELECT
            		c.characterID,
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
	if($result=mysql_query($query,$db)) {
		while($row=mysql_fetch_array($result)) {
			printf('<tr><td class="content"><a href="?p=characterinfo&c=%u">%s</a></td>',$row[0],$row[1]);
			printf('<td class="content">&nbsp;%s</td>',$row[2]);
			printf('<td align="center" class="content">&nbsp;%s&nbsp;(%s)</td>',$row[5],$row[6]);
			printf('<td align="right" class="content">%s&nbsp;</td>',number_format($row[4],1));
			printf('<td align="right" class="content">%s&nbsp;</td>',number_format($row[3],2));
			printf('<td class="content">&nbsp;%s</td></tr>',$row[7]);
		}
	} else {
		die("Player SQL error");
	}
}
mysql_free_result($result);

?>
