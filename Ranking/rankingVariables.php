<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="../Ranking/styles.css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1>Αρχικοποίηση</h1></td>
    <td>
    	<h1 style="padding-top: 23px;"></h1>
    </td>
  </tr>
</table>
<?php
if(!empty($_SESSION['rankingMessage'])){
    ?>
    <div class="success rankingMessage" style="" id="profileUpdatedMessage"><?php echo $_SESSION['rankingMessage']; ?></div>
    <script>
        $('.rankingMessage').click(function(){
            $(this).slideUp('fast');
        });
    </script>
    <?php
    unset($_SESSION['rankingMessage']);
}
?>
<table class="list userList" width="270" height="100%"  cellspacing="0" cellpadding="0"  >
    <tr class="row0">
		<th colspan="3" >Ελάχιστος αριθμός ανοιχτών Ace Games για δωρεάν απόρριψη</th>
    </tr>
    <tr class="row1">
        <th colspan="3">
            <select id="numOfOpenAGForFreeDecline" class="textbox">
            	<option value="0">Ανενεργό</option>
							<?php
							$res=mysql_query("select * from r_options");
							$default=0;
							if ($row=mysql_fetch_object($res)){
								$default=$row->numAGFreeDecl;
							}
              $i=1;
              while ($i<11){
                if ($i==$default){
                  echo "<option value='$i' selected='selected'>$i</option>";
                }
                else{
                  echo "<option value='$i'>$i</option>";
                }
                $i++;
              }
              ?>
            </select>
        </th>
	</tr>
    <tr class="row0">
		<th colspan="2" width="140">Αριθμός ποινών</th><th width="70">Αριθμός ημερών</th>
    </tr>
    <tr class="row1">
        <th colspan="2">
            <select id="numOfPenalties" class="textbox">
                <?php
					$res=mysql_query("select * from r_options");
					$default=-1;
					if ($row=mysql_fetch_object($res)){
						$default=$row->numofpenalties;
					}
                    $i=1;
                    while ($i<11){
						if ($i==$default){
							echo "<option value='$i' selected='selected'>$i</option>";
						}
						else{
                        	echo "<option value='$i'>$i</option>";
						}
                        $i++;
                    }
                ?>
            </select>
        </th>
        <th>
             <input type="text" id="numOfDaysOfPenalty" style="width:45px;text-align:center;" maxlength="3" value="<?php
                    $i=1;
					$res=mysql_query("select * from r_options");
					$default='';
					if ($row=mysql_fetch_object($res)){
						$default=$row->numofdays;
					}
					echo $default;
                ?>" />
        </th>
	</tr>
    <tr  class="row0">
    	<th colspan="3">Μέγιστη βαθμολογική απόσταση για πρόσκληση</th>
    </tr>
    <tr  class="row1">
    	<th colspan="3">
        	<select id="maxcalldistance" class="textbox">
                <?php
					$default=-1;
					$res=mysql_query("select * from r_options");
					if ($row=mysql_fetch_object($res)){
						$default=$row->maxcalldistance;
					}
                    $i=1;
                    while ($i<11){
						if ($i==$default){
							echo "<option value='$i' selected='selected'>$i</option>";
						}
						else{
	                        echo "<option value='$i'>$i</option>";
                       	}
					    $i++;
                    }
                ?>
            </select>
        </th>
    </tr>
    <tr class="row0">
    	<th colspan="3">Ελάχιστες ημέρες επανάληψης πρόσκλησης</th>
    </tr>
    <tr class="row1">
    	<th colspan="3">
        	<select id="numOfDaysOfsamecall" class="textbox">
                <?php
					$default=-1;
					$res=mysql_query("select * from r_options");
					if ($row=mysql_fetch_object($res)){
						$default=$row->numofdays_samecall;
					}
                    $i=1;
                    while ($i<31){
						if ($i==$default){
							echo "<option value='$i' selected='selected'>$i</option>";
						}
						else{
	                        echo "<option value='$i'>$i</option>";
                       	}
					    $i++;
                    }
                ?>
            </select>
        </th>
    </tr>
    <tr class="row0">
        <th width="90">Διαφορά</th>
        <th width="90">Πόντοι φαβορί</th>
        <th width="90">Πόντοι αουτσάιντερ</th>
        <?php
            $res=mysql_query("select * from r_points order by points_pos_difference asc");
            $tmptmptmp=1;
            while ($row=mysql_fetch_object($res)){
                ?>
                <tr class="distance row1" value="<?= $row->points_pos_difference ?>">
                    <th><?= $row->points_pos_difference ?></th>
                    <th>
                        <select class="pointsstrongselection textbox" >
                        <?php
                            $i=1;
                            while ($i<16){
                                if ($i==$row->points_strong){
                                    echo "<option value='$i' selected='selected'>$i</option>";
                                }
                                else{
                                    echo "<option value='$i'>$i</option>";
                                }
                                $i++;
                            }
                        ?>
                        </select>
                    </th>
                    <th>
                        <select class="pointsweakselection textbox" >
                        <?php
                            $i=1;
                            while ($i<26){
                                if ($i==$row->points_weak){
                                    echo "<option value='$i' selected='selected'>$i</option>";
                                }
                                else{
                                    echo "<option value='$i'>$i</option>";
                                }
                                $i++;
                            }
                        ?>
                        </select>
                    </th>
                </tr>
                <?php
                $tmptmptmp++;
            }
        ?>
    </tr>
    <tr class="row0">
    	<th colspan="2">Θέση</th><th>Πόντοι</th>
    </tr>
    <?php
		$res=mysql_query("select * from r_tours_positions where 1 order by position_id asc");
		$tmptmptmp=1;
		while($row=mysql_fetch_object($res)){
			?>
            <tr class="position row1" posid="<?= $row->position_id ?>">
            	<th colspan="2"><?= $row->pos_description ?></th>
                <th>
					<select class="positionpoints textbox" >
					<?php
                        $i=1;
                        while ($i<81){
                            if ($i==$row->pos_points){
                                echo "<option value='$i' selected='selected'>$i</option>";
                            }
                            else{
                                echo "<option value='$i'>$i</option>";
                            }
                            $i++;
							if($i>15){
								$i+=4;
							}
                        }
                    ?>
                    </select>
                </th>
            </tr>
            <?php
			$tmptmptmp++;
		}
	?>
    <tr>
    	<td colspan="3"><button class="button" id="submitnewadminoptions">Αποθήκευση</button></td>
    </tr>
