<link href="<?php echo base_url(); ?>assets/admin/vendors/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-ui/jquery-ui.js"></script>

<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <form class="form-horizontal form-label-left" id="master_form" action="<?php  echo base_url(); ?>constituent/create_constituent_member" method="post" enctype="multipart/form-data">
         <div class="x_panel">
            <div class="x_title">
               <h2>Constituency information</h2>
               <div class="clearfix"></div>
            </div>
            <?php if($this->session->flashdata('msg')) {
              $message = $this->session->flashdata('msg');?>
              <div class="<?php echo $message['class'] ?> alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
             </div>
            <?php  }  ?>
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
                     </div>
                     <label class="control-label col-md-2 col-sm-3 hide_part">Paguthi <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 hide_part">
                       <select class="form-control" name="paguthi_id" id="paguthi_id" onchange="get_paguthi(this);">
                         <option value="">SELECT</option>
                         <?php foreach($res_paguthi as $rows_paguthi){ ?>
                            <option value="<?php echo $rows_paguthi->id ?>"><?php echo $rows_paguthi->paguthi_name; ?></option>
                        <?php } ?>


                       </select>
                     </div>
                   </div>
                   <div class="form-group row hide_part">
                      <label class="control-label col-md-2 col-sm-3 ">Voter status</label>
                      <div class="col-md-4 col-sm-9 ">
                          <p>
                            <input type="radio" class="flat " name="voter_status" id="voter_status_y" value="VOTER" checked="" required="">  VOTER &nbsp;
                            <input type="radio" class="flat" name="voter_status" id="voter_status_n" value="NON-VOTER" > NON-VOTER

                         </p>
                      </div>
                      <label class="control-label col-md-2 col-sm-3 voter_section">Serial no</label>
                      <div class="col-md-4 col-sm-9 voter_section">
                        <input type="text" name="serial_no" id="serial_no" class="form-control">
                      </div>
                    </div>
                   <div class="form-group row ">
                     <label class="control-label col-md-2 col-sm-3 ">office <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-9 ">
                       <select class="form-control" name="office_id" id="office_id">
                         <option value="">SELECT</option>
                         <?php foreach($res_office as $rows_office){ ?>
                            <option value="<?php echo $rows_office->id ?>"><?php echo $rows_office->office_name; ?></option>
                        <?php } ?>
                       </select>
                     </div>
                      <label class="control-label col-md-2 col-sm-3 voter_section">ward <span class="required">*</span></label>
                      <div class="col-md-4 col-sm-9 voter_section">
                        <select class="form-control" name="ward_id" id="ward_id" onchange="get_booth(this);">
                          <option value=""></option>
                        </select>
                      </div>

                    </div>
                    <div class="form-group row voter_section">
                      <label class="control-label col-md-2 col-sm-3 ">booth </label>
                      <div class="col-md-4 col-sm-9 ">
                        <select class="form-control" name="booth_id" id="booth_id" onchange="get_booth_address(this);">
                          <option value="">Select</option>
                          <?php foreach($res_booth as $rows_booth){ ?>
                            <option value="<?php echo $rows_booth->id; ?>"><?php echo $rows_booth->booth_name; ?></option>
                        <?php  } ?>


                        </select>
                      </div>
                       <label class="control-label col-md-2 col-sm-3 ">booth address </label>
                       <div class="col-md-4 col-sm-9 ">
                        <textarea class="form-control" name="booth_address" id="booth_address" readonly></textarea>
                       </div>

                     </div>

                     <div class="form-group row hide_part">
                        <label class="control-label col-md-2 col-sm-3 ">Volunteer</label>
                        <div class="col-md-4 col-sm-9 ">
                          <select class="form-control" name="vote_type" id="vote_type">
                            <option value="NO">NO</option>
                            <option value="YES">YES</option>

                          </select>
                        </div>
                        <label class="control-label col-md-2 col-sm-3 ">Party member</label>
                        <div class="col-md-4 col-sm-9 ">
                           <p>
                              <input type="radio" class="flat" name="party_member_status" id="party_member_y" value="Y" > YES &nbsp;
                             <input type="radio" class="flat" name="party_member_status" id="party_member_n" value="N" checked="" required=""> NO

                          </p>

                        </div>


                      </div>

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
                       <input type="text" name="full_name" id="full_name" class="form-control">
                     </div>
                     <label class="control-label col-md-2 col-sm-3 ">Father or husband or Guardian name</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="father_husband_name" id="father_husband_name" class="form-control">
                     </div>
                  </div>
                    <div class="form-group row ">
                      <label class="control-label col-md-2 col-sm-3 ">DOB </label>
                      <div class="col-md-4 col-sm-9 ">
                        <input type="text" name="dob" id="datepicker" class="form-control" autocomplete="off" readonly='true'>
                      </div>
                      <label class="control-label col-md-2 col-sm-3 ">Religion</label>
                      <div class="col-md-4 col-sm-9 ">
                        <select class="form-control" name="religion_id" id="religion_id">
                          <option value="">SELECT</option>
                   <?php foreach($res_religion as $rows_religion){ ?>
                      <option value="<?php echo $rows_religion->id; ?>"><?php echo $rows_religion->religion_name; ?></option>
                   <?php  } ?>

                        </select>
                      </div>

                    </div>
                      <div class="form-group row ">
                        <label class="control-label col-md-2 col-sm-3 ">Gender</label>
                        <div class="col-md-4 col-sm-9 ">
                          <select class="form-control" name="gender" id="gender">
                            <option value="">SELECT</option>
                            <option value="M">MALE</option>
                            <option value="F">FEMALE</option>
                            <option value="T">TRANSGENDER</option>
                          </select>
                        </div>

                      <label class="control-label col-md-2 col-sm-3 ">Door no </label>
                      <div class="col-md-4 col-sm-9 ">
                        <input type="text" name="door_no" id="door_no" class="form-control">
                      </div>
                    </div>
                    <div class="form-group row ">

                       <label class="control-label col-md-2 col-sm-3 ">address </label>
                       <div class="col-md-4 col-sm-9 ">
                         <textarea name="address" id="address" class="form-control"></textarea>
                       </div>
                       <label class="control-label col-md-2 col-sm-3 ">pincode </label>
                       <div class="col-md-4 col-sm-9 ">
                         <input type="text" name="pin_code" id="pin_code" class="form-control">
                       </div>

                    </div>

                  <div class="form-group row ">
                     <label class="control-label col-md-2 col-sm-3 ">Mobile no </label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="mobile_no" id="mobile_no" class="form-control" onblur="checkTextField(this);">
                       <p id="copy_section"><input type="checkbox"  id="copy_value" style="margin-top:8px;"> &nbsp; <span>Same number for whatsapp</span></p>
                     </div>
                     <label class="control-label col-md-2 col-sm-3 ">Whatsapp no</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control" onkeyup="show_broadcast()">
                     </div>
                  </div>
                  <div class="form-group row ">
                     <!-- <label class="control-label col-md-2 col-sm-3 ">Gaurdian name</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="guardian_name" id="guardian_name" class="form-control">
                     </div> -->
                     <label class="control-label col-md-2 col-sm-3 ">EMAIL ID</label>
                     <div class="col-md-4 col-sm-9 ">
                       <input type="text" name="email_id" id="email_id" class="form-control">
                     </div>
                     <label class="control-label col-md-2 col-sm-3 broad_cast_section">Whatsapp Broadcast</label>
                     <div class="col-md-4 col-sm-9 broad_cast_section">
                       <p style="margin-top:8px;">
                       <input type="radio" class="flat" name="whatsapp_broadcast" id="whatsapp_broadcast_y" value="YES" >  YES &nbsp;
                       <input type="radio" class="flat" name="whatsapp_broadcast" id="whatsapp_broadcast_n" value="NO" checked="" required="">   NO

                      </p>
                     </div>
                  </div>

                    <div class="form-group row voter_section" id="">
                         <label class="control-label col-md-2 col-sm-3 ">has Voter id</label>
                       <div class="col-md-4 col-sm-9 ">
                          <p>
                          <input type="radio" class="flat" name="voter_id_status" id="voter_id_statu_y" value="Y" >  YES &nbsp;
                          <input type="radio" class="flat" name="voter_id_status" id="voter_id_status_n" value="N" checked="" required="">   NO

                         </p>
                       </div>
                        <label class="control-label col-md-2 col-sm-3 voter_id_box">Voter id no</label>
                       <div class="col-md-4 col-sm-9 voter_id_box">
                        <input type="text" name="voter_id_no" id="voter_id_no" class="form-control">
                       </div>
                     </div>
                     <div class="form-group row ">
                          <label class="control-label col-md-2 col-sm-3 ">Has Aadhaar  </label>
                        <div class="col-md-4 col-sm-9 ">
                           <p>
                             <input type="radio" class="flat" name="aadhaar_status" id="aadhaar_status_y" value="Y" > YES &nbsp;
                             <input type="radio" class="flat" name="aadhaar_status" id="aadhaar_status_n" value="N" checked="" required="">  NO

                          </p>
                        </div>
                         <label class="control-label col-md-2 col-sm-3 aadhaar_box">aadhaar no</label>
                        <div class="col-md-4 col-sm-9 aadhaar_box">
                         <input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control">
                        </div>
                      </div>
                      <div class="form-group row ">

                          <label class="control-label col-md-2 col-sm-3 ">Profile image</label>
                         <div class="col-md-4 col-sm-9 ">
                           <!-- <button class="" style="display:block;width:120px; height:30px;" onclick="document.getElementById('profile_pic').click()">SELECT A PHOTO</button> -->
                          <input type="file" name="profile_pic" id="profile_pic" title="SELECT A PHOTO" class="form-control">
                         </div>
                       </div>

                       <!-- <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-3 ">Show interaction information </label>
                          <div class="col-md-4 col-sm-9 ">
                             <p>
                               YES:
                               <input type="radio" class="flat" name="interaction_section" id="interaction_section_y" value="Y" > NO:
                               <input type="radio" class="flat" name="interaction_section" id="interaction_section_n" value="N" checked="" required="">
                            </p>
                          </div>

                        </div> -->
                      <br>  <hr><br>
                                      <div class="form-group">
                                         <div class="col-md-9 col-sm-9  offset-md-2">
                                            <button type="submit" class="btn btn-success">CREATE</button>
                                         </div>
                                      </div>
            </div>
         </div>

         <!-- <div class="x_panel" class="interaction_div">
            <div class="x_title interaction_div" >
               <h2>Interaction information</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group row interaction_div">
                <?php  foreach($res_interaction as $rows_question){ ?>
                  <label class="control-label col-md-2 col-sm-3 mb_20"><?php echo $rows_question->interaction_text; ?></label>
                  <div class="col-md-4 col-sm-9 mb_20">
                    <input type="hidden" name="question_id[]" value="<?php echo $rows_question->id; ?>">
                    <select class="form-control" name="question_response[]" id="">
                      <option value="Y">YES</option>
                      <option value="N">NO</option>
                    </select>
                  </div>
                <?php    } ?>


               </div>

            </div>
         </div> -->



         </form>
      </div>
   </div>
