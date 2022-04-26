<?php 
/*
*
*	***** CODJA *****
*
*	Core Functions
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
*
* Custom Front End Ajax Scripts / Loads In WP Footer
*
*/
function codja_frontend_ajax_form_scripts(){
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    "use strict";
    // add basic front-end ajax page scripts here

    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var role = '';
    var orderby= '';
    var order= '';
    function codja_load_all_users(page, role, orderby, order){
        
        var data = {
            page: page,
            orderby: orderby,
            order: order,
            role: role,
            action: "codja_users_frontend_ajax"
        };
        $.post(ajaxurl, data, function(response) {
            $(".table-content").html('').append(response);
        });
    }
    
    var orderby = $('#sort_column').val();
    var order = $('#sort_order').val();
    codja_load_all_users(1, role, orderby, order);
    
    $('body').on('click', '.codja-pagination li.enabled', function(){
        var page = $(this).attr('p');
        var role = $('select[name="role"]').val();
        var orderby = $('#sort_column').val();
        var order = $('#sort_order').val();
        codja_load_all_users(page, role, orderby, order);
    });

    $('body').on('change', 'select[name="role"]', function() {
        var role = $(this).val();
        var page = 1;
        var orderby = $('#sort_column').val();
        var order = $('#sort_order').val();
        codja_load_all_users(page, role, orderby, order);
    });

    $('body').on('click', 'thead td span', function(){
        var sorting = $(this).parent().attr('id');
        if(sorting == 'sort_by_id') {
            var orderby = 'id';
            var order = 'ASC';
        } else if(sorting == 'sort_by_name')  {
            var orderby = 'user_name';
            var order = 'ASC'; 
        } else if(sorting == 'sort_by_email')  {
            var orderby = 'user_email';
            var order = 'ASC'; 
        } else  {
            var orderby = 'id';
            var order = 'DESC'; 
        }
        //console.log(orderby);
        $('#sort_column').val(orderby);
        $('#sort_order').val(order);
        var page = 1;
        var role = $('select[name="role"]').val();
        codja_load_all_users(page, role, orderby, order);
    });

}(jQuery));    
</script>
<?php }
add_action('wp_footer','codja_frontend_ajax_form_scripts');