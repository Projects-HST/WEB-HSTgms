<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_panel">
               <div class="x_title">
                  <h2><i class="fa fa-file-word-o"></i> document list</h2>

                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Constituent document</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Grievance document</a>
                     </li>

                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                       <div class="x_panel">
            <div class="x_title">
               <h2>Upload documents </h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <form id="master_form" action="<?php echo base_url(); ?>constituent/constituent_document_upload" method="post" enctype="multipart/form-data" novalidate="novalidate">
                 <div class="form-group row">
                    <label class="col-form-label col-md-2 col-sm-3 label-align">File name <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 ">
                       <input id="file_name" class=" form-control" name="file_name" type="text" value="">
                       <input id="constituent_id" class=" form-control" name="constituent_id" type="hidden" value="<?php echo $this->uri->segment(3); ?>">
                    </div>

                 </div>
                  <div class="form-group row">
                    <label class="col-form-label col-md-2 col-sm-3 label-align">File  <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 ">
                       <input id="doc_file" class=" form-control" name="doc_file" type="file" value="">
                    </div>
                  </div>
                  <div class="item form-group">
                     <div class="col-md-4 col-sm-6 offset-md-2">
                        <button type="submit" class="btn btn-success">Upload</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>

           <?php if($this->session->flashdata('msg')) {
             $message = $this->session->flashdata('msg');?>
             <div class="<?php echo $message['class'] ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?php echo $message['message']; ?>
            </div>
           <?php  }  ?>
              <div class="x_panel">
           <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                 <tr>
                    <th>S.no</th>
                    <th>File name</th>
                    <th>Download</th>
                    <th>updated at</th>

                    <th>Action</th>

                 </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($res as $rows){ ?>
                  <tr>
                      <td><?php echo $i; ?></td>
                     <td><?php echo $rows->doc_name; ?></td>
                     <td><a href="<?php echo base_url(); ?>assets/constituent/doc/<?php echo $rows->doc_file_name ;?>" target="_blank" class="badge-download">download here</a></td>
                     <td><?php echo date('d-m-Y', strtotime($rows->updated_at ));?></td>
                     <td><button class="babdge badge-danger" onclick="delete_document('<?php echo $rows->id; ?>')">Delete</button></td>


                  </tr>

             <?php  $i++; } ?>



              </tbody>
           </table>
 </div>


                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                       <div class="x_panel">
                    <table id="example_2" class="table table-striped table-bordered dt-responsive" style="width:100%">
                       <thead>
                          <tr>
                             <th>S.no</th>
                             <th>File name</th>
                             <th>Download</th>
                             <th>updated at</th>

                             <th>Action</th>

                          </tr>
                       </thead>
                       <tbody>
                         <?php $i=1; foreach($res_grievance as $rows_doc){ ?>
                           <tr>
                               <td><?php echo $i; ?></td>
                              <td><?php echo $rows_doc->doc_name; ?></td>
                              <td><a href="<?php echo base_url(); ?>assets/constituent/doc/<?php echo $rows_doc->doc_file_name ;?>" target="_blank" class="badge-download">download here</a></td>
                              <td><?php echo date('d-m-Y', strtotime($rows_doc->updated_at ));?></td>
                              <td><button class="babdge badge-danger" onclick="delete_document('<?php echo $rows_doc->id; ?>')">Delete</button></td>


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
      </div>
   </div>
</div>
<script>
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#list_constituent_menu').addClass('active');
$('#example_2').DataTable({
    "language": {
      "search": "",
      searchPlaceholder: "SEARCH HERE"
    }
});
$.validator.addMethod('filesize', function (value, element,param) {
  var size=element.files[0].size;
  size=size/1024;
  size=Math.round(size);
  return this.optional(element) || size <=param ;
}, 'File size must be less than 1 MB');
$('#master_form').validate({
     rules: {
         file_name:{required:true },
         doc_file:{required:true,extension:'jpe?g,png,doc,docx,pdf', filesize: 1000    }
     },
     messages: {
       file_name:{required:"enter the file name" },
       doc_file:{required:"select a file" }
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
