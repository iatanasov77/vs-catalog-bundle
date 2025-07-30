// bin/console fos:js-routing:dump --format=json --target=public/shared_assets/js/fos_js_routes_admin.json
import { VsPath } from '@@/js/includes/fos_js_routes.js';
import { VsSpinnerShow, VsSpinnerHide } from '@@/js/includes/vs_spinner.js';
var applicationRoutes  = require( '@/js/fos_js_routes_application.json' );

import {
    GetStripeCreditCardForm,
    GetPayumCreditCardForm,
    GetPayumObtainCouponCodeForm,
    GetVendoCreditCardForm
} from './credit_card.js';

export function ChoosePlan( planFormUrl )
{
    $.ajax({
        type: "GET",
        url: planFormUrl,
        success: function( response )
        {
            $( '#selectPricingPlanForm' ).html( response );
            
            let supportRecurring    = $( '.rPaymentMethod:checked' ).attr( 'data-supportRecurring' );
            if ( ! supportRecurring ) {
                $( '#SetRecurringPayments' ).hide();
            }
            
            /** Bootstrap 5 Modal Toggle */
            const myModal = new bootstrap.Modal( '#plan-modal', {
                keyboard: false
            });
            myModal.show( $( '#plan-modal' ).get( 0 ) );
            
            //VsSpinnerShow( 'selectPricingPlanForm' );
        },
        error: function()
        {
            alert( "ChoosePlan SYSTEM ERROR!!!" );
        }
    });
}

export function PayPlan( planFormUrl )
{
    if ( ! window.PricingPlanFormSubmited ) {
        VsSpinnerShow( 'ProfileSubscriptions' );
    }
    
    $.ajax({
        type: "GET",
        url: planFormUrl,
        success: function( response )
        {
            $( '#selectPricingPlanForm' ).html( response );

            if ( ! window.PricingPlanFormSubmited ) {
                var formData    = new FormData( document.getElementById( 'PricingPlanForm' ) );
                handlePricingPlanPayment( formData );
                
                window.PricingPlanFormSubmited  = true;
            }
        },
        error: function()
        {
            VsSpinnerHide( 'ProfileSubscriptions' );
            alert( "PayPlan SYSTEM ERROR!!!" );
        }
    });
}

export function PaySubscription( paymentMethodFormUrl, isRecurring )
{
    $.ajax({
        type: "GET",
        url: paymentMethodFormUrl,
        success: function( response )
        {
            $( '#selectPaymentMethodForm' ).html( response );
            if ( isRecurring ) {
                $( '#select_payment_method_form_paymentMethod_setRecurringPayments' ).prop( 'checked', true );
            }
            
            /** Bootstrap 5 Modal Toggle */
            const myModal = new bootstrap.Modal( '#payment-modal', {
                keyboard: false
            });
            myModal.show( $( '#payment-modal' ).get( 0 ) );
        },
        error: function()
        {
            alert( "PaySubscription SYSTEM ERROR!!!" );
        }
    });
}

export function handlePricingPlanPayment( formId, modalId, contentId )
{
    var formData    = new FormData( document.getElementById( formId ) );
    
    VsSpinnerShow( 'selectPricingPlanForm' );
    $.ajax({
        type: "POST",
        url: $( '#' + formId ).attr( 'action' ),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function( response )
        {
            VsSpinnerHide( 'selectPricingPlanForm' );
            
            //alert( response.data.paymentPrepareUrl );
            //alert( response.data.gatewayFactory );
            switch ( response.data.gatewayFactory ) {
                //case 'stripe_checkout':
                case 'stripe_js':
                    var creditCardFormUrl   = VsPath( response.data.paymentPrepareUrl, {}, applicationRoutes );
                    GetStripeCreditCardForm( creditCardFormUrl, modalId, contentId );
                    
                    break;
                case 'paypal_pro_checkout':
                case 'authorize_net_aim':
                    var creditCardFormUrl   = VsPath( response.data.paymentPrepareUrl, {}, applicationRoutes );
                    GetPayumCreditCardForm( creditCardFormUrl, modalId, contentId );
                    
                    break;
                case 'telephone_call':
                    var obtainCouponCodeFormUrl = VsPath( response.data.paymentPrepareUrl, {}, applicationRoutes );
                    GetPayumObtainCouponCodeForm( obtainCouponCodeFormUrl, modalId, contentId );
                    
                    break;
                case 'vendo_sdk':
                    var creditCardFormUrl = VsPath(
                        'vs_payment_show_credit_card_form',
                        {
                            'formAction': btoa( VsPath( response.data.paymentPrepareUrl, {}, applicationRoutes ) )
                        },
                        applicationRoutes
                    );
                    GetVendoCreditCardForm( creditCardFormUrl, modalId, contentId );
                    
                    break;
                default:
                    document.location   = VsPath( response.data.paymentPrepareUrl, {}, applicationRoutes );
            }
        },
        error: function()
        {
            VsSpinnerHide( 'selectPricingPlanForm' );
            alert( "handlePricingPlanPayment SYSTEM ERROR!!!" );
        }
    });
}
