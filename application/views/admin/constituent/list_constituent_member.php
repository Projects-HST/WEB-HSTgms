<div  class="right_col" role="main">
   <div class="">
        <div class="col-md-12 col-sm-12 ">
          <?php if($this->session->flashdata('msg')) {
            $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
           </div>
          <?php  }  ?>
             <div class="x_panel">
               <h2>List of constituent member</h2>
          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>full name</th>
                   <th>paguthi</th>
                   <th>mobile</th>
                    <th>voter id</th>
                    <th>aadhhar id</th>
                    <th>serial no</th>
                   <th>status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $rows->full_name; ?></td>
                    <td><?php echo $rows->paguthi_name; ?></td>
                    <td><?php echo $rows->mobile_no ;?></td>
                    <td><?php echo $rows->voter_id_no ;?></td>
                    <td><?php echo $rows->aadhaar_no ;?></td>
                    <td><?php echo $rows->serial_no ;?></td>
                    <td><?php if($rows->status=='Active'){ ?>
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
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#list_constituent_menu').addClass('active');
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
