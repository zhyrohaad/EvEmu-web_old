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

	/*************************************************
	 * EveMu Portal Configuration file				 *
	 * Edit these values according to your own	 	 *
	 *************************************************/

	/* MySQL connection settings */
	$sql_crucible_test_user = "eve"; // MYSQL User for crucible test DB
	$sql_crucible_test_pass = "onlyme"; // MySQL Password for crucible test DB
	$sql_crucible_test_host = "localhost"; // MySQL Host for crucible test DB
	$sql_crucible_test_db = "EVE_Official"; // Server crucible test database name

	/* MySQL connection settings */
	$sql_crucible_user = "eve"; // MYSQL User for crucible DB
	$sql_crucible_pass = "onlyme"; // MySQL Password for crucible DB
	$sql_crucible_host = "localhost"; // MySQL Host for crucible DB
	$sql_crucible_db = "EVE_Dev"; // Server crucible database name

	/* MySQL connection settings */
	$sql_apocrypha_user = "eve"; // MYSQL User for apocrypha DB
	$sql_apocrypha_pass = "onlyme"; // MySQL Password for apocrypha DB
	$sql_apocrypha_host = "localhost"; // MySQL Host for apocrypha DB
	$sql_apocrypha_db = "EVE_Apocrypha"; // Server apocrypha database name

	/* MySQL connection settings */
	$sql_incursion_user = "eve"; // MYSQL User for apocrypha DB
	$sql_incursion_pass = "onlyme"; // MySQL Password for apocrypha DB
	$sql_incursion_host = "localhost"; // MySQL Host for apocrypha DB
	$sql_incursion_db = "EVE_Incursion"; // Server apocrypha database name

	/* Portal DB */
	$sql_portal_user = "eve"; // MySQL User for portal DB
	$sql_portal_pass = "onlyme"; // MySQL Password for portal DB
	$sql_portal_host = "localhost"; // MySQL Host for portal DB
	$sql_portal_db = "EVE_Portal"; // Portal database name

	/* Server config */
	$cruc_server = "eve.alasiya.net"; // EVEmu Cruc Server
	$cruc_port = 26000; // EVEmu Cruc Server Port
	$test_server = "eve.alasiya.net"; // EVEmu Cruc Test Server
	$test_port = 26010; // EVEmu Cruc Server Test Port
        $apoc_server = "eve.alasiya.net"; // EVEmu Apoc Server
        $apoc_port = 26005; // EVEmu Apoc Server Port
        $inc_server = "eve.alasiya.net"; // EVEmu Inc Server
        $inc_port = 26007; // EVEmu Inc Server Port

	/* Portal config */
	$portal_on = true; // Is the portal open ?

	/* Role */
	$adminRole = 7079658624976683008; // Admin role
	$registerRole = 2; //Default registration role for register script

	/* Server version */
	$server_version = "Crucible";

?>
