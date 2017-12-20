<?php
if(isset($_SESSION['error']) && !(empty($_SESSION['error']))){
  function createError($errormess,$errortype,$errorAddon){
    $mess = "<div id='message'>
      <div id='inner-message' class='alert alert-$errortype'>
          <button type='button' class='close' data-dismiss='alert'>&times;</button>
          <strong>$errorAddon </strong>
          $errormess
      </div>
    </div>";
    return $mess;
  }
  $errormess = $_SESSION['error'];
  $errortype = $_SESSION['errorType'];
  $errorAddon = $_SESSION['errorAdd'];

  //die("shushdagsdsdjsdhjsedhg".$_SESSION['error2']);
  //unset($_SESSION['error']);
  //unset($_SESSION['errorType']);
  //unset($_SESSION['errorAdd']);
}

?>
