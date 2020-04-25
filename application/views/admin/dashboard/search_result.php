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
		
		<div class="col-md-12 col-sm-12 ">
          <table id="export_example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
				   <th>Petition No</th>
				    <th>Date</th>
                   <th>Name</th>
				   <th>Phone</th>
				    <th>Category</th>
				   <th>Status</th>
                   <th>Created by</th>

                </tr>
             </thead>
             <tbody>
               <?php //$i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php //echo $i; ?></td>
					<td><?php //echo $rows->petition_enquiry_no; ?></td>
					<td><?php //echo date('d-m-Y', strtotime($rows->created_at)); ?></td>
                    <td><?php //echo $rows->full_name; ?></td>
					<td><?php //echo $rows->mobile_no; ?></td>
					<td><?php //echo $rows->grievance_name; ?></td>
                    <td><?php  //echo $rows->status; ?></td>
                    <td><?php  //echo $rows->full_name; ?></td>
                 </tr>
            <?php //$i++; } ?>
             </tbody>
          </table>
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