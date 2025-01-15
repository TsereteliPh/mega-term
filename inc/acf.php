<?php
// return acf row index from 0
add_filter('acf/settings/row_index_offset', '__return_zero');

// url for blocks preview
add_filter('acfe/flexible/thumbnail', 'adem_layout_thumbnail_url', 10, 3);
function adem_layout_thumbnail_url($thumbnail, $field, $layout)
{
	return get_template_directory_uri() . '/layouts/blocks/' . $layout['name'] . '/preview.jpg';
}

//! start temporarily fix acf extended pro
// ACFE 0.9.0.5: Fix compatibility with clone on ACF 6.3.2
add_action('acf/init', 'my_acfe_fix_clone', 100);
function my_acfe_fix_clone(){

    $instance = acf_get_instance('acfe_field_clone');
    remove_action('wp_ajax_acf/fields/clone/query', array($instance, 'ajax_query'), 5);

}

// ACFE 0.9.0.5: Fix compatibility with fields on ACF 6.3.2
add_action('acf/input/admin_print_footer_scripts', 'my_acfe_fix_form_fields');
function my_acfe_fix_form_fields(){
    ?>
    <script>
    (function($){

        if(typeof acf === 'undefined' || typeof acfe === 'undefined'){
            return;
        }

        new acf.Model({
            filters: {
                'select2_ajax_data/action=acfe/form/map_field_groups_ajax':      'ajaxData',
                'select2_ajax_data/action=acfe/form/map_field_ajax':             'ajaxData',
                'select2_ajax_data/action=acf/fields/acfe_taxonomy_terms/query': 'ajaxData',
            },

            ajaxData: function(ajaxData, data, $el, field, select){
                ajaxData.nonce = acf.get('nonce');
                return ajaxData;
            },
        });

    })(jQuery);
    </script>
    <?php
}
//! end
