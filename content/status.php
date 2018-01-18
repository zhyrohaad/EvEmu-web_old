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
 *  corrected querys         -allan  12Jan14
 *  updated for server mods  -allan 22Aug14
 ************************************/

$database = array(
'host'=>'localhost',			// Your DNS hostname or IP address
'user'=>'eve',				// MySQL User account with access to SELECT on your Eve database
'password'=>'onlyme',			// MySQL Password
'db'=>'EVE_Crucible'		        // Name of your EVE Emulator database
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
$threads=0;
$items=0;
$systems=0;
$bubbles=0;
$npcs = 0;
$rss=0.0;
$vm=0.0;
$user=0.0;
$kernel=0.0;

//  is server online?
$status = @fsockopen( $cruc_server, $cruc_port, $ERROR_NO, $ERROR_STR, ( float ) 0.5 );
if( $status )
{
	fclose( $status );
	// yes, server online.  get current status
	$query="SELECT startTime FROM srvStatus WHERE AI = 1;";
	if($result=mysql_query($query,$db)) {
		$row=mysql_fetch_array($result);
		if( $row['startTime'] ) {
			$online=1;
			$time=time()-$row['startTime'];
			$uptime=" <font color=green>Online for ";
       		 	$uptime .= GetTime2( $time ) ."</font>";
		}
	} else {
		die("StartTime SQL error");
	}

}

// get count of connections
$query2="SELECT Connections FROM srvStatus";
if( $result=mysql_query($query2,$db) ) {
	$row=mysql_fetch_array($result);
	$conns = $row[0];
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

// get count of total characters
$cquery="SELECT count(characterID) AS chars FROM chrCharacter;";
if( $result=mysql_query($cquery,$db) ) {
	$row=mysql_fetch_array($result);
	$chars = $row['chars'];
} else {
	die("PC Count error");
}

// get count of active players
if( $online ) {
	global $players;
	$query="SELECT count(Online) AS online FROM chrCharacter WHERE Online = 1;";
	if( $result=mysql_query($query,$db) ) {
		$row=mysql_fetch_array($result);
		$players = $row['online'];
	} else {
		die("OnlinePlayers SQL error");
	}
	// get saved settings of all dynamic stats
	global $threads, $items, $systems, $bubbles, $rss, $vm, $user, $kernel;
	$query2="SELECT threads, items, systems, bubbles, npcs, rss, vm, user, kernel, updateTime FROM srvStatus WHERE AI = 1;";
	if( $result=mysql_query($query2,$db) ) {
		$row=mysql_fetch_array($result);
		$threads = $row[0];
		$items = $row[1];
		$systems = $row[2];
		$bubbles = $row[3];
		$npcs = $row[4];
		$rss = number_format($row[5],3);
		$vm = number_format($row[6],3);
		$user = number_format($row[7],2);
		$kernel = number_format($row[8],2);
		$updated = updated($row[9]);
	} else {
		die("Server Stats error");
	}
}
?>
<tr><td colspan="4" align="center" class="content"><font color=orange><strong><h2>Alasiya EvE Status</h2></strong></font></td></tr>
<tr><td colspan="4" align="center" class="content"><?php echo $uptime ?></td></tr>
<tr><td colspan="4" align="center" class="content"><font color=yellow size=2>Updated <?php echo $updated ?>ago.</font></td></tr>
<tr><td colspan="2" align="right" class="content"><strong>Accounts:</strong></td>
    <td colspan="1" align="left" class="content"> <?php echo $accts ?></td>
    <td colspan="2" align="right" class="content"><strong>PCs:</strong></td>
    <td colspan="1" align="left" class="content"> <?php echo $chars ?></td></tr>
<?php
// If server is online, draw the Server Status stuff
if( $online ) {
	printf('
	<tr><td colspan="2" align="right" class="content"><strong>Players Online:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Connections:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Threads:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Items:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Systems:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Bubbles:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>NPCs:</strong></td>
	    <td colspan="1" align="left" class="content"> %s</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Memory:</strong></td>
	    <td colspan="1" align="left" class="content"> %sMB</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>VM:</strong></td>
	    <td colspan="1" align="left" class="content"> %sMB</td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>User Time:</strong></td>
	    <td colspan="1" align="left" class="content"> %s&#37; </td></tr>
	<tr><td colspan="2" align="right" class="content"><strong>Kernel Time:</strong></td>
	    <td colspan="1" align="left" class="content"> %s&#37; </td></tr>',
	$players,$conns,$threads,$items,$systems,$bubbles,$npcs,$rss,$vm,$user,$kernel);
}

printf('<tr><td colspan="6">&nbsp;</td></tr>');

// If server is online draw the Player Status stuff
if( $online ) {
	print('<tr><td align="left" width="20%" class="content">&nbsp;<strong>Name</strong></td>
		<td align="center" width="10%" class="content">&nbsp;<strong>Race</strong></td>
		<td align="center" width="30%" class="content">&nbsp;<strong>Corporation</strong></td>
		<td align="center" width="15%" class="content"><strong>SP</strong>&nbsp;</td>
		<td align="right" width="10%" class="content"><strong>Security</strong>&nbsp;</td>
		<td align="right" width="15%" class="content"><strong>Location</strong>&nbsp;</td></tr>');
}

// If there is at least 1 player, draw the Player Status stuff
if( $players && $online ) {
	$query="SELECT
            c.characterID,
            c.name,
            r.raceName,
            c.securityRating,
            c.skillPoints,
            co.corporationName,
            co.tickerName,
            mr.regionName
        FROM chrCharacters AS c
            LEFT JOIN chrSchools AS s USING (schoolID)
            LEFT JOIN chrRaces AS r USING (raceID)
            LEFT JOIN corporation AS co ON co.corporationID = c.corporationID
            LEFT JOIN mapRegions AS mr ON mr.regionID = c.regionID
        WHERE online=1;";
	if($result=mysql_query($query,$db)) {
		while($row=mysql_fetch_array($result)) {
			printf('<tr><td class="content"><a href="?p=characterinfo&c=%u">%s</a></td>
				<td class="content">&nbsp;%s</td>
				<td align="center" class="content">&nbsp;%s&nbsp;(%s)</td>
				<td align="right" class="content">%s&nbsp;</td>
				<td align="right" class="content">%s&nbsp;</td>
				<td align="center" class="content">&nbsp;%s</td></tr>',
				$row[0],$row[1],$row[2],$row[5],$row[6],number_format($row[4],1),
				number_format($row[3],2),$row[7]);
		}
	} else {
		die("Player SQL error");
	}
}
mysql_free_result($result);

?>
</table>