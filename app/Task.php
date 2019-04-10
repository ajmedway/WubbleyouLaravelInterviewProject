<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Coduo\PHPHumanizer\StringHumanizer;

class Task extends Model
{
    const PRIORITY_LOW = 'low_priority';
    const PRIORITY_MEDIUM = 'medium_priority';
    const PRIORITY_HIGH = 'high_priority';

    public static $PRIORITIES = [
        self::PRIORITY_LOW,
        self::PRIORITY_MEDIUM,
        self::PRIORITY_HIGH,
    ];

    /**
     * @param bool $valuesAsKeys
     * @return array
     */
    public static function getPriorityOptions($valuesAsKeys = true)
    {
        if ($valuesAsKeys) {
            $priorityLabels = array_map(function($val) {
                return StringHumanizer::humanize($val);
            }, self::$PRIORITIES);
            return array_combine(self::$PRIORITIES, $priorityLabels);
        }
        return self::$PRIORITIES;
    }
}
