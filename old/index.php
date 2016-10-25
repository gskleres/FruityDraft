<?php

/*
$starting_allowed_civs = array("America", "Arabia", "Assyria", "Austria", "Aztec", "Babylon", "Brazil", "Byzantium", "Carthage", "Celts", "China", "Denmark", "Egypt", "England", "Ethiopia", "France", "Germany", "Greece", "Huns", "Inca", "India", "Indonesia", "Iroquois", "Japan", "Korea", "Maya", "Mongolia", "Morocco", "Netherlands", "Ottomans", "Persia", "Poland", "Polynesia", "Portugal", "Rome", "Russia", "Shoshone", "Siam", "Songhai", "Spain", "Sweden", "Zulu");

$civs = array("America", "Arabia", "Assyria", "Austria", "Aztec", "Babylon", "Brazil", "Byzantium", "Carthage", "Celts", "China", "Denmark", "Egypt", "England", "Ethiopia", "France", "Germany", "Greece", "Huns", "Inca", "India", "Indonesia", "Iroquois", "Japan", "Korea", "Maya", "Mongolia", "Morocco", "Netherlands", "Ottomans", "Persia", "Poland", "Polynesia", "Portugal", "Rome", "Russia", "Shoshone", "Siam", "Songhai", "Spain", "Sweden", "Venice", "Zulu");

$bonkers_rules = array(
	"<i>Curse of Mediocrity</i>: You may not build World Wonders or National Wonders.",
	"<i>Policy of Sloth</i>: You may not assign/lock citizens or change governor focus from Default.",
	"<i>Union Labor Strike</i>: You may not build or purchase Settlers or Workers in your cities.",
	"<i>Shiny Chaser</i>: You may never unlock more than 2 Social Policies in each tree.",
	"<i>Blue Collar</i>: You must delete all Great People immediately upon getting them and you can't assign Specialists.",
	"<i>Uncreative</i>: You must click 'Future Tech' at the beginning of the game and cannot choose/alter the tech path.",
	"<i>Poor Depth Perception</i>: You may not build or purchase any unit with a ranged attack.",
	"<i>Anger Management Issues</i>: You must declare war immediately when meeting a new player or City State and may never declare peace.",
	"<i>Isolationist Extremism</i>: You must settle your capital inland and you may not build roads or railroads.",
	"<i>Schmoozer Loser</i>: You may not assign Spies and you must abstain from every World Congress vote.",
	"<i>Special Snowflake</i>: You may only have one of each building in your entire empire (sell duplicates if you earn them through conquest/social policies/etc).",
	"<i>Uncivilization</i>: You may not attack Barbarians (not even in your borders).",
	"<i>Hoarder</i>: You may not spend or trade away your gold (no purchasing units/buildings/tiles/city state favor/upgrading/etc).",
	"<i>Singularity</i>: After researching Guilds or Education, you must set all but one of your cities to produce Wealth or Research."
);
*/

?>

<script>

var civs = ["America", "Arabia", "Assyria", "Austria", "Aztec", "Babylon", "Brazil", "Byzantium", "Carthage", "Celts", "China", "Denmark", "Egypt", "England", "Ethiopia", "France", "Germany", "Greece", "Huns", "Inca", "India", "Indonesia", "Iroquois", "Japan", "Korea", "Maya", "Mongolia", "Morocco", "Netherlands", "Ottomans", "Persia", "Poland", "Polynesia", "Portugal", "Rome", "Russia", "Shoshone", "Siam", "Songhai", "Spain", "Sweden", "Venice", "Zulu"];

function updateStrikeout(civName)
{
	var chkbox = "checkbox_" + civName;
	var textSpan = "span_checkbox_" + civName;
	var tableCell = "table_cell_" + civName;
	
	var shouldStrikeOut = !document.getElementById(chkbox).checked;
	
	if (shouldStrikeOut)
	{
		document.getElementById(tableCell).style.backgroundColor='#999999';
		document.getElementById(textSpan).style.textDecoration='line-through';
	}
	else
	{
		document.getElementById(tableCell).style.backgroundColor='#FFFFFF';
		document.getElementById(textSpan).style.textDecoration='none';
	}
}

function setStrikeout(civName, isStruckOut)
{
	document.getElementById("checkbox_" + civName).checked = !isStruckOut;
	updateStrikeout(civName);
}

function toggleStrikeout(civName)
{
	document.getElementById("checkbox_" + civName).checked = !document.getElementById("checkbox_" + civName).checked;
	updateStrikeout(civName);
}

