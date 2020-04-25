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
				 <label class="col-form-label col-md-4 col-sm-4 label-align">Select Area <span class="required">*</span></label>
				 <div class="col-md-6 col-sm-6">
						<select class="form-control" name="paguthi" id ="paguthi">
								<option value="All">OVER ALL</option>
							<?php foreach($paguthi as $rows){ ?>
								<option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
							<?php } ?>
						</select>
				 </div>
				  <div class="col-md-2 col-sm-2">
					 <button type="submit" class="btn btn-success">GO</button>					 
				 </div>
			  </div>
		 </form>
</div>
</div>
<div class="clearfix"></div>


<div class="row">

<div class="col-md-3 widget widget_tally_box">
<div class="x_panel fixed_height_390">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h3 class="name">Constituent Members</h3>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3>4500</h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>



<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_390">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h3 class="name">Total <br>Meetings</h3>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3>150</h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>


<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_390">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h3 class="name">Grievance</h3>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3>45869</h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
</ul>
</div>

</div>
</div>
</div>


<div class="col-md-3   widget widget_tally_box">
<div class="x_panel fixed_height_390">
<div class="x_content">
<div class="flex">
	<ul class="list-inline widget_profile_box">
		<li>&nbsp;</li>
		<li><img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img"></li>
		<li>&nbsp;</li>
	</ul>
</div>
<h3 class="name">Interaction Questions</h3>
<div class="flex">
	<ul class="list-inline count2">
		<li><h3>1500</h3></li>
	</ul>
</div>

<div>
	<ul class="list-inline widget_tally">
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
	<li>
		<p>
			<span class="month">12 December 2014 </span>
			<span class="count">+12%</span>
		</p>
	</li>
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
	<h2>Dashboard </h2>
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
          ['MONTH', 'MEMBERS'],
          ['JAN',  165],
          ['FEB',  135],
          ['MAR',  157],
          ['APR',  139],
          ['MAY',  136]
        ]);

        var options = {
          title : 'MEMBERS DETAILS',
          vAxis: {title: 'MEMBERS'},
          hAxis: {title: 'MONTHS'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}        
		 };


		var data1 = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

		var options1 = {
          title: 'GRIEVANCE DETAILS',
		  is3D: true,
        };


        var data2 = google.visualization.arrayToDataTable([
          ['MONTHS', 'MEETINGS'],
          ['JAN',  1000],
          ['FEB',  1170],
          ['MAR',  660],
          ['APR',  1030],
		  ['MAY',  800],
        ]);

        var options2 = {
          title: 'MEETING DETAILS',
          hAxis: {title: 'MONTHS',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };


        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
		var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
		var chart2 = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
		chart1.draw(data1, options1);
		chart2.draw(data2, options2);
      }
    </script>