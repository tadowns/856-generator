<?php

  require_once "./header.class.php";  

  class TD1_package_loop extends header {
   
    function __construct($packing_code, $weight){
      $this->header_label = 'TD1';      
      $this->addElement('103', 3, 5, $packing_code);
      $this->addElement('80', 1, 7, '1');
      //$this->addElement('23', 1, 1, $id_23);      
      //$this->addElement('22', 1, 30, $id_22);
      //$this->addElement('79', 1, 50, $id_79);
      $this->addElement('187', 1, 2, 'G');
      $this->addElement('81', 1, 10, $weight);
      $this->addElement('355', 2, 2, 'LB');                 
    }
  }
?>