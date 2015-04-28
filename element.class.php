<?php
  class element{

    private $id;
    private $min;
    private $max;
    private $value;  
    
    function __construct($id, $min, $max, $value){
      $this->id = $id;
      $this->min = $min;
      $this->max = $max;
      $this->setValue($value);
    }

    private function setValue($value){
      $value_length = strlen($value);
      if($value_length > $this->max && $value != ''){
        print("\nError! ID: $this->id, Value is outside of expected range");
        die();
      }
      $this->value = $value;
    }

    function toString(){
      if( !isset($this->value) ) $this->value= ' ';
      print("This value: ".$this->value."\n");
      return str_pad($this->value, $this->max);
    }

  }
?>