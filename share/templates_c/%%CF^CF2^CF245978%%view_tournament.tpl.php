<?php /* Smarty version 2.6.26, created on 2017-03-03 06:55:10
         compiled from view_tournament.tpl */ ?>
<?php echo '
    <script type = "text/javascript">
	    function get_players() {
		    $(\'#joined_players\').load(
			    \'tournament.php?action=get_joined_players\',
				{tid: '; ?>
<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
<?php echo '},
				function() {
				    $(\'#joined_players\').show();
				}
			);
		}
		function get_stroke() {
		    $(\'#loader\').show();
			var l = $(\'#loader\');
		    $(\'#tournament_stroke\').load(
			    \'tournament.php?action=get_stroke\',
				{tid: '; ?>
<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
<?php echo '},
				function() {
				    $(\'#tournament_stroke\').show();
					$(\'#tournament_stroke\').append(l);
					$(\'#loader\').hide();
				}
			);
		}
		function get_valid_games() {
		    $(\'#valid_games\').load(
			    \'tournament.php?action=get_valid_games\',
				{tid: '; ?>
<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
<?php echo '},
				function() {
				    $(\'#valid_games\').show();
				}
			);
		}
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
					    window.location.reload();
					}
				}
			})
		}
	</script>
'; ?>

<?php $this->assign('winner', $this->_tpl_vars['tournament']->get_table()->get_winner()); ?>
<h1><?php echo $this->_tpl_vars['tournament']->get_name(); ?>
</h1>
<table>
    <tr>
	    <td align = "right">
		    <strong>Type:</strong>
		</td>
		<td>
		    <?php echo $this->_tpl_vars['tournament']->get_system_type(); ?>

		</td>
	</tr>
	<tr>
	    <td align = "right">
		    <strong>State:</strong>
		</td>
		<td>
		    <?php echo $this->_tpl_vars['state']['title']; ?>
<?php if ($this->_tpl_vars['user'] && ! $this->_tpl_vars['state']['value'] && ! $this->_tpl_vars['tournament']->is_user_joined($this->_tpl_vars['user']->get_player_id())): ?>&nbsp;(<span id = "join"><a href = "javascript: join_tournament(<?php echo $this->_tpl_vars['tournament']->get_id(); ?>
);" title = "Join the tournament">Sign up&nbsp;<img src = "images/sign_up.png" alt = "Sign up" title = "Sign up" /></a></span>)<?php endif; ?>
		</td>
	</tr>
	<tr>
	    <td align = "right">
		    <strong>Signing up <?php if ($this->_tpl_vars['state']['value'] < 1): ?>will finish<?php else: ?>is finished<?php endif; ?> at:</strong>
		</td>
		<td>
		    <?php echo $this->_tpl_vars['tournament']->get_date('sign_up_ends','.'); ?>

		</td>
	</tr>
	<tr>
	    <td align = "right">
		    <strong>Playing <?php if ($this->_tpl_vars['state']['value'] < 2): ?>will finish<?php else: ?>is finished<?php endif; ?> at:</strong>
		</td>
		<td>
		    <?php echo $this->_tpl_vars['tournament']->get_date('play_ends','.'); ?>

		</td>
	</tr>
	<?php if ($this->_tpl_vars['winner']): ?>
	    <tr>
	        <td align = "right">
		        <strong><?php if ($this->_tpl_vars['winner']->get_player_id() == -1): ?>Tie.<?php else: ?>Winner:<?php endif; ?></strong>
		    </td>
		    <td>
		        <?php if ($this->_tpl_vars['winner']->get_player_id() == -1): ?>Nobody is winner.<?php else: ?><a href = "profile.php?name=<?php echo $this->_tpl_vars['winner']->get_name(); ?>
"><?php echo $this->_tpl_vars['winner']->get_name(); ?>
</a><?php endif; ?>
		    </td>
	    </tr>
	<?php endif; ?>
</table>
<h3>Information</h3>
<pre><?php echo $this->_tpl_vars['tournament']->get_information(); ?>
</pre>
<h3>Rules</h3>
<pre><?php echo $this->_tpl_vars['tournament']->get_rules(); ?>
</pre>
<div class = "list">
    <div class = "list_header" onclick = "javascript: get_players();">
	    <strong>Joined users</strong>&nbsp;(<?php echo $this->_tpl_vars['tournament']->get_joined_participants(); ?>
 of <?php echo $this->_tpl_vars['tournament']->get_max_participants(); ?>
 required)
	</div>
	<div class = "list_content" id = "joined_players">
	</div>
</div>
<div class = "list">
    <div class = "list_header" onclick = "javascript: get_stroke();">
	    <strong>Tournament Stroke</strong>
	</div>
	<div class = "list_content" id = "tournament_stroke">
	    <?php echo $this->_reg_objects['html_entity'][0]->loader("Load...");?>

	</div>
</div>
<?php if ($this->_tpl_vars['user'] && $this->_tpl_vars['tournament']->is_user_joined($this->_tpl_vars['user']->get_player_id()) && $this->_tpl_vars['state']['value'] == 1): ?>
    <div class = "list">
        <div class = "list_header" onclick = "javascript: get_valid_games();">
	        <strong>Report game</strong>
	    </div>
	    <div class = "list_content" id = "valid_games">
	    </div>
    </div>
<?php endif; ?>
<div style = "height: 10px;">
</div>
<a href = "tournament.php?action=list_tournaments">Back to the list</a>