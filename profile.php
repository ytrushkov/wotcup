<?php
session_start();
require 'conf/variables.php';
require_once 'autologin.inc.php';
require_once 'include/gametable.inc.php';
require 'include/xp.inc.php';
require 'include/activity.inc.php';
require 'top.php';
require 'include/genericfunctions.inc.php';
date_default_timezone_set("$cfg_ladder_timezone");

?>
<script type="text/javascript">
$(document).ready(function()
    {
        $("#games").tablesorter({sortList: [[0,1]], widgets: ['zebra'] });
        // Set the values to the last used values
        if ($.cookie('profileplay') == "-") {
            $("#availabletoplayexpand").html("[-]");
        } else {
            $("#availabletoplayexpand").html("[+]");
            $("#availabletoplaydiv").hide();
        }
        if ($.cookie('profilegames') == "-") {
            $("#gamesexpand").html("[-]");
        } else {
            $("#gamesexpand").html("[+]");
            $("#gamesdiv").hide();
        }
		 if ($.cookie('profileopposition') == "-") {
            $("#gamesexpand2").html("[-]");
        } else {
            $("#gamesexpand2").html("[+]");
            $("#gamesdiv2").hide();
        }

        // Handle the toggle of playing expansion/collapse
        $("#availabletoplayexpand").click(function()
        {
            $("#availabletoplaydiv").slideToggle(600);
            if ($("#availabletoplayexpand").html() == "[-]") {
               $("#availabletoplayexpand").html("[+]");
               $.cookie('profileplay', "+", { expires: 7});
            } else {
               $("#availabletoplayexpand").html("[-]");
               $.cookie('profileplay', "-", {expires: 7});
            }
        });

        // Handle the toggle of games expansion/collapse
        $("#gamesexpand").click(function()
        {
            $("#gamesdiv").slideToggle(600);
            if ($("#gamesexpand").html() == "[-]") {
               $("#gamesexpand").html("[+]");
               $.cookie('profilegames', '+', { expires: 7});
            } else {
               $("#gamesexpand").html("[-]");
               $.cookie('profilegames', '-', { expires: 7});
            }
        });


        // Handle the toggle of opposition expansion/collapse
        $("#gamesexpand2").click(function()
        {
            $("#gamesdiv2").slideToggle(600);
            if ($("#gamesexpand2").html() == "[-]") {
               $("#gamesexpand2").html("[+]");
               $.cookie('profilegames', '+', { expires: 7});
            } else {
               $("#gamesexpand2").html("[-]");
               $.cookie('profilegames', '-', { expires: 7});
            }
        });
    }
);
</script>

<?php


// Get profile info, like avatar, country etc... Don't mix up the different results that are dumped in $player, which is info from the playerstable, with $playercached, which is info from the cached table and only about results etc.

$mysqlname = $_GET['name'];
$result = mysql_query("SELECT * FROM $playerstable WHERE name = '$mysqlname' LIMIT 1");
$player= mysql_fetch_array($result);


// Get My Ladder Rank

$MySQLPlayerName = $_GET['name'] ;

$result = mysql_query("SELECT * FROM $standingscachetable
WHERE name = '$MySQLPlayerName'
ORDER BY rank DESC
LIMIT 1;");
$playercached = mysql_fetch_array($result);

$cur = 1;
$rank = "";
$rank = $playercached['rank'];


$MySQLgamestorank = $gamestorank;


// A passive player is one that has 0 rank, and have played enough game in total to be included in the ladder, and also has an elo high enough to be included in the ladder. An unranked player is one that doesn't even qualify to be part of the ladder: He has a rank of 0, and hasnt played enough games in total and/or hasn't have an elo that is high enough to be included in the ladder.

if (($rank == "0") && ($playercached['games'] >= $gamestorank) && ($playercached['rating'] >= $ladderminelo)) {

    $rank = "(passive)"; } else if (($rank == "0") && (($playercached['games'] < $gamestorank) || ($playercached['rating'] < $ladderminelo))) {
    $rank = "(unranked)";
}

GetExactActivity($_GET['name'], GAMES_FOR_ACTIVE, $passivedays, $gamestable);

// Get the players elo hiscore

$sql = "SELECT winner, winner_elo FROM $gamestable WHERE winner = '".$_GET['name']."' AND contested_by_loser = '0' AND withdrawn ='0' ORDER BY winner_elo DESC LIMIT 0,1";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);

