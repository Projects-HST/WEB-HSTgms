<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_panel">
               <div class="x_title">
                  <h2><i class="fa fa-file-word-o"></i> list of grievance</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Petition</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#enquiry_tab" role="tab" aria-controls="profile" aria-selected="false">Enquiry</a>
                     </li>

                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="x_panel">
                          <?php if($this->session->flashdata('msg')) {
                             $message = $this->session->flashdata('msg');?>
                          <div class="<?php echo $message['class'] ?> alert-dismissible">
                             <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
                          </div>
                          <?php  }  ?>
                           <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>S.no</th>
                                    <th>Full name</th>
                                    <th>paguthi</th>
                                    <th>seeker</th>
                                    <!-- <th>category</th> -->
                                    <th>sub category</th>
                                    <th>petition no</th>
                                    <th>status</th>
                                    <th>updated at</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php $i=1; foreach($res as $rows){ ?>
                                  <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rows->full_name; ?></td>
                                    <td><?php echo $rows->paguthi_name; ?></td>
                                    <td><?php echo $rows->seeker_info; ?></td>
                                    <!-- <td><?php echo $rows->grievance_name; ?></td> -->
                                    <td><?php echo $rows->sub_category_name; ?></td>
                                    <td><?php echo $rows->petition_enquiry_no; ?></td>
                                    <td><?php echo $rows->status; ?></td>
                                    <td><?php echo $rows->updated_at; ?></td>
                                    <td><?php echo $rows->id; ?></td>
                                    </tr>
                              <?php $i++; } ?>

                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                       <div class="x_panel">
                          <table id="example_2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                             <thead>
                                <tr>
                                  <th>S.no</th>
                                  <th>Full name</th>
                                  <th>paguthi</th>
                                  <th>seeker</th>
                                  <!-- <th>category</th> -->
                                  <th>sub category</th>
                                  <th>petition no</th>
                                  <th>status</th>
                                  <th>updated at</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                               <?php $i=1; foreach($res_petition as $rows_petition){ ?>
                                 <tr>
                                   <td><?php echo $i; ?></td>
                                   <td><?php echo $rows_petition->full_name; ?></td>
                                   <td><?php echo $rows_petition->paguthi_name; ?></td>
                                   <td><?php echo $rows_petition->seeker_info; ?></td>
                                   <!-- <td><?php echo $rows_petition->grievance_name; ?></td> -->
                                   <td><?php echo $rows_petition->sub_category_name; ?></td>
                                   <td><?php echo $rows_petition->petition_enquiry_no; ?></td>
                                   <td><?php echo $rows_petition->status; ?></td>
                                   <td><?php echo $rows_petition->updated_at; ?></td>
                                   <td><?php echo $rows_petition->id; ?></td>
                                   </tr>
                             <?php $i++; } ?>
                             </tbody>
                          </table>
                       </div>

                     </div>
                     <div class="tab-pane fade" id="enquiry_tab" role="tabpanel" aria-labelledby="enquiry-tab">
                       <div class="x_panel">
                          <table id="example_3" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                             <thead>
                                <tr>
                                  <th>S.no</th>
                                  <th>Full name</th>
                                  <th>paguthi</th>
                                  <th>seeker</th>
                                  <!-- <th>category</th> -->
                                  <th>sub category</th>
                                  <th>petition no</th>
                                  <th>status</th>
                                  <th>updated at</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                               <?php $i=1; foreach($res_enquiry as $rows_enquiry){ ?>
                                 <tr>
                                   <td><?php echo $i; ?></td>
                                   <td><?php echo $rows_enquiry->full_name; ?></td>
                                   <td><?php echo $rows_enquiry->paguthi_name; ?></td>
                                   <td><?php echo $rows_enquiry->seeker_info; ?></td>
                                   <!-- <td><?php echo $rows_enquiry->grievance_name; ?></td> -->
                                   <td><?php echo $rows_enquiry->sub_category_name; ?></td>
                                   <td><?php echo $rows_enquiry->petition_enquiry_no; ?></td>
                                   <td><?php echo $rows_enquiry->status; ?></td>
                                   <td><?php echo $rows_enquiry->updated_at; ?></td>
                                   <td><?php echo $rows_enquiry->id; ?></td>
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
      </div>
   </div>
</div>
<script>
$('#example_2').DataTable();
$('#example_3').DataTable();
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#list_constituent_menu').addClass('active');
   $('#master_form').validate({
        rules: {
            file_name:{required:true },
            doc_file:{required:true }
        },
        messages: {
          file_name:{required:"enter the file name" },
          doc_file:{required:"select file" }
            }
    });

    function delete_document(sel){
      var d_id=sel;
      $.ajax({
     url:'<?php echo base_url(); ?>constituent/delete_document',
     method:"POST",
     data:{d_id:d_id},
     cache: false,
     success:function(data)
     {
      if(data=="success"){
         location.reload(true);
        }else{

        }
     }
   });
    }
</script>
