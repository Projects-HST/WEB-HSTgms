<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Birthday Report</h2>

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
	
		<form id="report_form" action="<?php echo base_url(); ?>report/birthday" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				<label class="col-form-label col-md-2 col-sm-2 label-align">Select Month <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
					<select id="month" name="month" class="form-control">
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
					</select><script> $('#month').val('<?php echo $searchMonth; ?>');</script>
				 </div>
				 <div class="col-md-2 col-sm-2">
					 <button type="submit" class="btn btn-success">SEARCH</button>					 
				 </div>
			  </div>
			  <div class="ln_solid"></div>
		</form>

		<div class="col-md-12 col-sm-12 ">
          <table id="export_example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no </th>
				    <th>Name</th>
                    <th>Date of Birth</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Status</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; $birth_id=''; foreach($res as $rows){ 
						
						$const_id = $rows->id;
						$year = date("Y"); 
						
						$subQuery = "SELECT * FROM consitutent_birthday_wish WHERE YEAR(created_at)='$year' AND constituent_id = '$const_id'";
                    	$subQuery_result = $this->db->query($subQuery);
							foreach ($subQuery_result->result() as $rows1)
                			{
                			    $birth_id = $rows1->constituent_id;
                			}
			   ?>
                 <tr>
                    <td><?php echo $i; ?></td>
					<td><?php echo $rows->full_name; ?></td>
					<td><?php echo date('d-m-Y', strtotime($rows->dob)); ?></td>
					<td><?php echo $rows->mobile_no; ?></td>
					<td><?php echo $rows->door_no; ?><br><?php echo $rows->address; ?><br><?php echo $rows->pin_code; ?></td>
					<?php 
					if ($const_id == $birth_id){ ?>
						<td style="font-size:13px;font-weight:bold;color:#1fae03;">Send</td>
					<?php } else { ?>
						<td><a href="<?php echo base_url(); ?>report/birthday_update/<?php echo $searchMonth?>/<?php echo base64_encode($rows->id*98765);?>" onclick="return confirm('ARE YOU SURE YOU WANT TO UPDATE?');" style="font-size:13px;font-weight:bold;color:#ee0606;">Not Send</a></td>	
					<?php } ?>
                 </tr>
            <?php $i++; } ?>
             </tbody>
          </table>

        </div>
            </div>
         </div>
      </div>


        
   </div>
</div>
<script type="text/javascript">

$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#report_form').validate({ // initialize the plugin
     rules: {
         frmDate:{required:true},
         toDate:{required:true}
     },
     messages: {
           frmDate: { required:"Select From Date"},
           toDate: { required:"Select To Date"}
         }
 });
 </script>
