<?php
    include "../config/database.php";

    $webhookResponse = json_decode(file_get_contents('php://input'), true);
    $topic = $webhookResponse['topic'];
    $payload = $webhookResponse['payload'];

    $topicExplode = explode("/", $topic);

    $serialNumber = $topicExplode[1];
    $name = $topicExplode[2];

    $sql_select = mysqli_query($conn, "SELECT username FROM devices WHERE serial_number = '$serialNumber' LIMIT 1");
    $result = mysqli_fetch_assoc($sql_select);
    $username = $result['username'];

    if ($topicExplode[2] == "suhu" || $topicExplode[2] == "kelembapan" || $topicExplode[2] == "intensitas_cahaya") {
        $type = "sensor";
    }
    else {
        $type = "actuator";
    }
    
    $sql = "INSERT INTO data(serial_number, username, sensor_actuator, value, name, mqtt_topic) VALUES('$serialNumber', '$username', '$type', '$payload', '$name', '$topic')";
    mysqli_query($conn, $sql);
?>