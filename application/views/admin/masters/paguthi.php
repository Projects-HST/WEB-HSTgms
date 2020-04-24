<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Create Paguthi</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">


               <form id="master_form" action="<?php echo base_url(); ?>masters/create_paguthi" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Paguthi name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="constituency_name" class=" form-control" name="paguthi_name" type="text" value="">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Paguthi short name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="paguthi_short_name" class=" form-control" name="paguthi_short_name" type="text" value="">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">status <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <select class="form-control" name="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Create</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>


        <div class="col-md-12 col-sm-12 ">
          <?php if($this->session->flashdata('msg')) {
            $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
           </div>
          <?php  }  ?>
             <div class="x_panel">
          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>paguthi</th>
                   <th>short name</th>
                   <th>status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $rows->paguthi_name; ?></td>
                    <td><?php echo $rows->paguthi_short_name ;?></td>
                    <td><?php if($rows->status=='ACTIVE'){ ?>
                            <span class="badge badge-success">Active</span>
                            <?php  }else{ ?>
                              <span class="badge badge-danger">Inactive</span>
                            <?php   } ?>
                    </td>
                    <td><a href="<?php echo base_url(); ?>masters/get_paguthi_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a></td>


                 </tr>

            <?php  $i++; } ?>



             </tbody>
          </table>
</div>
        </div>
   </div>
</div>
<script type="text/javascript">
$('#mastermenu').addClass('active');
$('.mastermenu').css('display','block');
$('#paguthimenu').addClass('active');
$('#master_form').validate({
     rules: {
         paguthi_name:{required:true,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthi",
                     type: "post"
                  }
             },
         paguthi_short_name:{required:true,maxlength:5,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthishort",
                     type: "post"
                  }
                 },
         status:{required:true }
     },
     messages: {
           paguthi_name: { required:"enter the paguthi name",remote:"paguthi name already exist"},
           paguthi_short_name: { required:"enter the paguthi short name",remote:"paguthi short name already exist"}
         }
 });
 </script>
