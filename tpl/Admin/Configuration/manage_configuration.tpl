
{include file='globalheader.tpl' cssFiles='css/admin.css,scripts/css/colorbox.css'}

{function name="list_settings"}
	{foreach from=$settings item=setting}
		{assign var="name" value=$setting->Name}
    <li><span class="label">{$setting->Key}</span>
		{if $setting->Key == ConfigKeys::SERVER_TIMEZONE}
            <select name="{$name}">
				{html_options values=$TimezoneValues output=$TimezoneOutput selected=$setting->Value}
            </select>
			{elseif $setting->Key == ConfigKeys::LANGUAGE}
            <select name={$name}>
				{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$setting->Value|strtolower}
            </select>
			{elseif $setting->Type == ConfigSettingType::String}
            <input type="text" size="50" name="{$name}" value="{$setting->Value|escape}"/>
			{else}
            <label>{translate key="True"}<input type="radio" value="true" name="{$name}"{if $setting->Value == 'true'}
                                                checked="checked"{/if} /></label>
            <label>{translate key="False"}<input type="radio" value="false"
                                                 name="{$name}"{if $setting->Value == 'false'} checked="checked"{/if} /></label>
		{/if}
    </li>
	{/foreach}
{/function}

<h1>{translate key=ManageConfiguration}</h1>

{if !$IsPageEnabled}
<div class="warning">
	{translate key=ConfigurationUiNotEnabled}
</div>
{/if}

{if !$IsConfigFileWritable}
<div class="warning">
	{translate key=ConfigurationFileNotWritable}
</div>
{/if}

{if $IsPageEnabled && $IsConfigFileWritable}

	{assign var=HelpUrl value="$ScriptUrl/help.php?ht=admin"}
<h3>{translate key=ConfigurationUpdateHelp args=$HelpUrl}</h3>

<div id="updatedMessage" class="success" style="display:none">
	{translate key=ConfigurationUpdated}
</div>

<div id="configSettings">

    <input type="button" value="{translate key=Update}" class='button save'/>

    <form method="post" ajaxAction="{ConfigActions::Update}" action="{$smarty.server.SCRIPT_NAME}">
		<h3>{translate key=GeneralConfigSettings}</h3>
		<fieldset>
		<ul class="no-style">
			{list_settings settings=$Settings}
        </ul>
		</fieldset>

		{foreach from=$SectionSettings key=section item=settings}
            <h3>{$section}</h3>
            <fieldset>
                <ul class="no-style">
					{list_settings settings=$settings}
                </ul>
            </fieldset>
		{/foreach}

        <input type="hidden" name="setting_names" value="{$SettingNames}"/>
    </form>
    <input type="button" value="{translate key=Update}" class='button save'/>

</div>

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/configuration.js"></script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var config = new Configuration();
        config.init();
    });

</script>

<div id="modalDiv" style="display:none;text-align:center; top:15%;position:relative;">
    <h3>{translate key=Working}...</h3>
	{html_image src="reservation_submitting.gif"}
</div>

{/if}

{include file='globalfooter.tpl'}