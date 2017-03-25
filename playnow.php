<?php
session_start();
// Playnow  v. 1.01
require 'autologin.inc.php';
require('logincheck.inc.php');

require 'top.php';
/* In the HTML we'll use a drop down with server options. They're based in the users settings;
   If he has only the developers version or only the stable version of the game, then they'll be the only
   ones to appear. If he has both versions, a drop down will appear with both. 
*/

// Get profile info, like avatar, country etc... Don't mix up the different results that are dumped in $player, which is info from the playerstable, with $playercached, which is info from the cached table and only about results etc.

$mysqlname = $_SESSION['username'];
$result = mysql_query("SELECT * FROM $playerstable WHERE name = '$mysqlname' LIMIT 1");
$bajs= mysql_fetch_array($result);

// echo "<br>".var_dump($bajs)."<br>";

if (($bajs['HaveVersion'] == "Both") || ($bajs['HaveVersion'] == "")) {$dropdown = "<option selected>Ladder Discord</option><option>XBOX Europe</option><option>XBOX NA East</option><option>XBOX NA West</option><option>PS4 Europe</option><option>PS4 NA East</option><option>PS4 NA West</option>";}

if ($bajs['HaveVersion'] == "XBOX") {$dropdown = "<option selected>Ladder Discord</option><option>XBOX Europe</option><option>XBOX NA East</option><option>XBOX NA West</option>";}

if ($bajs['HaveVersion'] == "PS4") {$dropdown = "<option selected>Ladder Discord</option><option>PS4 Europe</option><option>PS4 NA East</option><option>PS4 NA West</option>";}




// get the rating of the player...
$sql = "SELECT name, rating FROM $standingscachetable WHERE name = '".$_SESSION['username']."'";
$resultrating= mysql_query($sql, $db);
$rowrating = mysql_fetch_array($resultrating);

$Rating = $rowrating['rating'];


// See if the player uses any Instant Messangers...

if ((($bajs[Jabber] == "") || ($bajs[Jabber] == NULL) || ($bajs[Jabber] == "n/a")) && (($bajs[msn] == "") || ($bajs[msn] == NULL) || ($bajs[msn] == "n/a")) && (($bajs[aim] == "") || ($bajs[aim] == NULL) || ($bajs[aim] == "n/a")) && (($bajs[icq] == "") || ($bajs[icq] == NULL) || ($bajs[icq] == "n/a")) ) { $HaveNoIM = TRUE; }


// Check if the player has checked "dont contact me"...
if ($bajs[MsgMe] != "Yes") {$dontmsg = TRUE;}


// This happens when the page loads and the submit button has been pushed..
if ($_POST['wait']) {


// Check if the player selected the IM option in the dropdwon menu AND if he at the same time lacks an IM
If (($_POST[server] == "Instant Message" ) && ($HaveNoIM == TRUE)) {

	echo "<h1>Whoops...</h1><br>You selected the \"Instant Message\" option as the way to find you. <br>There is no Instant Messenger info in your profile.<br><br>Please <a href=\"edit.php?name=$bajs[name]\">edit your profile</a> and give us the information if you want to be contacted via IM.";
	require('bottom.php');
	exit;
}

// Check if the player selected the IM option in the dropdwon menu AND if he at the same has stated that he doesnt want to be contacted...
If (($_POST[server] == "Instant Message" ) && ($dontmsg == TRUE)) {

	echo "<h1>Whoops...</h1><br>You selected the \"Instant Message\" option as the way to find you. <br>In your profile you tell people not to contact you.<br><br>Please <a href=\"edit.php?name=$bajs[name]\">edit your profile</a> and allow people to contact you if you want to be contacted via IM.";
	require('bottom.php');
	exit;
}






// Set what meeting info that should go into the database later on...
if ($_POST["server"] == "Ladder Discord") {$MeetingPlace = "Discord"; }
if ($_POST["server"] == "XBOX Europe") {$MeetingPlace = "XB Europe"; }
if ($_POST["server"] == "XBOX NA East") {$MeetingPlace = "XB NA East"; }
if ($_POST["server"] == "XBOX NA West") {$MeetingPlace = "XB NA West"; }
if ($_POST["server"] == "PS4 Europe") {$MeetingPlace = "PS Europe"; }
if ($_POST["server"] == "PS4 NA East") {$MeetingPlace = "PS NA East"; }
if ($_POST["server"] == "PS4 NA West") {$MeetingPlace = "PS NA West"; }



// Set the time when the player entered himself in the waiting for a game-list...
$lastactive = time();
	
	
// Check if visitor is already in the table

$sql = "SELECT id FROM $waitingtable WHERE username = '".$_SESSION['username']."'";
$intable = mysql_query($sql);


// if in table the update the user... else add him...

	if (mysql_num_rows($intable)==0) {
	
			$sql = "INSERT INTO $waitingtable (username, time, entered, meetingplace, rating) VALUES ('".$_SESSION['username']."', '$_POST[hours]', '$lastactive', '$MeetingPlace', '$Rating')";
		$result = mysql_query($sql);

			// if successfully inserted data into database....
			if($result){
			echo "<h1>added new entry</h1><br /><a href='index.php'>back to index >></a>";
			require('bottom.php');
			exit;

			
			} else {
				echo "mysql error: cant add new enrty - contact admin if error remains for more than 1 day.";
			}


		} else {
// DEB echo "starting to updated entry...<br>";
		// "UPDATE online SET lastactive = $lastactive WHERE ipaddress = '$ipaddress'");

	$sql = "UPDATE $waitingtable SET time =  '$_POST[hours]', entered = '$lastactive', meetingplace = '$MeetingPlace', rating = '$Rating' WHERE username = '".$_SESSION['username']."'";
		$result = mysql_query($sql);
			
			if($result){
			echo "<h1>Updated entry</h1><br><a href='index.php'>back to index >></a>";
			require('bottom.php');
			exit;

			
			} else {
				echo "mysql error: cant update... contact admin if the error remains more than 1 day.";
			}
			
	}
}
?>

<?php 

// If the user is logged in and wants to delete himself from the list...

if ($_GET['del'] == $_SESSION['username']) {

	$sql3="DELETE FROM $waitingtable WHERE username = '".$_SESSION['username']."'";
	$result3=mysql_query($sql3,$db);

	if ($result3) {

		echo "<h1>Removed ".$_SESSION['username']." from list...</h1><br /><a href='index.php'>back to index >></a>";
			require('bottom.php');
			exit;
	}
	echo "Database frakked up error: Contact admin if problem remans for more then a day...";
	exit;
 	require('bottom.php');
}

?>


<br />
<table border=0 width="100%" style="smallinfo">
	<tr>
	
	
	<td width="70%" valign="top" padding-right="15px">


If you are looking for a <i>ladder game</i> you can find opponents by e-mail challenging them via their profile, the Ladder Discord server, checking out the Training Room or by putting yourself on the "I want to play now"-list below.<br /><br />Please estimate for how many hours you'll be looking for a game. Also tell us if you are already waiting on a given server or if you want to be contacted via Discord. Once your set time runs out you'll be auto-removed from the list. Don't forget to remove yourself if something else shows up. Abuse of this function will get you a ban.<br /><br />
<form method="post">
<select size="1" name="hours" class="text"><option>1</option><option selected>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
</select> This is how long we'll be available for a game.
<br /><br />

<select size="1" name="server" class="text">
<?php //lets display the proper dropdown menu..
echo "$dropdown"; ?>

</select> This is where you'll find and contact us.<br><br>

<input type="Submit" name="wait" value="Add clan to waiting-for-game" class="text"><br>
</form>
<?php require('bottom.php'); ?>