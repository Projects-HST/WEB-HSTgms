<div class="right_col" role="main" style="min-height: 1284px;">

	<form id="search_form" action="<?php echo base_url(); ?>dashboard/searchresult" method="post" enctype="multipart/form-data">
		<div class="title_left" style="padding-top:70px;">
			<div class="col-md-12 col-sm-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" style="padding:12px;">Go!</button>
				</span>
			</div>
			</div>
		</div>
		</form>

		<div class="clearfix"></div>
<hr>
<div class="row">
<div class="col-md-12">
<div class="x_content">

<div class="row">
<div class="col-md-7">
<h2>Dashboard </h2>
</div>
<div class="col-md-5">
		<form id="result_form" action="<?php echo base_url(); ?>dashboard" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				 <label class="col-form-label col-md-6 col-sm-6 label-align">Select Area <span class="required">*</span></label>
				 <div class="col-md-6 col-sm-6">
						<select class="form-control" name="paguthi" id ="paguthi"  onchange="this.form.submit()">
								<option value="All">OVER ALL</option>
							<?php foreach($paguthi as $rows){ ?>
								<option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
							<?php } ?><script> $('#paguthi').val('<?php echo $search_paguthi; ?>');</script>
						</select>
				 </div>
				  <!--<div class="col-md-2 col-sm-2">
					 <button type="submit" class="btn btn-success">GO</button>
				 </div>-->
			  </div>
		 </form>
</div>
</div>
<div class="clearfix"></div>


<div class="row">

<div class="col-md-3 widget widget_tally_box">
<div class="x_panel fixed_height_430">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/images/cm.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h4 class="name">Constituent Members</h4>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3><?php echo $result['con_count']; ?></h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">Total Male </span>
			<span class="count"><?php echo $result['conm_count']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">Total Female </span>
			<span class="count"><?php echo $result['conf_count']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">No. of Voter ID </span>
			<span class="count"><?php echo $result['conv_count']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">No. of Aadhaar Card </span>
			<span class="count"><?php echo $result['cona_count']; ?></span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>



<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_430">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/images/meeting.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h4 class="name">Total <br>Meetings</h4>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3><?php echo $result['meet_count']; ?></h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">Meeting Requested </span>
			<span class="count"><?php echo $result['meet_rcount']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">Meeting Completed </span>
			<span class="count"><?php echo $result['meet_ccount']; ?></span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>


<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_430">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/images/gl.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h4 class="name">Grievance</h4>
<br>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3><?php echo $result['grev_count']; ?></h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">No. of Enquiry </span>
			<span class="count"><?php echo $result['grev_ecount']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">No. of Petition </span>
			<span class="count"><?php echo $result['grev_pcount']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">No. of Processing </span>
			<span class="count"><?php echo $result['grev_processcount']; ?></span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">No. of Completed </span>
			<span class="count"><?php echo $result['grev_completecount']; ?></span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>


<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_430">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/images/interaction.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h4 class="name">Interaction Questions</h4>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3><?php echo $result['interaction_count']; ?></h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">


	<?php if (count($interaction) >0) {
			foreach($interaction as $rows){?>
		<li>
			<p>
				<span class="month"><?php echo $rows->widgets_title;?> </span>
				<span class="count"><?php echo $rows->tot_values;?></span>
			</p>
		</li>
	<?php
			}
		}
		?>
</ul>
</div>

</div>
</div>
</div>

</div>


<div class="clearfix"></div>
<hr>

<div class="row">
<div class="col-md-12">
<div class="x_panel">
		<div id="chart_div" style="height:400px;"></div>
	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="row">
<div class="col-md-6">
<div class="x_panel">
	<div id="chart_div1" style="height:400px;"></div>
</div>
</div>

<div class="col-md-6">
<div class="x_panel">
		<div id="chart_div2" style="height:400px;"></div>
</div>
</div>
</div>

</div>
</div>
</div>

</div>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable([
          ['Month', 'TOTAL', 'NEW', 'REPEATED'],
          <?php
			  if (count($footfall_result) >0) {
				$i=1;
				$rec_count = count($footfall_result);
				foreach($footfall_result as $rows){
					echo "['$rows->disp_month', $rows->total, $rows->new_grev, $rows->repeated_grev]"; if ($i<$rec_count) { echo ",\n";} else {echo "\n"; }
				$i++;

				}
			} else {
				echo "['Nill', 0,0,0]";
			}
		?>
        ]);
        var options = {
          title : 'FOOT FALL REPORT',
          vAxis: {title: 'GRIEVANCE DETAILS',format: '0'},
          hAxis: {title: 'MONTHS'},
          seriesType: 'bars'
		 };



		var data1 = google.visualization.arrayToDataTable([
          ['Grievance', 'Grievance Type'],
          ['Enquiry', <?php echo $grievance_result['gerv_ecount']; ?>],
          ['Petition processing', <?php echo $grievance_result['gerv_ppcount']; ?>],
          ['Petition completed', <?php echo $grievance_result['gerv_pccount']; ?>]
        ]);
		var options1 = {
          title: 'GRIEVANCE PROGRESS REPORT'
        };



        var data2 = google.visualization.arrayToDataTable([
          ['MONTHS', 'MEETINGS'],
		<?php
			if (count($meeting_result) >0) {
				$i=1;
				$rec_count = count($meeting_result);
				foreach($meeting_result as $rows){
					echo "['$rows->month_year',  $rows->meeting_request]"; if ($i<$rec_count) { echo ",\n";} else {echo "\n"; }
				$i++;
				}
			}else {
				echo "['Nill', 0]";
			}
		?>
        ]);
        var options2 = {
          title: 'CONSTITUENTS MEETING REPORT',
          hAxis: {title: 'MONTHS'},
          vAxis: {title: 'MEETING COUNT',minValue: 0,format: '0'}
        };



        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
		var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
		var chart2 = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
		chart1.draw(data1, options1);
		chart2.draw(data2, options2);
      }
    </script>
