<?php

  require_once "./header.class.php";  

  class MAN extends header {

    function __construct($marks_and_numbers){
      $this->header_label = 'MAN';
      $this->addElement('88', 1, 2, 'GM');
      $this->addElement('87', 1, 48, $marks_and_numbers);      
    }
  }
?>