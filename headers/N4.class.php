<?php

  require_once "./header.class.php";  

  class N4 extends header {

    function __construct($city_name, $state_code, $postal_code, $country_code){
      $this->header_label = 'N4';
      $this->addElement('19', 2, 30, $city_name);
      $this->addElement('156', 2, 2, $state_code);
      $this->addElement('116', 3, 15, $postal_code);
      $this->addElement('26', 2, 3, $country_code);
    }
  }
?>