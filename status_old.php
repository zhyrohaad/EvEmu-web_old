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
 *  Modified for Alasiya by Allan  
 *  15 Dec 2012
 ************************************/

// Set error reporting to only a few things.
error_reporting( E_ERROR | E_PARSE | E_WARNING ) ;
ini_set( 'display_errors', '0' ) ;

require_once ( 'content/dbsimple/Generic.php' ) ;

$db = array(
'type'			=>'mysql',				// MySQL database
'host'			=>'localhost',			// MySQL hostname
'user'			=>'apache',				// MySQL User account with access to SELECT on your Eve database
'password'	=>'alasiya',				// MySQL Password
'port'			=>'3306',				// MySQL Port
'db'			=>'EVE_Apocrypha'	// Name of your EVE Emulator database
);

// Init the database connection
$DB = DbSimple_Generic::connect( "" . $db['type'] . "://" . $db['user'] .
	":" . $db['password'] . "@" . $db['host'] . ":" . $db['port'] . "/" . $db['db'] . "" ) ;

$DB->setErrorHandler('databaseErrorHandler');

// get current status
$status = array();
$status = $DB->select("SELECT config_value AS StartTime FROM srvStatus WHERE config_name = 'serverStartTime' ");

if($status) {

	$time=time() - $status['StartTime'];

	// probably a better way to dice up the seconds since 1970... but I was in a hurry
//   ** NOT RIGHT....FIX THIS - allan
	$weeks=$time/604800;
	$days=($time%604800)/86400;
	$hours=(($time%604800)%86400)/3600;
	$minutes=((($time%604800)%86400)%3600)/60;
	$seconds=(((($time%604800)%86400)%3600)%60);

	$uptime='';
	if(intval($days)) 		$uptime .= ( intval($days)>1 ) 		? intval($days)		. " Days " 		: intval($days)	. " Day "; 
	if(intval($hours)) 	$uptime .= ( intval($hours)>1 ) 	? intval($hours)		. " Hours " 		: intval($hours)	. " Hour ";
	if(intval($minutes)) $uptime .= ( intval($minutes)>1 )	? intval($minutes)	. " Minutes " : intval($minutes)	. " Minutes ";
	if(!intval($minutes)&&!intval($hours)&&!intval($days)) $uptime.=" ".intval($seconds)." Seconds";
	//printf("Time: %s<br>Weeks: %s<br>Days: %s<br>Hours: %s<br>Minutes: %s<br>Seconds: %s",time(),$weeks,$days,$hours,$minutes,$seconds);
} else {
	die(" SQL error 1");
}

// Start the server status table, showing server uptime
print('<table align="center" cellspacing="2" border="1" width="60%">');
printf('<tr><td colspan="6" align="center"><strong>Server Uptime:</strong> %s</td></tr>',$uptime);

// get count of active players
$rows = array();
$num = 0;
$rows = $DB->selectPage($num, 'SELECT * FROM character_ WHERE online = 1');

// If there is at least 1 player online, draw the Players Online stuff
if( $num ) {
	printf('<tr><td colspan="6" align="center"><strong>Players Online:</strong> %s</td></tr>',$num);
}
	
// If there is at least 1 player online, draw the Player Status stuff
if( $num ) {
	print('
		<tr>
			<td align="left" width="15%">&nbsp;<strong>Name</strong></td>
			<td align="center" width="15%">&nbsp;<strong>Race</strong></td>
			<td align="center" width="40%">&nbsp;<strong>Corporation</strong></td>
			<td align="right" width="25%"><strong>SP</strong>&nbsp;</td>
			<td align="right" width="5%"><strong>Security</strong>&nbsp;</td>
		</tr>
		');

	$char = array();
	
	// this is really fucked up to go char->ancestry->bloodline->race but no other way to get around it.
	$char = $DB->select("SELECT 
				c.characterID AS id,  
				c.securityRating AS sec, 
				co.corporationName AS corp,
				co.tickerName AS ticker,
				e.itemName AS name,
				r.raceName AS race
				FROM character_ AS c
				LEFT JOIN corporation AS co ON (co.corporationID = c.corporationID)
				LEFT JOIN chrAncestries AS a ON (a.ancestryID = c.ancestryID)
				LEFT JOIN chrBloodlines AS bl ON (bl.bloodlineID = a.bloodlineID)
				LEFT JOIN chrRaces AS r ON (r.raceID = bl.raceID)
				LEFT JOIN entity AS e ON (e.itemID = c.characterID)
				WHERE online = 1 ");
	if($char) {
		foreach($char as $row) {
			print('<tr>');
			printf('<td>&nbsp;%s</td>',$row['name']);
			printf('<td>&nbsp;%s</td>',$row['race']);
			printf('<td>&nbsp;%s</td>',$row['corp']);
			printf('<td align="right">%s SP in %s Skills&nbsp;</td>',getSkillPoints($row['id']),getSkills($row['id']));
			printf('<td align="right">%s&nbsp;</td>',number_format($row['sec'],2));
			print('</tr>');
		}
	} else {
		die(" SQL error 3");
	}
}
print("</table>");

function getSkillPoints($id) {
	global $DB;
	$sp = array();
	$sp = $DB->select("
			SELECT 
			e.itemID AS item,
			ea.valueInt AS value,
			ea.attributeID AS attr
			FROM entity AS e 
			LEFT JOIN entity_attributes AS ea ON (e.itemID = ea.itemID)
			WHERE e.ownerID = ".$id." AND e.flag
			");
			
	if($sp) {
		foreach($sp as $row) {
			if ($row['attr'] == 276) {
				$total += $row['value'];
			}
		}
		return ( number_format($total));
	} else {
		return 0;
	}	
}

function getSkills($id) {
	global $DB;
	$sp = array();
	$sp = $DB->select("
			SELECT 
			e.itemID AS item,
			ea.valueInt AS value,
			ea.attributeID AS attr
			FROM entity AS e 
			LEFT JOIN entity_attributes AS ea ON (e.itemID = ea.itemID)
			WHERE e.ownerID = ".$id." AND e.flag
			");
			
	if($sp) {
		foreach($sp as $row) {
			if ($row['attr'] == 280) {
				$total += $row['value'];
			}
		}
		return ( number_format($total));
	} else {
		return 0;
	}	
}

function databaseErrorHandler($message, $info) {
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; print_r($info); echo "</pre>";
    exit();
}

// Free Memory
unset($query, $status, $result, $row, $rows, $num, $sp, $char, $message, $info, $id, $total);

?>