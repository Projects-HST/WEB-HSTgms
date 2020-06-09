	<style type="text/css">

.pagination-first-tag{
	border:1px solid #eeeeee;
	padding:10px;
	background:#31aa15;
}
 
.pagination-last-tag{
	border:1px solid #eeeeee;
	padding:10px;
	background:#31aa15;
	
}
 
.pagination-next-tag{
	padding:10px;
	border:1px solid #eeeeee;
	background:#31aa15;
}
 
.pagination-prev-tag{
	padding:10px;
	border:1px solid #eeeeee;
	background:#31aa15;
	
}
 
.pagination-current-tag{
	color:#000000;
	font-weight:bold;
	padding:10px;
	border:1px solid #eeeeee;
}
 
.pagination-number{
	padding:10px;
	border:1px solid #eeeeee;
}
 
.pagination-first-tag a, .pagination-next-tag a, .pagination-last-tag a, .pagination-prev-tag a{
	color:#ffffff;
	
}
	</style>
<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Staff Report - Constituent Count</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">

		<div class="col-md-12 col-sm-12 ">
	<div style='margin-top: 10px;margin-bottom:10px;'>
		<?= $pagination; ?>
	</div>
	<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
		<tr>
			<th>S.no</th>
			<th>full_name</th>
			<th>father_husband_name</th>
			<th>guardian_name</th>
		</tr>
		<?php 
		$sno = $row+1;
		foreach($result as $data){
			echo "<tr>";
			echo "<td>".$sno."</td>";
			echo "<td>".$data['full_name']."</td>";
			echo "<td>".$data['father_husband_name']."</td>";
			echo "<td>".$data['guardian_name']."</td>";
			echo "</tr>";
			$sno++;
		}
		?>
	</table>
		<div style='margin-top: 10px;margin-bottom:10px;'>
		<?= $pagination; ?>
	</div>
	<!-- Paginate -->
	

        </div>
            </div>
         </div>
      </div>


        
   </div>
</div>

