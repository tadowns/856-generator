<?php

  require_once "./header.class.php";  

  class SN1 extends header {

    function __construct($assigned_id, $qty_shipped){
      $this->header_label = 'SN1';      
      $this->addElement('350', 1, 20, $assigned_id);
      $this->addElement('382', 1, 10, $qty_shipped);
      $this->addElement('355', 2, 2, '');      
    }
  }
?>