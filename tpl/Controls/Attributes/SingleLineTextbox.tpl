<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
<span class="attributeValue">{$attribute->Value()|escape}</span>
{else}
<input type="text" id="{$attributeName}" name="{$attributeName}" value="{$attribute->Value()|escape}" class="customAttribute textbox" />
{/if}