</div>
</div>
<style>
.mb_20{
  margin-bottom: 20px;
}
.voter_id_box{
  display: none;
}
.aadhaar_box{
  display: none;
}

</style>
<script type="text/javascript">

   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#create_constituent_menu').addClass('active');
   $('#copy_section').hide();
   $('.broad_cast_section').hide();
   // $('#copy_section').change(function() {
   //     $("#whatsapp_no").val($("#mobile_no").val());
   //  });

//    $(document).ready(function(){
//     var voter_status=$("input[type=radio][name='voter_status']:checked").val();
//
//     if(voter_status == 'VOTER'){
//       $('.voter_section').show();
//     }else{
//       $('.voter_section').hide();
//     }
// });




    $("#copy_value").click(function() {
           var checked = $(this).is(':checked');
           if (checked) {
               $("#whatsapp_no").val($("#mobile_no").val());
               $('#whatsapp_no').focus();
               $('.broad_cast_section').show();
           } else {
             $('#whatsapp_no').val(" ");
             $('.broad_cast_section').hide();
               // $("#whatsapp_no").val($("#mobile_no").val());
           }
       });
    function checkTextField(field) {
      if(field.value==''){
        $('#copy_section').hide();
      }
    }
    $("#mobile_no").keyup(function(){
        $('#copy_section').show();
    });

   // $('#dob').datetimepicker({
   //       format: 'DD-MM-YYYY',
   //       viewMode: 'years',
   //       defaultDate: "01/1/1986",
   //       minDate:"01/1/1986",
   //       maxDate:"01/1/1996"
   // });
   $( "#datepicker" ).datepicker({
    changeYear:true,
    maxDate: '0',
      defaultDate: "01-01-1996",
     dateFormat: 'dd-mm-yy',
    yearRange: '1900:' + new Date().getFullYear()
    });






