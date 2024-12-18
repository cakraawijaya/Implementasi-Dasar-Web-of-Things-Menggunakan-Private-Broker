<?php
  // Baca Tabel Perangkat Yang Aktif
  if ($_SESSION['username'] > 0) {
    $username = $_SESSION['username'];
    $select_serialNumber = mysqli_fetch_assoc(mysqli_query($conn, "SELECT serial_number FROM devices WHERE username = '$username' AND active = 'Yes'"));
    $selectcount_serialNumber = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(serial_number) FROM devices WHERE username = '$username' AND active = 'Yes'"));
    
    if ($select_serialNumber != "") {
      $serial_number = implode(" ", $select_serialNumber);
      $conn_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM iot_connection WHERE serial_number = '$serial_number'"));
      $count_serialNumber = implode(" ", $selectcount_serialNumber);

      if ($count_serialNumber > 1) {
        echo "
        <script>
          alert('Matikan Perangkat yang tidak digunakan!');
          location.href = '?page=device';
        </script>";
        return false;
      }

      if (isset($conn_data['serial_number']) == "") {
        echo "
        <script>
          alert('Koneksi IoT belum dibuat!');
          location.href = '?page=iot_connection';
        </script>";
        return false;
      }
    }

    $userDevice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM devices WHERE username = '$username'"));
    $notActive = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM devices WHERE username = '$username' AND active = 'No'"));

    if ($userDevice == "") {
      echo "
      <script>
        alert('Perangkat belum dibuat!');
        location.href = '?page=device';
      </script>";
      return false;
    } 
    else {
      if ($notActive != "") {
        echo "
        <script>
          alert('Perangkat belum diaktifkan!');
          location.href = '?page=device';
        </script>";
        return false;
      }
      else {
        $sql = "SELECT * FROM devices WHERE username = '$username' AND active = 'Yes'";
        $result = mysqli_query($conn, $sql);
      }
    }
  }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="m-0"><i class="nav-icon fas fa-industry mr-2"></i>Dashboard</h1><hr>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <!-- Suhu -->
          <div class="col-lg-4">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><span id="suhu">(?)</span> °C</h3>

                <p>Suhu</p>
              </div>
              <div class="icon">
                <i class="fas fa-temperature-high"></i>
              </div>
            </div>
          </div>
          <!-- /.col-lg-4 -->

          <!-- Kelembapan -->
          <div class="col-lg-4">
            <div class="small-box bg-indigo">
              <div class="inner">
                <h3><span id="kelembapan">(?)</span> %</h3>

                <p>Kelembapan</p>
              </div>
              <div class="icon">
                <i class="fas fa-cloud-sun"></i>
              </div>
            </div>
          </div>
          <!-- /.col-lg-4 -->

          <!-- Intensitas Cahaya -->
          <div class="col-lg-4">
            <div class="small-box bg-maroon">
              <div class="inner">
                <h3><span id="intensitas_cahaya">(?)</span> lux</h3>

                <p>Intensitas Cahaya</p>
              </div>
              <div class="icon">
                <i class="fas fa-sun"></i>
              </div>
            </div>
          </div>
          <!-- /.col-lg-4 -->   
           
          <!-- Servo -->
          <div class="col-lg-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tachometer-alt mr-2"></i>Servo</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row margin">
                  <div class="col-sm-12">
                    <input id="servo" type="text" onchange="publishServo(this.value)">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-lg-6 -->   

          <!-- Lampu -->
          <div class="col-lg-6">
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-adjust mr-2"></i>Lampu</h3>
              </div>
              <div class="card-body table-responsive pad" style="margin-bottom:13px;">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary" id="label-lampu1-nyala">
                    <input type="radio" name="lampu1" onchange="publishLampu(this.value)" id="option_on" autocomplete="off"><i class="fas fa-lightbulb mr-2"></i>Nyala
                  </label>
                  <label class="btn btn-secondary" id="label-lampu1-mati">
                    <input type="radio" name="lampu1" onchange="publishLampu(this.value)" id="option_off" autocomplete="off"><i class="fas fa-power-off mr-2"></i>Mati
                  </label>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-lg-6 -->   

          <!-- Status Perangkat -->
          <div class="col-lg-12">
            <div class="card card-olive">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-table mr-2"></i>Status Perangkat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Serial Number</th>
                      <th>Location</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                      <td><?php echo $row['serial_number']; ?></td>
                      <td><?php echo $row['location']; ?></td>
                      <td style="color:red;" id="kelasiot/status/<?php echo $row['serial_number']; ?>">Offline</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-lg-12 -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
</div>

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<script>    
  const arrayData = <?php echo json_encode($conn_data); ?>;

  const serialNumber = arrayData.serial_number;
  const serverName = arrayData.server_name;
  const port = arrayData.port;
  const host = "wss://"+serverName+":"+port;
  const clientId = arrayData.client_id;
  const username_account = arrayData.username_account; 
  const password_account = arrayData.password_account;

  const options = {
    keepalive: 30,
    clientId: clientId,
    username: username_account,
    password: password_account,
    protocolId: "MQTT",
    protocolVersion: 4,
    reconnectPeriod: 1000,
    connectTimeout: 30 * 1000
  }

  console.log("Menghubungkan ke broker...");
  const client = mqtt.connect(host, options);

  client.on("connect", () => {
    console.log("Terhubung!");
    document.getElementById("status").innerHTML = `<i class="fas fa-wifi mr-2"></i><b>Server:</b> Terhubung`;
    document.getElementById("status").style.color = "green";

    client.subscribe("kelasiot/#", {qos: 1});
  });

  client.on("message", function(topic, payload) {
    if (topic === "kelasiot/"+serialNumber+"/suhu") {
      document.getElementById("suhu").innerHTML = payload;
    }
    else if (topic === "kelasiot/"+serialNumber+"/kelembapan") {
      document.getElementById("kelembapan").innerHTML = payload;
    }
    else if (topic === "kelasiot/"+serialNumber+"/intensitas_cahaya") {
      document.getElementById("intensitas_cahaya").innerHTML = payload;
    }
    else if (topic === "kelasiot/"+serialNumber+"/servo") {
      let servo1 = $("#servo").data("ionRangeSlider");

      servo1.update({
        from: payload.toString()
      });
    }
    else if (topic === "kelasiot/"+serialNumber+"/led") {
      if (payload == "nyala") {
        document.getElementById("label-lampu1-nyala").classList.add("active");
        document.getElementById("label-lampu1-mati").classList.remove("active");
      }
      else {
        document.getElementById("label-lampu1-nyala").classList.remove("active");
        document.getElementById("label-lampu1-mati").classList.add("active");
      }
    }

    if (topic.includes("kelasiot/status/")) {
      document.getElementById(topic).innerHTML = payload;

      if (payload.toString() === "Offline") {
        document.getElementById(topic).style.color = "red";
      }
      else if (payload.toString() === "Online") {
        document.getElementById(topic).style.color = "green";
      }
    }
  });

  function publishServo(value) {
    data = document.getElementById("servo").value;  
    client.publish("kelasiot/"+serialNumber+"/servo", data, {qos: 1, retain: true});
  }

  function publishLampu(value) {
    if (document.getElementById("option_on").checked) {
      data = "nyala";
    }

    if (document.getElementById("option_off").checked) {
      data = "mati";
    }
    
    client.publish("kelasiot/"+serialNumber+"/led", data, {qos: 1, retain: true});
  }
</script>