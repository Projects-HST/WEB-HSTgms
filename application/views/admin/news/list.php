<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>News list</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			<div class="col-md-12 col-sm-12 ">

			<?php if($this->session->flashdata('msg')): ?>
				<div class="alert alert-success alert-dismissible " role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php echo $this->session->flashdata('msg'); ?>
				</div>
			<?php endif; ?>

          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th> Date</th>
				   <th> Title</th>
				   <th>Status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($result as $rows){ ?>
                 <tr>
                     <td><?php echo $i; ?></td>
					 <td><?php echo date('d-m-Y', strtotime($rows->news_date)); ?></td>

					 <td><?php echo $rows->title; ?></td>
                    <td><?php if($rows->status=='ACTIVE'){ ?>
                            <span class="badge-<?= $rows->status ?>">ACTIVE</span>
                            <?php  }else{ ?>
                              <span class="badge-<?= $rows->status ?>">INACTIVE</span>
                            <?php   } ?>
                    </td>
                    <td>
					<a href="<?php echo base_url(); ?>news/edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a>
					&nbsp; &nbsp; <a href="<?php echo base_url(); ?>news/gallery/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-picture-o"></i></a>
					</td>
                 </tr>

            <?php  $i++; } ?>



             </tbody>
          </table>

        </div>
            </div>
         </div>
      </div>



   </div>
</div>
<script type="text/javascript">

$('#news_menu').addClass('active');
   $('.news_menu').css('display','block');
   $('#list_news_menu').addClass('active current-page');

$('#master_form').validate({ // initialize the plugin
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
