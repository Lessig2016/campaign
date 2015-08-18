<?php

$mk_artbees_products = new mk_artbees_products();

?>
<div class="wp-install-template">
<?php if ($mk_artbees_products->is_verified_artbees_customer()) : ?>
	<div class="install-template">
		<div class="template-uploader">
			<h1>Install Templates</h1>
			<div class="uploader-box uploader" id="drag-and-drop-zone">
				<div class="uploader-box-inside">
					<i class="ic-arrow-down"></i>
					<h2>Drag your template file here</h2>
					<input type="file" id="upload-btn" name="files[]" class="upload-btn" title="Browser Your Computer" />
					<?php wp_nonce_field('abb_install_template_nonce', 'abb_install_template_security'); ?>
				</div>
			</div>
		</div>
<div id="fileList">
<!-- Files will be placed here -->
</div>
		<div class="current-template">
			<h3>Current Templates</h3>
			<?php $mk_artbees_products->install_template_warnings(); ?>
			<div class="template-list" id="template-list">
				<?php $mk_artbees_products->get_list_of_templates(); ?>
			</div>
		</div>
		<hr/>
		<div class="how-to">
			<h3>How to Install Templates</h3>
			<ul class="decimal">
				<li><a href="http://artbees.net/themes/template" target="_blank">Select and download</a> your desired template.</li>
				<li>Locate the downloaded file in your computer and Drag it into the upper section.</li>
			</ul>
			<div class="how-to-video-list">
				<div class="video-item">
					<a target="_blank" href="https://www.youtube.com/watch?v=8V7LSmCvf9g">
						<img src="<?php echo THEME_DIR_URI; ?>/demo-importer/images/install-template-tuts-video.jpg" alt="">
						<i class="ic-play"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php else : 
		$mk_artbees_products->get_unverfied_view();
		endif; // End for is_verified_artbees_customer ?>
</div>


<script type="text/javascript">
jQuery(document).ready(function($){

	var $uploader = $( '.uploader' ),
		dragging = false,
		activeClass = 'is-drag';

	$uploader.on( 'dragover', doEnter );
	$uploader.on( 'dragleave', doLeave );

	function doEnter() { 
		$uploader.addClass( activeClass );
	} 

	function doLeave() {
		$uploader.removeClass( activeClass );
	}



	function add_log(message)
	{
		console.log(new Date().getTime() + ': ' + message);
	}

	function add_file(id, file)
	{
		var file_name = file.name;
		var clean_name = file_name.replace(/.zip/g, "");


		var template = '' +
		'<div class="file" id="uploadFile' + id + '">' +
		'<div class="info">' +
		  '<span class="filename" title="Size: ' + file.size + 'bytes - Mimetype: ' + file.type + '">' + clean_name + ' Template</span><br /><small><span class="status">Waiting</span></small>' +
		'</div>' +
		'<div class="bar">' +
		  '<div class="progress" style="width:0%"></div>' +
		'</div>' +
		'</div>';

		$('#fileList').prepend(template);
	}

	function update_file_status(id, status, message)
	{
		$('#uploadFile' + id).find('span.status').html(message).addClass(status);
	}

	function update_file_progress(id, percent)
	{
		$('#uploadFile' + id).find('div.progress').width(percent);
	}

	// Upload Plugin itself
	$('#drag-and-drop-zone').dmUploader({
		url: "<?php echo admin_url('admin-ajax.php'); ?>",
		dataType: 'json',
		allowedTypes: '*',
		extraData: {
			action : 'abb_install_template_action',
			abb_install_template_security : $("#abb_install_template_security").val()
		},
		onInit: function(){
		  add_log('File uploader initialized');
		},
		onBeforeUpload: function(id){
		  add_log('Starting the upload of #' + id);
		  
		  update_file_status(id, 'uploading', 'Uploading...');
		},
		onNewFile: function(id, file){
		  doLeave();
		  add_log('New file added to queue #' + id);
		  
		  add_file(id, file);
		},
		onComplete: function(){
		  add_log('All pending tranfers finished');
		},
		onUploadProgress: function(id, percent){
		  var percentStr = percent + '%';

		  update_file_progress(id, percentStr);
		},
		onUploadSuccess: function(id, data){

			add_log('Upload of file #' + id + ' completed');

			add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));

			update_file_status(id, 'success', 'Upload Completed');

			update_file_progress(id, '100%');

			$.ajax({
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				type: "POST",
				data: "action=abb_get_templates_action",
				success: function (res) {
					$("#template-list").html(res);
					mk_import_demos();
					mk_delete_template();
				}
			});
		},
		onUploadError: function(id, message){
			add_log('Failed to Upload file #' + id + ': ' + message);
			
			update_file_status(id, 'error', message);
		},
		onFileTypeError: function(file){
			add_log('File \'' + file.name + '\' cannot be added: must be a .zip archive');
		},
		onFileSizeError: function(file){
			add_log('File \'' + file.name + '\' cannot be added: size excess limit');
		},
		onFallbackMode: function(message){
			alert('Browser not supported(do something else here!): ' + message);
		}
});

	function mk_import_demos() {
		 $('.mk-import-content-btn').click(function(e){

	            var $serilized = 'template=' + $(this).parents('form').find("input[name='template']").val() +'&';

	            $serilized += $(this).parents('form').find("input[type='checkbox']").map(function(){return this.name+"="+this.checked;}).get().join("&");            

	           var $import_true = confirm('Are you sure to import dummy content? We highly encourage you to do this action in a fresh WordPress installation!');
	            
	            if($import_true == false) return false;

	            $('.import_message').html('<div class="updated settings-error"><div class="import-content-loading">Please be patient while template is being imported. This process may take a couple of minutes.</div></div>');

	       var data = {
	            action: 'abb_import_demo_action',
	            options: $serilized
	        };

	        $.post(ajaxurl, data, function(response) {
	            $('.import_message').html('<div class="updated settings-error">'+ response +'</div>');
	        });
	         $("html, body").animate({ scrollTop: 0 }, "fast");

	        e.preventDefault();
	    });
	}
	mk_import_demos();

	function mk_delete_template()
	{
		
		$('.mk-delete-template-btn').click(function(e){

	           var $delete_template = confirm('Are you sure to delete this template from your server?');
	            
	            if($delete_template == false) return false;

	       var data = {
	            action: 'abb_delete_template',
	            abb_install_template_security : $("#abb_install_template_security").val(),
	            template : $(this).parents('form').find("input[name='template']").val()
	        };

	        $.post(ajaxurl, data, function(response) {
	           $("#template-list").html(response);
	           mk_delete_template();
	           mk_import_demos();
	        });

	        e.preventDefault();
	    });
	}
	mk_delete_template();
});

</script>