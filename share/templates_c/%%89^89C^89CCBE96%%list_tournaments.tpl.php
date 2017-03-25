<?php /* Smarty version 2.6.26, created on 2017-02-28 10:30:48
         compiled from list_tournaments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'list_tournaments.tpl', 70, false),)), $this); ?>
<?php echo '
    <script type = "text/javascript">
	    //<![CDATA[
	    function join_tournament(tid) {
		    $.ajax({
			    url: \'tournament.php?action=join\',
				data: {tid: tid},
				success: function(json) {
				    eval(\'var result = \' + json + \';\');
					if (result.error) {
					    alert(result.error);
					}
					else {
					    $(\'#join_to_\' + tid).html(\'<img src = "images/signed_up.png" alt = "Signed up" title = "Signed up" />\');
					}
				}
			})
		}
		//]]>
'; ?>

<?php if ($this->_tpl_vars['user'] && $this->_tpl_vars['user']->get_is_admin()): ?>
    <?php echo '
		function delete_tournament(tid) {
		    $.ajax({
			    url: \'tournament.php?action=delete_tournament\',
				data: {tid: tid},
				success: function(json) {
				    eval(\'var result = \' + json + \';\');
					if (result.error) {
					    alert(result.error);
					}
					else {
					    window.location.reload();
					}
				}
			})
		}
    '; ?>

<?php endif; ?>
</script>
<div class = "tournament_list">
	<table width = "100%">
	    <tr>
	        <th>
		        &nbsp;
		    </th>
	        <th>
		        Tournament
		    </th>
		    <th>
		        Type
		    </th>
		    <th>
		        Number of participants
		    </th>
		    <th>
		        State
		    </th>
			<?php if ($this->_tpl_vars['user'] && $this->_tpl_vars['user']->get_is_admin()): ?>
			    <th>
				    &nbsp;
				</th>
			    <th>
				    &nbsp;
				</th>
			<?php endif; ?>
		</tr>
        <?php $_from = $this->_tpl_vars['tournaments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tournament']):
?>
		    <?php $this->assign('state', $this->_tpl_vars['tournament']->get_state()); ?>
	        <tr <?php echo smarty_function_cycle(array('name' => 'lines','values' => 'class="selected",'), $this);?>
>
			    <td>
				    <?php echo $this->_tpl_vars['key']+1; ?>

				</td>
			    <td>
				    <a href = "tournament.php?action=view_tournament&amp;tid=<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
"><?php echo $this->_tpl_vars['tournament']->get_name(); ?>
</a>
				</td>
				<td>
				    <?php echo $this->_tpl_vars['tournament']->get_system_type(); ?>

				</td>
				<td>
				    <?php echo $this->_tpl_vars['tournament']->get_joined_participants(); ?>
 of <?php echo $this->_tpl_vars['tournament']->get_max_participants(); ?>

				</td>
				<td align = "center" width = "5%">
			        <div class = "join" id = "join_to_<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
">
					    <?php if ($this->_tpl_vars['user'] && ! $this->_tpl_vars['state']['value']): ?>
						    <?php if ($this->_tpl_vars['tournament']->is_user_joined($this->_tpl_vars['user']->get_player_id())): ?><img src = "images/signed_up.png" alt = "Signed up" title = "Signed up" /><?php else: ?><a href = "javascript: join_tournament(<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
);" title = "Join the tournament"><img src = "images/sign_up.png" alt = "Sign up" title = "Sign up" /></a><?php endif; ?>
						<?php else: ?>
						    <?php if ($this->_tpl_vars['state']['value'] < 2): ?>
							    <img src = "images/playing.png" alt = "Tournament is playing" title = "Tournament is playing" />
							<?php else: ?>
							    <img src = "images/played.png" alt = "Tournament is played" title = "Tournament is played" />
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</td>
				<?php if ($this->_tpl_vars['user'] && $this->_tpl_vars['user']->get_is_admin()): ?>
				    <td align = "right">
				        <a href = "tournament.php?action=create_tournament&amp;tid=<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
" title = "Edit tournament"><img src = "images/edit.png" alt = "[delete]" /></a>
				    </td>
			        <td align = "right">
				        <a href = "javascript: delete_tournament(<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
);" title = "Remove tournament"><img src = "images/deleted.png" alt = "[delete]" /></a>
				    </td>
			    <?php endif; ?>
			</tr>
        <?php endforeach; else: ?>
            <tr>
			    <td>
	                No tournaments!
				</td>
			</tr>
        <?php endif; unset($_from); ?>
	</table>
    <div style = "width: 100%; text-align: right;">
	    <a href = "tournament.php">All tournaments</a>
	    &nbsp;|&nbsp;
	    <a href = "tournament.php?state=<?php echo $this->_tpl_vars['states'][0]; ?>
">New tournaments</a>
	    &nbsp;|&nbsp;
	    <a href = "tournament.php?state=<?php echo $this->_tpl_vars['states'][1]; ?>
">Playing tournaments</a>
	    &nbsp;|&nbsp;
	    <a href = "tournament.php?state=<?php echo $this->_tpl_vars['states'][2]; ?>
">Finished tournaments</a>
	</div>
	<?php if ($this->_tpl_vars['user'] && $this->_tpl_vars['user']->get_is_admin()): ?>
	    <br />
	    <a href = "tournament.php?action=create_tournament" title = "Create a tournament"><img src = "images/add.png" alt = "Create a tournament" />&nbsp;Create a tournament</a>
	<?php endif; ?>
</div>
<div style = "clear: both;">
</div>
<?php if ($this->_tpl_vars['tournaments']): ?>
    <?php echo $this->_reg_objects['html_entity'][0]->paginate($this->_tpl_vars['total'],$this->_tpl_vars['url'],$this->_tpl_vars['items_per_page']);?>

<?php endif; ?>
<hr />
<div style = "clear: both;">
</div>