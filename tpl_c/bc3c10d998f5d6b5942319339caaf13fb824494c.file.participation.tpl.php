<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:16:34
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reservation/participation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4627754115409eff2136238-02256985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc3c10d998f5d6b5942319339caaf13fb824494c' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reservation/participation.tpl',
      1 => 1409936899,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4627754115409eff2136238-02256985',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'IsCoach' => 0,
    'IsAdmin' => 0,
    'checkisTrainingCheckbox' => 0,
    'isCancelledTraining' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409eff218cc8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409eff218cc8')) {function content_5409eff218cc8($_smarty_tpl) {?><div id="reservationParticipation">
	<ul class="no-style">
		<li>
			<label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ParticipantList"),$_smarty_tpl);?>
<br/>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Add'),$_smarty_tpl);?>
 <input type="text" id="participantAutocomplete" class="input" style="width:250px;"/>
				or
				<button id="promptForParticipants" type="button" class="button" style="display:inline">
					<img src="img/user-plus.png"/>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AllUsers'),$_smarty_tpl);?>

				</button>
			</label>

			<div id="participantList">
				<ul/>
			</div>
			<div id="participantDialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddParticipants'),$_smarty_tpl);?>
" class="dialog"></div>
		</li>
    <li>
    <?php if ($_smarty_tpl->tpl_vars['IsCoach']->value||$_smarty_tpl->tpl_vars['IsAdmin']->value){?>
        <div style="height:30px; line-height:30px;" >
            <input type="checkbox" name="isTrainingCheckbox" id="isTrainingCheckbox" <?php if ($_smarty_tpl->tpl_vars['checkisTrainingCheckbox']->value){?>checked="checked"<?php }?> /> <label for="isTrainingCheckbox" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'isTrainingOrTourTitle'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'isTrainingOrTour'),$_smarty_tpl);?>
</label>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['checkisTrainingCheckbox']->value){?>
            <div id="cancel-training-container">
                <input type="checkbox" name="cancel-training" id="cancel-training" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value){?>checked="checked"<?php }?> /> <label for="cancel-training"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTraining'),$_smarty_tpl);?>
</label>
                <div id="cancel-training-hidden-container" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value){?>class="open"<?php }?>>
                    <select name="cancel-training-reason" id="cancel-training-reason" class="pulldown">
                        <option value="weather" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value=='weather'){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTrainingDueToWeather'),$_smarty_tpl);?>
</option>
                        <option value="sickness" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value=='sickness'){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTrainingDueToSickness'),$_smarty_tpl);?>
</option>
                        <option value="match" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value=='match'){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTrainingDueToMatch'),$_smarty_tpl);?>
</option>
                        <option value="other" <?php if ($_smarty_tpl->tpl_vars['isCancelledTraining']->value=='other'){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTrainingDueToOther'),$_smarty_tpl);?>
</option>
                    </select>
                    <input type="checkbox" id="cancel-training-send-sms" name="cancel-training-send-sms" /> <label for="cancel-training-send-sms"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'cancelTrainingSendSms'),$_smarty_tpl);?>
</label>
                </div>
            </div>
            <script type="text/javascript">
                $('#isTrainingCheckbox').change(function(){
                    if(!$(this).is(':checked')){
                        $('#cancel-training').attr('checked', false);
                        $('#cancel-training-hidden-container').removeClass('open');
                    }
                });
                $('#cancel-training').change(function(){
                    if($(this).is(':checked')){
                        $('#cancel-training-hidden-container').addClass('open');
                    }
                    else{
                        $('#cancel-training-hidden-container').removeClass('open');
                    }
                });
            </script>
        <?php }?>
    <?php }?>
    
        
            
        
    
    </li>
	</ul>
    <div id="participationOverLayer">&nbsp;</div>
</div>
<?php }} ?>