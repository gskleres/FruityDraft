<style type="text/css">
.noIbar {
cursor:default;
}
</style>

<html>
<head>
</head>
<body>
	<span class='noIbar'><center><font face='Arial'>

	<!-- title -->
	<h1><span class='noIbar'>Fruitstrike's Fabulous Civ 6 Drafter</span></h1>
	
	<br />
	
	<!-- create game click results -->
	<div id='createResults'></div>
	
	<br /><br />
	
	<!-- options -->
	<table>
		<tr>
			<td>Select Number of Players: </td><td><select id='numPlayers' name='numPlayers'></select></td>
		</tr>
		<tr>
			<td>Select # of Civs to Assign: </td><td><select id='numCivsToAssign' name='numCivsToAssign'></select></td>
		</tr>
	</table>
	
	<br /><br />
	
	<!-- ban civilizations box -->
	<table id='bannedCivs' frame='box' bgColor='#FFFFFF' cellspacing='5'>
		<tr><td id='bannedCivsTitle' colspan='3'><center>ALLOWED / BANNED LEADERS</center></td></tr>
	</table>
	
	<br /><br />

	<!-- create game button -->
	<input type="button" value="Create Game" onclick="createGame()" />
	
	</font></center></span>
</body>
</html>

<script>

// ------ DATA -------
var civs = ["AmericaTheodoreRoosevelt", "ArabiaSaladin", "AztecMontezuma", "BrazilPedroII", "ChinaQinShiHuang", "EgyptCleopatra", "EnglandVictoria", "FranceCatherinedeMedici", "GermanyFrederickBarbarossa", "GreecePericles", "GreeceGorgo", "IndiaGandhi", "JapanHojoTokimune", "KongoMvembaANzinga", "NorwayHaraldHardrada", "RomeTrajan", "RussiaPeterTheGreat", "ScythiaTomyris", "SpainPhilipII", "SumeriaGilgamesh"];

var civLongNames = ["America - Theodore Roosevelt", "Arabia - Saladin", "Aztec - Montezuma", "Brazil - Pedro II", "China - Qin Shi Huang", "Egypt - Cleopatra", "England - Victoria", "France - Catherine de Medici", "Germany - Frederick Barbarossa", "Greece - Pericles", "Greece - Gorgo", "India - Gandhi", "Japan - Hojo Tokimune", "Kongo - Mvemba a Nzinga", "Norway - Harald Hardrada", "Rome - Trajan", "Russia - Peter the Great", "Scythia - Tomyris", "Spain - Philip II", "Sumeria - Gilgamesh"];

// ------ MAIN FUNCTIONS ------
function createGame()
{
	// how many civs are requested?
	var requestedNumPlayers = document.getElementById("numPlayers").options[document.getElementById("numPlayers").selectedIndex].value;
	var requestedNumCivsToAssign = document.getElementById("numCivsToAssign").options[document.getElementById("numCivsToAssign").selectedIndex].value;
	var requestedTotalNumCivs = requestedNumPlayers * requestedNumCivsToAssign;

	// how many civs are not banned?
	var allowedCivs = [];
	//allowedCivs.push("new element");
	for (var i = 0; i < civs.length; i++)
	{
		var civCheckbox = document.getElementById("checkbox_" + civs[i]);
		if (civCheckbox.checked)
		{
			allowedCivs.push(civLongNames[i]);
		}
	}
	
	var result = "";

	if (requestedTotalNumCivs > allowedCivs.length)
	{
		// not enough civs available
		result += "<table frame='box' cellspacing='5' bgcolor='#FFBBBB'><tr><td><font color='#CC0000'><i><b>Too many civs requested, please adjust options and try again.</b></i></font></td></tr></table>"
	}
	else
	{
		// randomize the civs and pop off the top
		shuffle(allowedCivs);
		
		result += "<table frame='box' cellspacing='5' bgcolor='#BBFFBB'>";
		for (var iPlayerIndex = 0; iPlayerIndex < requestedNumPlayers; iPlayerIndex++)
		{
			result += "<tr><td><b>Player " + iPlayerIndex + ":</b> Choose from <b>";
			for (var iOptionIndex = 0; iOptionIndex < requestedNumCivsToAssign; iOptionIndex++)
			{
				var civName = allowedCivs[(iPlayerIndex * requestedNumCivsToAssign) + iOptionIndex];
				if (iOptionIndex > 0)
				{
					result += ", ";
				}
				result += "<img src='img/" + civName + ".png' width='16' height='16' /> " + civName;
			}
			result += "</td></tr>";
		}
		result += "</b></table>";
	}
	
	document.getElementById('createResults').innerHTML = result;
}

function shuffle (array) {
  var i = 0
    , j = 0
    , temp = null

  for (i = array.length - 1; i > 0; i -= 1) {
    j = Math.floor(Math.random() * (i + 1))
    temp = array[i]
    array[i] = array[j]
    array[j] = temp
  }
}

function civMouseOver(civName)
{
	var tableCell = "table_cell_" + civName;
	document.getElementById(tableCell).style.backgroundColor='#CCCCCC';
}

function civMouseOut(civName)
{
	var chkbox = "checkbox_" + civName;
	var tableCell = "table_cell_" + civName;
	if (document.getElementById(chkbox).checked)
	{
		document.getElementById(tableCell).style.backgroundColor = '#FFFFFF';
	}
	else
	{
		document.getElementById(tableCell).style.backgroundColor = '#999999';
	}

}

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


// ------------ INIT ---------------

// Number of Players option
var selectNumPlayers = document.getElementById('numPlayers');
for(var i = 1; i <= 12; i++) {
    var opt = document.createElement('option');
    opt.innerHTML = i + " Player";
	if (i > 1)
	{
		opt.innerHTML += "s";
	}
    opt.value = i;
	if (i == 6)
	{
		opt.selected = true;
	}
    selectNumPlayers.appendChild(opt);
}

// Number of Civs To Assign option
var selectNumCivsToAssign = document.getElementById('numCivsToAssign');
for(var i = 1; i <= 10; i++) {
    var opt = document.createElement('option');
    opt.innerHTML = i + " Random Civ";
	if (i > 1)
	{
		opt.innerHTML += "s";
	}
    opt.value = i;
	if (i == 3)
	{
		opt.selected = true;
	}
    selectNumCivsToAssign.appendChild(opt);
}

// Banned Civs
var numCols = 3;
var numRows = Math.ceil(civs.length / numCols);
var tableBannedCivs = document.getElementById('bannedCivs');
for (i = 0; i < numRows; i++) {
    var tr = document.createElement('TR');
	tr.innerHTML = "";
    for (j = 0; j < numCols; j++) {
		var civID = i + (numRows * j);
		if (civID < civs.length)
		{
			tr.innerHTML += "<td valign='middle' bgColor='#FFFFFF' id='table_cell_" + civs[civID] + "' onmouseover=civMouseOver('" + civs[civID] + "') onmouseout=civMouseOut('" + civs[civID] + "') >" +
							"<input id='checkbox_" + civs[civID] + "' type='checkbox' style='display:none' value='" + civs[civID] + "' onclick=updateStrikeout('" + civs[civID] + "') checked='true'>" +
							"<label for='checkbox_" + civs[civID] + "'><img src='img/" + civLongNames[civID] + ".png' width='16' height='16' /></label>" +
							" <span id='span_checkbox_" + civs[civID] + "'><label for='checkbox_" + civs[civID] + "'>" + civLongNames[civID] + "</label></span></td>";
		}
		else
		{
			tr.innerHTML += "<td />";
		}
    }
    tableBannedCivs.appendChild(tr);
}

</script>