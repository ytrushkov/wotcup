<?php /* Smarty version 2.6.26, created on 2017-03-02 04:02:00
         compiled from create_message.tpl */ ?>
<?php if ($this->_tpl_vars['sent']): ?>
    Your message is sent! Wait, you will be automatically redirected...
    Click <a href = 'message.php?action=show_message_box'>here</a> to redirect manualy.
    <?php echo $this->_reg_objects['html_entity'][0]->redirect('message.php?action=show_message_box');?>

<?php else: ?>
    <?php echo '
        <script type = "text/javascript">
		    function getUsers(field, dest) {
		    autoComplete(
			    field.value, 
				\'message.php?action=get_players\', 
				dest, 
				field
			);
		}
        </script>
    '; ?>

	<div class = "column" style = "margin-left: 5%;">
	    <?php echo $this->_reg_objects['html_entity'][0]->message_box_menu();?>

	</div>
	<div class = "column" style = "width: auto;">
	    <?php if ($this->_tpl_vars['errors']): ?><div class = "error"><strong><?php echo $this->_tpl_vars['errors']['spam']; ?>
</strong></div><?php endif; ?>
	    <form action="" method = "post">
	        <div class = "block_create_message">
                <div class = "wrapper">
                    <div>
				        <strong>Reciever:</strong>
			        </div>
				    <div class = "block_select_user block">    
                        <input type = "text" name = "reciever" value = "<?php echo $this->_tpl_vars['reciever']->get_name(); ?>
" onkeyup = "javascript: getUsers(this, $('#players'));" class = "value_list" />
                        <div id = "players" class = "value_list"></div>
                        <?php if ($this->_tpl_vars['errors']): ?><div class = "error"><?php echo $this->_tpl_vars['errors']['reciever']; ?>
</div><?php endif; ?>
				    </div>
				</div>
                <div class = "wrapper">
                    <div>
					    <strong>Topic:</strong>
					</div>
					<div class = "block">
					    <input name = "topic" id = "topic" class = "textfield" value = "<?php echo $this->_tpl_vars['topic']; ?>
" maxlength="64" class = "value_list" />
                        <?php if ($this->_tpl_vars['errors']): ?><div class = "error"><?php echo $this->_tpl_vars['errors']['topic']; ?>
</div><?php endif; ?>
					</div>
                </div>
				<div class = "wrapper">
				    <div>
					    <strong>Message:</strong>
					</div>
					<div class = "block">
					    <textarea name = "content"><?php echo $this->_tpl_vars['message']->get_content(); ?>
</textarea>
                        <?php if ($this->_tpl_vars['errors']): ?><div class = "error"><?php echo $this->_tpl_vars['errors']['content']; ?>
</div><?php endif; ?>
					</div>
				</div>
			</div>
            <input name = "form" type = "hidden" value = "1" />
            <input type = "submit" class = "button" value = "Send" />
		    <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
		        <input type = "checkbox" value = "a" name = "admin_sent" /> Send as Admin
		    <?php endif; ?>
        </form>
	</div>
<?php endif; ?>
<div style = "clear: both;">
</div>