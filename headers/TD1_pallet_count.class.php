<?php

  require_once "./header.class.php";  

  class TD1_pallet_count extends header {

    function __construct($number_of_pallets){
      $this->header_label = 'TD1';      
      $this->addElement('103', 3, 5, 'PLT');
      $this->addElement('80', 1, 7, $number_of_pallets);              
    }   
  }
?>