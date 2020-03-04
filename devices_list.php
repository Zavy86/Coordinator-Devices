<?php
/**
 * Devices - Devices List
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("devices-usage","dashboard");
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // definitions
 $users_array=array();
 // set application title
 $app->setTitle(api_text("devices_list"));
 // definitions
 $devices_array=array();
 // build filter
 $filter=new strFilter();
 $filter->addSearch(["name","description","brand","model","identifier"]);
 // build query object
 $query=new cQuery("devices__devices",$filter->getQueryWhere());
 $query->addQueryOrderField("name");
 // build pagination object
 $pagination=new strPagination($query->getRecordsCount());
 // cycle all results
 foreach($query->getRecords($pagination->getQueryLimits()) as $result_f){$devices_array[$result_f->id]=new cDevicesDevice($result_f);}
 // build table
 $table=new strTable(api_text("devices_list-tr-unvalued"));
 $table->addHeader($filter->link(api_icon("fa-filter",api_text("filters-modal-link"),"hidden-link")),"text-center",16);
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("cDevicesDevice-property-name"),null,"100%");
 $table->addHeader("&nbsp;",null,16);
 // cycle all devices
 foreach($devices_array as $device_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["scr"=>"devices_edit","idDevice"=>$device_fobj->id,"return"=>["scr"=>"devices_list"]]),"fa-pencil",api_text("table-td-edit"),(api_checkAuthorization("devices-manage")));
  if($device_fobj->deleted){$ob->addElement(api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cDevicesDevice","idDevice"=>$device_fobj->id,"return"=>["scr"=>"devices_list"]]),"fa-trash-o",api_text("table-td-undelete"),(api_checkAuthorization("devices-manage")),api_text("cDevicesDevice-confirm-undelete"));}
  else{$ob->addElement(api_url(["scr"=>"controller","act"=>"delete","obj"=>"cDevicesDevice","idDevice"=>$device_fobj->id,"return"=>["scr"=>"devices_list"]]),"fa-trash",api_text("table-td-delete"),(api_checkAuthorization("devices-manage")),api_text("cDevicesDevice-confirm-delete"));}
  // make table row class
  $tr_class_array=array();
  if($device_fobj->id==$_REQUEST['idDevice']){$tr_class_array[]="currentrow";}
  if($device_fobj->deleted){$tr_class_array[]="deleted";}
  // make devices row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowFieldAction(api_url(["scr"=>"devices_view","idDevice"=>$device_fobj->id]),"fa-search",api_text("table-td-view"));
  $table->addRowField($device_fobj->getCategory()->getIcon(),"nowrap");
  $table->addRowField($device_fobj->name,"truncate-ellipsis");
  $table->addRowField($ob->render(),"nowrap text-right");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($filter->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($pagination->render(),"col-xs-12");
 // add content to device
 $app->addContent($grid->render());
 // renderize device
 $app->render();
 // debug
 api_dump($query,"query");
?>