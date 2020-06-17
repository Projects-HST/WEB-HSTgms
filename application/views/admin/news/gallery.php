<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<?php   foreach($res as $res_news){} ?>
<div  class="right_col" role="main">
   <div class="">
   
      <div class="clearfix"></div>
	<div class="row">
	
      <div class="col-md-12 col-sm-12 ">
		<?php if($this->session->flashdata('msg')): ?>
				<div class="alert alert-success alert-dismissible " role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php echo $this->session->flashdata('msg'); ?>
				</div>
			<?php endif; ?>
			
         <div class="x_panel">
            <div class="x_title">
               <h2>Add Gallery</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">


               <form method="post" action="<?php echo base_url(); ?>news/add_update_gallery" class="form-horizontal" enctype="multipart/form-data">

                  
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align">Select Photos <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<input type="file" name="news_photos[]" id="news_photos" class="form-control" accept="image/*" multiple required><span class="required" style="font-size:11px;font-weight:normal;">1400 * 800 px</span>
						</div>
					</div>
                  
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
						<input type="hidden" name="news_id" value=<?php echo $res_news->id;  ?>>
						<button class="btn btn-success" id='news_gallery'>Upload</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>


	</div>
	
	
	
	<div class="row">
	
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>View Gallery</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			<?php if(empty($res_img)){
					echo "No Gallery Found";
				}else{
					foreach($res_img as $rows){ ?>
					<div class="col-lg-3" style="margin-bottom:25px;">
					<div id="thumbnail">
						<img src="<?php echo base_url(); ?>assets/news/<?php echo $rows->image_file_name; ?>" class="img-responsive" style="width:225px;height:129px;">
						<a id="close" onclick="return confirm('Are you sure?')? delgal(<?php echo $rows->id; ?>):'';" data-toggle="tooltip" title="Delete" style="cursor:pointer"></a>
						</a>
					</div>
				</div>
				<?php
					}
			  } ?>
            </div>
         </div>
      </div>


	</div>
	
	</div>
	
   </div>
</div>
<style>
.thumbnail {
        position: relative;
        width: 200px;
        height: 300px;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
    }

    #close {
        display: block;
        position: absolute;
        width: 25px;
        height: 25px;
        top: -10px;
        left: 225px;
        background: url(<?php echo base_url(); ?>assets/images/delete_icon.png);
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }
}
</style>
<script type="text/javascript">
	$('#news_menu').addClass('active');
   $('.news_menu').css('display','block');
   $('#list_news_menu').addClass('active current-page')
   
    function delgal(news_gal_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>news/delete_gal",
            data: {
                news_gal_id: news_gal_id
            },
            success: function(response) {
                if (response == 'success') {
                    $.toast({
                        heading: 'Image deleted',
                        text: '',
                        position: 'mid-center',
                        icon: 'success',
                        stack: false
                    })
                    window.setTimeout(function() {
                        location.reload()
                    }, 2000);
                } else {
                    $.toast({
                        heading: 'Error',
                        text: response,
                        position: 'mid-center',
                        icon: 'error',
                        stack: false
                    })
                }
            }
        });

    }

    $("#news_gallery").click(function() {
        for (var i = 0; i < $("#news_photos").get(0).files.length; ++i) {
            var file1 = $("#news_photos").get(0).files[i].name;

            if (file1) {
                var file_size = $("#news_photos").get(0).files[i].size;
                if (file_size < 1000000) {
                    var ext = file1.split('.').pop().toLowerCase();
                    if ($.inArray(ext, ['jpg', 'jpeg', 'png']) === -1) {
                        alert("Invalid file extension");
                        return false;
                    }

                } else {
                    alert("Images size should be less than 1 MB.");
                    return false;
                }
            } else {
                alert("Select Gallery image..");
                return false;
            }
        }
    });
</script>
