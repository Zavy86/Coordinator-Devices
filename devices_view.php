<?php
/**
 * Devices - Devices View
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("devices-usage","dashboard");
 // get objects
 $device_obj=new cDevicesDevice($_REQUEST['idDevice']);
 // check objects
 if(!$device_obj->id){api_alerts_add(api_text("cDevicesDevice-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=devices_list");}
 // deleted alert
 if($device_obj->deleted){api_alerts_add(api_text("cDevicesDevice-warning-deleted"),"warning");}
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(api_text("devices_view",$device_obj->name));
 // check for tab
 if(!defined(TAB)){define("TAB","informations");}
 // build devices description list
 $left_dl=new strDescriptionList("br","dl-horizontal");
 $left_dl->addElement(api_text("cDevicesDevice-property-code"),api_tag("samp",$device_obj->code));
 $left_dl->addElement(api_text("cDevicesDevice-property-name"),api_tag("strong",$device_obj->name));
 // build right description list
 $right_dl=new strDescriptionList("br","dl-horizontal");
 if($device_obj->description){$right_dl->addElement(api_text("cDevicesDevice-property-description"),nl2br($device_obj->description));}
 // include tabs
 require_once(MODULE_PATH."devices_view-informations.inc.php");
 require_once(MODULE_PATH."devices_view-documents.inc.php");
 // build view tabs
 $tab=new strTab();
 $tab->addItem(api_icon("fa-flag-o")." ".api_text("devices_view-tab-informations"),$informations_grid->render(),("informations"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-pdf-o")." ".api_text("devices_view-tab-documents"),$documents_table->render(),("documents"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-text-o")." ".api_text("devices_view-tab-logs"),api_logs_table($device_obj->getLogs((!$_REQUEST['all_logs']?10:null)))->render(),("logs"==TAB?"active":null));
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($left_dl->render(),"col-xs-12 col-md-5");
 $grid->addCol($right_dl->render(),"col-xs-12 col-md-7");
 $grid->addRow();
 $grid->addCol($tab->render(),"col-xs-12");
 // add content to device
 $app->addContent($grid->render());
 // renderize device
 $app->render();
 // debug
 api_dump($selected_measurement_obj,"selected measurement");
 api_dump($device_obj,"device");
?>