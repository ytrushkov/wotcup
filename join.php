<?php
session_start();
$page = "join";
require('conf/variables.php');
require('top.php');
include 'include/avatars.inc.php';
include 'include/countries.inc.php';
?>
<p class="header">Join.</p>
<p class="text">
<?php
if (isset ($_POST['submit'])) {
	$name = trim(strip_tags($_POST['name']));
	$passworddb = trim(strip_tags($_POST['passworddb']));
	$passworddb2 = trim(strip_tags($_POST['passworddb2']));
	$mail = trim(strip_tags($_POST['mail']));
	$WesVersion = $_POST['version'];
	$MsgMeToPlay = $_POST['msgme'];
	$length = strlen($name);

	if (isset($_POST['MonM']) != "") {$CanPlay = "$CanPlay $_POST[MonM]";}
	if (isset($_POST['MonN']) != "") {$CanPlay = "$CanPlay $_POST[MonN]";}
	if (isset($_POST['MonA']) != "") {$CanPlay = "$CanPlay $_POST[MonA]";}
	if (isset($_POST['MonE']) != "") {$CanPlay = "$CanPlay $_POST[MonE]";}
	if (isset($_POST['MonNi']) != "") {$CanPlay = "$CanPlay $_POST[MonNi]";}

	if (isset($_POST['TueM']) != "") {$CanPlay = "$CanPlay $_POST[TueM]";}
	if (isset($_POST['TueN']) != "") {$CanPlay = "$CanPlay $_POST[TueN]";}
	if (isset($_POST['TueA']) != "") {$CanPlay = "$CanPlay $_POST[TueA]";}
	if (isset($_POST['TueE']) != "") {$CanPlay = "$CanPlay $_POST[TueE]";}
	if (isset($_POST['TueNi']) != "") {$CanPlay = "$CanPlay $_POST[TueNi]";}

	if (isset($_POST['WedM']) != "") {$CanPlay = "$CanPlay $_POST[WedM]";}
	if (isset($_POST['WedN']) != "") {$CanPlay = "$CanPlay $_POST[WedN]";}
	if (isset($_POST['WedA']) != "") {$CanPlay = "$CanPlay $_POST[WedA]";}
	if (isset($_POST['WedE']) != "") {$CanPlay = "$CanPlay $_POST[WedE]";}
	if (isset($_POST['WedNi']) != "") {$CanPlay = "$CanPlay $_POST[WedNi]";}

	if (isset($_POST['ThuM']) != "") {$CanPlay = "$CanPlay $_POST[ThuM]";}
	if (isset($_POST['ThuN']) != "") {$CanPlay = "$CanPlay $_POST[ThuN]";}
	if (isset($_POST['ThuA']) != "") {$CanPlay = "$CanPlay $_POST[ThuA]";}
	if (isset($_POST['ThuE']) != "") {$CanPlay = "$CanPlay $_POST[ThuE]";}
	if (isset($_POST['ThuNi']) != "") {$CanPlay = "$CanPlay $_POST[ThuNi]";}


	if (isset($_POST['FriM']) != "") {$CanPlay = "$CanPlay $_POST[FriM]";}
	if (isset($_POST['FriN']) != "") {$CanPlay = "$CanPlay $_POST[FriN]";}
	if (isset($_POST['FriA']) != "") {$CanPlay = "$CanPlay $_POST[FriA]";}
	if (isset($_POST['FriE']) != "") {$CanPlay = "$CanPlay $_POST[FriE]";}
	if (isset($_POST['FriNi']) != "") {$CanPlay = "$CanPlay $_POST[FriNi]";}

	if (isset($_POST['SatM']) != "") {$CanPlay = "$CanPlay $_POST[SatM]";}
	if (isset($_POST['SatN']) != "") {$CanPlay = "$CanPlay $_POST[SatN]";}
	if (isset($_POST['SatA']) != "") {$CanPlay = "$CanPlay $_POST[SatA]";}
	if (isset($_POST['SatE']) != "") {$CanPlay = "$CanPlay $_POST[SatE]";}
	if (isset($_POST['SatNi']) != "") {$CanPlay = "$CanPlay $_POST[SatNi]";}

	if (isset($_POST['SunM']) != "") {$CanPlay = "$CanPlay $_POST[SunM]";}
	if (isset($_POST['SunN']) != "") {$CanPlay = "$CanPlay $_POST[SunN]";}
	if (isset($_POST['SunA']) != "") {$CanPlay = "$CanPlay $_POST[SunA]";}
	if (isset($_POST['SunE']) != "") {$CanPlay = "$CanPlay $_POST[SunE]";}
	if (isset($_POST['SunNi']) != "") {$CanPlay = "$CanPlay $_POST[SunNi]";}


	if ($passworddb == "") {
		echo "Please enter a password.";
	}

	else if (strtolower($name) == 'system') {
	    echo "Sorry, but <strong>$name</strong> is reserved name!";
	}


	else if ($passworddb != $passworddb2) {	echo "Passwords don't match. Please retype the passwords..<br>";	}

	else if ($mail == "") {
		if (REG_MAILVERIFICATION == 1) {	echo "Please enter a valid email. An activation link will be sent to it.<br>"; } else {
				echo "Please enter a valid email. No spam will be sent.<br>";
			}
	}

	else if ( $WesVersion == "") { echo "You must specify which Console(s) you're using...<br>"; }

	else if ($name == "") { echo "Please enter your clan tag."; }

	else if (($length > REG_MAX_NICKLENGTH) || ($length < REG_MIN_NICKLENGTH)) { echo "The name you entered is invalid. It must be ".  REG_MIN_NICKLENGTH ." to ". REG_MAX_NICKLENGTH ." characters long.<br />Please go back to correct the error by selecting a different username."; }

	else if (!preg_match("/^[a-zA-Z0-9\-\_]+$/i", $name)) { echo "You're only allowed to use standard aA-zZ 0-9 alfanumerical characters and the - and _ signs. <br>Please enter a valid WoT clan tag.";	}


	// If we pass the errorchecking this happens:
	else {

	if (REG_MAILVERIFICATION == 1) {
		// Random confirmation code
		$confirm_code=md5(uniqid(rand()));
	} else {
		$confirm_code = "Ok";
		// if we dont have mail confirmation enabled in the config we will "autoverify" the user by setting him to "Ok" in the Confirmation rown in the players table.
	}

	// Lets generate the encrypted pass... we do it by applying the salt and hashing it twice.
	$emailthispass = $passworddb;
	$passworddb = $salt.$passworddb;
	$passworddb = md5($passworddb);
	$passworddb = md5($passworddb);

	$sql="SELECT * FROM $playerstable WHERE name = '$name'";
	$result=mysql_query($sql,$db);
	$samenick = mysql_num_rows($result);

			// If we didnt find a user with the same nick the following happens:

			if ($samenick < 1) {

				if ($approve == 'yes') { $approved = 'no'; }
				else { $approved = 'yes'; }

				if (getenv("HTTP_X_FORWARDED_FOR")) { $ip = getenv("HTTP_X_FORWARD_FOR"); }
				else { $ip = getenv("REMOTE_ADDR"); }

				$sql = "INSERT INTO $playerstable (name, passworddb, mail, country, approved, ip, avatar, HaveVersion, MsgMe, Confirmation, CanPlay) VALUES ('$name', '$passworddb', '$mail', '$_POST[country]', '$approved', '$ip', '$_POST[avatar]', '$WesVersion', '$MsgMeToPlay', '$confirm_code', '$CanPlay')";
				$result = mysql_query($sql);

				if (REG_MAILVERIFICATION == 1) {
					echo "An activation mail has been sent to your mail. To activate your account <b>you must click the link</b> that is within it. <br /><br />If you have not recieved the mail within an hour <b>please check your spam box</b> or contact us.";

					// if suceesfully inserted data into database, send confirmation link to email
					if($result){
						// ---------------- SEND MAIL FORM ----------------

						// send e-mail to ...
						$to = $mail;

						// Your subject
						$subject = "WoT Ladder activation link";

						// Your message
						$body="Welcome to the WoT Ladder . This is your activation mail. \r\n";
						$body.="Click the link below to activate your account: \r\n";
						$body.="http://ladder.subversiva.org/confirmation.php?passkey=$confirm_code \r\n";
						$body.="If it doesnt work you can try to copy & pass it into your browser instead.\r\n";
						$body.="\r\n";
						$body.="Your username and password is: $name / $emailthispass\r\n";
						$body.="Save the info! We can't give it to you if you lose it.\r\n";
						$body.="\r\n";
						$body.="\r\n";
						$body.="As a new player you start with a rating of 1500. That is the average rating that a player who knows the game fairly will have. Players that are new to the game are expected to get a much lower rating after a couple of games, while veterans are expected to get a higher.\r\n";
						$body.="\r\n";
						$body.="Dont quit if you get low rating - it is fully normal and expected while you learn the game, and WoT takes quite some time to master. The rating is, first and foremost, a personal measure to track your own skills for your own sake. Play to have fun and use the ladder as a tool for information. Use it to find players that have about the same skills as you, thats when the game is most fun to play.\r\n";
						$body.="\r\n";
						$body.="\r\n";
						$body.="Please read the FAQ & Rules before you play a ladder game. Also, feel free to contact us if you need help or have suggestions.\r\n";
						$body.="\r\n";
						$body.="See you in the Training Room...\n";

						// send email
						$sentmail = send_mail($to, $body, $subject, $laddermailsender, $titlebar);
					}


				// if not found
				else { echo "Your mail wasn't found in our database."; }

			// if your email succesfully sent
				if($sentmail){}
				else { echo "Failed to send activation link to your e-mail address. Contact admin if the problem remains tomorrow."; }

				} else if ( REG_MAILVERIFICATION == 0) { echo "<br /> <img align='center' src='graphics/activated.jpg' />"; }

			} else { echo "The name you entered already exists. Please select another name."; }


	}
}
else{
?>

<b>Register with your exact clan tag (e.g. 360NA, IMTLS, 7F, 47R). Multiple accounts are forbidden</b>. Clans will share one login to report scores. If you have problems with your account or registration please read the rules & FAQ. Contact us <i>after</i> that if your problems remain. By registering you agree to all the ladder rules.

<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<table border="0" cellpadding="0">
<tr>
<td><p class="text"><b>Clan Tag:</b></p></td>
<td>&nbsp;<input type="Text" name="name" class="text"> (<?php echo REG_MIN_NICKLENGTH . " - " . REG_MAX_NICKLENGTH . " ";?> char, <i>must</i> be same as in the game)</td>
</tr>
<tr>
<td><p class="text"><b>Password:</b></p></td>
<td>&nbsp;<input type="password" name="passworddb" class="text"></td>
</tr>

<tr>
<td><p class="text"><b>Re-type Password:</b></p></td>
<td>&nbsp;<input type="password" name="passworddb2" class="text"></td>

</tr>


<tr>
<td><p class="text"><b>Mail:</b></p></td>
<td>&nbsp;<input type="Text" name="mail" value="" class="text"> <?php if (REG_MAILVERIFICATION == 1) {	echo "Please enter a valid email. An activation link will be sent to it.<br>"; } else {
				echo "Please enter a valid email. No spam will be sent.<br>"; } ?></td>
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
          echo '<option data-class="country" data-style="background-image:url(\'graphics/flags/'.htmlentities($data).'\');" value="'.htmlentities($key).'">'.htmlentities($key)."</option>\n";
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
          echo '<option style="background-image:url(avatars/'.htmlentities($data).');" value="'.htmlentities($data).'">'.htmlentities($key)."</option>\n";
        }
      }
