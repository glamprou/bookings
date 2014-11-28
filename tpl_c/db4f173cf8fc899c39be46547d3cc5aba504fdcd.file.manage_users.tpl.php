<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 22:17:25
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/manage_users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1139827489540a286508d0e1-66959601%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db4f173cf8fc899c39be46547d3cc5aba504fdcd' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Admin/manage_users.tpl',
      1 => 1409936878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1139827489540a286508d0e1-66959601',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FilterStatusId' => 0,
    'statusDescriptions' => 0,
    'Levels' => 0,
    'level' => 0,
    'selectedLevel' => 0,
    'Groupps' => 0,
    'group' => 0,
    'selectedGroup' => 0,
    'users' => 0,
    'rowCss' => 0,
    'user' => 0,
    'Definitions' => 0,
    'AttributeList' => 0,
    'attribute' => 0,
    'PageInfo' => 0,
    'Timezones' => 0,
    'Timezone' => 0,
    'Groups' => 0,
    'resources' => 0,
    'resource' => 0,
    'Path' => 0,
    'ManageGroupsUrl' => 0,
    'ManageReservationsUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540a28653bcd3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540a28653bcd3')) {function content_540a28653bcd3($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/function.html_options.php';
if (!is_callable('smarty_function_cycle')) include '/home/acetenni/public_html/bookings/lib/Common/../../lib/external/Smarty/plugins/function.cycle.php';
?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cssFiles'=>'css/admin.css'), 0);?>


<h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ManageUsers'),$_smarty_tpl);?>
</h1>

<div style="padding: 10px 0px;">
    <table>
        <tr>
            <td><label for="userSearch"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'FindUser'),$_smarty_tpl);?>
:</label></td>
            <td><label for="filterStatusId"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Status'),$_smarty_tpl);?>
:</label></td>
            <td><label for="levelSelection"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Level'),$_smarty_tpl);?>
:</label></td>
            <td><label for="filterStatusId"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Groups'),$_smarty_tpl);?>
:</label></td>
        </tr>
        <tr>
            <td><input type="text" id="userSearch" class="textbox"
                       size="40"/> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_link'][0][0]->PrintLink(array('href'=>$_SERVER['SCRIPT_NAME'],'key'=>'AllUsers'),$_smarty_tpl);?>
</td>
            <td><select id="filterStatusId" class="textbox">
			<?php echo smarty_function_html_options(array('selected'=>$_smarty_tpl->tpl_vars['FilterStatusId']->value,'options'=>$_smarty_tpl->tpl_vars['statusDescriptions']->value),$_smarty_tpl);?>

            </select></td>
            <td>
            	<select id="levelSelection" class="textbox" style="width:50px;">
              	<option value="0">All</option>
            		<?php  $_smarty_tpl->tpl_vars['level'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['level']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Levels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['level']->key => $_smarty_tpl->tpl_vars['level']->value){
$_smarty_tpl->tpl_vars['level']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['selectedLevel']->value==$_smarty_tpl->tpl_vars['level']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['level']->value;?>
</option>
                <?php } ?>         	
							</select>
            </td>
            <td>
            	<select id="grouppSelection" class="textbox">
              	<option value="0">All</option>
            		<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Groupps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['group']->value['grouppid'];?>
" <?php if ($_smarty_tpl->tpl_vars['selectedGroup']->value==$_smarty_tpl->tpl_vars['group']->value['grouppid']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['group']->value['grouppname'];?>
</option>
                <?php } ?>         	
							</select>
            </td>
        </tr>

    </table>
</div>

<table class="list userList">
    <tr>
        <th class="id">&nbsp;</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Name'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Username'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Email'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Phone'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Organization'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Position'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Created'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'LastLogin'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Status'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Permissions'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Groups'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Reservations'),$_smarty_tpl);?>
</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Password'),$_smarty_tpl);?>
</th>
        <th>Φωτογραφία</th>
        <th>Επιλογές</th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
</th>
    </tr>
<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
	<?php echo smarty_function_cycle(array('values'=>'row0,row1','assign'=>'rowCss'),$_smarty_tpl);?>

    <tr class="<?php echo $_smarty_tpl->tpl_vars['rowCss']->value;?>
 editable">
        <td class="id"><input type="hidden" class="id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->Id;?>
"/></td>
        <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['fullname'][0][0]->DisplayFullName(array('first'=>$_smarty_tpl->tpl_vars['user']->value->First,'last'=>$_smarty_tpl->tpl_vars['user']->value->Last,'ignorePrivacy'=>"true"),$_smarty_tpl);?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->Username;?>
</td>
        <td><a href="mailto:<?php echo $_smarty_tpl->tpl_vars['user']->value->Email;?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value->Email;?>
