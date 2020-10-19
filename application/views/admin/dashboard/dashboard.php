<style>
#dashboardmenu a{
	color:#31aa15;
	font-weight: bold;
}
.nav-md .container.body .right_col{
	padding: 10px 20px 0;
margin-left: 230px;
}
.general_heading{
		color: #000;
    font-size: 15px;
    font-weight: 600;
    margin: 0px 0px 0px 0px;
}
</style>
<div class="right_col" id="top" role="main" style="min-height: 1284px;">

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
				<input type="text" class="form-control" name="d_keyword" id="keyword" oninvalid="this.setCustomValidity('ENTER NAME OR PHONE NUMBER OR VOTER ID OR AADHAAR CARD NUMBER OF CONSTITUENT')" placeholder="Search for constituents based on Name / FATHER OR HUSBAND NAME / Phone number / Voter ID / Aadhaar Card number / Address" required>
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

						 <option value="">ALL</option>
						 <?php foreach($res_office as $rows_office){ ?>
								<option value="<?php echo $rows_office->id ?>"><?php echo $rows_office->office_name; ?></option>
						<?php } ?>
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
			<div class="row" style="height:380px;">
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
					<div class="label_box">
						<div class="c_widget_label">Having Voter id (<?= round($rows_cons->having_voter_percenatge,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_vote_id); ?></div>
					</div>
					<div class="label_box">
						<div class="c_widget_label">DOB Count (<?= round($rows_cons->having_dob_percentage,2); ?>%)</div>
						<div class="c_widget_value"><?= moneyFormatIndia($rows_cons->having_dob); ?></div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<div class="col-md-8">
		<div class="row mb_30">
			<div class="col-md-12">
				<div class="widget_box widget_1_height">

					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_2.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Grievance Count</p>
									<p class="widget_count">&nbsp;</p>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<?php foreach($grievance_result['grievance_list'] as $rows_grievance){}
							$total_grievance_list=$rows_grievance->no_of_civic + $rows_grievance->no_of_online;
							?>
						<div class="col-6">
							<div class="row">
								<div class="col-9"><p class="widget_grievance_label">grievance Petition count</p></div>
								<div class="col-3"><p class="widget_grievance_label widget_value"><?= moneyFormatIndia($total_grievance_list)	?></p></div>

								<div class="col-9"><p class="widget_label">Online issue (<?php  if($total_grievance_list=='0'){ echo "0.00"; }else{
								echo	number_format($online_percentage=$rows_grievance->no_of_online/$total_grievance_list *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_grievance->no_of_online);	?></p></div>

								<div class="col-9"><p class="widget_label">Civic issue (<?php  if($total_grievance_list=='0'){ echo "0.00"; }else{
								echo	number_format($online_percentage=$rows_grievance->no_of_civic/$total_grievance_list *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_grievance->no_of_civic);	?></p></div>


						</div>
						</div>
						<div class="col-6">
							<div class="row">
								<?php  foreach($grievance_result['enquiry_count'] as $enquiry_cnt){} ?>
								<?php  foreach($grievance_result['petition_count'] as $petition_cnt){}
												$total_p_e_cnt=$enquiry_cnt->enquiry_count+$petition_cnt->petition_count;
										?>
										<?php  foreach($grievance_result['petition_status'] as $petition_status){} ?>
								<div class="col-9"><p class="widget_grievance_label">Overall Grievance count</p></div>
								<div class="col-3"><p class="widget_grievance_label widget_value"><?= moneyFormatIndia($total_p_e_cnt)	?></p></div>

								<div class="col-9"><p class="widget_label">Enquiry </p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($enquiry_cnt->enquiry_count);	?></p></div>

								<div class="col-9"><p class="widget_label">Petition (<?php  if($enquiry_cnt->enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($petition_cnt->petition_count/$enquiry_cnt->enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($petition_cnt->petition_count);	?></p></div>



							</div>
								<div class="row">
									<div class="col-9"><p class="widget_label_status">Pending   (<?php  if($enquiry_cnt->enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($petition_status->no_of_pending/$enquiry_cnt->enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($petition_status->no_of_pending) ?></p></div>
									<div class="col-9"><p class="widget_label_status">Completed (<?php  if($enquiry_cnt->enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($petition_status->no_of_completed/$enquiry_cnt->enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($petition_status->no_of_completed) ?></p></div>
									<div class="col-9"><p class="widget_label_status">Rejected (<?php  if($enquiry_cnt->enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($petition_status->no_of_rejected/$enquiry_cnt->enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($petition_status->no_of_rejected) ?></p></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<hr>
							<div class="row">
								<?php foreach($grievance_result['online_enquiry_count'] as  $rows_online_enquiry_count){} ?>
								<?php foreach($grievance_result['online_petition_count'] as  $rows_online_petition_count){}
									$total_online_grievance_count=$rows_online_enquiry_count->online_enquiry_count + $rows_online_petition_count->online_petition_count;
									?>
										<?php  foreach($grievance_result['online_petition_status'] as $online_petition_status){} ?>
								<div class="col-9"><p class="widget_grievance_label">Online grievance Count</p></div>
								<div class="col-3"><p class="widget_grievance_label widget_value"><?= moneyFormatIndia($total_online_grievance_count) ?></p></div>
								<div class="col-9"><p class="widget_label">Enquiry</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_online_enquiry_count->online_enquiry_count) ?></p></div>
								<div class="col-9"><p class="widget_label">Petition (<?php  if($rows_online_enquiry_count->online_enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($rows_online_petition_count->online_petition_count/$rows_online_enquiry_count->online_enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_online_petition_count->online_petition_count) ?></p></div>
						</div>
						<div class="row">

								<div class="col-9"><p class="widget_label_status">Pending   (<?php  if($rows_online_enquiry_count->online_enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($online_petition_status->no_of_pending/$rows_online_enquiry_count->online_enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($online_petition_status->no_of_pending) ?></p></div>
								<div class="col-9"><p class="widget_label_status">Completed (<?php  if($rows_online_enquiry_count->online_enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($online_petition_status->no_of_completed/$rows_online_enquiry_count->online_enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($online_petition_status->no_of_completed) ?></p></div>
								<div class="col-9"><p class="widget_label_status">Rejected (<?php  if($rows_online_enquiry_count->online_enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($online_petition_status->no_of_rejected/$rows_online_enquiry_count->online_enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($online_petition_status->no_of_rejected) ?></p></div>

					</div>
						</div>
						<div class="col-6">
							<hr>
							<div class="row">
								<?php foreach($grievance_result['civic_enquiry_count'] as  $rows_civic_enquiry_count){} ?>
								<?php foreach($grievance_result['civic_petition_count'] as  $rows_civic_petition_count){}
									$total_civic_grievance_count=$rows_civic_enquiry_count->civic_enquiry_count + $rows_civic_petition_count->civic_petition_count;
									?>
										<?php  foreach($grievance_result['civic_petition_status'] as $civic_petition_status){} ?>
								<div class="col-9"><p class="widget_grievance_label">Civic grievance Count</p></div>
								<div class="col-3"><p class="widget_grievance_label widget_value"><?= moneyFormatIndia($total_civic_grievance_count) ?></p></div>
								<div class="col-9"><p class="widget_label">Enquiry</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_civic_enquiry_count->civic_enquiry_count) ?></p></div>
								<div class="col-9"><p class="widget_label">Petition (<?php  if($rows_civic_enquiry_count->civic_enquiry_count=='0'){ echo "0.00"; }else{
								echo	number_format($rows_civic_petition_count->civic_petition_count/$rows_civic_enquiry_count->civic_enquiry_count *100,2);
								} ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_civic_petition_count->civic_petition_count) ?></p></div>
						</div>
								<div class="row">

									<div class="col-9"><p class="widget_label_status">Pending   (<?php  if($rows_civic_enquiry_count->civic_enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($civic_petition_status->no_of_pending/$rows_civic_enquiry_count->civic_enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($civic_petition_status->no_of_pending) ?></p></div>
									<div class="col-9"><p class="widget_label_status">Completed (<?php  if($rows_civic_enquiry_count->civic_enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($civic_petition_status->no_of_completed/$rows_civic_enquiry_count->civic_enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($civic_petition_status->no_of_completed) ?></p></div>
									<div class="col-9"><p class="widget_label_status">Rejected (<?php  if($rows_civic_enquiry_count->civic_enquiry_count=='0'){ echo "0.00"; }else{
									echo	number_format($civic_petition_status->no_of_rejected/$rows_civic_enquiry_count->civic_enquiry_count *100,2);
									} ?>%)</p></div>
									<div class="col-3"><p class="widget_value widget_label"><?= moneyFormatIndia($civic_petition_status->no_of_rejected) ?></p></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="clearfix"></div>

		<div class="row mb_30 mt_0">
			<div class="col-md-8">
				<div class="widget_box widget_4_height">
					<div class="row">
						<div class="col-3">
								<p><img class="img-responsive widget_img" src="<?= base_url(); ?>assets/admin/images/widget_3.png"></p>
						</div>
						<div class="col-9">
							<div class="widget_title">
								<p class="widget_heading">Footfall Count</p>
								<p class="widget_count">&nbsp;</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
								<hr>
							<div class="row">
							<?php foreach($get_footfall_report['constituency_cnt'] as $rows_cons_cnt){} ?>
							<?php foreach($get_footfall_report['other_cnt'] as $rows_other_cnt){}
								$total_unique_cnt=$rows_cons_cnt->cons_footfall_cnt+$rows_other_cnt->other_footfall_cnt;
							?>
							<div class="col-9"><p class="widget_footfall_label">Unique Footfall Count</p></div>
							<div class="col-3"><p class="widget_footfall_label widget_value"><?= moneyFormatIndia($total_unique_cnt) ?></p></div>
							<div class="col-9"><p class="widget_label">SINGANALLUR  (<?php if($total_unique_cnt=='0'){ echo "0.00"; }else{
								echo	number_format($rows_cons_cnt->cons_footfall_cnt/$total_unique_cnt *100,2);
							} ?>%)</p></div>
							<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_cons_cnt->cons_footfall_cnt) ?></p></div>
							<div class="col-9"><p class="widget_label">Others  (<?php if($total_unique_cnt=='0'){ echo "0.00"; }else{
								echo	number_format($rows_other_cnt->other_footfall_cnt/$total_unique_cnt *100,2);
							} ?>%)</p></div>
							<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_other_cnt->other_footfall_cnt) ?></p></div>
						</div>
						</div>
						<div class="col-6">
								<hr>
							<div class="row">
								<?php foreach($get_footfall_report['unique_footfall_cnt'] as $rows_unique_cnt){} ?>
								<?php foreach($get_footfall_report['repeated_footfall_cnt'] as $rows_repeat_cnt){}
									$total_unique_repeat=$rows_unique_cnt->unique_cnt + $rows_repeat_cnt->repeated_cnt;
									?>
							<div class="col-9"><p class="widget_footfall_label">Total Footfall Count</p></div>
							<div class="col-3"><p class="widget_footfall_label widget_value"><?= moneyFormatIndia($total_unique_repeat) ?></p></div>
							<div class="col-9"><p class="widget_label">Unique  (<?php if($total_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_unique_cnt->unique_cnt/$total_unique_repeat *100 ,2); } ?>%)</p></div>
							<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_unique_cnt->unique_cnt) ?></p></div>
							<div class="col-9"><p class="widget_label">Repeated  (<?php if($total_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_repeat_cnt->repeated_cnt/$total_unique_repeat *100 ,2); } ?>%)</p></div>
							<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_repeat_cnt->repeated_cnt) ?></p></div>
						</div>
						</div>


					</div>

					<div class="row">
						<div class="col-6">
							<hr>
							<div class="row">
								<?php foreach($get_footfall_report['cons_repeated_cnt'] as $rows_cons_repeated_cnt){} ?>
								<?php foreach($get_footfall_report['cons_unique_cnt'] as $rows_cons_unique_cnt){}
									$total_cons_unique_repeat=$rows_cons_repeated_cnt->cons_repeated_cnt + $rows_cons_unique_cnt->new_cnt;
									?>
								<div class="col-9"><p class="widget_footfall_label">SINGANALLUR Footfall Count</p></div>
								<div class="col-3"><p class="widget_footfall_label widget_value"><?= moneyFormatIndia($total_cons_unique_repeat) ?></p></div>
								<div class="col-9"><p class="widget_label">Unique  (<?php if($total_cons_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_cons_unique_cnt->new_cnt/$total_cons_unique_repeat *100 ,2); } ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_cons_unique_cnt->new_cnt) ?></p></div>
								<div class="col-9"><p class="widget_label">Repeated (<?php if($total_cons_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_cons_repeated_cnt->cons_repeated_cnt/$total_cons_unique_repeat *100 ,2); } ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_cons_repeated_cnt->cons_repeated_cnt) ?></p></div>
							</div>
						</div>
						<div class="col-6">
							<hr>
							<div class="row">
								<?php foreach($get_footfall_report['other_repeated_cnt'] as $rows_other_repeated_cnt){} ?>
								<?php foreach($get_footfall_report['other_unique_cnt'] as $rows_other_unique_cnt){}
									$total_other_unique_repeat=$rows_other_repeated_cnt->other_repeated_cnt + $rows_other_unique_cnt->other_new_cnt;
									?>
								<div class="col-9"><p class="widget_footfall_label">Other Footfall Count</p></div>
								<div class="col-3"><p class="widget_footfall_label widget_value"><?= moneyFormatIndia($total_other_unique_repeat) ?></p></div>
								<div class="col-9"><p class="widget_label">Unique  (<?php if($total_other_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_other_unique_cnt->other_new_cnt/$total_other_unique_repeat *100 ,2); } ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_other_unique_cnt->other_new_cnt) ?></p></div>
								<div class="col-9"><p class="widget_label">Repeated  (<?php if($total_other_unique_repeat==0){ echo "0.00"; }else{ echo  number_format($rows_other_repeated_cnt->other_repeated_cnt/$total_other_unique_repeat *100 ,2); } ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_other_repeated_cnt->other_repeated_cnt) ?></p></div>
							</div>
						</div>
					</div>

				</div>
			</div>


			<div class="col-md-4">
				<?php  foreach($grievance_report['mr_list'] as $row_mr_list){} ?>
				<div class="widget_box">
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

				<div class="widget_box mt_20">
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
		<div class="row mb_30 ">

			<?php  foreach($grievance_report['br_list'] as $row_br_list){} ?>
				<?php  if(empty($grievance_report['fw_list'])){
					$fwlist_total="0";
				}else{
					foreach($grievance_report['fw_list'] as $row_fw_list){}
						$fwlist_total=$row_fw_list->total;
				} ?>
			<div class="col-md-4">
				<div class="widget_box widget_3_height">
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
						<div class="col-9"><p class="widget_label">Birthday letters (<?php  if($bwfw=="0"){ echo "0"; }else{ ?><?=  round($row_br_list->birth_wish_count/ $bwfw *100,2); }?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($row_br_list->birth_wish_count); ?></p></div>
						<div class="col-9"><p class="widget_label">festival letters (<?php if($bwfw=="0"){ echo "0"; }else{ ?><?=  round($fwlist_total/ $bwfw *100,2); } ?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($fwlist_total); ?></p></div>
					</div>
					<div class="row" id="festival_list_section">
						<?php if(empty($grievance_report['fm_list'])){
						}else{
							foreach($grievance_report['fm_list'] as $rows_fm_list){ ?>
								<div class="col-9"><p class="widget_label_status"><?= $rows_fm_list->festival_name ?>   (<?php if($fwlist_total=='0'){ echo "0"; }else{
									echo number_format($rows_fm_list->wishes_cnt/$fwlist_total *100,2);
								}  ?>%)</p></div>
								<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_fm_list->wishes_cnt) ?></p></div>
						<?php	}
						} ?>

				</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="widget_box widget_3_height">
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
					<div class="row" id="video_list_section">
						<?php if(empty($grievance_report['cv_list'])){

					}else{ foreach($grievance_report['cv_list'] as $rows_vi_lits){ ?>
						<div class="col-9"><p class="widget_label"><?= $rows_vi_lits->office_name; ?> (<?php if($sum=="0"){echo "0";}else{?><?= round($rows_vi_lits->cnt_video/$sum*100,2);?><?php }?>%)</p></div>
						<div class="col-3"><p class="widget_label widget_value"><?= moneyFormatIndia($rows_vi_lits->cnt_video); ?> </p></div>
					<?php }	} ?>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="widget_box widget_3_height">
					<div class="row">
						<div class="col-12">
							<center><img src="<?php echo base_url(); ?>assets/admin/images/widget_8.png" class="img-responsive" style="width:130px;"></center>
							<center><p style="margin-bottom:0px;font-size:14px;color:#000;">To known more date in <br><b>Grievance management system</b></p></center>
							<center> <a href="<?php echo base_url(); ?>constituent/all_grievance" class="btn btn-success" style="margin-top:10px;">Click here</a></center>
						</div>

				</div>
				</div>
			</div>

		</div>
		<div class="clearfix"></div>



<div class="row">


</div>

<div class="clearfix"></div>
	<?php if(empty($footfall_result)){  }else{ ?>
<hr>

<div class="row">

<div class="col-md-12">
	<p class="graph_title text-left">
		<?php if(empty($from_date)){ ?>
						<span class="text-right" style="float:right;">Last 30 days data</span>
	<?php	}else{

		} ?>
	</p>
<div class="x_panel">
	<p class="general_heading">FOOTFALL GRAPH</p>
	<hr>
		<div id="curve_chart" style="width: 100%; height: 500px"></div>
	</div>
</div>
</div>
<?php } ?>
<div class="clearfix"></div>
<div class="row">

	<div class="col-md-12">
		<div class="x_panel">
			<p class="general_heading" >Google Reviews</p>
			<hr style="margin-bottom:10px;">
			<div class="col-md-6">
				<div id="comments2"></div>
			</div>
			<div class="col-md-6">
				<div id="comments3"></div>
			</div>
		</div>

	</div>
	<!-- <a href="#top" class="cd-top text-replace js-cd-top">Top</a> -->


</div>


</div>
</div>
</div>

</div>



  <script type="text/javascript">

  wpac_init = window.wpac_init || [];
  wpac_init.push({widget: 'Comment', id: 12345});
  (function() {
    if ('WIDGETPACK_LOADED' in window) return;
    WIDGETPACK_LOADED = true;
    var mc = document.createElement('script');
    mc.type = 'text/javascript';
    mc.async = true;
    mc.src = 'https://embed.widgetpack.com/widget.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
  })();
  </script>
<script type="text/javascript">
    	wpac_init.push({widget: 'GoogleReview', id: 27611, place_id: 'ChIJn1KhaldXqDsRNVjdn9pNI7E', view_mode: 'list',el: 'comments2', chan: '3'});
		wpac_init.push({widget: 'GoogleReview', id: 27611, place_id: 'ChIJewDaUDlXqDsR7e2v19vPsZk', view_mode: 'list',el: 'comments3', chan: '3'});

  </script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <!-- <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script> -->

    <script type="text/javascript">
		 google.charts.load('current', {packages: ['corechart','line']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
            // Define the chart to be drawn.
            var data = new google.visualization.DataTable();
						data.addColumn('string', 'Day');
            data.addColumn('number', 'UNIQUE');
            data.addColumn('number', 'Repeated');
            data.addColumn('number', 'Total');
            data.addRows([
					<?php $i=1; foreach($footfall_result as $rows_graph){ ?>
						['<?= $rows_graph->day_name ?>',  <?= $rows_graph->unique_count ;?>,<?= $rows_graph->repeat_count ;?>,<?= $rows_graph->total ;?>],
					<?php $i++; } ?>
            ]);


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
						 // $("#office_id").empty();
						 //
						 // if (stat == "success") {
							// 	 var res = data.res;
							// 	 var len = res.length;
							// 	 $("#office_id").html('<option value="">ALL</option>');
							// 	 for (i = 0; i < len; i++) {
							// 			 $("<option>").val(res[i].id).text(res[i].office_name).appendTo("#office_id");
							// 	 }
						 // } else {
							// 	 $("#office_id").empty();
						 // }
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
