<?php $search_value = $this->session->userdata('search'); ?>

<div  class="right_col" role="main">
   <div class="">
    <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Festival wishes</h2>
               <span style="float:right">
                 <?php if(empty($cf_religion_id)){

                 }else{ ?>
                   <a href="<?php echo base_url(); ?>constituent/get_export_festival" class="btn btn-export">Export</a>
                 <?php } ?>
               </span>
               <div class="clearfix"></div>
            </div>
						<?php if($this->session->flashdata('msg')) {
							 $message = $this->session->flashdata('msg');?>
						<div class="<?php echo $message['class'] ?> alert-dismissible">
							 <button type="button" class="close" data-dismiss="alert">&times;</button>
							 <?php echo $message['message']; ?>
						</div>
						<?php  }  ?>
            <div class="x_content">
			 <form method='post' action="<?= base_url() ?>constituent/festival_wishes" id="report_form">
			<div class="col-md-12 col-sm-12" style="padding:0px;">
        <div class="form-group row">
           <label class="col-form-label col-md-2 col-sm-3 ">Select festival <span class="required">*</span></label>
          <div class="col-md-3 col-sm-4">
           <select class="form-control" name="cf_religion_id" id="religion_id">
             <option value="">Select</option>
             <?php foreach($res_festival as $rows_festival){ ?>
               <option value="<?php echo $rows_festival->id; ?>"><?php echo $rows_festival->festival_name; ?></option>
           <?php  } ?>
           </select>
           <script>$('#religion_id').val('<?php echo $cf_religion_id; ?>')</script>
         </div>
         <label class="col-form-label col-md-2 col-sm-3 ">Select paguthi</label>
       <div class="col-md-3 col-sm-4">
               <select class="form-control" name="cf_paguthi" id ="paguthi" onchange="get_paguthi(this);">
                 <option value="">ALL</option>
                 <?php foreach($paguthi as $rows){ ?>
                 <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
                 <?php } ?>
               </select>
               <script>$('#paguthi').val('<?php echo $cf_paguthi; ?>')</script>
         </div>


        </div>
        <div class="form-group row">
          <label class="col-form-label col-md-2 col-sm-3 ">Select Office</label>
          <div class="col-md-3 col-sm-4">

            <select class="form-control" name="cf_ward_id" id="office_id">
              <option value="">ALL</option>
              <?php foreach($res_office as $rows_office){ ?>
                 <option value="<?php echo $rows_office->id ?>"><?php echo $rows_office->office_name; ?></option>
             <?php } ?>
            </select>
            <script>$('#office_id').val('<?php echo $cf_ward_id; ?>')</script>
          </div>
          <label class="col-form-label col-md-2 col-sm-3 ">&nbsp;</label>
          <div class="col-md-4 col-sm-2">
            <input class="btn btn-success" type='submit' name='submit' value='Search'>

           <a href="<?php echo base_url(). "report/reset_search"; ?>" class="btn btn-danger">Clear</a>



         </div>
        </div>




			</div>

				</form>
        <div class="ln_solid"></div>
			<div class="col-md-12 col-sm-12" style="overflow-x: scroll;">
        <button class="btn btn-success pull-right" onclick="send_selected()">Send Selected</button>
        <div class="col-md-12 col-sm-12" style="padding:0px;">
           <div class="col-md-3 col-sm-3">
               <p style="margin-top:20px;">Total records : <?php echo $allcount; ?></p>
           </div>
           <div class="col-md-3 col-sm-3"></div>
           <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
       </div>

			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
			<tr>
				<th>S.no</th>
       <th>Name</th>
       <th>Surname</th>
       <th>Phone no</th>
       <th>Address</th>
       <th>check here</th>
       <th>Action</th>
			</tr>
			<?php
			$sno = $row+1;
			foreach($result as $data){ ?>
        <tr>
          <td><?php echo $sno; ?></td>
          <td><?php echo $data['full_name']; ?></td>
          <td><?php echo $data['father_husband_name']; ?></td>
          <td><?php echo $data['mobile_no']; ?></td>
          <td><?php echo $data['door_no']; ?><br><?php echo $data['address']; ?><br><?php echo $data['pin_code']; ?></td>
          <td><input type="checkbox" name="cons_id[]" class="cons_id" value="<?php echo $data['id']; ?>"></td>
          <td><?php  if(empty($cf_religion_id)){
            echo "Select festival";
          }else{

            if($data['sent_festival_id']==$cf_religion_id){
              echo "SENT";
              ?>

          <?php  }else{ ?>
              <!-- <a href="#" style="font-size:13px;font-weight:bold;color:#ee0606;" onclick="send_festival('<?php echo $data['id']; ?>','<?php echo  $cf_religion_id; ?>')">Not sent</a> -->
              <p style="font-size:13px;font-weight:bold;color:#ee0606;" >Not sent</p>
          <?php  }
          }
          ?>
        </td>
        </tr>
			<?php $sno++;	} ?>
		</table>
		</div>

		<div class="col-md-12 col-sm-12" style="padding:0px;">
			  <div class="col-md-3 col-sm-3"></div>
			  <div class="col-md-3 col-sm-3"></div>
			  <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
		</div>
	<!-- Paginate -->



            </div>
         </div>
      </div>

