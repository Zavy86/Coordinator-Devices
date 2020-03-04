<?php
/**
 * Devices - Devices View (Informations)
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // build left informations description list
 $informations_left_dl=new strDescriptionList("br","dl-horizontal");
 if($device_obj->brand){$informations_left_dl->addElement(api_text("cDevicesDevice-property-brand"),$device_obj->brand);}
 if($device_obj->model){$informations_left_dl->addElement(api_text("cDevicesDevice-property-model"),api_tag("samp",$device_obj->model));}
 if($device_obj->identifier){$informations_left_dl->addElement(api_text("cDevicesDevice-property-identifier"),api_tag("samp",$device_obj->identifier));}

 // build right informations description list
 $informations_right_dl=new strDescriptionList("br","dl-horizontal");
 if($device_obj->purchase){$informations_right_dl->addElement(api_text("cDevicesDevice-property-purchase"),api_date_format($device_obj->purchase,api_text("date")));}
 if($device_obj->warranty){
  if(api_date_difference(date("Y-m-d"),$device_obj->warranty)>0){$warranty_status_dd=api_icon("fa-check");}else{$warranty_status_dd=api_icon("fa-remove");}
  $informations_right_dl->addElement(api_text("cDevicesDevice-property-warranty"),api_date_format($device_obj->warranty,api_text("date")).$warranty_status_dd);
 }
 if($device_obj->price){$informations_right_dl->addElement(api_text("cDevicesDevice-property-price"),api_number_format($device_obj->price,2,"€",true));}

 // build informations grid
 $informations_grid=new strGrid();
 $informations_grid->addRow();
 $informations_grid->addCol($informations_left_dl->render(),"col-xs-12 col-md-6");
 $informations_grid->addCol($informations_right_dl->render(),"col-xs-12 col-md-6");

?>