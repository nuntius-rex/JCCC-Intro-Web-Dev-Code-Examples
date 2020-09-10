
//Front-End Form Validation
var first_name = document.getElementById("first_name");
var fn_validate = document.getElementById("first_name_valMSG");

var last_name = document.getElementById("last_name");
var ln_validate = document.getElementById("last_name_valMSG");

var email = document.getElementById("email");
var email_validate = document.getElementById("email_valMSG");

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
