<?php

  require_once "./header.class.php";  

  class BSN extends header {

    function __construct($shipment_id, $date_edi_created, $time_edi_created){
      $this->header_label = 'BSN';
      $this->addElement('353', 2, 2, '');
      $this->addElement('396', 2, 30, $shipment_id);
      $this->addElement('373', 8, 8, $date_edi_created);
      $this->addElement('337', 4, 8, $time_edi_created);
      $this->addElement('1005', 4, 4, '');//or 0004?      
    }    
  }
?>