<style>
#dashboardmenu a{
	color:#31aa15;
	font-weight: bold;
}
.nav-md .container.body .right_col{
	padding: 10px 20px 0;
margin-left: 230px;
}
</style>
<div class="right_col" role="main" style="min-height: 1284px;">

	<div class="col-md-12">
		<div class="col-md-3">
			<p class="dash_title fnt_15" >Welcome !</p>
		</div>
		<div class="col-md-6">
		</div>
		<div class="col-md-3">
				<p class="dash_title text-right"><?php   date_default_timezone_set("Asia/Calcutta");
				echo date('d-F-Y |'); ?> <span id="txt"></span></p>
		</div>
	</div>

	<form id="search_form" action="<?php echo base_url(); ?>dashboard/searchresult" method="post" enctype="multipart/form-data">
		<div class="title_left">
			<div class="col-md-12 col-sm-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" name="d_keyword" id="keyword" oninvalid="this.setCustomValidity('ENTER NAME OR PHONE NUMBER OR VOTER ID OR AADHAAR CARD NUMBER OF CONSTITUENT')" placeholder="Search for constituents based on Name, Phone number, Voter ID or Aadhaar Card number, Address" required>
				<span class="input-group-btn">
					<input class="btn btn-default" type="submit" name="submit" style="padding: 15px 10px 13px 10px;background-color: #31aa15;
    color: #fff;    font-weight: 600;" value="GO!">
				</span>
			</div>
			</div>
		</div>
		</form>

		<div class="clearfix"></div>

<div class="row">
<div class="col-md-12">
<div class="x_content">

<div class="row">

<div class="col-md-12">
		<form id="result_form" action="<?php echo base_url(); ?>dashboard/index" method="post" enctype="multipart/form-data">
			  <div class="form-group row">

 				 <div class="col-md-2 ">
					 <label class="col-form-label  text-left">From Date</label>
 						<input type="text" class="form-control" name="from_date" id="from_date" value="<?php echo $from_date; ?>" placeholder="DD-MM-YYYY">
 				 </div>

				 <div class="col-md-2">
					  <label class="col-form-label  text-left">To date</label>
					 <input type="text" class="form-control" name="to_date" id="to_date" value="<?php echo $to_date; ?>" placeholder="DD-MM-YYYY">
					 </div>

				 <div class="col-md-3 col-sm-6">
					 <label class="col-form-label  text-left">paguthi</label>
						<select class="form-control" name="paguthi_id" id ="paguthi_id" onchange="get_paguthi(this);">
								<option value="">ALL</option>
							<?php foreach($paguthi as $rows){ ?>
								<option value="<?php echo $rows->paguthi_id;?>"><?php echo $rows->paguthi_name;?></option>
							<?php } ?><script> $('#paguthi_id').val('<?php echo $paguthi_id; ?>');</script>
						</select>
				 </div>

				 <div class="col-md-3 col-sm-6">
					 <label class="col-form-label  text-left">office</label>
					 <select class="form-control" name="office_id" id="office_id">

						 <?php
						  $query="SELECT * FROM office WHERE status='ACTIVE' and paguthi_id='$paguthi_id' order by id desc";
						 $result=$this->db->query($query);
						 if($result->num_rows()==0){ ?>

						 <?php 	}else{
						 $res_office=$result->result(); ?>
						 <option value="">ALL</option>
						<?php foreach($res_office as $rows_office){ ?>
							 <option value="<?php echo $rows_office->id; ?>"><?php echo $rows_office->office_name; ?></option>
						 <?php   }		}    ?>
					 </select>
						<script>$('#office_id').val('<?php echo $office_id; ?>');</script>
				 </div>

					 <div class="col-md-2 col-sm-2 text-center">
					  <button type="submit" class="btn btn-success btn-width">FIND</button>
					  <a href="<?php echo base_url(); ?>dashboard/index" class="btn btn-white btn-width">CLEAR</a>



			 </div>

				  </div>


		 </form>
