<?php /* Smarty version 2.6.26, created on 2017-03-03 06:55:24
         compiled from get_joined_players.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'get_joined_players.tpl', 3, false),)), $this); ?>
<ul>
    <?php $_from = $this->_tpl_vars['players']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['player']):
?>
        <li <?php echo smarty_function_cycle(array('name' => 'lines','values' => "class = 'selected',"), $this);?>
>
            <a href = "profile.php?name=<?php echo $this->_tpl_vars['player']->get_name(); ?>
"><?php echo $this->_tpl_vars['player']->get_name(); ?>
</a>
        </li>
    <?php endforeach; else: ?>
        No players.
    <?php endif; unset($_from); ?>
</ul>
<div style = "clear: both;">
</div>