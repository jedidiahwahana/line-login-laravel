$(document).ready(function() {

  $("#verify").on("click", function(){
    get("../api/verify").done(function(data) {
      if(data) {
        alert("Access Token is VALID");
      } else {
        alert("Access Token is INVALID");
      }
    });
  });

  $("#refreshToken").on("click", function(){
    get("../api/refreshToken").done(function(data) {
      if(data) {
        alert("Access Token has been refreshed");
      } else {
        alert("Access Token has not been refreshed");
      }
    });
  });

  $("#revoke").on("click", function(){
    get("../api/revoke").done(function(data) {
      alert("Access Token has been revoked");
    });
  });

});


var get = function(url) {
  var def = jQuery.Deferred();
  jQuery.ajax({
    type: 'GET',
    url: url,
    success: function(value) {
      def.resolve(value);
    },
    error: function(xhr) {
      def.reject(xhr.responseText);
    }
  });
  return def.promise();
};
