<?php  
$this->load->view('include/header');
$this->load->view('include/left_side_menu');
$this->load->view('include/top_menu'); 
?>
<!-- <div class="right_col" role="main"></div> -->
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="row tile_count">
             
        <?php 
        $this->load->model('Auth_model');
        $menu_list = $this->Auth_model->currencylist();

        foreach ($menu_list as $balancedetail) {
         
          $rpc_host=$balancedetail->host;
          $rpc_user=$balancedetail->user;
          $rpc_pass=$balancedetail->pass;
          $rpc_port=$balancedetail->port;

          $client= new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
          $balance=$client->getBalance($this->session->userdata['email']);
          ?>
            <div class="col-md-4 col-sm-6 col-xs-8 tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> <?php echo $balancedetail->name ?> (<?php echo $balancedetail->short_name ?>)</span>
              <div class="count"><?php echo number_format($balance,8);?></div>
             <!--  <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </div>
          <?php  }   ?>
            
          </div>




          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                 <div class="x_title">
                            <h2>Transaction <?php echo $this->session->userdata('currencyname');?> List</h2>
                            <div class="title_right">
                            <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right">

                              <select class="form-control" id="status" onchange="txnldatalist();">
                                <option value="all">All transactions</option>
                                <option value="send">Sent transactions</option>
                                <option value="receive">Received transactions</option>
                              </select>
                              
                            </div>
                          </div>
                      
                            <div class="clearfix"></div>
                      </div>
                 <div class="x_content">
                       <div id="txnlist">
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                          <thead>
                            <tr>
                              <th>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th>Address</th>
                              <th>Type</th>
                              <th>Amount</th>
                              <th>Confirmations</th>
                              <th>TX Id</th>
                            </tr>
                          </thead>
                          <tbody>
                           
                          </tbody>
                        </table>
                        </div>
                      </div>
               
              </div>
            </div>


          </div>
        </div>
        <!-- /page content -->

       
 <?php $this->load->view('include/footer');  ?>
  <script type="text/javascript">
   

   $(document).ready(function(){
        txnldatalist();
        
        
      });
   function txnldatalist()
   {
      var status=$('#status').val();
      $.post("<?php echo base_url();?>transactionlist/gettransactionlistdetail",{
      
      status:status
      },
      function(data){
      $('#txnlist').html(data);
      $('#datatable-checkbox').dataTable({
        
        });
      }
    ); 
   }
 </script>

