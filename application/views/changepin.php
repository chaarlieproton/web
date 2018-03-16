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
                    <h2>Change Pin</h2>
                   
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
                   <form action="<?php echo base_url()?>changepin/updatepin" method="POST" id="changepinform" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="old_pin" name="old_pin" required class="form-control col-md-7 col-xs-12" value=""   >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Pin <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="new_pin" name="new_pin" required  class="form-control col-md-7 col-xs-12" value=""  maxlength="6" onkeypress="return isNumberKeyOnly(event);" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Pin <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="confirm_pin" required class="form-control col-md-7 col-xs-12" type="password" name="confirm_pin" value=""  maxlength="6" onkeypress="return isNumberKeyOnly(event);" >
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">


                          <button type="submit" class="btn btn-success" id="save">Submit</button>
                          <button class="btn btn-primary" type="reset" onclick="resetfun();">Reset</button>
                        </div>
                      </div>

                    </form>
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
$(document).ready(function(){      
  $('input:text').val(''); 
 
});
 $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
$(document).ready(function(){      
  $('input:password').val(''); 
});

  $(document).ready(function() {
   $('#new_pin').bind('copy paste cut',function(e) {
   e.preventDefault(); //disable cut,copy,paste

   });
  });

  $(document).ready(function() {
   $('#confirm_pin').bind('copy paste cut',function(e) { 
   e.preventDefault(); //disable cut,copy,paste

   });
  });

    function isNumberKeyOnly(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if ((charCode >= 48 && charCode <= 57) || (charCode == 8) )
          return true;
      return false;
  }

      $(document).ready(function(){
      //  $("#changepinform").validationEngine('attach');
        setTimeout(function(){ $(".alert").hide(); }, 5000);
      });
      function resetfun()
   {
    window.location.reload();
   }
      

 $("#changepinform").validate({
      rules: {

        old_pin: {
          required: true,


        },
        new_pin: {
          required: true,
          minlength: 6,
         
        },
        confirm_pin: {
          required: true,

           equalTo: "#new_pin"
        }
      },
      messages: {
        old_pin: {
          required: "Please enter current password",


        },
        new_pin: {
          required: "Please enter New pin",

          minlength: "Your pin must be atleast 6 digit"
        },
        confirm_password: {
          required: "Please enter Confirm Pin",

          equalTo:"pin must be same"

        }
      }
    });
  </script>
<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>

  label.error
  {
    text-shadow:none !important;
    color: red !important;
    font-style : normal !important;
  }
  </style>

