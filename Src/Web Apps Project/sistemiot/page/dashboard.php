<?php
  $sql = "SELECT * FROM devices WHERE active = 'Yes'";
  $result = mysqli_query($conn, $sql);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="m-0">Dashboard</h1><hr>
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
              <div class="card-body table-responsive pad">
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
  const clientId = "mqttjs_" + Math.random().toString(16).substr(2, 8);
  const port = "443";
  const host = "wss://kelasiotdevan.cloud.shiftr.io:"+port;

  const options = {
    keepalive: 30,
    clientId: clientId,
    username: "kelasiotdevan",
    password: "w4TXjZVczSQ0DyiW",
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
    if (topic === "kelasiot/suhu") {
      document.getElementById("suhu").innerHTML = payload;
    }
    else if (topic === "kelasiot/kelembapan") {
      document.getElementById("kelembapan").innerHTML = payload;
    }
    else if (topic === "kelasiot/intensitas_cahaya") {
      document.getElementById("intensitas_cahaya").innerHTML = payload;
    }
    else if (topic === "kelasiot/servo") {
      let servo1 = $("#servo").data("ionRangeSlider");

      servo1.update({
        from: payload.toString()
      });
    }
    else if (topic === "kelasiot/led") {
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
    client.publish("kelasiot/servo", data, {qos: 1, retain: true});
  }

  function publishLampu(value) {
    if (document.getElementById("option_on").checked) {
      data = "nyala";
    }

    if (document.getElementById("option_off").checked) {
      data = "mati";
    }
    
    client.publish("kelasiot/led", data, {qos: 1, retain: true});
  }
</script>