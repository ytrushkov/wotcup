<?php /* Smarty version 2.6.26, created on 2017-02-28 19:59:20
         compiled from message_box_menu.tpl */ ?>
<div class = "message_box_menu block">
    <div <?php if ($this->_tpl_vars['selected'] == 0): ?>class = "selected_item"<?php endif; ?>>
	    <a href = "message.php?action=create_message">Compose message</a>
	</div>
	<div <?php if ($this->_tpl_vars['selected'] == 1): ?>class = "selected_item"<?php endif; ?>>
        <a href = "message.php?action=show_message_box">Message box</a>
	</div>
	<div <?php if ($this->_tpl_vars['selected'] == 2): ?>class = "selected_item"<?php endif; ?>>
	    <a href = "message.php?action=search_message">Search</a>
	</div>
</div>