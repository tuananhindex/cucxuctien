// This is the jQuery animation code
$(document).ready(function () {
   $('.bxslider').bxSlider({
      mode: 'fade',
      captions: true
   });

   $('.media-slider').bxSlider({
      auto: 'true',
       pager:false,
      captions: false,
      nextSelector: '.media-slider-nav #ms-nav-right',
      prevSelector: '.media-slider-nav #ms-nav-left',
      nextText: '<i class="fa fa-angle-right"></i>',
      prevText: '<i class="fa fa-angle-left"></i>',
      slideWidth: 363,
      minSlides: 1,
      maxSlides: 3,
      slideMargin: 10
   });

   $('#dropdown-news-vi').click(function () {
         $('#dropdownmenu-news-vi').slideToggle();
      }
   );

   $('#dropdown-news-la').click(function () {
         $('#dropdownmenu-news-la').slideToggle();
      }
   );

   // calendar
    var tdObj = $('.calendar-cus table td');
    var clw = tdObj.width();
    tdObj.css({'height':clw+'px'});

    $('.calendar-cus.vi table td a').hover(function (e) {
        e.preventDefault();
        $('.calendar-cus.vi caption .note').html($(this).parent().find('p').html());
        $('.calendar-cus.vi caption .note').slideToggle();
    });

    $('.calendar-cus.la table td a').hover(function (e) {
        e.preventDefault();
        $('.calendar-cus.la caption .note').html($(this).parent().find('p').html());
        $('.calendar-cus.la caption .note').slideToggle();
    });

});
/*

var clndr = {};

$(function() {

   // PARDON ME while I do a little magic to keep these events relevant for the rest of time...
   var currentMonth = moment().format('YYYY-MM');
   var nextMonth    = moment().add('month', 1).format('YYYY-MM');

   var events = [
      { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },
      { date: currentMonth + '-' + '19', title: 'Cat Frisbee', location: 'Jefferson Park' },
      { date: currentMonth + '-' + '23', title: 'Kitten Demonstration', location: 'Center for Beautiful Cats' },
      { date: nextMonth + '-' + '07',    title: 'Small Cat Photo Session', location: 'Center for Cat Photography' }
   ];

   clndr = $('#full-clndr').clndr({
      template: $('#full-clndr-template').html(),
      events: events,
      forceSixRows: true
   });

   $('#mini-clndr').clndr({
      template: $('#mini-clndr-template').html(),
      events: events,
      clickEvents: {
         click: function(target) {
            if(target.events.length) {
               var daysContainer = $('#mini-clndr').find('.days-container');
               daysContainer.toggleClass('show-events', true);
               $('#mini-clndr').find('.x-button').click( function() {
                  daysContainer.toggleClass('show-events', false);
               });
            }
         }
      },
      adjacentDaysChangeMonth: true,
      forceSixRows: true
   });

});
 */