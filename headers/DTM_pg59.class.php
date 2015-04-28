<?php

  require_once "./header.class.php";  

  class DTM_pg59 extends header {

    function __construct(){
      $this->header_label = 'DTM';
      $this->addElement('374', 3, 3, $id_374);
      $this->addElement('373', 8, 8, $date);
    }
  }
?>