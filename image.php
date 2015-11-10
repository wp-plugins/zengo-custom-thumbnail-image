<?php
/*
Plugin Name: Zengo Custom Thumbnail Image
Plugin URI: http://www.zengo-web-services.com
Version: 1.0.2
Author: Zengo Web Services
Description: Separate Thumbnail Image from Main Image, Custom Gallery Image Size by Zengo Web Services.
*/
function register_zengo_custom_submenu_page(){
	add_submenu_page( 'options-general.php', 'Zengo Custom Thumbnail Image', 'Zengo Custom Thumbnail Image', 'manage_options', 'zengo-gallery', 'zengo_gallery_callback' );
}
add_action('admin_menu', 'register_zengo_custom_submenu_page');
/*Add menu in admin panel for upload_sports_icon end*/
function zengo_gallery_callback(){
/*Dynamic Height-Width start*/
$height = "150";
$width = "150";
$max_height = "200";
$max_width = "200";
$min_height = "200";
$min_width = "200";
if(isset($_POST['setting']) && $_POST['setting']=='SAVE'){
	$width = sanitize_text_field($_POST['zengo-gallery-width']);
	$height = sanitize_text_field($_POST['zengo-gallery-height']);
	$max_width = sanitize_text_field($_POST['zengo-gallery-max-width']);
	$max_height = sanitize_text_field($_POST['zengo-gallery-max-height']);
	$min_width = sanitize_text_field($_POST['zengo-gallery-min-width']);
	$min_height = sanitize_text_field($_POST['zengo-gallery-min-height']);
	
	$customthumb_attribute = get_option("customthumb_attribute");
	if(!empty($customthumb_attribute))
	{
		unset($customthumb_attribute['height']);
		unset($customthumb_attribute['width']);
		unset($customthumb_attribute['max_height']);
		unset($customthumb_attribute['max_height']);
		unset($customthumb_attribute['min_height']);
		unset($customthumb_attribute['min_height']);
	}
	$customthumb_attribute['height'] = strtolower($height);
	$customthumb_attribute['width'] = strtolower($width);
	$customthumb_attribute['max_height'] = strtolower($max_height);
	$customthumb_attribute['max_width'] = strtolower($max_width);
	$customthumb_attribute['min_height'] = strtolower($min_height);
	$customthumb_attribute['min_width'] = strtolower($min_width);
	update_option("customthumb_attribute",$customthumb_attribute);
	$save = "true";
}
/*Dynamic Height-Width End*/

/*Delete Code Start*/
if(isset($_GET['action']) && $_GET['action'] == "delete"){
	$name = $_GET['dname'];
	$did = $_GET['did'];
	$customthumb = get_option("customthumb");
	if(!empty($customthumb))
	{
		array_splice( $customthumb,0,0);
		if($customthumb[$did-1]['title'] == $name){
			unset($customthumb[$did-1]);
			array_splice( $customthumb,0,0);
			$deleted = "true";
		}
		update_option("customthumb",$customthumb);
	}
}
/*Delete Code End*/
	
/*Edit Code Start*/
if(isset($_GET['action']) && $_GET['action'] == "edit"){
	$name = $_GET['dname'];
	$did = $_GET['did'];
	$customthumb = get_option("customthumb");
	array_splice( $customthumb,0,0);
	if(!empty($customthumb)){
		if($customthumb[$did-1]['title'] == $name){
			$thumbnail = $customthumb[$did-1]['thumbnail'];
			$main = $customthumb[$did-1]['image'];
		}
	}
}

if(isset($_POST['edit']) && $_POST['edit'] == "MODIFY"){
	$customthumb = get_option("customthumb");
	array_splice( $customthumb,0,0);
	if(!empty($customthumb))
	{
		$name = sanitize_text_field($_POST['title']);
		$did = sanitize_text_field($_POST['did']);
		$thumbnail = sanitize_text_field($_POST['img21']);
		$main = sanitize_text_field($_POST['img31']);
		$customthumb[$did-1] = array(
			'title' => $name,
			'thumbnail' => $thumbnail,
			'image' => $main);
		update_option("customthumb",$customthumb);
		$edit = "true";
	}
}
/*Edit Code End*/
	
/*Add New Code Start*/
if(isset($_POST['add']) && $_POST['add'] == "ADD"){
		$title = sanitize_text_field(preg_replace('/[^A-Za-z0-9 \-]/', '', $_POST['title']));
		$thumbnail = sanitize_text_field($_POST['img2']);
		$image = sanitize_text_field($_POST['img3']);
		$success = "";		
		$Image_Details = array(
				'title' => $title,
				'thumbnail' => $thumbnail,
				'image' => $image);
				
		$customthumb = get_option("customthumb");
		
		if(!empty($customthumb))
		{
			$count = count($customthumb);
			$priority = $count;
			array_splice( $customthumb, $priority, 0, array($Image_Details));
			update_option("customthumb",$customthumb);
			$success = "true";
		}
		else
		{
			update_option("customthumb",array($Image_Details));
			$success = "true";
		}
}
/* Add New Code End */

/* Thumbnail Image Setting Start */
$Img = plugins_url("/images/No_Image.jpg", __FILE__);
function load_custom_wp_admin_style() {
		wp_register_style('tabcontent.css', plugins_url("/css/tabcontent.css", __FILE__), false, '1.0.0' );
		wp_enqueue_style('tabcontent.css');
		
		wp_register_style('main.css', plugins_url("/css/main.css", __FILE__), false, '1.0.0' );
		wp_enqueue_style('main.css');
		
		wp_enqueue_script( 'zentabcontent.js', plugins_url('/js/zentabcontent.js', __FILE__), array(), '1.0.0', true );
}
add_action('admin_enqueue_scripts','load_custom_wp_admin_style');

do_action('admin_enqueue_scripts');

?>

<h1>Zengo Custom Thumbnail Image Gallery Setting</h1>
<?php
/*Notifications Display Start */
if($success == "true"){ ?>
					<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong><?php echo $title; ?> ADDED SUCCESSFULLY! </strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }
				if($empty == "true"){ ?>
					<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong>Please Enter All Details.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }
				if($deleted == "true"){
					?>
					<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong><?php echo $name; ?> DELETED SUCCESSFULLY. </strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }
				if($save == "true"){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong> SETTINGS SAVED. </strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }

if($edit == "true"){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong><?php echo $name; ?> EDITED SUCCESSFULLY. </strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }

/*Notifications Display end */
?>
  <div style="width: 95%; margin: 0 auto; padding: 40px 0 40px;">
        <ul class="tabs" data-persist="true">
            <li><a href="#view1">Upload Images</a></li>
            <li><a href="#view3">Images Setting</a></li>
            <li><a href="#view5">Gallery Setting</a></li>
            <li><a href="#view2">Shortcode Generator</a></li>
			<li><a href="#view4">How to use it?</a></li>
        </ul>
        
        <div class="tabcontents">
            <div id="view1">
				<h2>Upload Images For Zengo Gallery</h2>
                <p>
						<div>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=add" method="post">
								<table class="zengo-table">
									<tr>
										<th align="left" class="zengo-table">Title</th>
										<td align="center" class="zengo-table">:</td>
										<td colspan="2" class="zengo-table"><input type="text" name="title" id="title" required="required" class="regular-text">(Special charecters will be Ignored.)</td>
									</tr>
									<tr>
										<th align="left" class="zengo-table">Select Thumbnail Image</th>
										<td align="center" class="zengo-table">:</td>
										<td class="zengo-table"><input type="text" name="img2" id="img2" required="required" class="regular-text" value="<?php echo $Img; ?>" ><input type="button" name="upload-btn-img2" id="upload-btn-img2" class="button-primary" value="Upload Image" data-id="img2"></td>
										<td class="zengo-table"  align="center"><img style="max-height:150px; max-width:300px;"  name="Img2" id="Img2" src="<?php echo $Img; ?>"  /> </td>
									</tr>
									<tr>
										<th align="left" class="zengo-table">Select Main Image</th>
										<td align="center" class="zengo-table">:</td>
										<td class="zengo-table"><input type="text" name="img3" id="img3" required="required" class="regular-text" value="<?php echo $Img; ?>" >
										<input type="button" name="upload-btn-img3" id="upload-btn-img3" class="button-primary" value="Upload Image" data-id="img3"></td>
										<td class="zengo-table"  align="center"><img style="max-height:150px; max-width:300px;"  name="Img3" id="Img3" src="<?php echo $Img; ?>"  /> </td>
									</tr>
									<tr>
										<td class="zengo-table" colspan="5"> <input id="submit_button" type="submit" value="ADD" name="add" class="zengo-save-btn"></td>
									</tr>
									<tr>
										<td colspan="4"><strong>NOTE: Use shortcode Generator to display gallery in page.</strong></td>
									</tr>
								</table>
							</form>
						</div>
				</p>
            </div>
            
            <div id="view5">
			<h2>Zengo Gallery Setting</h2>
			<h4>This setting will affects only when 'NORMAL' view selected in Gallery Display Style.</h4>
				<p><?php
						$customthumb_attribute = get_option("customthumb_attribute");
						if(!empty($customthumb_attribute))
						{
							$height = $customthumb_attribute['height'];
							$width = $customthumb_attribute['width'];
							$max_height = $customthumb_attribute['max_height'];
							$max_width = $customthumb_attribute['max_width'];
						}
					?>
					<form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=setting" method="post">
						<table class="zengo-table">
							<tr>
								<th class="zengo-table">Height :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-height" id="zengo-gallery-height" value="<?php echo $height; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<th class="zengo-table">Width :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-width" id="zengo-gallery-width" value="<?php echo $width; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<th class="zengo-table">Max Height :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-max-height" id="zengo-gallery-max-height" value="<?php echo $max_height; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<th class="zengo-table">Max Width :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-max-width" id="zengo-gallery-max-width" value="<?php echo $max_width; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<th class="zengo-table">Min Height :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-min-height" id="zengo-gallery-min-height" value="<?php echo $min_height; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<th class="zengo-table">Min Width :</th>
								<td class="zengo-table"><input type="text" name="zengo-gallery-min-width" id="zengo-gallery-min-width" value="<?php echo $min_width; ?>">px <strong>(Example: 100, 200, auto)</strong></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" name="setting" value="SAVE" class="zengo-save-btn"></td>
							</tr>
						</table>
					</form>
				</p>
			</div>
				
			
			
            <div id="view2">
				<h2>Shortcode Generator</h2>
                <p><?php require('shortcode.php'); ?></p>
			</div>

            <div id="view3">
					<h2>Zengo Gallery Images Setting</h2>
					<p>
					<?php
							if(isset($_GET['action']) && $_GET['action'] == "edit"){
							?>
							<div>
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=modified" method="post">
									<h3>Edit Details of <?php echo $name; ?></h3>
									<table  class="zengo-table">
										<tr>
											<th align="left" class="zengo-table">Title</th>
											<td align="center" class="zengo-table">:</td>
											<td colspan="2" class="zengo-table"><input type="text" name="title" id="title" value="<?php echo $name; ?>" required="required" class="regular-text"><input type="hidden" name="did" value="<?php echo $did; ?>"></td>
										</tr>
										<tr>
											<th align="left" class="zengo-table">Select Thumbnail Image</th>
											<td align="center" class="zengo-table">:</td>
											<td class="zengo-table"><input type="text" name="img21" id="img21" required="required" class="regular-text" value="<?php echo $thumbnail; ?>" ><input type="button" name="upload-btn-img21" id="upload-btn-img21" class="button-primary" value="Upload Image" data-id="img21"></td>
											<td class="zengo-table"  align="center"><img style="max-height:150px; max-width:300px;"  name="Img21" id="Img21" src="<?php echo $thumbnail; ?>"  /> </td>
										</tr>
										<tr>
											<th align="left" class="zengo-table">Select Main Image</th>
											<td align="center" class="zengo-table">:</td>
											<td class="zengo-table"><input type="text" name="img31" id="img31" required="required" class="regular-text" value="<?php echo $main; ?>" ><input type="button" name="upload-btn-img31" id="upload-btn-img31" class="button-primary" value="Upload Image" data-id="img31"></td>
											<td class="zengo-table"  align="center"><img style="max-height:150px; max-width:300px;" id="Img31" src="<?php echo $main; ?>"  /> </td>
										</tr>
										<tr>
											<td class="zengo-table" colspan="5"> <input id="submit_button" type="submit" value="MODIFY" name="edit" class="zengo-save-btn"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=cancel" style="text-decoration:none; cursor:pointer;">   <input type="button" name="cancel" value="CANCEL" type="button" class="zengo-save-btn" style="cursor:pointer;"></a></td>
										</tr>
									</table>
								</form>
							</div>
							<br/>
							<?php 
							}
							$customthumb = get_option("customthumb");
							if(!empty($customthumb)){
							?>
					<section class="">
					  <div class="zengo-container zengo-scroll-tab zengo-col-1">
						<table class="">
						  <thead>
							<tr class="header">
								<th class="zengo-table1"><div>No.</div></th>
								<th class="zengo-table1"><div>Title</div></th>
								<th class="zengo-table1"><div>Thumbnail Image</div></th>
								<th class="zengo-table1"><div>Main Image</div></th>
								<th class="zengo-table1"><div>Edit</div></th>
								<th class="zengo-table1"><div>Delete</div></th>
							</tr>
						 </thead>
						 <tbody>
							<?php
								$customthumb = get_option("customthumb");
								$i=1;
								foreach($customthumb as $customthumb)
								{ ?>
								<tr>
									<td align="center"><?php echo $i; ?></td>
									<td><?php echo $customthumb[title]; ?></td>
									<td align="center"><img style="height:100px; max-width:300px;" align="center" src="<?php echo $customthumb[thumbnail]; ?>" ></td>
									<td align="center"><img style="height:100px; max-width:300px;" align="center" src="<?php echo $customthumb[image]; ?>" ></td>
									<td align="center"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=edit&dname=<?php echo $customthumb[title]; ?>&did=<?php echo $i; ?>'>Edit</a></td>
									<td align="center"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery&action=delete&dname=<?php echo $customthumb[title]; ?>&did=<?php echo $i; ?>'>Delete</a></td>
								</tr>
								<?php
									$i++;
								}
								?>
							</tbody>
						</table>
					</div>
				</section>
			<?php 
				}
				else
				{
					echo "No Images. Please Upload Some Images";
				} ?>
			</p>
		</div>
		<div id="view4">
			<h3>How to use it?</h3>
			<p>Generate Shortcode from 'Shortcode Generator'.<br/> Copy generated shortcode and paste it to the page where you want to display gallery.</p>
		</div>
	</div>
</div>
<?php
	// jQuery
	wp_enqueue_script('jquery');
	// This will enqueue the Media Uploader script
	wp_enqueue_media();
	wp_enqueue_script( 'zenupload.js', plugins_url('/js/zenupload.js',__FILE__) , array(), '1.0.0', true );
}
require('display.php'); ?>
