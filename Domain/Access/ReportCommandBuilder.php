<?php

class ReportCommandBuilder
{
    const REPORT_TEMPLATE = 'SELECT [SELECT_TOKEN]
				FROM reservation_instances ri
				INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
				INNER JOIN users owner ON owner.user_id = rs.owner_id
				LEFT JOIN reservation_details rd ON rs.series_id = rd.series_id
				[JOIN_TOKEN]
				WHERE rs.status_id <> 2
				[AND_TOKEN]
                [PARTICIPANT_TOKEN]
				[GROUP_BY_TOKEN]
				[ORDER_TOKEN]
				[LIMIT_TOKEN]';

    const REPORT_TEMPLATE_ZEROS = "SELECT [SELECT_ZEROS] from(
                SELECT [SELECT_TOKEN]
				FROM reservation_instances ri
				INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
				INNER JOIN users owner ON owner.user_id = rs.owner_id
				LEFT JOIN reservation_details rd ON rs.series_id = rd.series_id
				[JOIN_TOKEN]
				WHERE rs.status_id <> 2
				[AND_TOKEN]
                [PARTICIPANT_TOKEN]
				[GROUP_BY_TOKEN]
				[ORDER_TOKEN]
				[LIMIT_TOKEN]
                ) as A
                RIGHT JOIN users owner ON A.owner_id=owner.user_id
                [JOIN_GROUPS_TOKEN]
                WHERE owner.status_id<>2
                [WHERE_ZEROS]
                [AND_GROUP_PERSON_TOKEN]";

    const RESERVATION_LIST_FRAGMENT = 'rs.date_created as date_created, rs.last_modified as last_modified, rs.repeat_type,
		rs.description as description, rs.title as title, rs.status_id as status_id, ri.reference_number, ri.start_date, ri.end_date';

    const COUNT_FRAGMENT = 'COUNT(1) as total';

    const COUNT_FRAGMENT_PART = "SUM(total_owner) AS total_owner, SUM(total_participant) AS total_participant, SUM(total_training) as total_training, fname AS owner_fname, lname AS owner_lname, CONCAT(fname, ' ', lname) AS owner_name, user_id AS owner_id
                            FROM( (SELECT SUM(1) AS total_owner, 0 as total_participant, owner.fname, owner.lname, owner.user_id, SUM(if(rd.particular_type = 'training', 1, 0)) AS total_training";

    const COUNT_FRAGMENT_PART_TRAINING = "SUM(private_training) as private_training, SUM(private_training_cancelled) as private_training_cancelled, SUM(group_training) as group_training, SUM(group_training_cancelled) as group_training_cancelled, fname AS owner_fname, lname AS owner_lname, CONCAT(fname, ' ', lname) AS owner_name, user_id AS owner_id
                            FROM( (SELECT owner.fname, owner.lname, owner.user_id, SUM(if(rd.trainingType = 'Private', 1, 0)) AS private_training, SUM(if(rd.trainingType = 'Private' AND cancelledTraining IS NOT NULL, 1, 0)) AS private_training_cancelled, SUM(if(rd.trainingType = 'Group', 1, 0)) AS group_training, SUM(if(rd.trainingType = 'Group' AND cancelledTraining IS NOT NULL, 1, 0)) AS group_training_cancelled";

    /*LOOKUP ZEROS*/
    const SELECT_COUNT_ZEROS = "0 AS total, owner.fname AS owner_fname, owner.lname AS owner_lname, CONCAT(owner.fname, ' ', owner.lname) AS owner_name, owner.user_id AS owner_id";
    /*LOOKUP ZEROS*/
    const SELECT_TIME_ZEROS = "0 AS totalTime, owner.fname AS owner_fname, owner.lname AS owner_lname, CONCAT(owner.fname, ' ', owner.lname) AS owner_name, owner.user_id AS owner_id";
    /*LOOKUP ZEROS*/
    const WHERE_ZERO_COUNT = "AND total IS NULL";

    const WHERE_ZERO_COUNT_PART = "AND total_owner IS NULL AND total_participant IS NULL";
    /*LOOKUP ZEROS*/
    const WHERE_ZERO_TIME = "AND totalTime IS NULL";

    const WHERE_ZERO_TIME_PART = "AND totalTime_owner IS NULL AND totalTime_participant IS NULL";

    const DOUBLES_SELECT_RESOURCES = "COUNT(1) as total, SUM(doubles) as doubles, COUNT(1)-SUM(doubles) as singles, resource_id, resource_name from (SELECT if(COUNT(ru.user_id)>2,1,0) as doubles, schedules.schedule_id, schedules.name as schedule_name, resources.name as resource_name, resources.resource_id";

    const DOUBLES_SELECT_SCHEDULES = "COUNT(1) as total, SUM(doubles) as doubles, COUNT(1)-SUM(doubles) as singles, schedule_id, schedule_name from (SELECT if(COUNT(ru.user_id)>2,1,0) as doubles, schedules.schedule_id, schedules.name as schedule_name, resources.name as resource_name, resources.resource_id";

    const PARTICIPANT_COUNT_TOKEN = "GROUP BY owner.user_id )
                            UNION ALL
                            (SELECT 0 as total_owner, SUM( 1 ) AS total_participant, owner.fname, owner.lname, owner.user_id, SUM(if(rd.particular_type = 'training', 1, 0)) AS total_training
                            FROM users owner INNER JOIN reservation_users ru ON owner.user_id=ru.user_id
                            INNER JOIN reservation_instances ri ON ru.reservation_instance_id= ri.reservation_instance_id
                            INNER JOIN reservation_series rs ON rs.series_id=ri.series_id
                            LEFT JOIN reservation_details rd ON rs.series_id = rd.series_id
                            [JOIN_TOKEN]
                            WHERE rs.status_id <> 2
                            AND ru.reservation_user_level = 2
                            [AND_TOKEN]
                            GROUP BY owner.user_id)) AS T";

    const PARTICIPANT_COUNT_TOKEN_TRAINING = "AND rd.particular_type = 'training' GROUP BY owner.user_id )
                            UNION ALL
                            (SELECT owner.fname, owner.lname, owner.user_id, SUM(if(rd.trainingType = 'Private', 1, 0)) AS private_training, SUM(if(rd.trainingType = 'Private' AND cancelledTraining IS NOT NULL, 1, 0)) AS private_training_cancelled, SUM(if(rd.trainingType = 'Group', 1, 0)) AS group_training, SUM(if(rd.trainingType = 'Group' AND cancelledTraining IS NOT NULL, 1, 0)) AS group_training_cancelled
                            FROM users owner INNER JOIN reservation_users ru ON owner.user_id=ru.user_id
                            INNER JOIN reservation_instances ri ON ru.reservation_instance_id= ri.reservation_instance_id
                            INNER JOIN reservation_series rs ON rs.series_id=ri.series_id
                            LEFT JOIN reservation_details rd ON rs.series_id = rd.series_id
                            [JOIN_TOKEN]
                            WHERE rs.status_id <> 2
                            AND ru.reservation_user_level = 2
                            AND rd.particular_type = 'training'
                            [AND_TOKEN]
                            GROUP BY owner.user_id)) AS T";

    const PARTICIPANT_TIME_TOKEN = "GROUP BY owner.user_id )
                            UNION ALL
                            (SELECT 0 as totalTime_owner, SUM( UNIX_TIMESTAMP(LEAST(end_date, @endDate)) - UNIX_TIMESTAMP(GREATEST(start_date, @startDate)) ) AS totalTime_participant, owner.fname, owner.lname, owner.user_id, ri.start_date, ri.end_date
                            FROM users owner INNER JOIN reservation_users ru ON owner.user_id=ru.user_id
                            INNER JOIN reservation_instances ri ON ru.reservation_instance_id= ri.reservation_instance_id
                            INNER JOIN reservation_series rs ON rs.series_id=ri.series_id
                            [JOIN_TOKEN]
                            WHERE rs.status_id <> 2
                            AND ru.reservation_user_level = 2
                            [AND_TOKEN]
                            GROUP BY owner.user_id)) AS T";

    const TOTAL_TIME_FRAGMENT = 'SUM( UNIX_TIMESTAMP(LEAST(ri.end_date, @endDate)) - UNIX_TIMESTAMP(GREATEST(ri.start_date, @startDate)) ) AS totalTime';

    /*LOOKUP PART*/
    const TOTAL_TIME_FRAGMENT_PART = "SUM(totalTime_owner) as totalTime_owner, SUM(totalTime_participant) as totalTime_participant, fname AS owner_fname, lname AS owner_lname, CONCAT(fname, ' ', lname) AS owner_name, user_id AS owner_id
             FROM( (SELECT SUM( UNIX_TIMESTAMP(LEAST(end_date, @endDate)) - UNIX_TIMESTAMP(GREATEST(start_date, @startDate)) ) AS totalTime_owner, 0 as totalTime_participant, owner.fname, owner.lname, owner.user_id, ri.start_date, ri.end_date";

    const RESOURCE_LIST_FRAGMENT = 'resources.name as resource_name, resources.resource_id';

    const SCHEDULE_LIST_FRAGMENT = 'schedules.schedule_id, schedules.name as schedule_name';

    const ACCESSORY_LIST_FRAGMENT = 'accessories.accessory_name, accessories.accessory_id, ar.quantity';

    const USER_LIST_FRAGMENT = 'owner.fname as owner_fname, owner.lname as owner_lname, CONCAT(owner.fname, \' \', owner.lname) as owner_name, owner.user_id as owner_id';

    const GROUP_LIST_FRAGMENT = 'groups.name as group_name, groups.group_id';

    const RESOURCE_JOIN_FRAGMENT = 'INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id
				INNER JOIN resources ON rr.resource_id = resources.resource_id
				INNER JOIN schedules ON resources.schedule_id = schedules.schedule_id';

    const ACCESSORY_JOIN_FRAGMENT = 'INNER JOIN reservation_accessories ar ON rs.series_id = ar.series_id
				INNER JOIN accessories ON ar.accessory_id = accessories.accessory_id';

    const GROUP_JOIN_FRAGMENT = 'INNER JOIN user_groups ug ON ug.user_id = owner.user_id
				INNER JOIN groups ON groups.group_id = ug.group_id';

    const DOUBLES_JOIN = "INNER JOIN reservation_users ru ON ru.reservation_instance_id = ri.reservation_instance_id";

    const ORDER_BY_FRAGMENT = 'ORDER BY ri.start_date ASC';

    const TOTAL_ORDER_BY_FRAGMENT = 'ORDER BY total DESC';

    const TOTAL_ORDER_BY_FRAGMENT_USER = 'ORDER BY SUM(total_owner + total_participant) DESC';

    const TOTAL_ORDER_BY_FRAGMENT_USER_TRAINING = 'ORDER BY SUM(group_training + private_training) DESC';

    const TIME_ORDER_BY_FRAGMENT = 'ORDER BY totalTime DESC';

    const TIME_ORDER_BY_FRAGMENT_USER = 'ORDER BY SUM(totalTime_owner + totalTime_participant) DESC';

    const SCHEDULE_ID_FRAGMENT = 'AND schedules.schedule_id = @scheduleid';

    const RESOURCE_ID_FRAGMENT = 'AND resources.resource_id = @resourceid';

    const ACCESSORY_ID_FRAGMENT = 'AND accessories.accessory_id = @accessoryid';

    const USER_ID_FRAGMENT = 'AND owner.user_id = @userid';

    const GROUP_ID_FRAGMENT = 'AND ug.group_id = @groupid';

    const DATE_FRAGMENT = 'AND ((ri.start_date >= @startDate AND ri.start_date < @endDate) OR
						(ri.end_date >= @startDate AND ri.end_date <= @endDate) OR
						(ri.start_date <= @startDate AND ri.end_date > @endDate))';

    const GROUP_BY_GROUP_FRAGMENT = 'GROUP BY groups.group_id';

    const GROUP_BY_RESOURCE_FRAGMENT = 'GROUP BY resources.resource_id';

    const GROUP_BY_SCHEDULE_FRAGMENT = 'GROUP BY schedules.schedule_id';

    const GROUP_BY_USER_FRAGMENT = 'GROUP BY owner_id';

    const DOUBLES_GROUP_BY_SCHEDULE = 'GROUP BY ri.reservation_instance_id, rr.resource_id) as t
            group by schedule_id';

    const DOUBLES_GROUP_BY_RESOURCE = 'GROUP BY ri.reservation_instance_id, rr.resource_id) as t
            group by resource_id';

    /**
     * @var bool
     */
    private $fullList = false;
    /**
     * @var bool
     */
    private $count = false;
    /**
     * @var bool
     */
    private $time = false;
    /**
     * @var bool
     */
    private $joinResources = false;
    /**
     * @var bool
     */
    private $joinGroups = false;
    /**
     * @var bool
     */
    private $joinAccessories = false;
    /**
     * @var bool
     */
    private $listResources = false;
    /**
     * @var bool
     */
    private $listSchedules = false;
    /**
     * @var bool
     */
    private $listGroups = false;
    /** @var bool
     */
    private $listUsers = false;
    /**
     * @var bool
     */
    private $listAccessories = false;
    /**
     * @var bool
     */
    private $limitWithin = false;
    /**
     * @var null|int
     */
    private $scheduleId = null;
    /**
     * @var null|int
     */
    private $userId = null;
    /**
     * @var null|int
     */
    private $resourceId = null;
    /**
     * @var null|int
     */
    private $accessoryId = null;
    /**
     * @var null|int
     */
    private $groupId = null;
    /**
     * @var null|Date
     */
    private $startDate = null;
    /**
     * @var null|Date
     */
    private $endDate = null;
    /**
     * @var bool
     */
    private $groupByGroup = false;
    /**
     * @var bool
     */
    private $groupByResource = false;
    /**
     * @var bool
     */
    private $groupBySchedule = false;
    /**
     * @var bool
     */
    private $groupByUser = false;
    /**
     * @var int
     */
    private $limit = 0;
    /**
     * @var array|Parameter[]
     */
    private $parameters = array();

    /**
     * LOOKUP PART
     * symperilamvanei kai ton 1o participant sta statistika
     * @var boolean
     */
    private $firstPart=FALSE;

    /**
     * LOOKUP ZEROS
     * Gemisma me midenika stous xristes pou DEN exoun oute mia kratisi
     * @var boolean
     */
    private $zeroFill=FALSE;

    private $doubles=FALSE;

    private $customParticipantResults=FALSE;

    /**
     * @return ReportCommandBuilder
     */
    public function SelectFullList()
    {
        $this->fullList = true;
        $this->listUsers = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function SelectCount()
    {
        $this->count = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function SelectTime()
    {
        $this->time = true;
        $this->limitWithin = true;
        $this->startDate = Date::Min();
        $this->endDate = Date::Max();
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function OfResources()
    {
        $this->joinResources = true;
        $this->listResources = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function OfAccessories()
    {
        $this->joinAccessories = true;
        $this->listAccessories = true;
        return $this;
    }

    /**
     * @param Date $start
     * @param Date $end
     * @return ReportCommandBuilder
     */
    public function Within(Date $start, Date $end)
    {
        $this->limitWithin = true;
        $this->startDate = $start;
        $this->endDate = $end;
        return $this;
    }

    /**
     * @param int $resourceId
     * @return ReportCommandBuilder
     */
    public function WithResourceId($resourceId)
    {
        $this->joinResources = true;
        $this->resourceId = $resourceId;
        return $this;
    }

    /**
     * @param int $userId
     * @return ReportCommandBuilder
     */
    public function WithUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param int $scheduleId
     * @return ReportCommandBuilder
     */
    public function WithScheduleId($scheduleId)
    {
        $this->joinResources = true;
        $this->scheduleId = $scheduleId;
        return $this;
    }

    /**
     * @param int $groupId
     * @return ReportCommandBuilder
     */
    public function WithGroupId($groupId)
    {
        $this->joinGroups = true;
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @param int $accessoryId
     * @return ReportCommandBuilder
     */
    public function WithAccessoryId($accessoryId)
    {
        $this->joinAccessories = true;
        $this->accessoryId = $accessoryId;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function GroupByGroup()
    {
        $this->joinGroups = true;
        $this->listGroups = true;
        $this->groupByGroup = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function GroupByResource()
    {
        $this->joinResources = true;
        $this->listResources = true;
        $this->groupByResource = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function GroupByUser()
    {
        $this->listUsers = true;
        $this->groupByUser = true;
        return $this;
    }

    /**
     * @return ReportCommandBuilder
     */
    public function GroupBySchedule()
    {
        $this->joinResources = true;
        $this->listSchedules = true;
        $this->groupBySchedule = true;
        return $this;
    }

    /**
     * @param int $limit
     * @return ReportCommandBuilder
     */
    public function LimitedTo($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return ISqlCommand
     */
    public function Build($nolimit=FALSE)
    {
        if(($_POST['reportResults']=="TIME" || $_POST['reportResults']=="COUNT" || !empty($_POST['training'])) && isset($_POST['REPORT_GROUPBY']) && $_POST['REPORT_GROUPBY']=="USER"){
            $this->customParticipantResults = true;
        }

        /**
         * LOOKUP ZEROS LOOKUP PARTS
         * epeidi ginane polles allages iparxoun k simeia pou epeksergastikan
         * xwris na iparxei LOOKUP. allakse OLO to arxeio k telos
         */
        if(($_POST['reportResults']=="TIME" || $_POST['reportResults']=="COUNT" || !empty($_POST['training'])) && isset($_POST['REPORT_GROUPBY']) && $_POST['REPORT_GROUPBY']=='USER' && isset($_POST['zeroResUsers'])){
            $this->zeroFill=TRUE;
        }
        if(TRUE){//anti gia true, na ginei dynamiko pedio sto mellon
            $this->firstPart=TRUE;
        }
        if(isset($_POST['reportResults']) && $_POST['reportResults']=='COUNT' && isset($_POST['REPORT_GROUPBY']) && $_POST['REPORT_GROUPBY']!="USER"){
            $this->doubles=TRUE;
        }

        $sql = $this->getTemplate();
        $sql = str_replace('[PARTICIPANT_TOKEN]', $this->GetPartToken(), $sql);
        $sql = str_replace('[SELECT_TOKEN]', $this->GetSelectList(), $sql);
        $sql = str_replace('[JOIN_TOKEN]', $this->GetJoin(), $sql);
        $sql = str_replace('[AND_TOKEN]', $this->GetWhereAnd(), $sql);
        $sql = str_replace('[GROUP_BY_TOKEN]', $this->GetGroupBy(), $sql);
        $sql = str_replace('[ORDER_TOKEN]', $this->GetOrderBy(), $sql);

        /*LOOKUP ZEROS*/
        $sql = str_replace('[JOIN_GROUPS_TOKEN]', $this->GetJoinGroups(), $sql);
        $sql = str_replace('[AND_GROUP_PERSON_TOKEN]', $this->GetAndGroupPerson(), $sql);

        if($nolimit){
            $sql = str_replace('[LIMIT_TOKEN]', "", $sql);
        }
        else{
            $sql = str_replace('[LIMIT_TOKEN]', $this->GetLimit(), $sql);
        }

        $query = new AdHocCommand($sql);
        foreach ($this->parameters as $parameter)
        {
            $query->AddParameter($parameter);
        }

        return $query;
    }

    public function getTemplate() {
        if($this->zeroFill){
            $sql = self::REPORT_TEMPLATE_ZEROS;
            $sql = str_replace('[SELECT_ZEROS]', $this->GetSelectZeros(), $sql);
            $sql = str_replace('[WHERE_ZEROS]', $this->GetWhereZeros(), $sql);
        }
        else{
            $sql = self::REPORT_TEMPLATE;
        }
        return $sql;
    }

    public function GetPartToken() {
        if($this->firstPart && $this->groupByUser){
            if($this->count || !empty($_POST['training'])){
                if(!empty($_POST['training'])){
                    return self::PARTICIPANT_COUNT_TOKEN_TRAINING;
                }
                else{
                    return self::PARTICIPANT_COUNT_TOKEN;
                }
            }
            else if($this->time){
                return self::PARTICIPANT_TIME_TOKEN;
            }
        }
        else{
            return "";
        }
    }

    public function GetSelectZeros() {
        if($this->count){
            return self::SELECT_COUNT_ZEROS;
        }
        else if($this->time){
            return self::SELECT_TIME_ZEROS;
        }
    }

    public function GetWhereZeros() {
        $and = new ReportQueryFragment();
        if($this->count){
            if($this->customParticipantResults){
                $and->Append(self::WHERE_ZERO_COUNT_PART);
            }
            else{
                $and->Append(self::WHERE_ZERO_COUNT);
            }
        }
        else if($this->time){
            if($this->customParticipantResults){
                $and->Append(self::WHERE_ZERO_TIME_PART);
            }
            else{
                $and->Append(self::WHERE_ZERO_TIME);
            }

        }

        if (!empty($this->userId))
        {
            $and->Append(self::USER_ID_FRAGMENT);
        }

        return $and;
    }

    public function GetJoinGroups() {
        if ($this->joinGroups){
            return self::GROUP_JOIN_FRAGMENT;
        }
        else{
            return "";
        }
    }

    public function GetAndGroupPerson() {
        if ($this->joinGroups){
            return self::GROUP_ID_FRAGMENT;
        }
        else{
            return "";
        }
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetSelectList()
    {
        $selectSql = new ReportQueryFragment();

        /*LOOKUP PART*/
        if($this->firstPart && $this->groupByUser && $this->count){
            if(empty($_POST['training'])){
                $selectSql->Append(self::COUNT_FRAGMENT_PART);
            }
            else{
                $selectSql->Append(self::COUNT_FRAGMENT_PART_TRAINING);
            }
            return $selectSql;
        }
        else if($this->firstPart && $this->groupByUser && $this->time){
            $selectSql->Append(self::TOTAL_TIME_FRAGMENT_PART);
            return $selectSql;
        }
        else if($this->doubles && ($_POST['reportResults']=="TIME" || $_POST['reportResults']=="COUNT") && isset($_POST['REPORT_GROUPBY']) && $_POST['REPORT_GROUPBY']=="RESOURCE"){
            $selectSql->Append(self::DOUBLES_SELECT_RESOURCES);
            return $selectSql;
        }
        else if($this->doubles && ($_POST['reportResults']=="TIME" || $_POST['reportResults']=="COUNT") && isset($_POST['REPORT_GROUPBY']) && $_POST['REPORT_GROUPBY']=="SCHEDULE"){
            $selectSql->Append(self::DOUBLES_SELECT_SCHEDULES);
            return $selectSql;
        }
        else if(!empty($_POST['training'])){
            $selectSql->Append(self::COUNT_FRAGMENT_PART);
            return $selectSql;
        }


        if ($this->fullList)
        {
            $selectSql->Append(self::RESERVATION_LIST_FRAGMENT);
        }

        if ($this->count)
        {
            $selectSql->Append(self::COUNT_FRAGMENT);
        }

        if ($this->time)
        {
            $selectSql->Append(self::TOTAL_TIME_FRAGMENT);
        }

        if ($this->listResources && ($this->fullList || $this->groupByResource))
        {
            $selectSql->AppendSelect(self::RESOURCE_LIST_FRAGMENT);
        }

        if ($this->listAccessories && $this->fullList)
        {
            $selectSql->AppendSelect(self::ACCESSORY_LIST_FRAGMENT);
        }

        if ($this->listGroups)
        {
            $selectSql->AppendSelect(self::GROUP_LIST_FRAGMENT);
        }

        if ($this->listUsers)
        {
            $selectSql->AppendSelect(self::USER_LIST_FRAGMENT);
        }

        if ($this->listSchedules)
        {
            $selectSql->AppendSelect(self::SCHEDULE_LIST_FRAGMENT);
        }

        return $selectSql;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetJoin()
    {
        $join = new ReportQueryFragment();

        if ($this->joinResources)
        {
            $join->Append(self::RESOURCE_JOIN_FRAGMENT);
        }

        if ($this->joinAccessories)
        {
            $join->Append(self::ACCESSORY_JOIN_FRAGMENT);
        }

        if ($this->joinGroups)
        {
            $join->Append(self::GROUP_JOIN_FRAGMENT);
        }

        if ($this->doubles && $_POST['REPORT_GROUPBY']!="NONE"){
            $join->Append(self::DOUBLES_JOIN);
        }

        return $join;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetUnion()
    {
        $join = new ReportQueryFragment();

        if ($this->firstPart && $this->groupByUser)
        {
            if($this->zeroFill){
                $join->Append(self::FIRST_PARTICIPANT_UNION_FRAGMENT_ZERO_FILL);
            }
            else{
                $join->Append(self::FIRST_PARTICIPANT_UNION_FRAGMENT);
            }
        }
        else{
            $join->Append("");
        }

        return $join;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetWhereAnd()
    {
        $and = new ReportQueryFragment();

        if (!empty($this->scheduleId))
        {
            $and->Append(self::SCHEDULE_ID_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $this->scheduleId));
        }

        if (!empty($this->userId))
        {
            $and->Append(self::USER_ID_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::USER_ID, $this->userId));
        }

        if (!empty($this->groupId))
        {
            $and->Append(self::GROUP_ID_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $this->groupId));
        }

        if (!empty($this->resourceId))
        {
            $and->Append(self::RESOURCE_ID_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $this->resourceId));
        }

        if (!empty($this->accessoryId))
        {
            $and->Append(self::ACCESSORY_ID_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $this->accessoryId));
        }

        if ($this->limitWithin)
        {
            $and->Append(self::DATE_FRAGMENT);
            $this->AddParameter(new Parameter(ParameterNames::START_DATE, $this->startDate->ToDatabase()));
            $this->AddParameter(new Parameter(ParameterNames::END_DATE, $this->endDate->ToDatabase()));
        }

        return $and;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetGroupBy()
    {
        $groupBy = new ReportQueryFragment();
        if($this->doubles){
            if($this->groupBySchedule){
                $groupBy->Append(self::DOUBLES_GROUP_BY_SCHEDULE);
                return $groupBy;
            }
            else if($this->groupByResource){
                $groupBy->Append(self::DOUBLES_GROUP_BY_RESOURCE);
                return $groupBy;
            }
        }
        if ($this->fullList)
        {
            return $groupBy;
        }
        if ($this->groupByGroup)
        {
            $groupBy->Append(self::GROUP_BY_GROUP_FRAGMENT);
        }

        if ($this->groupByResource)
        {
            $groupBy->Append(self::GROUP_BY_RESOURCE_FRAGMENT);
        }

        if ($this->groupBySchedule)
        {
            $groupBy->Append(self::GROUP_BY_SCHEDULE_FRAGMENT);
        }

        if ($this->groupByUser)
        {
            $groupBy->Append(self::GROUP_BY_USER_FRAGMENT);
        }

        return $groupBy;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetOrderBy()
    {
        $orderBy = new ReportQueryFragment();
        if ($this->fullList)
        {
            $orderBy->Append(self::ORDER_BY_FRAGMENT);
        }
        else {
            if ($this->count)
            {
                if($this->customParticipantResults){
                    if(empty($_POST['training'])){
                        $orderBy->Append(self::TOTAL_ORDER_BY_FRAGMENT_USER);
                    }
                    else{
                        $orderBy->Append(self::TOTAL_ORDER_BY_FRAGMENT_USER_TRAINING);
                    }

                }
                else{
                    $orderBy->Append(self::TOTAL_ORDER_BY_FRAGMENT);
                }
            }
            else
            {
                if($this->customParticipantResults){
                    $orderBy->Append(self::TIME_ORDER_BY_FRAGMENT_USER);
                }
                else{
                    $orderBy->Append(self::TIME_ORDER_BY_FRAGMENT);
                }
            }
        }

        return $orderBy;
    }

    /**
     * @return ReportQueryFragment
     */
    private function GetLimit()
    {
        $limit = new ReportQueryFragment();
        if (!empty($this->limit))
        {
            $limit->Append("LIMIT 0 , {$this->limit}");
        }

        return $limit;
    }

    private function AddParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;
    }
}

class ReportQueryFragment
{
    private $sql = '';

    public function Append($sql)
    {
        $this->sql .= " $sql";
    }

    public function AppendSelect($selectSql)
    {
        $this->sql .= ",$selectSql";
    }

    public function __toString()
    {
        return $this->sql;
    }
}

?>