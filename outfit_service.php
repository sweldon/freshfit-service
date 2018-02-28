<?php
/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 29/05/17
 * Time: 8:39 PM
 */

require_once 'Outfit.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $outfit = new Outfit();
      $response['error'] = false;
      // As an example check out DbOperation.getUserByUsername(username)
      $response = $outfit->getShirts($_POST['userid']);

} else {
    $response['error'] = true;
    $response['message'] = "We cannot give you anything if you give us nothing...";
}

echo json_encode($response);
