<?php function addToastsiJavascript(){ ?>
<?php $json = stripslashes(get_option('toastsi-json')); ?>
<?php $items = json_decode($json); ?>

<script>
jQuery(window).ready(function(){
<?php foreach($items as $item): ?>	
setTimeout(function(){	
jQuery('<?php echo $item->name; ?>').each(function(){
		var originalPositioning = jQuery(this).css('position');
		var ElementOffsetTop = jQuery(this).css({'position': 'static'}).offset().top;
		jQuery(this).css({'position': originalPositioning});
		var widthBefore = jQuery(this).width();
		var leftBefore = jQuery(this).offset().left;
		var fixedPosition = <?php echo $item->margintop; ?>;
		var element = jQuery(this);
		var parentHeight = parseInt(jQuery(this).parent().height());
		var parentOffset = parseInt(jQuery(this).parent().offset().top);
		var elementBorder = jQuery(this).css('border');
		var elementBackground = jQuery(this).css('background');
		var elementPadding = jQuery(this).css('padding');
		var elementMargin = jQuery(this).css('margin');
		
	jQuery(element).parent().css({'position': 'relative'});
	jQuery(element).css({'min-height': 1});
	jQuery(element).find('> *').wrapAll('<div class="fixed-container"></div>');
	var elementHeight = jQuery(element).find('.fixed-container').css({'height': 'auto'}).height();
		
	jQuery(window).scroll(function(){
		var scrollPosition = jQuery(window).scrollTop();
		
		if(jQuery(window).width() > <?php echo $item->screenwidth; ?>){
		//BLOCKED
		<?php if($item->blocked == 'enabled'): ?>
		if(scrollPosition + fixedPosition >= parentHeight + parentOffset - elementHeight){
			jQuery(element).removeClass('item-stuck');
			jQuery(element).find('.fixed-container').removeAttr('style');
			jQuery(element).find('.fixed-container').css({'position': 'absolute', 'bottom': 0, 'width': widthBefore})
		}
		else if(scrollPosition + fixedPosition >= ElementOffsetTop){
			if(! jQuery(element).hasClass('item-stuck')){
			jQuery(element).css({'padding': 0, 'border': 'none', 'background': 'none', 'padding': '0', 'margin': '0'});
			jQuery(element).addClass('item-stuck');
			jQuery(element).find('.fixed-container').css({'position': 'fixed', 'top': fixedPosition, 'width': widthBefore, 'border': elementBorder, 'background': elementBackground, 'padding': elementPadding, 'margin': elementMargin});
			}
		}else{
			jQuery(element).removeClass('item-stuck');
			jQuery(element).css({'border': elementBorder, 'background': elementBackground, 'padding': elementPadding, 'margin': elementMargin});
			jQuery(element).find('.fixed-container').removeAttr('style');
		}
		//NOT BLOCKED
		<?php else: ?>
		if(scrollPosition + fixedPosition >= ElementOffsetTop){
			if(! jQuery(element).hasClass('item-stuck')){
			jQuery(element).css({'padding': 0, 'border': 'none', 'background': 'none', 'padding': '0', 'margin': '0'});
			jQuery(element).addClass('item-stuck');
			jQuery(element).find('.fixed-container').css({'position': 'fixed', 'top': fixedPosition, 'width': widthBefore, 'border': elementBorder, 'background': elementBackground, 'padding': elementPadding, 'margin': elementMargin});
			}
		}else{
			jQuery(element).removeClass('item-stuck');
			jQuery(element).css({'border': elementBorder, 'background': elementBackground, 'padding': elementPadding, 'margin': elementMargin});
			jQuery(element).find('.fixed-container').removeAttr('style');
		}
		<?php endif; ?>
		}
	});
});
}, 300);
<?php endforeach; ?>
		
})	
</script>
<?php }
add_action('wp_footer', 'addToastsiJavascript'); ?>