$hiscore_elo = $row['winner_elo'];

// Get the players elo loscore

$sql = "SELECT loser, loser_elo FROM $gamestable WHERE loser = '".$_GET['name']."' AND contested_by_loser = '0' AND withdrawn ='0' ORDER BY loser_elo ASC LIMIT 0,1";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);

$loscore_elo = $row['loser_elo'];




// Get the players best streak
$sql = "SELECT winner, winner_streak FROM $gamestable WHERE winner = '".$_GET['name']."' AND contested_by_loser = '0' AND withdrawn ='0' ORDER BY winner_streak DESC LIMIT 0,1";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$hiscore_streak = $row['winner_streak'];

// Get the players worst streak
$sql = "SELECT loser, loser_streak FROM $gamestable WHERE loser = '".$_GET['name']."' AND contested_by_loser = '0' AND withdrawn ='0' ORDER BY loser_streak ASC LIMIT 0,1";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$loscore_streak = $row['loser_streak'];

// Now we want to know how many games the user has given a sportsmanship rating in. Sportsmanship rating can be given as loser or winner, so we need to add them together to get the correct count.
$sql=mysql_query("SELECT count(*) FROM $gamestable WHERE  loser = '".$_GET['name']."' AND winner_stars > '0' AND contested_by_loser = '0' AND withdrawn = '0'");
$number=mysql_fetch_row($sql);
$userhasrated = $number[0];

$sql=mysql_query("SELECT count(*) FROM $gamestable WHERE  winner = '".$_GET['name']."' AND loser_stars > '0' AND contested_by_loser = '0' AND withdrawn = '0'");
$number=mysql_fetch_row($sql);
$userhasrated = $userhasrated + $number[0];
// Let's turn them into a percentage of the users total amount of played games:
@$userhasrated = round((($userhasrated/$playercached['games'])*100),0)."%";

// Let's see how many times others have rated the user....
$sql=mysql_query("SELECT count(*) FROM $gamestable WHERE  loser = '".$_GET['name']."' AND loser_stars > '0' AND contested_by_loser = '0' AND withdrawn = '0'");
$number=mysql_fetch_row($sql);
$userwasrated = $number[0];

$sql=mysql_query("SELECT count(*) FROM $gamestable WHERE  winner = '".$_GET['name']."' AND winner_stars > '0' AND contested_by_loser = '0' AND withdrawn = '0'");
$number=mysql_fetch_row($sql);
$userwasrated = $userwasrated + $number[0];
// Let's turn them into a percentage of the users total amount of played games:
@$userwasrated = round((($userwasrated/$playercached['games'])*100),0)."%";







// Now let's see what the user has given other users as a sportsmanship rating, in average:

$sql = "SELECT sum(winner_stars) as total_stars, count(winner_stars) as count FROM $gamestable WHERE loser = '".$_GET['name']."'  AND winner_stars IS NOT NULL AND winner_stars > 0 AND contested_by_loser = '0' AND withdrawn = '0'";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$gaveothersasloser= $row['total_stars'];
$gaveasloserthismanytimes = $row['count'];
@$averagegivenasloser = round(($gaveothersasloser/$gaveasloserthismanytimes),0);

// What the user has given other users as a sportsmanship rating, in average, when he has been the winner:
$sql = "SELECT sum(loser_stars) as total_stars, count(loser_stars) as count FROM $gamestable WHERE winner = '".$_GET['name']."'  AND loser_stars IS NOT NULL AND loser_stars > 0 AND contested_by_loser = '0' AND withdrawn = '0'";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$gaveothersaswinner= $row['total_stars'];
$gaveaswinnerthismanytimes = $row['count'];
@$averagegivenaswinner= round(($gaveothersaswinner/$gaveaswinnerthismanytimes),0);

// And lastly we need an average of whenever he gives a sportsmanship rating
@$averagegiven = round(($gaveothersasloser+$gaveothersaswinner)/($gaveasloserthismanytimes+$gaveaswinnerthismanytimes),0);


