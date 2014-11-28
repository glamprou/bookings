<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:16:34
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Controls/Attributes/SelectList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20966413425409eff2195e38-47672442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8e35abcddd974b561a4f9c5a0dcf1733d7b3c31' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Controls/Attributes/SelectList.tpl',
      1 => 1409936911,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20966413425409eff2195e38-47672442',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'attributeName' => 0,
    'attribute' => 0,
    'align' => 0,
    'readonly' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409eff21d317',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409eff21d317')) {function content_5409eff21d317($_smarty_tpl) {?><label class="customAttribute" for="<?php echo $_smarty_tpl->tpl_vars['attributeName']->value;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attribute']->value->Label(), ENT_QUOTES, 'UTF-8', true);?>
</label>
<?php if ($_smarty_tpl->tpl_vars['align']->value=='vertical'){?>
<br/>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['readonly']->value){?>
<span class="attributeValue"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attribute']->value->Value(), ENT_QUOTES, 'UTF-8', true);?>
</span>
<?php }else{ ?>
<select id="<?php echo $_smarty_tpl->tpl_vars['attributeName']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['attributeName']->value;?>
" class="customAttribute textbox">
	<?php if (!$_smarty_tpl->tpl_vars['attribute']->value->Required()){?>
	<option value="">--</option>
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['attribute']->value->PossibleValueList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
	<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['attribute']->value->Value()==$_smarty_tpl->tpl_vars['value']->value){?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
	<?php } ?>
</select>
<?php }?>
<?php }} ?>