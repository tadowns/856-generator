<?php

  require_once "./header.class.php";  

  class TD5 extends header {

    function __construct($identification_code){
      $this->header_label = 'TD5';      
      $this->addElement('66', 1, 2, '2');
      $this->addElement('67', 2, 80, $identification_code);              
    }
  }
?>