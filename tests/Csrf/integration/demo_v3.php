<?php
require_once('config.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <title> reCAPTCHA V3 demo </title>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
 </head>

 <body>
 <script src="https://www.google.com/recaptcha/api.js"></script>
 <script>
   function onSubmit(token) {
    $.get("verify_v3.php",{token:token})
      .done(function(data){
        if(data.success==true){
          alert('v3 verify success');
        }else{
          alert('v3 verify fail errors:' + data.errors);
        }
      });
   }
 </script>
 <button class="g-recaptcha" data-sitekey="<?=RECAPTCHA_V3_SITE_KEY?>" data-callback='onSubmit' data-action='login'>Submit</button>
 </body>
</html>