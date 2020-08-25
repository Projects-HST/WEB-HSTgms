<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Create Grievance type</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">


               <form id="master_form" action="<?php echo base_url(); ?>masters/create_grievance" method="post" enctype="multipart/form-data">
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 ">Seeker <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                       <select class="form-control" name="seeker_id" id="seeker_id">
                         <?php foreach($res_seeker as $rows_seeker){ ?>
                           <option value="<?php echo $rows_seeker->id ?>"><?php echo $rows_seeker->seeker_info ?></option>
                        <?php }?>

                       </select>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Grievance type name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="grievance_name" class=" form-control" name="grievance_name" type="text" value="">
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span>
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
                   <th>Seeker type</th>
                   <th>Grievance name</th>

                   <th>status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $rows->seeker_info; ?></td>
                    <td><?php echo $rows->grievance_name; ?></td>

                    <td><?php if($rows->status=='ACTIVE'){ ?>
                            <span class="badge-<?= $rows->status ?>">Active</span>
                            <?php  }else{ ?>
                              <span class="badge-<?= $rows->status ?>">Inactive</span>
                            <?php   } ?>
                    </td>
                    <td>
              <a title="EDIT" href="<?php echo base_url(); ?>masters/get_grievance_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;
              <a title="ADD GRIEVANCE SUB CATEGORY" href="<?php echo base_url(); ?>masters/sub_category/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-plus-square"></i></a>

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
$('#mastermenu').addClass('active');
$('.mastermenu').css('display','block');
$('#grievancemeenu').addClass('active');
$('#master_form').validate({
     rules: {
         grievance_name:{required:true },

         status:{required:true }
     },
     messages: {
           grievance_name: { required:"enter the grievance type name",remote:"grievance type already exist"}

         }
 });
 </script>
