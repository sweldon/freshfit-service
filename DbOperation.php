<?php

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function userLogin($username, $pass)
     {
         $password = md5($pass);
         $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
         $stmt->bind_param("ss", $username, $password);
         $stmt->execute();
         $stmt->store_result();
         return $stmt->num_rows > 0;
     }

     /*
      * After the successful login we will call this method
      * this method will return the user data in an array
      * */

     public function getUserByUsername($username)
     {
         $stmt = $this->conn->prepare("SELECT id, username FROM users WHERE username = ?");
         $stmt->bind_param("s", $username);
         $stmt->execute();
         $stmt->bind_result($id, $uname);
         $stmt->fetch();
         $user = array();
         $user['id'] = $id;
         $user['username'] = $uname;
         return $user;
     }

    //Function to create a new user
    public function createUser($username, $pass)
    {
        if (!$this->isUserExist($username)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($username)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
