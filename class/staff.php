<?php

// CREATE TABLE staff(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
// 	user_id INT NOT NULL UNIQUE,
//     phone VARCHAR(20) NOT NULL UNIQUE,
//     status ENUM('active','inactive') DEFAULT 'active',
//     specialization VARCHAR(255) DEFAULT NULL,
//     role VARCHAR(255) NOT NULL,
//     salary DECIMAL(10,2) DEFAULT NULL,
//     hire_date DATE NOT NULL,
//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );

class Staff extends Db_object
{
    public static $db_table_name = "staff";
    public static $db_table_fields = array('user_id', 'phone', 'status', 'specialization', 'role', 'salary', 'hire_date');
    public $id;
    public $user_id;
    public $phone;
    public $status;
    public $specialization;
    public $role;
    public $salary;
    public $hire_date;
    public static function getUserInfo($id)
    {
        $sql = "SELECT * FROM staff WHERE id=" . (int)$id;
        $result = self::find_this_query($sql);
        $staff = array_shift($result);
        return $staff ? $staff->user_id : null;
    }
}
