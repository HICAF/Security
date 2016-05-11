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
      dataType: 'json'
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        type: response.type
      });
    }).fail(function(response){
      swal({
        title: "Ooops...!",
        text: "There was a technical error. Please try again in 5 min.",
        type: "warning"
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
      dataType: 'json'
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        type: response.type
      });
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
      dataType: 'json'
    }).done(function(response){
      swal({
        title: response.title,
        text: response.message,
        type: response.type
      });
      if (response.type == "success") {
        $(".login-box").hide();
        $(".logout").show();
        $(".add-flight").show();

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

    console.log(firstName + " " + middleName + " " + lastName);
    console.log(email + " " + password + " " + passwordCheck);

    if (password == passwordCheck) {
      if (password != "") {
        password = password;
      } else {
        password = "";
      }

      $.ajax('ajax.php', {
        data: {
          "function": "updateProfile",
          "firstName": firstName,
          "middleName": middleName,
          "lastName": lastName,
          "email": email,
          "phone": phone,
          "password": password
        },
        dataType: 'json'
      }).done(function(response){
        swal({
          title: response.title,
          text: response.message,
          type: response.type
        });
      }).fail(function(response){
        swal({
          title: "Ooops...!",
          text: "There was a technical error. Please try again in 5 min.",
          type: "warning"
        });
      });

    } else {
      swal({
        title: "Failed!",
        text: "The passwords you've entered does not match. Please retype your password and try again.",
        type: "warning"
      });
    };
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
  $(document).on("click", "#passwordProfile", function() {
    $(this).val("");
  });