?>
</select></td></tr>


<tr><td><p class="text"><b>My WoT Console:</b></p></td>
<td>&nbsp;<select size="1" name="version" class="text">
<option></option>
<option>XBOX</option>
<option>PS4</option>
<option>Both</option>
</select></td>

<tr><td><p class="text">Msg me to play:</p></td>
<td>&nbsp;<select size="1" name="msgme" class="text">
<option>Yes</option>
<option>No</option>
</select></td>
</table>



<p class="text">I can usually play these times (GMT):</p>
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
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonM" value="MonM" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonN" value="MonN" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonA" value="MonA" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonE" value="MonE" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="MonNi" value="MonG" /></td>
</tr>



<tr>
<td>Tuesday</td>
<td><input type="checkbox" name="TueM" value="TueM" /></td>
<td><input type="checkbox" name="TueN" value="TueN" /></td>
<td><input type="checkbox" name="TueA" value="TueA" /></td>
<td><input type="checkbox" name="TueE" value="TueE" /></td>
<td><input type="checkbox" name="TueNi" value="TueG" /></td>
</tr>


<tr>
<td bgcolor="#E7D9C0">Wednesday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedM" value="WedM" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedN" value="WedN" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedA" value="WedA" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedE" value="WedE" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="WedNi" value="WedG" /></td>
</tr>

