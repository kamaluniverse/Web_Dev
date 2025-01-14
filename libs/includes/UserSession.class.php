<?php



class UserSession
{
    private $conn;
    private $token;
    private $data;
    private $id;

    /*
     * This function will return a session ID if username and password is correct.
     * @return SessionID
     */
    public static function authenticate($user, $pass)
    {
        $username = User::checklogin($user, $pass);
        if ($username) {
            $user = new User($username);
            $conn = Database::getConnection();
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $token = md5(rand(0, 9999999) . $ip . $agent . time());
            $query = "INSERT INTO `session` (`uid`, `token`, `login_time`, `ip`, `user_agent`, `active`) VALUES ('$user->id', '$token', now(), '$ip', '$agent', '1');";
            if ($conn->query($query)) {
                Session::set('session_token', $token);
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function authorize($token)
    {
        $obj = new UserSession($token);
        if ($obj->isValid()) {
            return new UserSession($token);
        } else {
            return false;
        }
    }

    public function __construct($token)
    {
        //print("token : $token");
        $this->conn = Database::getConnection();
        $this->token = $token;
        $this->data = null;
        $query = "SELECT * FROM `session` WHERE `token` = '$token'";
        //print("$query");
        $result = $this->conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->data = $row;
            $this->id = $row['uid'];
            // echo "user Object Constructed for id: $this->id";
        } else {
            echo "Session Expired.";
            throw new Exception("Session is invalid.");
        }
    }

    public function getUser()
    {
        return new User($this->id);
    }

    /**
     * Check if the validity of the session is within one hour, else make it inactive.
     * @return Boolean
     */

    public function isValid()
    {
        if ($this->data['active']) {
            $currentDate = new DateTime();
            $retrievedDate = new DateTime($this->data['login_time']);
            $interval = $currentDate->diff($retrievedDate);
            if ($interval->h < 1 && $interval->days == 0 && $interval->i <= 60) {
                return true;
            } else {
                self::deactivate();
                return false;
            }
        } else {
            return false;
        }
    }

    public function getIp()
    {
        return $this->data['ip'];
    }

    public function getUserAgent()
    {
        return $this->data['user_agent'];
    }

    public function deactivate()
    {
        //print_r($this->data);
        $conn = Database::getConnection();
        $token = $this->data['token'];
        $query = "UPDATE `session` SET `active` = '0' WHERE `token` = '$token';";
        //$query = "UPDATE `session` SET`active` = '0' WHERE `uid` = '$this->data['uid']';";
        //print("Deactivating.. $query");
        if ($this->conn->query($query) === true) {
            Session::destroy();
        } else {
            //echo "Error updating record: " . $this->conn->error;
            throw new Exception("Session deactivation failed.");
        }
    }
}