/* old by russ
// PASSIVE CHECK: Lets get to know how many days the player has left before hes put into passive mode -----------------
$sql = "SELECT reported_on + '".$passivedays." days' < now() AS passive, ".$passivedays." - (to_days(now()) - to_days(reported_on)) as daysleft  from $gamestable WHERE (winner = '".$_GET['name']."' OR loser = '".$_GET['name']."') AND contested_by_loser = 0 AND withdrawn = 0 ORDER BY reported_on DESC LIMIT 1";
$result = mysql_query($sql, $db);
list($passive, $daysleft) = mysql_fetch_row($result);
*/

if ($player["approved"] == "no") {
$blocked = "(<font color='#FF0000'>blocked or not added yet</font>)";
}else{
$blocked = "";
}

$avan = $player["Avatar"];

if ($player["mail"] == "n/a") {
    $mailaddress = "n/a";
    $mailpic = "";
} else {
    if ($player['Joined'] != NULL) {
        $joined = date("H:i d m y", $player['Joined']);
    } else {
        $joined ="00:00 06 03 08";
    }


}

if ($playercached['games'] <= 0) {
    $totalpercentage = 0.000;
} else {
    $totalpercentage = round($playercached['wins'] / $playercached['games'] * 100, 0);
}

?>
<table width="100%" cellpadding="1px">
<tr>
<td valign="top">

<h1>
<?php

if ($player['Confirmation'] == "Deleted") {
	echo "<h2>The  account  of ". $player['name'] ." is deleted...</h2>For some reason the user or admin has deleted the account you are looking for. It's statistics and other info is <i>preserved</i> and the account can be re-activated by it's owner. We have however decided not to share the info of deleted accounts, thus it is not public. Please contact the admin if you wish to undelete your deleted account. <br><br>";

	require('bottom.php');
	exit;
	}


if ($playercached['name'] == "") {

	// So player is not to be found in the cache table. This either means that the player a) does not exist or b) exists, but hasn't ever played a game yet. Let's find out by looking in the complete players table:

	$sql99=mysql_query("SELECT count(*) FROM $playerstable WHERE  name = '".$_GET['name']."' LIMIT 1");
	$doesplayerexist=mysql_fetch_row($sql99);

	if ($doesplayerexist[0] != 1) {
		echo "Thou shall not name the wrong follower.....<br></h1>Translates into: You have tried to view the profile of a player that has never existed on the ladder. Please check the spelling in the url or enter the name of one that does.";

		require 'bottom.php';
		exit;
	}
}

if ($_SESSION['username'] == $_GET['name']) {
    include_once('conf/config.php');
    include_once('include/entity.class.php');
	//next lines are all about to grab the config file for the specific ladder.
    //first, set session variable called ladder_id, point it to default ladder if it doesnt exist
    if (!isset ($_SESSION['ladder_id'])){
      $_SESSION['ladder_id'] = $G_CFG_default_ladder_id;
    }
    //if 'ladder' is set with url-parameter, change session variable according to it
    if (isset ($_GET['ladder'])){
      $_SESSION['ladder_id'] = $_GET['ladder'];
    }
    //finally include the configuration for the defined ladder
    $config = new Config($_SESSION['ladder_id'].'_conf.php');
	$user = new Entity($config, 'players', array('name', $_SESSION['username']));
	$dbo = new DB($config);
	$cond = new DB_Condition_List(array(
        new DB_Condition('reciever_id', $user->get_player_id()),
		'AND',
		new DB_Condition('deleted_by_reciever', 0)
	));
	$condition = new DB_Condition_List(array(
	    $cond,
		'AND',
		new DB_Condition('read_date', 0)
	));
	$unread_messages = $dbo->select_function($config->get_db_prefix().'_module_topic', 'id', 'count', $condition);
	$all_messages = $dbo->select_function($config->get_db_prefix().'_module_topic', 'id', 'count', $cond);
	unset($dbo);
	unset($user);
    ?>
    <a href='edit.php'><?php echo $player['name'];?> <?php echo $blocked;?>
    <img border="0" src="images/edit.gif" width="18" height="18" align="middle" alt="Edit"></a>
    <?php echo "&nbsp;&nbsp;<img src='graphics/flags/".$player['country'].".bmp' align='middle' border='1' alt='' /> ".$player['country']; ?>
	<div class = "message_alert">
	    <div>
		    <img src = "images/message.png" alt = "Private Messages" title = "Private Messages" />:&nbsp;
		</div>
		<div>
		    <strong><a href = "message.php?unread=1" title = "Unread messages"><?php echo $unread_messages;?></a></strong>/<a href = "message.php" title = "All messages"><?php echo $all_messages;?></a>
		</div>
	</div>
    <div style = "clear: both;">
    </div>
	<?php
    }
    else {
        echo $_GET['name'],"$blocked","&nbsp;&nbsp;<img src='graphics/flags/".$player['country'].".bmp' align='middle' border='1' alt='' /> ".$player['country'];
    }

