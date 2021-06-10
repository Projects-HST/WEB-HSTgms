<style type="text/css">
th{
  width:50px;
  }</style>
  <div class="right_col" role="main">
    <div class="">
	<div class="clearfix"></div>
	<div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Category Based Report</h2>
                    <a href="<?php echo base_url(); ?>report/get_category_report_export" class="btn btn-export pull-right">Export</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="report_form" action="<?php echo base_url(); ?>report/category" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 col-sm-1">From</label>
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="form-control" placeholder="From Date" id="frmDate" name="g_frmDate" value="<?php echo $g_frmDate; ?>" />
                            </div>
                            <label class="col-form-label col-md-2 col-sm-2">To</label>
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="form-control" placeholder="To Date" id="toDate" name="g_toDate" value="<?php echo $g_toDate; ?>" />
                            </div>
                            <label class="control-label col-md-1 col-sm-3"> Seeker<span class="required">*</span></label>
                            <div class="col-md-3 col-sm-9">
                                <select class="form-control" name="g_seeker" id="g_seeker" onchange="get_category(this)">
                                    <option value="">ALL</option>
                                    <?php foreach($seeker as $rows){ ?>
                                    <option value="<?php echo $rows->id;?>"><?php echo $rows->seeker_info;?></option>
                                    <?php } ?>
                                </select>
                                <script>
                                    $("#g_seeker").val("<?php echo $g_seeker; ?>");
                                </script>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-3"> Category<span class="required">*</span></label>
                            <div class="col-md-2 col-sm-9">
                                <select class="form-control" name="g_category" id="category" onchange="get_sub_category(this)">
                                    <option value="">ALL</option>
                                   <?php
                                    $query_gr="SELECT * FROM grievance_type WHERE status='ACTIVE' and seeker_id='$g_seeker' order by id desc";
                                    $result_gr=$this->app_db->query($query_gr);
                                    if($result_gr->num_rows()==0){ 	}else{
                                    $res_gr=$result_gr->result();
                                    foreach($res_gr as $rows_gr){ ?>
                                      <option value="<?php echo $rows_gr->id; ?>"><?php echo $rows_gr->grievance_name; ?></option>
                                    <?php   }		}    ?>
                                </select>
                                <script>
                                    $("#category").val("<?php echo $g_category; ?>");
                                </script>
                            </div>
                            <label class="control-label col-md-2 col-sm-3">Sub Category</label>
                            <div class="col-md-2 col-sm-9">
                                <select class="form-control" id="sub_category_id" name="g_sub_category_id">
                                    <option value="">ALL</option>
                                    <?php
                                     $query_sb="SELECT * FROM grievance_sub_category WHERE status='ACTIVE' and grievance_id='$g_category' order by id desc";
                                     $result_sb=$this->app_db->query($query_sb);
                                     if($result_sb->num_rows()==0){ 	}else{
                                     $res_sb=$result_sb->result();
                                     foreach($res_sb as $rows_sb){ ?>
                                       <option value="<?php echo $rows_sb->id; ?>"><?php echo $rows_sb->sub_category_name; ?></option>
                                     <?php   }		}    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-3">paguthi<span class="required">*</span></label>
                            <div class="col-md-2 col-sm-9">
                                <select class="form-control" name="g_paguthi" id="paguthi" onchange="get_paguthi(this);">
                                    <option value="">ALL</option>
                                    <?php foreach($paguthi as $rows){ ?>
                                    <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
                                    <?php } ?>
                                </select>
                                <script>
                                    $("#paguthi").val("<?php echo $g_paguthi; ?>");
                                </script>
                            </div>
                            <label class="col-form-label col-md-2 col-sm-3">office</label>
                            <div class="col-md-2 col-sm-2">
                                <select class="form-control" name="g_ward_id" id="office_id">
                                  <option value="">ALL</option>
                                  <?php foreach($res_office as $rows_office){ ?>
                                     <option value="<?php echo $rows_office->id ?>"><?php echo $rows_office->office_name; ?></option>
                                 <?php } ?>
                                </select>
                                <script>
                                    $("#office_id").val("<?php echo $g_ward_id; ?>");
                                </script>
                            </div>
                            <div class="col-md-3 col-sm-2">
                                <input type="submit" name="submit" class="btn btn-success" value="SEARCH" />
                                <a href="<?php echo base_url(); ?>report/reset_search" class="btn btn-danger">CLEAR</a>

                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </form>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="col-md-12 col-sm-12" style="padding: 0px;">
                        <div class="col-md-3 col-sm-3">
                            <p style="margin-top:20px;">Total records : <?php echo $allcount; ?></p>
                        </div>
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6" style="padding: 0px;"><?= $pagination; ?></div>
                    </div>
                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                              <th>S.no</th>
                              <th>Name</th>
                              <th>Father name</th>
                              <th>Dob</th>
                              <th>Address</th>
                              <th>Phone no</th>
                              <th>GrievanceType</th>
                              <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = $row+1; foreach($result as $rows){ ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $rows['full_name']; ?></td>
                                <td><?php echo $rows['father_husband_name']; ?></td>
                                <td><?php if($rows['dob']=='0000-00-00'){ echo""; }else{echo date('d-m-Y', strtotime($rows['dob'])); } ?></td>
                                <td><?php echo $rows['door_no']; ?><br><?php echo $rows['address']; ?><br><?php echo $rows['pin_code']; ?></td>
                                <td><?php echo $rows['mobile_no']; ?></td>
                                <td><?php echo $rows['grievance_name']; ?></td>
                                <td class="badge-<?= $rows['status'] ?>"><?php  echo $rows['status']; ?></td>

                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <div class="col-md-12 col-sm-12" style="padding: 0px;">
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6" style="padding: 0px;"><?= $pagination; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $("#reportmenu").addClass("active");
    $(".reportmenu").css("display", "block");
    function get_paguthi(sel) {
        var paguthi_id = sel.value;
        $.ajax({
            url: "<?php echo base_url(); ?>masters/get_active_office",
            method: "POST",
            data: { paguthi_id: paguthi_id },
            dataType: "JSON",
            cache: false,
            success: function (data) {
                var stat = data.status;
                // $("#office_id").empty();
                //
                // if (stat == "success") {
                //     var res = data.res;
                //     var len = res.length;
                //     $("#office_id").html('<option value="">ALL</option>');
                //     for (i = 0; i < len; i++) {
                //         $("<option>").val(res[i].id).text(res[i].office_name).appendTo("#office_id");
                //     }
                // } else {
                //     $("#office_id").empty();
                // }
            },
        });
    }

    $("#frmDate").datetimepicker({
        format: "DD-MM-YYYY",
    });

    $("#toDate").datetimepicker({
        format: "DD-MM-YYYY",
    });

    function get_sub_category(sel) {
        var grievance_id = sel.value;
        $.ajax({
            url: "<?php echo base_url(); ?>masters/get_active_sub_category",
            method: "POST",
            data: { grievance_id: grievance_id },
            dataType: "JSON",
            cache: false,
            success: function (data) {
                var stat = data.status;
                if (stat == "success") {
                    $("#sub_category_id").empty();
                    var res = data.res;
                    var len = res.length;
                    $("#sub_category_id").html('<option value="">ALL</option>');
                    for (i = 0; i < len; i++) {
                        $("<option>").val(res[i].id).text(res[i].sub_category_name).appendTo("#sub_category_id");
                    }
                } else {
                    $("#sub_category_id").empty();
                }
            },
        });
    }

    function get_category(sel){
      var seeker_id = sel.value;

      $.ajax({
          url: "<?php echo base_url(); ?>masters/get_grievance_active",
          method: "POST",
          data: { seeker_id: seeker_id },
          dataType: "JSON",
          cache: false,
          success: function (data) {
              var stat = data.status;
              if (stat == "success") {
                  $("#category").empty();
                  var res = data.res;
                  var len = res.length;
                  $("#category").html('<option value="">ALL</option>');
                  for (i = 0; i < len; i++) {
                      $("<option>").val(res[i].id).text(res[i].grievance_name).appendTo("#category");
                  }
              } else {
                  $("#category").empty();
              }
          },
      });
    }

    $("#report_form").validate({
        rules: {
            g_frmDate: {
                required: function (element) {
                    return $("#toDate").val().length > 0;
                },
            },
            g_toDate: {
                required: function (element) {
                    return $("#frmDate").val().length > 0;
                },
                chkDates: "#frmDate",
            },
        },
        messages: {
            g_frmDate: { required: "Select From Date" },
            g_toDate: { required: "Select To Date" },
        },
    });
</script>
