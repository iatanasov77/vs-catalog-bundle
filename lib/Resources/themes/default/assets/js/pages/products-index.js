import { VsPath } from '@/js/includes/fos_js_routes.js';
require( '@/js/includes/clone_preview.js' );
require( '@/js/includes/resource-delete.js' );
require( '../../css/custom.css' );

$( function()
{
	$( "#form_filterByCategory" ).on( 'change', function() {
        let filterCategory  = $( this ).val();
        let url             = VsPath( 'vs_catalog_product_index' );
        if ( filterCategory ) {
            url += filterCategory + '/';
        }
        
        document.location   = url;
    });
});
