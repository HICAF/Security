$(function() {
	
	$(".slider").slick({
		vertical: true,
		adaptiveHeight: true,
		dots: false,
		arrows: false,
		centerMode: true,
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 0,
		speed: 9000,
		cssEase: 'linear'
	});
	
});





// Chat stuff
$(".chat-closer").click(function(){
	$(".chat").hide();
});

$(".chat-trigger").click(function(){
	$(".chat").toggle();
});


$('#submit-msg').keydown(function (e){
    if(e.keyCode == 13 && !event.shiftKey){
      var clientmsg = $(this).val();
      console.log(clientmsg);
      $.ajax('/src/ajax.php', {
        data: {
          "function":"submit-chat-msg", 
          "message":clientmsg
        },
        method: "post"
      }).done(function(response){
        $("#submit-msg").val("");
      }).fail(function(){
        swal({
          title: "Ooops...!",
          text: "There was a technical error. Please try again in 25 min.",
          type: "error"
        });
      });       
      return false;
    } 
})

// Continuously chat update
function loadLog(){   
  $.ajax({
    url: "/src/chatLog.html",
    cache: false,
    success: function(html){    
      var oldscrollHeight = $("#messages").prop("scrollHeight") - 20;
      $("#messages").html(html); //Insert chat log into the #chatbox div 
      //Auto-scroll     
      var newscrollHeight = $("#messages").prop("scrollHeight") - 20; //Scroll height after the request
      if(newscrollHeight > oldscrollHeight){
        $("#messages").scrollTop(newscrollHeight); //Autoscroll to bottom of div
      }      
    },
  });
}

setInterval(loadLog,500);




// Cookie stuff
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + "; " + expires;
  console.log("Cookie should have been made");
}

function deleteCookie() {
  cookieName="kfbsusloinapi2016";
  document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


  
function readCookie() {
   var allcookies = document.cookie;
   
   // Get all the cookies pairs in an array
   cookiearray = allcookies.split(';');
   var value = "";
   var activeUserApi = "";

  // Now take key value pair out of this array
  for(var i=0; i<cookiearray.length; i++){
    name = cookiearray[i].split('=')[0];
    value = cookiearray[i].split('=')[1];
    console.log("The key is : " + name + " and the Value is : " + value);
    if (name == "kfbsusloinapi2016") {
      activeUserApi = value;
    }
  }

  if(activeUserApi != ""){
    console.log("THE API IS "+ activeUserApi + " " + value);

    $.ajax('/src/ajax.php', {
      data: {
        "function":"cookieLogin", 
        "userApi":activeUserApi
      },
      method: "post"
    }).done(function(response){
      console.log(response)
    }).fail(function(){
      console.log("Could not get profile")
    });
  }
}

readCookie();


  








///////////////////////////////////////
///////////// USER SYSTEM /////////////
///////////////////////////////////////


////////// SIGNUP //////////
  $(document).on('submit','#signup-form', function(e){
    e.preventDefault();
    $this = $(this);

    $.ajax('/src/ajax.php', {
     data: $this.serialize() + "&function=" + "signup",
      type: "post",
      dataType: "json",
      async: false
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        type: response.type,
        html: true
      });

      $("input").removeClass("error");

      if (response.type != "success") {

        var faults = response.fields;

        for (var i = 0 ; i < faults.length; i++) {
          $("input[name="+faults[i]+"]").addClass("error");
        } 
      } else { 
        if (response.rememberMe == "true") {
          var cname = response.cookieName;
          var cvalue = response.cookieValue;
          var exdays = response.cookieExdays;
          
          setCookie(cname, cvalue, exdays);
        } else {
          deleteCookie();
        }

      	$(document).on("click",".sa-confirm-button-container .confirm",function(){
          window.location.replace("gifupload.php");
        });
      }
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 25 min.",
        type: "error"
      });
    });
  });







////////// LOGIN //////////
  $(document).on('submit','#login-form', function(e){
    e.preventDefault();
    $this = $(this);



    $.ajax('/src/ajax.php', {
      data: $this.serialize() + "&function=" + "login",
      type: "post",
      dataType: "json",
      async: false
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        html: true,
        type: response.type
      });

      if (response.type != "success") {

        var faults = response.fields;
        var admin = response.admin;

        for (var i = 0 ; i < faults.length; i++) {
          $("input[name="+faults[i]+"]").addClass("error");
        } 
      } else {
        if (response.rememberMe == "true") {
          var cname = response.cookieName;
          var cvalue = response.cookieValue;
          var exdays = response.cookieExdays;
          
          setCookie(cname, cvalue, exdays);
        } else {
          deleteCookie();
        }

      	$(document).on("click",".sa-confirm-button-container .confirm",function(){

      		if (admin == 1) {
	         	window.location.replace("gifaccepted.php");
      		} else {
	         	window.location.replace("gifupload.php");
      		}
        });

      }
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 25 min.",
        type: "warning"
      });
    });
  });










////////// RETRIEVE PASSWORD //////////
$(document).on('click','#btn-retrieve-password', function() {

  swal({
    title: "Write your email adress",
    type: "input",
    showCancelButton: true,
    closeOnCancel: true,
    closeOnConfirm: false,
    html: true,
    animation: "slide-from-top",
    inputPlaceholder: "your@email.com"
  }, function(inputValue){
    if (inputValue === false) return false;

    if (inputValue === "") {
      swal.showInputError("You must enter an email to continue.");
      return false
    }

    $.ajax('/src/ajax.php', {
      data: {
        "retrieveMail":"true",
        "email":inputValue
      },
      method: "get",
      async: false,
      dataType: 'json'
    }).done(function(response){
      if (response.type == "error") {
        swal.showInputError(response.message);
        return false;
      } 
      if (response.type == "success") {
        swal({
          title: response.title,
          text: response.message + inputValue,
          type: response.type
        })
      };
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 25 min.",
        type: "warning"
      });
    });
  });

});





