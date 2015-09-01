<?php
function zengo_gallery($atts){
ob_start();
wp_enqueue_style('demo.css', plugins_url("/css/demo.css", __FILE__));
wp_enqueue_style('style.css', plugins_url("/css/style.css", __FILE__));
$height = "100px";
$width = "100px";
$customthumb_attribute = get_option("customthumb_attribute");
if(!empty($customthumb_attribute))
{
	if($customthumb_attribute['height'] == "auto")
	{
		$height = $customthumb_attribute['height'];
	}
	else
	{
		$height = $customthumb_attribute['height']."px";
	}
	
	if($customthumb_attribute['width'] == "auto")
	{
		$width = $customthumb_attribute['width'];
	}
	else
	{
		$width = $customthumb_attribute['width']."px";
	}
}
?>
<style>
<?php
if($width == "auto" || $height == "auto"){
	echo "a .zengo_clearfix";
}
else{
	echo "a .zengo_clearfix, .lb-album li > a span";
}
?>
{
	margin: 2px;
	height: <?php echo $height; ?>;
	min-height: <?php echo $height; ?>;
	width: <?php echo  $width; ?>;
	min-width: <?php echo  $width; ?>;
}
</style>
<div class="zengo_gallery">
	<div class="container">
		<section>
			<?php
			$customthumb = get_option("customthumb");
			$count = count($customthumb);
			$i = 1;
			foreach($customthumb as $customthumb)
			{
			?>
			<ul class="lb-album">
				<li>
					<a href="#image-<?php echo $i; ?>">
						<img class="zengo_clearfix" src="<?php echo $customthumb['thumbnail']; ?>" alt="<?php echo $customthumb['title']; ?>">
						<span><?php echo $customthumb['title']; ?></span>
					</a>
					<div class="lb-overlay" id="image-<?php echo $i; ?>">
						<img src="<?php echo $customthumb['image']; ?>" alt="<?php echo $customthumb['title']; ?>" />
						<div>
							<h3><?php echo $customthumb['title']; ?></h3>
							<?php if($i != 1){ ?>
							<a href="#image-<?php echo $i-1; ?>" class="lb-prev">Prev</a>
							<?php } if($count != $i){ ?>
							<a href="#image-<?php echo $i+1; ?>" class="lb-next">Next</a>
							<?php } ?>
						</div>
						<a href="#page" class="lb-close">x Close</a>
					</div>
				</li>
			</ul>
			<?php
			$i++;
			}
		?>
		</section>
	</div>
</div>
<?php

// Attributes
extract( shortcode_atts(
	array(
		'id' => '',
	), $atts )
);

// Code
if(isset($id)){
	echo $id;
}

return ob_get_clean();
}
add_shortcode( 'zengo_gallery' , 'zengo_gallery' ); ?>