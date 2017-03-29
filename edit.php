<?php
session_start();
// v. 1.07

require 'conf/variables.php';
require_once 'autologin.inc.php';
require_once 'logincheck.inc.php';

require 'top.php';
include 'include/avatars.inc.php';
include 'include/countries.inc.php';


// Lets check to see if there are Ladder cookies to see if the user is logged in. If so, we wont show the login box....
// First we extract the info from the cookies... There are 2 of them, one containing username, other one the password.
echo "<br /><h2>".$_SESSION['username']."</h2>";

if (isset($_POST['submit'])) {
	// Lets generate the encrypted pass, after all, its the one thats stored in the database... we do it by applying the salt and hashing it twice.
// We need to take the users real pass, "encrypt" it the same way we did when he registered, and then compare the results.
// $salt is read from config file

$passworddb2 = $salt.$_POST['passworddb'];
$passworddb2 = md5($passworddb2);
$passworddb2 = md5($passworddb2);







$sql="SELECT * FROM $playerstable WHERE name='".$_SESSION['username']."'";
$result=mysql_query($sql,$db);
$num = mysql_num_rows($result);
if ($num > 0) {
$mail = trim(strip_tags($_POST['mail']));

$_w_days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
$_some_postfix = array('M', 'N', 'A', 'E', 'Ni');
$CanPlay = "";
foreach($_w_days as $_week_day) {
  foreach($_some_postfix as $_px) {
    //echo $_week_day.$_px."<br";
    if (isset($_POST[$_week_day.$_px]) && ($_POST[$_week_day.$_px] != "")) {
      $CanPlay = "$CanPlay".$_POST[$_week_day.$_px];
    }
  }
}


// check if the user wants a new password than the old.

    if ($_POST['newpassworddb'] == $_POST['newpassworddb2']) {
        // if the same new pass was entered twice he should get a new pass.... one will be generated now:
	    if ($_POST['newpassworddb'] != "" && $_POST['newpassworddb2'] != "") {
		    // Apparently he wants a new pass... let's compare the new pass verification:
		    $newpassworddb = $salt.$_POST['newpassworddb'];
            $newpassworddb = md5($newpassworddb);
            $newpassworddb = md5($newpassworddb);
		}
	} else {
        echo "New password verification didn't match. Please re-type and verify the new password.";
        require('bottom.php');
        exit;
    }


    // Depending on if he wants a new pass or wants to keep the old we need 2 different sql queries...
    // An administrator can impersonate a user and update information about them without entering the original password.
    if (isset($newpassworddb) && ($newpassworddb && $newpassworddb != ""))  {
        $sql = "UPDATE $playerstable SET mail = '$mail', country = '".$_POST['country']."', Avatar = '".$_POST['avatar']."', MsgMe = '".$_POST['msgme']."', HaveVersion = '".$_POST['version']."', CanPlay = '$CanPlay', Jabber = '".$_POST['jabber']."', passworddb = '$newpassworddb' WHERE name='".$_SESSION['username']."' AND (passworddb = '$passworddb2' OR '".$_SESSION['real-username']."' <> '".$_SESSION['username']."')";
    } else {
        $sql = "UPDATE $playerstable SET mail = '$mail', country = '".$_POST['country']."', Avatar = '".$_POST['avatar']."', MsgMe = '".$_POST['msgme']."', HaveVersion = '".$_POST['version']."', CanPlay = '$CanPlay', Jabber = '".$_POST['jabber']."' WHERE name='".$_SESSION['username']."' AND (passworddb = '$passworddb2' OR '".$_SESSION['real-username']."' <> '".$_SESSION['username']."')";
    }
    $result = mysql_query($sql);
    echo "<p class='text'>Profile is now updated.<br><a href='profile.php?name=".$_SESSION['username']."'>Go back to your profile.</a></p>";
    if (isset($newpassworddb) && ($newpassworddb && $newpassworddb !="")) {
       echo "<p class='text'><br>Since you changed password you will need to login to the site again to use the automatic login feature.  Please login with your new password.</p>"; }
    } else {
        echo "<p class='text'>The password you entered is incorrect.<br><br><a href='edit.php'>Please try again.</a></p>";
    }
} else {
?>
<?php
$sql="SELECT * FROM $playerstable WHERE name = '".$_SESSION['username']."' ORDER BY name ASC";
$result=mysql_query($sql,$db);
$row = mysql_fetch_array($result);
?>
<form method="post">
<table border="0" cellpadding="0">

<tr>
<td>
	<input type=hidden name="editname" value="<?php echo $_SESSION['username'] ?>">
</td>
</tr>

<tr>
<td><p class="text"><b>Password:</b></p></td>
<td><input type="password" size="15" name="passworddb" class="text"> You <i>must</i> enter your password to save profile changes.</td>
</tr>

<tr>
<td><p class="text">New Password:</p></td>
<td><input type="password" size="15" name="newpassworddb" class="text"> Leave empty unless changing your password.</td>
</tr>


<tr>
<td><p class="text">Verify New Password:</p></td>
<td><input type="password" size="15" name="newpassworddb2" class="text"></td>
</tr>



<tr>
<td><p class="text"><b>Mail:</b></p></td>
<td><input type="Text" name="mail" value="<?php echo $row['mail'] ?>" class="text"></td>
</tr>

<tr>
<td><p class="text">Jabber:</p></td>
<td><input type="Text" name="jabber" value="<?php echo $row['Jabber'] ?>" class="text"> Open source, Same as g-mail chat.</td>
</tr>
<tr>


<!–– TODO: YTrushkov
move to appropriate place later
––>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        var li = $( "<li>" ),
          wrapper = $( "<div>", { text: item.label } );

        if ( item.disabled ) {
          li.addClass( "ui-state-disabled" );
        }

        $( "<span>", {
          style: item.element.attr( "data-style" ),
          "class": "ui-icon " + item.element.attr( "data-class" )
        })
          .appendTo( wrapper );

        return li.append( wrapper ).appendTo( ul );
      }
    });


    $( "#country_select" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget" )
        .addClass( "ui-menu-icons country" );

  } );
  </script>
  <style>

    .ui-menu-icons .ui-menu-item-wrapper {
       padding-left: 2em;
    }

    .ui-selectmenu-menu .ui-menu {
       max-height: 300px;
    }

    /* select with CSS country icons */
    option.country {
      background-repeat: no-repeat !important;
      padding-left: 24px;
    }
    .country .ui-icon {
      background-position: left top;
      background-size: 16px 16px;
    }
  </style>


