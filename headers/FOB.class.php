<?php

  require_once "./header.class.php";  

  class FOB extends header {

    function __construct($payment_method){
      $this->header_label = 'FOB';
      $this->addElement('146', 2, 2, $payment_method);
    }
  }
?>