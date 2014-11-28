
<h3>{$Attributes|count} {translate key=Attributes}</h3>
{if $Attributes|count > 0}
<table class="list">
	<tr>
		<th>ID</th>
		<th>{translate key=SortOrder}</th>
		<th>{translate key=DisplayLabel}</th>
		<th>{translate key=Type}</th>
		<th>{translate key=Required}</th>
		<th>{translate key=ValidationExpression}</th>
		<th>{translate key=PossibleValues}</th>
		<th>{translate key=Delete}</th>
	</tr>
	{foreach from=$Attributes item=attribute}
		{cycle values='row0,row1' assign=rowCss}
		<tr class="{$rowCss} editable" attributeId="{$attribute->Id()}">
			<td>{$attribute->Id()}</td>
			<td>{$attribute->SortOrder()}</td>
			<td>{$attribute->Label()}</td>
			<td>{translate key=$Types[$attribute->Type()]}</td>
			<td>{if $attribute->Required()}
				{translate key=Yes}
				{else}
				{translate key=No}
			{/if}</td>
			<td>{$attribute->Regex()}</td>
			<td>{$attribute->PossibleValues()}</td>
			<td align="center"><a href="#" class="update delete" attributeId="{$attribute->Id()}">{html_image src='cross-button.png'}</a></td>
		</tr>
	{/foreach}
</table>
{/if}


<script type="text/javascript">
	var attributeList = new Object();

	{foreach from=$Attributes item=attribute}
		attributeList[{$attribute->Id()}] = {
						id: {$attribute->Id()},
						label: "{$attribute->Label()|escape:'javascript'}",
						required: {$attribute->Required()},
						regex: "{$attribute->Regex()|escape:'javascript'}",
						possibleValues: "{$attribute->PossibleValues()|escape:'javascript'}",
						type: "{$attribute->Type()}",
						sortOrder: "{$attribute->SortOrder()}"
					};
	{/foreach}

	$('#attributeList').data('list', attributeList);
</script>