<div id="repeatDiv">
	<label>{translate key="RepeatPrompt"}</label>
	<select id="repeatOptions" {formname key=repeat_options} class="pulldown" style="width:250px">
	{foreach from=$RepeatOptions key=k item=v}
		<option value="{$k}">{translate key=$v['key']}</option>
	{/foreach}
	</select>

	<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
		<label>{translate key="RepeatEveryPrompt"}</label>
		<select id="repeatInterval" {formname key=repeat_every} class="pulldown" style="width:55px">
		{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
		</select>
		<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
		<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
		<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
		<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
	</div>
	<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
		<label>{translate key="RepeatDaysPrompt"}</label>
		<input type="checkbox"
			   id="repeatDay0" {formname key=repeat_sunday} /><label
			for="repeatDay0">{translate key="DaySundaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay1" {formname key=repeat_monday} /><label
			for="repeatDay1">{translate key="DayMondaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay2" {formname key=repeat_tuesday} /><label
			for="repeatDay2">{translate key="DayTuesdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay3" {formname key=repeat_wednesday} /><label
			for="repeatDay3">{translate key="DayWednesdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay4" {formname key=repeat_thursday} /><label
			for="repeatDay4">{translate key="DayThursdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay5" {formname key=repeat_friday} /><label
			for="repeatDay5">{translate key="DayFridaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay6" {formname key=repeat_saturday} /><label
			for="repeatDay6">{translate key="DaySaturdaySingle"}</label>
	</div>
	<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfMonth}"
			   id="repeatMonthDay" checked="checked"/>
		<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfWeek}"
			   id="repeatMonthWeek"/>
		<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
	</div>
	<div id="repeatUntilDiv" style="display:none;">
	{translate key="RepeatUntilPrompt"}
		<input type="text" id="EndRepeat" class="dateinput" value="{formatdate date=$RepeatTerminationDate}"/>
		<input type="hidden" id="formattedEndRepeat" {formname key=end_repeat_date}
			   value="{formatdate date=$RepeatTerminationDate key=system}"/>
	</div>
</div>