<?php
/**
 * Devices - Category
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Devices Category class
  */
 class cDevicesCategory extends cObject{

  /** Parameters */
  static protected $table="devices__categories";
  static protected $logs=false;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $name;
  protected $title;
  protected $icon;

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->name))){throw new Exception("Category name is mandatory..");}
   if(!strlen(trim($this->icon))){throw new Exception("Category icon is mandatory..");}
   // return
   return true;
  }

  /**
   * Get Label
   *
   * @param boolean $icon Show icon
   * @return string|false Category label
   */
  public function getLabel($title=true,$icon=true){
   if(!$this->exists()){return false;}
   // make label
   $label=$this->name;
   if($icon){$label=$this->getIcon()." ".$label;}
   if($title && $this->title){$label.=" (".$this->title.")";}
   // return
   return $label;
  }

  /**
   * Get Icon
   *
   * @return string|false Category icon
   */
  public function getIcon(){
   if(!$this->exists()){return false;}
   return api_icon($this->icon,$this->getLabel(true,false));
  }

  /**
   * Get Devices
   *
   * @return objects[] Devices array
   */
  public function getDevices(){return cDevicesDevice::availables(true,["fkCategory"=>$this->id]);}

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"devices","scr"=>"controller","act"=>"store","obj"=>"cDevicesCategory","idCategory"=>$this->id],$additional_parameters)),"POST",null,null,"devices_category_edit_form");
   // fields
   $form->addField("text","name",api_text("cDevicesCategory-property-name"),$this->name,api_text("cDevicesCategory-placeholder-name"),null,null,null,"required");
   $form->addField("text","title",api_text("cDevicesCategory-property-title"),$this->title,api_text("cDevicesCategory-placeholder-title"));
   $form->addField("text","icon",api_text("cDevicesCategory-property-icon"),$this->icon,null,null,null,null,"required");
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * Remove
   *
   * @return boolean|exception
   */
  public function remove(){
   // check if category is empty
   if(count($this->getDevices())){
    // exception if not empty
    throw new Exception("Category remove function denied if not empty..");
   }else{
    // remove category
    return parent::remove();
   }
  }

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>