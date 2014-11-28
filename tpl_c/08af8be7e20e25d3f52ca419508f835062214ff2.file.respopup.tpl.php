<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:16:34
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/respopup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10722872955409eff28d05d6-66478200%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08af8be7e20e25d3f52ca419508f835062214ff2' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/respopup.tpl',
      1 => 1409936880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10722872955409eff28d05d6-66478200',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'authorized' => 0,
    'isGame' => 0,
    'rankingName' => 0,
    'opponent1pos' => 0,
    'opponent1name' => 0,
    'opponent2pos' => 0,
    'opponent2name' => 0,
    'hideUserInfo' => 0,
    'fullName' => 0,
    'ownerPhone' => 0,
    'participants' => 0,
    'user' => 0,
    'hideDetails' => 0,
    'title' => 0,
    'summary' => 0,
    'ReservationId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409eff298bd3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409eff298bd3')) {function content_5409eff298bd3($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/modifier.truncate.php';
?><link rel="stylesheet" type="text/css" href="css/popup.css">
<?php if ($_smarty_tpl->tpl_vars['authorized']->value){?>
<div class="res_popup_details" style="margin:0">	
    <?php if ($_smarty_tpl->tpl_vars['isGame']->value){?>
        <div class="rankingGamePopUpTitle">Αγώνας κατάταξης <?php echo $_smarty_tpl->tpl_vars['rankingName']->value;?>
</div>
        <div class="rankingGamePopUpPlr"><b><?php echo $_smarty_tpl->tpl_vars['opponent1pos']->value;?>
.</b> <?php echo $_smarty_tpl->tpl_vars['opponent1name']->value;?>
</div>
        <div class="rankingGamePopUpVS">VS</div>
        <div class="rankingGamePopUpPlr"><b><?php echo $_smarty_tpl->tpl_vars['opponent2pos']->value;?>
.</b> <?php echo $_smarty_tpl->tpl_vars['opponent2name']->value;?>
</div>
    <?php }else{ ?>
        <div class="user">
            <?php if ($_smarty_tpl->tpl_vars['hideUserInfo']->value){?>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Private'),$_smarty_tpl);?>

            <?php }else{ ?>
                <?php echo $_smarty_tpl->tpl_vars['fullName']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['ownerPhone']->value;?>

            <?php }?>
        </div>
        <?php if (!$_smarty_tpl->tpl_vars['hideUserInfo']->value){?>
        <div class="users">
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Participants"),$_smarty_tpl);?>
 (<?php echo count($_smarty_tpl->tpl_vars['participants']->value);?>
)
        <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['participants']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['user']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['user']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
 $_smarty_tpl->tpl_vars['user']->iteration++;
 $_smarty_tpl->tpl_vars['user']->last = $_smarty_tpl->tpl_vars['user']->iteration === $_smarty_tpl->tpl_vars['user']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['participant_loop']['last'] = $_smarty_tpl->tpl_vars['user']->last;
?>
            <?php if (!$_smarty_tpl->tpl_vars['user']->value->IsOwner()){?>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['fullname'][0][0]->DisplayFullName(array('first'=>$_smarty_tpl->tpl_vars['user']->value->FirstName,'last'=>$_smarty_tpl->tpl_vars['user']->value->LastName),$_smarty_tpl);?>

            <?php }?>
            <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['participant_loop']['last']){?>,<?php }?>
        <?php } ?>
        </div>
        <?php }?>
        <?php if (!$_smarty_tpl->tpl_vars['hideDetails']->value){?>
        <div class="title"><?php if ($_smarty_tpl->tpl_vars['title']->value!=''){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ReservationTitle"),$_smarty_tpl);?>
:<br /><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></div>
        <?php }?>
        <?php if (!$_smarty_tpl->tpl_vars['hideDetails']->value){?>
        <div class="summary"><?php if ($_smarty_tpl->tpl_vars['summary']->value!=''){?><?php echo nl2br(smarty_modifier_truncate($_smarty_tpl->tpl_vars['summary']->value,300,"..."));?>
<?php }?></div>
        <?php }?>
        <!-- <?php echo $_smarty_tpl->tpl_vars['ReservationId']->value;?>
 -->
    <?php }?>
</div>
<?php }else{ ?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'InsufficientPermissionsError'),$_smarty_tpl);?>

<?php }?><?php }} ?>