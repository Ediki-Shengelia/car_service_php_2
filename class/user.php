<?php
// ALTER TABLE users ADD COLUMN role ENUM('user','employee') DEFAULT "user" AFTER email;
class User extends Db_object
{
    public static $db_table_name = "users";
    public static $db_table_fields = array('name', 'email', 'password', 'role', 'user_image');
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $user_image;
    public $created_at;
    // ! for Images
    public $tmp_name;
    public $errors = array();
    public $placeholder = "https://cdn-icons-png.flaticon.com/512/428/428573.png";
    public $directory = "users";
    public $upload_errors_array = array(
        UPLOAD_ERR_OK         => 'File uploaded successfully.',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
        UPLOAD_ERR_PARTIAL    => 'The file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write the file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    );
    public function __construct()
    {
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true);
        }
    }
    public function user_with_image()
    {
        return empty($this->user_image) ? $this->placeholder : $this->directory . DS . $this->user_image;
    }
    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "The file is NOT avialable";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->tmp_name = $file['tmp_name'];
            $this->user_image = basename($file['name']);
        }
    }
    public function save_user_with_photo()
    {
        if (!empty($this->errors)) {
            $this->errors[] = "There is some PROblems!!!";
            return false;
        }
        if (empty($this->tmp_name) || empty($this->user_image)) {
            $this->errors[] = "The file is ot avialable";
            return false;
        }
        $target_path = SITE_ROOT . DS . $this->directory . DS . $this->user_image;
        if (file_exists($target_path)) {
            $this->errors[] = "The File {$this->user_image} AlreadY exists";
            return false;
        }
        if (move_uploaded_file($this->tmp_name, $target_path)) {
            return true;
        }
        return false;
    }
    #[Override]
    public function create()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        return parent::create();
    }
    #[Override]
    public function update()
    {
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
        return parent::update();
    }
    public static function verify_user($email, $password)
    {
        global $database;
        $sql = "SELECT * FROM " . self::$db_table_name . " WHERE email='" . $database->escape_string($email) . "' LIMIT 1";
        $result = self::find_this_query($sql);
        $the_user = array_shift($result);
        if (!$the_user) {
            return false;
        }
        return password_verify($password, $the_user->password) ? $the_user : false;
    }
    public function delete_user_with_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . $this->directory . DS . $this->user_image;
            unlink($target_path);
            return true;
        }
        return false;
    }
}
