<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:28:43
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/Attributes/attribute-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:855916975409f2cbbafd00-88357634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9cf23995d83bb038caca557471b42342b732be32' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/Attributes/attribute-list.tpl',
      1 => 1409936901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '855916975409f2cbbafd00-88357634',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Attributes' => 0,
    'rowCss' => 0,
    'attribute' => 0,
    'Types' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f2cbc62d6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f2cbc62d6')) {function content_5409f2cbc62d6($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/function.cycle.php';
?>
<h3><?php echo count($_smarty_tpl->tpl_vars['Attributes']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Attributes'),$_smarty_tpl);?>
</h3>
<?php if (count($_smarty_tpl->tpl_vars['Attributes']->value)>0){?>
<table class="list">
	<tr>
		<th>ID</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'SortOrder'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DisplayLabel'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Type'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Required'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ValidationExpression'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'PossibleValues'),$_smarty_tpl);?>
</th>
		<th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Attributes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
		<?php echo smarty_function_cycle(array('values'=>'row0,row1','assign'=>'rowCss'),$_smarty_tpl);?>

		<tr class="<?php echo $_smarty_tpl->tpl_vars['rowCss']->value;?>
 editable" attributeId="<?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
">
			<td><?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['attribute']->value->SortOrder();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['attribute']->value->Label();?>
</td>
			<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[$_smarty_tpl->tpl_vars['attribute']->value->Type()]),$_smarty_tpl);?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['attribute']->value->Required()){?>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Yes'),$_smarty_tpl);?>

				<?php }else{ ?>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'No'),$_smarty_tpl);?>

			<?php }?></td>
			<td><?php echo $_smarty_tpl->tpl_vars['attribute']->value->Regex();?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['attribute']->value->PossibleValues();?>
</td>
			<td align="center"><a href="#" class="update delete" attributeId="<?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>'cross-button.png'),$_smarty_tpl);?>
</a></td>
		</tr>
	<?php } ?>
</table>
<?php }?>


<script type="text/javascript">
	var attributeList = new Object();

	<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Attributes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
		attributeList[<?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
] = {
						id: <?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
,
						label: "<?php echo strtr($_smarty_tpl->tpl_vars['attribute']->value->Label(), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",
						required: <?php echo $_smarty_tpl->tpl_vars['attribute']->value->Required();?>
,
						regex: "<?php echo strtr($_smarty_tpl->tpl_vars['attribute']->value->Regex(), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",
						possibleValues: "<?php echo strtr($_smarty_tpl->tpl_vars['attribute']->value->PossibleValues(), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
",
						type: "<?php echo $_smarty_tpl->tpl_vars['attribute']->value->Type();?>
",
						sortOrder: "<?php echo $_smarty_tpl->tpl_vars['attribute']->value->SortOrder();?>
"
					};
	<?php } ?>

	$('#attributeList').data('list', attributeList);
</script><?php }} ?>