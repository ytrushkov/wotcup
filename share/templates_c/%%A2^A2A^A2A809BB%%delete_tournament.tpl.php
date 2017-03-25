<?php /* Smarty version 2.6.26, created on 2017-03-10 02:57:39
         compiled from delete_tournament.tpl */ ?>
<?php if ($this->_tpl_vars['error']): ?>
    <?php echo '
	    {\'error\': \''; ?>
<?php echo $this->_tpl_vars['error']; ?>
<?php echo '\'}
	'; ?>

<?php else: ?>
    <?php echo '
        {\'success\': 1}
    '; ?>

<?php endif; ?>