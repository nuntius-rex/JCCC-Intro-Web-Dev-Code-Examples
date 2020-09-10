<?php
//========================================================
// Form Handler by Dan Guinn ~ 2018/06/23
// Note: This demo is of a sample server-side PHP script.
// Many server-side deployments may have a larger back
// end framework to support modular components and
// seperation of concerns.
//========================================================

  if(isset($_REQUEST["debug"]) && $_REQUEST["debug"]==1){
    echo "<p>Data Recieved by the Server:";
    echo arrayToString($_REQUEST);
  }

  if(count($_REQUEST) !=0 ){

    $allowed_pages=array();
    $allowed_pages[]="contact.htm";
    $allowed_pages[]="contact.html";

    //print_r($allowed_pages);

    //echo $_SERVER['HTTP_REFERER'];
    $refArray=explode("/",$_SERVER['HTTP_REFERER']);
    $refLen = count($refArray)-1;
    $cur_page = $refArray[$refLen];
    //echo "<p>".$cur_page."<br>".in_array($cur_page, $allowed_pages)."</p>";
    if(in_array($cur_page, $allowed_pages, true)!==true){
      die("<p style='color:red'>Sorry, you are calling from an invalid page.</p>");
    }


    //======================================================
    // Confirm request was sent
    //======================================================
    if(isset($_REQUEST["debug"]) && $_REQUEST["debug"]==1){
      echo "<p>The following information was sent:</p>";
      arrayToString($_REQUEST);
    }

    //======================================================
    // Connect to database
    //======================================================
    $dcArray=array();
    $dcArray[0]="localhost";
    $dcArray[1]="root";
    $dcArray[2]="1lex2admit";
    $dcArray[3]="test";
    $MySQLi = new mysqli($dcArray[0], $dcArray[1], $dcArray[2], $dcArray[3]);

    if(isset($_REQUEST["debug"]) && $_REQUEST["debug"]==1){
      echo "<p>The following database connection was made:</p>";
      arrayToString($MySQLi);
    }

  }else{
    die("<p>You did not submit information from a form!</p>");
  }

  //======================================================
  // Validate the data
  //======================================================
  if(isset($_REQUEST["first_name"])){
    $first_name=$MySQLi->real_escape_string($_REQUEST["first_name"]);
    if(strlen($first_name)==0 || strlen($first_name)>40){
      die("<p style='color:red;'>Names must be between 1 and 40 characters.</p>");
    }
    if(validTextField($first_name)!=true){
      die("<p style='color:red;'>Only letters and white space allowed</p>");
    }
  }else{
    $first_name="";
  }

  if(isset($_REQUEST["last_name"])){
    $last_name=$MySQLi->real_escape_string($_REQUEST["last_name"]);
    if(strlen($last_name)==0 || strlen($last_name)>40){
      die("<p style='color:red;'>Names must be between 1 and 40 characters.</p>");
    }
    if(validTextField($last_name)!=true){
      die("<p style='color:red;'>Only letters and white space allowed</p>");
    }
  }else{
    $last_name="";
  }

  if(isset($_REQUEST["email"])){
    $email=$MySQLi->real_escape_string($_REQUEST["email"]);
    if(validateEmail($email)!=true){
      die("<p style='color:red;'>Invalid email format.</p>");
    }
  }else{
    $email="";
  }



  //======================================================
  // Build the SQL Query:
  //======================================================
  if($first_name!="" && $last_name!="" && $email!=""){
    $sql="INSERT INTO tbl_contact SET first_name='".$first_name
    ."', last_name='".$last_name."', email='".$email."' ";
  }else{
    die("<p style='color:red;'>FORM ERROR: Your form entry was not complete. Please try again.</p>");
  }

  if(isset($_REQUEST["debug"]) && $_REQUEST["debug"]==1){
    echo "<p>The following SQL was generated:<br>".$sql."</p>";
  }
  //echo $result=$MySQLi->query($sql); //Returns true/false

  //======================================================
  // Insert the data:
  //======================================================

  if(!$result=$MySQLi->query($sql)){

    die("<p style='color:red;'>We're sorry, the insert FAILED!<br>"
    .mysqli_error($MySQLi)
    ."</p>");
  }else{
    echo "<p>Your contact information has been processed. Thank you for your request!</p>";
  }
  //======================================================
  // Display ALL the data:
  //======================================================
  $line="";

  if(isset($_REQUEST["debug"]) && $_REQUEST["debug"]==1){

      $sql="SELECT first_name, last_name, email FROM tbl_contact WHERE isActive=1";

      $line.="<table>"
      ."<th>First Name</th>"
      ."<th>Last Name</th>"
      ."<th>Email</th>"
      ."";

      if($result=$MySQLi->query($sql)){
        //mysqli_data_seek($result, 0);


        for($i=0; $i<$result->num_rows; $i++){
          if($Obj=$result->fetch_object()){
            $line.="<tr>"
            ."<td>".$Obj->first_name."</td>"
            ."<td>".$Obj->last_name."</td>"
            ."<td>".$Obj->email."</td>"
            ."</tr>";
          }
        }
      }
      $line.="</table>";
  }
  echo $line;

  //==============================================
  //Helper function:
  //==============================================
  function arrayToString($array){
    echo "<pre>".print_r($array, true)."</pre>";
  }

  function validateEmail($email){
    //PHP Spec: maxlength 254 chars: 64@185.com
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    }else{
      return true;
    }

  }

  function validTextField($entry){
    if (!preg_match("/^[a-zA-Z ]*$/",$entry)) {
      return false;
    }else{
      return true;
    }
  }

//=========================================================
//Note: The following table is needed for the database
//=========================================================

/*

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


*/


?>
