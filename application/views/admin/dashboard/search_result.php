<style type="text/css">


	</style>
  <div  class="right_col" role="main">
   <div class="">
   <form id="search_form" action="<?php echo base_url(); ?>dashboard/searchresult" method="post" enctype="multipart/form-data">
		<div class="title_left" style="padding-top:70px;">
			<div class="col-md-12 col-sm-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" name="d_keyword" id="keyword" placeholder="Search for FULL Name,FATHER OR HUSBAND NAME Phone number, Voter ID, Aadhaar Card number ,Address" value="<?php echo $d_keyword;?>">
				<span class="input-group-btn">
					<input type="submit" class="btn btn-default" name="submit"  style="padding: 15px 10px 13px 10px;background-color: #31aa15;
    color: #fff;    font-weight: 600;" value="Go!">
				</span>
			</div>
			</div>
		</div>
		</form>

		<div class="clearfix"></div>


      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">

            <?php if($this->session->flashdata('msg')) {
               $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
            </div>
            <?php  }  ?>
            <div class="col-md-12 col-sm-12" style="padding:0px;">
               <div class="col-md-3 col-sm-3"><h2>Search Result</h2> Total records <?php echo $total_records; ?></div>
               <div class="col-md-3 col-sm-3"></div>
               <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
           </div>
            <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>Full name</th>
										 <th>Surname</th>
										 <th>Mobile</th>
                     <th>Paguthi</th>
					           <th>ward</th>
										 <th>Address</th>

                     <th>Voter id</th>
                     <!-- <th>Aadhhar id</th> -->
                     <!-- <th>Status</th> -->
										 <th>view</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $i=$row+1; foreach($result as $rows){ ?>
                  <tr>
                     <td><?php echo $i; ?></td>
                     <td><?php echo $rows['full_name']; ?></td>
										 <td><?php echo $rows['father_husband_name']; ?></td>
										 <td><?php echo $rows['mobile_no'] ;?></td>
										 <td><?php echo $rows['paguthi_name']; ?></td>
										 <td><?php echo $rows['ward_name'] ;?></td>
										 <td><?php echo $rows['door_no']; ?><br><?php echo $rows['address']; ?><br><?php echo $rows['pin_code']; ?></td>

                     <td><?php echo $rows['voter_id_no'] ;?></td>
                     <!-- <td><?php echo $rows['aadhaar_no'] ;?></td> -->
                     <!-- <td><?php if($rows['status']=='ACTIVE'){ ?>
                        <span class="badge-<?= $rows['status'] ?>">Active</span>
                        <?php  }else{ ?>
                        <span class="badge-<?= $rows['status'] ?>">Inactive</span>
                        <?php   } ?>
                     </td> -->
										 <td><a title="INFO" target="_blank" href="<?php echo base_url(); ?>constituent/constituent_profile_info/<?= base64_encode($rows['id']*98765); ?>"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  <?php  $i++; } ?>
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
