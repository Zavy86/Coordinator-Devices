<?php
/**
 * Devices - Devices View (Documents)
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build documents table
 $documents_table=new strTable(api_text("devices_view-documents-tr-unvalued"));
 $documents_table->addHeader("&nbsp;",null,16);
 $documents_table->addHeader(api_text("cArchiveDocument-property-id"),"nowrap");
 $documents_table->addHeader("&nbsp;",null,16);
 $documents_table->addHeader(api_text("cArchiveDocument-property-name"),null,"100%");
 $documents_table->addHeader("&nbsp;",null,16);
 // cycle all documents
 foreach($device_obj->getDocuments() as $document_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["mod"=>"archive","scr"=>"controller","act"=>"download","obj"=>"cArchiveDocument","idDocument"=>$document_fobj->id,"return"=>["mod"=>"devices","scr"=>"devices_view","tab"=>"documents","idDevice"=>$device_obj->id]]),"fa-download",api_text("table-td-download"),true,null,null,null,null,"_blank");
  $ob->addElement(api_url(["scr"=>"controller","act"=>"document_remove","obj"=>"cDevicesDevice","idDevice"=>$device_obj->id,"idDocument"=>$document_fobj->id,"return"=>["scr"=>"devices_view","tab"=>"documents"]]),"fa-trash",api_text("table-td-remove"),(api_checkAuthorization("devices-manage")),api_text("cDevicesDevice-confirm-document_remove"));
  // make table row class
  $tr_class_array=array();
  if($document_fobj->id==$_REQUEST['idDocument']){$tr_class_array[]="currentrow";}
  // make project row
  $documents_table->addRow(implode(" ",$tr_class_array));
  $documents_table->addRowFieldAction("#","fa-search",api_text("table-td-view"));
  $documents_table->addRowField(api_tag("samp",$document_fobj->id),"nowrap");
  $documents_table->addRowField($document_fobj->getCategory()->getDot(),"nowrap text-center");
  $documents_table->addRowField($document_fobj->name,"truncate-ellipsis");
  $documents_table->addRowField($ob->render(),"text-right");
 }
 // check add action
 if(ACTION=="document_add"){
  // build search bar
  $searchbar=new strSearchBar(api_url(["scr"=>"devices_view","tab"=>"documents","act"=>"document_add","idDevice"=>$device_obj->id]));
  // build table
  $table=new strTable(api_text("documents_list-tr-unvalued"));
  //$table->addHeader("&nbsp;",null,16);
  $table->addHeaderAction(api_url(["mod"=>"archive","scr"=>"documents_edit"]),"fa-plus",api_text("table-td-add"));
  $table->addHeader(api_text("cArchiveDocument-property-id"),"nowrap");
  $table->addHeader("&nbsp;",null,16);
  $table->addHeader(api_text("cArchiveDocument-property-name"),null,"100%");
  // make query where                                                                                                                          /** @todo molto migliorabile */
  $query_where="`id` LIKE '%".addslashes($_REQUEST["searchbar_query"])."%' OR `name` LIKE '%".addslashes($_REQUEST["searchbar_query"])."%'";
  // cycle all results
  foreach(cArchiveDocument::select($query_where,"`id` DESC",(!$_REQUEST["searchbar_query"]?9:null)) as $document_fobj){
   // make row
   $table->addRow();
   $table->addRowFieldAction(api_url(["mod"=>"devices","scr"=>"controller","act"=>"document_add","obj"=>"cDevicesDevice","idDevice"=>$device_obj->id,"idDocument"=>$document_fobj->id,"return"=>["scr"=>"devices_view","tab"=>"documents"]]),"fa-plus",api_text("table-td-add"));
   $table->addRowField(api_tag("samp",$document_fobj->id),"nowrap");
   $table->addRowField($document_fobj->getCategory()->getDot(),"nowrap text-center");
   $table->addRowField($document_fobj->name,"truncate-ellipsis");
  }
  // build modal
  $modal=new strModal(api_text("devices_view-documents-modal-title-add",api_tag("samp",$device_obj->name)),null,"devices_view-document");
  //$modal->setBody($form->render());
  $modal->setBody($searchbar->render()."<br>".$table->render());
  // add modal to application
  $app->addModal($modal);
  // modal scripts
  $app->addScript("$(function(){\$('#modal_devices_view-document').modal({show:true,backdrop:'static',keyboard:false});});");
 }

?>