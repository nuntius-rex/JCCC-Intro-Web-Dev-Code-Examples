
//Front-End Form Validation
var first_name = document.getElementById("first_name");
var fn_validate = document.getElementById("first_name_valMSG");

var last_name = document.getElementById("last_name");
var ln_validate = document.getElementById("last_name_valMSG");

var email = document.getElementById("email");
var email_validate = document.getElementById("email_valMSG");

var submit = document.getElementById("submit");

first_name.addEventListener("keyup",  function(e){
    console.log("First Name Length: "+first_name.value.length);
    if(first_name.value.length>=40){
      fn_validate.innerHTML="Names greater than 40 characters are not allowed.";
    }else{
      fn_validate.innerHTML="";
    }
  }
);

last_name.addEventListener("keyup",  function(e){
    console.log("Last Name Length: "+last_name.value.length);
    if(last_name.value.length>=40){
      ln_validate.innerHTML="Names greater than 40 characters are not allowed.";
    }else{
      ln_validate.innerHTML="";
    }
  }
);


email.addEventListener("keyup",  function(e){
    console.log("Email Length: "+email.value.length);
    if(email.value.length>=254){
      email_validate.innerHTML="Emails greater than 254 characters are not allowed.";
    }
  }
);

submit.addEventListener("click",  function(e){
    console.log("Submit button clicked!");

    var get_req = ""
    +"first_name="+first_name.value
    +"&last_name="+last_name.value
    +"&email="+email.value
    +"";

    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = processResponse; //Triggered each time the state changes
    xhr.open("GET", "form-handler.php?"+get_req, true); //Chenge the name of the file to trigger the error.
    xhr.send();
    function processResponse(){
      console.log("response called...");
      console.log("state:" + xhr.readyState);
      console.log("status:"+ xhr.status);
      if(xhr.readyState === 4 && xhr.status ===200){
          console.log("response text:"+xhr.responseText);
          console.log("xhr:"+xhr);
          document.getElementById("ajaxResults").innerHTML = xhr.responseText;
      }else if(xhr.readyState === 4 && xhr.status !== 200 && xhr.status !==304){ //304 is cached content (probably not wanted, but here for explanation)
          document.getElementById("ajaxResults").innerHTML = "There was a problem with your request.";

      }
    }
  }
);
