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
                    <h2>Change Password</h2>
                   
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
                    <form action="<?php echo base_url()?>changepassword/updatepass" method="POST" id="changepassform" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Old Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="old_password" name="old_password"  class="form-control  col-md-7 col-xs-12" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="new_password" name="new_password" class="form-control  col-md-7 col-xs-12" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="confirm_password" class="form-control  col-md-7 col-xs-12" type="password" name="confirm_password" value="">
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" onclick="return formbtn();">Submit</button>
                          <button class="btn btn-primary" type="reset" onclick="funreset();">Reset</button>

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
 <script>
 $(document).ready(function(){
   $('input:text').val('');
 });
 $(document).ready(function(){
   $('input:password').val('');
 });


      jQuery.validator.addMethod("lettersnumber", function(value, element) {
    return this.optional(element) || /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{5,}$/i.test(value);
  }, "Please enter atleast 1 alphabet , 1 number and 1 special character($@$!%*#?&) ");

   $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
   function funreset()
   {
    window.location.reload();
   }

  $(document).ready(function() {
    setTimeout(function(){ $(".alert").hide(); }, 5000);

    $("#changepassform").validate({
      rules: {

        old_password: {
          required: true,


        },
        new_password: {
          required: true,
          minlength: 5,
          lettersnumber:true
        },
        confirm_password: {
          required: true,

           equalTo: "#new_password"
        }
      },
      messages: {
        old_password: {
          required: "Please enter Old password",


        },
        new_password: {
          required: "Please enter New Password",

          minlength: "Your Password must be at least 5 digit"
        },
        confirm_password: {
          required: "Please enter Confirm Password",

          equalTo:"password must be same"

        }
      }
    });
  });
  </script>

  <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>

.x_panel {
    color: #73879C;
    font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;
    font-size: 13px;
}

  label.error
  {
    text-shadow:none !important;
    color: red !important;
    font-style : normal !important;
  }
  </style>

