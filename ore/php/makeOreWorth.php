<?php


/*
 * MiningBuddy (http://miningbuddy.net)
 * $Header: /usr/home/mining/cvs/mining/functions/html/makeOreWorth.php,v 1.19 2008/01/02 20:01:32 mining Exp $
 *
 * Copyright (c) 2005-2008 Christian Reiss.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms,
 * with or without modification, are permitted provided
 * that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 *  "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 *  LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 *  FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 *  OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *  SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
 *  TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA,
 *  OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 *  OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

// Prints the change form to edit the ore values.
function makeOreWorth() {
	// Get the globals.
	global $TIMEMARK;
	global $ORENAMES;
	global $DBORE;
	global $DB;

	// load the values.
	$orevaluesDS = $DB->query("select * from orevalues order by id DESC limit 1");
	$orevalues = $orevaluesDS->fetchRow();

	// Create the table.
	$table = new table(8, true);
	$table->addHeader(">> Manage ore values", array (
		"bold" => true,
		"colspan" => 8
	));

	$table->addRow();
	$table->addCol("Ore Name", array (
		"colspan" => 2,
		"bold" => true
	));
	$table->addCol("Enabled", array (
		"bold" => true
	));
	$table->addCol("Value", array (
		"bold" => true
	));
	$table->addCol("Ore Name", array (
		"colspan" => 2,
		"bold" => true
	));
	$table->addCol("Enabled", array (
		"bold" => true
	));
	$table->addCol("Value", array (
		"bold" => true
	));

	// How many ores are there in total? Ie, how long has the table to be?
	$tableLength = ceil(count($ORENAMES) / 2)-1;

	for ($i = 0; $i <= $tableLength; $i++) {

		$table->addRow();
		$ORE = $ORENAMES[$i];

		// Fetch the right image for the ore.
		$ri_words = str_word_count($ORE, 1);
		$ri_max = count($ri_words);
		$ri = strtolower($ri_words[$ri_max -1]);

		// Ore columns for LEFT side.
		$table->addCol("<img width=\"32\" height=\"32\" src=\"./images/ores/" . $ri . ".png\">");
		$table->addCol($ORE);
		if (getOreSettings($DBORE[$ORE])) {
			$table->addCol("<input name=\"" . $DBORE[$ORE] . "Enabled\" value=\"true\" type=\"checkbox\" checked=\"checked\">");
		} else {
			$table->addCol("<input name=\"" . $DBORE[$ORE] . "Enabled\" value=\"true\" type=\"checkbox\">");
		}
		$table->addCol("<input type=\"text\" name=\"$DBORE[$ORE]\"" . "size=\"6\" maxlength=\"6\" value=\"" . $orevalues[$DBORE[$ORE] . Worth] . "\">");

		// Ore columns for RIGHT side.
		$ORE = $ORENAMES[$i + $tableLength +1];
		
		// Fetch the right image for the ore.
		$ri_words = str_word_count($ORE, 1);
		$ri_max = count($ri_words);
		$ri = strtolower($ri_words[$ri_max -1]);
		
		if ($ORE != "") {
			$table->addCol("<img width=\"32\" height=\"32\" src=\"./images/ores/" . $ri . ".png\">");
			$table->addCol($ORE);
			if (getOreSettings($DBORE[$ORE])) {
				$table->addCol("<input name=\"" . $DBORE[$ORE] . "Enabled\" value=\"true\" type=\"checkbox\" checked=\"checked\">");
			} else {
				$table->addCol("<input name=\"" . $DBORE[$ORE] . "Enabled\" value=\"true\" type=\"checkbox\">");
			}
			$table->addCol("<input type=\"text\" name=\"$DBORE[$ORE]\"" . "size=\"6\" maxlength=\"6\" value=\"" . $orevalues[$DBORE[$ORE] . Worth] . "\">");
		} else {
			$table->addCol("");
			$table->addCol("");
			$table->addCol("");
			$table->addCol("");
		}

	}

	$form .= "<input type=\"hidden\" name=\"action\" value=\"changeore\">";
	$form .= "<input type=\"hidden\" name=\"check\" value=\"check\">";
	$form .= "<input type=\"submit\" name=\"change\" value=\"Modify ore settings\">";
	$table->addHeaderCentered($form, array (
		"colspan" => 8,
		"align" => "center"
	));

	// return the page
	return ("<h2>Modify ore settings</h2><form action=\"index.php\"method=\"post\">" . $table->flush());
}
?>