</table>
<script type="text/javascript">
function makenewselection(num,addclass){
	if (addclass==undefined){
		var selection="<select>";
	}
	else{
		var selection="<select class='"+addclass+" textbox'>";
	}
	var i=1;
	while (i<num+1){
		selection += "<option value='"+i+"'>"+i+"</option>";
		i++;
	}
	selection+="</select>";
	return selection;
}
$(document).ready(function(){
	var currElements=$('.distance').size();
	$('#maxcalldistance').change(function(){
		//alert(currElements);
		if ($(this).val()>currElements){
			var tobeshown=parseInt(currElements)+1;
		//	alert(tobeshown);
		//	alert($(this).val());
			while (tobeshown<=$(this).val()){
			//	alert('edw');
				$('.distance[value="'+tobeshown+'"]').show();
				if(!$('.distance[value="'+tobeshown+'"]').size()){
					$('.distance:last').after('<tr class="distance rownewdistance" value="'+tobeshown+'"><th>'+tobeshown+'</th><th>'+makenewselection(15,'pointsstrongselection')+'</th><th>'+makenewselection(15,'pointsweakselection')+'</th></tr>');
					currElements=$('.distance').size();
				}
				tobeshown++;
			}
			currElements=$('.distance:visible').size();
		}
		else if ($(this).val()<currElements){
			var toberemoved=parseInt($(this).val())+1;
			while (toberemoved<=currElements){
				$('.distance[value="'+toberemoved+'"]').hide();
				toberemoved++;
			}
			currElements=$('.distance:visible').size();
		}
		else{
			return false;
		}
	});
	
	$('#submitnewadminoptions').click(function(){
		var distances='';
		var i=0;
		$('.distance:visible').each(function(){
			if ($(this).css('display')=='none'){
				return;
			}
			if (i){
				distances+=',';
			}
			else{i=1;}
			distances+=$(this).attr('value')+'-';
			distances+=$(this).find('.pointsstrongselection').val()+'-';
			distances+=$(this).find('.pointsweakselection').val();
		});
		//alert(distances);
		var positions='';
		i=0;
		$('.position').each(function(){
			if (i){
				positions+=',';
			}
			else{i=1;}
			positions+=$(this).attr('posid')+'-';
			positions+=$(this).find('.positionpoints').val();
		});
		$.ajax({
		  type: "POST",
		  url: "../Ranking/ajax.php",
		  data: { action: "newRankingVariables",numofacegames: $('#numOfOpenAGForFreeDecline').val() , numofpenalties: $('#numOfPenalties').val(), numofdays: $('#numOfDaysOfPenalty').val(), maxcalldistance: $('#maxcalldistance').val(), numOfDaysOfsamecall: $('#numOfDaysOfsamecall').val(),distances: distances, positions:positions}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
});
</script>