function get_paguthi(sel){

  var paguthi_id=sel.value;
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
       // $("#office_id").empty();
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
         // if(res2.status=="success"){
         //   var res_office=res2.res_office;
         //   var len_off=res_office.length;
         //     $('#office_id').html('<option value="">SELECT office</option>');
         //       for (j = 0; j < len_off; j++) {
         //       $('<option>').val(res_office[j].id).text(res_office[j].office_name).appendTo('#office_id');
         //       }
         // }else{
         //   $("#office_id").empty();
         //   $("#booth_id").empty();
         //   $("#booth_address").empty();
         // }




		   }else{
		   $("#ward_id").empty();

        $("#booth_id").empty();
         $("#booth_address").empty();
		   }
		}
	});
}

// function get_office(sel){
//   var paguthi_id=sel.value;
//   $.ajax({
// 		url:'<?php echo base_url(); ?>masters/get_active_office',
// 		method:"POST",
// 		data:{paguthi_id:paguthi_id},
// 		dataType: "JSON",
// 		cache: false,
// 		success:function(data)
// 		{
// 		   var stat=data.status;
// 		   $("#ward_id").empty();
//        $("#office_id").empty();
//        $("#booth_id").empty();
//        $("#booth_address").empty();
// 		   if(stat=="success"){
// 		   var res=data.res;
// 		   var len=res.length;
//         $('#ward_id').html('<option value="">SELECT office</option>');
// 		   for (i = 0; i < len; i++) {
// 		   $('<option>').val(res[i].id).text(res[i].office_name).appendTo('#office_id');
// 		   }
//
// 		   }else{
// 		   $("#ward_id").empty();
//         $("#booth_id").empty();
//          $("#booth_address").empty();
//          $("#office_id").empty();
// 		   }
// 		}
// 	});
// }

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