?>
</h1>


<?php
// Show the players title if he has one...
if ( $player["Titles"]  != "" ) {
	echo "<b>" . $player["Titles"] . "</b><br />";
}

// Show if he's provisional...
// i cant even find this column in the db and suspect something is broken with the provisional stuff...russ? coded it and i dont even remember what it did.
if ( (isset($player["provisional"])) && ($player["provisional"]  == "1" )) {
	echo "<a href=\"faq.php#provisional\">provisional player</a><br />";
}


// Show info about players activity...

// Set the message about how many days we have until passive...

if ($ExactActivity["DaysUntilPassive"] == 0) {
	$buffertdays = "Last day today";
	} else if ($ExactActivity["DaysUntilPassive"] == 1) {
	$buffertdays = "Last day tomorrow";
	} else if ($ExactActivity["DaysUntilPassive"] > 1)  {
	$buffertdays = $ExactActivity["DaysUntilPassive"] . " days until passive";
}

if ($rank == "(passive)") {
	echo "(Missing ".  $ExactActivity["GamesSurplus"] * -1 ." games. Played ". $ExactActivity["GamesPlayed"] . " in the ". $passivedays ." recent days."; }


if (($rank != "(passive)") && ($rank != "(unranked)")  && ($rank > 0)) {
	echo "(". $buffertdays . ". ". $ExactActivity["GamesPlayed"] . " games in recent ". $passivedays ." days.)"; }

	if ($rank == "(unranked)") {
	echo "Need at least a) $gamestorank played games b) ". GAMES_FOR_ACTIVE ." games in the ". $passivedays ." recent days and c) $ladderminelo Elo to become ranked."; }





// If we are logged in and displaying somebody elses profile, tell us about my win/loss
if ((isset($_SESSION['username'])) && ($_GET['name'] != $_SESSION['username']) && (SHOW_ELO_EXPECTED != 0)) {

require_once 'include/elo.class.php';
    $elo = new Elo($db);
    $winresult = $elo->RankGame($_SESSION['username'],$player['name'], date("Y-m-d H:i:s"));
    $lossresult = $elo->RankGame($player['name'],$_SESSION['username'], date("Y-m-d H:i:s"));
    $drawresult = $elo->RankGame($player['name'],$_SESSION['username'], date("Y-m-d H:i:s"), true);

    echo " Points for Win/Loss/Draw: ".$winresult['winnerChange']."/".$lossresult['loserChange']."/".$drawresult['loserChange'];
}
?>
</td>
<td valign="top">
<?php
    echo "<img src='avatars/".$player['Avatar']."' alt='".$player['Avatar']."'>";

	// echo "<br/> <p class='text'><img src='graphics/flags/".$player['country'].".bmp' align='middle' border='1' alt='' /> ".$player['country']."</p>";

?>

</td>
</tr>
</table>


