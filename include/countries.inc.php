<?php

/*
 * Look through the countries folder for *.bmp files. Print out all the ones we find.
 */

/**
$dh = opendir('graphics/flags');

$countries = array();
while (false !== ($file = readdir($dh))) {
    $filename = substr($file, 0, strrpos($file,'.'));
    $extension = substr($file, strrpos($file,'.'));
    if (strcasecmp($extension, '.bmp') == 0) {
        array_push($countries, $filename);
    }
}

echo "<option>No Country</option>";
sort($countries);
foreach ($countries as $data) {
    if ($data !== "No Country") {
        echo '<option value="'.htmlentities($data).'">'.htmlentities($data)."</option>\n";
    }
}
 */


/**
 *
 * Returns a list of named countries in an array with title => filename pairs
 *
 * Currently avatars can only be bmp files, a small alteration to the code should
 * allow other media types.
 *
 * @param path the path to collect the avatars from, default is avatars
 */
function countriesList($path = 'graphics/flags')
{
	$dh = opendir($path);

        // YTrushkov to support different file extensions
        $allowed_extensions = array('.gif', '.png', '.jpeg', '.jpg', '.bmp');

	$countries = array();
	while (false !== ($file = readdir($dh))) {
	    $filename = substr($file, 0, strrpos($file,'.'));
	    $extension = substr($file, strrpos($file,'.'));
            $extension = strtolower($extension);
	    
            if (in_array($extension, $allowed_extensions)) {
	        $countries[$filename] = $file;
	    } 
	}
	return $countries;
}

?>