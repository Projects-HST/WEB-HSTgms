<div  class="right_col" role="main">
   <div class="">
        <div class="col-md-12 col-sm-12 ">
          <?php if($this->session->flashdata('msg')) {
            $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
           </div>
          <?php  }  ?>
        
             <div class="x_panel">
               <h2>List of Colours</h2>

			<form id="master_form" action="<?php echo base_url(); ?>login/update_colour_settings" method="post" enctype="multipart/form-data">
			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:50%">
             <thead>
                <tr>
                   <th width="20%">S.no</th>
                   <th width="60%">Base Colours</th>
                   <th width="20%" style="text-align: center;">status</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ 
					$selected_status = $rows->selected_status;
			   ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><span class="badge" style="background-color: <?php echo $rows->colour_code; ?>;width:200px;color: #fffff;font-size:13px;padding:10px"><?php echo $rows->colour_code; ?></span></td>
                    <td style="text-align: center;">
					<?php if($selected_status =='Y'){ ?>
						<input type="radio" id="colour_id" name="colour_id" value="<?php echo $rows->id; ?>" checked>
					<?php }else{ ?>
						<input type="radio" id="colour_id" name="colour_id" value="<?php echo $rows->id; ?>">
					<?php } ?>
                    </td>
                 </tr>
            <?php  $i++; } ?>
				<tr>
                   <td></td>
                   <td></td>
                   <td style="text-align: center;"><button type="submit" class="btn btn-success" style="background-color:<?php echo $this->session->userdata('base_colour');?>;color:#000000;border:1px solid <?php echo $this->session->userdata('base_colour');?>;">Assing</button></td>
                </tr>
             </tbody>
          </table>
		  </form>
</div>
        </div>
   </div>
</div>
