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
               <h2>List of religion</h2>

          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>Religion</th>
                   <th>status</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $rows->religion_name; ?></td>

                    <td><?php if($rows->status=='ACTIVE'){ ?>
                            <span class="badge badge-success">Active</span>
                            <?php  }else{ ?>
                              <span class="badge badge-danger">Inactive</span>
                            <?php   } ?>
                    </td>
                 </tr>
					<?php  $i++; } ?>
             </tbody>
          </table>
</div>
        </div>
   </div>
</div>
<script type="text/javascript">
$('#master_form').validate({ // initialize the plugin
     rules: {
         seeker_info:{required:true,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkseeker",
                     type: "post"
                  }
             },

         status:{required:true }
     },
     messages: {
           seeker_info: { required:"enter the seeker type",remote:"seeker type already exist"}

         }
 });
 </script>
