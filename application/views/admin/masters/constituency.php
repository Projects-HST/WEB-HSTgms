<div  class="right_col" role="main">
   <div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Constituency</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <br>
               <form id="master_form" >
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Constituency name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="constituency_name" class="date-picker form-control" name="constituency_name" type="text">
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">

                        <button type="submit" class="btn btn-success">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
$('#master_form').validate({ // initialize the plugin
     rules: {
         constituency_name:{required:true }
     },
     messages: {
           constituency_name: "Enter your username"
         }
 });
 </script>
