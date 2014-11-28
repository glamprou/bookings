{*
 *}
{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css'}

<div class="success" style="display:none" id="profileUpdatedMessage">{translate key=YourProfileWasUpdated}</div>

<div class="validationSummary error" id="validationErrors">
	<ul>
		{async_validator id="fname" key="FirstNameRequired"}
		{async_validator id="lname" key="LastNameRequired"}
		{async_validator id="username" key="UserNameRequired"}
		{async_validator id="emailformat" key="ValidEmailRequired"}
		{async_validator id="uniqueemail" key="UniqueEmailRequired"}
		{async_validator id="uniqueusername" key="UniqueUsernameRequired"}
		{async_validator id="additionalattributes" key=""}
	</ul>
</div>

<div id="registrationbox">
<form class="register" method="post" ajaxAction="{ProfileActions::Update}" id="frmRegister" action="{$smarty.server.SCRIPT_NAME}">
    <div class="registrationHeader"><h3>{translate key=Login} ({translate key=AllFieldsAreRequired})</h3></div>
	<p>
		<label class="reg">{translate key="Username"}<br />
		{textbox name="USERNAME" class="input" value="Username" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="DefaultPage"}<br />
				<select {formname key='DEFAULT_HOMEPAGE'} class="input">
						{html_options values=$HomepageValues output=$HomepageOutput selected=$Homepage}
				</select>
		</label>
	</p>
	<div class="registrationHeader"><h3>{translate key=Profile} ({translate key=AllFieldsAreRequired})</h3></div>
	<p>
		<label class="reg">{translate key="FirstName"}<br />
		{textbox name="FIRST_NAME" class="input" value="FirstName" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="LastName"}<br />
		{textbox name="LAST_NAME" class="input" value="LastName" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Email"}<br />
		{textbox name="EMAIL" class="input" value="Email" size="20"}
		</label>
	</p>
	<div class="registrationHeader"><h3>{translate key=AdditionalInformation} ({translate key=Optional})</h3></div>
	<p>
		<label class="reg">{translate key="Phone"}<br />
		{textbox name="PHONE" class="input" value="Phone" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Organization"}<br />
		{textbox name="ORGANIZATION" class="input" value="Organization" size="20"}
		</label>
	</p>
	<p>
		<label class="reg">{translate key="Position"}<br />
		{textbox name="POSITION" class="input" value="Position" size="20"}
		</label>
	</p>
  
	{if $Attributes|count > 0}
	<div class="registrationHeader"><h3>{translate key=AdditionalAttributes}</h3></div>
		{foreach from=$Attributes item=attribute}
		<p class="customAttribute">
			{control type="AttributeControl" attribute=$attribute}
		</p>
		{/foreach}
	{/if}

	<p class="regsubmit">
        <button type="button" class="button update" name="{Actions::SAVE}" id="btnUpdate">
			<img src="img/tick-circle.png" />{translate key='Update'}
	    </button>
	</p>
	<p>
		<label style="visibility:hidden;" class="reg">{translate key="Timezone"}<br />
				<select {formname key='TIMEZONE'} class="input">
						{html_options values=$TimezoneValues output=$TimezoneOutput selected=$Timezone}
				</select>
		</label>
	</p>
</form>
</div>
<div id="imageDialog" class="dialog" style="display:none;" title="{translate key=AddImage}">
	<form id="imageForm" method="post" enctype="multipart/form-data" action="image_upload.php">
		<input id="profileImage" type="file" class="text" size="60" name="profileImage" />
    <input type="hidden" name="user" value="{$userid}" />
		<br/>
		<span class="note">.gif, .jpg, or .png</span>
		<br/><br/>
		<button type="button" class="button uploadImage">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>
{setfocus key='FIRST_NAME'}
<style type="text/css">
.noImage {
	width: 98px; 
	height: 60px; 
	background-color: #f0f0f0; 
	line-height: 16px;
	text-align:center;
	color: #666;
	border: solid 1px #ccc;
}
</style>
<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="{$Path}scripts/profile.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/ajaxfileupload.js"></script>

<script type="text/javascript">

$(document).ready(function () {
	var profilePage = new Profile();
	profilePage.init();
	ConfigureAdminDialog($('#imageDialog'), 500, 150);
	var showChangeImage = function (e) {
		$('#imageDialog').dialog("open");
	};
	$('.imageButton').click(function (e) {
		showChangeImage(e);
		return false;
	});

	$('.removeImageButton').click(function (e) {
		$.ajax({
			url: "image_upload.php",
			type: "post",
			data: {
				user: 2,
				delete_profile_image: 1
			},
			success: function(){
					window.location.reload();
			}
		});
	});
	$('#imageDialog').find('.uploadImage').click(function(){
		$('#imageForm').submit();
	});
	$(".cancel").click(function () {
		$(this).closest('.dialog').dialog("close");
	});
});

</script>

<div id="modalDiv" style="display:none;text-align:center; top:15%;position:relative;">
	<h3>{translate key=Working}...</h3>
	{html_image src="reservation_submitting.gif"}
</div>

{include file='globalfooter.tpl'}