<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Birthday Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			
		<form id="report_form" action="<?php echo base_url(); ?>report/birthday" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				 <label class="col-form-label col-md-1 col-sm-1 label-align">From <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="frmDate" value="<?php echo $dfromDate; ?>">
				 </div>
				  <label class="col-form-label col-md-1 col-sm-1 label-align">To <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
					<input type="text" class="form-control" placeholder="To Date" id="toDate" name="toDate" value="<?php echo $dtoDate; ?>">
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
					<th>Status</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ 
						$disp = "";
						$const_id = $rows->id;
						$year = date("Y"); 
						
						$subQuery = "SELECT * FROM consitutent_birthday_wish WHERE YEAR(created_at)='$year'";
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
                    <td><?php 
						if ($const_id == $birth_id){ ?>
								Send
						<?php } else { ?>
								<a href="#">Not Send</a>
						<?php } ?></td>
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
