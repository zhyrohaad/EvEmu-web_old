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
?>
<div id="menu" >
	<ul>
		<li><a href="?p=" title="Home">Home</a></li>
        <li><a href="/phpBB3/" title="Forums">Forums</a></li>
		<li><a href="/gallery/" title="ScreenShots">ScreenShots</a></li>
		<li><a href="?p=status" title="Status">Server Status'</a></li>
        <li><a href="?p=userlist" title="Player List">Server Characters</a></li>
        <li><a href="?p=bounties" title="Player Bounties">Server Bounties</a></li>
        <li><a href="?p=sysstatus" title="System Status">Solar System Status'</a></li>
		<!--<li><a href="?p=summary" title="System Summary">System Summary</a></li>-->
		<li><a href="?p=op_status" title="Operational Status">Current Code Status</a></li>
	</ul>
</div>
<!--
<div id="dmenu">
	<ul>
		<li><a href="javascript:switchMenu();" title="Statistics">Statistics</a></li>
		<li><a href="javascript:switchMenu();" title="Account Management">Account Management</a></li>
	</ul>
</div>
-->
<div id="haccount" style="display: none;" >
	<ul>
		<?php if( !isset( $_SESSION[ 'portalUser' ] ) )
		{
		?>
			<li><a href="?p=login" title="Login">Login</a></li>
			<li><a href="?p=register" title="Registration">Register</a></li>
		<?php
		}else{
		?>
			<li><a href="?p=logout" title="Logout">Logout</a></li>
			<li><a href="?p=itemlist" title="Item list">Item list</a></li>
			<li><a href="?p=characterinfo" title="Character Info">Character Info</a></li>
		<?php
		}

		if( ( isset( $_SESSION[ 'portalRole' ] ) ) && ( $_SESSION[ 'portalRole' ]  == $adminRole ) )
		{
		?>
			<li><a href="?p=admin" title="Adminisrtation">Administration</a></li>
			<li><a href="blog" title="News management">News management</a></li>
		<?php
		}
		?>
	</ul>
</div><BR><BR><BR>
<?php include('content/basics.php'); ?>
