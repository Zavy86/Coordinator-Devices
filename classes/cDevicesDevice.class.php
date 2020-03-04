<?php
/**
 * Devices - Device
 *
 * @package Coordinator\Modules\Devices
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Devices Device class
  */
 class cDevicesDevice extends cObject{

  /** Parameters */
  static protected $table="devices__devices";
  static protected $logs=true;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $fkCategory;
  protected $name;
  protected $description;
  protected $brand;
  protected $model;
  protected $identifier;
  protected $price;
  protected $purchase;
  protected $warranty;

  /**
   * Decode log properties
   *
   * {@inheritdoc}
   */
  public static function log_decode($event,$properties){
   // make return array
   $return_array=array();
   // join events
   if($properties['class']=="cArchiveDocument"){$return_array[]=api_text($properties['class']).": ".(new cArchiveDocument($properties['id']))->name;}
   // return
   return implode(" | ",$return_array);
  }

  /**
   * Get Category
   *
   * @return object Category object
   */
  public function getCategory(){return new cDevicesCategory($this->fkCategory);}

  /**
   * Get Documents
   *
   * @return object[]|false Array of documents objects or false
   */
  public function getDocuments(){return api_sortObjectsArray($this->joined_select("devices__devices__join__documents","fkDevice","cArchiveDocument","fkDocument"),"id");}

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"devices","scr"=>"controller","act"=>"store","obj"=>"cDevicesDevice","idDevice"=>$this->id],$additional_parameters)),"POST",null,null,"devices_device_edit_form");
   // fields
   $form->addField("select","fkCategory",api_text("cDevicesDevice-property-fkCategory"),$this->fkCategory,api_text("cDevicesDevice-placeholder-fkCategory"),null,null,null,"required");
   foreach(cDevicesCategory::availables(true) as $category_fobj){$form->addFieldOption($category_fobj->id,$category_fobj->getLabel(true,false));}
   $form->addField("text","name",api_text("cDevicesDevice-property-name"),$this->name,api_text("cDevicesDevice-placeholder-name"),null,null,null,"required");
   $form->addField("textarea","description",api_text("cDevicesDevice-property-description"),$this->description,api_text("cDevicesDevice-placeholder-description"),null,null,null,"rows='2'");
   $form->addField("text","brand",api_text("cDevicesDevice-property-brand"),$this->brand,api_text("cDevicesDevice-placeholder-brand"));
   $form->addField("text","model",api_text("cDevicesDevice-property-model"),$this->model,api_text("cDevicesDevice-placeholder-model"));
   $form->addField("text","identifier",api_text("cDevicesDevice-property-identifier"),$this->identifier,api_text("cDevicesDevice-placeholder-identifier"));
   $form->addField("number","price",api_text("cDevicesDevice-property-price"),$this->price,api_text("cDevicesDevice-placeholder-price"));
   $form->addField("date","purchase",api_text("cDevicesDevice-property-purchase"),$this->purchase);
   $form->addField("date","warranty",api_text("cDevicesDevice-property-warranty"),$this->warranty);
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->fkCategory))){throw new Exception("Device category key is mandatory..");}
   if(!strlen(trim($this->name))){throw new Exception("Device name is mandatory..");}
   // return
   return true;
  }

  /**
   * Document Add
   *
   * @return boolean
   */
  public function document_add($object){return $this->joined_add("devices__devices__join__documents","fkDevice","cArchiveDocument","fkDocument",$object);}

  /**
   * Document Remove
   *
   * @return boolean
   */
  public function document_remove($object){return $this->joined_remove("devices__devices__join__documents","fkDevice","cArchiveDocument","fkDocument",$object);}

  // Disable remove function
  public function remove(){throw new Exception("Device remove function disabled by developer..");}

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>