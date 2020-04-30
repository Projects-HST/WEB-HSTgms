<div class="right_col" role="main" style="min-height: 907px;">
   <div class="">
      <div class="page-title">
         <div class="title_left">
            <h3>User Profile</h3>
         </div>

      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
               <div class="x_title">
                  <h2>User Report <small>Activity report</small></h2>
<?php foreach($res as $rows){} ?>
                  <div class="clearfix"></div>
               </div>
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
                     <h4><?php echo $rows->full_name; ?></h4>
                     <ul class="list-unstyled user_data">
                       <li><i class="fa fa-map-marker user-profile-icon"></i><?php echo $rows->door_no; ?> &nbsp; <?php echo $rows->address; ?></li>
                       <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $rows->pin_code; ?></li>


                     </ul>
                     <a href="<?php echo base_url(); ?>constituent/get_constituent_member_edit/<?php echo base64_encode($rows->id*98765); ?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>


                  </div>
                  <div class="col-md-10 col-sm-9 ">

                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                           <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" class="" aria-selected="false">Profile</a></li>
                           <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" class="" aria-selected="false">Grievance details</a></li>
                           <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false" class="active" aria-selected="true">Meeting and plant</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                           <div role="tabpanel" class="tab-pane fade active show" id="tab_content1" aria-labelledby="home-tab">
                             <table class="data table table-striped no-margin">
                                  <thead>

                                  </thead>
                                  <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Party member </td>
                                        <td><?php if($rows->party_member_status=='Y'){ echo "Yes"; }else{ echo "NO"; } ?></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>vote type </td>
                                        <td><?php echo $rows->vote_type; ?></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>serial no </td>
                                        <td><?php echo $rows->serial_no; ?></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>status </td>
                                        <td><?php echo $rows->status; ?></td>
                                    </tr>
                                  <tr>
                                      <td>5</td>
                                      <td>constituency </td>
                                      <td><?php echo $rows->constituency_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>6</td>
                                      <td>paguthi </td>
                                      <td><?php echo $rows->paguthi_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>7</td>
                                      <td>ward </td>
                                      <td><?php echo $rows->ward_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>8</td>
                                      <td>booth </td>
                                      <td><?php echo $rows->booth_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>9</td>
                                      <td>booth address </td>
                                      <td><?php echo $rows->booth_address; ?></td>
                                  </tr>
                                  <tr>
                                      <td>10</td>
                                      <td>gender </td>
                                      <td><?php if($rows->gender=='M'){ echo "male"; }else{ echo "female"; }  ?></td>
                                  </tr>
                                  <tr>
                                      <td>11</td>
                                      <td>mobile no </td>
                                      <td><?php echo $rows->mobile_no; ?></td>
                                  </tr>
                                  <tr>
                                      <td>12</td>
                                      <td>whatsapp no </td>
                                      <td><?php echo $rows->whatsapp_no; ?></td>
                                  </tr>
                                  <tr>
                                      <td>13</td>
                                      <td>religion name </td>
                                      <td><?php echo $rows->religion_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>14</td>
                                      <td>voter id </td>
                                      <td><?php echo $rows->voter_id_no; ?></td>
                                  </tr>
                                  <tr>
                                      <td>15</td>
                                      <td>aadhaar no </td>
                                      <td><?php echo $rows->aadhaar_no; ?></td>
                                  </tr>
                                  <tr>
                                      <td>16</td>
                                      <td>email  </td>
                                      <td><?php echo $rows->email_id; ?></td>
                                  </tr>
                                  <tr>
                                      <td>17</td>
                                      <td>father or husband name  </td>
                                      <td><?php echo $rows->father_husband_name; ?></td>
                                  </tr>
                                  <tr>
                                      <td>18</td>
                                      <td>date of birth  </td>
                                      <td><?php echo $rows->dob; ?></td>
                                  </tr>


                                  </tbody>
                                  </table>
                           </div>
                           <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                             <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                   <tr>
                                      <th>S.no</th>
                                      <th>seeker</th>
                                      <!-- <th>category</th> -->
                                      <th>sub category</th>
                                      <th>petition no</th>
                                      <th>reference</th>
                                      <th>status</th>
                                      <th>updated at</th>

                                   </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach($res_grievance as $rows_grievance){ ?>
                                    <tr>
                                      <td><?php echo $i; ?></td>


                                      <td><?php echo $rows_grievance->seeker_info; ?></td>
                                      <!-- <td><?php echo $rows_grievance->grievance_name; ?></td> -->
                                      <td><?php echo $rows_grievance->sub_category_name; ?></td>
                                      <td><?php echo $rows_grievance->petition_enquiry_no; ?></td>
                                      <td><?php echo $status= $rows_grievance->reference_note; ?></td>
                                      <td><?php echo $status= $rows_grievance->status; ?></td>
                                      <td><?php echo $rows_grievance->updated_at; ?></td>

                                      </tr>
                                <?php $i++; } ?>

                                </tbody>
                             </table>
                           </div>
                           <div role="tabpanel" class="tab-pane fade active" id="tab_content3" aria-labelledby="meeting-tab">
                             <h4>Plant donation</h4>
                             <table id="example_3" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                                      <td><?php echo $rows_plant->updated_at; ?></td>

                                      </tr>
                                <?php $i++; } ?>

                                </tbody>
                             </table>
                             <h4>meeting request</h4>
                             <table id="example_2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                   <tr>
                                      <th>S.no</th>
                                      <th>Meeting details</th>
                                      <th>status</th>
                                      <th>updated at</th>

                                   </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach($res_meeting as $rows_meeting){ ?>
                                    <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $rows_meeting->meeting_detail; ?></td>
                                      <td><?php echo $rows_meeting->meeting_status; ?></td>
                                      <td><?php echo $rows_meeting->updated_at; ?></td>

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
$(document).ready(function() {
    $('#example_2').DataTable({

    });
    $('#example_3').DataTable({

    });
} );
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#list_constituent_menu').addClass('active');
</script>
