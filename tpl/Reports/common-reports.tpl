{include file='globalheader.tpl' cssFiles="css/reports.css,scripts/js/jqplot/jquery.jqplot.min.css"}

<h1>{translate key=CommonReports}</h1>
<div id="report-list">
	<ul>
		<li>
			<span class="report-title">{translate key=ResourceUsageTimeBooked}</span>
			<span class="right">
				<a href="#" reportId="{CannedReport::RESOURCE_TIME_ALLTIME}"
				   class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
				<a href="#" reportId="{CannedReport::RESOURCE_TIME_THISWEEK}"
				   class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
				<a href="#" reportId="{CannedReport::RESOURCE_TIME_THISMONTH}"
				   class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
			</span>
		</li>
		<li class="alt">
			<span class="report-title">{translate key=ResourceUsageReservationCount}</span>
			<span class="right">
				<a href="#" reportId="{CannedReport::RESOURCE_COUNT_ALLTIME}"
				   class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
				<a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISWEEK}"
				   class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
				<a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISMONTH}"
				   class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
			</span>
		</li>
		<li>
			<span class="report-title">{translate key=Top20UsersTimeBooked}</span>
			<span class="right">
				<a href="#" reportId="{CannedReport::USER_TIME_ALLTIME}"
				   class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
				<a href="#" reportId="{CannedReport::USER_TIME_THISWEEK}"
				   class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
				<a href="#" reportId="{CannedReport::USER_TIME_THISMONTH}"
				   class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
			</span>
		</li>
		<li class="alt">
			<span class="report-title">{translate key=Top20UsersReservationCount}</span>
			<span class="right">
				<a href="#" reportId="{CannedReport::USER_COUNT_ALLTIME}"
				   class="report report-action  runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
				<a href="#" reportId="{CannedReport::USER_COUNT_THISWEEK}"
				   class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
				<a href="#" reportId="{CannedReport::USER_COUNT_THISMONTH}"
				   class="report report-action  runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
			</span>
		</li>
	</ul>
</div>


<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;">
	<h3>{translate key=Working}...</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

{include file="Reports/chart.tpl"}

<script type="text/javascript" src="{$Path}scripts/ajax-helpers.js"></script>
<script type="text/javascript" src="{$Path}scripts/reports/canned-reports.js"></script>
<script type="text/javascript" src="{$Path}scripts/reports/chart.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		var reportOptions = {
			generateUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}&{QueryStringKeys::REPORT_ID}=",
			emailUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Email}&{QueryStringKeys::REPORT_ID}=",
			deleteUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Delete}&{QueryStringKeys::REPORT_ID}=",
			printUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&{QueryStringKeys::REPORT_ID}=",
			csvUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&{QueryStringKeys::REPORT_ID}="
		};

		var reports = new CannedReports(reportOptions);
		reports.init();
	});
</script>

{include file='globalfooter.tpl'}