</a></td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->Phone;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->Organization;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->Position;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->DateCreated;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['user']->value->LastLogin;?>
</td>
        <td align="center"><a href="#" class="update changeStatus"><?php echo $_smarty_tpl->tpl_vars['statusDescriptions']->value[$_smarty_tpl->tpl_vars['user']->value->StatusId];?>
</a></td>
        <td align="center"><a href="#" class="update changePermissions"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Edit'),$_smarty_tpl);?>
</a></td>
        <td align="center"><?php echo $_smarty_tpl->tpl_vars['user']->value->group_name;?>
 <a href="#" class="update changeGroups"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Edit'),$_smarty_tpl);?>
</a></td>
        <td align="center"><a href="#" class="update viewReservations"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Search'),$_smarty_tpl);?>
</a></td>
        <td align="center"><a href="#" class="update resetPassword"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Reset'),$_smarty_tpl);?>
</a></td>
        <td align="center"><a href="#" class="update editProfilePhoto" userid="<?php echo $_smarty_tpl->tpl_vars['user']->value->Id;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Edit'),$_smarty_tpl);?>
</a></td>
	<?php if (count($_smarty_tpl->tpl_vars['Definitions']->value)>0){?>
        <td>
            <div class="editable">
                
                <a href="#" class="update changeAttributes"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Edit'),$_smarty_tpl);?>
</a>
            </div>

        </td>
	<?php }?>
        <td align="center"><a href="#" class="update delete"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"cross-button.png"),$_smarty_tpl);?>
</a></td>
      </tr>
      <tr>
		<td class="id" style="display: none;"><input type="hidden" class="id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->Id;?>
"/></td>
		<td colspan="17" style="display: none;" class="<?php echo $_smarty_tpl->tpl_vars['rowCss']->value;?>
 customAttributes" userId="<?php echo $_smarty_tpl->tpl_vars['user']->value->Id;?>
">
			<div class="customAttributes" style="display:block;">
				<p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AdditionalAttributes'),$_smarty_tpl);?>
 <a href="#" class="update changeAttributes"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Edit'),$_smarty_tpl);?>
</a></p>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['AttributeList']->value->GetAttributeValues($_smarty_tpl->tpl_vars['user']->value->Id); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
						<li class="customAttribute" attributeId="<?php echo $_smarty_tpl->tpl_vars['attribute']->value->Id();?>
">
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"AttributeControl",'attribute'=>$_smarty_tpl->tpl_vars['attribute']->value,'readonly'=>true),$_smarty_tpl);?>

						</li>
					<?php } ?>
				</ul>
			</div>

		</td>
	</tr>
<?php } ?>
</table>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['pagination'][0][0]->CreatePagination(array('pageInfo'=>$_smarty_tpl->tpl_vars['PageInfo']->value),$_smarty_tpl);?>


<div class="admin" style="margin-top:30px;">
    <div class="title">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddUser'),$_smarty_tpl);?>

    </div>
    <div>
        <ul>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"addUserEmailformat",'key'=>"ValidEmailRequired"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"addUserUniqueemail",'key'=>"UniqueEmailRequired"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"addUserUsername",'key'=>"UniqueUsernameRequired"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"addAttributeValidator",'key'=>''),$_smarty_tpl);?>

        </ul>
        <form id="addUserForm" method="post">
            <div style="display: table-row">
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Username"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"USERNAME",'class'=>"required textbox",'size'=>"40",'id'=>"addUsername"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Email"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"EMAIL",'class'=>"required textbox",'size'=>"40",'id'=>"addEmail"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"FirstName"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"FIRST_NAME",'class'=>"required textbox",'size'=>"40",'id'=>"addFname"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"LastName"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"LAST_NAME",'class'=>"required textbox",'size'=>"40",'id'=>"addLname"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
            </div>
            <div style="display: table-row">
                <div style="display:none;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Timezone"),$_smarty_tpl);?>
</li>
                        <li>
                            <select <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'TIMEZONE'),$_smarty_tpl);?>
 class="textbox">
							<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['Timezones']->value,'output'=>$_smarty_tpl->tpl_vars['Timezones']->value,'selected'=>$_smarty_tpl->tpl_vars['Timezone']->value),$_smarty_tpl);?>

                            </select>
                        </li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Password"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"PASSWORD",'class'=>"required textbox",'size'=>"40",'id'=>"addPassword"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Phone"),$_smarty_tpl);?>
</li>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"PHONE",'class'=>"textbox",'size'=>"40",'id'=>"addPhone"),$_smarty_tpl);?>
</li>
                    </ul>
                </div>
                <div style="display: table-cell;">
                    <ul>
                        <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Group"),$_smarty_tpl);?>
</li>
                        <li>
                            <select <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'GROUP_ID'),$_smarty_tpl);?>
 class="textbox">
                                <option value=""><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'None'),$_smarty_tpl);?>
