<div  class="right_col" role="main">
   <div class="">

     <div class="x_panel">
       <div class="x_title">
          <h2><i class="fa fa-file-word-o"></i> list of grievance reply</h2>
          <div class="clearfix"></div>
       </div>
       <?php if($this->session->flashdata('msg')) {
          $message = $this->session->flashdata('msg');?>
       <div class="<?php echo $message['class'] ?> alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
       </div>
       <?php  }  ?>
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
           <thead>
              <tr>
                 <th>S.no</th>
                 <th>Full name</th>
                 <th>Sms text</th>
                 <th>sent on</th>
                 <th>sent by</th>
              </tr>
           </thead>
           <tbody>
             <?php $i=1; foreach($res as $rows){ ?>
               <tr>
                 <td><?php echo $i; ?></td>
                 <td><?php echo $rows->full_name; ?></td>
                 <td><?php echo $rows->sms_text; ?></td>
                 <td><?php echo date("d-m-Y h:i", strtotime($rows->created_at)); ?></td>
                 <!-- <td><?php echo $rows->grievance_name; ?></td> -->
                 <td><?php echo $rows->sent_by; ?></td>


                 </tr>
           <?php $i++; } ?>

           </tbody>
        </table>
     </div>

   </div>
 </div>
 <script>
 $('#grievance_menu').addClass('active');
 $('.grievance_menu').css('display','block');
 $('#list_grievance_reply_menu').addClass('active');
 </script>
