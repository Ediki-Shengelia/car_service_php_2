<?php


class Working_hours extends Db_object
{
    public static $db_table_name = "working_hours";
    public static $db_table_fields = array('staff_id', 'day_of_week', 'start_time', 'end_time', 'is_day_off', 'date_for_day_off');
    public $id;
    public $staff_id;
    public $day_of_week;
    public $start_time;
    public $end_time;
    public $is_day_off;
    public $date_for_day_off;
    public static function create_working_hours_for_worker($staff_id, $is_day_off = false)
    {

        $days =  ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($days as $day) {
            $wh = new Working_hours();
            $wh->staff_id = $staff_id;
            $wh->day_of_week = $day;
            $wh->start_time = '09:00:00';
            $wh->end_time = '18:00:00';
            $wh->is_day_off = $is_day_off;


            $wh->create();
        }
    }
    public static function add_day_off_day($staff_id, $day_name, $date_for_day_off = null)
    {
        global $database; // შენი ბაზის კავშირის გლობალური ობიექტი

        $staff_id = (int)$staff_id;
        $day_name = $database->escape_string($day_name);
        $date_for_day_off = $database->escape_string($date_for_day_off);

        $sql  = "UPDATE " . static::$db_table_name . " ";
        $sql .= "SET is_day_off = 1, date_for_day_off = '{$date_for_day_off}' ";
        $sql .= "WHERE staff_id = {$staff_id} AND day_of_week = '{$day_name}'";

        return $database->query($sql);
    }
    public static function  refresh_day_off($staff_id, $day_name, $date_for_day_off)
    {
        global $database; // შენი ბაზის კავშირის გლობალური ობიექტი

        $staff_id = (int)$staff_id;
        $day_name = $database->escape_string($day_name);
        $date_for_day_off = $database->escape_string($date_for_day_off);

        $sql  = "UPDATE " . static::$db_table_name . " ";
        $sql .= "SET is_day_off = 0, date_for_day_off = NULL ";
        $sql .= "WHERE staff_id = {$staff_id} AND day_of_week = '{$day_name}'";

        return $database->query($sql);
    }
}
