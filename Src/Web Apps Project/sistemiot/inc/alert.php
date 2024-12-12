<?php
    function alertSuccess($message) {
        echo '
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
          . $message .
        '&nbsp;&nbsp;&nbsp;<i class="fas fa-check"></i><strong></strong></div>';
    }

    function alertUpdate($message) {
      echo '
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
        . $message .
      '&nbsp;&nbsp;&nbsp;<i class="fas fa-check"></i><strong></strong></div>';
    }

    function alertDelete($message) {
      echo '
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="fas fa-exclamation-circle"></i> Pemberitahuan Sistem :</h5>'
        . $message .
      '&nbsp;&nbsp;&nbsp;<i class="fas fa-check"></i><strong></strong></div>';
    }
?>