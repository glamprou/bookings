<?php /* Smarty version Smarty-3.1.7, created on 2012-07-09 05:02:42
         compiled from "/home/acetenni/public_html/bookings/tpl/Email/emailheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1023354624ffa3bc28ee7d4-18359391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7264701ebd06d6c06b1796172e6a7d3c1fe5b297' => 
    array (
      0 => '/home/acetenni/public_html/bookings/tpl/Email/emailheader.tpl',
      1 => 1341796931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1023354624ffa3bc28ee7d4-18359391',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Charset' => 0,
    'ScriptUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4ffa3bc290d4d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ffa3bc290d4d')) {function content_4ffa3bc290d4d($_smarty_tpl) {?>
<?php echo '<?xml';?> version="1.0" encoding="<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
"<?php echo '?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
" />
		<style type="text/css">
			@import url(<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
/css/email.css);
		</style>
	</head>
	<body><?php }} ?>