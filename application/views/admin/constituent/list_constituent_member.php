<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <h2>List of constituent member</h2>
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
                     <th>full name</th>
                     <th>paguthi</th>
                     <th>mobile</th>
                     <th>voter id</th>
                     <th>aadhhar id</th>
                     <th>serial no</th>
                     <!-- <th>status</th> -->
                     <th>interaction</th>
                     <th>plant</th>
                     <th>Grievance</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $i=1; foreach($res as $rows){ ?>
                  <tr>
                     <td><?php echo $i; ?></td>
                     <td><?php echo $rows->full_name; ?></td>
                     <td><?php echo $rows->paguthi_name; ?></td>
                     <td><?php echo $rows->mobile_no ;?></td>
                     <td><?php echo $rows->voter_id_no ;?></td>
                     <td><?php echo $rows->aadhaar_no ;?></td>
                     <td><?php echo $rows->serial_no ;?></td>
                     <!-- <td><?php if($rows->status=='ACTIVE'){ ?>
                        <span class="badge badge-success">Active</span>
                        <?php  }else{ ?>
                        <span class="badge badge-danger">Inactive</span>
                        <?php   } ?>
                     </td> -->
                     <td><?php if($rows->interaction_status =='0'){ ?>
                       <a class="badge badge-warning" href="<?php echo base_url(); ?>constituent/add_interaction_response/<?php echo base64_encode($rows->id*98765); ?>" title="INTERACTION ADDED">ADD</i></a>
                        <?php }else{ ?>
                        <a href="<?php echo base_url(); ?>constituent/get_interaction_response_edit/<?php  echo base64_encode($rows->id*98765); ?>" title="VIEW " class="badge badge-success" >View</a>
                        <?php }?>
                     </td>
                     <td><?php if($rows->plant_status =='0'){ ?>
                        <a class="badge badge-warning handle_symbol" onclick="add_plant_donation('<?php echo $rows->id; ?>')" >ADD</i></a>
                        <?php }else{ ?>
                          <a  title="VIEW " class="badge badge-success handle_symbol" onclick="view_donation('<?php echo $rows->id; ?>')">View</a>

                        <?php }?>
                     </td>
                     <td><a href="" class="badge badge-warning" data-toggle="modal" data-target=".bs-example-modal-lg">Add grievance</a></td>
                     <td>
                       <a href="<?php echo base_url(); ?>constituent/get_constituent_member_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                        <a href="<?php echo base_url(); ?>constituent/get_list_document/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-file-word-o"></i></a>&nbsp;


                     </td>
                  </tr>
                  <?php  $i++; } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" id="plant_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Plant donation</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/plant_save" method="post" id="plant_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Plant name <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 ">
                    <input id="name_of_plant" class=" form-control" name="name_of_plant" type="text" value="">
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">No.of.Plant<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 ">
                    <input id="no_of_plant" class=" form-control" name="no_of_plant" type="text" value="">
                    <input id="constituent_id" class=" form-control" name="constituent_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Save</button>

                  </div>
               </div>
            </form>
         </div>

      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Grievance</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask">
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Mobile number </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Address </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Pincode </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">City </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Ward no. </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Booth no. </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Ward no. </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>
               <div class="col-md-6 col-sm-6  form-group has-feedback">
                  <label class="col-form-label col-md-3 col-sm-3 ">Booth no. </label>
                  <div class="col-md-9 col-sm-9 ">
                     <input type="text" class="form-control"  placeholder=" ">
                  </div>
               </div>



               <div class="col-md-6  col-sm-6  form-group has-feedback">
                  <div class="form-group row">
                     <label class="col-form-label col-md-3 col-sm-3 ">  &nbsp; &nbsp;Select</label>
                     <div class="col-md-9 col-sm-9 ">
                        <select class="form-control">
                           <option>Choose option</option>
                           <option>Option one</option>
                           <option>Option two</option>
                           <option>Option three</option>
                           <option>Option four</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-6  col-sm-6  form-group has-feedback">
                  <div class="form-group row">
                     <label class="col-form-label col-md-3 col-sm-3 ">  &nbsp; &nbsp;Select</label>
                     <div class="col-md-9 col-sm-9 ">
                        <select class="form-control">
                           <option>Choose option</option>
                           <option>Option one</option>
                           <option>Option two</option>
                           <option>Option three</option>
                           <option>Option four</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-6  col-sm-6  form-group has-feedback">
                  <div class="form-group row">
                     <label class="col-form-label col-md-3 col-sm-3 ">  &nbsp; &nbsp;Select</label>
                     <div class="col-md-9 col-sm-9 ">
                        <select class="form-control">
                           <option>Choose option</option>
                           <option>Option one</option>
                           <option>Option two</option>
                           <option>Option three</option>
                           <option>Option four</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Save</button>
                     <button class="btn btn-primary" type="reset">Reset</button>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
   </div>
</div>
<style>
   td{
   width:250px;
   }
</style>
<script type="text/javascript">
function add_plant_donation(sel){
  $('#plant_model').modal('show');
  $('#constituent_id').val(sel);

}

function view_donation(sel){
  var c_id=sel;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_plant_donation',
    method:"POST",
    data:{c_id:c_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      if(stat=="success"){
      $('#plant_model').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#name_of_plant').val(res[i].name_of_plant);
        $('#no_of_plant').val(res[i].no_of_plant);
        $('#constituent_id').val(res[i].constituent_id);
     }
      }else{
      $("#booth_address").empty();
      }
    }
  });
}
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#list_constituent_menu').addClass('active');
   $('#plant_form').validate({
        rules: {
              name_of_plant:{required:true ,maxlength:80},
              no_of_plant:{required:true,digits:true }
        },
        messages: {
          name_of_plant:{required:"enter the name of plant " },
          no_of_plant:{required:"enter the number" }
            }
    });

</script>
