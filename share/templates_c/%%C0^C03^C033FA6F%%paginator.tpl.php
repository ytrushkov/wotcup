<?php /* Smarty version 2.6.26, created on 2017-03-02 07:04:40
         compiled from paginator.tpl */ ?>
<div class = "paginator">
    <?php if ($this->_tpl_vars['current_page'] > 0): ?>
	    <?php $this->assign('prev', $this->_tpl_vars['current_page']-$this->_tpl_vars['items_per_page']); ?>
	<?php else: ?>
	    <?php $this->assign('prev', 0); ?>
	<?php endif; ?>
    <div>
	    <a href = "<?php echo $this->_tpl_vars['url']; ?>
<?php if ($this->_tpl_vars['is_js_url']): ?>(<?php echo $this->_tpl_vars['prev']; ?>
);<?php else: ?>&amp;p_c_p=<?php echo $this->_tpl_vars['prev']; ?>
<?php endif; ?>" title = "Previous page">&lt;</a>
	</div>
    <?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['page']):
?>
        <div class = "page_number">
	        <?php if ($this->_tpl_vars['current_page'] == $this->_tpl_vars['page']): ?>
			    <strong>
				    <?php echo $this->_tpl_vars['i']; ?>

				</strong>
			<?php else: ?>
	            <a href = "<?php echo $this->_tpl_vars['url']; ?>
<?php if ($this->_tpl_vars['is_js_url']): ?>(<?php echo $this->_tpl_vars['page']; ?>
);<?php else: ?>&amp;p_c_p=<?php echo $this->_tpl_vars['page']; ?>
<?php endif; ?>" title = "Page #<?php echo $this->_tpl_vars['i']; ?>
"><?php echo $this->_tpl_vars['i']; ?>
</a>
		    <?php endif; ?>
	    </div>
    <?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['current_page'] < $this->_tpl_vars['last_page']): ?>
	    <?php $this->assign('next', $this->_tpl_vars['current_page']+$this->_tpl_vars['items_per_page']); ?>
	<?php else: ?>
	    <?php $this->assign('next', $this->_tpl_vars['last_page']); ?>
	<?php endif; ?>
    <div>
	    <a href = "<?php echo $this->_tpl_vars['url']; ?>
<?php if ($this->_tpl_vars['is_js_url']): ?>(<?php echo $this->_tpl_vars['next']; ?>
);<?php else: ?>&amp;p_c_p=<?php echo $this->_tpl_vars['next']; ?>
<?php endif; ?>" title = "Next page">&gt;</a>
	</div>
</div>
<div style = "clear: both;"></div>