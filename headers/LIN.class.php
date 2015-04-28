<?php

  require_once "./header.class.php";  

  class LIN extends header {
   
    function __construct($assigned_id, $product_id){
      $this->header_label = 'LIN';      
      $this->addElement('350', 1, 20, $assigned_id);
      $this->addElement('235', 2, 2, '');
      $this->addElement('234', 1, 48, $product_id);      
      $this->addElement('235', 2, 2, '');
      $this->addElement('234', 1, 48, );              
    }
  }
?>