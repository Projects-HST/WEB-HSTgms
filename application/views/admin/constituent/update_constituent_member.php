<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div  class="right_col" role="main" style="height:100vh;">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <form class="form-horizontal form-label-left" id="master_form" action="<?php  echo base_url(); ?>constituent/update_constituent_member" method="post" enctype="multipart/form-data">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Constituency information</h2>
               <div class="clearfix"></div>
            </div>
            <?php if($this->session->flashdata('msg')) {
              $message = $this->session->flashdata('msg');?>
              <div class="<?php echo $message['class'] ?> alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
             </div>
            <?php  }  ?>
            <?php foreach($res as $rows){}
              $paguthi_id=$rows->paguthi_id;
              $ward_id=$rows->ward_id;
              $office_id=$rows->office_id;
              $booth_id=$rows->booth_id;
              $constituency_id=$rows->constituency_id;

               ?>

            <div class="x_content">
                  <div class="form-group row ">
                     <label class="control-label col-md-2 col-sm-3 ">Constituency <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 ">
                       <select class="form-control" name="constituency_id" id="constituency_id">
                         <?php foreach($res_constituency as $rows_constituency){ ?>

                        <?php } ?>
                         <option value="<?php echo $rows_constituency->id ?>"><?php echo $rows_constituency->constituency_name; ?></option>
                         <option value="0">OTHERS</option>
                       </select>
                       <script>$('#constituency_id').val('<?php echo $rows->constituency_id; ?>');</script>
                     </div>
                     <label class="control-label col-md-2 col-sm-3 hide_part">Paguthi <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 hide_part">
                       <select class="form-control" name="paguthi_id" id="paguthi_id" onchange="get_paguthi();">
                         <?php foreach($res_paguthi as $rows_paguthi){ ?>
                            <option value="<?php echo $rows_paguthi->id ?>"><?php echo $rows_paguthi->paguthi_name; ?></option>
                        <?php } ?>


                       </select>
                       <script>$('#paguthi_id').val('<?php echo $paguthi_id; ?>');</script>
                     </div>
                   </div>
                   <div class="form-group row hide_part">
                     <label class="control-label col-md-2 col-sm-3 ">Voter status</label>
                     <div class="col-md-4 col-sm-9 ">
                         <p>
                           <input type="radio" class="flat" name="voter_status" id="voter_status_y" value="VOTER"  <?php echo ($rows->voter_status=='VOTER') ? 'checked="checked"':'';?>> VOTER &nbsp;
                             <input type="radio" class="flat" name="voter_status" id="voter_status_n" value="NON-VOTER" <?php echo ($rows->voter_status=='NON-VOTER') ? 'checked="checked"':'';?>> NON-VOTER

                        </p>
                     </div>
                     <label class="control-label col-md-2 col-sm-3 voter_section">Serial no</label>
                     <div class="col-md-4 col-sm-9 voter_section">
                       <input type="text" name="serial_no" id="serial_no" class="form-control" value="<?php echo $rows->serial_no; ?>">
                     </div>
                   </div>
                   <div class="clearfix"></div>

                   <div class="form-group row voter_section">
                     <label class="control-label col-md-2 col-sm-3 ">office <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 ">
                       <select class="form-control" name="office_id" id="office_id">
                         <?php $query="SELECT * FROM office WHERE status='ACTIVE' and paguthi_id='$paguthi_id' order by id desc";
                         $result=$this->db->query($query);
                         if($result->num_rows()==0){ ?>
                         <option value=""></option>
                         <?php 	}else{
                         $res_office=$result->result();
                         foreach($res_office as $rows_office){ ?>
                           <option value="<?php echo $rows_office->id; ?>"><?php echo $rows_office->office_name; ?></option>
                         <?php   }		}    ?>
                       </select>
                        <script>$('#office_id').val('<?php echo $office_id; ?>');</script>
                     </div>

                      <label class="control-label col-md-2 col-sm-3 ">ward <span class="required">*</span></label>
                      <div class="col-md-4 col-sm-9 ">
                          <select class="form-control" name="ward_id" id="ward_id" onchange="get_booth(this);">
                            <?php $query="SELECT * FROM ward WHERE status='ACTIVE' and paguthi_id='$paguthi_id' order by id desc";
                            $result=$this->db->query($query);
                            if($result->num_rows()==0){ ?>
                            <option value=""></option>
                            <?php 	}else{
                            $res_ward=$result->result();
                            foreach($res_ward as $rows_ward){ ?>
                              <option value="<?php echo $rows_ward->id; ?>"><?php echo $rows_ward->ward_name; ?></option>
                            <?php   }		}    ?>
                        </select>
                        <script>$('#ward_id').val('<?php echo $ward_id; ?>');</script>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group row voter_section">
                      <label class="control-label col-md-2 col-sm-3 ">booth <span class="required">*</span></label>
                      <div class="col-md-4 col-sm-9 ">
                        <select class="form-control" name="booth_id" id="booth_id" onchange="get_booth_address(this);">

                          <?php $query_b="SELECT * FROM booth where ward_id='$ward_id' and status='ACTIVE' order by id desc";
                          $resultb=$this->db->query($query_b);
                          if($resultb->num_rows()==0){ ?>
                          <option value=""></option>
                          <?php 	}else{
                          $res_booth=$resultb->result();
                          foreach($res_booth as $rows_booth){ ?>
                            <option value="<?php echo $rows_booth->id; ?>"><?php echo $rows_booth->booth_name; ?></option>
                          <?php   }		}    ?>

                        </select>
                        <script>$('#booth_id').val('<?php echo $booth_id; ?>');</script>
                      </div>
                       <label class="control-label col-md-2 col-sm-3 ">booth address <span class="required">*</span></label>
                       <div class="col-md-4 col-sm-9 ">
                         <?php $query_b="SELECT * FROM booth where id='$booth_id' and status='ACTIVE' order by id desc";
                         $resultb=$this->db->query($query_b);
                         if($resultb->num_rows()==0){ ?>
                        <textarea class="form-control" name="booth_address" id="booth_address" readonly></textarea>
                         <?php 	}else{
                         $res_booth=$resultb->result();
                         foreach($res_booth as $rows_booth){ ?>
                           <textarea class="form-control" name="booth_address" id="booth_address" readonly><?php echo $rows_booth->booth_address; ?></textarea>
                         <?php   }		}    ?>


                       </div>

                     </div>
                     <div class="clearfix"></div>

                     <div class="form-group row hide_part">
                        <label class="control-label col-md-2 col-sm-3 ">Volunteer</label>
                        <div class="col-md-4 col-sm-9 ">
                          <select class="form-control" name="vote_type" id="vote_type">
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                          </select>
                          <script>$('#vote_type').val('<?php echo $rows->volunteer_status; ?>');</script>
                        </div>
                        <label class="control-label col-md-2 col-sm-3 ">Party member</label>
                        <div class="col-md-4 col-sm-9 ">
                           <p>
                            <input type="radio" class="flat" name="party_member_status" id="party_member_y" value="Y" <?php echo ($rows->party_member_status=='Y') ? 'checked="checked"':'';?>> YES &nbsp;
                                <input type="radio" class="flat" name="party_member_status" id="party_member_n" value="N" <?php echo ($rows->party_member_status=='N') ? 'checked="checked"':'';?>>NO

                          </p>

                        </div>
                      </div>
                      <div class="clearfix"></div>
            </div>
         </div>

         <div class="x_panel">
            <div class="x_title">
               <h2>personal information</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="form-group row ">
                     <label class="control-label col-md-2 col-sm-3 ">FULL name <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $rows->full_name; ?>">
                     </div>
                     <label class="control-label col-md-2 col-sm-3 ">Father or husband or Guardian name</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="father_husband_name" id="father_husband_name" class="form-control" value="<?php echo $rows->father_husband_name; ?>">
                     </div>
                  </div>
                    <div class="form-group row ">
                      <label class="control-label col-md-2 col-sm-3 ">DOB </label>
                      <div class="col-md-4 col-sm-9 ">
                        <?php if($rows->dob=='0000-00-00'){
                          $dob='';
                        }else{
                          $dob=date("d-m-Y", strtotime($rows->dob));
                        } ?>
                        <input type="text" name="dob" id="datepicker" class="form-control" value="<?php echo $dob; ?>" autocomplete="off" readonly='true'>
                      </div>
                      <label class="control-label col-md-2 col-sm-3 ">Religion</label>
                      <div class="col-md-4 col-sm-9 ">
                        <select class="form-control" name="religion_id" id="religion_id">

                   <?php foreach($res_religion as $rows_religion){ ?>
                      <option value="<?php echo $rows_religion->id; ?>"><?php echo $rows_religion->religion_name; ?></option>
                 <?php  } ?>

                        </select>
                        <script>$('#religion_id').val('<?php echo $rows->religion_id; ?>');</script>
                      </div>

                    </div>
                      <div class="form-group row">
                        <label class="control-label col-md-2 col-sm-3 ">Gender</label>
                        <div class="col-md-4 col-sm-9 ">
                          <select class="form-control" name="gender" id="gender">
                            <option value="">SELECT</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="T">Transgender</option>
                          </select>
                            <script>$('#gender').val('<?php echo $rows->gender; ?>');</script>
                           </div>
                           <label class="control-label col-md-2 col-sm-3 ">Door no </label>
                           <div class="col-md-4 col-sm-9 ">
                             <input type="text" name="door_no" id="door_no" class="form-control" value="<?php echo $rows->door_no; ?>">
                             <input type="hidden" name="constituent_id" id="constituent_id" class="form-control" value="<?php echo base64_encode($rows->id*98765); ?>">
                           </div>

                      </div>
                      <div class="form-group row ">

                         <label class="control-label col-md-2 col-sm-3 ">address </label>
                         <div class="col-md-4 col-sm-9 ">
                           <textarea name="address" id="address" class="form-control"><?php echo $rows->address; ?></textarea>
                         </div>
                         <label class="control-label col-md-2 col-sm-3 ">pincode </label>
                         <div class="col-md-4 col-sm-9 ">
                           <input type="text" name="pin_code" id="pin_code" class="form-control" value="<?php echo $rows->pin_code; ?>">
                         </div>

                      </div>
                      <div class="form-group row ">
                         <label class="control-label col-md-2 col-sm-3 ">Mobile no </label>
                         <div class="col-md-4 col-sm-9 ">
                           <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="<?php echo $rows->mobile_no; ?>">
                         </div>
                         <label class="control-label col-md-2 col-sm-3 ">Whatsapp no</label>
                         <div class="col-md-4 col-sm-9 ">
                           <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control" value="<?php echo $rows->whatsapp_no; ?>">
                         </div>
                      </div>
                  <div class="form-group row ">
                     <!-- <label class="control-label col-md-2 col-sm-3 ">Gaurdian name</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="guardian_name" id="guardian_name" class="form-control" value="<?php echo $rows->guardian_name; ?>">
                     </div> -->
                     <label class="control-label col-md-2 col-sm-3 ">EMAIL ID</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="email_id" id="email_id" class="form-control" value="<?php echo $rows->email_id; ?>">
                     </div>
                     <label class="control-label col-md-2 col-sm-3 broad_cast_section">Whatsapp Broadcast</label>
                     <div class="col-md-4 col-sm-9 broad_cast_section">
                       <p style="margin-top:8px;">
                       <input type="radio" class="flat" name="whatsapp_broadcast" id="whatsapp_broadcast_y" value="YES" <?php echo ($rows->whatsapp_broadcast=='YES') ? 'checked="checked"':'';?>>  YES &nbsp;
                       <input type="radio" class="flat" name="whatsapp_broadcast" id="whatsapp_broadcast_n" value="NO" <?php echo ($rows->whatsapp_broadcast=='NO') ? 'checked="checked"':'';?>>   NO

                      </p>
                     </div>
                  </div>


                   <div class="clearfix"></div>
                    <div class="form-group row voter_section">
                         <label class="control-label col-md-2 col-sm-3 ">Voter id status</label>
                       <div class="col-md-4 col-sm-9 ">
                          <p>
                          <input type="radio" class="flat" name="voter_id_status" id="voter_id_statu_y" value="Y" <?php echo ($rows->voter_id_status=='Y') ? 'checked="checked"':'';?>>  YES &nbsp;
                            <input type="radio" class="flat" name="voter_id_status" id="voter_id_status_n" value="N" <?php echo ($rows->voter_id_status=='N') ? 'checked="checked"':'';?>> NO

                         </p>
                       </div>
                        <label class="control-label col-md-2 col-sm-3 voter_id_box">Voter id no</label>
                       <div class="col-md-4 col-sm-9 voter_id_box">
                        <input type="text" name="voter_id_no" id="voter_id_no" class="form-control" value="<?php echo $rows->voter_id_no; ?>">
                       </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="form-group row ">
                          <label class="control-label col-md-2 col-sm-3 ">aadhaar status </label>
                        <div class="col-md-4 col-sm-9 ">
                           <p>
                            <input type="radio" class="flat" name="aadhaar_status" id="aadhaar_status_y" value="Y" <?php echo ($rows->aadhaar_status=='Y') ? 'checked="checked"':'';?>> YES &nbsp;
                            <input type="radio" class="flat" name="aadhaar_status" id="aadhaar_status_n" value="N" <?php echo ($rows->aadhaar_status=='N') ? 'checked="checked"':'';?>>  NO

                          </p>
                        </div>

                        <label class="control-label col-md-2 col-sm-3 aadhaar_box">aadhaar no</label>
                       <div class="col-md-4 col-sm-9 aadhaar_box">
                        <input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control" value="<?php echo $rows->aadhaar_no; ?>">
                       </div>

                      </div>
                      <div class="form-group row ">

                          <label class="control-label col-md-2 col-sm-3 ">Profile image</label>
                         <div class="col-md-4 col-sm-9 ">
                           <!-- <button class="" style="display:block;width:130px; height:30px;" onclick="document.getElementById('profile_pic').click()">SELECT A PHOTO</button> -->
                          <input type="file" name="profile_pic" id="profile_pic" title="SELECT A PHOTO" class="form-control">
                            <input type="hidden" name="old_profile_pic" id="old_profile_pic" class="form-control" value="<?php echo $rows->profile_pic; ?>">
                         </div>
                         <?php  if(empty($rows->profile_pic)){

                         }else{ ?>
                           <label class="control-label col-md-2 col-sm-3 ">current image</label>
                          <div class="col-md-4 col-sm-9 ">
                           <img src="<?php echo base_url(); ?>assets/constituent/<?php echo $rows->profile_pic; ?>" style="width:150px;">
                          </div>
                         <?php } ?>

                       </div>
                       <div class="form-group row ">

                          <label class="control-label col-md-2 col-sm-3 ">status</label>
                          <div class="col-md-4 col-sm-9 ">
                            <select class="form-control" name="status" id="status">
                              <option value="ACTIVE">ACTIVE</option>
                              <option value="INACTIVE">INACTIVE</option>
                            </select>
                            <script>$('#status').val('<?php echo $rows->status; ?>');</script>
                             </div>

                        </div>
                          <br>  <hr><br>
                        <div class="x_content">
                            <div class="form-group">
                             <div class="col-md-9 col-sm-9  offset-md-2">
                                <button type="submit" class="btn btn-success">Update</button>
                             </div>
                          </div>
                        </div>


            </div>
         </div>

         <!-- <div class="x_panel" class="interaction_div">


         </div> -->



         </form>
      </div>
   </div>
