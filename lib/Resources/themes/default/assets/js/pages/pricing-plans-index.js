// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
import { VsPath } from '@@/js/includes/fos_js_routes.js';
require( '@@/js/includes/clone_preview.js' );
require( '@@/js/includes/resource-delete.js' );

$( function()
{
	$( "#form_filterByCategory" ).on( 'change', function() {
        let filterCategory  = $( this ).val();
        let url             = VsPath( 'vs_catalog_pricing_plan_index' );
        if ( filterCategory ) {
            url = VsPath( 'vs_catalog_pricing_plan_index_filtered', { 'filterCategory': filterCategory } );
        }
        
        document.location   = url;
    });
});
