// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
import { VsPath } from '@@/js/includes/fos_js_routes.js';
require( '@@/js/includes/clone_preview.js' );
require( '@@/js/includes/resource-delete.js' );
require( '@@/vendor/vs_tablesortable/tablesortable.js' );

function changeOrder( itemId, itemPosition )
{
    $.ajax({
        type: 'GET',
        url: VsPath( 'vs_catalog_pricing_plans_sort', { 'id': itemId, 'position': itemPosition } ),
        success: function ( data )
        {
            if ( data['status'] == 'ok' ) {
                document.location   = document.location;
            } else {
                alert( 'ERROR !!!' );
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown )
        {
            alert( 'ERROR !!!' );
        }
    });
}

function computeNewPosition( itemIndex, itemsPositions )
{   let prevItemPosition    = ( ( itemIndex - 1 ) in itemsPositions ) ? itemsPositions[itemIndex - 1] : undefined;
    let nextItemPosition    = ( ( itemIndex + 1 ) in itemsPositions ) ? itemsPositions[itemIndex + 1] : undefined;
    
    let newPosition         = 'undefined';
    let positionStep        = 10;
    
    if ( prevItemPosition ) {
        newPosition  = prevItemPosition + positionStep;
        while ( itemsPositions.includes( newPosition ) ) {
            newPosition  = newPosition + positionStep;
        }
    } else if ( nextItemPosition ) {
        newPosition  = nextItemPosition - positionStep;
        while ( itemsPositions.includes( newPosition ) ) {
            newPosition  = newPosition - positionStep;
        }
    }
    
    return newPosition;
}

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
    
    let sortableIds;
    $( "#pricingPlansContainer" ).sortable({
        start: function( event, ui ) {
            sortableIds = $( "#pricingPlansContainer" ).sortable( "toArray" );
            console.log( sortableIds );
        },
        
        update: function( event, ui ) {
            var itemId      = ui.item.attr( "data-id" );
            var sortedIDs   = $( "#pricingPlansContainer" ).sortable( "toArray" );
            var itemIndex   = sortedIDs.indexOf( itemId );
            
            var itemsPositions = [];
            for ( let i = 0; i < sortedIDs.length; i++ ) {
                itemsPositions.push( $( '#' + sortedIDs[i] ).data( 'position' ) );
            }
            console.log( sortedIDs );
            console.log( itemsPositions );
            //alert( "Position: " + ui.position.top + " Original Position: " + ui.originalPosition.top );
            
            let newPosition = computeNewPosition( itemIndex, itemsPositions );
            if ( newPosition ) {
                changeOrder( itemId, newPosition );
            }
        }
    });
});
