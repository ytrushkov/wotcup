<?php
session_start();
session_destroy();
// v 1.01

require('conf/variables.php');
// Set cookies so that they expire.
setcookie ("LadderofWotCup1", $bajs[name], $time-8776000); 
setcookie ("LadderofWotCup2", $bajs[passworddb], $time-8776000); 
require('top.php');  
?>
<h1>Farewell Commander....</h1><br>
<p>You're now logged out. Please <a href="index.php">come back</a> any time - your skills improve, and so does the ladder.</p>
<?php
require('bottom.php');
?>