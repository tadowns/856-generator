<?php

  require_once "element.class.php";

  class header {   
    private $element_array;   
    public  $header_label; 
    private $array_position;
    private $end_element_delimiter = "*";
    private $end_header_delimiter = '~';

    function __construct(){
      $this->array_position = 0;
    }

    protected function addElement($id, $min, $max, $value){
      $this->element_array[$id] = array(
                                        'min' => $min,
                                        'max' => $max,
                                        'value' => $value,
                                        'position' => $this->array_position++
                                        );
    }

    function __toString(){
      if(isset($this->element_array)){
        $this->sortElementArrayByPosition();
        $output = $this->getAllElementsAsString();
        $output = rtrim($output, "*");
        $output .= $this->end_header_delimiter;
        $output = $this->header_label.$this->end_element_delimiter.$output;
        print($output."\n");
        return $output;
      }
      return '';      
    }

    private function sortElementArrayByPosition(){
      usort($this->element_array, function($a, $b) {
        return $a['position'] - $b['position'];
      });      
    }
    
    private function getAllElementsAsString(){
      $output = "";
      foreach($this->element_array as $element){
        $output .= $this->getElementString($element);
      }
      return $output;
    }

    private function getElementString($element){
      $return = str_pad($element['value'], $element['min']);
      $return = $return.$this->end_element_delimiter;        
      return $return;
    }
  }
?>