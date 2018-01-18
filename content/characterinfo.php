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

	if( isset( $_SESSION[ 'portalUser' ] ) )
	{
		// First check if the character belongs to the player

		$query = "SELECT accountID FROM account WHERE accountName='".$_SESSION[ 'portalUser' ]."';";
		$result = @mysql_query( $query, $connections[ 'cruc' ] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		if( $row )
		{
			$accountID = $row[ 'accountID' ];
		}else{
			$accountID = 0;
		}

		$query = "SELECT characterID, name AS characterName FROM chrCharacters WHERE accountID=".$accountID.";";
		$result = @mysql_query( $query, $connections[ 'cruc' ] );

		$characterInfo = array(
								"id"	=> array(),
								"name"	=> array()
							);

		$n = 0;

		while( $row = @mysql_fetch_array( $result, MYSQL_ASSOC ) )
		{
			$characterInfo[ 'id'   ][ $n ] = $row[ 'characterID' ];
			$characterInfo[ 'name' ][ $n ] = $row[ 'characterName' ];
			$n += 1;
		}

	}

	if( !isset( $_GET[ 'c' ] ) )
	{

		if( !isset( $_SESSION[ 'portalUser' ] ) )
		{
			echo '<div id="theader"><table><tr><th><center><font style="color: rgb( 255, 0, 0 );"><strong>Error</strong></font></th></tr><tr><td><center>You should be logged in to use this function</center></td></tr></table></div>';
		}else{
			echo 'Select one character to see the character\'s info<br>';
			echo '<center>| ';
			while( $n > 0 )
			{
				$n -= 1;
				echo '<a href="?p=characterinfo&amp;c='.$characterInfo[ 'id' ][ $n ].'">'.$characterInfo[ 'name' ][ $n ].'</a> | ';
			}
			echo '</center>';
		}
	}else{
		if( !isset( $_SESSION[ 'portalUser' ] ) )
		{
			$belongsTo = false;
		}else{
			$query = "SELECT accountID FROM chrCharacters WHERE characterID=".$_GET[ 'c' ].";";
			$result = @mysql_query( $query, $connections[ 'cruc' ] );

			$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

			if( !$row )
			{
				$belongsTo = false;
			}else{
				$belongsTo = true;
			}
		}
		// Ok correct character, fetch the essential data for it and display
		$c = new cache();
		if( $c->start( 'cache/', 3600, false ) == false )
		{
?>
<?php
		    echo '<tr><td width=180 class="content">'.get_character_picture( $_GET[ 'c' ], 180 ).'</td><td class="content">';
		    $cInfo = get_character_info( $_GET[ 'c' ] );

		    echo '<strong>Character name:</strong> '.$cInfo[ 'characterName' ];
		    echo '<br><strong>Gender:</strong> '.$cInfo[ 'gender' ];
		    echo '<br><strong>Race:</strong> '.$cInfo[ 'raceInfo' ][ 'raceName' ];
		    echo '<br><strong>Bloodline:</strong> '.$cInfo[ 'raceInfo' ][ 'bloodlineName' ];
		    echo '<br><strong>Ancestry:</strong> ',$cInfo[ 'raceInfo' ][ 'ancestryName' ];
		    echo '<br><strong>School:</strong> '.$cInfo[ 'raceInfo' ][ 'schoolName' ];
		    echo '<br><strong>Corporation:</strong> '.$cInfo[ 'corporationName' ];
		    echo '<br><strong>Security Status:</strong> '.$cInfo[ 'securityRating' ];
		    echo '<br><strong>Location:</strong> '.$cInfo[ 'stationName' ];
		    echo '</td></tr>';
?>
</table>
<?php
		//if( ( $belongsTo ) || ( ( isset( $_SESSION[ 'portalUser' ] ) ) && ( is_admin( $_SESSION[ 'portalUser' ] ) ) ))
		//{
			// Ok the character is selected, now fetch all the data, thats gonna hurt!
			//$query = "SELECT invTypes.typeName, entity.typeID, entity_attributes.valueInt FROM entity LEFT JOIN invTypes USING (typeID) LEFT JOIN entity_attributes USING (itemID) WHERE ownerID=".$_GET[ 'c' ]." AND attributeID=280;";
			//$result = @mysql_query( $query, $connections[ 'cruc' ] );

?>
<table width=100%>
<?php
/*
			while( $row = @mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				echo '<tr><td class="content">';
				//echo "<a href=\"?p=iteminfo&item=".$row[ 'typeID' ]."\" alt=\"Show item info\"><img width=64 height=64 src=\"".$icon->check( $row[ 'typeID' ] )."\" alt=\"".$row[ 'typeName' ]." Level ".$row[ 'valueInt' ]."\"></a>";
				//echo '</td><td class="content">';
				echo '<a href="?p=iteminfo&item='.$row[ 'typeID' ].'" alt="Show item info">'.$row[ 'typeName' ].'</a> ( '.$row[ 'valueInt' ].' )</td></tr>';
			}
*/
			// Ok now fetch all the implants data
			$query = "SELECT typeName, entity.typeID, entity.flag FROM entity LEFT JOIN invTypes ON invTypes.typeID = entity.typeID WHERE ownerID=".$_GET[ 'c' ]." AND (flag=89 OR flag=88);";
			$result = @mysql_query( $query, $connections[ 'cruc' ] );

			if( ( $result ) && ( mysql_num_rows( $result ) != 0 ) )
			{
?>
</table>
</div>

<div id="iheader">
<table width=100%>
<tr><th width=64 class="content">Icon</th><th class="content">Implant/Booster name</th><th class="content">Type</th></tr>
<?php
					while( $row = @mysql_fetch_array( $result, MYSQL_ASSOC ) )
					{
						echo '<tr><td class="content">';
						echo "<a href=\"?p=iteminfo&item=".$row[ 'typeID' ]."\" alt=\"Show item info\"><img width=64 height=64 src=\"".$icon->check( $row[ 'typeID' ] )."\" alt=\"".$row[ 'typeName' ]."\"></a>";
						echo '</td><td class="content">';
						echo '<a href="?p=iteminfo&item='.$row[ 'typeID' ].'" alt="Show item info">'.$row[ 'typeName' ].'</a>';
						echo '</td><td class="content"><center>';
						if( $row[ 'flag' ] == 89 ) echo 'Implant</center></td></tr>';
						else if( $row[ 'flag' ] == 88 ) echo 'Booster</center></td></tr>';
					}
				}
?>
</table>
</div>
<?php
			//}
			$c->end();
		}
	}
?>