<table width="100%" class="tablesorter">
<thead>
<tr>
<th><span onmouseover="showToolTip('Player Rank','The position the player currently holds in the ladder.',event);" onmouseout="hideToolTip();">Rank</span></th>
<th onmouseover="showToolTip('Elo Rating','Current rating (Highest rating / Lowest rating) .',event);" onmouseout="hideToolTip();">Rating</th>
<th onmouseover="showToolTip('Win Percentage','Has won this many % of the total amount of played games.',event);" onmouseout="hideToolTip();">Percent</th>
<th onmouseover="showToolTip('Player Victories','Amount of games won, in total.',event);" onmouseout="hideToolTip();">Wins</th>
<th onmouseover="showToolTip('Player Losses','Amount of games lost, in total.',event);" onmouseout="hideToolTip();">Losses</th>
<th onmouseover="showToolTip('Played Games','Amount of played games, in total.',event);" onmouseout="hideToolTip();">Played</th>
<th onmouseover="showToolTip('Average Points','Average elo points the player gets when (s)he Wins/Loses/In total.',event);" onmouseout="hideToolTip();">Aver.P W/L/T</th>
<th onmouseover="showToolTip('Streaks','Games currently won/lost in a row (Highest win streak / Highest Loss streak)',event);" onmouseout="hideToolTip();">Streak</th>
<th onmouseover="showToolTip('Sportsmanship / Karma','Current rating / % that rated the player (% that the player rated / average rating given by player when player is the winner / avg. r. given by player when (s)he is the loser / avg. rating given by the player).',event);" onmouseout="hideToolTip();">Sportsmanship</th>
<th onmouseover="showToolTip('False Reports','Involved in this many % of games where the result is false. (Withdrawn victories by player / Player victories contested by others / Player contested losses).',event);" onmouseout="hideToolTip();">Revoked Games</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<?php

// we need some info to get to know how many points the player wins in average WHEN he wins, and the same about when he loses...

$sql = "SELECT round(avg(loser_points),0) FROM $gamestable WHERE loser = '".$_GET['name']."'";
$result = mysql_query($sql, $db);
$row = mysql_fetch_row($result);
$avgPointsOnLoss = $row[0];

$sql = "SELECT round(avg(winner_points),0) FROM $gamestable WHERE winner = '".$_GET['name']."'";
$result = mysql_query($sql, $db);
$row = mysql_fetch_row($result);
$avgPointsOnWin = $row[0];

$sql = "SELECT coalesce(sum(withdrawn),0), coalesce(sum(contested_by_loser),0) from $gamestable WHERE winner = '".$_GET['name']."'";
$result = mysql_query($sql, $db);
list($withdrawn, $contestedByOthers) = mysql_fetch_row($result);
$sql = "SELECT coalesce(sum(contested_by_loser),0) from $gamestable WHERE loser = '".$_GET['name']."'";
$result = mysql_query($sql, $db);
list($contested) = mysql_fetch_row($result);

// get the players average points / game...
if ($playercached['games'] > 0) {
	$avgPointsPerGame = round((($playercached['rating'] - BASE_RATING)/$playercached['games']),2);
} else {
    $avgPointsPerGame = 0;
}

if ($playercached['games'] < $gamestorank) {
    echo "(unranked)";
} else {

 if ($ExactActivity["DaysUntilPassive"] >= 0) {
        echo $rank;
    } else {
        echo "<a href=\"faq.php#passive\">(passive)</a>";
    }
}

// Get average sportsmanship. This will get the points one has gotten from others while one is the loser of the game.
$sql = "SELECT sum(loser_stars) as total_stars, count(loser_stars) as count FROM $gamestable WHERE loser = '".$_GET['name']."'  AND loser_stars IS NOT NULL AND loser_stars > 0 ";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$SportsmanshipAsLoser = $row['total_stars'];
$SportsmanshipRatedAsLoser = $row['count'];

// This will get the points one has gotten from others while one is the winner of the game.
$sql = "SELECT sum(winner_stars) as total_stars, count(winner_stars) as count FROM $gamestable WHERE winner = '".$_GET['name']."'  AND winner_stars IS NOT NULL AND winner_stars > 0";
$result = mysql_query($sql, $db);
$row = mysql_fetch_array($result);
$SportsmanshipAsWinner = $row['total_stars'];
$SportsmanshipRatedAsWinner = $row['count'];

