{include file='globalheader.tpl' cssFiles='css/calendar.css,css/jquery.qtip.min.css,scripts/css/fullcalendar.css' printCssFiles='scripts/css/fullcalendar.print.css'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$DayName}, {$MonthName} {$DisplayDate->Day()}, {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{PersonalCalendarUrl::Create($Today, CalendarTypes::Day)}" alt="Today" title="Today">{translate key=Today} {html_image src="calendar-day.png"}</a>
		<a href="{PersonalCalendarUrl::Create($DisplayDate, CalendarTypes::Week)}" alt="Week" title="Week">{translate key=Week} {html_image src="calendar-select-week.png"}</a>
		<a href="{PersonalCalendarUrl::Create($DisplayDate, CalendarTypes::Month)}" alt="View Month" title="View Month">{translate key=Month} {html_image src="calendar-select-month.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>
</div>

{include file='Calendar/mycalendar.common.tpl' view='agendaDay'}

{include file='globalfooter.tpl'}