</div>
<style>

.mb_20{
  margin-bottom: 20px;
}
</style>
<?php if($rows->aadhaar_status=='N'){ ?>
<style>
.aadhaar_box{
  display: none;
}
</style>
<?php } ?>
<?php if($rows->voter_id_status=='N'){ ?>
<style>
.voter_id_box{
  display: none;
}
</style>
<?php }
if($rows->constituency_id=='0'){
  echo "<style>.voter_section{display:none;}.hide_part{display:none;}</style>";
}else{

}
if($rows->voter_status=='NON-VOTER'){
  echo "<style>.voter_section{display:none;}</style>";
}else{

}

?>

<script type="text/javascript">
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#create_constituent_menu').addClass('active');
   // $('#dob').datetimepicker({
   //       format: 'DD-MM-YYYY',
   //       viewMode: 'years',
   //       minDate:"01/1/1986"
   //       // maxDate:"01/1/1996"
   // });
   $( "#datepicker" ).datepicker({
      changeYear:true,
      maxDate: '0',
      defaultDate: "01-01-1996",
      dateFormat: 'dd-mm-yy',
      yearRange: '1900:' + new Date().getFullYear()
    });


function get_paguthi(){
      var paguthi_id=$('#paguthi_id').val();

  //   $.ajax({
	// 	url:'<?php echo base_url(); ?>masters/get_active_ward',
	// 	method:"POST",
	// 	data:{paguthi_id:paguthi_id},
	// 	dataType: "JSON",
	// 	cache: false,
	// 	success:function(data)
	// 	{
	// 	   var stat=data.status;
	// 	   $("#ward_id").empty();
	// 	   if(stat=="success"){
	// 	   var res=data.res;
	// 	   var len=res.length;
  //       $('#ward_id').html('<option value="">SELECT ward</option>');
	// 	   for (i = 0; i < len; i++) {
	// 	   $('<option>').val(res[i].id).text(res[i].ward_name).appendTo('#ward_id');
	// 	   }
  //
	// 	   }else{
	// 	   $("#ward_id").empty();
  //       $("#booth_id").empty();
  //        $("#booth_address").empty();
	// 	   }
	// 	}
	// });
  // var paguthi_id=sel.value;
  $.ajax({
    url:'<?php echo base_url(); ?>masters/get_active_ward_office',
    method:"POST",
    data:{paguthi_id:paguthi_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
       var stat=data.status;
       $("#ward_id").empty();
       $("#office_id").empty();
       $("#booth_id").empty();
       $("#booth_address").empty();
       if(stat=="success"){
         var res1=data.result_ward;
         var res2=data.result_office;
         if(res1.status=="success"){
           var res=res1.res_ward;
           var len=res.length;
             $('#ward_id').html('<option value="">SELECT ward</option>');
               for (i = 0; i < len; i++) {
               $('<option>').val(res[i].id).text(res[i].ward_name).appendTo('#ward_id');
               }
         }else{
           $("#ward_id").empty();
           $("#booth_id").empty();
           $("#booth_address").empty();
         }
         if(res2.status=="success"){
           var res_office=res2.res_office;
           var len_off=res_office.length;
             $('#office_id').html('<option value="">SELECT office</option>');
               for (j = 0; j < len_off; j++) {
               $('<option>').val(res_office[j].id).text(res_office[j].office_name).appendTo('#office_id');
               }
         }else{
           $("#office_id").empty();
           $("#booth_id").empty();
           $("#booth_address").empty();
         }




       }else{
       $("#ward_id").empty();

        $("#booth_id").empty();
         $("#booth_address").empty();
       }
    }
  });
}

