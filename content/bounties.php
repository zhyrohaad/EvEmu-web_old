
<?php
/************************************
 * EVE Emulator: Server Bounties Script
 * Copyright 2014
 * No license - do whatever you want with it
 * ------------------
 * bounties.php
 * Began: Sat, 7 Sept 2014
 *
 * $Id: bounties.php,v 1.00 2014/09/07 00:18:17 allan vaughn Exp $
 *
 *
 ************************************/


$database = array(
'host'=>'localhost',
'user'=>'eve',
'password'=>'onlyme',
'db'=>'EVE_Crucible'
);

// Init the DB
$db = mysql_connect($database['host'], $database['user'], $database['password']); mysql_select_db($database['db']);

?>
<tr><td colspan="5" align="center" class="content"><h1><font color=blue>Server Bounties</font></h1></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td align="center" class="content"><strong>Bounty Amount</strong></td>
    <td align="center" class="content"><strong>Name</strong>&nbsp;(Security Status)</td>
    <td align="center" class="content"><strong>Corporation</strong>&nbsp;(Ticker)</td>
    <td align="center" class="content"><strong>Date Placed</strong></td>
    <td align="center" class="content"><strong>Placed By</strong></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>

    <?php
    /* AI 	characterID 	ownerID 	bounty 	timePlaced */
    $query="SELECT
	b.characterID,
	c.name,
	co.corporationName,
	b.bounty,
	b.timePlaced,
	b.ownerID,
	c2.name,
	c.securityRating,
	co.tickerName
      FROM webBounties AS b
      LEFT JOIN chrCharacters AS c USING (characterID)
      LEFT JOIN chrCharacters AS c2 ON b.ownerID = c2.characterID
      LEFT JOIN corporation AS co USING (corporationID)
      ORDER BY b.bounty DESC;";
    if($result=mysql_query($query,$db)) {
        while($row=mysql_fetch_array($result)) {
	    printf('<tr><td align="center" class="content">%s&nbsp;ISK</td>',number_format($row[3],2));
	    printf('    <td align="center" class="content"><a href="?p=characterinfo&c=%u">%s</a> (%.3f)</td>',$row[0],$row[1],$row[7]);
	    printf('    <td align="center" class="content">&nbsp;%s&nbsp;(%s)</td>',$row[2],$row[8]);
	    printf('    <td align="center" class="content">%s&nbsp;</td>',placed($row[4]));
	    printf('    <td align="center" class="content"><a href="?p=characterinfo&c=%u">%s</td>',$row[5],$row[6]);
	}
    } else {
	die("Player SQL error");
    }

mysql_free_result($result);
?>
</table><BR><BR>

