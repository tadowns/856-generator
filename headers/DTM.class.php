<?php

  require_once "./header.class.php";  

  class DTM extends header {

    function __construct($shipped_or_est_delivery, $date_left_warehouse, $time_left_warehouse){
      $this->header_label = 'DTM';
      
      $this->addElement('374', 3, 3, $shipped_or_est_delivery);
      $this->addElement('373', 8, 8, $date_left_warehouse);
      $this->addElement('337', 4, 8, $time_left_warehouse);
      $this->addElement('623', 2, 2, 'GM');
    }
  }
?>