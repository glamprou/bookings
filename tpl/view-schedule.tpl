{extends file="schedule.tpl"}

{block name="header"}
{include file='globalheader.tpl' cssFiles='css/schedule.css,css/view-schedule.css,css/jquery.qtip.min.css'}
{/block}

{block name="actions"}{/block}

{block name="scripts"}
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>
<script type="text/javascript" src="scripts/resourcePopup.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	var scheduleOptions = {
		reservationUrlTemplate: "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
		summaryPopupUrl: "ajax/respopup.php"
	};
	var schedule = new Schedule(scheduleOptions);
	schedule.initNavigation();
	schedule.initReservations();
	schedule.initResources();
});
</script>

{/block}