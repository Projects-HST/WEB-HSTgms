<div  class="right_col" role="main">
   <div class="">
   <form id="search_form" action="<?php echo base_url(); ?>dashboard/searchresult" method="post" enctype="multipart/form-data">
		<div class="title_left" style="padding-top:70px;">
			<div class="col-md-12 col-sm-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search for Name,Phone number,Voter ID,Aadhaar Card number" value="<?php echo $keyword;?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" style="padding:12px;">Go!</button>
				</span>
			</div>
			</div>
		</div>
		</form>

		<div class="clearfix"></div>
		<hr>

      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <h2>Search Result</h2>
            <?php if($this->session->flashdata('msg')) {
               $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
            </div>
            <?php  }  ?>
            <table id="export_example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>Full name</th>
                     <th>Paguthi</th>
					 <th>Serial no</th>
                     <th>Mobile</th>
                     <th>Voter id</th>
                     <th>Aadhhar id</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $i=1; foreach($res as $rows){ ?>
                  <tr>
                     <td><?php echo $i; ?></td>
                     <td><?php echo $rows->full_name; ?></td>
					 <td><?php echo $rows->paguthi_name; ?></td>
					 <td><?php echo $rows->serial_no ;?></td>
                     <td><?php echo $rows->mobile_no ;?></td>
                     <td><?php echo $rows->voter_id_no ;?></td>
                     <td><?php echo $rows->aadhaar_no ;?></td>
                     <td><?php if($rows->status=='ACTIVE'){ ?>
                        <span class="badge badge-success">Active</span>
                        <?php  }else{ ?>
                        <span class="badge badge-danger">Inactive</span>
                        <?php   } ?>
                     </td>
                  </tr>
                  <?php  $i++; } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<script type="text/javascript">

</script>
