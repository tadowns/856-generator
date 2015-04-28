<?php

  class asn_order_data {

    public $order_number;
    public $date_ordered;
    public $invoice_number;
    public $invoice;
    public $bins;
    public $pallets;
    public $pallet_count;
    public $bin_count;
    public $shipment_weight;
    public $scac;
    public $hl_shipment_number;
    public $hl_order_number;
    private $shipping_atleast_one_pallet;
    public $single_tracking_number;
    public $hl_number_array;
    public $ship_to_id_code;

    function __construct($order_number){
      print("Processesing order number: ".$order_number);
      $this->order_number = $order_number;
      $this->date_ordered = $date_ordered;
      $this->retrieveInvoiceData();
      $this->retrieveBins();
      $this->retrievePallets();
      $this->getPalletCount();
      $this->retrieveShipmentWeight();
      $this->isSingleRefNumber();
      $this->retrieveShipToId();
      $this->retrieveSCAC();
    }

    private function retrieveInvoiceData(){
      //get invoice from database
    }

    private function retrieveBins(){
      //get packages from database
    }

    private function retrievePallets(){
      //get pallets from database          
    }

    private function getPalletCount(){
     //count pallets
    } 

    private function retrieveShipmentWeight(){
      $pallet_weight_sum = $this->getPalletWeightSum();
      $carton_weight_sum = $this->getCartonWeightSum();

      if($pallet_weight_sum > 0){
        $this->shipping_atleast_one_pallet = true;
        $this->shipment_weight = $pallet_weight_sum;
      }else{
        $this->shipping_atleast_one_pallet = false;
        $this->shipment_weight = $carton_weight_sum;
      }
    }

    private function getPalletWeightSum(){
      $pallet_weight_sum = 0;      
      foreach($this->pallets as $pallet){
        $weight = isset($pallet['weight'])?$pallet['weight']:null;
        if( !empty($weight) ) $pallet_weight_sum = $pallet_weight_sum + $weight;
      }
      return $pallet_weight_sum;
    }

    private function getCartonWeightSum(){
      $carton_weight_sum = 0;
      foreach($this->bins as $carton){
        $weight = isset($carton['weight'])?$carton['weight']:null;        
        if( !empty($weight) ) $carton_weight_sum = $carton_weight_sum + $weight;
      }
      return $carton_weight_sum;
    }

    private function isSingleRefNumber(){

      if( $this->pallet_count == 0 || $this->pallet_count == 1 ){
        if( !empty($this->pallets[0]['tracking_number']) ){  
          $this->single_tracking_number = $this->pallets[0]['tracking_number'];
        }elseif($this->bin_count == 1){
          $this->single_tracking_number = $this->bins[0]['tracking_number'];
        }
      }else{
        $this->single_tracking_number = false;
      }
    }   

    private function retrieveSCAC(){
      //get scac code
      //$this->scac = 'UPSN';
    }

    private function getOnePalletTrackingNum(){
      foreach($this->pallets as $pallet){
        if( !empty($pallet['tracking_number']) )
          return $pallet['tracking_number'];
      }
      return false;
    }

    private function getOnePackageTrackingNum(){
      foreach($this->bins as $package){
        if( !empty($package['tracking_number']) )
          return $package['tracking_number'];
      }
      return false;
    }

    public function setHlShipment($hl_shipment_number){
      $this->hl_shipment_number = $hl_shipment_number;
    }

    public function setHlOrderNum($hl_order_number){
      $this->hl_order_number = $hl_order_number;      
    }

    public function setHlPalletNum($parking_space_id, $hl_number){
      $this->addToHlArray($parking_space_id, 'PALLET', $hl_number);
    }

    public function getHlPalletNum($parking_space_id){
      return $this->retrieveFromHlArray($parking_space_id, 'PALLET');
    }

    public function setHlPackageNum($bin_id, $hl_number){
      $this->addToHlArray($bin_id, 'PACKAGE', $hl_number);
    }

    public function getHlPackageNum($bin_id){
      return $this->retrieveFromHlArray($bin_id, 'PACKAGE');
    }

    private function addToHlArray($id, $type, $hl_number){
      $this->hl_number_array[] = array(
                                          "id" => $id,
                                          "type" => $type,
                                          "hl_number" => $hl_number
                                        );      
    }

    private function retrieveFromHlArray($id, $type){
      foreach($this->hl_number_array as $index){
        if($index['id'] == $id && $index['type'] == $type){
          return $index['hl_number'];
        }
      }
      return -1;     
    }

    public function getPackageContents($package_id){
      $package_object = new package($package_id);
      $items = $package_obj->getItems();
      return $items;
    }

    private function retrieveShipToId(){
      //get ship to id
    }


  }

?>