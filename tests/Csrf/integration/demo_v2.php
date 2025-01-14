<?php
require_once('config.php');
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title> reCAPTCHA V2 demo </title>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">

      var siteVerifyCallback = function(response) {
        document.getElementById("token").value = response;
      };

      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '<?=RECAPTCHA_V2_SITE_KEY?>',
          'callback' : siteVerifyCallback
        });
      };

     function onSubmit() {
       var token = document.getElementById("token").value;
       if(token==''){
        return false;
       }

      $.get("verify_v2.php",{token:token})
       .done(function(data){
        if(data.success==true){
          alert('v2 verify success');
        }else{
          alert('v2 verify fail errors:' + data.errors);
        }
      });

     }

    </script>
  </head>
  <body>
    <form action="?" method="POST" onsubmit="return false">
      <div id="html_element"></div>
      <br>
      token: <input type="text" id="token" value="">
      <input type="submit" value="Submit" onClick="onSubmit()">
    </form>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>
  </body>
</html>