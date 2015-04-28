<?php

  require_once "./header.class.php";  

  class N1 extends header {

    function __construct($ship_from_or_to, $id_code_qual, $id_code){
      $this->header_label = 'N1';      
      $this->addElement('98', 2, 3, $ship_from_or_to);
      $this->addElement('3', 1, 60, $name);
      $this->addElement('66', 1, 2, $id_code_qual);
      $this->addElement('67', 2, 80, $id_code);
    }
  }
?>