</div>
   </div>
</div>



<script type="text/javascript">
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#list_constituent_menu').addClass('active');

   function send_selected(){
       var len = $("[name='cons_id[]']:checked").length;
        var festival_id=$('#religion_id').val();
       if(len==0){
         alert("Check the constituent");
       }else{
         if (confirm("ARE YOU SURE YOU WANT TO UPDATE THE STATUS?")) {
         var cons_id = new Array();
          $('input[name="cons_id[]"]:checked').each(function(){
             cons_id.push($(this).val());
          });
         $.ajax({
             type: "POST",
             url: "<?php echo base_url(); ?>constituent/festival_selected_id",
             data:{festival_id:festival_id,cons_id:cons_id},
             success: function(data){
               if(data=='success'){
                 alert("Festival wishes sent Successfully!.")
                 location.reload();
               }else{

               }
             }
           });
         }
           return false;
         }


       }





   function send_festival(cons_id,festival_id){
     if (confirm("ARE YOU SURE YOU WANT TO UPDATE THE STATUS?")) {
     $.ajax({
   		url:'<?php echo base_url(); ?>constituent/sent_festival_wishes',
   		method:"POST",
   		data:{festival_id:festival_id,cons_id:cons_id},
   		cache: false,
   		success:function(data)
   		{
        if(data=='success'){
          location.reload();
        }else{

        }
   		}
   	});
   }
     return false;
   }



   function get_paguthi(sel){
     var paguthi_id=sel.value;
     $.ajax({
   		url:'<?php echo base_url(); ?>masters/get_active_office',
   		method:"POST",
   		data:{paguthi_id:paguthi_id},
   		dataType: "JSON",
   		cache: false,
   		success:function(data)
   		{
   		   var stat=data.status;
   		   // $("#office_id").empty();

   		   // if(stat=="success"){
   		   // var res=data.res;
   		   // var len=res.length;
         //   $('#office_id').html('<option value="">ALL</option>');
   		   // for (i = 0; i < len; i++) {
   		   // $('<option>').val(res[i].id).text(res[i].office_name).appendTo('#office_id');
   		   // }
         //
   		   // }else{
   		   // $("#office_id").empty();
         //
   		   // }
   		}
   	});
   }
   $('#report_form').validate({ // initialize the plugin
        rules: {
            cf_religion_id:{required:true},
            toDate:{required:true}
        },
        messages: {
              cf_religion_id: { required:"Select the festival name"},
              toDate: { required:"Select To Date"}
            }
    });
</script>
