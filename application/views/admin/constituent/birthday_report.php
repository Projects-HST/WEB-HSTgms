<div  class="right_col" role="main">
   <div class="">
    <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Birthday Wishes</h2>
               <span style="float:right;"><a href="<?php echo base_url(); ?>constituent/get_export_birthday" class="btn btn-export">Export</a></span>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			<?php if($this->session->flashdata('msg')): ?>
		<div class="alert alert-success alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<?php echo $this->session->flashdata('msg'); ?>
		</div>
	<?php endif; ?>

		<form id="report_form" action="<?php echo base_url(); ?>constituent/birthday" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				<label class="col-form-label col-md-2 col-sm-2">select Month <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
					<select id="month_id" name="b_month" class="form-control">
            <option value="">Select month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
          <?php if(empty($month_id)){ ?>
              <script>$('#month_id').val('<?php echo date("m"); ?>')</script>
        <?php  }else{ ?>
              <script>$('#month_id').val('<?php echo $month_id; ?>')</script>
          <?php } ?>

				 </div>
				 <div class="col-md-4 col-sm-2">
					 <input type="submit" name="submit" class="btn btn-success" value="SEARCH">
           <a href="<?php echo base_url(). "report/reset_search"; ?>" class="btn btn-danger">Clear</a>

				 </div>
			  </div>
			  <div class="ln_solid"></div>
		</form>

		<div class="col-md-12 col-sm-12 ">
      <button class="btn btn-success pull-right" onclick="send_selected()">Send Selected</button>

      <div class="col-md-12 col-sm-12" style="padding:0px;">
         <div class="col-md-3 col-sm-3">
           Total records : <?php echo $allcount; ?>
         </div>
         <div class="col-md-3 col-sm-3"></div>
         <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
     </div>

          <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                  <th>S.no </th>
                  <th>Name</th>
                  <th>SURNAME</th>
                  <th>DOB</th>
                  <th>Phone no</th>
                  <th>DOOR NO & Address</th>
                  <th><input type="checkbox" name="select_all" id="select_all" class="checkAll" /> check all</th>

                  <th>Status</th>
                </tr>
             </thead>
             <tbody>
               <?php 	$sno = $row+1;
               foreach($result as $rows){ ?>
                <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $rows['full_name']; ?></td>
                <td><?php echo $rows['father_husband_name']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($rows['dob'])); ?></td>
                <td><?php echo $rows['mobile_no']; ?></td>
                <td><?php echo $rows['door_no']; ?><br><?php echo $rows['address']; ?><br><?php echo $rows['pin_code']; ?></td>
                <td><input type="checkbox" name="cons_id[]" class="cons_id" value="<?php echo $rows['id']; ?>"></td>

                <td><?php if(is_null($rows['wish_id'])){ ?>
                  <!-- <a href="<?php echo base_url(); ?>constituent/birthday_update/<?php echo base64_encode($rows['id']*98765);?>" onclick="return confirm('ARE YOU SURE YOU WANT TO UPDATE THE STATUS ?');" style="font-size:13px;font-weight:bold;color:#ee0606;">NOT SENT</a> -->
                  <p style="font-size:13px;font-weight:bold;color:#ee0606;">NOT SENT</p>
              <?php  }else{ ?>
                <p>SENT</p>
              <?php  } ?></td>
                <!-- <td></td> -->
                </tr>
				          <?php  $sno++; }  ?>
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
      </div>

</div>

   </div>
</div>
<script type="text/javascript">
$('.checkAll').click(function(){
  $("input[name='cons_id[]']").prop('checked', $(this).prop("checked"));

});
function send_selected(){
    var len = $("[name='cons_id[]']:checked").length;
     var festival_id=$('#religion_id').val();
    if(len==0){
      alert("CHECK THE CONSTITUENT");
    }else{
      if (confirm("ARE YOU SURE YOU WANT TO UPDATE THE STATUS?")) {
      var cons_id = new Array();
       $('input[name="cons_id[]"]:checked').each(function(){
          cons_id.push($(this).val());
       });
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>constituent/birthday_update",
          data:{cons_id:cons_id},
          success: function(data){
            if(data=='success'){
              alert("Birthday wishes sent Successfully!.")
              location.reload();
            }else{

            }
          }
        });
      }
        return false;
      }


    }
$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#report_form').validate({ // initialize the plugin
     rules: {
         b_month:{required:true},
         toDate:{required:true}
     },
     messages: {
           b_month: { required:"Select the  Month"},
           toDate: { required:"Select To Date"}
         }
 });
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#constituent_birthday').addClass('active current-page');
 </script>
