(function( $ ) {
    
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        responsiveRefreshRate: 200,
        responsive: {
            0: {
                items: 1
            },
            601: {
                items: 2
            },
            851: {
                items: 3
            }
        }
    });
    
}( jQuery ));


