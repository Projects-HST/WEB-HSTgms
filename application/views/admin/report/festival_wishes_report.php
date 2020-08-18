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
			 <form method='post' action="<?= base_url() ?>report/festival_wishes_report" >
			<div class="col-md-12 col-sm-12" style="padding:0px;">
        <div class="col-md-2 col-sm-4">
         <select class="form-control" name="year_id" id="year_id">

           <?php foreach($res_year as $rows_year){ ?>
             <option value="<?php echo $rows_year->year_name; ?>"><?php echo $rows_year->year_name; ?></option>
         <?php  } ?>
         </select>
         <?php if(empty($year_id)){

         }else{ ?>
           <script>$('#year_id').val('<?php echo $year_id; ?>')</script>
         <?php } ?>

       </div>
			   <div class="col-md-2 col-sm-4">
          <select class="form-control" name="religion_id" id="religion_id">
            <option value="">--Select--</option>
            <?php foreach($res_festival as $rows_festival){ ?>
              <option value="<?php echo $rows_festival->id; ?>"><?php echo $rows_festival->festival_name; ?></option>
          <?php  } ?>
          </select>
          <script>$('#religion_id').val('<?php echo $festival_id; ?>')</script>
        </div>
      <div class="col-md-2 col-sm-4">
              <select class="form-control" name="paguthi" id ="paguthi" onchange="get_paguthi(this);">
                <option value="">ALL</option>
                <?php foreach($paguthi as $rows){ ?>
                <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
                <?php } ?>
              </select>
        </div>
          <div class="col-md-2 col-sm-4">
            <select class="form-control" name="ward_id" id ="ward_id" >
              <option value=""></option>
            </select>
          </div>
				  <div class="col-md-3 col-sm-2"><input class="btn btn-success" type='submit' name='submit' value='Search'>

						<a href="<?php echo base_url(). "report/festival_wishes_report"; ?>" class="btn btn-danger">Clear All</a>

				  </div>

			</div>
				</form>
			<div class="col-md-12 col-sm-12" style="overflow-x: scroll;">
        <div class="x_panel">
        <div class="col-md-12 col-sm-12" style="padding:0px;">
           <div class="col-md-3 col-sm-3">
              <h2>Search Result</h2>
              Total records <?php echo $allcount; ?>
           </div>
           <div class="col-md-3 col-sm-3"></div>
           <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
        </div>
			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
			<tr>
				<th>S.no</th>
       <th>Name</th>
			 <th>Festival name</th>
       <th>Mobile</th>
       <th>Address</th>
       <th>Sent on</th>
			</tr>
			<?php
			$sno = $row+1;
			foreach($result as $data){ ?>
        <tr>
          <td><?php echo $sno; ?></td>
          <td><?php echo $data['full_name']; ?></td>
					<td><?php echo $data['festival_name']; ?></td>
          <td><?php echo $data['mobile_no']; ?></td>
          <td><?php echo $data['address']; ?></td>
          <td><?php echo date("d-m-Y H:i", strtotime($data['sent_on'])); ?>
        </td>
        </tr>
			<?php $sno++;	} ?>
		</table>
		</div>
    </div>

		<div class="col-md-12 col-sm-12" style="padding:0px;">
			  <div class="col-md-3 col-sm-3"></div>
			  <div class="col-md-3 col-sm-3"></div>
				<?php if(!empty($result)){ ?>
					<div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
			<?php	} ?>

		</div>
	<!-- Paginate -->



            </div>
         </div>
      </div>


   </div>
</div>



<script type="text/javascript">
$('#reportmenu').addClass('active');
$('.reportmenu').css('display','block');
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
           $('#ward_id').html('<option value="">-SELECT ward --</option>');
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
