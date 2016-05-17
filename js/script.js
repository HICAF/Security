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

// Gif approval stuff
$(".gif-accepted").click(function(){
	alert("Accepted");
});

$(".gif-rejected").click(function(){
	alert("Narh, that one sucked anyways.");
});

// Chat stuff
$(".chat-closer").click(function(){
	$(".chat").hide();
});

$(".chat-trigger").click(function(){
	$(".chat").toggle();
});








///////////////////////////////////////
///////////// USER SYSTEM /////////////
///////////////////////////////////////





////////// SIGNUP //////////
  $(document).on('click','#btn-signup', function(){
    var username = $("input[name=username]").val();
    var password = $("input[name=password]").val();
    var email = $("input[name=email]").val();
    var firstName = $("input[name=firstname]").val();
    var lastName = $("input[name=lastname]").val();


    $.ajax('/src/ajax.php', {
      data: {
        "function":"signup",
        "username":username,
        "password":password,
        "email":email,
        "firstName":firstName,
        "lastName":lastName
      },
      method: "get",
      async:false,
      dataType: 'json'
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
  $(document).on('click','#btn-login', function(){
    var username = $("input[name=username]").val();
    var password = $("input[name=password]").val();


    $.ajax('/src/ajax.php', {
      data: {
        "function":"login",
        "username":username,
        "password":password
      },
      method: "get",
      async: false,
      dataType: 'json'
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










////////// LOGIN ADMIN //////////
  $(document).on('click','#btn-admin-login', function(){
    var email = $("#admin-email").val();
      var password = $("#admin-password").val();


    $.ajax('/src/ajax.php', {
      data: {
        "function":"admin-login",
        "email":email,
        "password":password
      },
      method: "get",
      async: false,
      dataType: 'json'
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        type: response.type
      });
      if (response.type == "success") {
        $(document).on("click",".sa-confirm-button-container .confirm",function(){
          window.location.replace("../admin/");
        });
      };
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
        "function":"retrievePassword",
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
    var passwordCheck = $("#passwordReset").val();


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
        method: "get",

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
    window.location.replace("/src/ajax.php?function=logout");
  })











////////// UPDATE PROFILE //////////
  $(document).on('click','#btn-UpdateProfile', function(){
    var firstName = $("input[name=firstname]").val();
    var lastName = $("input[name=lastname]").val();
    var email = $("input[name=email]").val();
    var username = $("input[name=username]").val();
    var password = $("input[name=password]").val();
    var passwordCheck = $("input[name=passwordcheck]").val();


    username == "" ? username = $("input[name=username]").attr("placeholder") : username = username;
    email == "" ? email = $("input[name=email]").attr("placeholder") : email = email;
    firstName == "" ? firstName = $("input[name=firstname]").attr("placeholder") : firstName = firstName;
    lastName == "" ? lastName = $("input[name=lastname]").attr("placeholder") : lastName = lastName;



      $.ajax('/src/ajax.php', {
        data: {
          "function": "updateProfile",
          "username": username,
          "firstName": firstName,
          "lastName": lastName,
          "email": email,
          "password": password,
          "passwordCheck": passwordCheck
        },
        async: false,
        dataType: 'json',
        method: "get"
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