<style>
th{
  width:250px;
}
.badge-reference{
  width:200px;
}
</style>
<div class="right_col" role="main" style="min-height: 907px;">
   <div class="">
      <div class="page-title">
         <div class="title_left">
            <h2>Constituent Profile</h2>
         </div>

      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
              <?php foreach($res as $rows){} ?>
               <!-- <div class="x_title">
                  <h2>User Report <small>Activity report</small></h2>
                  <div class="clearfix"></div>
               </div> -->
               <div class="x_content">
                  <div class="col-md-2 col-sm-3  profile_left">
                     <div class="profile_img">
                        <div id="crop-avatar">

                          <?php
                          if(empty($rows->profile_pic)){
                          $pic='default.png';
                          }else{
                            $pic=$rows->profile_pic;
                          }?>
                           <img class="img-responsive avatar-view" style="width:150px;" src="<?php echo base_url(); ?>assets/constituent/<?php echo $pic;  ?>" alt="Avatar" title="Change the avatar">
                        </div>
                     </div>
                     <h4 style="text-align:left;margin-top:15px;"><?php echo $rows->full_name; ?></h4>
                     <ul class="list-unstyled user_data">
                       <li style="  word-wrap: break-word;"><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $rows->door_no; ?> &nbsp; <?php echo $rows->address; ?></li>
                       <li><?php echo $rows->pin_code; ?></li>


                     </ul>
                     <a href="<?php echo base_url(); ?>constituent/get_constituent_member_edit/<?php echo base64_encode($rows->id*98765); ?>" class="btn btn-success" style="background-color:<?php echo $this->session->userdata('base_colour');?>;color:#000000 !important;border:1px solid <?php echo $this->session->userdata('base_colour');?>;">Edit Profile</a>


                  </div>
                  <div class="col-md-10 col-sm-9 ">
                    <div class="profile_heading">
                      <h4>Profile</h4>
                    </div>
                    <div class="col-md-12 profile_info" style="margin-bottom:25px;">
                      <div class="col-md-6">
                          <p class="label_profile">PARTY MEMBER : <span class="label_text"><?php if($rows->party_member_status=='Y'){ echo "Yes"; }else{ echo "NO"; } ?></span></p>
                          <p class="label_profile">Volunteer : <span class="label_text"><?php echo $rows->volunteer_status; ?></span></p>
                          <p class="label_profile">serial no: <span class="label_text"><?php echo $rows->serial_no; ?></span></p>
                          <p class="label_profile">status: <span class="label_text"><?php echo $rows->status; ?></span></p>
                          <p class="label_profile">constituency: <span class="label_text"><?php echo $rows->constituency_name; ?></span></p>
                          <p class="label_profile">paguthi: <span class="label_text"><?php echo $rows->paguthi_name; ?></span></p>
                          <p class="label_profile">ward: <span class="label_text"><?php echo $rows->ward_name; ?></span></p>
                          <p class="label_profile">booth: <span class="label_text"><?php echo $rows->booth_name; ?></span></p>
                          <p class="label_profile">booth address: <span class="label_text"><?php echo $rows->booth_address; ?></span></p>
                      </div>
                      <div class="col-md-6">
                        <p class="label_profile">GENDER: <span class="label_text"><?php if($rows->gender=='M'){ echo "male"; }else if($rows->gender=='M'){ echo "female";}else{ echo "others"; }  ?></span></p>
                        <p class="label_profile">Phone no: <span class="label_text"><?php echo $rows->mobile_no; ?></span></p>
                        <p class="label_profile">whatsapp no: <span class="label_text"><?php echo $rows->whatsapp_no; ?></span></p>
                        <p class="label_profile">email id: <span class="label_text"><?php echo $rows->email_id; ?></span></p>
                        <p class="label_profile">religion: <span class="label_text"><?php echo $rows->religion_name; ?></span></p>
                        <p class="label_profile">voter id: <span class="label_text"><?php echo $rows->voter_id_no; ?></span></p>
                        <p class="label_profile">aadhaar: <span class="label_text"><?php echo $rows->aadhaar_no; ?></span></p>
                        <p class="label_profile">father or husband: <span class="label_text"><?php echo $rows->father_husband_name; ?></span></p>
                        <p class="label_profile">date of birth: <span class="label_text"><?php echo date('d-m-Y', strtotime($rows->dob)); ?></span></p>
                    <br>  </div>
                    </div>

                  <div class="" role="tabpanel" data-example-id="togglable-tabs" style="margin-top:15px;">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                           <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" class="active" aria-selected="false">Grievance</a></li>
                           <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" class="" aria-selected="false">Meeting</a></li>
                           <!-- <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false" class="active" aria-selected="true">Meeting and plant</a></li> -->
                        </ul>
                        <div id="myTabContent" class="tab-content">
                           <div role="tabpanel" class="tab-pane fade active show" id="tab_content1" aria-labelledby="home-tab">
                             <!-- <h4>Plant donation</h4> -->
                             <!-- <table id="example_3" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                   <tr>
                                      <th>S.no</th>
                                      <th>Plant</th>
                                      <th>no of plant </th>
                                      <th>updated at</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach($res_plant as $rows_plant){ ?>
                                    <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $rows_plant->name_of_plant; ?></td>
                                      <td><?php echo $rows_plant->no_of_plant; ?></td>
                                      <td><?php echo date('d-m-Y H:i:s', strtotime($rows_plant->updated_at)); ?></td>
                                      </tr>
                                <?php $i++; } ?>

                                </tbody>
                             </table> -->
                             <table id="example_4" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                   <tr>
                                      <th style="width:50px;">S.no</th>
									  <th style="width:50px;">Category</th>
                                      <th>Seeker type</th>
                                      <th>Grievance type</th>
                                      <th style="width:200px;">Reference</th>
                                      <th style="width:50px;">Status</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach($res_grievance as $rows_grievance){ ?>
                                    <tr>
                                      <td><?php echo $i; ?></td>
									  <td><?php echo $rows_grievance->grievance_type; ?></td>
                                      <td><?php echo $rows_grievance->seeker_info; ?></td>
                                      <td><?php echo $rows_grievance->grievance_name; ?></td>
                                      <td ><?php echo $rows_grievance->reference_note; ?></td>
                                      <td class="badge-<?php echo $status= $rows_grievance->status; ?>"><?php echo $rows_grievance->status; ?></td>
								</tr>
                                <?php $i++; } ?>

                                </tbody>
                             </table>

                           </div>
                           <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
						   <h4>meeting request</h4>
                             <table id="example_2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                   <tr>
                                      <th>S.no</th>
                                      <th style="width:200px;">Meeting details</th>
                                      <th>Meeting date</th>
                                      <th>status</th>
                                      <th>created by</th>
                                      <th>requested On</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach($res_meeting as $rows_meeting){ ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $rows_meeting->meeting_detail; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($rows_meeting->meeting_date)); ?></td>
                                        <td class="badge-<?php echo $rows_meeting->meeting_status; ?>"><?php echo $rows_meeting->meeting_status; ?></td>
                                        <td><?php echo $rows_meeting->full_name; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($rows_meeting->created_at)); ?></td>
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
</div>
<script>


$(document).ready(function () {
    $('#example_2').DataTable({
      "scrollX": true,
        responsive: true,
        language: {
          "search": "",
          searchPlaceholder: "SEARCH "
        }
    });
    $('#example_4').DataTable({
      "scrollX": true,
        responsive: true,
        language: {
          "search": "",
          searchPlaceholder: "SEARCH "
        }
    });
    $('#example_3').DataTable({
      "scrollX": true,
        responsive: true,
        "language": {
          "search": "",
          searchPlaceholder: "SEARCH"
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust()
           .responsive.recalc();
    });
});
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#list_constituent_menu').addClass('active');
</script>
