<?php

  require_once "./header.class.php";  

  class PRF extends header {
    
    function __construct($purchase_order_number){
      $this->header_label = 'PRF';
      $this->addElement('324', 1, 22, $purchase_order_number);
    }
  }
?>