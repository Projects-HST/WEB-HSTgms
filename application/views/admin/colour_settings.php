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

			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th width="10%">S.no</th>
                   <th>Base Colours</th>
                   <th>status</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ 
					$selected_status = $rows->selected_status;
			   ?>
                 <tr>
                     <td><?php echo $i; ?></td>
                    <td><span class="badge" style="background-color: <?php echo $rows->colour_code; ?>;width:200px;color: #fffff;font-size:13px;padding:10px"><?php echo $rows->colour_code; ?></span></td>
                    <td>
					<?php if($selected_status =='Y'){ ?>
						<input type="radio" id="colour_id" name="colour_id" value="<?php echo $rows->id; ?>" checked>
					<?php }else{ ?>
						<input type="radio" id="colour_id" name="colour_id" value="<?php echo $rows->id; ?>">
					<?php } ?>
                    </td>
                 </tr>
            <?php  $i++; } ?>



             </tbody>
          </table>
</div>
        </div>
   </div>
</div>
