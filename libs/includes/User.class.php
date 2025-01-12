<?php

class User
{
    private $conn;
    private $username;
    public $id;

    /*
     * '__call' is the magic function available in php, which will be invoked automatically if the requested method is not availabkle.
     * In this case, We used '__call' method to reduce number of lines of code, that means this method will invoke two methods (_set_data and _get_data) dynamically. 
     */

    public function __call($name, $arguments)
    {
        //echo "call magic function<br>";
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3)); //removes set, get (first three characters)
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property)); //changes other cases to snake case.
        //echo $property."<br>"; 
        if (substr($name, 0, 3) == "get") { //if method requested to get from data base.
            return $this->_get_data($property);
        } else if (substr($name, 0, 3) == "set") { //if method requested to set(update) to data base.
            return $this->_set_data($property, $arguments[0]);
        } else {
            throw new Exception("User::__call() -> $name, function unavailable."); //If no called class is not exist with get and set, then throwing error in order to identify.
        }
    }

    /*
    * Constructor gets id of username and stores it to $id variable.
    * This stored $id can be used to do other stuffs. 
    * User Object can be constructed with both UserID and Username.
    */

    public function __construct($username)
    {
        $this->conn = Database::getConnection();
        $this->username = $username;
        $query = "SELECT `id` FROM `auth` WHERE `username` = '$username' OR `id` = '$username'";
        $result = $this->conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            // echo "user Object Constructed for id: $this->id";
        } else {
            //echo "User not found.";
            throw new Exception("User::__construct() -> Username not found.");
        }
    }

    //private static $salt = "alsdfjlnvajdsfurejfjds"; {implemented for understanding}

    public static function signup($username, $phone, $email, $password)
    {
        $options = [
            'cost' => 9,
        ];

        $password = password_hash($password, PASSWORD_BCRYPT, $options); //most secure and prefered way for password saving, suggested by official php
        $conn = Database::getConnection();
        try {
            $sql = "INSERT INTO `auth` (`username`, `password`, `email`, `phone`, `blocked`, `active`)
                        VALUES ('$username', '$password', '$email', '$phone', '0', '1');";

            $error = false;
            if ($conn->query($sql) === true) {
                $error = false;
            } //else {
            //     echo "Error: " . $sql . "<br>" . $conn->error;
            //     $result = false;
            // }
        } catch (Exception $e) {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            //echo $e;
            $error = $conn->error;
        }
        //$conn->close();
        return $error;
    }

    public static function login($email, $pass)
    {
        //$pass = md5(strrev(md5($pass)) . Self::$salt); {implemented for understanding}
        $row = false;
        $conn = Database::getConnection(); //invoking Connection Using Database Class.
        $sql = "SELECT `username`,`email`, `password` FROM `auth` WHERE `email` = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            //if (hash_equals($row['password'], $pass)) { //having time constraint for password matching. other operator won't have any constraint.
            if (password_verify($pass, $row['password'])) {  //most secure and prefered way for password saving, suggested by official php
                $row['auth'] = true;
            }
        } else {
            $row = false;
        }
        //$conn->close();
        return $row;
    }

    public static function checklogin($username, $pass) //written for learning
    {
        //$pass = md5(strrev(md5($pass)) . Self::$salt); {implemented for understanding}
        $query = "SELECT * FROM `auth` WHERE `username` = '$username'";
        $conn = Database::getConnection();
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // if ($row['password'] == $pass) {
            if (password_verify($pass, $row['password'])) { //most secure and prefered way for password saving, suggested by official php
                /* ToDo
                1. Generate Session Token.
                2. Insert Session Token
                3. Build Session and session to user.
                */
                return $row['username']; //returning username on successful login.
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Testing Functions.
    // private function _get_data($property)
    // {
    //     return isset($this->properties[$property]) ? $this->properties[$property] : null;
    // }

    // private function _set_data($property, $value)
    // {
    //     $this->properties[$property] = $value;
    //     return $this;
    // }


    //Updates data to database. (invoked by __call method).

    public function _set_data($key, $value)
    {
        $this->conn = Database::getConnection();
        $query = "UPDATE `users` SET `$key` = '$value' WHERE `id` = '$this->id';";
        if ($this->conn->query($query) === TRUE) {
            return True;
        } else {
            //echo "Error updating record: " . $this->conn->error;
            return False;
        }
    }

    //Retrives data from database. (invoked by __call method).
    public function _get_data($key)
    {
        $query = "SELECT `$key` FROM `users` WHERE `id` = '$this->id'";
        //echo $query;
        $this->conn = Database::getConnection();
        $result = $this->conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $result = $row[$key];
            return $result;
        } else {
            return false;
        }
    }

    /* 
    * Since Date of Birth has special format, a override method is written for updating Dob. 
    * However it formats the dob and invokes _set_data method to update.
    */
    public function setDob($month, $day, $year)
    {
        if (checkdate($month, $day, $year)) {
            return $this->_set_data("firstname", $month, $day, $year);
        } else {
            return false;
        }
    }

    /*
    * Since Username is not in the User table, Override method for getting Username from auth table.
    * Here this username is given by user and verified indirectly in constructor and stored in $username variable.
    */

    public function getUsername()
    {
        return $this->username;
    }

    //Below comments are sample comments, that represents what if magic methods are not available.

    // public function setBio($bio)
    // {
    //     $this->_set_data("bio", $bio);
    // }

    // public function getBio()
    // {
    //     return $this->_get_data("bio");
    // }

    // public function setAvatar($link)
    // {
    //     $this->_set_data("link", $link);
    // }

    // public function getAvatar()
    // {
    //     return $this->_get_data("avatar");
    // }

    // public function setFirstname($firstname)
    // {
    //     $this->_set_data("firstname", $firstname);
    // }

    // public function getFirstname()
    // {
    //     return $this->_get_data("firstname");
    // }

    // public function setLastname($lastname)
    // {
    //     $this->_set_data("lastname", $lastname);
    // }

    // public function getLastname()
    // {
    // }

    // public function getDob()
    // {
    // }

    // public function setInstagram($instagram)
    // {
    //     $this->_set_data("instagram", $instagram);
    // }

    // public function getInstagram()
    // {
    // }

    // public function setTwitter()
    // {
    // }

    // public function getTwitter()
    // {
    // }

    // public function setFacebook()
    // {
    // }

    // public function getFacebook()
    // {
    // }
}