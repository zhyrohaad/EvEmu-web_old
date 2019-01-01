<?php
/*
        ------------------------------------------------------------------------------------
        LICENSE:
        ------------------------------------------------------------------------------------
        This file is part of EVEmu portal
        Copyright 2006 - 2011 The EVEmu portal Team
        For the latest information visit http://forum.evemu.org/viewtopic.php?f=7&t=68
        ------------------------------------------------------------------------------------
        This program is free software; you can redistribute it and/or modify it under
        the terms of the GNU Lesser General Public License as published by the Free Software
        Foundation; either version 2 of the License, or (at your option) any later
        version.

        This program is distributed in the hope that it will be useful, but WITHOUT
        ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
        FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.

        You should have received a copy of the GNU Lesser General Public License along with
        this program; if not, write to the Free Software Foundation, Inc., 59 Temple
        Place - Suite 330, Boston, MA 02111-1307, USA, or go to
        http://www.gnu.org/copyleft/lesser.txt.
        ------------------------------------------------------------------------------------
        Author:         Almamu		Adrasteia
*/
$database = array(
'host'=>'localhost',
'user'=>'eve',
'password'=>'onlyme',
'db'=>'EVE_Crucible'
);

// Init the database connection and other vars
$db = mysql_connect($database['host'], $database['user'], $database['password']); mysql_select_db($database['db']);
$systems=0;
$players=0;

    $query="SELECT count(online) AS online FROM chrCharacters WHERE online = 1;";
    if( $result=mysql_query($query,$db) ) {
        $row=mysql_fetch_array($result);
        $players = $row['online'];
    } else {
        die("OnlinePlayers SQL error");
    }
    $squery="SELECT count(solarSystemID) AS systems FROM mapDynamicData WHERE active = 1;";
    if( $result=mysql_query($squery,$db) ) {
        $row=mysql_fetch_array($result);
        $systems = $row['systems'];
    } else {
        die("SystemCount SQL error");
    }
?>
<tr><td colspan="10" align="center" class="content"><h1><font color=blue>Solar System Status'</font></h1></td></tr>
<?php
printf('<tr><td colspan="10" align="center" class="content">%s Players Online in %s Active Systems</td>',$players, $systems);
printf('<TR><TD colspan="10">&nbsp;</tr></td>');
printf('<tr><td colspan="10" align="center">Active System Information</td></tr>');
printf('<TR><TD colspan="10">&nbsp;</tr></td>');
    print('<tr><td align="left" width="20%" class="content">&nbsp;<strong>System</strong></td>
        <td align="center" class="content">&nbsp;<strong>Pilots Docked/InSpace</strong></td>
        <td align="center" class="content">&nbsp;<strong>Jumps/Hour</strong></td>
        <td align="center" class="content"><strong>Beacons</strong>&nbsp;</td>
        <td align="center" class="content"><strong>Cyno Fields</strong>&nbsp;</td>
        <td align="center" class="content"><strong>Kills/Hour</strong>&nbsp;</td>
        <td align="center" class="content">&nbsp;<strong>PodKills/Hour</strong></td>
        <td align="center" class="content"><strong>Kills Last 24 Hours</strong>&nbsp;</td>
        <td align="center" class="content"><strong>Pod Kills Last 24 Hours</strong>&nbsp;</td>
        <td align="center" class="content"><strong>FactionKills</strong>&nbsp;</td></tr>');
    $query2="SELECT
              mss.solarSystemName,
              mdd.pilotsDocked,
              mdd.pilotsInSpace,
              mdd.jumpsHour,
              mdd.moduleCnt,
              mdd.structureCnt,
              mdd.killsHour,
              mdd.podKillsHour,
              mdd.kills24Hour,
              mdd.podKills24Hour,
              mdd.factionKills
            FROM mapDynamicData AS mdd
            LEFT JOIN mapSolarSystems AS mss USING (solarSystemID)
            WHERE mdd.active = 1;";
    if($result=mysql_query($query2,$db)) {
        while($row=mysql_fetch_array($result)) {
            printf('<tr><td class="content">%s</td>',$row[0]);
            printf('<td class="content">&nbsp;%s / %s</td>',$row[1],$row[2]);
            printf('<td class="content">&nbsp;%s</td>',$row[3]);
            printf('<td class="content">&nbsp;%s</td>',$row[4]);
            printf('<td class="content">&nbsp;%s</td>',$row[5]);
            printf('<td class="content">&nbsp;%s</td>',$row[6]);
            printf('<td class="content">&nbsp;%s</td>',$row[7]);
            printf('<td class="content">&nbsp;%s</td>',$row[8]);
            printf('<td class="content">&nbsp;%s</td>',$row[9]);
            printf('<td class="content">&nbsp;%s</td>',$row[10]);
        }
    } else {
        die("System SQL error");
    }
?>
<TR><TD colspan="10">&nbsp;</tr></td>
<TR><TD colspan="10">&nbsp;</tr></td>
<tr><td colspan="10" class="error">Please Note...Pilots and Jumps ARE updated dynamically by the server, but RIGHT NOW, it is NOT
deleted on server restarts, so will not be accurate.  Other System information is hard-coded in DB right now for testing.  This page is a DB/Server test, to make sure all relevant information is stored and retrieved correctly, but will give a general idea of active systems.<BR><BR>
Systems Listed here ARE created by the server when a player enters that system, so no unused system will be displayed.<BR>
That means there has been a player in the listed systems at one point, but may not be now, so the pilot count will be wrong.</tr></td>
</table>

<?php
mysql_free_result($result);

?>

