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
        Author:         Almamu
        Updates:    Allan
*/
?><tr><td class="content" align="center" colspan="10">
<h2><font color=blue>Crucible Server Players</font></h2></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td class="content"><center><strong>Name</strong></center></td>
<td class="content"><center><strong>Race</strong></center></td>
<td class="content"><center><strong>Security Rating</strong></center></td>
<td class="content"><center><strong>Corp (Ticker)</strong></center></td>
<td class="content"><center><strong>Login Time</strong></center></td>
<td class="content"><center><strong>Skill Points</strong></center></td>
<td class="content"><center><strong>Home Station</strong></center></td>
<td class="content"><center><strong>Gender</strong></center></td>
<td class="content"><center><strong>Current System</strong></center></td>
<td class="content"><center><strong>Current Ship</strong></center></td>
<td class="content"><center><strong></strong></center></td></tr>
<?php
	$pInfo = array( array() );

	$query = "
SELECT c.characterID,c.name,cr.raceName,c.securityRating,co.corporationName,co.tickerName,c.logonMinutes,
c.skillPoints,stb.stationName,c.gender,ss.solarSystemName, it.typeName
FROM chrCharacters AS c
LEFT JOIN chrRaces AS cr USING (raceID)
LEFT JOIN crpCorporation AS co USING (corporationID)
LEFT JOIN staStations AS stb ON (stb.stationID = c.baseID)
LEFT JOIN mapSolarSystems AS ss ON (ss.solarSystemID = c.solarSystemID)
LEFT JOIN entity AS e ON (e.itemID = c.shipID)
LEFT JOIN invTypes AS it ON (it.typeID = e.typeID) ORDER BY characterID";
	$result = mysql_query( $query, $connections[ 'cruc' ] );
	$pCount = 0;

	while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$pInfo[ $pCount ][0] = $row[ 'characterID' ];
		$pInfo[ $pCount ][1] = $row[ 'name' ];
        $pInfo[ $pCount ][2] = $row[ 'raceName' ];
        $pInfo[ $pCount ][3] = $row[ 'securityRating' ];
        $pInfo[ $pCount ][4] = $row[ 'corporationName' ];
        $pInfo[ $pCount ][5] = $row[ 'tickerName' ];
        $pInfo[ $pCount ][6] = $row[ 'logonMinutes' ];
        $pInfo[ $pCount ][7] = $row[ 'skillPoints' ];
        $pInfo[ $pCount ][8] = $row[ 'stationName' ];
        if ($row[ 'gender' ])
            $pInfo[ $pCount ][9] = "Male";
        else
            $pInfo[ $pCount ][9] = "Female";
        $pInfo[ $pCount ][10] = $row[ 'solarSystemName' ];
        $pInfo[ $pCount ][11] = $row[ 'typeName' ];
		$pCount += 1;
	}

	$pMax = $pCount;
	$pCount = 0;

	// created .placed(). 
	while ( $pCount < $pMax )
	{
		//echo '<tr><td class="content"><center><a href="?p=characterinfo&c='.$pInfo[$pCount][0].'">'.$pInfo[ $pCount ][1].'</a></center></td>';
		echo '<tr><td class="content"><center>'.$pInfo[ $pCount ][1].'</center></td>';
        echo '<td class="content"><center>'.$pInfo[$pCount][2].'</center></td><td class="content"><center>'.number_format($pInfo[$pCount][3],3).'</center></td>';
        echo '<td class="content"><center>'.$pInfo[$pCount][4].'&nbsp;('.$pInfo[$pCount][5].')</center></td>';
        echo '<td class="content"><center>'.$pInfo[$pCount][6].'</center></td><td class="content"><center>'.$pInfo[$pCount][7].'</center></td>';
        echo '<td class="content"><center>'.$pInfo[$pCount][8].'</center></td><td class="content"><center>'.$pInfo[$pCount][9].'</center></td>';
        echo '<td class="content"><center>'.$pInfo[$pCount][10].'</center></td><td class="content"><center>'.$pInfo[$pCount][11].'</center></td></tr>';
		$pCount += 1;
	}
mysql_free_result($result);
?>
</table><BR>
<!--
<font color=purple>Owner</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=teal>Administrator</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=green>Development</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=yellow>Game Master</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=#44e>Tester</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=white>Player</font>
// -->
</div>