////////// RESET PASSWORD //////////
  $(document).on('click','#btn-password-reset', function(){
    var id = $(this).attr("data-id");
    var password = $("#passwordReset").val();
    var passwordCheck = $("#passwordCheckReset").val();


    if (password == "") {
      swal({
        title: "Ooops...!",
        text: "You need to type in a password.",
        type: "error"
      });
    } else if (password != passwordCheck) {
      swal({
        title: "Ooops...!",
        text: "The entered password does not match.",
        type: "error"
      });
    } else {
      $.ajax('/src/ajax.php', {
        data: {
          "function":"resetPassword",
          "id":id,
          "password":password
        },
        method: "post",

        dataType: 'json'
      }).done(function(response){
        swal({
          title: response.title,
          text: response.message,
          type: response.type
        });

        if (response.type == "success") {
          $(document).on("click",".sa-confirm-button-container .confirm",function(){
            window.location.replace("login.php");
          });
        };
      }).fail(function(response){
        swal({
          title: "Ooops...!",
          text: "There was a technical error. Please try again in 25 min.",
          type: "warning"
        });
      });
    };


  });











////////// LOGOUT //////////
  $(".logout").click(function(){
    deleteCookie();
    window.location.replace("/src/ajax.php?logout=true");
  })











////////// UPDATE PROFILE //////////
  $(document).on('submit','#update-form', function(e){
    e.preventDefault();
    $this = $(this);


    // username == "" ? username = $("input[name=username]").attr("placeholder") : username = username;
    // email == "" ? email = $("input[name=email]").attr("placeholder") : email = email;
    // firstName == "" ? firstName = $("input[name=firstname]").attr("placeholder") : firstName = firstName;
    // lastName == "" ? lastName = $("input[name=lastname]").attr("placeholder") : lastName = lastName;
    



    $.ajax('/src/ajax.php', {
      data: $this.serialize() + "&function=" + "updateProfile",
      type: "post",
      dataType: "json",
      async: false
      }).done(function(response){
        swal({
          title: response.title,
          text: response.message,
          type: response.type,
          html: true
        });

         $("input").removeClass("error");

        if (response.type != "success") {

          var faults = response.fields;

          for (var i = 0 ; i < faults.length; i++) {
            $("#"+faults[i]).addClass("error");
          };
        };
      }).fail(function(response){
        swal({
          title: "Ooops...!",
          text: "There was a technical error. Please try again in 25 min.",
          type: "warning"
        });
      });
  });



////////// DELETE USER //////////
  $(document).on("click", "#btnDeleteUser", function() {
    $("#deleteConfirmation").html('<div class="btn-warning text-center" style="padding:5px;font-weight:300;font-size:12px;">Are you sure you want to delete your user?<br><button id="btnConfirmDelete" class="btn btn-danger">YES</button> <button id="btnCancelDelete" class="btn btn-success">NO</button></div>');
  });

////////// CANCEL DELETE //////////
  $(document).on("click", "#btnCancelDelete", function() {
    $("#deleteConfirmation").html("");
  });

////////// CONFIRM DELETE //////////
  $(document).on("click", "#btnConfirmDelete", function() {
    window.location.replace("/src/ajax.php?function=deleteUser")
  });

////////// RESET PASSWORD //////////
  $(document).on("click", "#passwordProfile", function() { $(this).val(""); });
  $(document).on("click", "#passwordCheckProfile", function() { $(this).val(""); });











////////////////////////////////////////
///////////// APPROVE GIFS /////////////
////////////////////////////////////////

////////// GIF ACCEPTED //////////
$(document).on("click", "#btn-gif-accepted", function() {
	var gif_id = $(".current-gif").attr("data-id");


	$.ajax('/src/ajax.php', {
		data: {
		  "function": "gif-accepted",
		  "gif_id": gif_id
		},
		async: false,
		dataType: 'json',
		method: "post"
	}).done(function(response){
		swal({
          title: response.title,
          text: response.message,
          type: response.type
        });

        $(document).on("click",".sa-confirm-button-container .confirm",function(){
        	window.location.replace("gifaccept.php");
        });
	}).fail(function(response){
		swal({
		  title: "Ooops...!",
		  text: "There was a technical error. Please try again in 25 min.",
		  type: "warning"
		});
	});
});

////////// GIF REJECTED //////////
$(document).on("click", "#btn-gif-rejected", function() {
	var gif_id = $(".current-gif").attr("data-id");

	$.ajax('/src/ajax.php', {
		data: {
		  "function": "gif-rejected",
		  "gif_id": gif_id
		},
		async: false,
		dataType: 'json',
		method: "post"
	}).done(function(response){
		swal({
          title: response.title,
          text: response.message,
          type: response.type
        });

        $(document).on("click",".sa-confirm-button-container .confirm",function(){
        	window.location.replace("gifaccept.php");
        });
	}).fail(function(response){
		swal({
		  title: "Ooops...!",
		  text: "There was a technical error. Please try again in 25 min.",
		  type: "warning"
		});
	});
});







