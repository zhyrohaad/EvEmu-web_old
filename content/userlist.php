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
*/
?><tr><td class="content" align="center" colspan="3">
<h2><font color=blue>Crucible Server Players</font></h2></td></tr>
<tr><td class="content"><center><strong>Player ID</strong></center></td>
<td class="content"><center><strong>Account Name</strong></center></td>
<td class="content"><center><strong>Character (Login Time)</strong></center></td></tr>
<?php
	$pInfo = array( array() );

	$query = "SELECT accountID, accountName FROM account ORDER BY accountID";
	$result = mysql_query( $query, $connections[ 'cruc' ] );
	$pCount = 1;
	$pMax = 0;

	while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
	{
		$pInfo[ $pCount ][0] = $row[ 'accountID' ];
		$pInfo[ $pCount ][1] = $row[ 'accountName' ];
		$pCount += 1;
	}

	$pMax = $pCount;
	$pCount = 1;
	$pChr = 0;

	while( $pCount <= $pMax )
	{
		if( !( empty( $pInfo[ $pCount ][0] ) ) )
		{
			$query = "SELECT characterID, logonMinutes FROM character_ WHERE accountID=".$pInfo[ $pCount ][0];
			$result = mysql_query( $query, $connections[ 'cruc' ] );

			while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				$query = "SELECT itemName FROM entity WHERE itemID=".$row[ 'characterID' ];
				$result_row = mysql_query( $query, $connections[ 'cruc' ] );
				$rowRes = mysql_fetch_array( $result_row, MYSQL_ASSOC );
				$pInfo[ $pCount ][ $pChr + 2 ] = $rowRes[ 'itemName' ];
                $pInfo[ $pCount ][ $pChr + 3 ] = "  ( ".GetTime( $row[ 'logonMinutes' ] )." )";
				$pChr += 1;
			}
		}

		$pChr = 0;
		$pCount += 1;
	}

	$pCount = 1;

	while( $pCount < $pMax )
	{
		echo '<tr><td class="content"><center>'.$pInfo[$pCount][0].'</center></td><td class="content"><center>'.$pInfo[$pCount][1].'</center></td><td class="content"><center>';
		if( isset( $pInfo[ $pCount ][2] ) )
		{
			echo '<a href="?p=characterinfo&c='.get_character_id( $pInfo[ $pCount ][2] ).'">'.$pInfo[ $pCount ][2].'</a>  '.$pInfo[ $pCount ][3].'</center></td><td class="content"><center>';
		}else{
			echo '<font color=red>None</font></center></td><td class="content"><center>';
		}

		$pCount += 1;
	}
?>
</table><BR>
<font color=purple>Owner</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=teal>Administrator</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=green>Development</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=yellow>Game Master</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=#44e>Tester</font>&nbsp;&nbsp;|&nbsp;&nbsp;
<font color=white>Player</font>
</div>
