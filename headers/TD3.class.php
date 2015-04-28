<?php

  require_once "./header.class.php";  

  class TD3 extends header {

    function __construct(){
      $this->header_label('TD3');
      $this->addElement('40', 2, 2, $id_40);
      $this->addElement('187', 1, 2, 'B');
      $this->addElement('81', 1, 10, $date);
      $this->addElement('355', 2, 2, 'LB');
    }
  }
?>