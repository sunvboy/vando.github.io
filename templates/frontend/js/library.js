/*js menu mobile*/
$(document).ready(function ($) {
    $('#trigger-mobile').click(function() {
        $(".mobile-main-menu").addClass('active');
        $(".backdrop__body-backdrop___1rvky").addClass('active');
    });
    $('#close-nav').click(function() {
        $(".mobile-main-menu").removeClass('active');
        $(".backdrop__body-backdrop___1rvky").removeClass('active');
    });
    $('.backdrop__body-backdrop___1rvky').click(function() {
        $(".mobile-main-menu").removeClass('active');
        $(".backdrop__body-backdrop___1rvky").removeClass('active');
    });
    $(window).resize( function(){
        if ($(window).width() > 1023) {
            $(".mobile-main-menu").removeClass('active');
            $(".backdrop__body-backdrop___1rvky").removeClass('active');
        }
    });
    $('.ng-has-child1 a .fa1').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $this.parents('.ng-has-child1').find('.ul-has-child1').stop().slideToggle();
        $(this).toggleClass('active')
        return false;
    });
    $('.ng-has-child1 .ul-has-child1 .ng-has-child2 a .fa2').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $this.parents('.ng-has-child1 .ul-has-child1 .ng-has-child2').find('.ul-has-child2').stop().slideToggle();
        $(this).toggleClass('active')
        return false;
    });
});
/*resize img cùng cấp*/
/*$( window ).load(function() {
    render_size();
    var url = window.location.href;
    $('.menu-item  a[href="' + url + '"]').parent().addClass('active');
});
$( window ).resize(function() {
    render_size();
});*/
/*function render_size(){

    var h_1000 = $('.h_1000 img').width();
    $('.h_1000 img').height( 1.000 * parseInt(h_1000));


}*/
/*navText:["<i class=\"fa fa-long-arrow-left\"></i>","<i class=\"fa fa-long-arrow-right\"></i>"],*/
/*js zoom img ctsp*/
$(function() {
  $("#zoom1").glassCase({
      'widthDisplay': 390,
      'heightDisplay': 330,
      'nrThumbsPerRow': 4,
      'isSlowZoom': true,
      'colorIcons': '#F15129',
      'colorActiveThumb': '#F15129',
      /*'thumbsPosition': 'left'*/ /*img con float left*/
  });
});
// js back to top
if ($('#back-to-top').length) {
    var scrollTrigger = 800, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
/*js home slider banner*/
$('.slide-sp').owlCarousel({
    loop:true,
    margin:0,
    dots:false,
    nav:true,
    autoplay:false,
    autoplayTimeout:3000,
    autoplaySpeed:1200,
    smartSpeed:1200,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
/*js click item sp*/
$(".list-color-sp li").click( function() {
    $(this).parents(".list-color-sp").find(".item-color").removeClass('active');
    $(this).addClass('active');
})
$(".list-color-sp li").click( function() {
    $(this).parents(".wp-item-sp").find(".wp-item-sp-main").removeClass('active');
})
$(".list-color-sp li:nth-child(1)").click( function() {
    $(this).parents(".wp-item-sp").find(".wp-item-sp-main:nth-child(1)").addClass('active');
})
$(".list-color-sp li:nth-child(2)").click( function() {
    $(this).parents(".wp-item-sp").find(".wp-item-sp-main:nth-child(2)").addClass('active');
})
$(".list-color-sp li:nth-child(3)").click( function() {
    $(this).parents(".wp-item-sp").find(".wp-item-sp-main:nth-child(3)").addClass('active');
})

/*js click search mb*/
$(".btn-search-mb").click(function () {
    $(this).toggleClass("open");
    $(".wp-box-search-mb").slideToggle( "slow", function() {

    });
})
$(".wp-ft-main").click(function () {
    $(this).toggleClass("open");
    $(this).find(".list-ft-main").slideToggle( "slow", function() {

    });
})

/*js click bo loc*/
$(".btn-click-boloc").click( function (){
    $(this).parent().addClass("open");
    $(this).parent().find(".wp-bo-loc-1").addClass("open");
})
$(".close-fil").click( function (){
    $(this).parent().removeClass("open");
    $(this).parent().find(".wp-bo-loc-1").removeClass("open");
})

/*js click show hidden form*/
$(".btn-click-dosize").click( function() {
    $(".wp-list-form-dosize").find(".form-1").addClass("hidden");
    $(".wp-list-form-dosize").find(".form-2").addClass("active");
})
$(".btn-chinhsua-lai").click( function() {
    $(".wp-list-form-dosize").find(".form-1").removeClass("hidden");
    $(".wp-list-form-dosize").find(".form-2").removeClass("active");
})