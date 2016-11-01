<?php
 
header('Content-Type: application/json');

$data=array('no'=>'100','name'=>'Jerry','department'=>'sbit');
echo(json_encode($data));
 
class t_menu{
    public $id;
    public $name;
}

$m= new t_menu();
$m->id=100;
$m->name="sachin";

echo json_encode($m);

$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

   var_dump(json_decode($json));
   var_dump(json_decode($json, true));
  

?>