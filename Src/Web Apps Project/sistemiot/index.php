<?php
  session_start();

  if (!isset($_SESSION['username'])) {
    echo "<script> location.href = 'login.php'; </script>";
  }

  if ($_SESSION['active'] == "No") {
    echo "<script> location.href = 'logout.php'; </script>";
  }

  if (isset($_SESSION['username'])) {   
    if (time() - $_SESSION['last_login_timestamps'] > 1800) {
      echo "<script> location.href = 'logout.php' </script>";
    }
  }

  include "config/database.php";
  include "inc/header.php";
  include "inc/navbar.php";
  include "inc/sidebar.php";
  include "inc/alert.php";

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    include "page/". $page .".php";  
  } else {
    include "page/dashboard.php";
  }

  include "inc/footer.php";
?>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  $(function () {
    /* ION SLIDER */
    $('#servo').ionRangeSlider({
      skin    : 'round',
      min     : 0,
      max     : 180,
      from    : 0,
      type    : 'single',
      step    : 1,
      postfix : '°',
      onChange: function(data) {
        data.update({
            from: data.from
        });
      }
    })
  })
</script>
</body>
</html>