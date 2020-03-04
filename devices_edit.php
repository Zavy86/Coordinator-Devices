<?php
/**
 * Devices - Devices Edit
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("devices-manage","dashboard");
 // get objects
 $device_obj=new cDevicesDevice($_REQUEST['idDevice']);
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(($device_obj->id?api_text("devices_edit",$device_obj->name):api_text("devices_edit-add")));
 // get form
 $form=$device_obj->form_edit(["return"=>api_return(["scr"=>"devices_view"])]);
 // additional controls
 if($device_obj->id){
  $form->addControl("button",api_text("form-fc-cancel"),api_return_url(["scr"=>"devices_view","idDevice"=>$device_obj->id]));
  if(!$device_obj->deleted){
   $form->addControl("button",api_text("form-fc-delete"),api_url(["scr"=>"controller","act"=>"delete","obj"=>"cDevicesDevice","idDevice"=>$device_obj->id]),"btn-danger",api_text("cDevicesDevice-confirm-delete"));
  }else{
   $form->addControl("button",api_text("form-fc-undelete"),api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cDevicesDevice","idDevice"=>$device_obj->id,"return"=>["scr"=>"devices_view"]]),"btn-warning");
   $form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cDevicesDevice","idDevice"=>$device_obj->id]),"btn-danger",api_text("cDevicesDevice-confirm-remove"));
  }
 }else{$form->addControl("button",api_text("form-fc-cancel"),api_url(["scr"=>"devices_list"]));}
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($form->render(),"col-xs-12");
 // add content to device
 $app->addContent($grid->render());
 // renderize device
 $app->render();
 // debug
 api_dump($device_obj,"device");
?>