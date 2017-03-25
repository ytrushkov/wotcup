<?php /* Smarty version 2.6.26, created on 2017-03-02 20:24:02
         compiled from view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'view.tpl', 32, false),)), $this); ?>
<?php $this->assign('sender', $this->_tpl_vars['topic']->get_sender()); ?>
<?php $this->assign('reciever', $this->_tpl_vars['topic']->get_reciever()); ?>
<div class = "column" style = "margin-left: 5%;">
    <?php echo $this->_reg_objects['html_entity'][0]->message_box_menu(1);?>

</div>
<div class = "column">
    <div style = "margin-top: 30px; font-size: 12px;">
	    <div>
            <strong>Sender:</strong> <?php if ($this->_tpl_vars['topic']->get_signature() != 's'): ?><a href = "profile.php?name=<?php echo $this->_tpl_vars['sender']->get_name(); ?>
"><?php echo $this->_tpl_vars['sender']->get_name(); ?>
</a><?php else: ?><a href = "/">System</a><?php endif; ?>
		</div>
        <div>
		    <strong>Reciever:</strong> <a href = "profile.php?name=<?php echo $this->_tpl_vars['reciever']->get_name(); ?>
"><?php echo $this->_tpl_vars['reciever']->get_name(); ?>
</a>
		</div>
		<div>
		    Message was sent at <br />
			<i><?php echo $this->_tpl_vars['topic']->get_sent_date(); ?>
</i>
		</div>
	</div>
</div>
<div style = "clear: both;">
</div>
<div class = "message" style = "margin-left: 5%;">
    <div class = "topic">
        <h1><?php echo $this->_tpl_vars['topic']->get_topic(); ?>
</h1>
	</div>

    <div class = "content">
        <pre><?php echo $this->_tpl_vars['message']->get_content(); ?>
</pre>
	</div>
	<?php if ($this->_tpl_vars['topic']->get_signature() != 's'): ?>
	    <div style = "text-align: right;">
	        <a href = "message.php?action=create_message&amp;reciever=<?php echo $this->_tpl_vars['sender']->get_name(); ?>
&amp;topic=<?php echo ((is_array($_tmp=$this->_tpl_vars['topic']->get_topic())) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"><img src = "images/reply.png" alt = "" />Reply</a>
	    </div>
	<?php endif; ?>
	<strong>Thread of topic "<?php echo $this->_tpl_vars['topic']->get_topic(); ?>
":</strong>
	<div class = "thread">
        <?php echo $this->_reg_objects['application'][0]->load_module('topic','thread',$this->_tpl_vars['topic']->get_id());?>

	</div>
<a href = "javascript: history.back();">Back</a>
</div>