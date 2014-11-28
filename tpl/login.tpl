{include file='globalheader.tpl'}

{if $ShowLoginError}
<div id="loginError">
	{translate key='LoginError'}
</div>
{/if}

<div id="loginbox">
	<!--This "$smarty.server.SCRIPT_NAME" sets up the form to post back to the same page that it is on.-->
	<form class="login" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div>
			{if $ShowUsernamePrompt}
			<p>
				<label class="login">{translate key='UsernameOrEmail'}<br/>
				{textbox name="EMAIL" class="input" size="20" tabindex="10"}</label>
			</p>
			{/if}

			{if $ShowPasswordPrompt}
			<p>
				<label class="login">{translate key='Password'}<br/>
				{textbox type="password" name="PASSWORD" class="input" value="" size="20" tabindex="20"}</label>
			</p>
			{/if}

			{*<p>*}
				{*<label class="login">{translate key='Language'}<br/>*}
					{*<select {formname key='LANGUAGE'} class="input-small" id="languageDropDown">*}
					{*{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$SelectedLanguage}*}
					{*</select>*}
			{*</p>*}
            <p class="loginsubmit">
                <button type="submit" name="{Actions::LOGIN}" class="button" tabindex="100" value="submit"><img
                            src="img/door-open-in.png"/> {translate key='LogIn'} </button>
                <input type="hidden" name="{FormKeys::RESUME}" value="{$ResumeUrl}"/>
            </p>
            {if $ShowRegisterLink}
                <p>{html_link href="register.php" key="CreateAnAccount"}</p>
            {/if}
            {if $ShowForgotPasswordPrompt}
                <p><a href="forgot.php">{translate key='ForgotMyPassword'}</a></p>
            {/if}
			{if $ShowPersistLoginPrompt}
			<p class="stayloggedin">
				<label class="login"><input type="checkbox" name="{FormKeys::PERSIST_LOGIN}" value="true" tabindex="30"/> {translate key='RememberMe'}</label>
			</p>
			{/if}
		</div>
		<div style="clear:both;">&nbsp;</div>
	</form>
</div>

<div id="login-links">
    <p>
        <a href="view-schedule.php">{translate key='ViewSchedule'}</a> | <a href="view-ranking.php">{translate key='ViewRanking'}</a>
    </p>
</div>

{setfocus key='EMAIL'}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function () {
		$('#languageDropDown').change(function()
		{
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode) {
		}
	});
</script>
{include file='globalfooter.tpl'}