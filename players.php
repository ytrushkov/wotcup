<?php
session_start();
require('conf/variables.php');

// Handle cookies setting before any display is made
$searchArray = unserialize(base64_decode($_COOKIE['playeroptions']));
isset($_GET['player']) ? $searchArray['player'] = $_GET['player'] : $searchArray['player'] = "";
isset($_GET['gamesdirection']) ? $searchArray['gamesdirection'] = $_GET['gamesdirection'] : $searchArray['gamesdirection'] = "";
isset($_GET['winsdirection']) ? $searchArray['winsdirection'] = $_GET['winsdirection'] : $searchArray['winsdirection'] = "";
isset($_GET['lossesdirection']) ? $searchArray['lossesdirection'] = $_GET['lossesdirection'] : $searchArray['lossesdirection'] = "";
isset($_GET['ratingdirection']) ? $searchArray['ratingdirection'] = $_GET['ratingdirection'] : $searchArray['ratingdirection'] = "";
isset($_GET['streakdirection']) ? $searchArray['streakdirection'] = $_GET['streakdirection'] : $searchArray['streakdirection'] = "";
isset($_GET['country']) ? $searchArray['country'] = $_GET['country'] : $searchArray['country'] = "";
isset($_GET['games']) ? $searchArray['games'] = $_GET['games'] : $searchArray['games'] = "";
isset($_GET['wins']) ? $searchArray['wins'] = $_GET['wins'] : $searchArray['wins'] = "";
isset($_GET['losses']) ? $searchArray['losses'] = $_GET['losses'] : $searchArray['losses'] = "";
isset($_GET['rating']) ? $searchArray['rating'] = $_GET['rating'] : $searchArray['rating'] = "";
isset($_GET['streak']) ? $searchArray['streak'] = $_GET['streak'] : $searchArray['streak'] = "";
isset($_GET['HaveVersion']) ? $searchArray['HaveVersion'] = $_GET['HaveVersion'] : $searchArray['HaveVersion'] = "";

if ($searchArray['gamesdirection'] <> "<=" && $searchArray['gamesdirection'] <> ">=" && $searchArray['gamesdirection'] <> "=") $searchArray['gamesdirection'] = "";
if ($searchArray['winsdirection'] <> "<=" && $searchArray['winsdirection'] <> ">=" && $searchArray['winsdirection'] <> "=") $searchArray['winsdirection'] = "";
if ($searchArray['lossesdirection'] <> "<=" && $searchArray['lossesdirection'] <> ">=" && $searchArray['lossesdirection'] <> "=") $searchArray['lossesdirection'] = "";
if ($searchArray['ratingdirection'] <> "<=" && $searchArray['ratingdirection'] <> ">=" && $searchArray['ratingdirection'] <> "=") $searchArray['ratingdirection'] = "";
if ($searchArray['streakdirection'] <> "<=" && $searchArray['streakdirection'] <> ">=" && $searchArray['streakdirection'] <> "=") $searchArray['streakdirection'] = "";

setcookie ("playeroptions", base64_encode(serialize($searchArray)), time()+7776000);

require_once 'autologin.inc.php';
require('top.php');
?>
<h2>Clan Search <?php echo $_SESSION['ladder_id']; ?></h2>
<p>You can search for clans below.  You may use the options in the header to search for specific criteria.  A maximum of 250 players will be displayed for any search.</p>
<form method="get" action="players.php">
<script type="text/javascript">
$(document).ready(function()
    {
        $("#player").tablesorter({sortList: [[2,1]], widgets: ['zebra', 'filter'] });
    }
);
</script>
<table id="player" class="tablesorter">
<thead>
<tr>
<th>&nbsp;</th>
<th>Clan</th>
<th>Games</th>
<th>Wins</th>
<th>Losses</th>
<th>Rating</th>
<th>Streak</th>
<th>Country</th>
<th>Version</th>
</tr>
<tr>
<td><input type="submit" value="Search" /></td>
<td><input name="player" type="text" value="<?php if(isset($searchArray['player'])) echo $searchArray['player']; ?>" size="10" /></td>
<td><select name="gamesdirection">
    <option <?php if ($searchArray['gamesdirection'] == "") echo "selected='selected'"; ?> value="">--</option>
    <option <?php if ($searchArray['gamesdirection'] == "<=") echo "selected='selected'"; ?> value="&lt;=">&lt;=</option>
    <option <?php if ($searchArray['gamesdirection'] == ">=") echo "selected='selected'"; ?> value="&gt;=">&gt;=</option>
    <option <?php if ($searchArray['gamesdirection'] == "=") echo "selected='selected'"; ?> value="=">=</option>
    </select>
    <input type="text" value="<?php echo $searchArray['games']; ?>" name="games" size="2" />
</td>
<td><select name="winsdirection">
    <option <?php if ($searchArray['winsdirection'] == "") echo "selected='selected'"; ?> value="">--</option>
    <option <?php if ($searchArray['winsdirection'] == "<=") echo "selected='selected'"; ?> value="&lt;=">&lt;=</option>
    <option <?php if ($searchArray['winsdirection'] == ">=") echo "selected='selected'"; ?> value="&gt;=">&gt;=</option>
    <option <?php if ($searchArray['winsdirection'] == "=") echo "selected='selected'"; ?> value="=">=</option>
    </select>
    <input type="text" value="<?php echo $searchArray['wins']; ?>" name="wins" size="2" />
