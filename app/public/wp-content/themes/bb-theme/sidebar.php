<?php

$position = isset( $position ) ? $position : 'right';
$section  = isset( $section ) ? $section : 'blog';
$size     = isset( $size ) ? $size : '4';
$display  = isset( $display ) ? $display : 'desktop';

?>
<div class="fl-sidebar fl-sidebar-<?php echo $position; ?> fl-sidebar-display-<?php echo $display; ?> col-md-<?php echo $size; ?>"<?php FLTheme::print_schema( ' itemscope="itemscope" itemtype="https://schema.org/WPSideBar"' ); ?>>
	<?php do_action( 'fl_sidebar_open' ); ?>
	<?php dynamic_sidebar( $section . '-sidebar' ); ?>
	<?php do_action( 'fl_sidebar_close' ); ?>
</div>