</div>
</div>
<hr>
<div class="clearfix"></div>
<?php
function moneyFormatIndia($num) {
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3);
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {

            if($i==0) {
                $explrestunits .= (int)$expunit[$i].",";
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash;
}
?>
<?php foreach($result_cons as $rows_cons){} ?>
<div class="row mt_20">
	<div class="col-md-4">
		<div class="widget_box">
			<div class="row">
				<div class="col-3">
						<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_1.png"></p>
				</div>
				<div class="col-9">
					<div class="widget_title">
						<p class="widget_heading">Constituent Count</p>
						<p class="widget_count"><?= moneyFormatIndia($rows_cons->total); ?></p>
					</div>
				</div>
			</div>
			<hr>
			<div class="row" style="height:440px;">
				<div class="col-12">
					<div class="label_box">
							<div class="c_widget_label">Male (<?= round($rows_cons->malepercenatge,2); ?>%)</div>
							<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->malecount); ?></div>
					</div>

					<div class="label_box">
						<div class="c_widget_label">Female (<?= round($rows_cons->femalepercenatge,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->femalecount); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">Transgender (<?= round($rows_cons->otherpercenatge,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->others); ?></div>
					</div>
					<!-- <div class="label_box">
						<div class="c_widget_label">Male  voter(<?= round($rows_cons->malevoter_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->malevoter); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">feMale voter (<?= round($rows_cons->femalevoter_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->femalevoter); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">Male  aadhaar(<?= round($rows_cons->maleaadhaar_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->maleaadhar); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">female aadhaar (<?= round($rows_cons->femaleaadhaar_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->femaleaadhar); ?></div>
					</div> -->
					<div class="label_box">
						<div class="c_widget_label">Having phone No (<?= round($rows_cons->mobile_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_mobilenumber); ?></div>
					</div>


					<div class="label_box">
						<div class="c_widget_label">Having whatsapp (<?= round($rows_cons->whatsapp_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_whatsapp); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">whatsapp broadcast users (<?= round($rows_cons->broadcast_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_whatsapp_broadcast); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">Having Email id (<?= round($rows_cons->email_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_email); ?></div>
					</div>

				</div>


			</div>

		</div>
	</div>

	<div class="col-md-8">
		<div class="row mb_30">
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_2.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Grievance Count</p>
								<?php  foreach($grievance_report['gr_list'] as $row_gr_list){} ?>
							<!-- <p class="widget_count"><?php echo moneyFormatIndia($total_grievance=$row_gr_list->total);  ?></p> -->
							<p class="widget_count"><?php $sum_1 = 0; if(empty($grievance_report['seeker_list'])){ 	}else{  foreach($grievance_report['seeker_list'] as $row_grievenace){ $sum_1 += $row_grievenace->total;  }} echo moneyFormatIndia($sum_1); ?>
							</p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
				<?php  foreach($grievance_report['seeker_list'] as $row_grievenace){ ?>
							<div class="col-9"><p class="widget_label"><?php echo  $row_grievenace->seeker_info; ?> (<?php
							if($row_grievenace->total=='0'){
								echo "0";
							}else{
									echo round($row_grievenace->total/$total_grievance *100,2);
							}
							?>%)</p></div>
							<div class="col-3"><p class="widget_label widget_value"> <?php echo  moneyFormatIndia($row_grievenace->total); ?></p></div>

						<?php } ?>

					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_3.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Footfall Count</p>
									<?php  foreach($grievance_report['gr_list'] as $row_gr_list){} ?>
								<p class="widget_count"><?php echo moneyFormatIndia($row_gr_list->total);  ?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">

							<?php   foreach($grievance_report['gr_list'] as $row_gr_list){ ?>
						<div class="col-9"><p class="widget_label">New Constituent (<?php echo round($row_gr_list->unique_count_percentage,2); ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?php echo moneyFormatIndia($row_gr_list->unique_count); ?></p></div>
						<div class="col-9"><p class="widget_label">Repeated Constituent (<?php echo round($row_gr_list->repeat_count_percentage,2); ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?php echo moneyFormatIndia($row_gr_list->repeat_count); ?></p></div>
					<?php } ?>
					</div>
				</div>
			</div>

		</div>

		<div class="row mb_30">
			<?php  foreach($grievance_report['mr_list'] as $row_mr_list){} ?>
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_4.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Meeting Count</p>
								<p class="widget_count"><?= moneyFormatIndia($row_mr_list->total); ?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-9"><p class="widget_label">Requested & Scheduled (<?= round($row_mr_list->mr_percentage,2); ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?= moneyFormatIndia($row_mr_list->meeting_request_count); ?></p></div>
						<div class="col-9"><p class="widget_label">Completed (<?= round($row_mr_list->mc_percentage,2); ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?= moneyFormatIndia($row_mr_list->meeting_complete_count); ?></p></div>

					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_5.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Volunteer Count</p>
								<p class="widget_count"><?= moneyFormatIndia($rows_cons->total); ?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-9"><p class="widget_label">Volunteer (<?=  round($rows_cons->no_of_volut_percentage,2);?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?= moneyFormatIndia($rows_cons->no_of_volunteer); ?></p></div>
						<div class="col-9"><p class="widget_label">Non Volunteer (<?= round($rows_cons->no_of_nonvolut_percentage,2); ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"> <?= moneyFormatIndia($rows_cons->no_of_nonvolunteer); ?></p></div>
					</div>
				</div>
			</div>
		</div>


		<div class="clearfix"></div>
		<div class="row mb_30">

			<?php  foreach($grievance_report['br_list'] as $row_br_list){} ?>
				<?php  if(empty($grievance_report['fw_list'])){
					$fwlist_total="0";
				}else{
					foreach($grievance_report['fw_list'] as $row_fw_list){}
						$fwlist_total=$row_fw_list->total;
				} ?>
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_6.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Greeting Count</p>
								<p class="widget_count"><?php echo $bwfw=moneyFormatIndia($fwlist_total+$row_br_list->birth_wish_count); ?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">

						<div class="col-9"><p class="widget_label">Birthday letters (<?php  if($rows_cons->total=="0"){ echo "0"; }else{ ?><?=  round($row_br_list->birth_wish_count/ $bwfw *100,2); }?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($row_br_list->birth_wish_count); ?></p></div>
						<div class="col-9"><p class="widget_label">festival letters (<?php if($rows_cons->total=="0"){ echo "0"; }else{ ?><?=  round($fwlist_total/ $bwfw *100,2); } ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($fwlist_total); ?></p></div>

					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="widget_box widget_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_7.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Video Count</p>
								<p class="widget_count"><?php $sum = 0; if(empty($grievance_report['cv_list'])){ 	}else{  foreach($grievance_report['cv_list'] as $rows_vi_lits){ $sum += $rows_vi_lits->cnt_video;  }} echo moneyFormatIndia($sum); ?></p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<?php if(empty($grievance_report['cv_list'])){

					}else{ foreach($grievance_report['cv_list'] as $rows_vi_lits){ ?>
						<div class="col-9"><p class="widget_label"><?= $rows_vi_lits->office_name; ?> (<?php if($rows_cons->total=="0"){echo "0";}else{?><?= round($rows_vi_lits->cnt_video/$rows_cons->total*100,2);?><?php }?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_vi_lits->cnt_video); ?> </p></div>
					<?php }	} ?>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="clearfix"></div>
	<?php if(empty($footfall_result)){  }else{ ?>
<hr>

<div class="row">

<div class="col-md-12">
	<p class="graph_title text-left">FOOTFALL GRAPH
		<?php if(empty($from_date)){ ?>
						<span class="text-right" style="float:right;">Last 6 week data</span>
	<?php	}else{

		} ?>


	</p>

<div class="x_panel">

		<div id="curve_chart" style="width: 100%; height: 500px"></div>



	</div>

</div>

<!-- <div class="col-md-4">
	<script src="https://apps.elfsight.com/p/platform.js" defer></script>
	<div class="elfsight-app-b71202ae-76b6-4648-b0ef-e159094d4f38"></div>
</div> -->
</div>
<?php } ?>
<div class="clearfix"></div>



</div>
</div>
</div>

</div>
 <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
 <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
		 google.charts.load('current', {packages: ['corechart','line']});
// 		google.charts.load('current', {'packages':['corechart']});
// google.charts.setOnLoadCallback(drawChart);
// function drawChart() {
// var data = google.visualization.arrayToDataTable([
// 	['Week', 'NEW', 'Repeated','Total'],
// 	<?php $i=1; foreach($footfall_result as $rows_graph){ ?>
// 		['<?= "week".'-' .$i; ?>',  <?= $rows_graph->total ;?>,<?= $rows_graph->unique_count ;?>,<?= $rows_graph->repeat_count ;?>],
// 	<?php $i++; } ?>
//
// 	// ['2005',  1170,      460,112],
// 	// ['2006',  660,       1120,200],
// 	// ['2007',  1030,      540,300],
// ]);
//
// var options = {
// 	title: '',
// 	curveType: 'function',
// 	legend: { position: 'bottom' }
// };
//
// var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
//
// chart.draw(data, options);
// }
function drawChart() {
            // Define the chart to be drawn.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Week');
            data.addColumn('number', 'New');
            data.addColumn('number', 'Repeated');
            data.addColumn('number', 'Total');
            data.addRows([

					<?php $i=1; foreach($footfall_result as $rows_graph){ ?>
						['<?= "week".'-' .$i; ?>',  <?= $rows_graph->unique_count ;?>,<?= $rows_graph->repeat_count ;?>,<?= $rows_graph->total ;?>],
					<?php $i++; } ?>

            ]);


            // Set chart options
            var options = {
               'width':1024,
               'height':500,
               pointsVisible: true
            };

            // Instantiate and draw the chart.
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
         }
         google.charts.setOnLoadCallback(drawChart);

$.validator.addMethod("chkDates", function(value, element) {
		var startDate = $('#from_date').val();
		var datearray = startDate.split("-");
		var frm_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		var endDate = $('#to_date').val();
		var datearray = endDate.split("-");
		var to_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		return Date.parse(frm_date) <= Date.parse(to_date) || value == "";
	}, "Please check dates");
$('#from_date').datetimepicker({
      format: 'DD-MM-YYYY'
});
$('#to_date').datetimepicker({
      format: 'DD-MM-YYYY'

});
$('#result_form').validate({
     rules: {
         // paguthi_id:{required:true },
				 from_date:{ required: function(element){
            return $("#to_date").val().length > 0; }},
				to_date:{ required: function(element){
	         return $("#from_date").val().length > 0; },chkDates: "#from_date"},
     },
     messages: {
			 from_date:{required:"Select From Date"},
			 to_date:{required:"Select TO Date"}
         }
 });

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
 function startTime()
{
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	var hours = (today.getHours() >= 12) ? today.getHours()-12 : today.getHours();
	// h = hours % 12;
	// var h = hours ? hours : 12;
	m = checkTime(m);
	s = checkTime(s);
	document.getElementById('txt').innerHTML =
	hours + ":" + m + ":" + s;
	var t = setTimeout(startTime, 500);
}
function checkTime(i)
{
	if (i < 10) {i = "0" + i};
	return i;
}
window.onload
{
	startTime();
}
    </script>
