<?php 
// All pages that include the menu should have started the session is they want to use logged in information
if ($maintenanceMode <> true) {

/*
Menu for teamladder
*/
 if ($CFG_teamladder == true){?>
  <div id="nav">
    <ul>
	  <?php if (isset($_SESSION['username'])) { ?>
	  <li><a href="team_create.php">CreateTeam</a></li>
	  <?php } ?>
	  <li><a href="ladder.php">Ladder</a></li>
	  <li><a href="tournament.php">Tournaments</a></li>
	  <li><a href="team_report.php">Report</a></li>
	  <li><a href="team_profile.php">Profile</a></li>
    </ul>

  <?php 
  //next lines create an additional menu with the only purpose of accessing different ladders
  //checks if multiladder is enabled and then reads the $G_CFG_enabled_ladder_list array and will create for each entry a link plus $_GET Parameter
  //
  if  ($G_CFG_multiladder == true){?>
      <br></br>
      <ul style="font-size: small;">
	  <li><b>Ladderselection:</b></li>
	  <?
	  foreach($G_CFG_enabled_ladder_list as $key => $value) { 
	  echo "<li><a href=\"index.php?ladder=".$value."\">".$value."</a></li>";
	  }
	  ?>
      </ul>
  <?php } ?>

  </div> <?php
  }

else{

/*
Menu for normal ladder
*/

?>
<div id="nav">
  <ul>
	<?php if (!isset($_SESSION['username'])) { ?>
	<li><a href="join.php">Join</a></li>
	<?php } ?>
	<li><a href="report.php">Report</a></li>
	<li><a href="ladder.php">Ladder</a></li>
	<li><a href="gadder.php">Classes</a></li>
	<li><a href="players.php">Clans</a></li>

	<li><a href="gamehistory.php">Game History</a></li>
	<li><a href="tournament.php">Tournaments</a></li>
	<?php if (isset($_SESSION['username'])) { ?>
	<li><a href="ladder.php?personalladder=<?php echo urlencode($_SESSION['username']) ?>">My Ladder</a></li>
	<?php } ?>

	<?php if (isset($_SESSION['username'])) { 
          echo "<li><a href=\"profile.php?name=".$_SESSION['username']."\">".$_SESSION['username']."</a></li>";
          }
    ?>
	<li><a href="faq.php">Rules/FAQ</a></li>
        
<!-- Message Envelope -->
	<!--<div id = "envelope">-->
	  <?php
	      //Envelope for message system
        if (isset($_SESSION['username'])) {
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
	        echo '<span>&nbsp;&nbsp&nbsp;<a href = "message.php" title = "Your message box"><img src = "images/message.png" alt = "Private Messages" title = "Private Messages" /></a>:&nbsp;<strong><a href = "message.php?unread=1" title = "Unread messages">'.$unread_messages.'</a></strong>/<a href = "message.php" title = "All messages">'.$all_messages.'</a>&nbsp;&nbsp&nbsp;</span>';
	}
	  ?>
  <!--</div>-->
  </ul>

<?php 
//next lines create an additional menu with the only purpose of accessing different ladders
//checks if multiladder is enabled and then reads the $G_CFG_enabled_ladder_list array and will create for each entry a link plus $_GET Parameter
//
if  ($G_CFG_multiladder == true){?>
    <br></br>
    <ul style="font-size: small;">
        <li><b>Active Ladder: <?php echo $_SESSION['ladder_id']; ?></b></li> 
	<li><b>Ladder Selection:</b></li>
	<?php
	foreach($G_CFG_enabled_ladder_list as $key => $value) { 

	echo "<li><a href=\"index.php?ladder=".$value."\">".$value."</a></li>";
	}
	?>
    </ul>
<?php
}
?>

</div>
<?php
} } else {
?>
<div id="nav"></div>

<?php
}
?>