function get_booth(sel){
  var ward_id=sel.value;
  $.ajax({
		url:'<?php echo base_url(); ?>masters/get_active_booth',
		method:"POST",
		data:{ward_id:ward_id},
		dataType: "JSON",
		cache: false,
		success:function(data)
		{
		   var stat=data.status;
		   $("#booth_id").empty();
		   if(stat=="success"){

		   var res=data.res;
		   var len=res.length;
       $('#booth_id').html('<option value="">SELECT BOOTH</option>');
		   for (i = 0; i < len; i++) {
		   $('<option>').val(res[i].id).text(res[i].booth_name).appendTo('#booth_id');
		   }

		   }else{
		   $("#booth_id").empty();
        $("#booth_address").empty();
		   }
		}
	});
}

function get_booth_address(sel){
  var booth_id=sel.value;
  $.ajax({
    url:'<?php echo base_url(); ?>masters/get_booth_address',
    method:"POST",
    data:{booth_id:booth_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
       var stat=data.status;
       $("#booth_address").empty();
       if(stat=="success"){
       var res=data.res;
       var len=res.length;
       for (i = 0; i < len; i++) {
        $('#booth_address').text(res[i].booth_address);
      }
       }else{
       $("#booth_address").empty();
       }
    }
  });
}
$('input[name=voter_status]').click(function(){
  if(this.value == 'VOTER'){
    $('.voter_section').show();
  }else{
    $('.voter_section').hide();
  }
});
$('#constituency_id').on('change', function() {
  var constituency_id=this.value;
  if(constituency_id=='0'){
    $('.voter_section').hide();
    $('.hide_part').hide();
  }else{
    $('.voter_section').show();
    $('.hide_part').show();
  }
});
$('input[name=voter_id_status]').click(function(){
  if(this.value == 'Y'){
    $('.voter_id_box').show();
  }else{
    $('.voter_id_box').hide();
  }
});
$('input[name=aadhaar_status]').click(function(){
  if(this.value == 'Y'){
    $('.aadhaar_box').show();
  }else{
    $('.aadhaar_box').hide();
  }
});
  $('.interaction_div').hide();
