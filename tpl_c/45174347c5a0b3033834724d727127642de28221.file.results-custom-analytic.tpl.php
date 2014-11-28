<?php /* Smarty version Smarty-3.1.7, created on 2014-09-08 11:17:46
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reports/results-custom-analytic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1604348831540d824a1ca3d5-14023963%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45174347c5a0b3033834724d727127642de28221' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reports/results-custom-analytic.tpl',
      1 => 1409936896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1604348831540d824a1ca3d5-14023963',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Report' => 0,
    'HideSave' => 0,
    'Definition' => 0,
    'column' => 0,
    'hideTotal' => 0,
    'doubles' => 0,
    'Schedules' => 0,
    'schedule' => 0,
    'first' => 0,
    'rowCss' => 0,
    'row' => 0,
    'cell' => 0,
    'i' => 0,
    'extra_data' => 0,
    'userOnSchedule' => 0,
    'variable' => 0,
    'total' => 0,
    'type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540d824a3c7a6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540d824a3c7a6')) {function content_540d824a3c7a6($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/function.cycle.php';
?><?php if ($_smarty_tpl->tpl_vars['Report']->value->ResultCount()>0){?>
	<div id="report-actions">
		<a href="#" id="btnChart"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"chart.png"),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ViewAsChart'),$_smarty_tpl);?>
</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if (!$_smarty_tpl->tpl_vars['HideSave']->value){?><a href="#" id="btnSaveReportPrompt"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-black.png"),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'SaveThisReport'),$_smarty_tpl);?>
</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php }?><a href="#" id="btnPrint"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"printer.png"),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Print'),$_smarty_tpl);?>
</a>
	</div>
	<table width="100%" id="report-results" chart-type="<?php echo $_smarty_tpl->tpl_vars['Definition']->value->GetChartType();?>
">
		<tr>
		<?php  $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Definition']->value->GetColumnHeaders(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['column']->key => $_smarty_tpl->tpl_vars['column']->value){
$_smarty_tpl->tpl_vars['column']->_loop = true;
?>
			<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['column']->value->TitleKey()),$_smarty_tpl);?>
</th>
            <?php if ($_smarty_tpl->tpl_vars['hideTotal']->value){?>
                <?php break 1?>
            <?php }?>
		<?php } ?>
        <?php if ($_smarty_tpl->tpl_vars['doubles']->value){?>
            <th>Doubles</th>
            <th>Singles</th>
        <?php }else{ ?>
            
            <?php $_smarty_tpl->tpl_vars["first"] = new Smarty_variable("1", null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['schedule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['schedule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Schedules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['schedule']->key => $_smarty_tpl->tpl_vars['schedule']->value){
$_smarty_tpl->tpl_vars['schedule']->_loop = true;
?>
                <th><?php echo $_smarty_tpl->tpl_vars['schedule']->value->GetName();?>
<?php if ($_smarty_tpl->tpl_vars['first']->value=='1'){?><?php $_smarty_tpl->tpl_vars["first"] = new Smarty_variable("0", null, 0);?>(ως συμμετέχοντας)<?php }?></th>
            <?php } ?>
        <?php }?>
		</tr>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable(0, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Report']->value->GetData()->Rows(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
			<?php echo smarty_function_cycle(array('values'=>',alt','assign'=>'rowCss'),$_smarty_tpl);?>

			<tr class="<?php echo $_smarty_tpl->tpl_vars['rowCss']->value;?>
">
				<?php  $_smarty_tpl->tpl_vars['cell'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cell']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Definition']->value->GetRow($_smarty_tpl->tpl_vars['row']->value); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cell']->key => $_smarty_tpl->tpl_vars['cell']->value){
$_smarty_tpl->tpl_vars['cell']->_loop = true;
?>
					<td chart-value="<?php echo $_smarty_tpl->tpl_vars['cell']->value->ChartValue();?>
" chart-column-type="<?php echo $_smarty_tpl->tpl_vars['cell']->value->GetChartColumnType();?>
" chart-group="<?php echo $_smarty_tpl->tpl_vars['cell']->value->GetChartGroup();?>
"><?php if ($_smarty_tpl->tpl_vars['cell']->value->Value()!=''){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cell']->value->Value(), ENT_QUOTES, 'UTF-8', true);?>
<?php }else{ ?>0 hours<?php }?></td>
                    <?php if ($_smarty_tpl->tpl_vars['hideTotal']->value){?>
                        <?php break 1?>
                    <?php }?>
                <?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['doubles']->value){?>
                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value["doubles"];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value["singles"];?>
</td>
                <?php }else{ ?>
                
                 <?php  $_smarty_tpl->tpl_vars['userOnSchedule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['userOnSchedule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['extra_data']->value[$_smarty_tpl->tpl_vars['i']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['userOnSchedule']->key => $_smarty_tpl->tpl_vars['userOnSchedule']->value){
$_smarty_tpl->tpl_vars['userOnSchedule']->_loop = true;
?>
                     <?php $_smarty_tpl->tpl_vars['variable'] = new Smarty_variable($_smarty_tpl->tpl_vars['userOnSchedule']->value->GetData()->Rows(), null, 0);?>
                     <td>
                         <?php if ($_smarty_tpl->tpl_vars['Definition']->value->GetChartType()=='total'){?>
                             <?php if ($_smarty_tpl->tpl_vars['variable']->value[0]["total"]){?><?php echo $_smarty_tpl->tpl_vars['variable']->value[0]["total"];?>
<?php }else{ ?>0<?php }?>
                             <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['variable']->value[0]["total"], null, 0);?>
                             <?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable("count", null, 0);?>
                         <?php }elseif($_smarty_tpl->tpl_vars['Definition']->value->GetChartType()=='totalTime'){?>
                             <?php if ($_smarty_tpl->tpl_vars['variable']->value[0]["totalTime"]){?><?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['variable']->value[0]["totalTime"]);?>
<?php }else{ ?>0 hours<?php }?>
                             <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['variable']->value[0]["totalTime"], null, 0);?>
                             <?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable("time", null, 0);?>
                         <?php }?>
                     </td>
                 <?php } ?>
                <?php }?>
			</tr>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
		<?php } ?>
	</table>
	<h4><?php echo $_smarty_tpl->tpl_vars['Report']->value->ResultCount();?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Rows'),$_smarty_tpl);?>

		<?php if ($_smarty_tpl->tpl_vars['Definition']->value->GetTotal()!=''){?>
			|
            <?php if ($_smarty_tpl->tpl_vars['type']->value){?>
                <?php if ($_smarty_tpl->tpl_vars['type']->value=="count"){?>
                    <?php echo $_smarty_tpl->tpl_vars['total']->value;?>

                <?php }else{ ?>
                    <?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['total']->value);?>

                <?php }?>
            <?php }else{ ?>
                <?php echo $_smarty_tpl->tpl_vars['Definition']->value->GetTotal();?>

            <?php }?>
             <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Total'),$_smarty_tpl);?>

		<?php }?>
	</h4>
<?php }else{ ?>
	<h2 id="report-no-data" class="no-data" style="text-align: center;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'NoResultsFound'),$_smarty_tpl);?>
</h2>

<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$('#report-no-data, #report-results').trigger('loaded');
});
</script><?php }} ?>