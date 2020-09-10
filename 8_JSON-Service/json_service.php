<?php
  $Obj = new \stdClass();
  $Obj->first_name = "Dan";
  $Obj->last_name = "Guinn";
  $Obj->status = "Gold";

  $myJSON = json_encode($Obj);

  echo $myJSON;
?>