function mouseOver(civName)
{
	var tableCell = "table_cell_" + civName;
	document.getElementById(tableCell).style.backgroundColor='#CCCCCC';
}

function mouseOut(civName)
{
	var chkbox = "checkbox_" + civName;
	var tableCell = "table_cell_" + civName;
	if (document.getElementById(chkbox).checked)
	{
		document.getElementById(tableCell).style.backgroundColor = (civName == 'allowDuplicateCivs') ? '#DDDDDD' : '#FFFFFF';
	}
	else
	{
		document.getElementById(tableCell).style.backgroundColor = (civName == 'allowDuplicateCivs') ? '#DDDDDD' : '#999999';
	}

}
</script>

<!-- document.getElementById('log').innerHTML += '<br>Some new content!'; -->

<style type="text/css">

.noIbar {
cursor:default;
}

</style>

<center>
<font face='Arial'>
<h1><span class='noIbar'>Fruitstrike's Fabulous Civ 5 Drafter</span></h1>

<!--

<?php

$selected_allowed_civs = $starting_allowed_civs;
$selected_num_players = 6;
$selected_num_civs_to_assign = 3;
$selected_allow_duplicate_civs = false;
$selected_allow_bonkers = false;

if (!empty($_POST))
{
	$selected_allowed_civs = $_POST["allowed_civs"];
	$selected_num_players = $_POST["num_players"];
	$selected_num_civs_to_assign = $_POST["num_civs_to_assign"];
	$selected_allow_duplicate_civs = $_POST["allow_duplicate_civs"];
	$selected_allow_bonkers = $_POST["allow_bonkers"];
	
	$num_pooled_civs = count($selected_allowed_civs);
	$num_requested_civs = $selected_num_players * $selected_num_civs_to_assign;
	if ($num_requested_civs > $num_pooled_civs && !$selected_allow_duplicate_civs)
	{
		echo "<span class='noIbar'><font color='red'><b>SORRY!</b> I can't assign $num_requested_civs Civs with only $num_pooled_civs unbanned Civs in the pool. Better try again with different settings! :)</font></span><br><br>";
	}
	elseif ($selected_allow_duplicate_civs && $num_pooled_civs < $selected_num_civs_to_assign)
	{
		echo "<span class='noIbar'><font color='red'><b>SORRY!</b> I can't assign $selected_num_civs_to_assign Civs to each player, even with duplicate civs allowed, with only $num_pooled_civs unbanned Civs in the pool. Better try again with different settings! :)</font></span><br><br>";
	}
	else
	{
		$pooled_civs = array();
		$check_civs = $civs;
		foreach ($check_civs as $check_civ)
		{
			if (in_array($check_civ, $selected_allowed_civs))
			{
				array_push($pooled_civs, $check_civ);
			}
		}
		shuffle($pooled_civs);
		shuffle($bonkers_rules);
		echo "<span class='noIbar'><table frame='box' cellspacing='5' bgcolor='#BBFFBB'>";
		for ($i = 1; $i <= $selected_num_players; $i++)
		{
			if ($selected_allow_duplicate_civs)
			{
				shuffle($pooled_civs);
			}
			echo "<tr><td>";
			$assigned_civs = array();
			for ($j = 0; $j < $selected_num_civs_to_assign; $j++)
			{
				if ($selected_allow_duplicate_civs)
				{
					array_push($assigned_civs, $pooled_civs[$j]);
				}
				else
				{
					array_push($assigned_civs, array_pop($pooled_civs));
				}
			}
			echo "<b><i>PLAYER $i: </i></b>";
			if (count($assigned_civs) > 1)
			{
				echo "Choose from ";
			}
			echo "<b>";
			$first = true;
			foreach ($assigned_civs as $assigned_civ)
			{
				if (!$first)
				{
					echo " / ";
				}
				echo "<img src='img/$assigned_civ.png' width='16' height='16' /> $assigned_civ";
				$first = false;
			}
			echo "</b></td></tr>";
			if ($selected_allow_bonkers)
			{
				echo "<tr><td><i><b><span style='padding-left: 4em'>-----> </span>Player $i Bonkers Rule - </i></b>";
				echo $bonkers_rules[$i - 1];
				echo "</td></tr>";
			}
		}
		echo "</table></span><br>";
	}
}

