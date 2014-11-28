<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:28:43
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/Attributes/manage_attributes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10607435655409f2cb05b3b0-07631883%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb4e9c5d3c6079e014b552e6601853d8bdc8bdc1' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/Attributes/manage_attributes.tpl',
      1 => 1409936902,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10607435655409f2cb05b3b0-07631883',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Types' => 0,
    'Path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f2cb194b6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f2cb194b6')) {function content_5409f2cb194b6($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cssFiles'=>'css/admin.css'), 0);?>


<h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'CustomAttributes'),$_smarty_tpl);?>
</h1>

<label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Category'),$_smarty_tpl);?>
:
	<select id="attributeCategory">
		<option value="<?php echo CustomAttributeCategory::RESERVATION;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'CategoryReservation'),$_smarty_tpl);?>
</option>
		<option value="<?php echo CustomAttributeCategory::USER;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'User'),$_smarty_tpl);?>
</option>

		<option value="<?php echo CustomAttributeCategory::RESOURCE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Resource'),$_smarty_tpl);?>
</option>
	</select>
</label>

<a href="#" id="addAttributeButton"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>'plus-circle-frame.png'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddAttribute'),$_smarty_tpl);?>
</a>

<div id="addAttributeDialog" class="dialog attributeDialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddAttribute'),$_smarty_tpl);?>
">

	<form id="addAttributeForm" ajaxAction="<?php echo ManageAttributesActions::AddAttribute;?>
" method="post">
		<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Type'),$_smarty_tpl);?>
:</span>
		<select <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'ATTRIBUTE_TYPE'),$_smarty_tpl);?>
 id="attributeType">
			<option value="<?php echo CustomAttributeTypes::SINGLE_LINE_TEXTBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]),$_smarty_tpl);?>
</option>
			<option value="<?php echo CustomAttributeTypes::MULTI_LINE_TEXTBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::MULTI_LINE_TEXTBOX]),$_smarty_tpl);?>
</option>
			<option value="<?php echo CustomAttributeTypes::SELECT_LIST;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::SELECT_LIST]),$_smarty_tpl);?>
</option>
			<option value="<?php echo CustomAttributeTypes::CHECKBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::CHECKBOX]),$_smarty_tpl);?>
</option>
		</select>

		<div class="textBoxOptions">
			<div class="attributeLabel">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DisplayLabel'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_LABEL','class'=>"required"),$_smarty_tpl);?>

			</div>
			<div class="attributeRequired">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Required'),$_smarty_tpl);?>
:</span>
				<input type="checkbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'ATTRIBUTE_IS_REQUIRED'),$_smarty_tpl);?>
 />
			</div>
			<div class="attributeValidationExpression">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ValidationExpression'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_VALIDATION_EXPRESSION'),$_smarty_tpl);?>

			</div>
			<div class="attributePossibleValues" style="display:none">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'PossibleValues'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_POSSIBLE_VALUES','class'=>"required"),$_smarty_tpl);?>
 <span class="note">(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'CommaSeparated'),$_smarty_tpl);?>
)</span>
			</div>
			<div class="attributeSortOrder">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'SortOrder'),$_smarty_tpl);?>
:</span>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_SORT_ORDER','maxlength'=>3,'width'=>"40px"),$_smarty_tpl);?>

			</div>
		</div>

		<button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"plus-button.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Add'),$_smarty_tpl);?>
</button>
		<button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>

		<input type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'ATTRIBUTE_CATEGORY'),$_smarty_tpl);?>
  id="addCategory" value="" />
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
">
	<form id="deleteForm"  ajaxAction="<?php echo ManageAttributesActions::DeleteAttribute;?>
" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DeleteWarning'),$_smarty_tpl);?>
</h3>
		</div>
		<button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"cross-button.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
</button>
		<button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
	</form>
</div>

<div id="editAttributeDialog" class="dialog attributeDialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'EditAttribute'),$_smarty_tpl);?>
">

	<form id="editAttributeForm" ajaxAction="<?php echo ManageAttributesActions::UpdateAttribute;?>
" method="post">
		<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Type'),$_smarty_tpl);?>
:</span>
		<span class='editAttributeType'
			  id="editType<?php echo CustomAttributeTypes::SINGLE_LINE_TEXTBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::SINGLE_LINE_TEXTBOX]),$_smarty_tpl);?>
</span>
		<span class='editAttributeType'
			  id="editType<?php echo CustomAttributeTypes::MULTI_LINE_TEXTBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::MULTI_LINE_TEXTBOX]),$_smarty_tpl);?>
</span>
		<span class='editAttributeType'
			  id="editType<?php echo CustomAttributeTypes::SELECT_LIST;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::SELECT_LIST]),$_smarty_tpl);?>
</span>
		<span class='editAttributeType'
			  id="editType<?php echo CustomAttributeTypes::CHECKBOX;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['Types']->value[CustomAttributeTypes::CHECKBOX]),$_smarty_tpl);?>
</span>

		<div class="textBoxOptions">
			<div class="attributeLabel">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DisplayLabel'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_LABEL','class'=>"required",'id'=>'editAttributeLabel'),$_smarty_tpl);?>

			</div>
			<div class="attributeRequired">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Required'),$_smarty_tpl);?>
:</span>
				<input type="checkbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'ATTRIBUTE_IS_REQUIRED'),$_smarty_tpl);?>
 id='editAttributeRequired'/>
			</div>
			<div class="attributeValidationExpression">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ValidationExpression'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_VALIDATION_EXPRESSION','id'=>'editAttributeRegex'),$_smarty_tpl);?>

			</div>
			<div class="attributePossibleValues" style="display:none">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'PossibleValues'),$_smarty_tpl);?>
:</span>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_POSSIBLE_VALUES','class'=>"required",'id'=>"editAttributePossibleValues"),$_smarty_tpl);?>
 <span
					class="note">(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'CommaSeparated'),$_smarty_tpl);?>
)</span>
			</div>
			<div class="attributeSortOrder">
				<span class="wideLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'SortOrder'),$_smarty_tpl);?>
:</span>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>'ATTRIBUTE_SORT_ORDER','maxlength'=>3,'width'=>"40px",'id'=>"editAttributeSortOrder"),$_smarty_tpl);?>

			</div>
		</div>

		<button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"tick-circle.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
</button>
		<button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
	</form>
</div>
<div style="clear:both"></div>

<div id="attributeList">
</div>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"admin-ajax-indicator.gif",'class'=>"indicator",'style'=>"display:none;"),$_smarty_tpl);?>


<input type="hidden" id="activeId" value=""/>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/admin/edit.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/admin/attributes.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery.form-3.09.min.js"></script>

<script type="text/javascript">

	$(document).ready(function () {
	var attributeOptions = {
	submitUrl: '<?php echo $_SERVER['SCRIPT_NAME'];?>
',
	changeCategoryUrl: '<?php echo $_SERVER['SCRIPT_NAME'];?>
?<?php echo QueryStringKeys::DATA_REQUEST;?>
=attributes&<?php echo QueryStringKeys::ATTRIBUTE_CATEGORY;?>
=',
	singleLine: '<?php echo CustomAttributeTypes::SINGLE_LINE_TEXTBOX;?>
',
	multiLine: '<?php echo CustomAttributeTypes::MULTI_LINE_TEXTBOX;?>
',
	selectList: '<?php echo CustomAttributeTypes::SELECT_LIST;?>
',
	checkbox: '<?php echo CustomAttributeTypes::CHECKBOX;?>
'
	};

	var attributeManagement = new AttributeManagement(attributeOptions);
	attributeManagement.init();
	});
</script>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>