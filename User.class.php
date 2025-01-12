<?php


class User
{
    private $conn;

    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));
        if(substr($name,0,3) == "get"){
            return $this->__get($property);
        }elseif(substr($name,0,3) == "set"){
            return $this->__set($name, $arguments[0]);     
        }
    }
    public static function signup($user, $pass, $email, $phone)
    {
        $options = [
            'cost' => 7,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn = Database::getconnection();
        $sql = "INSERT INTO `auth` (`username`, `password`, `email`, `phone`, `blocked`, `active`)
    VALUES ('$user', '$pass', '$email', '$phone', '0', '1')";
        $result = false;
        if ($conn->query($sql) === true) {

            $result = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $result = false;
        }

        $conn->close();
        return $result;


    }
    public static function login($user, $pass)
    {

        $conn = Database::getconnection();
        $query = "SELECT * FROM `auth` WHERE `username` = '$user'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // if ($row['password'] == $pass) {
            if (password_verify($pass, $row['password'])) {
                return $row;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }
    public function __construct($username)
    {
        $this->conn = Database::getconnection();
        // $this->username = $username;
        $sql = "SELECT `id` FROM `auth` WHERE `username` = '$username'";
        $result = $this->conn->query($sql);
if ($result->num_rows()) {
    $row = $result->fetch_assoc();

    // }else $this->id = $row['id'];{
    //     // throw new Exception("Username don't exist");
    // }
}
    }

    public function authenticate()
    {

    }
    public function setBio()
    {
        $conn = Database::getconnection();
    }
    public function getBio()
    {
        $conn = Database::getconnection();
        // $query = "SELECT * FROM `user` WHERE `bio` = $username";
    }
    public function setAvatar()
    {
        $conn = Database::getconnection();
    }
    public function getAvatar()
    {
        $conn = Database::getconnection();
        // $query = "SELECT * FROM `user` WHERE `avatar` = ";
    }
    public function dob()
    {

    }
    public function firstname()
    {

    }
    public function lastname()
    {

    }
    public function instagram()
    {

    }
    public function twitter()
    {

    }
    public function facebook()
    {

    }
}
