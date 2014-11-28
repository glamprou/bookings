{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key='ManageResources'}</h1>
<div>
<table cellpadding="0" cellspacing="0" style="margin-bottom:10px">
	<tr>
    <td style="text-align:left;">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td width="50">{translate key='kairos'}</td>
                <td width="150">
                <select class="textbox" name="clouds_id" id="clouds_id" style="width:150px; height:22px;">
										{foreach from=$clouds item=item}
                    <option value="{$item->id}" {if $item->now eq 1}selected="selected"{/if}>{$item->title}</option>
                    {/foreach}
                </select>
                </td>
                <td width="20"></td>	
                <td width="50">{translate key='aeras'}</td>
                <td width="150">
                <select class="textbox" name="winds_id" id="winds_id" style="width:150px; height:22px;">
                    {foreach from=$winds item=item}
                    <option value="{$item->id}" {if $item->now eq 1}selected="selected"{/if}>{$item->title}</option>
                    {/foreach}
                </select>
                </td>
                <td width="20"></td>
                <td><button class="button save" id="save_weather" type="button"><img alt="" title="" height="16" width="16" src="../img/plus-button.png"> {translate key='save_weather'}</button></a></td>
              </tr>
          </table>
      </td>
  </tr>
</table>
<script type="text/javascript">
	$('#save_weather').click(function(){
		var elem=$(this);
		elem.children('img').attr('src','../img/admin-ajax-indicator.gif');		
		$.ajax({
			type: "POST",
			url: "../ajax/save_weather.php",
			data: {
				clouds_id: $('#clouds_id').val(),
				winds_id:	$('#winds_id').val()
			},
			success: function(){
				elem.children('img').attr('src','../img/plus-button.png');		
			}
		});
	});
</script>
</div>
<div>
	<table border="0" cellspacing="0" cellpadding="0"  style="margin-bottom:10px">
    <tr>
      <td width="260" style="padding-right:10px;">{translate key='deleteedittimebeforeres'}</td>
      <td width="150">
        <select class="textbox" name="hoursbeforeres" id="hoursbeforeres" style="width: 150px; height:22px;">
          <option value="1" {if $hoursbeforeres_val eq 1}selected="selected"{/if}>1 {translate key='hours'}</option>
          <option value="2" {if $hoursbeforeres_val eq 2}selected="selected"{/if}>2 {translate key='hours'}</option>
          <option value="3" {if $hoursbeforeres_val eq 3}selected="selected"{/if}>3 {translate key='hours'}</option>
          <option value="4" {if $hoursbeforeres_val eq 4}selected="selected"{/if}>4 {translate key='hours'}</option>
          <option value="5" {if $hoursbeforeres_val eq 5}selected="selected"{/if}>5 {translate key='hours'}</option>
          <option value="6" {if $hoursbeforeres_val eq 6}selected="selected"{/if}>6 {translate key='hours'}</option>
          <option value="7" {if $hoursbeforeres_val eq 7}selected="selected"{/if}>7 {translate key='hours'}</option>
          <option value="8" {if $hoursbeforeres_val eq 8}selected="selected"{/if}>8 {translate key='hours'}</option>
          <option value="9" {if $hoursbeforeres_val eq 9}selected="selected"{/if}>9 {translate key='hours'}</option>
          <option value="10" {if $hoursbeforeres_val eq 10}selected="selected"{/if}>10 {translate key='hours'}</option>
          <option value="11" {if $hoursbeforeres_val eq 11}selected="selected"{/if}>11 {translate key='hours'}</option>
          <option value="12" {if $hoursbeforeres_val eq 12}selected="selected"{/if}>12 {translate key='hours'}</option>
          <option value="24" {if $hoursbeforeres_val eq 24}selected="selected"{/if}>24 {translate key='hours'}</option>
          <option value="48" {if $hoursbeforeres_val eq 48}selected="selected"{/if}>48 {translate key='hours'}</option>
        </select>
      </td>
      <td width="20"></td>
      <td><button class="button save" id="save_time_for_edit_delete" type="button"><img alt="" title="" height="16" width="16" src="../img/plus-button.png"> {translate key='save_hours'}</button></a></td>
    </tr>
  </table>
