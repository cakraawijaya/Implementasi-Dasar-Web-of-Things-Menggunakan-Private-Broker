<?php
    function alertType1($message, $symbol) {
      echo '
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
        . $message . '&nbsp;&nbsp;&nbsp;' . $symbol .
      '</div>';
    }

    function alertType2($message, $symbol) {
      echo '
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
        . $message . '&nbsp;&nbsp;&nbsp;' . $symbol .
      '</div>';
    }

    function alertType3($message, $symbol) {
      echo '
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
        . $message . '&nbsp;&nbsp;&nbsp;' . $symbol .
      '</div>';
    }
?>