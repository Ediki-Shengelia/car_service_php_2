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

    // !
    public function create_and_calculate_time_of_service()
    {

        $services = [
            'Engine_service'  => ['price' => 1400, 'eta' => '+2 days'],
            'Fuel_service'    => ['price' => 100,  'eta' => '+1 hours'],
            'Item_service'    => ['price' => 220,  'eta' => '+125 minutes'],
            'Electrical'      => ['price' => 850,  'eta' => '+36 hours'],
        ];

        if (!isset($services[$this->service])) {
            return;
        }
        $this->price = $services[$this->service]['price'];
        $this->completed_at = date("Y-m-d H:i:s", strtotime($services[$this->service]['eta']));
    }
    public static function check_status($id, $cancell = false)
    {
        $service = self::find_by_id($id);
        if ($service->status == "completed" || $service->status == "cancelled") {
            return $service->status;
        }

        if ($cancell) {
            $service->status = "cancelled";
            $service->update();
            return $service->status;
        }
        $current_time = date("Y-m-d H:i:s");
        if ($current_time >= $service->completed_at) {
            $service->status = "completed";
            $service->update();
        }
        return $service->status;
    }
    public static function check_service_status($id)
    {
        $sql = "SELECT * FROM " . self::$db_table_name;
        $sql .= " WHERE staff_id=" . (int)$id;
        $sql .= " AND status='in_progress'";
        $result = self::find_this_query($sql);
        return !empty($result);
    }

}
