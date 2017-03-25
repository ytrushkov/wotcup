<?php /* Smarty version 2.6.26, created on 2017-03-02 20:41:45
         compiled from list_filters.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'list_filters.tpl', 35, false),)), $this); ?>
<?php echo '
    <script type = "text/javascript">
	    //<![CDATA[
		    function show_create_filter_form() {
		        $(\'#filter_form\').load(
			        \'tournament.php?action=create_filter\',
				    function() {
				        $(\'#filter_form\').show();
					    $(\'#create_anchor\').hide();
				    }
			    );
			}
			
			function delete_filter(fid) {
		        $.ajax({
			        url: \'tournament.php?action=delete_filter\',
				    data: {fid: fid},
				    success: function(json) {
				        eval(\'var result = \' + json + \';\');
					    if (result.error) {
					        alert(result.error);
					    }
					    else {
					        get_filters();
					    }
				    }
			    })
		    }
		//]]>
	</script>
'; ?>

<div class = "list">
	<table width = "100%">
        <?php $_from = $this->_tpl_vars['filters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['filter']):
?>
	        <tr <?php echo smarty_function_cycle(array('name' => 'lines','values' => 'class="selected",'), $this);?>
>
			    <td>
				    <input type = "checkbox" name = "filters[]" value = "<?php echo $this->_tpl_vars['filter']->get_id(); ?>
" <?php if ($this->_tpl_vars['filter']->is_applied_to($this->_tpl_vars['tid'])): ?>checked="checked"<?php endif; ?> />&nbsp;
				    <strong><?php echo $this->_tpl_vars['filter']->get_field(); ?>
</strong>&nbsp;
				    <?php echo $this->_tpl_vars['filter']->get_operator(); ?>
&nbsp;
				    <i><?php echo $this->_tpl_vars['filter']->get_value(); ?>
</i>
				</td>
				<td align = "right">
				    <a href = "javascript: delete_filter(<?php echo $this->_tpl_vars['filter']->get_id(); ?>
);" title = "Delete filter"><img src = "images/deleted.png" alt = "[delete]" /></a>
				</td>
			</tr>
        <?php endforeach; else: ?>
            <tr>
			    <td>
	                No filters!
				</td>
			</tr>
        <?php endif; unset($_from); ?>
	</table>
	<a id = "create_anchor" href = "javascript: show_create_filter_form();" title = "Create a filter"><img src = "images/add.png" alt = "Create a filter" />&nbsp;Create a filter</a>
	<div id = "filter_form">
	</div>
</div>
<div style = "clear: both;">
</div>