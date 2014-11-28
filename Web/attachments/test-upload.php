<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

$file = ServiceLocator::GetServer()->GetFile(FormKeys::RESERVATION_FILE);

if ($file != null)
{
	echo 'got a file';
	$fileName = $file->OriginalName();
	$tmpName = $file->TemporaryName();
	$fileSize = $file->Size();
	$fileType = $file->MimeType();
	$extension = $file->Extension();

	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	fclose($fp);

	$attachment = ReservationAttachment::Create($fileName, $fileType, $fileSize, $content, $extension, 1);
	$repo = new ReservationRepository();
	$repo->AddReservationAttachment($attachment);
}
?>
<form action="test-upload.php" enctype="multipart/form-data" method="POST">
	<input type="file" name="reservationFile">
	<input type="submit" value="Go"/>
</form>
<?php
?>