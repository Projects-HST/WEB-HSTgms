<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Meeting Based Report</h2>

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
		<form id="report_form" action="<?php echo base_url(); ?>report/meetings" method="post" enctype="multipart/form-data">
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
                   <th>S.no</th>
				   <th>Date</th>
                   <th>Name</th>
				   <th>Phone</th>
				   <th>Details</th>
				   <th>Status</th>
                   <th>Created</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
					<td><?php echo date('d-m-Y', strtotime($rows->meeting_date)); ?></td>
                    <td><?php echo $rows->full_name; ?></td>
					<td><?php echo $rows->mobile_no; ?></td>
					<td><?php echo $rows->meeting_detail; ?></td>
					
					<?php 
						$meeting_status = $rows->meeting_status;
						if ($meeting_status == 'REQUESTED'){ ?>
								<td style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $meeting_status; ?></td>
								<!--<td><a href="<?php echo base_url(); ?>report/meeting_update/<?php echo base64_encode($rows->id*98765); ?>/<?php echo $dfromDate;?>/<?php echo $dtoDate;?>" onclick="return confirm('ARE YOU SURE YOU WANT TO UPDATE?');" style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $rows->meeting_status; ?></a></td>-->
						<?php } else { ?>
								<td style="font-size:13px;font-weight:bold;color:#1fae03;"><?php  echo $meeting_status; ?></td>
						<?php } ?>

                    <td><?php  echo $rows->created_by; ?></td>
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
<div class="modal fade bs-example-modal-lg" id="meeting_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Meeting request</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/save_meeting_request" method="post" id="meeting_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting status <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="meeting_status" class=" form-control" name="meeting_status" type="text" value="REQUESTED" readonly>
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting date <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="meeting_date" class=" form-control" name="meeting_date" type="text">
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting details<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="meeting_detail" class=" form-control" name="meeting_detail" rows="5"></textarea>
                    <input id="meeting_constituent_id" class=" form-control" name="meeting_constituent_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Save</button>
                  </div>
               </div>
            </form>

            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                     <th style="width:600px !important;">Meeting details</th>
                     <th>date</th>
                     <th>status</th>
                     <th>updated at</th>
                     <th>Action</th>

                  </tr>
               </thead>
               <tbody id="table_meeting">


               </tbody>
            </table>



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
