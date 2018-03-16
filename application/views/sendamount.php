<?php $this->load->view('include/header');
      $this->load->view('include/left_side_menu');
      $this->load->view('include/top_menu');?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <?php $this->load->view('include/other_menu')?>  
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Send <?php echo $this->session->userdata('currencyname');?> Amount</h2>
                   
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
                                    <form action="<?php echo base_url()?>sendamount/transferamount" autocomplete="off" method="POST" id="sendform" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Receiver Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="receive_address" name="receive_address"  class="form-control col-md-7 col-xs-12" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amount (Balance : <?php print_r($user_bal);?>) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="amount" name="amount" autofill="false" autocomplete="off" class="form-control  col-md-7 col-xs-12 autofill" required onkeypress="return isNumberKey(event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pin <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="pin" class="form-control col-md-7 col-xs-12 autofill" autofill="false"  autocomplete="off" type="password" name="pin" required value="" maxlength="6" onkeypress="return isNumberKey(event)" >
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">


                          <button type="submit" class="btn btn-success" id='save'>Submit</button>
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

 $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
$(document).ready(function(){      
  $('input:text').val(''); 
});
$(document).ready(function(){      
  $('input:password').val(''); 
  setTimeout(function(){ $(".autofill").val(''); }, 2000);
});



function resetfun(){window.location.reload();}

 
$(document).ready(function(){  
   $("#sendform").validate({

      rules: {
        
        
receive_address:{
required: true,
},
        amount: {
          required: true,          
        }, 
        pin: {
          required: true,
          maxlength: 6,
          minlength:6,
          numbersonly: true
        }
        
      },
      messages: {
        receive_address: {
          required: "Please enter address"
        },
        amount: {
          required: "Please enter amount"
        },pin: {
          required: "Please enter Pin",
          minlength: "Your pin must be at least 6 digit long",
          maxlength: "Your pin must be at long 6 digit",
        }
        
      }
    });  });

  </script>
 <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>
label.error{text-shadow:none !important;color: #7d1c1c !important;font-style : normal !important;}
 </style>
       

       
       
