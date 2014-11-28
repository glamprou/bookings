<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
<span class="attributeValue">{$attribute->Value()|escape}</span>
{else}
<select id="{$attributeName}" name="{$attributeName}" class="customAttribute textbox">
	{if !$attribute->Required()}
	<option value="">--</option>
	{/if}
	{foreach from=$attribute->PossibleValueList() item=value}
	<option value="{$value|escape}" {if $attribute->Value() == $value}selected="selected"{/if}>{$value|escape}</option>
	{/foreach}
</select>
{/if}
