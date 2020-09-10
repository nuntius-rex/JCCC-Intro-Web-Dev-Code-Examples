// Main viewmodel class (this is a requirejs module)
define(['knockout-3.4.2'], function(ko) {

    return function appViewModel() {
        self=this;
        self.firstName = ko.observable('');
        self.lastName = ko.observable('');
        self.email = ko.observable('');

        self.save = function () {

            $.ajax({
                url: "form-handler.php",
                type: "GET",
                data: {
                   first_name : self.firstName(),
                   last_name: self.lastName(),
                   email: self.email()
                },
                success: function(result)
                {
                    $("#ajaxResults").html(result)
                },
                error: function(jqXHR, exception)
                {
                   $("#ajaxResults").html("There was a problem with your request.")
                }
            });

            $.getJSON( "js/app/data/client.json", function( data ) {
              //console.log(self.firstName());
              count=0;
              var msg="";
              var status="";
              $.each( data, function( key, val ) {
                if(key=="first_name" && val==self.firstName()){
                  count++;
                }
                if(key=="last_name" && val==self.lastName()){
                  count++;
                }

                if(key=="message"){
                  msg=val;
                }

                if(key=="status"){
                  status=val;
                }
            });

            //console.log("count:"+count);
            //console.log("message: "+msg);

            if(count==2 && status=="Gold"){
              $("#client_msg").html(msg);
            }

        });
      }//End Save

    }; //End Return
});
