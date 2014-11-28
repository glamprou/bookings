<div id="reservationParticipation">
	<ul class="no-style">
		<li>
			<label>{translate key="ParticipantList"}<br/>
				{translate key=Add} <input type="text" id="participantAutocomplete" class="input" style="width:250px;"/>
				or
				<button id="promptForParticipants" type="button" class="button" style="display:inline">
					<img src="img/user-plus.png"/>
				{translate key='AllUsers'}
				</button>
			</label>

			<div id="participantList">
				<ul/>
			</div>
			<div id="participantDialog" title="{translate key=AddParticipants}" class="dialog"></div>
		</li>
    <li>
    {if $IsCoach or $IsAdmin}
        <div style="height:30px; line-height:30px;" >
            <input type="checkbox" name="isTrainingCheckbox" id="isTrainingCheckbox" {if $checkisTrainingCheckbox}checked="checked"{/if} /> <label for="isTrainingCheckbox" title="{translate key=isTrainingOrTourTitle}">{translate key=isTrainingOrTour}</label>
        </div>
        {if $checkisTrainingCheckbox}
            <div id="cancel-training-container">
                <input type="checkbox" name="cancel-training" id="cancel-training" {if $isCancelledTraining}checked="checked"{/if} /> <label for="cancel-training">{translate key=cancelTraining}</label>
                <div id="cancel-training-hidden-container" {if $isCancelledTraining}class="open"{/if}>
                    <select name="cancel-training-reason" id="cancel-training-reason" class="pulldown">
                        <option value="weather" {if $isCancelledTraining == 'weather'}selected="selected"{/if}>{translate key=cancelTrainingDueToWeather}</option>
                        <option value="sickness" {if $isCancelledTraining == 'sickness'}selected="selected"{/if}>{translate key=cancelTrainingDueToSickness}</option>
                        <option value="match" {if $isCancelledTraining == 'match'}selected="selected"{/if}>{translate key=cancelTrainingDueToMatch}</option>
                        <option value="other" {if $isCancelledTraining == 'other'}selected="selected"{/if}>{translate key=cancelTrainingDueToOther}</option>
                    </select>
                    <input type="checkbox" id="cancel-training-send-sms" name="cancel-training-send-sms" /> <label for="cancel-training-send-sms">{translate key=cancelTrainingSendSms}</label>
                </div>
            </div>
            <script type="text/javascript">
                $('#isTrainingCheckbox').change(function(){
                    if(!$(this).is(':checked')){
                        $('#cancel-training').attr('checked', false);
                        $('#cancel-training-hidden-container').removeClass('open');
                    }
                });
                $('#cancel-training').change(function(){
                    if($(this).is(':checked')){
                        $('#cancel-training-hidden-container').addClass('open');
                    }
                    else{
                        $('#cancel-training-hidden-container').removeClass('open');
                    }
                });
            </script>
        {/if}
    {/if}
    {*{if $openResCheckBoxVisible}*}
        {*<div>*}
            {*<input type="checkbox" name="ParticipantsNeeded" id="ParticipantsNeeded" {if $checkisOpenCheckbox}checked="checked"{/if} /> <label for="ParticipantsNeeded">{translate key=isOpenRes}</label>*}
        {*</div>*}
    {*{/if}*}
    </li>
	</ul>
    <div id="participationOverLayer">&nbsp;</div>
</div>
