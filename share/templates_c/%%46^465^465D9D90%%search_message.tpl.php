<?php /* Smarty version 2.6.26, created on 2017-03-02 04:02:14
         compiled from search_message.tpl */ ?>
<?php if (! $this->_tpl_vars['result']): ?>
<?php echo '
    <script type = "text/javascript">
	    $(function() {
		    $("#init_date").datepicker();
		    $("#last_date").datepicker();
			$(\'input\').change(function() {
		        getResults();
		    });
		    $(\'select\').change(function() {
		        getResults();
		    });
	    });
		
        function getUsers(field, dest) {
		    autoComplete(
			    field.value, 
				\'message.php?action=get_players\', 
				dest, 
				field
			);
		}
		
		function getResults(current_page) {
		    $(\'#search_result\').load(
		        \'message.php?action=search_message\' + \'&amp;p_c_p=\' + ((current_page)? current_page : 0), 
		        {
				    form: 1,
					box: $(\'select[name=box]\').val(),
					goal: $(\'select[name=goal]\').val(),
					fromwhere: $(\'select[name=fromwhere]\').val(),
					status: $(\'select[name=status]\').val(),
					signature: $(\'select[name=signature]\').val(),
					users: $(\'input:text[name=users]\').val(),
					init_date: $(\'input:text[name=init_date]\').val(),
					last_date: $(\'input:text[name=last_date]\').val(),
					text: $(\'input:text[name=text]\').val(),
					'; ?>

					    <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
						    player: $('input:text[name=player]').val(),
							hide_deleted: $('input:checkbox[name=hide_deleted]').val(),
						<?php endif; ?>
					<?php echo '
					all_w: $(\'input:checkbox[name=all_w]\').val()
				},
				function () {
				}
			);
		}
    </script>
'; ?>

<div class = "column" style = "margin-left: 5%;">
    <?php echo $this->_reg_objects['html_entity'][0]->message_box_menu(2);?>

</div>
<div class = "column" style = "width: 70%;">
    <form action="" method = "post" id = "search_form" onsubmit = "javascript: getResults(); return false;">
        <div class = "block_search_message">
            <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
                <div class = "wrapper">
				    <div>
                        <strong>Player</strong>
					</div>
                    <div class = "block_select_user">
                        <input type = "text" name = "player" value = "" onkeyup = "javascript: getUsers(this, $('#players'));" class = "value_list" />
                        <div id = "players" class = "value_list">
                        </div>
                    </div>
				</div>
            <?php endif; ?>
            <div class = "wrapper">
			    <div>
                    <strong>Message box:</strong>
				</div>
				<div>
                    <select name = "box">
                        <option value = "0">Inbox</option>
                        <option value = "1">Outbox</option>
                        <option value = "2">Both: inbox and outbox</option>
                    </select>
				</div>
			</div>
            <div class = "wrapper">
		        <div>
                    <strong>Search in</strong>
				</div>
				<div>
                    <select name = "goal">
                        <option value = "0">Topic</option>
                        <option value = "1">Message Body</option>
                        <option value = "2">Both: topic and message body</option>
                    </select>
				</div>
			</div>
            <div class = "wrapper">
		        <div>
                    <strong>Message status:</strong>
				</div>
				<div>
				    <select name = "status">
                        <option value = "0">Read</option>
                        <option value = "1">Unread</option>
                        <option value = "2" selected="selected">Both: read and unread</option>
                    </select>
				</div>
			</div>
            <div class = "wrapper">
		        <div>
                    <strong>Message signature:</strong>
				</div>
				<div>
				    <select name = "signature">
                        <option value = "u">From user</option>
                        <option value = "a">From admin</option>
                        <option value = "s">System</option>
					    <option value = "w">Warning</option>
					    <option value = "0">Either</option>
                    </select>
				</div>
			</div>
            <div class = "wrapper">
		        <div>
                    <strong>Was</strong>&nbsp;
					<select name = "fromwhere">
					    <option value = "0">Recieved from</option>
						<option value = "1">Sent to</option>
						<option value = "2">Sent to or Recieved from</option>
					</select>
					&nbsp;<strong>the next users:</strong>
				</div>
                <div class = "block_select_user">
				    <input type = "text" name = "users" value = "" onkeyup = "javascript: getUsers(this, $('#users2'));" class = "value_list" />
                    <div id = "users2" class = "value_list">
					</div>
                </div>
            </div>
            <div class = "wrapper">
		        <div>
                    <strong>Sent date:</strong>
				</div>
				<div>
				    Between 
                    <input id = "init_date" type = "text" name = "init_date" value = "<?php echo $this->_tpl_vars['init_date']; ?>
" />
                    and 
                    <input id = "last_date" type = "text" name = "last_date" value = "<?php echo $this->_tpl_vars['last_date']; ?>
" />
				</div>
			</div>
            <div class = "wrapper">
		        <div>
                    <strong>Goal phrase:</strong>
				</div>
				<div>
				    <input type = "text" name = "text" value = "" />
                    <input type = "checkbox" value = "0" name = "all_w" onchange = "javascript: this.value = (this.value == '1')? 0 : 1;" /> Full match
				</div>
			</div>
            <?php if ($this->_tpl_vars['user']->get_is_admin()): ?>
                <div class = "wrapper">
				    <div>
                        <strong>Hide deleted:</strong>
					</div>
					<div>
					    <input type = "checkbox" value = "1" name = "hide_deleted" checked = "checked" onchange = "javascript: this.value = (this.value == '1')? 0 : 1;" />
					</div>
				</div>
            <?php endif; ?>
		</div>
		<div style = "clear: both;">
        </div>
        <input type = "submit" value = "Search" />
    </form>
</div>
<div id = "search_result" style = "width: 100%; font-size: 10px;">
</div>
<?php else: ?>
    <h2 style = "border: 0;">Search Results</h2>
    <?php if ($this->_tpl_vars['results']): ?>
        <div>
            <?php echo $this->_reg_objects['application'][0]->load_module('topic','thread',$this->_tpl_vars['results']);?>

        </div>
    <?php else: ?>
        Nothing's found...
    <?php endif; ?>
<?php endif; ?>
<div style = "clear: both;">
</div>