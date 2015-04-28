<?php

  require_once "./header.class.php";  

  class ST extends header {    

    function __construct($asn_id){
      $this->header_label = 'ST';
      $this->addElement('143', 3, 3, '856');
      $this->addElement('329', 4, 9, $asn_id);      
    }   
  }
?>