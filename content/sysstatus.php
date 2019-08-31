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

// Init the vars
$systems=0;
$players=0;

    $query="SELECT count(online) AS online FROM chrCharacters WHERE online = 1;";
	$result = mysqli_query($connections[ 'cruc' ], $query);
	if($result) {
        $row=mysqli_fetch_array($result);
        $players = $row['online'];
    } else {
        die("OnlinePlayers SQL error");
    }
    $squery="SELECT count(solarSystemID) AS systems FROM mapDynamicData WHERE active = 1;";
	$result = mysqli_query($connections[ 'cruc' ], $squery);
	if($result) {
        $row=mysqli_fetch_array($result);
        $systems = $row['systems'];
    } else {
        die("SystemCount SQL error");
    }
?>
<tr><td colspan="11" align="center" class="content"><h1><font color=blue>Active Solar Systems</font></h1></td></tr>
<?php
printf('<tr><td colspan="11" align="center" class="content">%s Players Online in %s Active Systems</td>',$players, $systems);
printf('<TR><TD colspan="11">&nbsp;</tr></td>');
printf('<TR><TD colspan="11" align="center">System data updated every 15 minutes.</tr></td>');
printf('<TR><TD colspan="11">&nbsp;</tr></td>');
printf('<TR><TD colspan="11">&nbsp;</tr></td>');
    print('<tr><td align="center" width="15%" class="content"><strong>System</strong></td>
        <td align="center" class="content"><strong>Docked</strong></td>
        <td align="center" class="content"><strong>InSpace</strong></td>
        <td align="center" class="content"><strong>Jumps</strong></td>
        <td align="center" class="content"><strong>Kills</strong></td>
        <td align="center" class="content"><strong>Faction Kills</strong></td>
        <td align="center" class="content"><strong>PodKills</strong></td>
        <td align="center" class="content"><strong>Kills 24h</strong></td>
        <td align="center" class="content"><strong>PodKills 24h</strong></td>
        <td align="center" class="content"><strong>Beacons</strong></td>
        <td align="center" class="content"><strong>Cynos</strong></td></tr>');
    $query2="SELECT
              mss.solarSystemName,
              mdd.pilotsDocked,
              mdd.pilotsInSpace,
              mdd.jumpsHour,
              mdd.killsHour,
              mdd.factionKills,
              mdd.podKillsHour,
              mdd.kills24Hour,
              mdd.podKills24Hour,
              mdd.moduleCnt,
              mdd.structureCnt
            FROM mapDynamicData AS mdd
            LEFT JOIN mapSolarSystems AS mss USING (solarSystemID)
            WHERE mdd.active = 1;";
	$result = mysqli_query($connections[ 'cruc' ], $query2);
	if($result) {
        while($row=mysqli_fetch_array($result)) {
            printf('<tr><td align="center" class="content">%s</td>',$row[0]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[1]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[2]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[3]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[4]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[5]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[6]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[7]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[8]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[9]);
            printf('<td align="center" class="content">&nbsp;%s</td>',$row[10]);
        }
    } else {
        die("System SQL error");
    }
mysqli_free_result($result);
?>
<TR><TD colspan="11">&nbsp;</tr></td>
</table>

