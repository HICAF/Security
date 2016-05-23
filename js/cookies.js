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
      method: "get"
    }).done(function(response){
      console.log(response)
    }).fail(function(){
      console.log("Could not get profile")
    });
  }
}

readCookie();