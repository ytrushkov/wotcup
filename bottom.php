<p align="center" class="copyleft">
<?php 
if (isset($cronbottommsg)){
echo "<b>$cronbottommsg</b><br>"; 
}
?>This ladder is not in any way associated with the official World of Tanks Console forum or Wargaming itself.
<br /><a href="<?php echo $GLOBALS['prefix'] ?>ip.php">dupe check</a> / <a href="<?php echo $GLOBALS['prefix'] ?>rss.php">rss</a> / powered by <a href="https://sourceforge.net/projects/gamingladder/?abmode=1">Gaming Ladder</a> <br> <?php echo TRIBAL_VERSION ?> 
Maintained by anubis71 and YTrushkov.<br />
<?php echo "<br />contact: ". FOOTER_MAIL ?>
</p>

<?php
$endtime = microtime();
$endarray = explode(" ", $endtime);
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime;
$totaltime = round($totaltime, 5);
echo "<p align=\"center\" class=\"copyleft\">". date('Y-m-d H:i') ." $cfg_ladder_timezone | ". $totaltime ."sec. </p>";
?>
</div>
<br /><br />
</body>
</html>