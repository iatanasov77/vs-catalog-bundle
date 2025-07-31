import { VsSpinnerShow, VsSpinnerHide } from '@@/js/includes/vs_spinner.js';

export function GetStripeCreditCardForm( url, modalId, contentId )
{
    /** Bootstrap 5 Modal Toggle */
    const myModal = new bootstrap.Modal( '#' + modalId, {
        keyboard: false
    });
    myModal.hide( $( '#' + modalId ).get( 0 ) );
    VsSpinnerShow( contentId );
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            $( '.modal-title' ).text( 'Enter Your Card Details' );
            $( '.modal-body' ).attr( 'style', '' );
            $( '.modal-body' ).addClass( 'credit-card' );
            $( '#' + contentId ).addClass( 'credit-card' );
                        
            $( '#' + contentId ).html( response );
            
            myModal.show( $( '#' + modalId ).get( 0 ) );
            
            VsSpinnerHide( contentId );
        },
        error: function()
        {
            alert( "GetStripeCreditCardForm SYSTEM ERROR!!!" );
        }
    });
}

export function GetPayumCreditCardForm( url, modalId, contentId )
{
    /** Bootstrap 5 Modal Toggle */
    const myModal = new bootstrap.Modal( '#' + modalId, {
        keyboard: false
    });
    myModal.hide( $( '#' + modalId ).get( 0 ) );
    VsSpinnerShow( contentId );
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            $( '.modal-title' ).text( 'Enter Your Card Details' );
            $( '.modal-body' ).attr( 'style', '' );
            $( '.modal-body' ).addClass( 'credit-card' );
            $( '#' + contentId ).addClass( 'credit-card' );
                        
            $( '#' + contentId ).html( response );
            
            myModal.show( $( '#' + modalId ).get( 0 ) );
            VsSpinnerHide( contentId );
        },
        error: function()
        {
            alert( "GetPayumCreditCardForm SYSTEM ERROR!!!" );
        }
    });
}

export function GetPayumObtainCouponCodeForm( url, modalId, contentId )
{
    /** Bootstrap 5 Modal Toggle */
    const myModal = new bootstrap.Modal( '#' + modalId, {
        keyboard: false
    });
    myModal.hide( $( '#' + modalId ).get( 0 ) );
    VsSpinnerShow( contentId );
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            $( '.modal-title' ).text( 'Enter Coupon Code' );
            $( '.modal-body' ).attr( 'style', '' );
            $( '.modal-body' ).addClass( 'credit-card' );
            $( '#' + contentId ).addClass( 'credit-card' );
                        
            $( '#' + contentId ).html( response );
            
            myModal.show( $( '#' + modalId ).get( 0 ) );
            VsSpinnerHide( contentId );
        },
        error: function()
        {
            alert( "GetPayumObtainCouponCodeForm SYSTEM ERROR!!!" );
        }
    });
}

export function GetVendoCreditCardForm( url, modalId, contentId )
{
    /** Bootstrap 5 Modal Toggle */
    const myModal = new bootstrap.Modal( '#' + modalId, {
        keyboard: false
    });
    myModal.hide( $( '#' + modalId ).get( 0 ) );
    VsSpinnerShow( contentId );
    
    $.ajax({
        type: "GET",
        url: url,
        success: function( response )
        {
            $( '.modal-title' ).text( 'Enter Your Card Details' );
            $( '.modal-body' ).attr( 'style', '' );
            $( '.modal-body' ).addClass( 'credit-card' );
            $( '#' + contentId ).addClass( 'credit-card' );
                        
            $( '#' + contentId ).html( response );
            
            myModal.show( $( '#' + modalId ).get( 0 ) );
            VsSpinnerHide( contentId );
        },
        error: function()
        {
            alert( "GetPayumCreditCardForm SYSTEM ERROR!!!" );
        }
    });
}