</option>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['object_html_options'][0][0]->ObjectHtmlOptions(array('options'=>$_smarty_tpl->tpl_vars['Groups']->value,'label'=>'Name','key'=>'Id'),$_smarty_tpl);?>

                            </select>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="customAttributes">
                <ul>
				<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Definitions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
                    <li class="customAttribute">
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"AttributeControl",'attribute'=>$_smarty_tpl->tpl_vars['attribute']->value,'algin'=>'vertical'),$_smarty_tpl);?>

                    </li>
				<?php } ?>
                </ul>
                <div style="clear:both;"></div>
            </div>

            <button type="button"
                    class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-black.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddUser'),$_smarty_tpl);?>
</button>
            <button type="button" class="button clear"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
        </form>
    </div>
</div>

<input type="hidden" id="activeId"/>

<div id="permissionsDialog" class="dialog" style="display:none;" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Permissions'),$_smarty_tpl);?>
">
    <form id="permissionsForm" method="post">
        <div class="warning"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'UserPermissionInfo'),$_smarty_tpl);?>
</div>
	<?php  $_smarty_tpl->tpl_vars['resource'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['resource']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['resources']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['resource']->key => $_smarty_tpl->tpl_vars['resource']->value){
$_smarty_tpl->tpl_vars['resource']->_loop = true;
?>
        <label><input <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'RESOURCE_ID','multi'=>true),$_smarty_tpl);?>
 class="resourceId" type="checkbox"
                                                             value="<?php echo $_smarty_tpl->tpl_vars['resource']->value->GetResourceId();?>
"> <?php echo $_smarty_tpl->tpl_vars['resource']->value->GetName();?>

        </label><br/>
	<?php } ?>
        <button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"tick-circle.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
</button>
        <button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
    </form>
</div>

<div id="passwordDialog" class="dialog" style="display:none;" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Password'),$_smarty_tpl);?>
">
    <form id="passwordForm" method="post">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Password'),$_smarty_tpl);?>
<br/>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('type'=>"password",'name'=>"PASSWORD",'class'=>"required textbox",'value'=>''),$_smarty_tpl);?>

        <button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-black.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
</button>
        <button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
    </form>
</div>

<div id="userDialog" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
">
    <form id="userForm" method="post">
        <ul>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"emailformat",'key'=>"ValidEmailRequired"),$_smarty_tpl);?>

       		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"uniqueemail",'key'=>"UniqueEmailRequired"),$_smarty_tpl);?>

       		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"uniqueusername",'key'=>"UniqueUsernameRequired"),$_smarty_tpl);?>

        </ul>

        <ul>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Username"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"USERNAME",'class'=>"required textbox",'size'=>"40",'id'=>"username"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Email"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"EMAIL",'class'=>"required textbox",'size'=>"40",'id'=>"email"),$_smarty_tpl);?>
</li>

            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"FirstName"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"FIRST_NAME",'class'=>"required textbox",'size'=>"40",'id'=>"fname"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"LastName"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"LAST_NAME",'class'=>"required textbox",'size'=>"40",'id'=>"lname"),$_smarty_tpl);?>
</li>

            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Timezone"),$_smarty_tpl);?>
</li>
            <li>
                <select <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'TIMEZONE'),$_smarty_tpl);?>
 id='timezone' class="textbox">
				<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['Timezones']->value,'output'=>$_smarty_tpl->tpl_vars['Timezones']->value),$_smarty_tpl);?>

                </select>
            </li>

            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Phone"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"PHONE",'class'=>"textbox",'size'=>"40",'id'=>"phone"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Organization"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"ORGANIZATION",'class'=>"textbox",'size'=>"40",'id'=>"organization"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Position"),$_smarty_tpl);?>
</li>
            <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"POSITION",'class'=>"textbox",'size'=>"40",'id'=>"position"),$_smarty_tpl);?>
</li>
        </ul>

        <button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-black.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
</button>
        <button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
    </form>
</div>

<div id="deleteDialog" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
">
    <form id="deleteUserForm" method="post">
        <div class="error" style="margin-bottom: 25px;">
            <h3><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DeleteWarning'),$_smarty_tpl);?>
</h3>

            <div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DeleteUserWarning'),$_smarty_tpl);?>
</div>
        </div>
        <button type="button" class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"cross-button.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>
</button>
        <button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
    </form>
</div>

<div id="attributeDialog" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AdditionalAttributes'),$_smarty_tpl);?>
">
    <div class="validationSummary">
        <ul><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['async_validator'][0][0]->AsyncValidator(array('id'=>"attributeValidator",'key'=>''),$_smarty_tpl);?>

        </ul>
    </div>

    <div class="customAttributes">
        <form method="post" id="attributesForm">
            <ul>
			<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Definitions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
                <li class="customAttribute">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"AttributeControl",'attribute'=>$_smarty_tpl->tpl_vars['attribute']->value),$_smarty_tpl);?>

                </li>
			<?php } ?>
            </ul>
            <div style="clear:both;"></div>
            <br/>
            <button type="button"
                    class="button save"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"tick-circle.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>
