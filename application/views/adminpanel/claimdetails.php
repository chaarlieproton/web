<?php $this->load->view('adminpanel/include/header');
      $this->load->view('adminpanel/include/left_side_menu');
      $this->load->view('adminpanel/include/top_menu');?>
        <!-- page content -->
         <div class="right_col" role="main">

          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>User Claim Details</h3>
              </div>

             
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Last User Claim Detail</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-3">
                      <div class="product-image">
                        <img src="<?php echo base_url().''.$listing[0]->upload_image;?>" height="50" width="50" alt="..." />
                      </div>
                     
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                      <h4 class="prod_title">The original BCH holders will be compensated with 1000 CDY.</h4>
                      <p>                                              
                        Check User Your Block Address *<br>
                       Check user's Total The Amount of BCH Before 512666*<br>
                       Check the user's screenshot of Claim .<br>
                      </p>
                     
                      <br/>

                      <div class="">
                        <h2>Total send CDY</h2>
                        <p><?php echo $listing[0]->amount_of_bch;?></p>
                      </div>
                      <br />

                      <div class="">
                        <h2>Block Address </h2>
                        <p><?php echo $listing[0]->bch_address;?></p>
                      </div>
                      <br />

                      
                      <div class="">
                        <a type="button" class="btn btn-default btn-lg" href="<?php base_url();?>multisend/sendCDY/<?php echo $listing[0]->amount_of_bch;?>">Send CDY</a>
                        <button type="button" class="btn btn-default btn-lg">Cancel</button>
                      </div>


                    </div>


                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<?php $this->load->view('include/footer');  ?>

 

<style>


  label.error
  {
    text-shadow:none !important;
    color: #7d1c1c !important;
    font-style : normal !important;
  }
  </style>
       
