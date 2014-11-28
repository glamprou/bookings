{if $Report->ResultCount() > 0}
	<div id="report-actions">
		<a href="#" id="btnChart">{html_image src="chart.png"}{translate key=ViewAsChart}</a>&nbsp;&nbsp;&nbsp;&nbsp;{if !$HideSave}<a href="#" id="btnSaveReportPrompt">{html_image src="disk-black.png"}{translate key=SaveThisReport}</a>&nbsp;&nbsp;&nbsp;&nbsp;{/if}<a href="#" id="btnPrint">{html_image src="printer.png"}{translate key=Print}</a>
	</div>
	<table width="100%" id="report-results" chart-type="{$Definition->GetChartType()}">
		<tr>
		{foreach from=$Definition->GetColumnHeaders() item=column}
			<th>{translate key=$column->TitleKey()}</th>
            {if $hideTotal}
                {break}
            {/if}
		{/foreach}
        {if $doubles}
            <th>Doubles</th>
            <th>Singles</th>
        {else}
            {*LOOKUP SOS*}
            {assign var="first" value="1"}
            {foreach from=$Schedules item=schedule}
                <th>{$schedule->GetName()}{if $first eq '1'}{assign var="first" value="0"}(ως συμμετέχοντας){/if}</th>
            {/foreach}
        {/if}
		</tr>
        {$i=0}
        {$total=0}
		{foreach from=$Report->GetData()->Rows() item=row}
			{cycle values=',alt' assign=rowCss}
			<tr class="{$rowCss}">
				{foreach from=$Definition->GetRow($row) item=cell}
					<td chart-value="{$cell->ChartValue()}" chart-column-type="{$cell->GetChartColumnType()}" chart-group="{$cell->GetChartGroup()}">{if $cell->Value()!=""}{$cell->Value()|escape}{else}0 hours{/if}</td>
                    {if $hideTotal}
                        {break}
                    {/if}
                {/foreach}
                {if $doubles}
                    <td>{$row["doubles"]}</td>
                    <td>{$row["singles"]}</td>
                {else}
                {*LOOKUP SOS*}
                 {foreach from=$extra_data[$i] item=userOnSchedule}
                     {assign var=variable value=$userOnSchedule->GetData()->Rows()}
                     <td>
                         {if $Definition->GetChartType()=='total'}
                             {if $variable[0]["total"]}{$variable[0]["total"]}{else}0{/if}
                             {$total = $total + $variable[0]["total"]}
                             {$type="count"}
                         {elseif $Definition->GetChartType()=='totalTime'}
                             {if $variable[0]["totalTime"]}{TimeInterval::Parse($variable[0]["totalTime"])}{else}0 hours{/if}
                             {$total = $total + $variable[0]["totalTime"]}
                             {$type="time"}
                         {/if}
                     </td>
                 {/foreach}
                {/if}
			</tr>
            {$i=$i+1}
		{/foreach}
	</table>
	<h4>{$Report->ResultCount()} {translate key=Rows}
		{if $Definition->GetTotal() != ''}
			|
            {if $type}
                {if $type eq "count"}
                    {$total}
                {else}
                    {TimeInterval::Parse($total)}
                {/if}
            {else}
                {$Definition->GetTotal()}
            {/if}
             {translate key=Total}
		{/if}
	</h4>
{else}
	<h2 id="report-no-data" class="no-data" style="text-align: center;">{translate key=NoResultsFound}</h2>

{/if}

<script type="text/javascript">
$(document).ready(function(){
	$('#report-no-data, #report-results').trigger('loaded');
});
</script>