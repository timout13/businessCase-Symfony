"use strict";

/***************
 Variables
 ***************/
const checkoutBtn=document.querySelector("#payment_summary_btn");
const paymentSummary=document.querySelector("#payment_summary");
const checkout=document.querySelector("#payment_checkout");
const checkout_submit=document.querySelector("#payment_submit");
const radio1=document.querySelector("#payment_payment_type_0");
const radio2=document.querySelector("#payment_payment_type_1");

/***************
Fonctions
 ***************/



/***************
 Code principal
 ***************/

/* starts when the html is loaded */

document.addEventListener("DOMContentLoaded", function () {

    radio2.addEventListener('click', ()=>{
        checkoutBtn.removeAttribute('disabled');
    })
    radio1.addEventListener('click', ()=>{
        checkoutBtn.removeAttribute('disabled');
    })
    checkoutBtn.addEventListener('click', ()=>{
        console.log(radio1.checked);
        if (radio1.checked){
            paymentSummary.innerHTML = 'Paypal';
        }
        if (radio2.checked){
            paymentSummary.innerHTML = 'Carte Bancaire';
        }
        console.log(radio2.checked);
    })
    checkout.addEventListener('click', ()=>{
        checkout_submit.click();
    })
});
