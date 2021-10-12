/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('chart.js');
require('./bootstrap');

import flatpickr from "flatpickr";



flatpickr("#appointmentDateTime", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    static: false
});

$("#banAccountTrigger").on("click", function(event){

    $("#banAccountModal").modal('show');

});

$("#durationDropdown").dropdown();

$(".dropdown-menu a").on("click", function(e){

    $(".duration-btn").text(this.innerHTML);
    $("#operator").val(this.innerHTML);

});

$("#banAccountButton").on("click", function(){
    $("#banAccountForm").submit();
});

$("#comment").keyup(function(){
    $("#charcount").text($("#comment").val().length);
});

$("#submitComment").on('click', function(){
    $("#newComment").submit();
});

$("#jointype").bootstrapToggle();

