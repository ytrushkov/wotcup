<?php
    /*
	*
        * Message section
	*@author Khramkov Ivan.
	* 
	*/
    session_start();
	require 'conf/variables.php';
	require 'conf/config.php';
	require_once 'autologin.inc.php';
	$result = '';
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
	$actions = array(
	    'create_message' => array('message', 'message'),
		'view' => array('message', 'message'),
		'view_content' => array('message', 'message'),
		'delete_message' => array('message', 'message'),
		'thread' => array('topic', 'topic'),
	    'show_message_box' => array('message_box', 'message'),
		'search_message' => array('message_box', 'message'),
		'get_players' => array('user', 'user')
	);
	$_GET['action'] = (isset($_GET['action']))? $_GET['action'] : 'show_message_box';
	$ac_box = $actions[$_GET['action']];
	try {
	    if (isset($ac_box)) {
	        require_once("modules/".$ac_box[1]."/".$ac_box[0].".class.php");
	        eval('$module = new '.first_letter($ac_box[0]).'($config);');
		    $result = $module->run_controller($_GET['action']);// What's the controller returns (HTML, text)...
	    }
	    else {
	        //Smth for default...
		    $result = "Action '<i>".$_GET['action']."</i>' is not specified in the section context...";
	    }
	}
	catch (Exception $e) {
	    $result = $e->getMessage();
	}
	require 'top.php';
    echo $result;
    require_once('bottom.php');
?>