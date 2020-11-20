<?php
/**
 * Devices - Categories List
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
 $app->setTitle(api_text("categories_list"));
 // build table
 $table=new strTable(api_text("categories_list-tr-unvalued"));
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("cDevicesCategory-property-name"),"nowrap");
 $table->addHeader(api_text("cDevicesCategory-property-title"),null,"100%");
 if(!api_checkAuthorization("devices-manage")){$table->addHeader("&nbsp;",null,16);}
 else{$table->addHeaderAction(api_url(["scr"=>"categories_list","act"=>"category_add"]),"fa-plus",api_text("categories_list-td-add"),null,"text-right");}
 // cycle all categories
 foreach(cDevicesCategory::availables(true) as $category_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["scr"=>"categories_list","act"=>"category_edit","idCategory"=>$category_fobj->id]),"fa-pencil",api_text("table-td-edit"),(api_checkAuthorization("devices-manage")));
  $ob->addElement(api_url(["scr"=>"controller","act"=>"remove","obj"=>"cDevicesCategory","idCategory"=>$category_fobj->id,"return"=>["scr"=>"categories_list"]]),"fa-trash",api_text("table-td-remove"),(api_checkAuthorization("devices-manage") && !count($category_fobj->getDevices())),api_text("cDevicesCategory-confirm-remove"));
  // make table row class
  $tr_class_array=array();
  if($category_fobj->id==$_REQUEST['idCategory']){$tr_class_array[]="currentrow";}
  if($category_fobj->deleted){$tr_class_array[]="deleted";}
  // make row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowField($category_fobj->getIcon(),"nowrap");
  $table->addRowField($category_fobj->name,"nowrap");
  $table->addRowField($category_fobj->title,"truncate-ellipsis");
  $table->addRowField($ob->render(),"nowrap text-right");
 }
 // check for add or edit action
 if(in_array(ACTION,["category_add","category_edit"]) && api_checkAuthorization("devices-manage")){
  // get selected category
  $selected_category_obj=new cDevicesCategory($_REQUEST['idCategory']);
  // get form
  $form=$selected_category_obj->form_edit(["return"=>["scr"=>"categories_list","tab"=>"categories","idHouse"=>$house_obj->id]]);
  // additional controls
  $form->addControl("button",api_text("form-fc-cancel"),"#",null,null,null,"data-dismiss='modal'");
  if($selected_category_obj->id){
   if(!count($selected_category_obj->getDevices())){
    $form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cDevicesCategory","idCategory"=>$selected_category_obj->id]),"btn-danger",api_text("cDevicesCategory-confirm-remove"));
   }
  }
  // form scripts
  $app->addScript("/* Font Awesome Icon Picker */\n$(function(){\$(\"#form_devices_category_edit_form_input_icon\").iconpicker();});");
  // build modal
  $modal=new strModal(api_text("categories_list-modal-title-".($selected_category_obj->id?"edit":"add")),null,"categories_list-category");
  $modal->setBody($form->render(1));
  // add modal to house
  $app->addModal($modal);
  // modal scripts
  $app->addScript("$(function(){\$('#modal_categories_list-category').modal({show:true,backdrop:'static',keyboard:false});});");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 // add content to category
 $app->addContent($grid->render());
 // renderize category
 $app->render();
 // debug
 if(is_object($selected_category_obj)){api_dump($selected_category_obj,"selected category");}
?>