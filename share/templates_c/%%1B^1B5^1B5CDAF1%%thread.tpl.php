<?php /* Smarty version 2.6.26, created on 2017-03-03 05:12:47
         compiled from thread.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'thread.tpl', 25, false),)), $this); ?>
<?php echo '
    <script type = "text/javascript">
		function collapse(topic_id) {
		    var topic = $(\'#topic_content_\' + topic_id);
		    if (!topic.html().length) {
			    topic.append($(\'#loader\').css(\'display\', \'block\'));
			    topic.load(
				    \'message.php?action=view_content\', 
					{user: '; ?>
<?php echo $this->_tpl_vars['user']->get_player_id(); ?>
<?php echo ', topic: topic_id},
				    function (){collapse(topic_id);}
				);
			}
			else {
		        topic.slideToggle(600);
				$(\'#loader\').css(\'display\', \'none\');
			}
		}
	</script>
'; ?>

<div class = "message_list thread" style = "margin-top: 0;">
<?php $_from = $this->_tpl_vars['topics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['topic']):
?>
    <?php if (( ! $this->_tpl_vars['topic']->get_deleted_by_sender() && $this->_tpl_vars['user']->get_player_id() == $this->_tpl_vars['topic']->get_sender_id() ) || ( ! $this->_tpl_vars['topic']->get_deleted_by_reciever() && $this->_tpl_vars['user']->get_player_id() == $this->_tpl_vars['topic']->get_reciever_id() ) || $this->_tpl_vars['user']->get_is_admin()): ?>
	    <?php $this->assign('sender', $this->_tpl_vars['topic']->get_sender()); ?>
        <?php $this->assign('reciever', $this->_tpl_vars['topic']->get_reciever()); ?>
	    <div class = "wrapper <?php echo smarty_function_cycle(array('name' => 'lines','values' => "selected,"), $this);?>
" style = "cursor: pointer;" onclick = "javascript: collapse(<?php echo $this->_tpl_vars['topic']->get_id(); ?>
);">
		    <div class = "message_date">
		        <img src = "images/date.png" alt = "[<?php echo $this->_tpl_vars['topic']->get_sent_date(); ?>
]" title = "Sent: <?php echo $this->_tpl_vars['topic']->get_sent_date(); ?>
" />
			</div>
			<div class = "message_user" style = "color: #<?php echo smarty_function_cycle(array('name' => 'users','values' => "909786,B2B9A8"), $this);?>
;">
			    <span>From <?php if ($this->_tpl_vars['topic']->get_signature() != 's'): ?><a style = "color: #909786;" href = "profile.php?name=<?php echo $this->_tpl_vars['sender']->get_name(); ?>
"><?php echo $this->_tpl_vars['sender']->get_name(); ?>
</a><?php else: ?><a href = "/" style = "color: #909786;">System</a><?php endif; ?> to <a style = "color:  #909786;" href = "profile.php?name=<?php echo $this->_tpl_vars['reciever']->get_name(); ?>
"><?php echo $this->_tpl_vars['reciever']->get_name(); ?>
</a>:&nbsp;</span>
			</div>
			<div class = "message_title">
                <?php echo $this->_tpl_vars['topic']->get_topic(); ?>

			</div>
			<div class = "message_view">
                <a href = "message.php?action=view&topic=<?php echo $this->_tpl_vars['topic']->get_id(); ?>
"><img src = "images/view.png" alt = "View message" title = "View message" /></a>
			</div>
        </div>
		<div id = "topic_content_<?php echo $this->_tpl_vars['topic']->get_id(); ?>
" style = "display: none;"></div>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div>
<div style = "clear: both;">
</div>
<?php echo $this->_reg_objects['html_entity'][0]->loader();?>

<?php if ($this->_tpl_vars['topics']): ?>
    <?php echo $this->_reg_objects['html_entity'][0]->paginate($this->_tpl_vars['total'],$this->_tpl_vars['url'],$this->_tpl_vars['items_per_page'],$this->_tpl_vars['is_js']);?>

<?php endif; ?>