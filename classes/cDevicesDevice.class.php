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
  protected $code;
  protected $name;
  protected $description;
  protected $identifier;
  protected $price;
  protected $purchase;
  protected $warranty;
  protected $note;

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
   $form->addField("text","code",api_text("cDevicesDevice-property-code"),$this->code,api_text("cDevicesDevice-placeholder-code"),null,null,null,"required");
   $form->addField("text","name",api_text("cDevicesDevice-property-name"),$this->name,api_text("cDevicesDevice-placeholder-name"),null,null,null,"required");
   $form->addField("textarea","description",api_text("cDevicesDevice-property-description"),$this->description,api_text("cDevicesDevice-placeholder-description"),null,null,null,"rows='2'");
   $form->addField("text","identifier",api_text("cDevicesDevice-property-identifier"),$this->identifier,api_text("cDevicesDevice-placeholder-identifier"),null,null,null,"required");
   $form->addField("number","price",api_text("cDevicesDevice-property-price"),$this->price,api_text("cDevicesDevice-placeholder-price"));
   $form->addField("date","purchase",api_text("cDevicesDevice-property-purchase"),$this->purchase);
   $form->addField("date","warranty",api_text("cDevicesDevice-property-warranty"),$this->warranty);
   $form->addField("textarea","note",api_text("cDevicesDevice-property-note"),$this->note,api_text("cDevicesDevice-placeholder-note"),null,null,null,"rows='2'");
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
   if(!strlen(trim($this->code))){throw new Exception("Device code is mandatory..");}
   if(!strlen(trim($this->name))){throw new Exception("Device name is mandatory..");}
   if(!strlen(trim($this->identifier))){throw new Exception("Device identifier is mandatory..");}
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