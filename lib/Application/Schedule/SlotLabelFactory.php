<?php

class SlotLabelFactory
{
	/**
	 * @static
	 * @param ReservationItemView $reservation
	 * @return string
	 */
	public static function Create(ReservationItemView $reservation)
	{
		$f = new SlotLabelFactory();
		return $f->Format($reservation);
	}

	/**
	 * @param ReservationItemView $reservation
	 * @return string
	 */
	public function Format(ReservationItemView $reservation)
	{
		$property = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE,
															 ConfigKeys::SCHEDULE_RESERVATION_LABEL);

		$name = $this->GetFullName($reservation);

		if ($property == 'titleORuser')
		{
			if (strlen($reservation->Title))
			{
				return $reservation->Title;
			}
			else
			{
				return $name;
			}
		}
		if ($property == 'title')
		{
			return $reservation->Title;
		}
		if ($property == 'none' || empty($property))
		{
			return '';
		}
		if ($property == 'name' || $property == 'user')
		{
			return $name;
		}

		$label = $property;
		$label = str_replace('{name}', $name, $label);
		$label = str_replace('{title}', $reservation->Title, $label);
		$label = str_replace('{description}', $reservation->Description, $label);
		$label = str_replace('{email}', $reservation->OwnerEmailAddress, $label);
		$label = str_replace('{organization}', $reservation->OwnerOrganization, $label);
		$label = str_replace('{phone}', $reservation->OwnerPhone, $label);
		$label = str_replace('{position}', $reservation->OwnerPosition, $label);
		
		
		//epistrofi 2 epithetwn, alliws, default		
		$rows=pdoq("select * from reservation_first_participant where reservation_series_id=? order by reservation_first_participant_id asc limit 1",$reservation->SeriesId);
		if(count($rows)){
			$rows=pdoq("SELECT lname FROM users  WHERE user_id = ?",$rows[0]->user_id);
			return $reservation->LastName."<br />".$rows[0]->lname;
		}
		else{
            $rows=pdoq("select u.lname from users u inner join reservation_users ru on u.user_id=ru.user_id where ru.reservation_instance_id=? and ru.reservation_user_level = 2", $reservation->ReservationId);
            if($rows){
                return $reservation->LastName."<br />".$rows[0]->lname;
            }

			return $label;//default	
		}
	}

	protected function GetFullName(ReservationItemView $reservation)
	{
		$shouldHide = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
															   ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
															   new BooleanConverter());
		if ($shouldHide)
		{
			return Resources::GetInstance()->GetString('Private');
		}

		$name = new FullName($reservation->FirstName, $reservation->LastName);
		return $name->__toString();

	}
}

class NullSlotLabelFactory extends SlotLabelFactory
{
	public function Format(ReservationItemView $reservation)
	{
		return '';
	}
}

class AdminSlotLabelFactory extends SlotLabelFactory
{
	protected function GetFullName(ReservationItemView $reservation)
	{
		$name = new FullName($reservation->FirstName, $reservation->LastName);
		return $name->__toString();
	}
}

?>