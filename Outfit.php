<?php
  class Outfit
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

    public function getShirts($userid)
    {
        $stmt = $this->conn->prepare("SELECT * from clothes where user_id = ? and type = 'shirt'");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $stmt->bind_result($id, $user, $type, $last_worn, $name);
        $results = array();
        while ($stmt->fetch()) {
          $shirts = array();
          $shirts['id'] = $id;
          $shirts['user'] = $user;
          $shirts['type'] = $type;
          $shirts['last_worn'] = $last_worn;
          $shirts['name'] = $name;
          array_push($results, $shirts);
       }


        return $results;
    }


  }







?>
