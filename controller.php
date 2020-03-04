<?php
/**
 * Devices - Controller
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // debug
 api_dump($_REQUEST,"_REQUEST");
 // check if object controller function exists
 if(function_exists($_REQUEST['obj']."_controller")){
  // call object controller function
  call_user_func($_REQUEST['obj']."_controller",$_REQUEST['act']);
 }else{
  api_alerts_add(api_text("alert_controllerObjectNotFound",[MODULE,$_REQUEST['obj']."_controller"]),"danger");
  api_redirect("?mod=".MODULE);
 }

 /**
  * Device controller
  *
  * @param string $action Object action
  */
 function cDevicesDevice_controller($action){
  // check authorizations
  api_checkAuthorization("devices-manage","dashboard");
  // get object
  $device_obj=new cDevicesDevice($_REQUEST['idDevice']);
  api_dump($device_obj,"device object");
  // check object
  if($action!="store" && !$device_obj->id){api_alerts_add(api_text("cDevicesDevice-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=devices_list");}
  // check for document
  if(in_array($action,array("document_add","document_remove"))){
   // get object
   $document_obj=new cArchiveDocument($_REQUEST['idDocument']);
   api_dump($document_obj,"document object");
   // check object
   if(!$document_obj->id){api_alerts_add(api_text("cArchiveDocument-alert-exists"),"danger");api_redirect(api_url(["scr"=>"devices_view","tab"=>"documents","idDevice"=>$device_obj->id]));}
  }
  // execution
  try{
   switch($action){
    case "store":
     $device_obj->store($_REQUEST);
     api_alerts_add(api_text("cDevicesDevice-alert-stored"),"success");
     break;
    case "delete":
     $device_obj->delete();
     api_alerts_add(api_text("cDevicesDevice-alert-deleted"),"warning");
     break;
    case "undelete":
     $device_obj->undelete();
     api_alerts_add(api_text("cDevicesDevice-alert-undeleted"),"warning");
     break;
    case "remove":
     $device_obj->remove();
     api_alerts_add(api_text("cDevicesDevice-alert-removed"),"warning");
     break;
    case "document_add":
     $device_obj->document_add($document_obj);
     api_alerts_add(api_text("cDevicesDevice-alert-document_added"),"success");
     break;
    case "document_remove":
     $device_obj->document_remove($document_obj);
     api_alerts_add(api_text("cDevicesDevice-alert-document_removed"),"warning");
     break;
    default:
     throw new Exception("Device action \"".$action."\" was not defined..");
   }
   // redirect
   api_redirect(api_return_url(["scr"=>"devices_list","idDevice"=>$device_obj->id]));
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,api_url(["scr"=>"devices_list","idDevice"=>$device_obj->id]),"cDevicesDevice-alert-error");
  }
 }

?>