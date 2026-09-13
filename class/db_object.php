<?php

class Db_object
{

    public function has_the_attribute($the_attribute)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }
    public static function instantiation($the_record)
    {
        $calling_class = get_called_class();
        $the_obj = new $calling_class;
        foreach ($the_record as $key => $value) {
            if ($the_obj->has_the_attribute($key)) {
                $the_obj->$key = $value;
            }
        }
        return $the_obj;
    }
    public function properties()
    {
        $the_array = array();
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $the_array[$db_field] = $this->$db_field;
            }
        }
        return $the_array;
    }
    public function clean_properties()
    {
        global $database;
        $the_array = array();
        foreach ($this->properties() as $key => $value) {
            $the_array[$key] = $database->escape_string($value);
        }
        return $the_array;
    }
    public static function find_this_query($sql)
    {
        global $database;
        $result = $database->query($sql);
        $the_array = array();
        while ($row = mysqli_fetch_array($result)) {
            $the_array[] = self::instantiation($row);
        }
        return $the_array;
    }
    public static function find_all()
    {
        return self::find_this_query("SELECT * FROM " . static::$db_table_name);
    }
    public static function  find_by_id($id)
    {

        $sql = "SELECT * FROM " . static::$db_table_name . " WHERE id =" . $id . " LIMIT 1";
        $result = self::find_this_query($sql);
        return !empty($result) ? array_shift($result) : false;
    }
    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table_name . " (";
        $sql .= implode(",", array_keys($properties)) . ") VALUES('";
        $sql .= implode("','", array_values($properties)) . "')";
        $result = $database->query($sql);
        if (!empty($result)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }
    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $the_array = array();
        foreach ($properties as $key => $value) {
            $the_array[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . static::$db_table_name . " SET ";
        $sql .= implode(",", $the_array);
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$db_table_name . " WHERE id=" . $database->escape_string($this->id);
        $database->query($sql);
        return true;
    }
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }
    public static function count_all()
    {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table_name;
        $result = $database->query($sql);
        $arr = mysqli_fetch_array($result);
        return array_shift($arr);
    }
}