$('input[name=voter_id_status]').click(function(){
  if(this.value == 'Y'){
    $('.voter_id_box').show();
  }else{
    $('.voter_id_box').hide();
  }
});

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


$('#booth_id').on('change', function() {
  var booth_id=this.value;
  $.ajax({
    url:'<?php echo base_url(); ?>masters/get_ward_paguthi_details',
    method:"POST",
    data:{booth_id:booth_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
       var stat=data.status;
       if(stat=="success"){
         $("#ward_id").empty();
         var res=data.res;
         $('#ward_id').html("<option value='"+res[0].ward_id+"'>"+res[0].ward_name+"</option>");
         $('#paguthi_id').val(res[0].paguthi_id);
       }else{
       $("#booth_address").empty();
       }
    }
  });
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
          gender:{required:true},
          office_id:{required:true },
          booth_id:{required:false },
          full_name:{required:true,maxlength:80 },
          father_husband_name:{required:false,maxlength:80 },
          guardian_name:{required:false,maxlength:80 },
          mobile_no:{required:false,number:true,minlength:10,maxlength:10 },
          whatsapp_no:{required:false,number:true,minlength:10,maxlength:10  },
          dob:{required:false,maxlength:10 },
          door_no:{required:false },
          address:{required:false,maxlength:240 },
          pin_code:{required:false,digits:true,maxlength:6,minlength:6 },
          email_id:{required:false ,email:true,maxlength:80},
          serial_no:{required:false,
            remote: {
                      url: "<?php echo base_url(); ?>constituent/checkserialno",
                      type: "post"
                   }
                  },
            voter_id_no:{required:false,maxlength:20,
              remote: {
                        url: "<?php echo base_url(); ?>constituent/checkvoter_id_no",
                        type: "post"
                     }
                },
            aadhaar_no:{required:false,maxlength:12,
              remote: {
                        url: "<?php echo base_url(); ?>constituent/checkaadhaar_no",
                        type: "post"
                     }
                   },
            profile_pic:{required:false,extension:'jpe?g,png', filesize: 1000000  }
        },
        messages: {
          paguthi_id:{required:"select paguthi" },
          ward_id:{required:"select ward" },
          office_id:{required:"select office" },
          booth_id:{required:"select booth" },
          gender:{required:"select the gender"},
          full_name:{required:"enter the full name" },
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