// We must to account of the fact that a user may only have a sportsmanship rating as either a winner or a loser.
// You must average at the last possible moment, so we can't create a total sportsmanship average in the SQL.
// Instead we do that here.
if (($SportsmanshipRatedAsLoser+$SportsmanshipRatedAsWinner) > 0) {
    $sportsmanship = round((($SportsmanshipAsWinner+$SportsmanshipAsLoser)/($SportsmanshipRatedAsLoser+$SportsmanshipRatedAsWinner)),0). " &nbsp;($userwasrated / $userhasrated: $averagegivenaswinner / $averagegivenasloser / $averagegiven)";
} else {
    $sportsmanship = "- &nbsp;($userwasrated / $userhasrated:  $averagegivenaswinner / $averagegivenasloser / $averagegiven)";
}
?>
</td>
<td><?php if ($playercached['games'] <= 0) { echo BASE_RATING ;} else { echo round($playercached['rating'],0) ." &nbsp; (". round($hiscore_elo,0) ." / ". round($loscore_elo,0) .")"; } ?></td>
<td><?php echo $totalpercentage ?>%</td>
<td><?php echo $playercached['wins'] ?></td>
<td><?php echo $playercached['losses'] ?></td>
<td><?php echo $playercached['games'] ?></td>
<td><?php if ($playercached['games'] > 0) { echo "$avgPointsOnWin / $avgPointsOnLoss / $avgPointsPerGame"; } else { echo "-"; } ?></td>

<td><?php if ($playercached['games'] > 0) { echo $playercached['streak']."&nbsp;($hiscore_streak / $loscore_streak)"; } else { echo "-"; }  ?></td>
<td><?php echo $sportsmanship; ?></td>
<td><?php

// Avoid division by zero problems...

if ($playercached['games'] > 0) {
    echo sprintf("%0.0f%% (%d / %d / %d)",($withdrawn+$contestedByOthers+$contested)/($playercached['games']+$withdrawn+$contestedByOthers+$contested)*100, $withdrawn, $contestedByOthers, $contested);
} else {
    echo "-";
}

?></td>
</tr>
</tbody>
</table>

<?php
GetLvl($playercached['wins'], $playercached['losses'],XP_FOR_WIN,XP_FOR_LOSS,XP_SYS_LVL_1,XP_SYS_LVL_FACTOR);

// Fetch his lvl-related title...
$titlefound = 0;

// (YTrushkov) not sure if this right, but q and $TitleNumber were unset before
$q = 0;
$TitleNumber = 0;

while ($titlefound == 0) {
        //echo "<b>PlayerLvl: ",$PlayerLvl,"</b>";
	if ($PlayerLvl >= $q) {

		$TitleNumber++;
		$q = ($q + XP_SYS_TITLE_RANGE)*XP_SYS_TITLE_RANGE_MULTIPLIER;

	} else {

	$titlefound = 1;

	// If the player has a level lower than then required to obtain the first title we have to set a custom one instead.
	if ($PlayerLvl < XP_SYS_TITLE_RANGE) {
		$LvlRelatedTitle = "None";
		} else { $LvlRelatedTitle = $XpTitle["$TitleNumber"];}

	}

}

// The following table and stuff should only be shown / happen if the ladder uses the XP system. It can be enabled/disabled in the config file.
if (XP_SYS_ENABLED == 1) { ?>
<table class="tablesorter">
<thead>
<tr>
<th>Title</th>
	<th>Level</th>
	<th>XP</th>
	<th>Next Lvl</th>
		<th>Have</th>
</tr>
</thead>
<tbody>
	<tr>

	<td><?php echo $LvlRelatedTitle; ?></td>
	<td><?php echo $PlayerLvl; ?></td>
	<td> <?php echo $PlayerXp; ?></td>
	<td> <?php echo round($CountingXp,0); ?></td>
	<td> <?php echo round(($PlayerXp/$CountingXp*100),0). "%"; ?></td>

	</tr>
</tbody>
</table>

<?php } ?>

<table class="tablesorter"><tbody><tr><td>
<?php
if ((isset($player['MsgMe'])) && ($player['MsgMe'] == "Yes")) {
    echo "<b><font color=\"#0D3D02\">Contact me to play!</font></b>";
} else {
    echo "<font color=\"#9E005D\">Please don't message me asking for a game.</font>";
}

if ($_SESSION['username'] && $player['MsgMe'] == "Yes") {
    echo "  <a href=\"challenge.php?challenger=".urlencode($_SESSION['username'])."&challenged=".$_GET['name']."\">[Challenge]</a>";
}
?>
</td>