</button>
            <button type="button" class="button cancel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
        </form>
    </div>
</div>

<div id="groupsDialog" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Groups'),$_smarty_tpl);?>
">
    <div id="allUsers" style="display:none;" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AllUsers'),$_smarty_tpl);?>
"></div>

	<div id="groupList" class="hidden">
		<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
			<div class="group-item" groupId="<?php echo $_smarty_tpl->tpl_vars['group']->value->Id;?>
"><a href="#">&nbsp;</a> <span><?php echo $_smarty_tpl->tpl_vars['group']->value->Name;?>
</span></div>
		<?php } ?>
	</div>

	<div id="addedGroups">
	</div>

	<div id="removedGroups">
	</div>
</div>
<div id="profilePhotoDialog">
  <div id="ahsdakjhdksajhd">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="middle">Παρακαλώ περιμένετε</td>
      </tr>
    </table>
  </div>
</div>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"admin-ajax-indicator.gif",'class'=>"indicator",'style'=>"display:none;"),$_smarty_tpl);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/admin/edit.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/admin/user.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery.form-3.09.min.js"></script>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var actions = {
            activate:'<?php echo ManageUsersActions::Activate;?>
',
            deactivate:'<?php echo ManageUsersActions::Deactivate;?>
',
            permissions:'<?php echo ManageUsersActions::Permissions;?>
',
            password:'<?php echo ManageUsersActions::Password;?>
',
            deleteUser:'<?php echo ManageUsersActions::DeleteUser;?>
',
            updateUser:'<?php echo ManageUsersActions::UpdateUser;?>
',
            addUser:'<?php echo ManageUsersActions::AddUser;?>
',
            changeAttributes:'<?php echo ManageUsersActions::ChangeAttributes;?>
'
        };

        var userOptions = {
            userAutocompleteUrl:"../ajax/autocomplete.php?type=<?php echo AutoCompleteType::MyUsers;?>
",
            groupsUrl:'<?php echo $_SERVER['SCRIPT_NAME'];?>
',
			groupManagementUrl:'<?php echo $_smarty_tpl->tpl_vars['ManageGroupsUrl']->value;?>
',
            permissionsUrl:'<?php echo $_SERVER['SCRIPT_NAME'];?>
',
            submitUrl:'<?php echo $_SERVER['SCRIPT_NAME'];?>
',
            saveRedirect:'<?php echo $_SERVER['SCRIPT_NAME'];?>
',
            selectUserUrl:'<?php echo $_SERVER['SCRIPT_NAME'];?>
?uid=',
            filterUrl:'<?php echo $_SERVER['SCRIPT_NAME'];?>
?<?php echo QueryStringKeys::ACCOUNT_STATUS;?>
=',
						filterUrl2:'<?php echo $_SERVER['SCRIPT_NAME'];?>
?lvlsel=',
						filterUrl3:'<?php echo $_SERVER['SCRIPT_NAME'];?>
?grpsel=',
            actions:actions,
            manageReservationsUrl:'<?php echo $_smarty_tpl->tpl_vars['ManageReservationsUrl']->value;?>
'
        };

        var userManagement = new UserManagement(userOptions);
        userManagement.init();

	<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
        var user = {
            id: <?php echo $_smarty_tpl->tpl_vars['user']->value->Id;?>
,
            first:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->First);?>
',
            last:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Last);?>
',
            isActive:'<?php echo $_smarty_tpl->tpl_vars['user']->value->IsActive();?>
',
            username:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Username);?>
',
            email:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Email);?>
',
            timezone:'<?php echo $_smarty_tpl->tpl_vars['user']->value->Timezone;?>
',
            phone:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Phone);?>
',
            organization:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Organization);?>
',
            position:'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['user']->value->Position);?>
'
        };
        userManagement.addUser(user);
	<?php } ?>
        $('.showCustomAttributes').click(function(){
            $('.customAttributes[userId="'+$(this).attr('userid')+'"]').find('.changeAttributes').click();
            $('#attributeDialog').find('.customAttributes').show();
        });

        $('.editProfilePhoto').click(function(){		
            $.ajax({
                type: 'GET',
                url: "../getProfileImage.php",
                data: {
                          userid: $(this).attr('userid')
                      },
                success: function(response) {
                          $('#ahsdakjhdksajhd').html(response);
                      }
                  });
                  $('#profilePhotoDialog').dialog();
                  $('#profilePhotoDialog').dialog('open');
              });
    });
</script>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>