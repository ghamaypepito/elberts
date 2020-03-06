<?php add_action( 'admin_menu', 'toast_add_admin_menu' );
function toast_add_admin_menu(){ 
add_submenu_page( 'options-general.php', 'Sticky Items on Scroll', 'Sticky Items on Scroll', 'manage_options', 'toast_sticky_items', 'toast_si_options_page' );
}
function toast_si_options_page(){ 

	?>
	<div class="wrap">
	<h2>Sticky Anything <span class="toast-version-number">Version 2.0.2</span></h2>
	<div class="toast-wrap">
		
		<div class="toast-main-content">
		
		<div class="green-wrapper">
		<div class="sticky-element-form">
		<?php $options = get_option( 'toastsi_settings' ); ?>
		<div class="element-option">
		<label>Element name</label>
		<input type="text" id="row-item">
		</div>
		
		<div class="element-option">
		<label>Element margin top</label>
		<select id="row-margin-top">
		<option value="0" <?php if($options['toastsi_offset_top'] == 0): ?>selected<?php endif; ?>>No Margin</option>
		<option value="10" <?php if($options['toastsi_offset_top'] == 10): ?>selected<?php endif; ?>>10px</option>
		<option value="20" <?php if($options['toastsi_offset_top'] == 20): ?>selected<?php endif; ?>>20px</option>
		<option value="30" <?php if($options['toastsi_offset_top'] == 30): ?>selected<?php endif; ?>>30px</option>
		<option value="50" <?php if($options['toastsi_offset_top'] == 50): ?>selected<?php endif; ?>>50px</option>
		<option value="70" <?php if($options['toastsi_offset_top'] == 70): ?>selected<?php endif; ?>>70px</option>
		<option value="80" <?php if($options['toastsi_offset_top'] == 80): ?>selected<?php endif; ?>>80px</option>
		<option value="90" <?php if($options['toastsi_offset_top'] == 90): ?>selected<?php endif; ?>>90px</option>
		<option value="100" <?php if($options['toastsi_offset_top'] == 100): ?>selected<?php endif; ?>>100px</option>
		<option value="150" <?php if($options['toastsi_offset_top'] == 150): ?>selected<?php endif; ?>>150px</option>
		<option value="200" <?php if($options['toastsi_offset_top'] == 200): ?>selected<?php endif; ?>>200px</option>
		<option value="250" <?php if($options['toastsi_offset_top'] == 250): ?>selected<?php endif; ?>>250px</option>
		<option value="300" <?php if($options['toastsi_offset_top'] == 300): ?>selected<?php endif; ?>>300px</option>
		<option value="350" <?php if($options['toastsi_offset_top'] == 350): ?>selected<?php endif; ?>>350px</option>
		<option value="400" <?php if($options['toastsi_offset_top'] == 400): ?>selected<?php endif; ?>>400px</option>
		<option value="500" <?php if($options['toastsi_offset_top'] == 500): ?>selected<?php endif; ?>>500px</option>
		</select>
		</div>
		
		<div class="element-option">
		<label>Minimum screen width</label>
		<select id="row-screen-width">
		<option value="0" <?php if($options['toastsi_min_width'] == 0): ?>selected<?php endif; ?>>Any Screen Width</option>
		<option value="400" <?php if($options['toastsi_min_width'] == 400): ?>selected<?php endif; ?>>400px</option>
		<option value="550" <?php if($options['toastsi_min_width'] == 550): ?>selected<?php endif; ?>>550px</option>
		<option value="768" <?php if($options['toastsi_min_width'] == 768): ?>selected<?php endif; ?>>768px</option>
		<option value="1024" <?php if($options['toastsi_min_width'] == 1024): ?>selected<?php endif; ?>>1024px</option>
		<option value="1400" <?php if($options['toastsi_min_width'] == 1400): ?>selected<?php endif; ?>>1400px</option>
		</select>
		</div>
		
		<div class="element-option">
		<label>Parent block sticking?</label>
		<input type="checkbox" id="row-parent-stop">
		</div>
		
		<div class="element-option">
		<a class="button add-sticky-item">Add sticky item</a>
		</div>
		</div>
		</div>

		<input type="hidden" name="toastsi-json" value='<?php echo stripslashes(get_option('toastsi-json')); ?>'>

		<table class="sticky-items-table">
				<?php $sticky_items = json_decode(stripslashes(get_option('toastsi-json'))); ?>
				<thead>
				<th>Class / ID / Tag</div>
				<th>Element Margin Top</div>
				<th>Min. screenwidth</div>
				<th>Parent Block Sticking?</div>
				<th>Remove?</div>
				</thead>
				<tbody>
				<?php foreach($sticky_items as $sticky_item): ?>
				<tr>
				<td>
				<?php echo $sticky_item->name; ?>
				</td>
				<td>
				<?php echo $sticky_item->margintop; ?>
				</td>
				<td>
				<?php echo $sticky_item->screenwidth; ?>
				</td>
				<td>
				<?php echo $sticky_item->blocked; ?>
				</td>
				<td>
				<span class="dashicons dashicons-no"></span>
				</td>
				</tr>
				<?php endforeach; ?>
		</tbody>
        </table>
        </div>
        
        <div class="toast-sidebar">
        
		<div class="toast-metabox">
		<h3>Ratings & Reviews</h3>
		<p>If you like this plugin please consider leaving a ★★★★★ rating.
        A huge thanks in advance!</p>
        <a href="https://wordpress.org/plugins/toast-stick-anything/#reviews" target="_blank" class="button button-primary">Leave us a rating</a>
        </div>
        
        <div class="toast-metabox">
		<h3>About the plugin</h3>
	    <div class="meta-info"><strong>Developed by:</strong> <a href="https://www.toastplugins.co.uk/">Toast Plugins</a></div>
		<div class="meta-info"><strong>Need some support?</strong> 
		<br><a href="https://wordpress.org/support/plugin/toast-stick-anything/" target="_blank" >Contact the developers via the Support Forum</a></div>
        <a href="https://wordpress.org/support/plugin/toast-stick-anything/" class="button button-primary">Contact us</a>
        </div>
        
        
        </div>

	</div>
	
	</div>
<?php } ?>