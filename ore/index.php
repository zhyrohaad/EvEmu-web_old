<?php
/* index */

require_once ("./php/init.php");

$MySelf =$EVE_Charname;

	// Clean & Print the page.
	$html = new html;
	$html->addBody($page);
	print ($html->flush());
?>
