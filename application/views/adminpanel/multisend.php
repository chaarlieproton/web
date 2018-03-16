<?php  
$this->load->view('adminpanel/include/header');
$this->load->view('adminpanel/include/left_side_menu');
$this->load->view('adminpanel/include/top_menu'); 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<div class="right_col" role="main">
          <div class="">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <?php //$this->load->view('include/other_menu');                
                ?>  
                <div class="x_panel">
                        <div class="x_title">
                            <h2>Users List</h2>
                            <div class="title_right">
                            <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right">

                             <!--  <select class="form-control" id="status" onchange="txnldatalist();">
                                <option value="all">All transactions</option>
                                <option value="send">Send transactions</option>
                                <option value="receive">Receive transactions</option>
                              </select> -->
                              
                            </div>
                          </div>
                      
                            <div class="clearfix"></div>

            <?php 

            if($this->session->flashdata('success')){ ?>
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
                      </div>
                      <div class="x_content">
                       <div id="txnlist">
                         <form action="<?php echo base_url();?>admin/claimdetails/sendRecords" method="post">
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                          <thead>
                            <tr>
                              <th>#ID</th>
                              <th>Name</th>
                              <th>Amount</th>
                              <th>Images</th>
                              <th>Action</th>
                              <th>Select</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i=1; foreach($listing as $list){?>
                           
                           <tr>
                            <td><?php echo $i++;?></td>
                             <td><?php echo $list->user_id;?></td>
                             <td><?php echo $list->amount_of_bch;?></td>
                             <td><img src="<?php echo base_url().$list->upload_image;?>" width="150"></td>
                             <th>
                              <a class="btn btn-sm btn-warning" title="User Details" href="<?php echo base_url().'admin/claimdetails/details/'.$list->serial_no;?>"><i class="fa fa-file-text"></i></a>
                            </th>
                            <th>
                              <input  type="checkbox" name="claimData[]" style="width: 50px; height: 25px;" value="<?php echo $list->user_id."^".$list->amount_of_bch;?>">
                            </th>
                           </tr>
                         
                           <?php }?>
                          </tbody>
                        </table>
                        <input type="submit" name="submit" value="Send CND"> 
                        </form>
                        </div>
                      </div>
                </div>
              </div>

            </div>
          </div>
        </div>


 <?php $this->load->view('adminpanel/include/footer');  ?>
<script>
        $(document).on('click','#remove5',function(){
            $('#catrgories5').val($(this).data('catrgories5'));
            $('#title5').val($(this).data('title5'));
            $('#video_desc5').val($(this).data('video_desc5'));
           $('#cover5').val($(this).data('cover5'));
           $('#tag5').val($(this).data('tag5'));
           $('#type5').val($(this).data('type5'));
           $('#price5').val($(this).data('price5'));
           $('#video5').val($(this).data('video5'));
           $('#created5').val($(this).data('created5'));
           $('#duration5').val($(this).data('duration5'));
           $('#duration15').val($(this).data('duration15'));
           $('#lang5').val($(this).data('lang5'));
           $('#top5').val($(this).data('top5'));
           $('#product_type5').val($(this).data('product_type5'));
           $('#trailer5').val($(this).data('trailer5'));
           $('#user_id5').val($(this).data('user_id5'));
           $('#id5').val($(this).data('id5'));
          
        });
    </script>


 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transction List</h4>
        </div>
        <div class="modal-body">
          <div class="row">
           
            <div class="title_right">
              
               <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right">
                <input type="hidden" name="user_email" id="user_email">
                              <select class="form-control" id="liststatus" onchange="gettxndetail();">
                                <option value="all">All transactions</option>
                                <option value="send">Send transactions</option>
                                <option value="receive">Receive transactions</option>
                              </select>
                              
                            </div>
              <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right">

                              <select class="form-control" id="currencylist" onchange="gettxndetail();">
                                <?php 
                    $this->load->model('Auth_model');
                    $menu_list = $this->Auth_model->currencylist();
                    foreach ($menu_list as $menudetail) { ?>
                    <option value="<?php echo base64_encode($menudetail->id);?>"><?php echo $menudetail->name;?> (<?php echo $menudetail->short_name;?>)</option>
                    <?php }?>
                              </select>
                              
                            </div>
                            <div id="balances"></div>
                          </div>
          </div>

          <div id="transactionlist">
               <table id="datatable-checkbox-txnlist" class="table table-striped table-bordered bulk_action">
                          <thead>
                            <tr>
                              <th>Date</th>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <style type="text/css">
    @media (min-width: 768px)
{
.modal-dialog {
    width: 90%;
    margin: 30px auto;
}  
}

  </style>
