<?php
  foreach(glob("/headers/*.php") as $file){
    require $file;
  }

  class asn_builder2 {

    private $asn_orders_obj;
    
    private $header_array;
    private $asn_string;
    private $time;
    private $date_edi_created;
    private $time_edi_created;
    private $interchange_control_number;
    private $hl_counter;
    private $bin_attribute_obj;
    private $current_order_data_obj;
    private $sscc_obj;
    private $ps_attr_obj;
    private $lin_counter;
    private $asin_obj;
    private $items_in_asn;

    function __construct ($asn_orders_obj){
      $this->asn_orders_obj = $asn_orders_obj;
      $this->sscc_obj = new sscc;
      $this->time = time();

      //generate interchange control number
      //$this->interchange_control_number =  ;
      $this->hl_counter = 1;
      $this->lin_counter = 1;
      $this->items_in_asn = 0;
      
    }

    function getASN(){
      $this->createAllHeaders();
      $this->stringifyAsn();
      $this->createOutputFile();
      return $this->asn_string;
    }

    private function createAllHeaders(){
      $this->isaHeader();
      $this->gsHeader();
      $this->stHeader();
      $this->bsnHeader();

      $asn_orders_array = $this->asn_orders_obj->asn_order_data_array;
      
      foreach( $asn_orders_array as $asn_order ){
        $this->current_order_data_obj = $asn_order;
        $this->shipmentLoop();
      }

      foreach( $asn_orders_array as $asn_order ){
        $this->current_order_data_obj = $asn_order;
        $this->orderLoop();
      }

      foreach( $asn_orders_array as $asn_order ){
        $this->current_order_data_obj = $asn_order;
        $this->palletLoop();
      }

      foreach( $asn_orders_array as $asn_order ){
        $this->current_order_data_obj = $asn_order;
        $this->packageLoop();
      }

      foreach( $asn_orders_array as $asn_order ){
        $this->current_order_data_obj = $asn_order;
        $this->itemLoop();
      }

      $this->cttHeader();
      $this->seHeader();
      $this->geHeader();
      $this->ieaHeader();
    }

    private function isaHeader(){
      $date_edi_created = date("ymd",$this->time);
      $time_edi_created = date("Hi",$this->time);
      $interchange_control_number = '0'.$this->interchange_control_number;
      $test_or_production = 'T';
      $this->header_array[] = new ISA($date_edi_created, $time_edi_created, $interchange_control_number, $test_or_production);
    }

    private function gsHeader(){
      $date_edi_created = date("Ymd",$this->time);
      $time_edi_created = date("Hi",$this->time);
      $group_control_number = '9'.$this->interchange_control_number;
      $this->header_array[] = new GS($date_edi_created, $time_edi_created, $group_control_number);
    }

    private function stHeader(){
      $asn_id = $this->interchange_control_number;
      $this->header_array[] = new ST($asn_id);
    }

    private function bsnHeader(){
      $date_edi_created = date("Ymd",$this->time);
      $time_edi_created = date("Hi",$this->time);
      $shipment_id  = 'A'.$this->interchange_control_number;
      //$shipment_id = $this->current_order_data_obj->invoice['invoice'];
      $this->header_array[] = new BSN($shipment_id, $date_edi_created, $time_edi_created);
    }

    private function shipmentLoop(){      
        $this->hlShipmentHeader();
        $this->td1CartonHeader();
        $this->td1PalletHeader();
        $this->td5Header();
        if($this->current_order_data_obj->single_tracking_number)
          $this->refHeader();
        $this->dtmShipped();
        $this->dtmEstimated();
        $this->fobHeader();

        $this->n1LoopShipFrom();
        $this->n1LoopShipToo();
    }

    private function hlShipmentHeader(){
      $this->current_order_data_obj->setHlShipment($this->hl_counter);
      $this->header_array[] = new HL($this->hl_counter, '', 'S');
      $this->hl_counter++;
    }

    private function td1CartonHeader(){
      //count number of AZs
      $number_of_cartons = $this->current_order_data_obj->bin_count;
      //$commodity_code = '';
      $weight_of_shipment = $this->current_order_data_obj->shipment_weight;
      $this->header_array[] = new TD1_carton($number_of_cartons, $weight_of_shipment);
    }

    private function td1PalletHeader(){
      //if ap has weight count it
      $number_of_pallets = $this->current_order_data_obj->pallet_count;
      $this->header_array[] = new TD1_pallet_count($number_of_pallets);
    }

    private function td5Header(){
      $identification_code = $this->current_order_data_obj->scac;
      $this->header_array[] = new TD5($identification_code);
    }   

    private function refHeader(){
      $ref_id_qualifier = 'CN';
      $reference_id = $this->current_order_data_obj->single_tracking_number;
      $this->header_array[] = new REF($ref_id_qualifier, $reference_id);
    }

    private function dtmShipped(){
      $shipped_or_est_delivery = '011';
      $date_left_warehouse = gmdate("Ymd",$this->time);
      $time_left_warehouse = gmdate("Hi",$this->time);
      $this->header_array[] = new DTM($shipped_or_est_delivery, $date_left_warehouse, $time_left_warehouse);
    }

    private function dtmEstimated(){
      $expected = strtotime("+7 days",$this->time);
      $shipped_or_est_delivery = '017';
      $estimated_arrival_date = gmdate("Ymd",$expected);;
      $estimated_arrival_time = gmdate("Hi",$expected);
      $this->header_array[] = new DTM($shipped_or_est_delivery, $estimated_arrival_date, $estimated_arrival_time);
    }

    private function fobHeader(){
      $payment_method = '';
      $this->header_array[] = new FOB($payment_method);
    }

    private function n1LoopShipFrom(){
      $this->n1HeaderShipFrom();
      $this->n4Header();      
    }

    private function n1HeaderShipFrom(){
      $ship_from_or_to = '';
      $id_code_qual = '';
      $id_code = '';
      $this->header_array[] = new N1($ship_from_or_to, $id_code_qual, $id_code);      
    }
 
    /*private function n3Header(){
      $address_info1 = ;
      $address_info2 = ;
      $this->header_array[] = new N3($address_info1, $address_info2);
    }*/

    private function n4Header(){
      $city_name = '';
      $state_code = '';
      $postal_code = '';
      $country_code = '';
      $this->header_array[] = new N4($city_name, $state_code, $postal_code, $country_code);
    }

    private function n1LoopShipToo(){
      //foreach($blahs as $blah){
        $this->n1HeaderShipToo();
      //}
    }

    private function n1HeaderShipToo(){
      $ship_from_or_to = '';
      $id_code_qual = '';    
      $id_code = $this->current_order_data_obj->ship_to_id_code;
      $this->header_array[] = new N1($ship_from_or_to, $id_code_qual, $id_code);            
    }

    private function orderLoop(){
        $this->hlOrderHeader();
        $this->prfHeader();
    }

    private function hlOrderHeader(){
      $this->current_order_data_obj->setHlOrderNum($this->hl_counter);      
      $hl_id = $this->hl_counter++;
      $hl_parent_id = $this->current_order_data_obj->hl_shipment_number;
      $hl_code = 'O';      
      $this->header_array[] = new HL($hl_id, $hl_parent_id, $hl_code);                  
    }

    private function prfHeader(){
      $purchase_order_number = $this->current_order_data_obj->invoice['customer_po'];
      $this->header_array[] = new PRF($purchase_order_number);
    }

     private function palletLoop(){
      if($this->current_order_data_obj->pallet_count == 0)return;
      foreach($this->current_order_data_obj->pallets as $pallet){
        $this->hlPalletHeader($pallet);
        //td1PalletHeader();
        $this->manPalletHeader($pallet);
      }
    }

    private function hlPalletHeader($pallet){
      $hl_id = $this->hl_counter;
      $hl_parent_id = $this->current_order_data_obj->hl_order_number;
      $this->current_order_data_obj->setHlPalletNum($pallet['parking_space_id'], $this->hl_counter);
      $hl_code = 'T';      
      $this->header_array[] = new HL($hl_id, $hl_parent_id, $hl_code);

      $this->hl_counter++;      
    }

    /*private function td1PalletHeader(){
      $this->header_array[] = new TD1_pallet_content();
    }*/

    private function manPalletHeader($pallet){
      //get sscc assigned to pallet
      $this->header_array[] = new MAN($sscc_number);      
    }

    private function packageLoop(){
      foreach($this->current_order_data_obj->bins as $package){
        $this->hlPackageHeader($package);
        if( !empty($package['tracking_number']) )//no tracking number so it is being shipped on a pallet
          $this->td1PackageHeader($package);
        if( !$this->current_order_data_obj->single_tracking_number )
          $this->refPackageHeader($package);
        $this->manPackageHeader($package);
      }
    }

    private function hlPackageHeader($package){
      $hl_id = $this->hl_counter;
      $hl_parent_id = $this->getHlPackageParentLoopId($package);
      $this->current_order_data_obj->setHlPackageNum($package['bin_id'], $this->hl_counter);
      $hl_code = 'P';      
      $this->header_array[] = new HL($hl_id, $hl_parent_id, $hl_code);

      $this->hl_counter++;
    }

    private function getHlPackageParentLoopId($package){
      if($this->current_order_data_obj->pallet_count == 0){
        //if no pallets then the package is a child to the order not a pallet
        return $this->current_order_data_obj->hl_order_number;
      }else{
        $temp = $this->current_order_data_obj->getHlPalletNum($package['parking_space_id']);
        //if some packages are in a pallet and some are not
        return ($temp != -1)?$temp:$this->current_order_data_obj->hl_order_number;
      }
    }

    private function td1PackageHeader($package){
      $packaging_code = 'CTN';
      $weight = $package['weight'];
      $this->header_array[] = new TD1_package_loop($packaging_code, $weight);            
    }

    private function refPackageHeader($package){
      $ref_id_qualifier = 'CN';
        $tracking_number = $package['tracking_number'];
      if( empty($tracking_number) ){
        //get tracking number of the pallet that the package is on
      }
      $this->header_array[] = new REF($ref_id_qualifier, $tracking_number);
    }

    private function manPackageHeader($package){
      //get sscc number assigned to package
      $this->header_array[] = new MAN($sscc_number);
    }

    private function itemLoop(){
      foreach($this->current_order_data_obj->bins as $package){      
        $items = $this->current_order_data_obj->getPackageContents($package);
        foreach($items as $item){       
          $this->hlItemHeader($package, $item);
          $this->linHeader($item);
          $this->sn1Header($item);
        }
      }
    }

    private function hlItemHeader($package, $item){
      $hl_id = $this->hl_counter;
      $hl_parent_id = $this->current_order_data_obj->getHlPackageNum($package['bin_id']);
      $hl_code = 'I';      
      $this->header_array[] = new HL($hl_id, $hl_parent_id, $hl_code);

      $this->hl_counter++;
    }

    private function linHeader($item){
      $assigned_id = $this->lin_counter;
      //get product id from database (or move this to the order_info_class where it should probably reside)
      $this->header_array[] = new LIN($assigned_id, $product_id);      
    }

    private function sn1Header($item){
      $assigned_id = $this->lin_counter++;
      $qty_shipped = $item['qty_shipped'];
      $this->items_in_asn += $item['qty_shipped'];
      $this->header_array[] = new SN1($assigned_id, $qty_shipped);      
    }
    
    private function cttHeader(){
      //the loop counter is previously incremented so as to start a new HL so we are subtracting 1
      //to accurately represent the number of HL loops
      $number_of_loops = $this->hl_counter-1;
      $total_item_qty = $this->items_in_asn;
      $this->header_array[] = new CTT($number_of_loops, $total_item_qty); 
    }

    private function seHeader(){
      $num_of_segments = count($this->header_array);
      $transaction_set_control_num = $this->interchange_control_number;
      $this->header_array[] = new SE($num_of_segments, $transaction_set_control_num); 
    }

    private function geHeader(){
      $number_of_transaction_sets = 1;
      $group_control_number = '9'.$this->interchange_control_number;
      $this->header_array[] = new GE($number_of_transaction_sets, $group_control_number); 
    }

    private function ieaHeader(){
      $num_of_functional_groups = 1;
      $interchange_control_number = '0'.$this->interchange_control_number;
      $this->header_array[] = new IEA($num_of_functional_groups, $interchange_control_number); 
    }

    private function stringifyAsn(){
      $array = $this->header_array;
      foreach($array as $header){
        $this->asn_string .= $header->__toString();
      }
    }

    private function createOutputFile(){
      file_put_contents('testFile', $this->asn_string);
    }

  }
?>