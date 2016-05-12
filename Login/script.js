///////////////////////////////////////
///////////// USER SYSTEM /////////////
///////////////////////////////////////

////////// SIGNUP //////////
  $(document).on('click','#btn-signup', function(){
    var username = $("#username").val();
    var password = $("#passwordSignup").val();
    var email = $("#emailSignup").val();
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();


    $.ajax('ajax.php', {
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
          $("#"+faults[i]).addClass("error");
        }
      }
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 5 min.",
        type: "error"
      });
    });
  });









////////// LOGIN //////////
  $(document).on('click','#btn-login', function(){
    var username = $("#usernameLogin").val();
    var password = $("#passwordLogin").val();


    $.ajax('ajax.php', {
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
        type: response.type
      });

      if (response.type == "success") {
        $(document).on("click",".sa-confirm-button-container .confirm",function(){
          window.location.replace("user.php");
        });
      };
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 5 min.",
        type: "warning"
      });
    });
  });



////////// LOGIN ADMIN //////////
  $(document).on('click','#btn-admin-login', function(){
    var email = $("#admin-email").val();
      var password = $("#admin-password").val();


    $.ajax('ajax.php', {
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
        text: "There was a technical error. Please try again in 5 min.",
        type: "warning"
      });
    });
  });





////////// LOGOUT //////////
  $(".logout").click(function(){
    window.location.replace("ajax.php?function=logout");
  })






////////// UPDATE PROFILE //////////
  $(document).on('click','#btn-UpdateProfile', function(){
    var firstName = $("#firstNameProfile").val();
    var lastName = $("#lastNameProfile").val();
    var email = $("#emailProfile").val();
    var username = $("#usernameProfile").val();
    var password = $("#passwordProfile").val();
    var passwordCheck = $("#passwordCheckProfile").val();


    username == "" ? username = $("#usernameProfile").attr("placeholder") : username = username;
    email == "" ? email = $("#emailProfile").attr("placeholder") : email = email;
    firstName == "" ? firstName = $("#firstNameProfile").attr("placeholder") : firstName = firstName;
    lastName == "" ? lastName = $("#lastNameProfile").attr("placeholder") : lastName = lastName;



      $.ajax('ajax.php', {
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
          text: "There was a technical error. Please try again in 5 min.",
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
    window.location.replace("ajax.php?function=deleteUser")
  });

////////// RESET PASSWORD //////////
  $(document).on("click", "#passwordProfile", function() { $(this).val(""); });
  $(document).on("click", "#passwordCheckProfile", function() { $(this).val(""); });