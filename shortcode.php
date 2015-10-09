<div class="d-main">
	<?php
		if(isset($_POST['generate']) && $_POST['generate'] == "Generate"){
			$display_style = $_POST['display_style'];
		}
	?>
	<script>
		jQuery(document).ready(function(){
			jQuery(".z_sht_code").each(function(){
				jQuery(this).hover(function(){
				  jQuery(this).select();
				});
				jQuery(this).click(function(){
				  jQuery(this).select();
				});
			});
		});
	</script>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=zengo-gallery" method="post">
		<table>
			<tr>
				<td align="left"><strong>Select Gallery Display Style:   </strong>
						<input type="radio" id="352" value="normal" name="display_style" checked>
						<label for="352">Normal</label>
						<input type="radio" id="351" value="pinterest" name="display_style">
						<label for="351">Pinterest</label>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="generate" id="generate" value="Generate"></td>
			</tr>
		</table>
	</form>
	<div class="shrt-code">
	<?php
	if(isset($_POST['generate']) && $_POST['generate'] == "Generate"){ ?>
		<h4>Shortcode: <input readonly type="text" id="sht_code" name="sht_code" class="z_sht_code" value="<?php echo '[zengo_gallery display_style=&quot;'.$display_style.'&quot;]'; ?>" ></h4>
		<p><strong>NOTE:</strong> Copy this shortcode and paste it to the page where you want to display gallery.</p>
<?php
	}
	?>
	</div>
</div>
