<?php $search_value = $this->session->userdata('search'); ?>

<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>List of constituent</h2>
               <div class="clearfix"></div>
            </div>
						<?php if($this->session->flashdata('msg')) {
							 $message = $this->session->flashdata('msg');?>
						<div class="<?php echo $message['class'] ?> alert-dismissible">
							 <button type="button" class="close" data-dismiss="alert">&times;</button>
							 <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
						</div>
						<?php  }  ?>
            <div class="x_content">
			 <form method='post' action="<?= base_url() ?>constituent/festival_wishes" >
			<div class="col-md-12 col-sm-12" style="padding:0px;">
        <div class="form-group row">
           <label class="col-form-label col-md-2 col-sm-3 ">Select festival</label>
          <div class="col-md-3 col-sm-4">
           <select class="form-control" name="cf_religion_id" id="religion_id">
             <option value="">Select</option>
             <?php foreach($res_festival as $rows_festival){ ?>
               <option value="<?php echo $rows_festival->id; ?>"><?php echo $rows_festival->festival_name; ?></option>
           <?php  } ?>
           </select>
           <script>$('#religion_id').val('<?php echo $cf_religion_id; ?>')</script>
         </div>
         <label class="col-form-label col-md-2 col-sm-3 ">Select Office</label>
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
          <label class="col-form-label col-md-2 col-sm-3 ">Select ward</label>
          <div class="col-md-3 col-sm-4">
            <select class="form-control" name="cf_ward_id" id ="ward_id" >
              <option value=""></option>
            </select>
          </div>
          <label class="col-form-label col-md-2 col-sm-3 ">&nbsp;</label>
          <div class="col-md-3 col-sm-2">
            <input class="btn btn-success" type='submit' name='submit' value='Search'>

           <a href="<?php echo base_url(). "report/reset_search"; ?>" class="btn btn-danger">Clear All</a>

         </div>
        </div>




			</div>
				</form>
			<div class="col-md-12 col-sm-12" style="overflow-x: scroll;">
        <div class="col-md-12 col-sm-12" style="padding:0px;">
    			  <div class="col-md-3 col-sm-3"></div>
    			  <div class="col-md-3 col-sm-3"></div>
    			  <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
    		</div>
			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
			<tr>
				<th>S.no</th>
       <th>Name</th>

       <th>Mobile</th>
       <th>Address</th>
       <th>Action</th>
			</tr>
			<?php
			$sno = $row+1;
			foreach($result as $data){ ?>
        <tr>
          <td><?php echo $sno; ?></td>
          <td><?php echo $data['full_name']; ?></td>
          <td><?php echo $data['mobile_no']; ?></td>
          <td><?php echo $data['address']; ?></td>
          <td><?php  if(empty($cf_religion_id)){
            echo "Select festival";
          }else{

            if($data['sent_festival_id']==$cf_religion_id){ ?>

          <?php  }else{ ?>
              <a href="#" onclick="send_festival('<?php echo $data['id']; ?>','<?php echo  $cf_religion_id; ?>')">send</a>
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



<script type="text/javascript">
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#list_constituent_menu').addClass('active');

   function send_festival(cons_id,festival_id){

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



   function get_paguthi(sel){
     var paguthi_id=sel.value;
     $.ajax({
   		url:'<?php echo base_url(); ?>masters/get_active_ward',
   		method:"POST",
   		data:{paguthi_id:paguthi_id},
   		dataType: "JSON",
   		cache: false,
   		success:function(data)
   		{
   		   var stat=data.status;
   		   $("#ward_id").empty();

   		   if(stat=="success"){
   		   var res=data.res;
   		   var len=res.length;
           $('#ward_id').html('<option value="">-ALL--</option>');
   		   for (i = 0; i < len; i++) {
   		   $('<option>').val(res[i].id).text(res[i].ward_name).appendTo('#ward_id');
   		   }

   		   }else{
   		   $("#ward_id").empty();

   		   }
   		}
   	});
   }
</script>
