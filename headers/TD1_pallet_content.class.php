<?php

  require_once "./header.class.php";  

  class TD1_pallet_content extends header {    

    function __construct(){
      $this->header_label = 'TD1';      
      $this->addElement('103', 3, 5, 'CTN');
      $this->addElement('80', 1, 7, $number_of_cartons);
      $this->addElement('23', 1, 1, $commodity_code_qualifier);      
      $this->addElement('22', 1, 30, $commodity_code);
      $this->addElement('79', 1, 50, $lading_description);
      $this->addElement('187', 1, 2, 'G');
      $this->addElement('81', 1, 10, $id_81);
      $this->addElement('355', 2, 2, 'LB');
      $this->addElement('183', 1, 8, $id_183);
      $this->addElement('355', 2, 2, $id_1005);           
    }
  }
?>