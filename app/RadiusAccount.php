<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RadiusAccount extends Model {
    protected $table = 'radacct';
    protected $primaryKey = 'radacctid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acctsessionid',
        'acctuniqueid',
        'username',
        'groupname',
        'realm',
        'nasipaddress',
        'nasportid',
        'nasporttype',
        'acctstarttime',
        'acctstoptime',
        'acctsessiontime',
        'acctauthentic',
        'connectioninfo_start',
        'connectioninfo_stop',
        'acctinputoctets',
        'acctoutputoctets',
        'calledstationid',
        'callingstationid',
        'acctterminatecause',
        'servicetype',
        'framedprotocol',
        'framedipaddress',
        'acctstodelay',
        'xascendsessionsvrkey',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * retrieves the number of connections for a specific time period (day, month, year)
     * and optionally limits it to a specific user.
     *
     * @param string $timePeriod
     * @param string $timeValue
     * @param boolean $groupByUsername
     * @param string $username
     * @return mixed
     */
    public static function getConnections($timePeriod = 'day', $timeValue = null, $groupByUsername = false, $username = null) {
        $sql = self::getTimePeriodSQL($timePeriod);
        $query = self::selectRaw($sql);

        if ($timeValue !== null) {
            $query->having($timePeriod, '=', $timeValue);
        }

        if ($username !== null) {
            $query->where('username', $username)
                ->groupBy($timePeriod);
        } else {
            if ($groupByUsername) {
                $query->groupBy($timePeriod, 'username');
            } else {
                $query->groupBy($timePeriod);
            }
        }

        return $query;
    }

    /**
     * calculates the total bandwidth used for the year and returns an array with
     * download/upload converted to gb.
     *
     * @param string $username
     * @return array
     */
    public static function getMonthlyBandwidthUsage($username = null) {
        $sql = "MONTH(acctstarttime) AS month, sum(acctinputoctets) as download, sum(acctoutputoctets) as upload";
        $query = self::selectRaw($sql)
            ->groupBy('month');

        if ($username !== null) {
            $query->where('username', $username);
        }

        $query = $query->get();

        $usage = [
            'download' => [0,0,0,0,0,0,0,0,0,0,0,0],
            'upload'   => [0,0,0,0,0,0,0,0,0,0,0,0]
        ];

        foreach ($query as $result) {
            $usage['download'][$result->month - 1] += $result->download;
            $usage['upload'][$result->month - 1]   += $result->upload;
        }

        foreach($usage as $type => $values) {
            foreach ($values as $index => $value) {
                $usage[$type][$index] = round($value / 1000000000, 2);
            }
        }

        return $usage;
    }

    public static function onlineStatus($username) {
        $query = self::select('username')
            ->where('AcctStopTime', 'IS', 'NULL')
            ->where('Username', $username)
            ->orWhere('AcctStopTime', '0000-00-00 00:00:00')
            ->where('username', $username);

        return ($query->count() > 0) ? true : false;
    }

    /**
     * Return the sql statement for a desired time period
     *
     * @param string $timePeriod
     * @return string
     */
    private static function getTimePeriodSQL($timePeriod) {
        switch($timePeriod) {
            default:
            case "day":
                return "username, count(acctstarttime) as connections, DAY(acctstarttime) AS day, sum(acctinputoctets) AS acctinputoctets, sum(acctoutputoctets) AS acctoutputoctets, sum(acctinputoctets + acctoutputoctets) AS total";

            case "month":
                return "username, count(acctstarttime) as connections, MONTH(acctstarttime) AS month, sum(acctinputoctets) AS acctinputoctets, sum(acctoutputoctets) AS acctoutputoctets, sum(acctinputoctets + acctoutputoctets) AS total";

            case "year":
                return "username, count(acctstarttime) as connections, YEAR(acctstarttime) AS year, sum(acctinputoctets) AS acctinputoctets, sum(acctoutputoctets) AS acctoutputoctets, sum(acctinputoctets + acctoutputoctets) AS total";
        }
    }
}