<tr>
<td>Thursday</td>
<td><input type="checkbox" name="ThuM" value="ThuM" /></td>
<td><input type="checkbox" name="ThuN" value="ThuN" /></td>
<td><input type="checkbox" name="ThuA" value="ThuA" /></td>
<td><input type="checkbox" name="ThuE" value="ThuE" /></td>
<td><input type="checkbox" name="ThuNi" value="ThuG" /></td>
</tr>

<tr>
<td bgcolor="#E7D9C0">Friday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriM" value="FriM" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriN" value="FriN" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriA" value="FriA" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriE" value="FriE" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="FriNi" value="FriG" /></td>
</tr>

<tr>
<td>Saturday</td>
<td><input type="checkbox" name="SatM" value="SatM" /></td>
<td><input type="checkbox" name="SatN" value="SatN" /></td>
<td><input type="checkbox" name="SatA" value="SatA" /></td>
<td><input type="checkbox" name="SatE" value="SatE" /></td>
<td><input type="checkbox" name="SatNi" value="SatG" /></td>
</tr>

<tr>
<td bgcolor="#E7D9C0">Sunday</td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunM" value="SunM" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunN" value="SunN" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunA" value="SunA" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunE" value="SunE" /></td>
<td bgcolor="#E7D9C0"><input type="checkbox" name="SunNi" value="SunG" /></td>

