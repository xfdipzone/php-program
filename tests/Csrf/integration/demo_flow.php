<?php
require_once('config.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <title> reCAPTCHA V3+V2 demo </title>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
 </head>

 <body>
 <p>先执行v3，如v3失败则执行v2</p>
 <script src="https://www.google.com/recaptcha/api.js"></script>
 <script>
   function onSubmit(token) {
    $.get("verify_v3.php",{token:token})
      .done(function(data){
        if(data.success==true){
          alert('v3 verify success');
        }else{
          alert('v3 verify fail errors:' + data.errors);
          // 执行v2验证
          $('#v3button').remove();
          showv2();
        }
      });
   }

  var siteVerifyCallback = function(response) {
    document.getElementById("token").value = response;
  };

  var showv2 = function() {
    grecaptcha.render('html_element', {
      'sitekey' : '<?=RECAPTCHA_V2_SITE_KEY?>',
      'callback' : siteVerifyCallback
    });
    $('#token').show();
    $("#submitv2").show();
  };

 function onSubmitV2() {
   var token = document.getElementById("token").value;
   if(token==''){
    return false;
   }

    $.get("verify_v2.php",{token:token})
      .done(function(data){
      	if(data.success==true){
      		alert('v2 verify success');
      	}else{
      		alert('v2 verify fail error:' + data.errors);
      	}
      });
 }

 </script>

 <button id="v3button" class="g-recaptcha" data-sitekey="<?=RECAPTCHA_V3_SITE_KEY?>"  data-callback='onSubmit' data-action='login'>Submit</button>
 <div id="html_element"></div>
 <input type="text" id="token" style="display:none" value="">
 <input id="submitv2" style="display:none" type="submit" value="Submit" onClick="onSubmitV2()">

 </body>
</html>