<td><p class="text" >Country:</p></td>
<td><select size="1" name="country" id="country_select">
<?php
      // Force No Country to the top
      echo "<option data-class='country' data-style=\"background-image:url('graphics/flags/No Country.bmp');\" value='No Country'>No Country</option>";

      $countries = countriesList();

      asort($countries);

      foreach ($countries as $key => $data) {
        if ($key !== "No Country") {
          echo '<option data-class="country" data-style="background-image:url(\'graphics/flags/'.htmlentities($data).'\');" value="'.htmlentities($key).'" '.(($key == $row['country'])?"selected":"").'>'.htmlentities($key)."</option>\n";
        }
      }
?>
</select></td></tr>



<tr><td><p class="text">Avatar:</p></td>
<td><select name="avatar" class="icon-menu" id="avatar">
<?php
      // Force No avatar to the top
      echo "<option value='No avatar.gif'>No avatar</option>";
      $avatars = avatarList();

      asort($avatars);

      foreach ($avatars as $key => $data) {
        if ($key !== "No avatar") {
          echo '<option style="background-image:url(avatars/'.htmlentities($data).');" value="'.htmlentities($data).'" '.(($data == $row['Avatar'])?"selected":"").'>'.htmlentities($key)."</option>\n";
        }
      }



?>
</select></td></tr>


<tr><td><a href="avatar_upload.php">Upload Your Logo/Avatar Here</a></tr></td>


<tr><td><p class="text"><b>Console:</b></p></td>

<td>&nbsp;<select size="1" name="version" class="text">
<?php
echo "<option>$row[HaveVersion]</option>";
?>
<option>XBOX</option>
<option>PS4</option>
<option>Both</option>
</select></td></tr>

<tr><td><p class="text">Msg me to play:</p></td>
<td>&nbsp;<select size="1" name="msgme" class="text">
<?php echo "<option>$row[MsgMe]</option>"; ?>
<option>Yes</option>
<option>No</option>
</select></td></tr>
</table>



<p class="text">We can usually play these times (GMT):</p>
<table width="100%">


<tr>

<td></td>
<td>Morning</td>
<td>Noon</td>
<td>Afternoon</td>
<td>Evening</td>
<td>Night</td>
</tr>



