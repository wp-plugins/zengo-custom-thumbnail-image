<?php
function zengo_gallery($atts){
ob_start();

// Attributes
extract(shortcode_atts(
	array(
		'display_style' => '',
	),$atts)
);

wp_enqueue_style('demo.css', plugins_url("/css/demo.css", __FILE__));
wp_enqueue_style('style.css', plugins_url("/css/style.css", __FILE__));
// Code
if($display_style == "pinterest"){
	wp_enqueue_style('pin.css', plugins_url("/css/pin.css", __FILE__));
?>
<div class="zengo-container1">
  <div id="main-search-zengo-pin">
	<div id="zengo-columns">
		<section>
			<?php
			$customthumb = get_option("customthumb");
			$count = count($customthumb);
			$i = 1;
			foreach($customthumb as $customthumb)
			{
			?>
			<div class="zengo-pin">
			<ul class="zengo-lb-album1">
				<li>
					<a href="#image-<?php echo $i; ?>">
						<img src="<?php echo $customthumb['thumbnail']; ?>" alt="<?php echo $customthumb['title']; ?>">
						<span><?php echo $customthumb['title']; ?></span>
					</a>
					<div class="zengo-lb-overlay" id="image-<?php echo $i; ?>">
						<img src="<?php echo $customthumb['image']; ?>" alt="<?php echo $customthumb['title']; ?>" />
						<div>
							<h3><?php echo $customthumb['title']; ?></h3>
							<?php if($i != 1){ ?>
							<a href="#image-<?php echo $i-1; ?>" class="zengo-lb-prev">Prev</a>
							<?php } if($count != $i){ ?>
							<a href="#image-<?php echo $i+1; ?>" class="zengo-lb-next">Next</a>
							<?php } ?>
						</div>
						<a href="#zengo-page" class="zengo-lb-close">CLOSE</a>
					</div>
				</li>
			</ul>
			</div>
			<?php
			$i++;
			}
		?>
		</section>
	</div>
  </div>
</div>
<?php
}
else{
	$customthumb_attribute = get_option("customthumb_attribute");
	if(!empty($customthumb_attribute))
	{
		if($customthumb_attribute['height'] == "auto")
		{
			 $height = $customthumb_attribute['height'];
		}
		else if(!empty($customthumb_attribute['height']))
		{
			 $height = $customthumb_attribute['height']."px"; 
		}
		else
		{
			 $height = "100px"; 
		}
		
		if($customthumb_attribute['width'] == "auto")
		{
			$width = $customthumb_attribute['width'];
		}
		else if(!empty($customthumb_attribute['width']))
		{
			$width = $customthumb_attribute['width']."px";
		}
		else
		{
			$width = "100px";
		}
		
		if($customthumb_attribute['max_height'] == "auto")
		{
			 $max_height = $customthumb_attribute['max_height'];
		}
		else if(!empty($customthumb_attribute['max_height']))
		{
			 $max_height = $customthumb_attribute['max_height']."px"; 
		}
		else
		{
			 $max_height = "200px"; 
		}
		
		if($customthumb_attribute['max_width'] == "auto")
		{
			$max_width = $customthumb_attribute['max_width'];
		}
		else if(!empty($customthumb_attribute['max_width']))
		{
			$max_width = $customthumb_attribute['max_width']."px";
		}
		else
		{
			$max_width = "200px";
		}
		
		if($customthumb_attribute['min_height'] == "auto")
		{
			 $min_height = $customthumb_attribute['min_height'];
		}
		else if(!empty($customthumb_attribute['min_height']))
		{
			 $min_height = $customthumb_attribute['min_height']."px"; 
		}
		else
		{
			 $min_height = "200px"; 
		}
		
		if($customthumb_attribute['min_width'] == "auto")
		{
			$min_width = $customthumb_attribute['min_width'];
		}
		else if(!empty($customthumb_attribute['min_width']))
		{
			$min_width = $customthumb_attribute['min_width']."px";
		}
		else
		{
			$min_width = "200px";
		}
	}
	else
	{
		$height = "150px";
		$width = "150px";
		$max_height = "200px";
		$max_width = "200px";
		$min_height = "100px";
		$min_width = "100px";
	}
	
	if(intval($max_width) < intval($min_width)){
		$min_width = $max_width;
	}
	
	if(intval($max_height) < intval($min_height)){
		$min_height = $max_height;
	}
	?>
	<style>
	<?php
	if($width == "auto" || $height == "auto"){
		?>
		a .zengo_clearfix
		{
			height: <?php echo $height; ?>;
			min-height: <?php echo $min_height; ?>;
			max-height: <?php echo $max_height; ?>;
			width: <?php echo $width; ?>;
			min-width: <?php echo $min_width; ?>;
			max-width: <?php echo $max_width; ?>;
		}
		<?php
	}
	else{
	?>
		a .zengo_clearfix
		{
			height: <?php echo $height; ?>;
			min-height: <?php echo $min_height; ?>;
			max-height: <?php echo $max_height; ?>;
			width: <?php echo $width; ?>;
			min-width: <?php echo $min_width; ?>;
			max-width: <?php echo $max_width; ?>;
		}
		.zengo-lb-album li > a span
		{
			height: <?php echo $height; ?>;
			min-height: <?php echo $min_height; ?>;
			width: <?php echo $width; ?>;
			min-width: <?php echo $min_width; ?>;
		}
		.zengo-lb-album li > a
		{
			border-bottom: none;
		}
	<?php 
	}
	?>
	</style>
	<div class="zengo_gallery">
		<div class="zengo-container">
			<section>
				<?php
				$customthumb = get_option("customthumb");
				$count = count($customthumb);
				$i = 1;
				foreach($customthumb as $customthumb)
				{
				?>
				<ul class="zengo-lb-album">
					<li>
						<a href="#image-<?php echo $i; ?>">
							<img class="zengo_clearfix" src="<?php echo $customthumb['thumbnail']; ?>" alt="<?php echo $customthumb['title']; ?>">
							<span><?php echo $customthumb['title']; ?></span>
						</a>
						<div class="zengo-lb-overlay" id="image-<?php echo $i; ?>">
							<img src="<?php echo $customthumb['image']; ?>" alt="<?php echo $customthumb['title']; ?>" />
							<div>
								<h3><?php echo $customthumb['title']; ?></h3>
								<?php if($i != 1){ ?>
								<a href="#image-<?php echo $i-1; ?>" class="zengo-lb-prev">Prev</a>
								<?php } if($count != $i){ ?>
								<a href="#image-<?php echo $i+1; ?>" class="zengo-lb-next">Next</a>
								<?php } ?>
							</div>
							<a href="#zengo-page" class="zengo-lb-close">x Close</a>
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
}

return ob_get_clean();
}
add_shortcode( 'zengo_gallery' , 'zengo_gallery' );
add_filter('widget_text', 'do_shortcode');
?>