</table>

<p class="text"><input type="Submit" name="submit" value="Join." class="text"><br><br>
</form>
</p>
<?php
}
require('bottom.php');

function send_mail($to, $body, $subject, $fromaddress, $fromname)
{
  $eol="\r\n";
  $mime_boundary=md5(time());

  # Common Headers
  $headers .= "From: ".$fromname."<".$fromaddress.">".$eol;
  $headers .= "Reply-To: ".$fromname."<".$fromaddress.">".$eol;
  $headers .= "Return-Path: ".$fromname."<".$fromaddress.">".$eol;    // these two to set reply address
  $headers .= "Message-ID: <".time()."-".$fromaddress.">".$eol;
  $headers .= "X-Mailer: Thunderbird".$eol;          // These two to help avoid spam-filters

  # Boundry for marking the split & Multitype Headers
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol.$eol;

  # Open the first part of the mail
  $msg = "--".$mime_boundary.$eol;

  $htmlalt_mime_boundary = $mime_boundary."_htmlalt"; //we must define a different MIME boundary for this section
  # Setup for text OR html -
  $msg .= "Content-Type: multipart/alternative; boundary=\"".$htmlalt_mime_boundary."\"".$eol.$eol;

  # Text Version
  $msg .= "--".$htmlalt_mime_boundary.$eol;
  $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= strip_tags(str_replace("<br>", "\n", substr($body, (strpos($body, "<body>")+6)))).$eol.$eol;

  # HTML Version
  $msg .= "--".$htmlalt_mime_boundary.$eol;
  $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $msg .= $body.$eol.$eol;

  //close the html/plain text alternate portion
  $msg .= "--".$htmlalt_mime_boundary."--".$eol.$eol;



  # Finished
  $msg .= "--".$mime_boundary."--".$eol.$eol;  // finish with two eol's for better security. see Injection.

  # SEND THE EMAIL
  ini_set(sendmail_from,$fromaddress);  // the INI lines are to force the From Address to be used !
  $mail_sent = mail($to, $subject, $msg, $headers);

  ini_restore(sendmail_from);

  return $mail_sent;
}

?>