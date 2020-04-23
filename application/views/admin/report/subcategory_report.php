<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Sub Category Based Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			
			<form id="report_form" action="<?php echo base_url(); ?>report/status" method="post" enctype="multipart/form-data">

                  <div class="item form-group">
                     <label class="col-form-label col-md-1 col-sm-1 label-align">From <span class="required">*</span></label>
                     <div class="col-md-3 col-sm-3">
							<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="frmDate">
                     </div>
					  <label class="col-form-label col-md-1 col-sm-1 label-align">To <span class="required">*</span></label>
                     <div class="col-md-3 col-sm-3">
						<input type="text" class="form-control" placeholder="To Date" id="toDate" name="toDate">
                     </div>
					 
                  </div>
				   <div class="item form-group">
                     
					  <label class="col-form-label col-md-1 col-sm-1 label-align">Status <span class="required">*</span></label>
                     <div class="col-md-3 col-sm-3">
							<select class="form-control" name="status" id ="status" >
								<option value="All">All</option>
								<option value="Processing">Processing</option>
								<option value="Completed">Completed</option>
							</select>
                     </div>
					  <label class="col-form-label col-md-1 col-sm-1 label-align">Area <span class="required">*</span></label>
                     <div class="col-md-3 col-sm-3">
							<select class="form-control" name="status" id ="status" >
								<option value="All">All</option>
								<option value="Processing">Processing</option>
								<option value="Completed">Completed</option>
							</select>
                     </div>
					 <div class="col-md-2 col-sm-2">
                         <button type="submit" class="btn btn-success">SEARCH</button>					 
                     </div>
                  </div>
                  <div class="ln_solid"></div>
               </form>

			   
		<div class="col-md-12 col-sm-12 ">
          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>Name</th>
				   <th>Email Id</th>
				   <th>Paguthi</th>
				   <th>Status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php //$i=1; foreach($result as $rows){ ?>
                 <tr>
                     <td><?php //echo $i; ?></td>
                    <td><?php //echo $rows->full_name; ?></td>
					 <td><?php //echo $rows->email_id; ?></td>
					 <td><?php //echo $rows->paguthi_name; ?></td>
                    <td><?php //if($rows->status=='Active'){ ?>
                            <span class="badge badge-success">Active</span>
                            <?php  //}else{ ?>
                              <span class="badge badge-danger">Inactive</span>
                            <?php  //} ?>
                    </td>
                    <td><a href="<?php //echo base_url(); ?>users/edit/<?php //echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a></td>
                 </tr>

            <?php //$i++; } ?>



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
         paguthi_name:{required:true,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthi",
                     type: "post"
                  }
             },
         paguthi_short_name:{required:true,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthishort",
                     type: "post"
                  }
                 },
         status:{required:true }
     },
     messages: {
           paguthi_name: { required:"enter the paguthi name",remote:"paguthi name already exist"},
           paguthi_short_name: { required:"enter the paguthi short name",remote:"paguthi short name already exist"}
         }
 });
 </script>
