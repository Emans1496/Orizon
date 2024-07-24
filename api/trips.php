<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getTrips($id);
        } else {
            getTrips();
        }
        break;

    case 'POST':
        addTrip();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        updateTrip($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteTrip($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getTrips($id = 0) {
    global $db;
    $query = "SELECT * FROM trips";
    if($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $stmt = $db->prepare($query);
    $stmt->execute();
    $response = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
}

function addTrip() {
    global $db;

    $data = json_decode(file_get_contents('php://input'), true);
    $countries = $data["countries"];
    $available_spots = $data["available_spots"];

    if (empty($countries)) {
        $response = array(
            "status" => "error",
            "message" => "Please enter a value for countries."
        );
        echo json_encode($response);
        return;
    }

    $query = "INSERT INTO trips SET countries=:countries, available_spots=:available_spots";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":countries", $countries);
    $stmt->bindParam(":available_spots", $available_spots);

    if($stmt->execute()) {
        $response = array(
            "status" => "success",
            "message" => "Trip added successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to add trip."
        );
    }
    echo json_encode($response);
}

function updateTrip($id) {
    global $db;

    $data = json_decode(file_get_contents("php://input"), true);
    $countries = $data["countries"];
    $available_spots = $data["available_spots"];

    $query = "UPDATE trips SET countries=:countries, available_spots=:available_spots WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":countries", $countries);
    $stmt->bindParam(":available_spots", $available_spots);
    $stmt->bindParam(":id", $id);

    if($stmt->execute()) {
        $response = array(
            "status" => "success",
            "message" => "Trip updated successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to update trip."
        );
    }
    echo json_encode($response);
}

function deleteTrip($id) {
    global $db;
    $query = "DELETE FROM trips WHERE id=" . $id;
    if($db->exec($query)) {
        $response = array(
            "status" => "success",
            "message" => "Trip deleted successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to delete trip."
        );
    }
    echo json_encode($response);
}
?>
