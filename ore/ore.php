<?php

/* CREDITS/DISCLAIMER/ETC.....
original files from unknown source
misc js/php errors corrected
moved js to seperate file
reformated
allan 05/19/10
*/

	if ($f = @fopen('http://api.eve-central.com/api/evemon', 'r'))
		{
		$content = '';
		while (!feof($f)) {
			$content .= fgets($f, 4096);
			}
		}
	fclose($f);

	preg_match_all("'<mineral>(.*?)</mineral>'si", $content, $items);
	//print_r($items[1]);
	foreach($items[1] as $item)
	{
		preg_match("'<name.*?>(.*?)</name>'si", $item, $name);
		preg_match("'<price.*?>(.*?)</price>'si", $item, $price);
		$result[$name[1]] = $price[1]; // Set only if not empty
	}
	?>
<html>
	<head>
		<title>Allan's Ore Pricer for EVE-IGB</title>
		<style>
			body { background-color: #dddddd; font-family: Verdana;}
			.TblHeader {font-size:20px; font-weight:bold; text-align:center;}
			.TblHeader2 {font-size:14px; text-align:center; font-weight:bold;}
			.TblData {font-size:14px; padding:2px; text-align:right;}
		</style>
		<!--<link rel="stylesheet" href="ore.css" type="text/css">-->
		<script Language="JavaScript" src="ore.js"></script>
	</head>

	<body onLoad="javascript:UpdatePrice();">
<div class="content"><table width="90%" border=1 align="center"><tr><td style="background-color: #405050; color: yellow;" align="center">
<h1 style="margin-left: 10px;">IGB Ore Pricer</h1>
</td></tr>
<tr><td>&nbsp;</td></tr><tr><td>Minerals</td></tr><tr><td><table border=1 width="100%">
						<tr><td class="TblData" style="padding: 5px; font-size: 75%;">Tritanium:<br><input size="8" class="TxtField" id="TritaniumPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Tritanium'].'"'; ?>></td>
						<td class="TblData" style="padding: 5px; font-size: 75%;">Pyerite:<br><input size="8" class="TxtField" id="PyeritePrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Pyerite'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Mexallon:<br><input size="8" class="TxtField" id="MexallonPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Mexallon'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Isogen:<br><input size="8" class="TxtField" id="IsogenPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Isogen'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Nocxium:<br><input size="8" class="TxtField" id="NocxiumPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Nocxium'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Zydrine:<br><input size="8" class="TxtField" id="ZydrinePrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Zydrine'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Megacyte:<br><input size="8" class="TxtField" id="MegacytePrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Megacyte'].'"'; ?>></td>

							<td class="TblData" style="padding: 5px; font-size: 75%;">Morphite:<br><input size="8" class="TxtField" id="MorphitePrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Morphite'].'"'; ?>></td>
						<td><a href="?reload_prices=yes">reset&nbsp;price</a></td></tr></table>
						<?php /*
			<tr><td>&nbsp;</td></tr><tr><td>Compounds</td></tr><tr><td><table border=1 width="100%">
						<tr><td class="TblData" style="padding: 5px; font-size: 75%;">Heavy Water:<br><input size="8" class="TxtField" id="h2oPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Ozone:<br><input size="8" class="TxtField" id="o3Price" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Strotium:<br><input size="8" class="TxtField" id="srPrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Oxygen:<br><input size="8" class="TxtField" id="o2Price" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Nitrogen:<br><input size="8" class="TxtField" id="n2Price" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Helium:<br><input size="8" class="TxtField" id="hePrice" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td><td class="TblData" style="padding: 5px; font-size: 75%;">Hydrogen:<br><input size="8" class="TxtField" id="h2Price" onKeyUp="javascript:UpdatePrice();" onChange="javascript:UpdatePrice();"<?php if (isset($result)) echo ' value="'.$result['Heavy Water'].'"'; ?>></td>
						<td><a href="?reload_prices=ice">reset&nbsp;price</a></td></tr></table>
						//-->
				<tr>	<td width="100%">&nbsp;</td></tr>
				<tr>	<td width="95%" valign="top">
					<table border="1" width="100%">
						<tr>	<td class="TblHeader" colspan="8">Asteroids</td>	</tr>
						<tr>	<td class="TblHeader2">Name</td>
							<td class="TblHeader2">M3/Unit</td>
							<td class="TblHeader2">ISK/m3</td>
							<td class="TblHeader2">ISK/Unit</td>
							<td width="7%">&nbsp;</td>
							<td width="15%" class="TblHeader2">Units</td>
							<td class="TblHeader2">M3's</td>
							<td class="TblHeader2">Total ISK</td></tr>
						<tr><td class="TblData">Veldspar</td>
							<td class="TblData" >0.10</td>
							<td class="TblData" ><span id="Veldspar_m3_price">---</span></td>
							<td class="TblData" ><span id="Veldspar_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Veldspar_amt" onKeyUp="javascript:UpdateAmt('Veldspar');" onChange="javascript:UpdateAmt('Veldspar');" value="0"></td>
							<td class="TblData" ><span id="Veldspar_m3">---</span></td>
							<td class="TblData" ><span id="Veldspar_isk">---</span></td></tr>
						<tr><td class="TblData">Scordite</td>
							<td class="TblData" >0.15</td>
							<td class="TblData" ><span id="Scordite_m3_price">---</span></td>
							<td class="TblData" ><span id="Scordite_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Scordite_amt" onKeyUp="javascript:UpdateAmt('Scordite');" onChange="javascript:UpdateAmt('Scordite');" value="0"></td>
							<td class="TblData" ><span id="Scordite_m3">---</span></td>
							<td class="TblData" ><span id="Scordite_isk">---</span></td></tr>
						<tr><td class="TblData">Plagioclase</td>
							<td class="TblData" >0.35</td>
							<td class="TblData" ><span id="Plagioclase_m3_price">---</span></td>
							<td class="TblData" ><span id="Plagioclase_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Plagioclase_amt" onKeyUp="javascript:UpdateAmt('Plagioclase');" onChange="javascript:UpdateAmt('Plagioclase');" value="0"></td>
							<td class="TblData" ><span id="Plagioclase_m3">---</span></td>
							<td class="TblData" ><span id="Plagioclase_isk">---</span></td></tr>
						<tr><td class="TblData">Pyroxeres</td>
							<td class="TblData" >0.30</td>
							<td class="TblData" ><span id="Pyroxeres_m3_price">---</span></td>
							<td class="TblData" ><span id="Pyroxeres_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Pyroxeres_amt" onKeyUp="javascript:UpdateAmt('Pyroxeres');" onChange="javascript:UpdateAmt('Pyroxeres');" value="0"></td>
							<td class="TblData" ><span id="Pyroxeres_m3">---</span></td>
							<td class="TblData" ><span id="Pyroxeres_isk">---</span></td></tr>
						<tr><td class="TblData">Omber</td>
							<td class="TblData" >0.60</td>
							<td class="TblData" ><span id="Omber_m3_price">---</span></td>
							<td class="TblData" ><span id="Omber_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Omber_amt" onKeyUp="javascript:UpdateAmt('Omber');" onChange="javascript:UpdateAmt('Omber');" value="0"></td>
							<td class="TblData" ><span id="Omber_m3">---</span></td>
							<td class="TblData" ><span id="Omber_isk">---</span></td></tr>
						<tr><td class="TblData">Kernite</td>
							<td class="TblData" >1.20</td>
							<td class="TblData" ><span id="Kernite_m3_price">---</span></td>
							<td class="TblData" ><span id="Kernite_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Kernite_amt" onKeyUp="javascript:UpdateAmt('Kernite');" onChange="javascript:UpdateAmt('Kernite');" value="0"></td>
							<td class="TblData" ><span id="Kernite_m3">---</span></td>
							<td class="TblData" ><span id="Kernite_isk">---</span></td></tr>
						<tr><td class="TblData">Jaspet</td>
							<td class="TblData" >2.00</td>
							<td class="TblData" ><span id="Jaspet_m3_price">---</span></td>
							<td class="TblData" ><span id="Jaspet_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Jaspet_amt" onKeyUp="javascript:UpdateAmt('Jaspet');" onChange="javascript:UpdateAmt('Jaspet');" value="0"></td>
							<td class="TblData" ><span id="Jaspet_m3">---</span></td>
							<td class="TblData" ><span id="Jaspet_isk">---</span></td></tr>
						<tr><td class="TblData">Hemorphite</td>
							<td class="TblData" >3.00</td>
							<td class="TblData" ><span id="Hemorphite_m3_price">---</span></td>
							<td class="TblData" ><span id="Hemorphite_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Hemorphite_amt" onKeyUp="javascript:UpdateAmt('Hemorphite');" onChange="javascript:UpdateAmt('Hemorphite');" value="0"></td>
							<td class="TblData" ><span id="Hemorphite_m3">---</span></td>
							<td class="TblData" ><span id="Hemorphite_isk">---</span></td></tr>
						<tr><td class="TblData">Hedbergite</td>
							<td class="TblData" >3.00</td>
							<td class="TblData" ><span id="Hedbergite_m3_price">---</span></td>
							<td class="TblData" ><span id="Hedbergite_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Hedbergite_amt" onKeyUp="javascript:UpdateAmt('Hedbergite');" onChange="javascript:UpdateAmt('Hedbergite');" value="0"></td>
							<td class="TblData" ><span id="Hedbergite_m3">---</span></td>
							<td class="TblData" ><span id="Hedbergite_isk">---</span></td></tr>
						<tr><td class="TblData">Gneiss</td>
							<td class="TblData" >5.00</td>
							<td class="TblData" ><span id="Gneiss_m3_price">---</span></td>
							<td class="TblData" ><span id="Gneiss_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="Gneiss_amt" onKeyUp="javascript:UpdateAmt('Gneiss');" onChange="javascript:UpdateAmt('Gneiss');" value="0"></td>
							<td class="TblData" ><span id="Gneiss_m3">---</span></td>
							<td class="TblData" ><span id="Gneiss_isk">---</span></td></tr>
						<tr><td class="TblData">Dark Ochre</td>
							<td class="TblData" >8.00</td>
							<td class="TblData" ><span id="DarkOchre_m3_price">---</span></td>
							<td class="TblData" ><span id="DarkOchre_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData" ><input size="12" class="TxtField" id="DarkOchre_amt" onKeyUp="javascript:UpdateAmt('DarkOchre');" onChange="javascript:UpdateAmt('DarkOchre');" value="0"></td>
							<td class="TblData" ><span id="DarkOchre_m3">---</span></td>
							<td class="TblData" ><span id="DarkOchre_isk">---</span></td></tr>
						<tr><td class="TblData">Spodumain</td>
							<td class="TblData">16.00</td>
							<td class="TblData"><span id="Spodumain_m3_price">---</span></td>
							<td class="TblData"><span id="Spodumain_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData"><input size="12" class="TxtField" id="Spodumain_amt" onKeyUp="javascript:UpdateAmt('Spodumain');" onChange="javascript:UpdateAmt('Spodumain');" value="0"></td>
							<td class="TblData" ><span id="Spodumain_m3">---</span></td>
							<td class="TblData" ><span id="Spodumain_isk">---</span></td></tr>
						<tr><td class="TblData">Crokite</td>
							<td class="TblData">16.00</td>
							<td class="TblData"><span id="Crokite_m3_price">---</span></td>
							<td class="TblData"><span id="Crokite_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData"><input size="12" class="TxtField" id="Crokite_amt" onKeyUp="javascript:UpdateAmt('Crokite');" onChange="javascript:UpdateAmt('Crokite');" value="0"></td>
							<td class="TblData" ><span id="Crokite_m3">---</span></td>
							<td class="TblData" ><span id="Crokite_isk">---</span></td></tr>
						<tr><td class="TblData">Bistot</td>
							<td class="TblData">16.00</td>
							<td class="TblData"><span id="Bistot_m3_price">---</span></td>
							<td class="TblData"><span id="Bistot_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData"><input size="12" class="TxtField" id="Bistot_amt" onKeyUp="javascript:UpdateAmt('Bistot');" onChange="javascript:UpdateAmt('Bistot');" value="0"></td>
							<td class="TblData" ><span id="Bistot_m3">---</span></td>
							<td class="TblData" ><span id="Bistot_isk">---</span></td></tr>
						<tr><td class="TblData">Arkonor</td>
							<td class="TblData">16.00</td>
							<td class="TblData"><span id="Arkonor_m3_price">---</span></td>
							<td class="TblData"><span id="Arkonor_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData"><input size="12" class="TxtField" id="Arkonor_amt" onKeyUp="javascript:UpdateAmt('Arkonor');" onChange="javascript:UpdateAmt('Arkonor');" value="0"></td>
							<td class="TblData" ><span id="Arkonor_m3">---</span></td>
							<td class="TblData" ><span id="Arkonor_isk">---</span></td></tr>
						<tr>	<td class="TblData">Mercoxit</td>
							<td class="TblData">40.00</td>
							<td class="TblData"><span id="Mercoxit_m3_price">---</span></td>
							<td class="TblData"><span id="Mercoxit_unit_price">---</span></td>
							<td>&nbsp;</td>
							<td class="TblData"><input size="12" class="TxtField" id="Mercoxit_amt" onKeyUp="javascript:UpdateAmt('Mercoxit');" onChange="javascript:UpdateAmt('Mercoxit');" value="0"></td>
							<td class="TblData" ><span id="Mercoxit_m3">---</span></td>
							<td class="TblData" ><span id="Mercoxit_isk">---</span></td></tr>
						<tr><td colspan="6" align="right">Grand Total:</td>
						<td class ="TblData"><span id="total_m3">&nbsp;</span></td>
						<td class ="TblData"><span id="total_isk">&nbsp;</span></td></tr>

							</table>
							<P><font color="red">*NOTE* </font>&nbsp;Refreshing the page will reset amounts and totals to 0.</p><br><br>
							<!--
				<tr>	<td width="100%">&nbsp;</td></tr>
				<tr>	<td width="100%">&nbsp;</td></tr>
				<tr>	<td width="95%" valign="top">
					<table border="1" width="100%">
						<tr>	<td class="TblHeader" colspan="12">Ice</td>	</tr>
<tr align=center>
<td>Type</td>
<td>Mass</td>
<td>Refine Size</td>
<td>H2O</td>
<td>O3</td>
<td>Sr</td>
<td>O2</td>
<td>N2</td>
<td>He</td>
<td>H2</td>
<td>Sell</td>
<td>Buy</td>
</tr>
<tr valign=middle align=right>
<td align=left>Blue Ice</td>
<td>1000</td>
<td>1</td>
<td>50</td>
<td>25</td>
<td>1</td>
<td>300</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>76,000.00</td>
<td>76,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Glacial Mass</td>
<td>1000</td>
<td>1</td>
<td>50</td>
<td>25</td>
<td>1</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>300</td>
<td>76,000.00</td>
<td>76,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>White Glaze</td>
<td>1000</td>
<td>1</td>
<td>50</td>
<td>25</td>
<td>1</td>
<td>&nbsp;</td>
<td>300</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>76,000.00</td>
<td>76,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Pristine White Glaze</td>
<td>1000</td>
<td>1</td>
<td>75</td>
<td>40</td>
<td>1</td>
<td>&nbsp;</td>
<td>350</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>116,000.00</td>
<td>116,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Thick Blue Ice</td>
<td>1000</td>
<td>1</td>
<td>75</td>
<td>40</td>
<td>1</td>
<td>350</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>116,000.00</td>
<td>116,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Smooth Glacial Mass</td>
<td>1000</td>
<td>1</td>
<td>75</td>
<td>40</td>
<td>1</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>350</td>
<td>116,000.00</td>
<td>116,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Clear Icicle</td>
<td>1000</td>
<td>1</td>
<td>50</td>
<td>25</td>
<td>1</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>300</td>
<td>&nbsp;</td>
<td>376,000.00</td>
<td>376,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Krystallos</td>
<td>1000</td>
<td>1</td>
<td>100</td>
<td>250</td>
<td>100</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>450,000.00</td>
<td>450,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Enriched Clear Icicle</td>
<td>1000</td>
<td>1</td>
<td>75</td>
<td>40</td>
<td>1</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>350</td>
<td>&nbsp;</td>
<td>466,000.00</td>
<td>466,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Gelidus</td>
<td>1000</td>
<td>1</td>
<td>250</td>
<td>500</td>
<td>75</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>825,000.00</td>
<td>825,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Glare crust</td>
<td>1000</td>
<td>1</td>
<td>1000</td>
<td>500</td>
<td>25</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>1,525,000.00</td>
<td>1,525,000.00</td>
</tr>
<tr valign=middle align=right>
<td align=left>Dark glitter</td>
<td>1000</td>
<td>1</td>
<td>500</td>
<td>1000</td>
<td>50</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>1,550,000.00</td>
<td>1,550,000.00</td>
</tr>
</form>
</table>
				</td></tr></table>
				*/ ?>
<BR><BR><a href="javascript:ShowArray()">Show Array</a><BR>
</body></html>
