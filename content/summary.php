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
        Author:         Allan
*/
?>
<tr><td class="content" align="center" colspan="5">
<h2><font color=blue>Crucible System Summary</font></h2></td></tr>
<tr><td class="content"><center><strong>System</strong></center></td>
<td class="content"><center><strong>Agents</strong></center></td>
<td class="content"><center><strong>Max Agent Level</strong></center></td>
<td class="content"><center><strong>Asteroid Belts</strong></center></td>
<td class="content"><center><strong>Ice Belts</strong></center></td></tr>

<?php
	$pInfo = array( array() );
	$query = "SELECT * FROM mapSystemSummary;";
	$result = mysql_query( $query, $connections[ 'cruc' ] );
	$pCount = 1;
	$pMax = 0;

	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$pInfo[ $pCount ][0] = $row[ 'solarSystemName' ];
		$pInfo[ $pCount ][1] = $row[ 'agent_count' ];
		$pInfo[ $pCount ][2] = $row[ 'agent_max_level' ];
		$pInfo[ $pCount ][3] = $row[ 'asteroid_belts' ];
		$pInfo[ $pCount ][4] = $row[ 'ice_belts' ];
		$pCount ++;
	}

	$pMax = $pCount;
	$pCount = 1;

	while( $pCount < $pMax )
	{
		echo '<tr><td class="content"><center>'.$pInfo[ $pCount ][0].'</center></td>';
		echo '<td class="content"><center>'.$pInfo[ $pCount ][1].'</center></td>';
		echo '<td class="content"><center>'.$pInfo[ $pCount ][2].'</center></td>';
		echo '<td class="content"><center>'.$pInfo[ $pCount ][3].'</center></td>';
		echo '<td class="content"><center>'.$pInfo[ $pCount ][4].'</center></td></tr>';
		$pCount ++;
	}
?>

</table>
</div><BR><BR><BR>
