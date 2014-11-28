<?php
if(!$this->rankings_data){//empty data
    $resources = Resources::GetInstance();
    echo $resources->GetString("noRankingTables");
    exit;
}
$userSession = ServiceLocator::GetServer()->GetUserSession();

?>
<div id="rt_tabs">
    <ul>
        <?php
        foreach ($this->rankings_data as $index => $ranking_table) {
            if($ranking_table['current']){
                echo '<li><b>'.$ranking_table['ranking_name'].'</b></li>';
            }
            else{
                echo '<li><a href="'.$ranking_table['url'].'">'.$ranking_table['ranking_name'].'</a></li>';
            }
        }
        ?>
    </ul>
    <div class="clear"></div>
</div>
<div>
    <table id="ranking_table">
        <tr>
            <th id="rt_pos_col">Θέση</th>
            <th id="rt_plr_col">Παίκτες</th>
            <th id="rt_poi_col">Πόντοι</th>
            <th id="rt_set_col">Επιλογές</th>
        </tr>
        <?php
        $row=0;
        foreach ($this->rankings_data as $index => $ranking_table) {
            if($ranking_table['current']){
                /* @var $player RankingTableUser */
                foreach ($ranking_table['players'] as $player){
                    ?>
                    <tr class="row<?php echo $row++%2; ?>" player="<?php echo $player->user_id ?>">
                        <td>
                            <div class="plr_pos"><?php echo $player->position ?><div class="plr_pos_dif"><?php echo $player->position_difference!=0 ? "(".$player->position_difference.")" : "" ?></div></div>
                        </td>
                        <td>
                            <div class="plr_name<?php echo $player->canBeCalled ? " call" : "" ?>"><?php echo $player->fullname ?></div>
                            <div class="right">
                                <?php
                                if($player->isInjured ){
                                    ?>
                                    <div class="r_plr_btn<?php echo $userSession->IsAdmin ? " plr_uninjure" : "" ?>" has-dialog="unInjureDialog">injured</div>
                                    <?php
                                }
                                else{
                                    if($userSession->IsAdmin){
                                        ?>
                                        <div class="r_plr_btn plr_injure" has-dialog="injureDialog">injury</div>
                                        <?php   
                                    }
                                }
                                if($player->isBlocked ){
                                    ?>
                                    <div class="r_plr_btn<?php echo $userSession->IsAdmin ? " plr_unblock" : "" ?>" has-dialog="unBlockDialog">blocked</div>
                                    <?php
                                }
                                else{
                                    if($userSession->IsAdmin){
                                        ?>
                                        <div class="r_plr_btn plr_block" has-dialog="blockDialog">block</div>
                                        <?php   
                                    }
                                }
                                if($userSession->IsAdmin){
                                    ?>
                                    <div class="r_plr_btn plr_remove" has-dialog="removeDialog">remove</div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"></div>
                        </td>
                        <td>
                            <div class="plr_points"><?php echo $player->points ?></div>
                        </td>
                        <td>
                            <div class="plr_l5m"><span class="l5m_trigger">L5M</span></div>
                            <div class="plr_stats"><span class="stats_trigger">STATS</span></div>
                            <div class="plr_ltp"><span class="ltp_trigger">LTP</span></div>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
    </table>
</div>
<div class="rt_dialog" id="callDialog" style="display:none">
    <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
    <div id="callDialogText">Θέλετε να καλέσετε τον παίκτη <span class="dialog_name_field"></span> σε αγώνα;</div>
    <div><button class="button proceed">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<?php
if($userSession->IsAdmin){
?>
<div class="rt_dialog" id="blockDialog" style="display:none">
    <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
    <div>Θέλετε να ορίσετε ως "blocked" τον <span class="dialog_name_field"></span>;<br>Προσοχή! Θα ακυρωθούν και όλες οι εκκρεμείς προσκλήσεις που τον αφορούν.</div>
    <div><button class="button proceed" action="block">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<div class="rt_dialog" id="unBlockDialog" style="display:none">
    <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
    <div>Θέλετε να αφαιρέσετε το "block" από τον <span class="dialog_name_field"></span>;</div>
    <div><button class="button proceed" action="unblock">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<div class="rt_dialog" id="injureDialog" style="display:none">
    <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
    <div>Θέλετε να ορίσετε ως "injured" τον <span class="dialog_name_field"></span>;<br>Προσοχή! Θα ακυρωθούν και όλες οι εκκρεμείς προσκλήσεις που τον αφορούν.</div>
    <div><button class="button proceed" action="injure">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<div class="rt_dialog" id="unInjureDialog" style="display:none">
    <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
    <div>Θέλετε να αφαιρέσετε το "injured" από τον <span class="dialog_name_field"></span>;</div>
    <div><button class="button proceed" action="uninjure">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<div class="rt_dialog" id="removeDialog" style="display:none">
   <div><img src="<?php echo $this->path ?>img/dialog-warning.png"  /></div>
   <div>Θέλετε να διαγράψετε τον <span class="dialog_name_field"></span> από την βαθμολογία;<br>Προσοχή! Σε περίπτωση που προχωρήσετε, θα διαγραφούν όλοι οι πόντοι του και δεν θα υπάρχει τρόπος ανάκτησής τους.</div>
   <div><button class="button proceed" action="remove">Αποδοχή</button><button class="button cancel">Ακύρωση</button></div>
</div>
<?php
}
?>
<script type="text/javascript">
//dialog initialization
$(".rt_dialog").dialog({
    autoOpen: false, 
    modal: true, 
    draggable: false, 
    resizable: false, 
    closeOnEscape: true,
    minHeight: 400, 
    minWidth: 700, 
    width: 700,
    open: function(event, ui) {
        $(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
    }
});

//event listeners
$(document).on('click','.call',function(){
    $('#callDialog').attr('player',$(this).closest('tr').attr('player'));
    $("#callDialog .dialog_name_field").html($(this).closest("tr").find(".plr_name").html());
    $("#callDialog").dialog("open");
});

//in-dialog listeners
$(document).on('click','#callDialog .proceed',function(){
    $.ajax({
        url: "<?php echo $this->path ?>ajax/call.php",
        type: "POST",
        data: {
            action: "call",
            player: $(this).closest(".rt_dialog").attr("player")
        },
        success: function(response){
            alert(response);
        }
    });
});
$(document).on('click','#callDialog .cancel',function(){
    $("#callDialog").dialog("close");
});

<?php
if($userSession->IsAdmin){
?>  
    //admin event listeners
    $(document).on('click','.plr_remove, .plr_block, .plr_unblock, .plr_injure, .plr_uninjure',function(){
        $("#"+$(this).attr("has-dialog")).attr('player',$(this).closest('tr').attr('player'));
        $("#"+$(this).attr("has-dialog")).find(".dialog_name_field").html($(this).closest("tr").find(".plr_name").html());
        $("#"+$(this).attr("has-dialog")).dialog("open");
    });
    
    //in-dialog listeners
    $(document).on('click','.rt_dialog .cancel',function(){
        $(this).closest(".rt_dialog").dialog("close");
    });
    $(document).on('click','#removeDialog .proceed, #blockDialog .proceed, #unBlockDialog .proceed, #injureDialog .proceed, #unInjureDialog .proceed',function(){
        $.ajax({
            url: "<?php echo $this->path ?>ajax/rtPlayerCondition.php",
            type: "POST",
            data: {
                action: $(this).attr("action"),
                player: $(this).closest(".rt_dialog").attr("player")
            },
            success: function(response){
                alert(response);
            }
        });
    });
<?php
}
?>
</script>