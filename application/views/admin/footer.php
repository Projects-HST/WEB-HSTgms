<footer>
   <div class="pull-right">
       Developed by <a href="https://www.happysanztech.com/" target="_blank">Happy Sanz Tech</a>
   </div>
   <div class="clearfix"></div>
</footer>
</div>
</div>

<style>

</style>
<script>


$(document).ready(function() {
  $('#grievance_model,#meeting_model,#status_modal,#reference_modal,#reply_modal').on('hidden.bs.modal', function () {
      location.reload();
  });
    $('#example').DataTable({

      "language": {
        "search": "",
        searchPlaceholder: "SEARCH"
      },
      "scrollX": true

    });
} );


$(document).ready(function() {
    $('#export_example').DataTable( {

		"scrollX": true,


		"language": {
          "search": "",
          searchPlaceholder: "SEARCH HERE"
        },
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5'
        ],

    } );
} );

$("input").on("keypress", function(e) {
         if (e.which === 32 && !this.value.length)
             e.preventDefault();
 });

 $('input[type=text]').val (function () {
     return this.value.toUpperCase();
 })
</script>
<script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendors/skycons/skycons.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/build/js/custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/build/js/rocket-loader.min.js" data-cf-settings="06b171321855c1ee1d6f7155- |49" defer=""></script>
</body>
</html>
