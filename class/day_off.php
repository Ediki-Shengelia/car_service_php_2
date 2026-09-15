<?php



// CREATE TABLE day_off(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     staff_id INT NOT NULL,
//     date_time DATE NOT NULL,
//     reason TEXT DEFAULT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
// );

class Day_off extends Db_object
{
    public static $db_table_name = "day_off";
    public static $db_table_fields = array('staff_id', 'date_time', 'reason');
    public $id;
    public $staff_id;
    public $date_time;
    public $reason;
}
