<?php
    include "../config/database.php";

    $webhookResponse = json_decode(file_get_contents('php://input'), true);
    $topic = $webhookResponse['topic'];
    $payload = $webhookResponse['payload'];

    $topicExplode = explode("/", $topic);

    $serialNumber = $topicExplode[1];
    $name = $topicExplode[2];

    $select_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM devices WHERE serial_number = '$serialNumber' LIMIT 1"));
    $serial_number = $select_data['serial_number'];
    $username = $select_data['username'];

    if ($serialNumber === $serial_number) {
        $serial_number = $serialNumber;
    }

    if ($topicExplode[2] == "suhu" || $topicExplode[2] == "kelembapan" || $topicExplode[2] == "intensitas_cahaya") {
        $type = "sensor";
    }
    else {
        $type = "actuator";
    }
    
    $sql = "INSERT INTO data(serial_number, username, sensor_actuator, value, name, mqtt_topic) VALUES('$serial_number', '$username', '$type', '$payload', '$name', '$topic')";
    mysqli_query($conn, $sql);
?>