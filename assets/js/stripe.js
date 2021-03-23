// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
import $ from 'jquery';
$(document).ready(function(){

var stripe = Stripe('pk_test_NjZTkuP2e7cpHs02JcfQInKj00kBCo6MH0');
var elements = stripe.elements();
var cardElement = elements.create('card');
cardElement.mount('#card-element');


});