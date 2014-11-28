<div class="clear"></div>
<div id="chart-indicator" style="display:none; text-align: center;">
	<h3>{translate key=Working}...</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

<div id="chartdiv" style="margin:auto;height:400px;width:80%"></div>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="{$Path}scripts/js/jqplot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="{$Path}scripts/js/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$(document).on('loaded', '#report-no-data, #report-results', function () {
			var chart = new Chart();
			chart.clear();
		});
	});
</script>