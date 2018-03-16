<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo favicon_url();?>" type="image/ico" />

    <title><?php echo project_name();?></title>
    <link href="<?php echo asset_url() ?>css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/nprogress/nprogress.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/build/custom.min.css" rel="stylesheet">
    <link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
	<?php $user=""; $pass="";?>
  </head>

  <body class="login" style="background: url('<?php echo login_bg();?>') no-repeat center center fixed !important;  -webkit-background-size: cover;
  -moz-background-size: cover !important;
  -o-background-size: cover !important;
  background-size: cover !important;">
    <div>
      <!-- <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a> -->

      <div class="login_wrapper">
        <div class="animate form login_form">
           <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-block alert-success">
                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-block alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
          <section class="login_content">
            <form action="<?php echo base_url()?>home/login" method="POST"  id="loginform" autocomplete="off">
              <img src="<?php echo logo_url() ?>" style="width: 162px;">
              <div><br>
                <input type="email" class="form-control"  placeholder="Email address" id="email" name="username" required />
                
              </div>
              <div>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="new-password"/>
              </div>
              <div class="row">
              <div class="col-md-6">
                <input type="text" id="inputcap" name="inputcap" class="form-control" required placeholder="enter 5 digit captcha"  />

</div>
    <div class="col-md-6" style=" background-color:white; height: 33px;"><span style="font-size: 16px;" id="feedCaptchaDiv"></span>
      <input type="hidden" id="feedcaptext" name="feedcaptext"><a href="javascript:;" onclick="captcha();" >&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh">  Reload </i> </a></div>
      </div>
              <div>
                <button type="submit" id='save' class="btn btn-success" style="color: #000;background-color: #fff;">Login</button>
                 <button class="btn btn-primary" type="reset" onclick="resetfun();" style="color: #000;background-color: #fff;">Reset</button>
                <a class="reset_pass" href="<?php echo base_url();?>forgetemail">Lost your password?</a>
             
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="<?php echo base_url();?>signup" class="to_register"> Create Account </a>
                </p>
		

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><!-- <i class="fa fa-paw"></i> --></h1>
                  <p>©2018 All Rights Reserved. <?php echo project_name();?></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>

<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

 <script>
$( document ).ready(function() {
 $('input').prop('value','')
});
   $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
  
  function resetfun()
   {
    window.location.reload();
   }
  $(document).ready(function() {
  setTimeout(function(){ $(".alert").hide(); }, 5000);
    
    $("#loginform").validate({
      rules: {
        
        password: {
          required: true,
          minlength: 5
        },
        
        email: {
          required: true,
          email: true
        },
 captha: {
          required: true
        }
      },
      messages: {
        
        password: {
          required: "Please enter Password",
          minlength: "Your password must be at least 5 characters long",
        },email: {
          required: "Please enter Email-address",
          
        },captha: {
          required: "Please enter Captcha",
          
        },
        
        email: "Please enter a valid email address",
        
      }

    }); });

$(document).ready(function() {
captcha();
   });

function captcha()
{
var a1 = Math.ceil(Math.random() * 9)+ '';
	var b1 = Math.ceil(Math.random() * 9)+ '';
	var c1 = Math.ceil(Math.random() * 9)+ '';
	var d1= Math.ceil(Math.random() * 9)+ '';
	var e1 = Math.ceil(Math.random() * 9)+ '';

	var code1 = a1 + b1 + c1 + d1 + e1;
	document.getElementById("feedcaptext").value = code1;
	document.getElementById("feedCaptchaDiv").innerHTML = code1;
}



  </script>

  <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>


  label.error
  {
    text-shadow:none !important;
    color: #7d1c1c !important;
    font-style : normal !important;
  }
  </style>