?>
<form action="" method="post" />
<span class='noIbar'>Select Number of Players:</span><select name="num_players">
<?php
for ($p = 1; $p <= 12; $p++)
{
	echo "<option value='$p'";
	if ($p == $selected_num_players)
	{
		echo " selected='selected'";
	}
	echo ">$p Player";
	if ($p > 1)
	{
		echo "s";
	}
	echo "</option>";
}
?>
</select>
<br>
<span class='noIbar'>Select Number of Civs to Assign to Each Player:</span> <select name="num_civs_to_assign">
<?php
for ($p = 1; $p <= 10; $p++)
{
	echo "<option value='$p'";
	if ($p == $selected_num_civs_to_assign)
	{
		echo " selected='selected'";
	}
	echo ">$p Random Civ";
	if ($p != 1)
	{
		echo "s";
	}
	echo "</option>";
}
?>
</select>

<br /><br />
Quick Ban Filters:
<?php

echo "<input type='button' id='button_ban_venice_only' value='Venice Only' onclick=\"";
foreach ($civs as $checkCiv)
{
	echo "setStrikeout('$checkCiv', ";
	echo (($checkCiv == 'Venice') ? "true" : "false");
	echo ");";
}
echo "\">";

echo "<input type='button' id='button_ban_venice_only' value='None' onclick=\"";
foreach ($civs as $checkCiv)
{
	echo "setStrikeout('$checkCiv', false);";
}
echo "\">";

echo "<input type='button' id='button_ban_venice_only' value='All' onclick=\"";
foreach ($civs as $checkCiv)
{
	echo "setStrikeout('$checkCiv', true);";
}
echo "\">";

echo "<input type='button' id='button_ban_venice_only' value='Inverse' onclick=\"";
foreach ($civs as $checkCiv)
{
	echo "toggleStrikeout('$checkCiv');";
}
echo "\">";

?>
<table frame="box" bgColor='#FFFFFF' cellspacing='5'>
<tr>
	<td colspan="5" align='center' bgColor='#FFFFFF'><b><span class='noIbar'>ALLOWED/BANNED CIVILIZATIONS</span></b></td>
</tr>

<?php

$civ_count = 0;
foreach ($civs as $civ)
{
	if ($civ_count % 5 == 0)
	{
		echo "<tr>";
	}
	echo "<td valign='middle' bgColor='#FFFFFF' id='table_cell_$civ' onmouseover=mouseOver('$civ') onmouseout=mouseOut('$civ')><input id='checkbox_$civ' type='checkbox' name='allowed_civs[]' style='display:none' value='$civ' onclick=updateStrikeout('$civ')";
	if (in_array($civ, $selected_allowed_civs))
	{
		echo " checked='true'";
	}
	echo "><label for='checkbox_$civ'><img src='img/$civ.png' width='16' height='16' /></label> <span id='span_checkbox_$civ'><label for='checkbox_$civ'>$civ</label></span></td>";
	if ($civ_count % 5 == 4)
	{
		echo "</tr>";
	}
	
	$civ_count++;
}

$leftover_cols = 5 - ($civ_count % 5);

if ($leftover_cols < 2)
{
	echo "<td colspan='$leftover_cols' bgcolor='#FFFFFF'></td></tr>";
	echo "<tr><td colspan='3' bgcolor='#FFFFFF'></td>";
}
elseif ($leftover_cols > 2)
{
	$extraCols = $leftover_cols - 2;
	echo "<td colspan='$extraCols' bgcolor='#FFFFFF'></td>";
}

echo "<td align='right' colspan='2'><table frame='box'><tr><td bgColor='#DDDDDD' id='table_cell_allowDuplicateCivs' onmouseover=mouseOver('allowDuplicateCivs') onmouseout=mouseOut('allowDuplicateCivs')><input id='checkbox_allowDuplicateCivs' type='checkbox' name='allow_duplicate_civs' value='allowDuplicateCivs'";

if ($selected_allow_duplicate_civs)
{
	echo " checked='true'";
}

echo "><span id='span_checkbox_allowDuplicateCivs'><label for='checkbox_allowDuplicateCivs'>Allow Duplicate Civs</label></span></td></tr></table></td></tr>";

?>

</table>
<br>
<input type="submit" value="Create Game" />
<br><br>
<input id='checkbox_bonkers' type='checkbox' name='allow_bonkers' value='allowBonkers' <?php if ($selected_allow_bonkers) echo " checked='true'"; ?> /><span id='span_checkbox_allowBonkers'><label for='checkbox_bonkers'>Enable "Bonkers" Edition</label></span>
</form>
</font>
</center>
<script>
<?php
	foreach ($civs as $banned_civ)
	{
		if (!in_array($banned_civ, $selected_allowed_civs))
		{
			echo "setStrikeout('$banned_civ', true);";
		}
	}
?>
</script>
-->