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
 $informations_left_dl->addElement(api_text("cDevicesDevice-property-identifier"),api_tag("samp",$device_obj->identifier));
 if($device_obj->purchase){$informations_left_dl->addElement(api_text("cDevicesDevice-property-purchase"),api_date_format($device_obj->purchase,api_text("date")));}
 if($device_obj->warranty){
  if(api_date_difference(date("Y-m-d"),$device_obj->warranty)>0){$warranty_status_dd=api_icon("fa-check");}else{$warranty_status_dd=api_icon("fa-remove");}
  $informations_left_dl->addElement(api_text("cDevicesDevice-property-warranty"),api_date_format($device_obj->warranty,api_text("date")).$warranty_status_dd);
 }
 if($device_obj->price){$informations_left_dl->addElement(api_text("cDevicesDevice-property-price"),api_number_format($device_obj->price,2,"€",true));}

 // build right informations description list
 $informations_right_dl=new strDescriptionList("br","dl-horizontal");
 if($device_obj->note){$informations_right_dl->addElement(api_text("cDevicesDevice-property-note"),nl2br($device_obj->note));}

 // biuld informations grid
 $informations_grid=new strGrid();
 $informations_grid->addRow();
 $informations_grid->addCol($informations_left_dl->render(),"col-xs-12 col-md-4");
 $informations_grid->addCol($informations_right_dl->render(),"col-xs-12 col-md-8");

?>