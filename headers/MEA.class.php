<?php

  require_once "./header.class.php";  

  class MEA extends header {

    function __construct(){
      $this->header_label = 'MEA';      
      $this->addElement('737', 2, 2, '');
      $this->addElement('738', 1, 3, '');
      $this->addElement('739', 1, 20, $id_739);      
      $this->addElement('C001', 2, 2, $comp);
      $this->addElement('355',2, 2, $id_355);              
    }
  }
?>