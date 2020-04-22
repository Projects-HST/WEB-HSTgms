<footer>
   <div class="pull-right">
       Developed by <a href="#">Happy Sanz Tech</a>
   </div>
   <div class="clearfix"></div>
</footer>
</div>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable();
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
