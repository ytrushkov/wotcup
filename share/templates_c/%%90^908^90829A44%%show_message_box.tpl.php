<?php /* Smarty version 2.6.26, created on 2017-02-28 19:59:20
         compiled from show_message_box.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'show_message_box.tpl', 50, false),)), $this); ?>
<div class = "column" style = "margin-left: 5%;">
    <?php echo $this->_reg_objects['html_entity'][0]->message_box_menu(1);?>

    <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
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

		<div class = "label">
		    Select player
		</div>
        <div class = "block_select_user block">
            <div>
		        <form action = "" method = "post">
                    <input type = "text" class = "textfield" name = "player" value = "<?php echo $this->_tpl_vars['player']->get_name(); ?>
" onkeyup = "javascript: getUsers(this, $('#players'));" class = "value_list" />
                    <div id = "players" class = "value_list">
                    </div>
				    <input type = "submit" class = "button" value = "Show" />
			    </form>
            </div>
	    </div>
    <?php endif; ?>
	<div class = "label">
        Message box:
	</div>
	<div class = "select_box block">
	    <div <?php if ($this->_tpl_vars['box'] == 'inbox'): ?>class = "selected_item"<?php endif; ?>>
	        <a href = "message.php?action=show_message_box&amp;player=<?php echo $this->_tpl_vars['player']->get_name(); ?>
">Inbox</a>
		</div>
		<div <?php if ($this->_tpl_vars['box'] == 'outbox'): ?>class = "selected_item"<?php endif; ?>>
            <a href = "message.php?action=show_message_box&amp;box=outbox&amp;player=<?php echo $this->_tpl_vars['player']->get_name(); ?>
">Outbox</a>
		</div>
    </div>
</div>
<div class = "column" style = "width: 70%;">
    <form action = "message.php?action=delete_message" method = "post">
        <div class = "message_list">
		    <a href = "message.php?box=<?php echo $this->_tpl_vars['box']; ?>
&amp;player=<?php echo $this->_tpl_vars['player']->get_name(); ?>
&amp;unread=1">Only unread messages</a>
	        &nbsp;|&nbsp;
	        <a href = "message.php?box=<?php echo $this->_tpl_vars['box']; ?>
&amp;player=<?php echo $this->_tpl_vars['player']->get_name(); ?>
">All messages</a>
			<table width = "100%">
            <?php $_from = $this->_tpl_vars['topics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['topic']):
?>
			    <tr <?php echo smarty_function_cycle(array('name' => 'lines','values' => 'class = "selected",'), $this);?>
>
				    <td class = "message_date">
					    <img src = "images/date.png" alt = "[<?php echo $this->_tpl_vars['topic']->get_sent_date(); ?>
]" title = "<?php if ($this->_tpl_vars['box'] == 'outbox'): ?>Sent<?php else: ?>Recieved<?php endif; ?>: <?php echo $this->_tpl_vars['topic']->get_sent_date(); ?>
" />
					</td>
					<td class = "message_user" style = "color: #<?php echo smarty_function_cycle(array('name' => 'users','values' => "909786,B2B9A8"), $this);?>
;">
					    <?php if ($this->_tpl_vars['box'] == 'inbox'): ?>From<?php else: ?>To<?php endif; ?>
						<?php if ($this->_tpl_vars['topic']->get_signature() != 's'): ?>
						    <?php if ($this->_tpl_vars['box'] == 'inbox'): ?><?php echo $this->_tpl_vars['topic']->get_sender()->get_name(); ?>
<?php else: ?><?php echo $this->_tpl_vars['topic']->get_reciever()->get_name(); ?>
<?php endif; ?>
					    <?php else: ?>
						    <a href = "/">System</a>
						<?php endif; ?>
						:&nbsp;
					</td>
                    <td class = "message_title">
                        <?php if (! $this->_tpl_vars['topic']->get_read_date()): ?>
					        <strong>
					    <?php endif; ?>
                        <a href = "message.php?action=view&amp;topic=<?php echo $this->_tpl_vars['topic']->get_id(); ?>
&amp;player=<?php echo $this->_tpl_vars['player']->get_name(); ?>
"><?php echo $this->_tpl_vars['topic']->get_topic(); ?>
</a>
						<?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
					        <?php if (( $this->_tpl_vars['topic']->get_deleted_by_sender() && $this->_tpl_vars['box'] == 'outbox' ) || ( $this->_tpl_vars['topic']->get_deleted_by_reciever() && $this->_tpl_vars['box'] == 'inbox' )): ?>
					            (<img src = "images/deleted.png" alt = "[deleted]" title = "Deleted" class = "deleted" />)
				            <?php endif; ?>
					    <?php endif; ?>
					    <?php if (! $this->_tpl_vars['topic']->get_read_date()): ?>
					        </strong>
					    <?php endif; ?>
                    </td>
                    <td align = "right">
				        <input type = "checkbox" name = "messages[]" value = "<?php echo $this->_tpl_vars['topic']->get_id(); ?>
" /><br />
                    </td>
				</tr>
            <?php endforeach; else: ?>
                <tr>
				    <td>
			            No messages in <strong><?php echo $this->_tpl_vars['box']; ?>
</strong>
                    </td>
				</tr>
            <?php endif; unset($_from); ?>
        </table>
        <input type = "hidden" name = "box" value = "<?php echo $this->_tpl_vars['box']; ?>
" />
		<input type = "hidden" name = "player" value = "<?php echo $this->_tpl_vars['player']->get_name(); ?>
" />
		<div style = "clear: both;">
		</div>
		<?php if ($this->_tpl_vars['topics']): ?>
		    <?php echo $this->_reg_objects['html_entity'][0]->paginate($this->_tpl_vars['total'],$this->_tpl_vars['url'],$this->_tpl_vars['items_per_page']);?>

		<?php endif; ?>
		<hr />
		<div style = "width: 100%; text-align: right;">
            <a href = "javascript: document.forms[<?php if ($this->_tpl_vars['user']->get_is_admin()): ?>1<?php else: ?>0<?php endif; ?>].submit();">Delete selected</a>
		    <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
		        <input type = "checkbox" name = "totally" value = "1" /> from database.
		    <?php endif; ?>
		</div>
    </form>
</div>
<div style = "clear: both;">
</div>