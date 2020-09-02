<style type="text/css">
th{
  width:70px;
  }</style>
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Status Based Report</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="report_form" action="<?php echo base_url(); ?>report/status" method="post" enctype="multipart/form-data">
                        <div class="item form-group">
                            <label class="col-form-label col-md-2 col-sm-2">From </label>
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="form-control" placeholder="From Date" id="frmDate" name="s_frmDate" value="<?php echo $dfromDate; ?>" />
                            </div>
                            <label class="col-form-label col-md-2 col-sm-2">To </label>
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="form-control" placeholder="To Date" id="toDate" name="s_toDate" value="<?php echo $dtoDate; ?>" />
                            </div>
                            <label class="col-form-label col-md-1 col-sm-2">Status <span class="required">*</span></label>
                            <div class="col-md-2 col-sm-2">
                                <select class="form-control" name="s_status" id="status">
                                    <option value="">ALL</option>
                                    <!-- <option value="COMPLETED">COMPLETED</option> -->
                                    <option value="REJECTED">REJECTED</option>
                                    <option value="PENDING">PENDING</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                </select>
                                <script>
                                    $("#status").val("<?php echo $status; ?>");
                                </script>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-2 col-sm-2">paguthi <span class="required">*</span></label>
                            <div class="col-md-2 col-sm-2">
                                <select class="form-control" name="s_paguthi" id="paguthi" onchange="get_paguthi(this);">
                                    <option value="">ALL</option>
                                    <?php foreach($paguthi as $rows){ ?>
                                    <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
                                    <?php } ?>
                                </select>
                                <script>
                                    $("#paguthi").val("<?php echo $dpaguthi; ?>");
                                </script>
                            </div>
                            <label class="col-form-label col-md-2 col-sm-2">Office</label>
                            <div class="col-md-2 col-sm-2">
                                <select class="form-control" name="s_ward_id" id="office_id">
                                   <option value="">ALL</option>
                                  <?php  $query="SELECT * FROM office WHERE status='ACTIVE' and paguthi_id='$dpaguthi' order by id desc";
                                   $result_of=$this->db->query($query);
                                   if($result_of->num_rows()==0){ ?>
                                   <option value=""></option>
                                   <?php 	}else{
                                   $res_office=$result_of->result();
                                   foreach($res_office as $rows_office){ ?>
                                     <option value="<?php echo $rows_office->id; ?>"><?php echo $rows_office->office_name; ?></option>
                                   <?php   }		}    ?>
                                </select>
                                <script>
                                    $("#office_id").val("<?php echo $s_ward_id; ?>");
                                </script>
                            </div>
                            <label class="col-form-label col-md-1 col-sm-2">&nbsp;</label>
                            <div class="col-md-3 col-sm-2">
                                <input type="submit" name="submit" class="btn btn-success" value="SEARCH" />
                                <a href="<?php echo base_url(); ?>report/reset_search" class="btn btn-danger">CLEAR</a>
                                <a href="<?php echo base_url(); ?>report/get_status_report_export" class="btn btn-export">Export</a>
                            </div>

                        </div>
                        <div class="ln_solid"></div>
                    </form>
                </div>

                <!-- <div class="clearfix"></div> -->
                <div class="col-md-12 col-sm-12">
                    <div class="">
                        <div class="col-md-12 col-sm-12" style="padding: 0px;">
                            <div class="col-md-3 col-sm-3">
                                <h2>Search Result</h2>
                                Total records
                                <?php echo $total_records; ?>
                            </div>
                            <div class="col-md-3 col-sm-3"></div>
                            <div class="col-md-6 col-sm-6" style="padding: 0px;"><?= $pagination; ?></div>
                        </div>
                        <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Name</th>
                                    <th>Father or Husband </th>
                                    <th>Dob</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = $row+1; foreach($result as $rows){ ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rows['full_name']; ?></td>
                                    <td><?php echo $rows['father_husband_name']; ?></td>
                                    <td><?php echo $rows['dob']; ?></td>
                                    <td><?php echo $rows['address']; ?></td>
                                    <td><?php echo $rows['mobile_no']; ?></td>
                                    <td class="badge-<?= $rows['status'] ?>"><?php  echo $rows['status']; ?></td>

                                    <!-- <td><?php echo $rows['petition_enquiry_no']; ?></td> -->
                                    <!-- <td><?php echo date('d-m-Y', strtotime($rows['created_at'])); ?></td> -->
                                    <!-- <td><?php echo $rows['grievance_name']; ?></td> -->
                                    <!-- <td><?php  echo $rows['created_by']; ?></td> -->
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
                <div class="clearfix"></div>
            </div>
            <!-- </div> -->
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
                $("#office_id").empty();

                if (stat == "success") {
                    var res = data.res;
                    var len = res.length;
                    $("#office_id").html('<option value="">ALL</option>');
                    for (i = 0; i < len; i++) {
                        $("<option>").val(res[i].id).text(res[i].office_name).appendTo("#office_id");
                    }
                } else {
                    $("#office_id").empty();
                }
            },
        });
    }

    $.validator.addMethod(
        "chkDates",
        function (value, element) {
            var startDate = $("#frmDate").val();
            var datearray = startDate.split("-");
            var frm_date = datearray[1] + "/" + datearray[0] + "/" + datearray[2];

            var endDate = $("#toDate").val();
            var datearray = endDate.split("-");
            var to_date = datearray[1] + "/" + datearray[0] + "/" + datearray[2];

            return Date.parse(frm_date) <= Date.parse(to_date) || value == "";
        },
        "Fom date cannot be greater than To date"
    );

    $("#frmDate").datetimepicker({
        format: "DD-MM-YYYY",
    });

    $("#toDate").datetimepicker({
        format: "DD-MM-YYYY",
    });

    $("#report_form").validate({
        // initialize the plugin
        rules: {
            s_frmDate: {
                required: function (element) {
                    return $("#toDate").val().length > 0;
                },
            },
            s_toDate: {
                required: function (element) {
                    return $("#frmDate").val().length > 0;
                },
                chkDates: "#frmDate",
            },
        },
        messages: {
            s_frmDate: { required: "Select From Date" },
            s_toDate: { required: "Select To Date" },
        },
    });
</script>
