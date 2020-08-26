<?php $search_value = $this->session->userdata('search'); ?>
<style type="text/css">
th{
  width:100px;
}

	</style>
  <div  class="right_col" role="main">
   <div class="">

     <div class="x_panel">
       <div class="">
          <h2>list of grievance reply</h2>

       </div>
       <div class="ln_solid"></div>
       <?php if($this->session->flashdata('msg')) {
          $message = $this->session->flashdata('msg');?>
       <div class="<?php echo $message['class'] ?> alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
       </div>
       <?php  }  ?>
       <div class="pull-right" style="padding:0px;"><?= $pagination; ?></div>
        <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
             <?php $i=$row+1; foreach($res as $rows){ ?>
               <tr>
                 <td><?php echo $i; ?></td>
                 <td><?php echo $rows['full_name']; ?></td>
                 <td><?php echo $rows['sms_text']; ?></td>
                 <td><?php echo date("d-m-Y h:i", strtotime($rows['created_at'])); ?></td>
                 <!-- <td><?php echo $rows['grievance_name']; ?></td> -->
                 <td><?php echo $rows['sent_by']; ?></td>


                 </tr>
           <?php $i++; } ?>

           </tbody>
        </table>
        <div class="col-md-12 col-sm-12" style="padding:0px;">
           <div class="col-md-3 col-sm-3"></div>
           <div class="col-md-3 col-sm-3"></div>
           <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
       </div>
     </div>


   </div>
 </div>
 <script>
 $('#grievance_menu').addClass('active');
 $('.grievance_menu').css('display','block');
 $('#list_grievance_reply_menu').addClass('active');
 </script>
