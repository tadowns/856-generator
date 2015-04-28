<?php

  require_once "./header.class.php";  

  class REF extends header {

    function __construct($ref_id_qualifier, $reference_id){
      $this->header_label = 'REF';
      $this->addElement('128', 2, 3, $ref_id_qualifier);
      $this->addElement('127', 1, 50, $reference_id);
    }
  }
?>