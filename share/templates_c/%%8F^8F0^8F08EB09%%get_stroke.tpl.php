<?php /* Smarty version 2.6.26, created on 2017-03-03 06:55:22
         compiled from get_stroke.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'get_stroke.tpl', 36, false),)), $this); ?>
<?php if ($this->_tpl_vars['table'] && $this->_tpl_vars['table']->get_tournament_id()): ?>
    <?php $this->assign('winner', $this->_tpl_vars['table']->get_winner()); ?>
    <table class = "stroke" width = "100%">
		<tr>
		    <?php if ($this->_tpl_vars['tournament']->get_type()): ?>
			    <?php $this->assign('td_count', $this->_tpl_vars['table']->get_knock_out_stage_count()); ?>
		    <?php else: ?>
			    <?php $this->assign('participants', $this->_tpl_vars['table']->calculate_places()); ?>
			    <th style = "width: 3%;">
		            &nbsp;
		        </th>
			    <th>
			        &nbsp;
			    </th>
			    <?php unset($this->_sections['key']);
$this->_sections['key']['name'] = 'key';
$this->_sections['key']['loop'] = is_array($_loop=$this->_tpl_vars['participants']['count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['key']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['key']['show'] = true;
$this->_sections['key']['max'] = $this->_sections['key']['loop'];
$this->_sections['key']['start'] = $this->_sections['key']['step'] > 0 ? 0 : $this->_sections['key']['loop']-1;
if ($this->_sections['key']['show']) {
    $this->_sections['key']['total'] = min(ceil(($this->_sections['key']['step'] > 0 ? $this->_sections['key']['loop'] - $this->_sections['key']['start'] : $this->_sections['key']['start']+1)/abs($this->_sections['key']['step'])), $this->_sections['key']['max']);
    if ($this->_sections['key']['total'] == 0)
        $this->_sections['key']['show'] = false;
} else
    $this->_sections['key']['total'] = 0;
if ($this->_sections['key']['show']):

            for ($this->_sections['key']['index'] = $this->_sections['key']['start'], $this->_sections['key']['iteration'] = 1;
                 $this->_sections['key']['iteration'] <= $this->_sections['key']['total'];
                 $this->_sections['key']['index'] += $this->_sections['key']['step'], $this->_sections['key']['iteration']++):
$this->_sections['key']['rownum'] = $this->_sections['key']['iteration'];
$this->_sections['key']['index_prev'] = $this->_sections['key']['index'] - $this->_sections['key']['step'];
$this->_sections['key']['index_next'] = $this->_sections['key']['index'] + $this->_sections['key']['step'];
$this->_sections['key']['first']      = ($this->_sections['key']['iteration'] == 1);
$this->_sections['key']['last']       = ($this->_sections['key']['iteration'] == $this->_sections['key']['total']);
?>
				    <th valign = "bottom">
					    <?php echo $this->_sections['key']['index']+1; ?>

					</th>
				<?php endfor; endif; ?>
				<th style = "width: 3%;" valign = "bottom">
				    Total
				</th>
				<th style = "width: 5%;">
				    Berger Coeff.
				</th>
				<th style = "width: 5%;" valign = "bottom">
				    Place
				</th>
		    <?php endif; ?>
		</tr>
		<?php if (! $this->_tpl_vars['tournament']->get_type()): ?>
	        <?php unset($this->_sections['key1']);
$this->_sections['key1']['name'] = 'key1';
$this->_sections['key1']['loop'] = is_array($_loop=$this->_tpl_vars['participants']['count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['key1']['show'] = true;
$this->_sections['key1']['max'] = $this->_sections['key1']['loop'];
$this->_sections['key1']['step'] = 1;
$this->_sections['key1']['start'] = $this->_sections['key1']['step'] > 0 ? 0 : $this->_sections['key1']['loop']-1;
if ($this->_sections['key1']['show']) {
    $this->_sections['key1']['total'] = $this->_sections['key1']['loop'];
    if ($this->_sections['key1']['total'] == 0)
        $this->_sections['key1']['show'] = false;
} else
    $this->_sections['key1']['total'] = 0;
if ($this->_sections['key1']['show']):

            for ($this->_sections['key1']['index'] = $this->_sections['key1']['start'], $this->_sections['key1']['iteration'] = 1;
                 $this->_sections['key1']['iteration'] <= $this->_sections['key1']['total'];
                 $this->_sections['key1']['index'] += $this->_sections['key1']['step'], $this->_sections['key1']['iteration']++):
$this->_sections['key1']['rownum'] = $this->_sections['key1']['iteration'];
$this->_sections['key1']['index_prev'] = $this->_sections['key1']['index'] - $this->_sections['key1']['step'];
$this->_sections['key1']['index_next'] = $this->_sections['key1']['index'] + $this->_sections['key1']['step'];
$this->_sections['key1']['first']      = ($this->_sections['key1']['iteration'] == 1);
$this->_sections['key1']['last']       = ($this->_sections['key1']['iteration'] == $this->_sections['key1']['total']);
?>
			    <?php $this->assign('count', $this->_tpl_vars['participants']['count'][$this->_sections['key1']['index']]['count']); ?>
				<?php $this->assign('uid1', $this->_tpl_vars['participants']['count'][$this->_sections['key1']['index']]['uid']); ?>
			    <?php $this->assign('participant', $this->_tpl_vars['table']->get_participant_by_id($this->_tpl_vars['uid1'])); ?>
		        <tr <?php echo smarty_function_cycle(array('name' => 'lines','values' => "class='selected',"), $this);?>
>
                    <td style = "border-left: 1px solid #000000;">
				        <?php echo $this->_sections['key1']['rownum']; ?>

				    </td>
				    <td>
				        <a href = "profile.php?name=<?php echo $this->_tpl_vars['participant']->get_name(); ?>
"><?php echo $this->_tpl_vars['participant']->get_name(); ?>
</a>
				    </td>
				    <?php unset($this->_sections['key2']);
$this->_sections['key2']['name'] = 'key2';
$this->_sections['key2']['loop'] = is_array($_loop=$this->_tpl_vars['participants']['count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['key2']['show'] = true;
$this->_sections['key2']['max'] = $this->_sections['key2']['loop'];
$this->_sections['key2']['step'] = 1;
$this->_sections['key2']['start'] = $this->_sections['key2']['step'] > 0 ? 0 : $this->_sections['key2']['loop']-1;
if ($this->_sections['key2']['show']) {
    $this->_sections['key2']['total'] = $this->_sections['key2']['loop'];
    if ($this->_sections['key2']['total'] == 0)
        $this->_sections['key2']['show'] = false;
} else
    $this->_sections['key2']['total'] = 0;
if ($this->_sections['key2']['show']):

            for ($this->_sections['key2']['index'] = $this->_sections['key2']['start'], $this->_sections['key2']['iteration'] = 1;
                 $this->_sections['key2']['iteration'] <= $this->_sections['key2']['total'];
                 $this->_sections['key2']['index'] += $this->_sections['key2']['step'], $this->_sections['key2']['iteration']++):
$this->_sections['key2']['rownum'] = $this->_sections['key2']['iteration'];
$this->_sections['key2']['index_prev'] = $this->_sections['key2']['index'] - $this->_sections['key2']['step'];
$this->_sections['key2']['index_next'] = $this->_sections['key2']['index'] + $this->_sections['key2']['step'];
$this->_sections['key2']['first']      = ($this->_sections['key2']['iteration'] == 1);
$this->_sections['key2']['last']       = ($this->_sections['key2']['iteration'] == $this->_sections['key2']['total']);
?>
					    <?php $this->assign('count', $this->_tpl_vars['participants']['count'][$this->_sections['key2']['index']]['count']); ?>
				        <?php $this->assign('uid2', $this->_tpl_vars['participants']['count'][$this->_sections['key2']['index']]['uid']); ?>
				        <td>
					        <?php if ($this->_tpl_vars['uid2'] == $this->_tpl_vars['uid1']): ?>
							    <img src = "images/square.png" alt = "-" />
							<?php else: ?>
							    <?php $this->assign('the_row', $this->_tpl_vars['table']->get_the_row($this->_tpl_vars['uid1'],$this->_tpl_vars['uid2'])); ?>
								<?php if (! $this->_tpl_vars['the_row']->get_first_result() && ! $this->_tpl_vars['the_row']->get_second_result()): ?>
								    &nbsp;
								<?php else: ?>
								    <div class = "score">
							            <?php if ($this->_tpl_vars['the_row']->get_first_participant() == $this->_tpl_vars['uid1']): ?>
									        <?php echo $this->_tpl_vars['the_row']->get_first_result(); ?>

									    <?php else: ?>
									        <?php echo $this->_tpl_vars['the_row']->get_second_result(); ?>

									    <?php endif; ?>
									</div>
									<div class = "number_of_games_subtitle">
									    game&nbsp;<?php echo $this->_tpl_vars['the_row']->get_played_games(); ?>
&nbsp;of&nbsp;<?php echo $this->_tpl_vars['tournament']->get_games_to_play(); ?>

									</div>
								<?php endif; ?>
							<?php endif; ?>
					    </td>
				    <?php endfor; endif; ?>
					<td>
					    <div class = "score">
						    <?php echo $this->_tpl_vars['participants']['total'][$this->_tpl_vars['uid1']]; ?>

						</div>
					</td>
					<td>
					    <div class = "score">
						    <?php echo $this->_tpl_vars['participants']['bc'][$this->_tpl_vars['uid1']]; ?>

						</div>
					</td>
					<td>
					    <div class = "score">
					        <?php if (! $this->_tpl_vars['winner'] || $this->_tpl_vars['winner']->get_player_id() != -1): ?><?php echo $this->_tpl_vars['participants']['place'][$this->_tpl_vars['uid1']]; ?>
<?php else: ?>-<?php endif; ?>
						</div>
					</td>
				</tr>
		    <?php endfor; endif; ?>
		<?php else: ?>
		    <tr>
		        <td <?php if ($this->_sections['td']['index'] == 0): ?>style = "border-left: 1px solid #000000;"<?php endif; ?>>
			        <table cellpadding = "0" cellspacing = "0">
				        <tr>
					        <?php unset($this->_sections['td']);
$this->_sections['td']['name'] = 'td';
$this->_sections['td']['start'] = (int)0;
$this->_sections['td']['loop'] = is_array($_loop=$this->_tpl_vars['td_count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['td']['show'] = true;
$this->_sections['td']['max'] = $this->_sections['td']['loop'];
$this->_sections['td']['step'] = 1;
if ($this->_sections['td']['start'] < 0)
    $this->_sections['td']['start'] = max($this->_sections['td']['step'] > 0 ? 0 : -1, $this->_sections['td']['loop'] + $this->_sections['td']['start']);
else
    $this->_sections['td']['start'] = min($this->_sections['td']['start'], $this->_sections['td']['step'] > 0 ? $this->_sections['td']['loop'] : $this->_sections['td']['loop']-1);
if ($this->_sections['td']['show']) {
    $this->_sections['td']['total'] = min(ceil(($this->_sections['td']['step'] > 0 ? $this->_sections['td']['loop'] - $this->_sections['td']['start'] : $this->_sections['td']['start']+1)/abs($this->_sections['td']['step'])), $this->_sections['td']['max']);
    if ($this->_sections['td']['total'] == 0)
        $this->_sections['td']['show'] = false;
} else
    $this->_sections['td']['total'] = 0;
if ($this->_sections['td']['show']):

            for ($this->_sections['td']['index'] = $this->_sections['td']['start'], $this->_sections['td']['iteration'] = 1;
                 $this->_sections['td']['iteration'] <= $this->_sections['td']['total'];
                 $this->_sections['td']['index'] += $this->_sections['td']['step'], $this->_sections['td']['iteration']++):
$this->_sections['td']['rownum'] = $this->_sections['td']['iteration'];
$this->_sections['td']['index_prev'] = $this->_sections['td']['index'] - $this->_sections['td']['step'];
$this->_sections['td']['index_next'] = $this->_sections['td']['index'] + $this->_sections['td']['step'];
$this->_sections['td']['first']      = ($this->_sections['td']['iteration'] == 1);
$this->_sections['td']['last']       = ($this->_sections['td']['iteration'] == $this->_sections['td']['total']);
?>
						        <td class = "stage">
				                    <?php $this->assign('stage_pairs', $this->_tpl_vars['table']->get_situation($this->_sections['td']['index']+1)); ?>
									<?php $this->assign('lindex', $this->_sections['td']['index']+1); ?>
				                    <div class = "stroke_col">
									    <?php if (! $this->_tpl_vars['winner'] || $this->_tpl_vars['lindex'] != $this->_tpl_vars['td_count']): ?>
										    <strong>Stage&nbsp;<?php echo $this->_sections['td']['index']+1; ?>
</strong>
										<?php endif; ?>
				                            <?php $_from = $this->_tpl_vars['stage_pairs'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pairs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pairs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row']):
        $this->_foreach['pairs']['iteration']++;
?>
							                    <?php $this->assign('tindex', ($this->_foreach['pairs']['iteration']-1)+1); ?>
					                            <?php $this->assign('p1', $this->_tpl_vars['table']->get_participant_by_id($this->_tpl_vars['row']->get_first_participant())); ?>
						                        <?php $this->assign('p2', $this->_tpl_vars['table']->get_participant_by_id($this->_tpl_vars['row']->get_second_participant())); ?>
											    <?php if (! $this->_tpl_vars['maxh']): ?>
											        <?php $this->assign('maxh', $this->_tpl_vars['stage_pairs'][1]*45); ?>
											    <?php endif; ?>
							                    <?php if ($this->_tpl_vars['stage_pairs'][1]): ?>
											        <?php $this->assign('h', $this->_tpl_vars['maxh']/$this->_tpl_vars['stage_pairs'][1]); ?>
											    <?php else: ?>
											        <?php $this->assign('h', $this->_tpl_vars['maxh']); ?>
											    <?php endif; ?>
												<?php if ($this->_tpl_vars['lindex'] > 1): ?>
												    <?php $this->assign('t', '5'); ?>
												<?php else: ?>
												    <?php $this->assign('t', '0'); ?>
												<?php endif; ?>
						                        <?php if ($this->_tpl_vars['p2']): ?>
							                        <div class = "pair" style = "height: <?php echo $this->_tpl_vars['h']+$this->_tpl_vars['t']+5; ?>
px;">
						                                <div class = "participant_info" style = "height: <?php echo $this->_tpl_vars['h']+$this->_tpl_vars['t']; ?>
px;">
													        <div class = "info">
						                                        <span><a href = "profile.php?name=<?php echo $this->_tpl_vars['p1']->get_name(); ?>
"><?php echo $this->_tpl_vars['p1']->get_name(); ?>
</a></span>
														        <img src = "images/competitors.png" alt = "v/s" />
														        <span><a href = "profile.php?name=<?php echo $this->_tpl_vars['p2']->get_name(); ?>
"><?php echo $this->_tpl_vars['p2']->get_name(); ?>
</a></span>
														    </div>
						                                </div>
									                    <div class = "line">
									                        <div class = "score">
										                        <?php echo $this->_tpl_vars['row']->get_first_result(); ?>
:<?php echo $this->_tpl_vars['row']->get_second_result(); ?>

										                    </div>
									                    </div>
								                    </div>
												    <?php $this->assign('free', 0); ?>
						                       <?php else: ?>
											       <?php if (! $this->_tpl_vars['winner'] || $this->_tpl_vars['lindex'] != $this->_tpl_vars['td_count']): ?>
										               <?php $this->assign('free', $this->_tpl_vars['p1']->get_name()); ?>
												   <?php else: ?>
												       <div class = "participant_info" style = "height: <?php echo $this->_tpl_vars['h']+$this->_tpl_vars['t']; ?>
px;">
										                   <div class = "info">
						                                       <span><strong><a href = "profile.php?name=<?php echo $this->_tpl_vars['p1']->get_name(); ?>
"><?php echo $this->_tpl_vars['p1']->get_name(); ?>
</a></strong></span> is winner!
						                                   </div>
										              </div>
											       <?php endif; ?>
						                       <?php endif; ?>
					                       <?php endforeach; endif; unset($_from); ?>
									       <div class = "free">
						                       <span><?php if ($this->_tpl_vars['free']): ?><a href = "profile.php?name=<?php echo $this->_tpl_vars['free']; ?>
"><?php echo $this->_tpl_vars['free']; ?>
</a> is free<?php else: ?>&nbsp;<?php endif; ?></span>
									       </div>
				                   </div>
				               </td>
			               <?php endfor; endif; ?>
		               </tr>
			       </table>
		       </td>
		   </tr>
		   <script type = "text/javascript">
		       <?php echo '
			       $(\'.line\').each(function(index, elem){
			           $(elem).css({top: -$(elem).prev().height()/2 - $(elem).height() - 5});
			       });
				   $(\'.participant_info .info, .stroke_col\').each(function(index, elem){
			           $(elem).css({top: $(elem).parent().height()/2 - $(elem).height()/2});
			       });
			   '; ?>

		   </script>
		<?php endif; ?>
	</table>
	<?php if ($this->_tpl_vars['winner'] && $this->_tpl_vars['winner']->get_player_id() > 0): ?>
	    <div style = "padding-top: 10px; border-top: 1px solid #000000;">
	        Tournament is finished. <a href = "profile.php?name=<?php echo $this->_tpl_vars['winner']->get_name(); ?>
"><?php echo $this->_tpl_vars['winner']->get_name(); ?>
</a> is winner.
		</div>
	<?php else: ?>
	    <?php if ($this->_tpl_vars['winner'] && $this->_tpl_vars['winner']->get_player_id() == -1): ?>
	        <div style = "padding-top: 10px; border-top: 1px solid #000000;">
	            Tournament is finished. Tie.
		    </div>
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
    Tournament is not played yet!
<?php endif; ?>