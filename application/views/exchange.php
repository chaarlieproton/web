<?php $this->load->view('include/header');
      $this->load->view('include/left_side_menu');
      $this->load->view('include/top_menu');?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <?php //$this->load->view('include/other_menu')?>  
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Exchange Your BTC To VCN</h2>
                   <div class="title_right">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right" style="text-align:center;
">

                              <div class="alert alert-block alert-success"><strong> 1 VCN = <span id="rate1" style="color:#fff !important;"></span> BTC</strong></div>
                              
                            </div>
                          </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-block alert-success alert1">
                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-block alert-danger alert1">
                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
                    <form action="<?php echo base_url()?>exchange/changeamt" method="POST" id="sendform" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">BTC Amount (Balance : <?php print_r($user_bal);?>) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id="BTCamount" name="amount" class="autofill form-control col-md-7 col-xs-12 allownumericwithdecimal" value="" onkeyup="compareamt();" required>
                        </div>
                      </div>
                      <div class="form-group" id="ratetxt" style="display:none !important;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <b><div > You Will Receive : <span id="rate"></span> VCN</div></b>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pin <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="pin" class="autofill form-control col-md-7 col-xs-12 allownumericwithdecimal" type="password" name="pin" autocomplete="off"  maxlength="6" required>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;&nbsp;</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <b>Note : </b>Excluding network fee 0.1% of transfer amount.
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
$(document).ready(function(){      
  $('input:password').val(''); 
});

 $.validator.setDefaults({
    submitHandler: function() {
      return true;
    }
  });
$(document).ready(function(){
   currentvcnrate();
   $('#ratetxt').hide();
   setTimeout(function(){ $(".alert1").hide(); }, 5000);
   setTimeout(function(){ $('.autofill').val(''); }, 2000);

});

$(".allownumericwithdecimal").on("keypress keyup blur",function (event) { 
$(this).val($(this).val().replace(/[^0-9\.]/g,'')); 
if ((event.which > 46 || $(this).val().indexOf('.') != -1)  && (event.which < 48 || event.which > 57) )  {
 event.preventDefault(); } });

function resetfun(){window.location.reload();}

     
function compareamt()
{
      var BTCamount=$('#BTCamount').val();
     $.post('<?php echo base_url();?>getvcn/compareamt',{
      
          amount:BTCamount
          },
          function(data){
         
         $('#rate').html(data);
	$('#ratetxt').show();
          }
        ); 


    }


    function currentvcnrate()
    {
       $.post('<?php echo base_url();?>getvcn/currentvcnrate',{},
          function(data){
          $('#rate1').html(data);        
          }
        ); 
    }

   $("#sendform").validate({

      rules: {
        
        
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
       
        amount: {
          required: "Please enter amount"
        },pin: {
          required: "Please enter Pin",
          minlength: "Your pin must be at least 6 digit long",
          maxlength: "Your pin must be at long 6 digit",
        }
        
      }
    });

  </script>
 <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">


<style>
label.error{text-shadow:none !important;color: #7d1c1c !important;font-style : normal !important;}
 </style>
       

       
