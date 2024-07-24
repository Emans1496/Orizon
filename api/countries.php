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
            getCountries($id);
        } else {
            getCountries();
        }
        break;

    case 'POST':
        addCountry();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        updateCountry($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteCountry($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getCountries($id = 0) {
    global $db;
    $query = "SELECT * FROM countries";
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

function addCountry() {
    global $db;

    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data["name"];

    if (countryExists($name)) {
        $response = array(
            "status" => "error",
            "message" => "Country already exists."
        );
        echo json_encode($response);
        return;
    }

    $query = "INSERT INTO countries SET name=:name";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":name", $name);

    if($stmt->execute()) {
        $response = array(
            "status" => "success",
            "message" => "Country added successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to add country."
        );
    }
    echo json_encode($response);
}

function countryExists($name) {
    global $db;

    $query = "SELECT COUNT(*) as count FROM countries WHERE LOWER(name) = LOWER(:name)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['count'] > 0;
}

function updateCountry($id) {
    global $db;

    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data["name"];

    if (countryExists($name)) {
        $response = array(
            "status" => "error",
            "message" => "Country already exists."
        );
        echo json_encode($response);
        return;
    }

    $query = "UPDATE countries SET name=:name WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":id", $id);

    if($stmt->execute()) {
        $response = array(
            "status" => "success",
            "message" => "Country updated successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to update country."
        );
    }
    echo json_encode($response);
}

function deleteCountry($id) {
    global $db;
    $query = "DELETE FROM countries WHERE id=" . $id;
    if($db->exec($query)) {
        $response = array(
            "status" => "success",
            "message" => "Country deleted successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Failed to delete country."
        );
    }
    echo json_encode($response);
}
?>