<script type="text/javascript">
	$('#save_time_for_edit_delete').click(function(){
		var elem=$(this);
		elem.children('img').attr('src','../img/admin-ajax-indicator.gif');		
		$.ajax({
			type: "POST",
			url: "../ajax/save_hours.php",
			data: {
				hours: $('#hoursbeforeres').val()
			},
			success: function(){
				elem.children('img').attr('src','../img/plus-button.png');		
			}
		});
	});
</script>
</div>
<div id="globalError" class="error" style="display:none"></div>
<div class="admin">
	<div class="title">
	{translate key='AllResources'}
	</div>
{foreach from=$Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails" resourceId="{$id}">
		<div style="float:left;max-width:50%;">
			<input type="hidden" class="id" value="{$id}"/>

			<div style="float:left; text-align:center; width:110px; display:none;">
				{if $resource->HasImage()}
					<img src="{resource_image image=$resource->GetImage()}" alt="Resource Image" class="image"/><br/>
					<a class="update imageButton" href="javascript: void(0);">{translate key='Change'}</a> |
					<a class="update removeImageButton" href="javascript: void(0);">{translate key='Remove'}</a>
					{else}
					<div class="noImage">{translate key='NoImage'}</div>
					<a class="update imageButton" href="javascript: void(0);">{translate key='AddImage'}</a>
				{/if}
			</div>
			<div style="float:right;">
				<ul>
					<li>
						<h4>{$resource->GetName()|escape}</h4>
						<a class="update renameButton" href="javascript:void(0);">{translate key='Rename'}</a> |
						<a class="update deleteButton" href="javascript:void(0);">{translate key='Delete'}</a>
					</li>
					<li>
						{translate key='Status'}
						{if $resource->IsOnline()}
							{html_image src="status.png"} <a class="update takeOfflineButton"
															 href="javascript: void(0);">{translate key='TakeOffline'}</a>
							{else}
							{html_image src="status-busy.png"} <a class="update bringOnlineButton"
																  href="javascript: void(0);">{translate key='BringOnline'}</a>
						{/if}

					</li>

					<li>
						{translate key='AppearsOn' args=$Schedules[$resource->GetScheduleId()]} {translate key='Schedule'}
						<a class="update changeScheduleButton" href="javascript: void(0);">{translate key='Move'}</a>
					</li>
					<li>
						{translate key=SortOrder}
						{$resource->GetSortOrder()|default:"-"}
						<a class="update changeSortOrder" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li style="display:none;">
						{translate key='Location'}
						{if $resource->HasLocation()}
							{$resource->GetLocation()}
							{else}
							<span class="note">{translate key='NoLocationLabel'}</span>
						{/if}
						<a class="update changeLocationButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li style="display:none;">
						{translate key='Contact'}
						{if $resource->HasContact()}
							{$resource->GetContact()}
							{else}
							<span class="note">{translate key='NoContactLabel'}</span>
						{/if}
					</li>
					<li style="display:none;">
						{translate key='Description'}
						{if $resource->HasDescription()}
							{$resource->GetDescription()|truncate:500:"..."}
							{else}
							<span class="note">{translate key='NoDescriptionLabel'}</span>
						{/if}
						<a class="update descriptionButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li style="display:none;">
						{translate key='Notes'}
						{if $resource->HasNotes()}
							{$resource->GetNotes()|truncate:500:"..."}
							{else}
							<span class="note">{translate key='NoNotesLabel'}</span>
						{/if}
						<a class="update notesButton" href="javascript: void(0);">{translate key='Edit'}</a>
					</li>
					<li style="display:none;">
						{translate key='ResourceAdministrator'}
						{if $resource->HasAdminGroup()}
							{$GroupLookup[$resource->GetAdminGroupId()]->Name}
							{else}
							<span class="note">{translate key='NoResourceAdministratorLabel'}</span>
						{/if}
						{if $AdminGroups|count > 0}
							<a class="update adminButton" href="javascript: void(0);">{translate key='Edit'}</a>
						{/if}
					</li>
					<li style="display:none;">
						{if $resource->GetIsCalendarSubscriptionAllowed()}
							<a class="update disableSubscription"
							   href="javascript: void(0);">{translate key=TurnOffSubscription}</a>
							{else}
							<a class="update enableSubscription"
							   href="javascript: void(0);">{translate key=TurnOnSubscription}</a>
						{/if}
					</li>
				</ul>
			</div>
		</div>
		<div style="float:right">
			<div>
				<h5>{translate key='UsageConfiguration'}</h5> <a class="update changeConfigurationButton"
																 href="javascript: void(0);">{translate key='ChangeConfiguration'}</a>
			</div>
			<div style="float:left;width:300px;">
				<ul>
					<li>
						{if $resource->HasMinLength()}
							{translate key='ResourceMinLength' args=$resource->GetMinLength()}
						{else}
							{translate key='ResourceMinLengthNone'}
						{/if}
					</li>
					<li>
						{if $resource->HasMaxLength()}
							{translate key='ResourceMaxLength' args=$resource->GetMaxLength()}
						{else}
							{translate key='ResourceMaxLengthNone'}
						{/if}
					</li>
					<li>
						{if $resource->GetRequiresApproval()}
							{translate key='ResourceRequiresApproval'}
						{else}
							{translate key='ResourceRequiresApprovalNone'}
						{/if}
					</li>
					<li>
						{if $resource->GetAutoAssign()}
							{translate key='ResourcePermissionAutoGranted'}
						{else}
							{translate key='ResourcePermissionNotAutoGranted'}
						{/if}
					</li>
				</ul>
			</div>

			<div style="float:right;width:300px;">
				<ul>
					<li>
						{if $resource->HasMinNotice()}
						{translate key='ResourceMinNotice' args=$resource->GetMinNotice()}
					{else}
						{translate key='ResourceMinNoticeNone'}
					{/if}
					</li>
					<li>
						{if $resource->HasMaxNotice()}
						{translate key='ResourceMaxNotice' args=$resource->GetMaxNotice()}
					{else}
						{translate key='ResourceMaxNoticeNone'}
					{/if}
					</li>
					<li>
						{if $resource->GetAllowMultiday()}
						{translate key='ResourceAllowMultiDay'}
					{else}
						{translate key='ResourceNotAllowMultiDay'}
					{/if}
					</li>
					<li>
						{if $resource->HasMaxParticipants()}
						{translate key='ResourceCapacity' args=$resource->GetMaxParticipants()}
					{else}
						{translate key='ResourceCapacityNone'}
					{/if}
					</li>
				</ul>
			</div>
		</div>
		{if $Definitions|count > 0}
			<div class="customAttributes">
				<h3>{translate key=AdditionalAttributes} <a href="#"
															class="update changeAttributes">{translate key=Edit}</a>
				</h3>
				<ul>
					{foreach from=$AttributeList->GetAttributeValues($id) item=attribute}
						<li class="customAttribute" attributeId="{$attribute->Id()}">
							{control type="AttributeControl" attribute=$attribute readonly=true}
						</li>
					{/foreach}
				</ul>
			</div>
			<div style="clear:both;">&nbsp;</div>
		{/if}
		<div class="actions">&nbsp;</div>
	</div>
{/foreach}
</div>


<div class="admin" style="margin-top:30px">
	<div class="title">
	{translate key='AddNewResource'}
	</div>
	<div>
		<div id="addResourceResults" class="error" style="display:none;"></div>
		<form id="addResourceForm" method="post">
			<table>
				<tr>
					<th>{translate key='Name'}</th>
					<th>{translate key='Schedule'}</th>
					<th>{translate key='ResourcePermissions'}</th>
					<th style="display:none;">{translate key='ResourceAdministrator'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" class="textbox required" maxlength="85"
							   style="width:250px" {formname key=RESOURCE_NAME} />
					</td>
					<td>
						<select class="textbox" {formname key=SCHEDULE_ID} style="width:100px">
						{foreach from=$Schedules item=scheduleName key=scheduleId}
							<option value="{$scheduleId}">{$scheduleName}</option>
						{/foreach}
						</select>
					</td>
					<td>
						<select class="textbox" {formname key=AUTO_ASSIGN} style="width:170px">
							<option value="0">{translate key="None"}</option>
							<option value="1">{translate key="AllUsers"}</option>
						</select>
					</td>
					<td style="display:none;">
						<select class="textbox" {formname key=RESOURCE_ADMIN_GROUP_ID} style="width:170px">
							<option value="">{translate key=None}</option>
						{foreach from=$AdminGroups item=adminGroup}
							<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
						{/foreach}
						</select>
					</td>
					<td>
						<button type="button"
								class="button save">{html_image src="plus-button.png"} {translate key='AddResource'}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value=""/>

<div id="imageDialog" class="dialog" style="display:none;" title="{translate key=AddImage}">
	<form id="imageForm" method="post" enctype="multipart/form-data">
		<input id="resourceImage" type="file" class="text" size="60" {formname key=RESOURCE_IMAGE} />
		<br/>
		<span class="note">.gif, .jpg, or .png</span>
		<br/><br/>
		<button type="button"
				class="button uploadImage">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;" title="{translate key=Rename}">
	<form id="renameForm" method="post">
	{translate key='Name'}: <input id="editName" type="text" class="textbox required" maxlength="85"
								   style="width:250px" {formname key=RESOURCE_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Rename'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="scheduleDialog" class="dialog" style="display:none;" title="{translate key=MoveToSchedule}">
	<form id="scheduleForm" method="post">
	{translate key=MoveToSchedule}:
		<select id="editSchedule" class="textbox" {formname key=SCHEDULE_ID}>
		{foreach from=$Schedules item=scheduleName key=scheduleId}
			<option value="{$scheduleId}">{$scheduleName}</option>
		{/foreach}
		</select>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="locationDialog" class="dialog" style="display:none;" title="{translate key=Location}">
	<form id="locationForm" method="post">
	{translate key=Location}:<br/>
		<input id="editLocation" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_LOCATION} /><br/>
	{translate key=Contact}:<br/>
		<input id="editContact" type="text" class="textbox" maxlength="85"
			   style="width:250px" {formname key=RESOURCE_CONTACT} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="descriptionDialog" class="dialog" style="display:none;" title="{translate key=Description}">
	<form id="descriptionForm" method="post">
	{translate key=Description}:<br/>
		<textarea id="editDescription" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="notesDialog" class="dialog" style="display:none;" title="{translate key=Notes}">
	<form id="notesForm" method="post">
	{translate key=Notes}:<br/>
		<textarea id="editNotes" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_NOTES}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="configurationDialog" class="dialog" style="display:none;" title="{translate key=UsageConfiguration}">
	<form id="configurationForm" method="post">
		<div style="margin-bottom: 10px;">
			<fieldset>
				<legend>{translate key=Duration}</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="noMinimumDuration"/> {translate key=ResourceMinLengthNone}
						</label>
						<span class="noMinimumDuration">
							<br/>
						{capture name="txtMinDuration" assign="txtMinDuration"}
							<input type='text' id='minDurationDays' size='3' class='days textbox' maxlength='3'/>
							<input type='text' id='minDurationHours' size='2' class='hours textbox' maxlength='2'/>
							<input type='text' id='minDurationMinutes' size='2' class='minutes textbox' maxlength='2'/>
							<input type='hidden' id='minDuration' class='interval' {formname key=MIN_DURATION} />
						{/capture}
						{translate key='ResourceMinLength' args=$txtMinDuration}
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noMaximumDuration"/> {translate key=ResourceMaxLengthNone}
						</label>
						<span class="noMaximumDuration">
							<br/>
						{capture name="txtMaxDuration" assign="txtMaxDuration"}
							<input type='text' id='maxDurationDays' size='3' class='days textbox' maxlength='3'/>
							<input type='text' id='maxDurationHours' size='2' class='hours textbox' maxlength='2'/>
							<input type='text' id='maxDurationMinutes' size='2' class='minutes textbox' maxlength='2'/>
							<input type='hidden' id='maxDuration' class='interval' {formname key=MAX_DURATION} />
						{/capture}
						{translate key=ResourceMaxLength args=$txtMaxDuration}
						</span>
					</li>
					<li>
					{translate key=ResourceAllowMultiDay}
						<select id="allowMultiday" class="textbox" {formname key=ALLOW_MULTIDAY}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>{translate key=Access}</legend>
				<ul>
					<li>
					{translate key='ResourceRequiresApproval'}
						<select id="requiresApproval" class="textbox" {formname key=REQUIRES_APPROVAL}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
					<li>
					{translate key='ResourcePermissionAutoGranted'}
						<select id="autoAssign" class="textbox" {formname key=AUTO_ASSIGN}>
							<option value="1">{translate key='Yes'}</option>
							<option value="0">{translate key='No'}</option>
						</select>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noStartNotice"/> {translate key='ResourceMinNoticeNone'}
						</label>
						<span class="noStartNotice">
							<br/>
						{capture name="txtStartNotice" assign="txtStartNotice"}
							<input type='text' id='startNoticeDays' size='3' class='days textbox' maxlength='3'/>
							<input type='text' id='startNoticeHours' size='2' class='hours textbox' maxlength='2'/>
							<input type='text' id='startNoticeMinutes' size='2' class='minutes textbox' maxlength='2'/>
							<input type='hidden' id='startNotice' class='interval' {formname key=MIN_NOTICE} />
						{/capture}
						{translate key='ResourceMinNotice' args=$txtStartNotice}
						</span>
					</li>
					<li>
						<label>
							<input type="checkbox" id="noEndNotice"/> {translate key='ResourceMaxNoticeNone'}
						</label>					
						<span class="noEndNotice">
							<br/>
						{capture name="txtEndNotice" assign="txtEndNotice"}
							<input type='text' id='endNoticeDays' size='3' class='days textbox' maxlength='3'/>
							<input type='text' id='endNoticeHours' size='2' class='hours textbox' maxlength='2'/>
							<input type='text' id='endNoticeMinutes' size='2' class='minutes textbox' maxlength='2'/>
							<input type='hidden' id='endNotice' class='interval' {formname key=MAX_NOTICE} />
						{/capture}
						{translate key='ResourceMaxNotice' args=$txtEndNotice}
						</span>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>{translate key='Capacity'}</legend>
				<ul>
					<li>
						<label>
							<input type="checkbox" id="unlimitedCapactiy"/> {translate key='ResourceCapacityNone'}
						</label>					
						<span class="unlimitedCapactiy">
							<br/>
						{capture name="txtMaxCapacity" assign="txtMaxCapacity"}
							<input type='text' id='maxCapactiy' class='textbox' size='5'
								   maxlength='5' {formname key=MAX_PARTICIPANTS} />
						{/capture}
						{translate key='ResourceCapacity' args=$txtMaxCapacity}
						</span>
					</li>
				</ul>
			</fieldset>
		</div>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="groupAdminDialog" class="dialog" title="{translate key=WhoCanManageThisResource}">
	<form method="post" id="groupAdminForm">
		<select id="adminGroupId" {formname key=RESOURCE_ADMIN_GROUP_ID} class="textbox">
			<option value="">-- {translate key=None} --</option>
		{foreach from=$AdminGroups item=adminGroup}
			<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
		{/foreach}
		</select>
		<br/><br/>
		<button type="button" class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
			<br/>{translate key=DeleteResourceWarning}:
			<ul>
				<li>{translate key=DeleteResourceWarningReservations}</li>
				<li>{translate key=DeleteResourceWarningPermissions}</li>
			</ul>
			<br/>
		{translate key=DeleteResourceWarningReassign}
		</div>

		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="attributeDialog" class="dialog" title="{translate key=AdditionalAttributes}">
	<div class="validationSummary">
		<ul>{async_validator id="attributeValidator" key=""}
		</ul>
	</div>

	<div class="customAttributes">
		<form method="post" id="attributesForm">
			<ul>
			{foreach from=$Definitions item=attribute}
				<li class="customAttribute">
					{control type="AttributeControl" attribute=$attribute}
				</li>
			{/foreach}
			</ul>
			<div style="clear:both;"></div>
			<br/>
			<button type="button"
					class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</form>
	</div>
</div>

<div id="sortOrderDialog" class="dialog" style="display:none;" title="{translate key=SortOrder}">
	<form id="sortOrderForm" method="post">
	{translate key=SortOrder}:
		<input type="text" id="editSortOrder" class="textbox" {formname key=RESOURCE_SORT_ORDER} maxlength="3" style="width:40px" />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>


{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/js/jquery.watermark.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/resource.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/ajaxfileupload.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		var actions = {
			rename:'{ManageResourcesActions::ActionRename}',
			changeImage:'{ManageResourcesActions::ActionChangeImage}',
			removeImage:'{ManageResourcesActions::ActionRemoveImage}',
			changeSchedule:'{ManageResourcesActions::ActionChangeSchedule}',
			changeLocation:'{ManageResourcesActions::ActionChangeLocation}',
			changeDescription:'{ManageResourcesActions::ActionChangeDescription}',
			changeNotes:'{ManageResourcesActions::ActionChangeNotes}',
			add:'{ManageResourcesActions::ActionAdd}',
			deleteResource:'{ManageResourcesActions::ActionDelete}',
			takeOffline:'{ManageResourcesActions::ActionTakeOffline}',
			bringOnline:'{ManageResourcesActions::ActionBringOnline}',
			changeConfiguration:'{ManageResourcesActions::ActionChangeConfiguration}',
			changeAdmin:'{ManageResourcesActions::ActionChangeAdmin}',
			enableSubscription:'{ManageResourcesActions::ActionEnableSubscription}',
			disableSubscription:'{ManageResourcesActions::ActionDisableSubscription}',
			changeAttributes:'{ManageResourcesActions::ActionChangeAttributes}',
			changeSortOrder:'{ManageResourcesActions::ActionChangeSort}'
		};

		var opts = {
			submitUrl:'{$smarty.server.SCRIPT_NAME}',
			saveRedirect:'{$smarty.server.SCRIPT_NAME}',
			actions:actions
		};

		var resourceManagement = new ResourceManagement(opts);
		resourceManagement.init();

	{foreach from=$Resources item=resource}
		var resource = {
			id:'{$resource->GetResourceId()}',
			name:"{$resource->GetName()|escape:'javascript'}",
			location:"{$resource->GetLocation()|escape:'javascript'}",
			contact:"{$resource->GetContact()|escape:'javascript'}",
			description:"{$resource->GetDescription()|escape:'javascript'}",
			notes:"{$resource->GetNotes()|escape:'javascript'}",
			autoAssign:'{$resource->GetAutoAssign()}',
			requiresApproval:'{$resource->GetRequiresApproval()}',
			allowMultiday:'{$resource->GetAllowMultiday()}',
			maxParticipants:'{$resource->GetMaxParticipants()}',
			scheduleId:'{$resource->GetScheduleId()}',
			minLength: {},
			maxLength: {},
			startNotice: {},
			endNotice: {},
			adminGroupId: '{$resource->GetAdminGroupId()}',
			sortOrder: '{$resource->GetSortOrder()}'
	};

		{if $resource->HasMinLength()}
		resource.minLength = {
			value:'{$resource->GetMinLength()}',
			days:'{$resource->GetMinLength()->Days()}',
			hours:'{$resource->GetMinLength()->Hours()}',
			minutes:'{$resource->GetMinLength()->Minutes()}'
		};
		{/if}

		{if $resource->HasMaxLength()}
		resource.maxLength = {
			value:'{$resource->GetMaxLength()}',
			days:'{$resource->GetMaxLength()->Days()}',
			hours:'{$resource->GetMaxLength()->Hours()}',
			minutes:'{$resource->GetMaxLength()->Minutes()}'
		};
		{/if}

		{if $resource->HasMinNotice()}
		resource.startNotice = {
			value:'{$resource->GetMinNotice()}',
			days:'{$resource->GetMinNotice()->Days()}',
			hours:'{$resource->GetMinNotice()->Hours()}',
			minutes:'{$resource->GetMinNotice()->Minutes()}'
		};
		{/if}

		{if $resource->HasMaxNotice()}
		resource.endNotice = {
			value:'{$resource->GetMaxNotice()}',
			days:'{$resource->GetMaxNotice()->Days()}',
			hours:'{$resource->GetMaxNotice()->Hours()}',
			minutes:'{$resource->GetMaxNotice()->Minutes()}'
		};
		{/if}

	resourceManagement.add(resource);
	{/foreach}
	})
	;

</script>

{include file='globalfooter.tpl'}