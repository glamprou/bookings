<?php


class Announcement
{
    private $Id;
    private $Text;
    private $Start;
    private $End;
    private $Priority;
		private $important;

    /**
     * @return int
     */
    public function Id()
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function Text()
    {
        return $this->Text;
    }

    /**
     * @return Date
     */
    public function Start()
    {
        return $this->Start;
    }

    /**
     * @return Date
     */
    public function End()
    {
        return $this->End;
    }

    /**
     * @return int
     */
    public function Priority()
    {
        return $this->Priority;
    }
		
		public function Important()
    {
        return $this->important;
    }


    public function __construct($id, $text, Date $start, Date $end, $priority, $important)
    {
        $this->Id = $id;
        $this->Text = $text;
        $this->Start = $start;
        $this->End = $end;
        $this->Priority = $priority;
				$this->important = $important;
    }

    public static function FromRow($row)
    {
        return new Announcement(
            $row[ColumnNames::ANNOUNCEMENT_ID],
            $row[ColumnNames::ANNOUNCEMENT_TEXT],
            Date::FromDatabase($row[ColumnNames::ANNOUNCEMENT_START]),
            Date::FromDatabase($row[ColumnNames::ANNOUNCEMENT_END]),
            $row[ColumnNames::ANNOUNCEMENT_PRIORITY],
						$row[ColumnNames::ANNOUNCEMENT_IMPORTANT]
        );
    }

    /**
     * @static
     * @param string $text
     * @param Date $start
     * @param Date $end
     * @param int $priority
     * @return Announcement
     */
    public static function Create($text, Date $start, Date $end, $priority)
    {
        if (empty($priority))
        {
            $priority = null;
        }
        return new Announcement(null, $text, $start, $end, $priority);
    }

    /**
     * @param string $text
     */
    public function SetText($text)
    {
        $this->Text = $text;
    }

    /**
     * @param Date $start
     * @param Date $end
     */
    public function SetDates(Date $start, Date $end)
    {
        $this->Start = $start;
        $this->End = $end;
    }

    /**
     * @param int $priority
     */
    public function SetPriority($priority)
    {
        $this->Priority = $priority;
    }
		
		public function SetImportant($important)
    {
        $this->important = $important;
    }
}

?>