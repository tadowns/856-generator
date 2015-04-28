<?php

  require_once "./header.class.php";  

  class N3 extends header {

    function __construct($address_info1, $address_info2){
      $this->header_label('N3');
      $this->addElement('166', 1, 55, $address_info1);
      $this->addElement('166', 1, 55, $address_info2);
    }
  }
?>