<?php
/**
 * Devices - Template
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build application
 $app=new strApplication();
 // build nav object
 $nav=new strNav("nav-tabs");
 // dashboard
 $nav->addItem(api_icon("fa-th-large",null,"hidden-link"),api_url(["scr"=>"dashboard"]));
 $nav->addItem(api_text("nav-devices-list"),api_url(["scr"=>"devices_list"]));
 // operations
 if($device_obj->id && in_array(SCRIPT,array("devices_view","devices_edit"))){
  $nav->addItem(api_text("nav-operations"),null,null,"active");
  $nav->addSubItem(api_text("nav-devices-operations-edit"),api_url(["scr"=>"devices_edit","idDevice"=>$device_obj->id]),(api_checkAuthorization("devices-manage")));
  $nav->addSubSeparator();
  $nav->addSubItem(api_text("nav-devices-operations-document_add"),api_url(["scr"=>"devices_view","tab"=>"documents","act"=>"document_add","idDevice"=>$device_obj->id]),(api_checkAuthorization("devices-manage")));
 }else{
  $nav->addItem(api_text("nav-devices-add"),api_url(["scr"=>"devices_edit"]),(api_checkAuthorization("devices-manage")));
 }
 // settings
 $nav->addItem(api_text("nav-settings"));
 $nav->addSubItem(api_text("nav-settings-categories"),api_url(["scr"=>"categories_list"]));
 // add nav to html
 $app->addContent($nav->render(false));
?>