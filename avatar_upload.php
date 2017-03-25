<?php
session_start();
require('conf/variables.php');
require('top.php');

?>

<p><!DOCTYPE html>
<html>
<body>
<p>Name your file descriptively before you upload it. If it is a logo, it needs at least a clan tag.</p><br>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html></p>

<?php
require('bottom.php');
?>