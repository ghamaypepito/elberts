jQuery(window).ready(function(){

//SAVING DATA
jQuery('.add-sticky-item').on('click', function(){
var elementName = jQuery('#row-item').val();
var elementMarginTop = jQuery('#row-margin-top').val();
var elementScreenWidth = jQuery('#row-screen-width').val();
if(jQuery('#row-parent-stop').attr('checked') == 'checked'){
var elementBlocked = 'enabled'
}else{
var elementBlocked = 'disabled'
}
if(elementName){
var currentJSON = jQuery('input[name="toastsi-json"]').val();
if(currentJSON){
var json = JSON.parse(currentJSON);
}else{
var json = [];
}
element = new Object();
element.name = elementName;
element.margintop = elementMarginTop;
element.screenwidth = elementScreenWidth;
element.blocked = elementBlocked;
json.unshift(element);
jQuery('input[name="toastsi-json"]').val(JSON.stringify(json));

var itemsJSON = jQuery('input[name="toastsi-json"]').val();

jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'post',
        data: { action: 'toastsi_update',
        		json: itemsJSON
        		},
        success: function(){
        var newItem = '<tr><td>'+elementName+'</td><td>'+elementMarginTop+'</td><td>'+elementScreenWidth+'</td><td>'+elementBlocked+'</td><td><span class="dashicons dashicons-no"></span></td></tr>';
        jQuery('.sticky-items-table tbody').prepend(newItem);
        
        jQuery('#row-item').val('');
	jQuery('#row-margin-top').val(0);
	jQuery('#row-screen-width').val(0);
        
        }
});
}else{
alert('Please add an element name')
}


})

//REMOVING DATA
jQuery('body').on('click', '.dashicons-no', function(){
var element = jQuery(this);
var item = jQuery(this).parents('tr').index();
var itemsJSON = jQuery('input[name="toastsi-json"]').val();
var array = JSON.parse(itemsJSON);
array.splice(item, 1);
itemsJSON = JSON.stringify(array);

jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'post',
        data: { action: 'toastsi_update',
        		json: itemsJSON,
        		},
        success: function(toastsi_update){
        jQuery(element).parents('tr').remove();
        jQuery('input[name="toastsi-json"]').val(itemsJSON);
        
        }
});

})


})