<?php



// CREATE TABLE services(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     staff_id INT NOT NULL,
//     service VARCHAR(255) NOT NULL,
//     description TEXT DEFAULT NULL,
//     completed_at DATETIME DEFAULT NULL,
//     status ENUM('pending','in_progress','completed','cancelled') DEFAULT 'pending',
//     price DECIMAL(10,2) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
// );

class Service extends Db_object
{
    public static $db_table_name = "services";
    public static $db_table_fields = array('staff_id', 'service', 'description', 'completed_at', 'status', 'price', 'created_at');
    public $id;
    public $staff_id;
    public $service;
    public $description;
    public $completed_at;
    public $status;
    public $price;
    public $created_at;
}
