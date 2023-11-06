<?php

header('Content-Type: application/json');

// File path
$file_path = __DIR__ . "/devices.json";

// Utility functions
function readDevices() {
    global $file_path;
    if (file_exists($file_path)) {
        $json = file_get_contents($file_path);
        return json_decode($json, true);
    }
    return [];
}

function writeDevices($devices) {
    global $file_path;
    file_put_contents($file_path, json_encode(array_values($devices), JSON_PRETTY_PRINT));
}

// Check endpoint
$endpoint = $_SERVER['REQUEST_URI'];

if ($endpoint === "/api/devices" && $_SERVER["REQUEST_METHOD"] === "GET") {
    echo json_encode(readDevices());
    exit;
}

if ($endpoint === "/api/devices" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? null;
    $devices = readDevices();
    
    if ($action === "add") {
        $name = $_POST["name"];
        $ip = $_POST["ip"];
        $devices[] = ["name" => $name, "ip" => $ip];
        writeDevices($devices);
    } elseif ($action === "delete") {
        $index = $_POST["index"];
        unset($devices[$index]);
        writeDevices($devices);
    }

    echo json_encode(["status" => "success"]);
    exit;
}

?>
