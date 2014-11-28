<?php

class Paths
{
	/**
	 * Filesystem directory for storing reservation attachments. Always contains trailing slash
	 *
	 * @static
	 * @return string
	 */
	public static function ReservationAttachments()
	{
		$uploadDir = Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_ATTACHMENTS);

		if (empty($uploadDir))
		{
			$uploadDir = ROOT_DIR . 'uploads/reservation';
		}

		if (!is_dir($uploadDir))
		{
			$uploadDir =  ROOT_DIR . $uploadDir;
		}

		if (!StringHelper::EndsWith($uploadDir, '/'))
		{
			$uploadDir = $uploadDir . '/';
		}

		if (!is_dir($uploadDir))
		{
			Log::Debug('Could not find directory %s. Attempting to create it', $uploadDir);
			$created = mkdir($uploadDir);
			if ($created)
			{
				Log::Debug('Created %s', $uploadDir);
			}
			else
			{
				Log::Debug('Could not create %s', $uploadDir);
			}

		}
		return $uploadDir;
	}
}
?>