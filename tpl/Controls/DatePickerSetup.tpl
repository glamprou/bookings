<script type="text/javascript">
$(function(){
  $("#{$ControlId}").datepicker({ldelim} 
		 numberOfMonths: {$NumberOfMonths},
		 showButtonPanel: {$ShowButtonPanel},
		 onSelect: {$OnSelect},
		 dayNames: {$DayNames},
		 dayNamesShort: {$DayNamesShort},
		 dayNamesMin: {$DayNamesMin},
		 dateFormat: '{$DateFormat}',
		 firstDay: {$FirstDay},
		 monthNames: {$MonthNames},
		 monthNamesShort: {$MonthNamesShort},
		 currentText: "{translate key='Today'}"
	  	 {if $AltId neq ''}
		   ,
	  		altField: "#{$AltId}",
	  	 	altFormat: '{$AltFormat}'
		  {/if}
  {rdelim});

  {if $AltId neq ''}
	$("#{$ControlId}").change(function() {
 		if ($(this).val() == '') {
			$("#{$AltId}").val('');
		}
		else{
			var dateVal = $("#{$ControlId}").datepicker('getDate');
			var dateString = dateVal.getFullYear() + '-' + ('0' + (dateVal.getMonth()+1)).slice(-2) + '-' + ('0' + dateVal.getDate()).slice(-2);
			$("#{$AltId}").val(dateString);
		}
  	});
  {/if}

});
</script>