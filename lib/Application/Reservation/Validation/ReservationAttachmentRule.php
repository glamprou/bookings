<?php

class ReservationAttachmentRule implements IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$attachment = $reservationSeries->AddedAttachment();

		$allowedExtensionsConfig = Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS);

		if (empty($allowedExtensionsConfig) || ($attachment == null))
		{
			return new ReservationRuleResult();
		}

		$allowedExtensions = str_replace('.', '', $allowedExtensionsConfig);
		$allowedExtensions = str_replace(' ', '', $allowedExtensions);
		$allowedExtensionList = explode(',', $allowedExtensions);

		return new ReservationRuleResult(in_array($attachment->FileExtension(), $allowedExtensionList), Resources::GetInstance()->GetString('InvalidAttachmentExtension', $allowedExtensionsConfig));
	}
}
?>