$('input[name=interaction_section]').click(function(){
  if(this.value == 'Y'){
    $('.interaction_div').show();
  }else{
    $('.interaction_div').hide();
  }
});
$.validator.addMethod('filesize', function(value, element, arg) {
  return this.optional(element) || element.files[0].size <= arg;
  });

   $('#master_form').validate({
        rules: {
          paguthi_id:{required:true },
          ward_id:{required:true },
          booth_id:{required:false },
          full_name:{required:true,maxlength:80 },
          father_husband_name:{required:false,maxlength:80 },
          guardian_name:{required:false,maxlength:80 },
          mobile_no:{required:false,minlength:10,maxlength:10 },
          whatsapp_no:{required:false,minlength:10,maxlength:10  },
          dob:{required:false,maxlength:10 },
          door_no:{required:false },
          address:{required:false,maxlength:240 },
          pin_code:{required:false,digits:true,maxlength:6,minlength:6 },
          email_id:{required:false ,email:true,maxlength:80},
          serial_no:{required:false,
            remote: {
                      url: "<?php echo base_url(); ?>constituent/checkserialnoexist/<?php echo $rows->id; ?>",
                      type: "post"
                   }
                  },
            voter_id_no:{required:false,maxlength:20,
              remote: {
                        url: "<?php echo base_url(); ?>constituent/checkvoter_id_noexist/<?php echo $rows->id; ?>",
                        type: "post"
                     }
                },
            aadhaar_no:{required:false,maxlength:12,
              remote: {
                        url: "<?php echo base_url(); ?>constituent/checkaadhaar_noexist/<?php echo $rows->id; ?>",
                        type: "post"
                     }
                    },
            profile_pic:{required:false,extension:'jpe?g,png', filesize: 1000000 }
        },
        messages: {
          paguthi_id:{required:"select paguthi" },
          ward_id:{required:"select ward" },
          booth_id:{required:"select booth" },
          full_name:{required:"enter full name" },
          father_husband_name:{required:"Enter father or husband name" },
          mobile_no:{minlength:"Phone no should be 10 digits",maxlength:"Phone no should be 10 digits" },
          whatsapp_no:{minlength:"whatsapp no should be 10 digits",maxlength:"whatsapp no should be 10 digits" },
          dob:{required:"select date of birth" },
          door_no:{required:"enter door no" },
          address:{required:"enter address" },
          pin_code:{required:"enter pincode" },
          email_id:{required:"enter email id" },
          serial_no:{required:"enter serial no",remote:"serial no already exist" },
          voter_id_no:{required:"enter voter id"},
            voter_id_no: { required:"enter the voter id",remote:"voter id no  already exist"},
            aadhaar_no: { required:"enter the aadhaar no",remote:"aadhaar no  already exist"},
            profile_pic:{required:"select profile image",filesize:"File size must less than 1 mb" },
            }
    });

</script>