<tr>
<td bgcolor="#E7D9C0">Monday</td>


<td bgcolor="#E7D9C0"><input type="checkbox" name="MonM" value="MonM" <?php $pos1 = strpos("$row[CanPlay]", "MonM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>


<td bgcolor="#E7D9C0"><input type="checkbox" name="MonN" value="MonN" <?php $pos1 = strpos("$row[CanPlay]", "MonN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonA" value="MonA" <?php $pos1 = strpos("$row[CanPlay]", "MonA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonE" value="MonE" <?php $pos1 = strpos("$row[CanPlay]", "MonE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonNi" value="MonG" <?php $pos1 = strpos("$row[CanPlay]", "MonG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>



<tr>
<td>Tuesday</td>
<td><input type="checkbox" name="TueM" value="TueM" <?php $pos1 = strpos("$row[CanPlay]", "TueM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="TueN" value="TueN" <?php $pos1 = strpos("$row[CanPlay]", "TueN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="TueA" value="TueA" <?php $pos1 = strpos("$row[CanPlay]", "TueA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="TueE" value="TueE" <?php $pos1 = strpos("$row[CanPlay]", "TueE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="TueNi" value="TueG" <?php $pos1 = strpos("$row[CanPlay]", "TueG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>


<tr>
<td bgcolor="#E7D9C0">Wednesday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedM" value="WedM" <?php $pos1 = strpos("$row[CanPlay]", "WedM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedN" value="WedN" <?php $pos1 = strpos("$row[CanPlay]", "WedN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedA" value="WedA" <?php $pos1 = strpos("$row[CanPlay]", "WedA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedE" value="WedE" <?php $pos1 = strpos("$row[CanPlay]", "WedE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedNi" value="WedG" <?php $pos1 = strpos("$row[CanPlay]", "WedG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>

<tr>
<td>Thursday</td>
<td><input type="checkbox" name="ThuM" value="ThuM" <?php $pos1 = strpos("$row[CanPlay]", "ThuM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="ThuN" value="ThuN" <?php $pos1 = strpos("$row[CanPlay]", "ThuN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="ThuA" value="ThuA" <?php $pos1 = strpos("$row[CanPlay]", "ThuA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="ThuE" value="ThuE" <?php $pos1 = strpos("$row[CanPlay]", "ThuE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="ThuNi" value="ThuG" <?php $pos1 = strpos("$row[CanPlay]", "ThuG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>

<tr>
<td bgcolor="#E7D9C0">Friday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriM" value="FriM" <?php $pos1 = strpos("$row[CanPlay]", "FriM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriN" value="FriN" <?php $pos1 = strpos("$row[CanPlay]", "FriN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriA" value="FriA" <?php $pos1 = strpos("$row[CanPlay]", "FriA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriE" value="FriE" <?php $pos1 = strpos("$row[CanPlay]", "FriE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriNi" value="FriG" <?php $pos1 = strpos("$row[CanPlay]", "FriG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>

<tr>
<td>Saturday</td>
<td><input type="checkbox" name="SatM" value="SatM" <?php $pos1 = strpos("$row[CanPlay]", "SatM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="SatN" value="SatN" <?php $pos1 = strpos("$row[CanPlay]", "SatN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="SatA" value="SatA" <?php $pos1 = strpos("$row[CanPlay]", "SatA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="SatE" value="SatE" <?php $pos1 = strpos("$row[CanPlay]", "SatE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td><input type="checkbox" name="SatNi" value="SatG" <?php $pos1 = strpos("$row[CanPlay]", "SatG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
</tr>

<tr>
<td bgcolor="#E7D9C0">Sunday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunM" value="SunM" <?php $pos1 = strpos("$row[CanPlay]", "SunM"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunN" value="SunN" <?php $pos1 = strpos("$row[CanPlay]", "SunN"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunA" value="SunA" <?php $pos1 = strpos("$row[CanPlay]", "SunA"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunE" value="SunE" <?php $pos1 = strpos("$row[CanPlay]", "SunE"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunNi" value="SunG" <?php $pos1 = strpos("$row[CanPlay]", "SunG"); if ($pos1 != FALSE) { echo "checked"; }?>/></td>

</table>

<p><input type="Submit" name="submit" value="Submit" class="text"><br>

</form>
<?php
}


require('bottom.php');
?>