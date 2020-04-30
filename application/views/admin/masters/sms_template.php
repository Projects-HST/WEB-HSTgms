<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Create sms template</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <form id="master_form" action="<?php echo base_url(); ?>masters/create_sms_template" method="post" enctype="multipart/form-data">
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">SMS type <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                       <select class="form-control" name="template_type" id="template_type">
                         <option value="GENERAL">GENERAL</option>
                         <option value="REPLY">REPLY</option>
                       </select>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">sms title <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="sms_title" class=" form-control" name="sms_title" type="text" value="">

                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">sms text  <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <textarea name="sms_text" id="sms_text" class="form-control"></textarea>
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
                   <th>Type</th>
                   <th>title</th>
                   <th>text</th>
                   <th>status</th>
                   <th>Action</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $rows->template_type; ?></td>
                    <td><?php echo $rows->sms_title; ?></td>
                    <td><?php echo $rows->sms_text; ?></td>
                    <td><?php if($rows->status=='ACTIVE'){ ?>
                            <span class="badge badge-success">Active</span>
                            <?php  }else{ ?>
                              <span class="badge badge-danger">Inactive</span>
                            <?php   } ?>
                    </td>
                    <td>
              <a title="EDIT" href="<?php echo base_url(); ?>masters/get_sms_template_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;

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
$('#smsmenu').addClass('active');
$('#master_form').validate({
     rules: {
         sms_title:{required:true,maxlength:50 },
         sms_text:{required:true,maxlength:240 },
         status:{required:true }
     },
     messages: {
       sms_title:{required:"enter sms title"},
       sms_text:{required:"enter sms text" }

         }
 });
 </script>
