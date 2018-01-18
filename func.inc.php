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

	function imageserver_on( )
	{
		//include( 'config.php' );
		//$status = @fsockopen( 'image.eveonline.com', 80, $ERROR_NO, $ERROR_STR, ( float ) 0.5 );
		//if( $status )
		//{
		//	fclose( $status );
		//	return true;
		//}
		return false;
	}

	function item_exists( $itemID )
	{
		global $connections;
		$query = "SELECT typeID FROM invTypes WHERE typeID=".$itemID;
		if($result = mysql_query( $query, $connections['cruc'] ))
        {
            $row = mysql_fetch_array( $result, MYSQL_ASSOC );
            if( $row ) return true;
        } else {
            echo 'Invalid query: ' . mysql_error() . "\n";
            echo 'Whole query: ' . $query;
            return false;
        }
		return false;
	}

	class imgCache
	{
		var $chache_file;

		function check( $characterID )
		{
			include( 'config.php' );
			if( empty( $characterID ) )$characterID = 1;

			$cache_file = 'images/cache/characters/'.$characterID.'_512.jpg';
			if( file_exists( $cache_file ) )
			{
				return 'images/cache/characters/?img='.$characterID.'';
			}else
				{
					$cache_file = 'http://'.$game_server.':'.( $cruc_port + 1 ).'/Character/'.$characterID.'_512.jpg';
					$oF = fopen( $cache_file, 'r' );
					$dF = fopen( 'images/cache/characters/'.$characterID.'_512.jpg', 'w');
					while( !feof( $oF ) )
					{
						$data = fread( $oF, 512 );
						fwrite( $dF, $data, 512 );
					}

					fclose( $oF );
					fclose( $dF );
				}
				return 'images/cache/characters/?img='.$characterID.'';
			}
		}

	class iconCache
	{
		var $chache_file;

		function check( $itemID )
		{
			include( 'config.php' );
			if( empty( $itemID ) )$itemID = 1;

			$cache_file = 'images/cache/items/'.$itemID.'_64.png';
			if( file_exists( $cache_file ) )
			{
				return 'images/cache/items/?img='.$itemID.'';
			}else{
				if( imageserver_on( ) )
				{
					$cache_file = 'http://image.eveonline.com/InventoryType/'.$itemID.'_64.png';
					$oF = fopen( $cache_file, 'r' );
					$dF = fopen( 'images/cache/items/'.$itemID.'_64.png', 'w');
					while( !feof( $oF ) )
					{
						$data = fread( $oF, 512 );
						fwrite( $dF, $data, 512 );
					}

					fclose( $oF );
					fclose( $dF );
					return 'images/cache/items/?img='.$itemID.'';
				}
				return 'images/cache/items/?img='.$itemID.'';
			}
		}
	}

	function timequery(){
		static $querytime_begin;
		list( $usec, $sec ) = explode( ' ',microtime() );
		if( !isset($querytime_begin) )
		{
			$querytime_begin = ( ( float ) $usec + ( float ) $sec );
		}
		else
		{
			$querytime = ( ( ( float ) $usec + ( float ) $sec)) - $querytime_begin;
			return sprintf( 'Script executed in %01.5f seconds', $querytime );
		}
	}

	function mysql_crucible_connect()
	{
		include( 'config.php' );
		$hndSQL = mysql_connect( $sql_crucible_host, $sql_crucible_user, $sql_crucible_pass, true );
		mysql_select_db( $sql_crucible_db, $hndSQL );
		return $hndSQL;
	}

	function mysql_crucible_test_connect()
	{
		include( 'config.php' );
		$hndSQL = mysql_connect( $sql_crucible_test_host, $sql_crucible_test_user, $sql_crucible_test_pass, true );
		mysql_select_db( $sql_crucible_test_db, $hndSQL );
		return $hndSQL;
	}

	function mysql_apocrypha_connect()
	{
		include( 'config.php' );
		$hndSQL = mysql_connect( $sql_apocrypha_host, $sql_apocrypha_user, $sql_apocrypha_pass, true );
		mysql_select_db( $sql_apocrypha_db, $hndSQL );
		return $hndSQL;
	}

	function mysql_incursion_connect()
	{
		include( 'config.php' );
		$hndSQL = mysql_connect( $sql_incursion_host, $sql_incursion_user, $sql_incursion_pass, true );
		mysql_select_db( $sql_incursion_db, $hndSQL );
		return $hndSQL;
	}

	function mysql_portal_connect()
	{
		include( 'config.php' );
		$hndSQL = mysql_connect( $sql_portal_host, $sql_portal_user, $sql_portal_pass, true );
		mysql_select_db( $sql_portal_db, $hndSQL );
		return $hndSQL;
	}

	function initDB()
	{
		include( 'config.php' );
		$sql_crucible_connection = @mysql_crucible_connect();
		if( !$sql_crucible_connection )
		{
			echo '<div id="out">Can\'t connect to the gameserver DB. MySQL Error: '.mysql_error().'</div>';
			return false;
		}

		$sql_crucible_test_connection = @mysql_crucible_test_connect();
		if( !$sql_crucible_test_connection )
		{
			echo '<div id="out">Can\'t connect to the gameserver DB. MySQL Error: '.mysql_error().'</div>';
			return false;
		}

		$sql_apocrypha_connection = @mysql_apocrypha_connect();
		if( !$sql_apocrypha_connection )
		{
			echo '<div id="out">Can\'t connect to the gameserver DB. MySQL Error: '.mysql_error().'</div>';
			return false;
		}

		$sql_incursion_connection = @mysql_incursion_connect();
		if( !$sql_apocrypha_connection )
		{
			echo '<div id="out">Can\'t connect to the gameserver DB. MySQL Error: '.mysql_error().'</div>';
			return false;
		}

		$sql_portal_connection = @mysql_portal_connect();
		if( !$sql_portal_connection )
		{
			echo '<div id="out">Can\'t connecto to the portal DB. MySQL Error: '.mysql_error().'</div>';
			return false;
		}

		$connections = array(
			'cruc' => $sql_crucible_connection,
            'test' => $sql_crucible_test_connection,
			'apoc' => $sql_apocrypha_connection,
			'inc' => $sql_incursion_connection,
			'portal' => $sql_portal_connection
		);

		return $connections;
	}

	function closeDB()
	{
		global $connections;
		mysql_close( $connections[ 'cruc' ] );
		mysql_close( $connections[ 'test' ] );
		mysql_close( $connections[ 'apoc' ] );
		mysql_close( $connections[ 'inc' ] );
		mysql_close( $connections[ 'portal' ] );
	}

	function get_station_name( $stationid )
	{
		global $connections;
		if( $stationid == 0 )return 'Somewhere in space';
		$qquery = "SELECT stationName FROM staStations WHERE stationID=".$stationid.";";
		$qresult = @mysql_query( $qquery, $connections['cruc'] );

		$qrow = @mysql_fetch_array( $qresult, MYSQL_ASSOC );

		return $qrow[ 'stationName' ];
	}

	function get_account_name( $accountid )
	{
		global $connections;
		if( $accountid == 0 ) return 'Anonymous';
		$query = "SELECT accountName FROM account WHERE accountID=".$accountid.";";
		$result = mysql_query( $query, $connections['cruc'] );

		$row = mysql_fetch_array( $result, MYSQL_ASSOC );

		if( $row )return $row[ 'accountName' ];
		else return false;
	}

	function get_character_picture( $characterID, $size = 128 )
	{
		global $img;
		include( 'config.php' );
		return '<img width='.$size.' height='.$size.' src="'.$img->check( $characterID ).'" alt="Character picture">';
	}

	function get_principal_picture( $accountID, $size = 128 )
	{
		global $connections;
		include( 'config.php' );
		$query = "SELECT characterID FROM chrCharacters WHERE accountID=".$accountID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return 1; // get_character_picture( $row[ 'characterID' ] );
	}

	function get_principal_character( $accountID )
	{
		global $connections;
		include( 'config.php' );
		$query = "SELECT characterID FROM chrCharacters WHERE accountID=".$accountID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'characterID' ];
	}

	function get_account_id( $accountName )
	{
		global $connections;
		if( empty( $accountName ) )return 0;
		$query = "SELECT accountID FROM account WHERE accountName='".$accountName."';";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'accountID' ];
	}

	function get_last_reply( $post )
	{
		global $connections;
		$query = "SELECT date, creatorID FROM forum_replies WHERE topicid=".$post." ORDER BY id DESC";
		$result = @mysql_query( $query, $connections[ 'portal' ] );

		$row = mysql_fetch_array( $result, MYSQL_ASSOC );

		if( $row )
		{
			$ret = array(
						'name' => get_account_name( $row[ 'creatorID' ] ),
						'date' => $row[ 'date' ]
						);
		}
		return $ret;

	}

	function get_last_topic( $categoryID )
	{
		global $connections;

		$query = "SELECT date, creatorID FROM forum_topics WHERE categoryID=".$categoryID." ORDER BY date DESC";
		$result = @mysql_query( $query, $connections[ 'portal' ] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		if( $row )
		{
			$ret = array(
						'name' => get_account_name( $row[ 'creatorID' ] ),
						'date' => $row[ 'date' ]
						);
		}else{
			$ret = array(
						'name' => 'No last topics',
						'date' => NULL
						);
		}

		return $ret;
	}

	function get_character_name( $characterID )
	{
		global $connections;
		if( empty( $characterID ) )
		{
			return 'Anonymous';
		}

		$query = "SELECT name FROM chrCharacters WHERE characterID=".$characterID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'name' ];
	}

	function get_character_id( $characterName )
	{
		global $connections;
		if( empty( $characterName ) )
		{
			return '0';
		}

		$query = "SELECT characterID FROM chrCharacters WHERE name='".$characterName."';";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'characterID' ];
	}

	function get_corporation_name( $corporationID )
	{
		global $connections;
		if( empty( $corporationID ) ) return 'None';
		$query = "SELECT corporationName FROM crpCorporation WHERE corporationID=".$corporationID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'corporationName' ];
	}

	function get_race_name( $raceID )
	{
		global $connections;
		$query = "SELECT raceName FROM chrRaces WHERE raceID=".$raceID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'raceName' ];
	}


	function get_race_info( $ancestryID, $careerID, $schoolID )
	{
		global $connections;
		if( ( empty( $ancestryID ) ) && ( empty( $careerID ) ) && ( empty( $schoolID ) ) )
		{
			$ret = array(
				'raceName' => 'Unknown',
				'careerName' => 'Unknown',
				'ancestryName' => 'Unknown',
				'bloodlineName' => 'Unknown',
				'schoolName' => 'Unknown'
				);
			return $ret;
		}

        $query = "SELECT careerName FROM chrCareers WHERE careerID=".$careerID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		$careerName = $row[ 'careerName' ];

		$query = "SELECT ancestryName, bloodlineID FROM chrAncestries WHERE ancestryID=".$ancestryID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		$ancestryName = $row[ 'ancestryName' ];
		$bloodlineID = $row[ 'bloodlineID' ];

		$query = "SELECT bloodlineName, raceID FROM chrBloodlines WHERE bloodlineID=".$bloodlineID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		$bloodlineName = $row[ 'bloodlineName' ];
		$raceName = get_race_name( $row[ 'raceID' ] );

		$query = "SELECT schoolName FROM chrSchools WHERE schoolID=".$schoolID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		$schoolName = $row[ 'schoolName' ];

		$ret = array(
			'raceName' => $raceName,
			'careerName' => $careerName,
			'ancestryName' => $ancestryName,
			'bloodlineName' => $bloodlineName,
			'schoolName' => $schoolName
			);

		return $ret;
	}

	function get_character_info( $characterID )
	{
		global $connections;
		$query = "SELECT corporationID, securityRating, ancestryID, careerID, schoolID, careerSpecialityID, gender, stationID FROM chrCharacters WHERE characterID=".$characterID.";";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		$info = array(
				'characterName' => get_character_name( $characterID ),
				'corporationName' => get_corporation_name( $row[ 'corporationID' ] ),
				'stationName' => get_station_name( $row[ 'stationID' ] ),
				'securityRating' => $row[ 'securityRating' ],
				'raceInfo' => get_race_info( $row[ 'ancestryID' ], $row[ 'careerID' ], $row[ 'schoolID' ] ),
				'careerSpecialityID' => $row[ 'careerSpecialityID' ],
				'gender' =>  $row[ 'gender' ] ? 'Male' : 'Female'
				);

		return $info;
	}

	function mysql_fetch_full_result_array( $result )
	{
		$table_result = array();
		$r = 0;

		while( $row = mysql_fetch_assoc( $result ) )
		{
			$arr_row = array();
			$c = 0;

			while ( $c < mysql_num_fields( $result ) )
			{
				$col = mysql_fetch_field( $result, $c );
				$arr_row[ $col -> name ] = $row[ $col -> name ];
				$c++;
			}

			$table_result[ $r ] = $arr_row;
			$r++;
		}

		return $table_result;
	}

	function is_admin( $characterName )
	{
		global $connections;
		include( 'config.php' );
		$query = "SELECT role FROM account WHERE accountName='".$characterName."';";
		$result = @mysql_query( $query, $connections['cruc'] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		if( $row )
		{
			if( $row[ 'role' ] == $adminRole )return true;
		}

		return false;
	}

	function get_topic_name( $topicID )
	{
		global $connections;
		include( 'config.php' );
		$query = "SELECT name FROM forum_topics WHERE id=".$topicID.";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'name' ];
	}

	function get_topic_from_reply( $replyID )
	{
		global $connections;
		include( 'config.php' );

		$query = "SELECT topicID FROM forum_replies WHERE id=".$replyID.";";
		$result = @mysql_query( $query, $connections[ 'portal' ] );

		$row = @mysql_fetch_array( $result, MYSQL_ASSOC );

		return $row[ 'topicID' ];
	}

	function get_bounties()
	{
		global $connections;
		include( 'config.php' );

		return 0;
	}

    function GetTime( $time  ) //dice up minutes   -allan
    {
	$M = $time / 604800 % 12;
	$w = $time / 86400 % 4;
   	$d = $time / 3600 % 7;
   	$h = $time / 60 % 24;
   	$m = $time % 60;

    $return = "";
    if ($M) $return .= $M."M ";
    if ($w) $return .= $w."W ";
    if ($d) $return .= $d."D ";
    if ($h) $return .= $h."H ";
    if ($m) $return .= $m."M ";
    if ($return == "") $return = " < 1M";
    return $return;
    }

    function GetTime2( $time  ) //dice up seconds   -allan
    {
	$M = $time /60 /60 /24 /7 /4 %12;
   	$w = $time /60 /60 /24 /7 %4;
   	$d = $time /60 /60 /24 %7;
   	$h = $time /60 /60 %24;
   	$m = $time / 60 % 60;
   	//$s = $time % 60;

    $return = "<BR>";
    if ($M) $return .= $M." Months ";
    if ($w) $return .= $w." Weeks ";
    if ($d) $return .= $d." Days ";
    if ($h) $return .= $h." Hours ";
    if ($m) $return .= $m." Minutes ";
    //if ($s) $return .= $s." Seconds";
    if ($return == "") $return = " < 1M";
    return $return;
    }

    function placed( $t )
    {
	$date = getdate($t);
	return $date['weekday'].",&nbsp;".$date['month']."&nbsp;".$date['mday'].",&nbsp;".$date['year'];
    }

    function updated( $t )
    {
	$date = getdate($t);
	return GetTime2(time() - $date['0']);
    }

?>
