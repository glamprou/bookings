<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect(); 

$userid=$_GET['userid'];

$res=mysql_query("select * from user_profile_info where user_id=$userid");
if($row=mysql_fetch_object($res)){
	if($row->user_profile_img!="" && $row->user_profile_img!=NULL){
	?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" valign="middle">
        <img src="<?= ROOT_DIR.$row->user_profile_img ?>" alt="Profile Image" class="image"/><br/>
        <a class="update imageButton" href="javascript: void(0);">Αλλαγή</a> |
        <a class="update removeImageButton" href="javascript: void(0);">Αφαίρεση</a>
        <div id="imageDialog" class="dialog" style="display:none;" title="Προσθήκη εικόνας">
          <form id="imageForm" method="post" enctype="multipart/form-data" action="../image_upload.php">
            <input id="profileImage" type="file" class="text" size="60" name="profileImage" />
            <input type="hidden" id="userid" name="userid" value="<?php echo $userid ?>" />
            <br/>
            <span class="note">.gif, .jpg, or .png</span>
            <br/><br/>
            <button class="button uploadImage" type="button"><img alt="" title="" src="../img/disk-black.png"> Ενημέρωση</button>
            <button class="button cancel" type="button"><img alt="" title="" src="../img/slash.png"> Άκυρο</button>
          </form>
        </div>
      </td>
    </tr>
  </table>
  <?php
	}
	else{
	?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" valign="middle">
        <div class="noImage">Δεν υπάρχει εικόνα</div>
        <a class="update imageButton" href="javascript: void(0);">Προσθήκη εικόνας</a>	
        <div id="imageDialog" class="dialog" style="display:none;" title="Προσθήκη εικόνας">
          <form id="imageForm" method="post" enctype="multipart/form-data" action="../image_upload.php">
            <input id="profileImage" type="file" class="text" size="60" name="profileImage" />
            <input type="hidden" id="userid" name="userid" value="<?php echo $userid ?>" />
            <br/>
            <span class="note">.gif, .jpg, or .png</span>
            <br/><br/>
            <button class="button uploadImage" type="button"><img alt="" title="" src="../img/disk-black.png"> Ενημέρωση</button>
            <button class="button cancel" type="button"><img alt="" title="" src="../img/slash.png"> Άκυρο</button>
          </form>
        </div>
      </td>
    </tr>
  </table>
  <?php
	}
}
else{
	?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" valign="middle">
        <div class="noImage">Δεν υπάρχει εικόνα</div>
        <a class="update imageButton" href="javascript: void(0);">Προσθήκη εικόνας</a>	
        <div id="imageDialog" class="dialog" style="display:none;" title="Προσθήκη εικόνας">
          <form id="imageForm" method="post" enctype="multipart/form-data" action="../image_upload.php">
            <input id="profileImage" type="file" class="text" size="60" name="profileImage" />
            <input type="hidden" id="userid" name="userid" value="<?php echo $userid ?>" />
            <br/>
            <span class="note">.gif, .jpg, or .png</span>
            <br/><br/>
            <button class="button uploadImage" type="button"><img alt="" title="" src="../img/disk-black.png"> Ενημέρωση</button>
            <button class="button cancel" type="button"><img alt="" title="" src="../img/slash.png"> Άκυρο</button>
          </form>
        </div>
      </td>
    </tr>
  </table>
  <?php
	}
?>
<script type="text/javascript">
$('.imageButton').click(function (e) {
	showChangeImage(e);
	return false;
});

$('.removeImageButton').click(function (e) {
	$.ajax({
		url: "../image_upload.php",
		type: "post",
		data: {
			userid: <?php echo $userid; ?>,
			delete_profile_image: 1
		},
		success: function(){
				window.location.reload();
		}
	});
});
var showChangeImage = function (e) {
	$('#imageDialog').dialog({
			modal: false,
			autoOpen: false,
			height: 150,
			width: 500,
			close: function(){
				$(this).dialog('destroy');
			}
	});
	$('#imageDialog').dialog("open");
};
$('#imageDialog').find('.uploadImage').click(function(){
	$('#imageForm').submit();
});
$(".cancel").click(function () {
	$(this).closest('.dialog').dialog("close");
});
</script>