<td>
<a href = "message.php?action=create_message&amp;reciever="<?php echo $player['name'];?>">Send me a message</a>
</td>
</tr>
</tbody>
</table>

<?php

if ($player['CanPlay'] != "") { ?>
    <h2>Available to play <a style = "cursor: pointer;" id="availabletoplayexpand"></a></h2>
	<br>

<div id="availabletoplaydiv">
<p class="text">Is on <?php echo $player['HaveVersion'] ?>  & can usually play <?php echo " ($cfg_ladder_timezone)";?>:</p>

	<table id="availabletoplay" class="tablesorter">
    <thead>
	<tr>
	<th></th>
	<th>Morning</th>
	<th>Noon</th>
	<th>Afternoon</th>
	<th>Evening</th>
	<th>Night</th>
	</tr>
    </thead>
    <tbody>
<?php
    $days = array("Monday" => "Mon", "Tuesday" => "Tue", "Wednesday" => "Wed",
                  "Thursday" => "Thu", "Friday" => "Fri", "Saturday" => "Sat", "Sunday" => "Sun");
$class = "even";
foreach($days as $name => $abbrev) {
    if ($class == "odd") {
        $class = "even";
    } else {
        $class = "odd";
    }
?>
	<tr class="<?php echo $class ?>">
		<td style="text-align: right; font-weight: bold"><?php echo $name ?></td>

		<td><?php $pos1 = strpos($player['CanPlay'], $abbrev."M");
		if ($pos1 != FALSE) {echo "<img border=\"0\" height='20px' src=\"images/streakplus.gif\" />";}?></td>
		<td><?php $pos1 = strpos($player['CanPlay'], $abbrev."N");
		if ($pos1 != FALSE) {echo "<img border=\"0\" height='20px' src=\"images/streakplus.gif\" />";} ?></td>
		<td><?php $pos1 = strpos($player['CanPlay'], $abbrev."A");
		if ($pos1 != FALSE) {echo "<img border=\"0\" height='20px' src=\"images/streakplus.gif\" />";} ?></td>
		<td><?php $pos1 = strpos($player['CanPlay'], $abbrev."E");
		if ($pos1 != FALSE) {echo "<img border=\"0\" height='20px' src=\"images/streakplus.gif\" />";} ?></td>
		<td><?php $pos1 = strpos($player['CanPlay'], $abbrev."G");
		if ($pos1 != FALSE) {echo "<img border=\"0\" height='20px' src=\"images/streakplus.gif\" />";} ?></td>
	</tr>

	<?php } ?> // edn of foreach
    </tbody>
	</table>
    </div>
<?php }  // end of if

// Only show game history & opposition break down if there are any played games...

if ($playercached['games'] > 0) {


    $sql = "SELECT reported_on, DATE_FORMAT(reported_on, '".$GLOBALS['displayDateFormat']."') as report_time, unix_timestamp(reported_on) as unixtime, winner, loser, winner_points, loser_points, winner_elo, loser_elo, replay_filename is not null as is_replay, replay_downloads, withdrawn, contested_by_loser, winner_comment, loser_comment, winner_stars, loser_stars, winner_games, loser_games, l_rank, w_rank, l_new_rank, w_new_rank FROM $gamestable WHERE winner = '".$_GET['name']."' OR loser = '".$_GET['name']."'  ORDER BY reported_on DESC LIMIT 30";


$result = mysql_query($sql,$db);
?>


<h2>Recent Games <a id="gamesexpand" style = "cursor: pointer;"></a></h2>
<div id="gamesdiv">
<table id="games" class="tablesorter">
	<?php echo gameTableTHead(); ?>
	<?php echo gameTableTBody($result, $_GET['name']); ?>
</table>
</div>
<br />


<h2>Opposition <a id="gamesexpand2" style = "cursor: pointer;"></a></h2>
<div id="gamesdiv2">
<?php include 'include/opposition.inc.php'; ?>
</div>


<?php

// display the elo/game chart if it is set in the main config
if  ($G_CFG_enable_graph_creation == TRUE){?>
    <h2>Graph <a id="graph"></a></h2>
    <div align="center" id="graph"> <?php include 'pChart/elo_time_graph.php'; ?> </div>
<?php  } ?>

<?php
}
require('bottom.php');
?>