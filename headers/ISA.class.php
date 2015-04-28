<?php

  require_once "./header.class.php";  

  class ISA extends header {    

    function __construct($date_edi_created, $time_edi_created, $interchange_control_number, $test_or_production){
      $this->header_label = 'ISA'; 
      
      $this->addElement('I01', 2, 2, '');
      $this->addElement('I02', 10, 10, '');
      $this->addElement('I03', 2, 2, '');
      $this->addElement('I04', 10, 10, '');
      $this->addElement('I05a', 2, 2, '');
      $this->addElement('I06', 15, 15, '');
      $this->addElement('I05b', 2, 2, '');      
      $this->addElement('I07', 15, 15, '');
      $this->addElement('I08', 6, 6, $date_edi_created);
      $this->addElement('I09', 4, 4, $time_edi_created);
      $this->addElement('I65', 1, 1, '');
      $this->addElement('I11', 5, 5, '');
      $this->addElement('I12', 9, 9, $interchange_control_number);
      $this->addElement('I13', 1, 1, '');
      $this->addElement('I14', 1, 1, $test_or_production);
      $this->addElement('I15', 1, 1, '>');
    }   
  }
?>