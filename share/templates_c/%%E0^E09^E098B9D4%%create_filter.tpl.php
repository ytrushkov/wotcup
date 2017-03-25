<?php /* Smarty version 2.6.26, created on 2017-03-02 20:41:47
         compiled from create_filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'create_filter.tpl', 19, false),)), $this); ?>
<?php echo '
    <script type = "text/javascript">
	    //<![CDATA[
		    function save_filter() {
		        $.ajax({
			        url: \'tournament.php?action=create_filter\',
				    data: {tablefield: $(\'#tablefield\').val(), value: $(\'#value\').val(), operator: $(\'#operator\').val(), form: 1},
				    success: function() {
					    get_filters();	
					}
				})
		    }
		//]]>
	</script>
'; ?>

<form action = "" method = "post" onsubmit = "javascript: save_filter(); return false;">
    <div class = "wrapper">
        <div>
	        <strong>Field:</strong>&nbsp;<?php echo smarty_function_html_options(array('name' => 'tablefield','id' => 'tablefield','options' => $this->_tpl_vars['fields']), $this);?>
&nbsp;
			<?php echo smarty_function_html_options(array('name' => 'operator','id' => 'operator','options' => $this->_tpl_vars['operators']), $this);?>
&nbsp;
			<strong>Value:</strong>&nbsp;<input type = "text" name = "value" id = "value" />&nbsp;
			<input type = "submit" value = "Save" style = "border: 1px solid #000000;" />
			<br />
			(You can use asterisk * in value field.)
        </div>
    </div>
</form>