<?php

  require_once "./header.class.php";  

  class HL extends header {     

    function __construct($hl_id, $hl_parent_id, $hl_code){
      $this->header_label = 'HL';
      $this->addElement('628', 1, 12, $hl_id);
      if($hl_code != 'S'){
        $this->addElement('734', 1, 12, $hl_parent_id);
      }
      $this->addElement('735', 1, 2, $hl_code);      
    }
  }
?>