</td>
<td><select name="lossesdirection">
    <option <?php if ($searchArray['lossesdirection'] == "") echo "selected='selected'"; ?> value="">--</option>
    <option <?php if ($searchArray['lossesdirection'] == "<=") echo "selected='selected'"; ?> value="&lt;=">&lt;=</option>
    <option <?php if ($searchArray['lossesdirection'] == ">=") echo "selected='selected'"; ?> value="&gt;=">&gt;=</option>
    <option <?php if ($searchArray['lossesdirection'] == "=") echo "selected='selected'"; ?> value="=">=</option>
    </select>
    <input type="text" value="<?php echo $searchArray['losses']; ?>" name="losses" size="2" />
</td>
<td><select name="ratingdirection">
    <option <?php if ($searchArray['ratingdirection'] == "") echo "selected='selected'"; ?> value="">--</option>
    <option <?php if ($searchArray['ratingdirection'] == "<=") echo "selected='selected'"; ?> value="&lt;=">&lt;=</option>
    <option <?php if ($searchArray['ratingdirection'] == ">=") echo "selected='selected'"; ?> value="&gt;=">&gt;=</option>
    <option <?php if ($searchArray['ratingdirection'] == "=") echo "selected='selected'"; ?> value="=">=</option>
    </select>
    <input type="text" value="<?php echo $searchArray['rating']; ?>" name="rating" size="2" />
</td>
<td><select name="streakdirection">
    <option <?php if ($searchArray['streakdirection'] == "") echo "selected='selected'"; ?> value="">--</option>
    <option <?php if ($searchArray['streakdirection'] == "<=") echo "selected='selected'"; ?> value="&lt;=">&lt;=</option>
    <option <?php if ($searchArray['streakdirection'] == ">=") echo "selected='selected'"; ?> value="&gt;=">&gt;=</option>
    <option <?php if ($searchArray['streakdirection'] == "=") echo "selected='selected'"; ?> value="=">=</option>
    </select>
    <input type="text" value="<?php echo $searchArray['streak']; ?>" name="streak" size="2" />
</td>
<td><select size="1" name="country" class="text">
    <option value=""></option>

    <?php include ("include/countries.inc.php"); ?>

<?php


      $countries = countriesList();

      asort($countries);

      foreach ($countries as $key => $data) {
        if ($key !== "No Country") {
          echo '<option value="'.htmlentities($key).'" '.(($key == $searchArray['country'])?"selected":"").'>'.htmlentities($key)."</option>\n";
        }
      }
?>

</select>

</td>
<td><select size="1" name="HaveVersion" class="text">
    <option value=""></option>
    <option <?php echo (($searchArray['HaveVersion'] == "XBOX")?"selected":" "); ?> value="XBOX">XBOX</option>
    <option <?php echo (($searchArray['HaveVersion'] == "PS4")?"selected":" "); ?> value="PS4">PS4</option>
    </select>
</td>
</tr>
</thead>
<tbody>
<?php

// Construct the where clause
$where = "name like '%".$searchArray['player']."%' ";

// Setup ratings in query
if ($searchArray['gamesdirection'] != "" && $searchArray['games'] != "") {
    $where .= " AND games ".$searchArray['gamesdirection']." '".$searchArray['games']."' ";
}
if ($searchArray['winsdirection'] != "" && $searchArray['wins'] != "") {
    $where .= " AND wins ".$searchArray['winsdirection']." '".$searchArray['wins']."' ";
}
if ($searchArray['lossesdirection'] != "" && $searchArray['losses'] != "") {
    $where .= " AND losses ".$searchArray['lossesdirection']." '".$searchArray['losses']."' ";
}
if ($searchArray['ratingdirection'] != "" && $searchArray['rating'] != "") {
    $where .= " AND rating ".$searchArray['ratingdirection']." '".$searchArray['rating']."' ";
}
if ($searchArray['streakdirection'] != "" && $searchArray['streak'] != "") {
    $where .= " AND streak ".$searchArray['streakdirection']." '".$searchArray['streak']."' ";
}
if ($searchArray['country'] != '') {
    $where .= " AND country = '".$searchArray['country']."' ";
}
if ($searchArray['HaveVersion'] != '') {
    $where .= " AND HaveVersion = '".$searchArray['HaveVersion']."' ";
}

// YTrushkov: dont show admins
if($CFG_ignoreadmins) {
    $where .= " AND is_admin = 0  ";
}

$sql = "SELECT * FROM $standingscachetable RIGHT JOIN $playerstable USING (name) WHERE confirmation <> 'Deleted' AND ".$where;
$sql .= " ORDER BY name ASC LIMIT 250";

$result=mysql_query($sql,$db);
while ($row = mysql_fetch_array($result)) {
    if ($row["approved"] == "no") {
	$namepage = "<span style='color: #FF0000'>$row[name]</span>";
    } else {
	$namepage = $row['name'];
    }

    $games = $row['games'] == "" ? 0 : $row['games'];
    $wins = $row['wins'] == "" ? 0 : $row['wins'];
    $losses = $row ['losses'] == "" ? 0 : $row['losses'];
    $rating = $row['rating'] == "" ? BASE_RATING : $row['rating'];
    $streak = $row['streak'] == "" ? 0 : $row['streak'];
    $version = $row['HaveVersion'] == "" ? 0 : $row['HaveVersion'];

?>
<tr>
<td align="center"><?php echo "<img border='0' height='48px' src='avatars/$row[Avatar]' alt='avatar' />"?></td>
<td><?php echo "<a href='profile.php?name=$row[name]'>$namepage</a>"?></td>
<td><?php echo $games ?></td>
<td><?php echo $wins ?></td>
<td><?php echo $losses ?></td>
<td><?php echo $rating ?></td>
<td><?php echo $streak ?></td>
<td align="center"><?php echo "<img src='graphics/flags/$row[country].bmp' align='middle' border='1'>"?></td>
<td><?php echo $version ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</form>
<?php
require('bottom.php');
?>