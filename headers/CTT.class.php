<?php

  require_once "./header.class.php";  

  class CTT extends header {

    function __construct($number_of_loops, $total_item_qty){
      $this->header_label = 'CTT';
      $this->addElement('354', 1, 6, $number_of_loops);
      $this->addElement('347', 1, 10, $total_item_qty);            
    }
  }
?>