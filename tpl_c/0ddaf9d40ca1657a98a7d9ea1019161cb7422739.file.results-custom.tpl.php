<?php /* Smarty version Smarty-3.1.7, created on 2014-09-07 18:11:53
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reports/results-custom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:258446950540c91d92054c5-38898484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ddaf9d40ca1657a98a7d9ea1019161cb7422739' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reports/results-custom.tpl',
      1 => 1409936896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '258446950540c91d92054c5-38898484',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Report' => 0,
    'HideSave' => 0,
    'Definition' => 0,
    'column' => 0,
    'showParticipations' => 0,
    'resultType' => 0,
    'training' => 0,
    'rowCss' => 0,
    'row' => 0,
    'cell' => 0,
    'zeroResUsers' => 0,
    'total' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540c91d9dba1b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540c91d9dba1b')) {function content_540c91d9dba1b($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/function.cycle.php';
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
            <?php if ($_smarty_tpl->tpl_vars['showParticipations']->value){?>
                <th>Σύνολο<?php if ($_smarty_tpl->tpl_vars['resultType']->value=='count'){?>(Προπονήσεις)<?php }?></th>
                <th>Κρατήσεις</th>
                <th>Συμμετοχές</th>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['training']->value){?>
                <th>Σύνολο Προπονήσεων</th>
                <th>Private</th>
                <th>Group</th>
            <?php }?>
		<?php } ?>
		</tr>
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
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cell']->value->Value(), ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['zeroResUsers']->value&&$_smarty_tpl->tpl_vars['cell']->value->Value()!==null&&$_smarty_tpl->tpl_vars['resultType']->value=='time'){?>0 hours<?php }?></td>
				<?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['showParticipations']->value){?>
                    <?php if ($_smarty_tpl->tpl_vars['resultType']->value=='count'){?>
                        <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['row']->value['total_owner']+$_smarty_tpl->tpl_vars['row']->value['total_participant'], null, 0);?>
                        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['total_owner']+$_smarty_tpl->tpl_vars['row']->value['total_participant'];?>
 (<?php echo $_smarty_tpl->tpl_vars['row']->value['total_training'];?>
)</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['total_owner'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['total_participant'];?>
</td>
                    <?php }else{ ?>
                        <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['row']->value['totalTime_owner']+$_smarty_tpl->tpl_vars['row']->value['totalTime_participant'], null, 0);?>
                        <td><?php if (TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_owner']+$_smarty_tpl->tpl_vars['row']->value['totalTime_participant'])!=''){?><?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_owner']+$_smarty_tpl->tpl_vars['row']->value['totalTime_participant']);?>
<?php }else{ ?>0 hours<?php }?></td>
                        <td><?php if (TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_owner'])!=''){?><?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_owner']);?>
<?php }else{ ?>0 hours<?php }?></td>
                        <td><?php if (TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_participant'])!=''){?><?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['row']->value['totalTime_participant']);?>
<?php }else{ ?>0 hours<?php }?></td>
                    <?php }?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['training']->value){?>
                    <?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['row']->value['private_training']+$_smarty_tpl->tpl_vars['row']->value['group_training'], null, 0);?>
                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['private_training']+$_smarty_tpl->tpl_vars['row']->value['group_training'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['private_training'];?>
 (-<?php echo $_smarty_tpl->tpl_vars['row']->value['private_training_cancelled'];?>
)</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['group_training'];?>
 (-<?php echo $_smarty_tpl->tpl_vars['row']->value['group_training_cancelled'];?>
)</td>
                <?php }?>
			</tr>
		<?php } ?>
	</table>
	<h4><?php echo $_smarty_tpl->tpl_vars['Report']->value->ResultCount();?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Rows'),$_smarty_tpl);?>

		<?php if ($_smarty_tpl->tpl_vars['Definition']->value->GetTotal()!=''){?>
			| <?php echo $_smarty_tpl->tpl_vars['Definition']->value->GetTotal();?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Total'),$_smarty_tpl);?>

        <?php }else{ ?>
            <?php if ($_smarty_tpl->tpl_vars['showParticipations']->value){?>
                |
                <?php if ($_smarty_tpl->tpl_vars['resultType']->value=='count'){?>
                    <?php echo $_smarty_tpl->tpl_vars['total']->value;?>

                <?php }else{ ?>
                    <?php echo TimeInterval::Parse($_smarty_tpl->tpl_vars['total']->value);?>

                <?php }?>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Total'),$_smarty_tpl);?>

            <?php }?>
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