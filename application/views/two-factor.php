<?php $this->load->view('include/header');
       $this->load->view('include/left_side_menu');
       $this->load->view('include/top_menu');?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Two-factor Authentication</h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
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
        <div id="enable" class="text-center">
<p>You can enable Google Time based One Time Password (TOTP) Two-factor Authentication to further protect your account. When it's enable, you are required to input the TOTP every time you login or withdraw funds. If you have an iOS or Android smartphone, you can do the following steps to enable it. In case you don't have a smartphone available, you can use the Google Authenticator on Windows as instructed in the later part, but it's less secure.</p>
<h4 style="font-weight:700">1st step: Install Google Authenticator on your smartphone.</h4>
<h4 style="font-weight:700">2nd step: Setup "Google Authenticator" and scan the following QR code</h4>
<img src=<?php print_r($qrCodeUrl); ?>>
<h4>Also you can choose "Enter provided key" and input this key: <?php echo $this->session->userdata('tfa_key');?></h4>
<h4 style="font-weight:700">3rd step: Input the TOTP showing on your smartphone:</h4>

                      <div class="ln_solid"></div>

                    <form action="<?php echo base_url()?>twofactor/verifytotp" method="POST" id="totpform" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Totp (Time based One Time Password)<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="totp" name="totp" class="form-control col-md-7 col-xs-12" required>
                        </div>
                      </div>
                     
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                
                          <button type="submit" class="btn btn-success" >Enable 2-factor</button>
                <button class="btn btn-primary" type="reset" onclick="resetfun();">Reset</button>
                        </div>
                      </div>

                    </form>
                    <h4>Notice: Do NOT delete the "Google Authenticator" app on your smartphone when it's enabled. If you lost your phone or deleted the "Google Authenticator" so contact us at <?php echo wallet_mail();?></h4>
                  </div>
                  <div id="disable">
                    <form action="<?php echo base_url()?>twofactor/disable" method="POST" id="totpform" class="form-horizontal form-label-left">
                      <button type="submit" class="btn btn-success" id="save">Disable 2-factor</button>
                    </form>
                  </div>
                  </div>
                </div>
              </div>
            </div>

          
          </div>
        </div>
        <!-- /page content -->
<?php $this->load->view('include/footer');  ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
  <script type="text/javascript">
 $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
jQuery.validator.addMethod("numbersonly", function(value, element) {
  return this.optional(element) || /^[0-9]+$/i.test(value);
}, "Please enter numbers only"); 
    function resetfun()
   {
    window.location.reload();
   }

      $(document).ready(function(){
        
        setTimeout(function(){ $(".alert").hide(); }, 5000);

        <?php if($this->session->userdata('tfa_status')==1){?>
          $('#disable').show();
          $('#enable').hide();
          <?php }else{?>
            $('#enable').show();
            $('#disable').hide();
            <?php }?>
      });

     

$( document ).ready(function() {
 $('input').prop('value','')
});


$("#totpform").validate({

      rules: {
         
        totp: {
          required: true,
	  numbersonly: true,
          maxlength: 6,
          minlength:6
          
        }
        
      },
      messages: {
       totp: {
          required: "Please enter Totp",
          minlength: "Your pin must be at least 6 digit long",
          maxlength: "Your pin must be 6 digit long"
	  
        }
        
      }
    });
  </script>
 <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>
label.error{text-shadow:none !important;color: #7d1c1c !important;font-style : normal !important;}
 </style>
       
       
