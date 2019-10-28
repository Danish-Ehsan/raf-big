(function () { 
    
    const heroListItems = document.getElementsByClassName( 'js--hero-list-item' );
    const heroListImages = document.getElementsByClassName( 'js--hero-list-image' );
    var currentIndex = Math.ceil( heroListItems.length / 2 ) - 1;
    
    //Load all featured background images using the URL stored in the data attribute
    for ( var i = 0; heroListImages.length > i; i++ ) {
        if ( heroListImages[i].dataset.imageSource ) {
            heroListImages[i].style.backgroundImage = 'url(' + heroListImages[i].dataset.imageSource + ')';
            heroListImages[i].removeAttribute('data-image-source');
        }
    }
    
    
    function changeFeatured( index ) {
        for ( var i = 0; heroListItems.length > i; i++ ) {
            heroListItems[i].classList.remove( 'hero__list-item--active' );
            heroListItems[i].classList.add( 'hero__list-item--faded' );
            heroListImages[i].classList.remove( 'hero__image--active' );
        }

        heroListItems[index].classList.add( 'hero__list-item--active' );
        heroListImages[index].classList.add( 'hero__image--active' );

        if ( heroListItems[index - 1] ) {
            heroListItems[index - 1].classList.remove( 'hero__list-item--faded' );
        }
        if ( heroListItems[index + 1] ) {
            heroListItems[index + 1].classList.remove( 'hero__list-item--faded' );
        }
    }
    
    
    //Hover events for desktop users
    if ( !('ontouchstart' in window) ) {
        for ( var i = 0; heroListItems.length > i; i++ ) {
            heroListItems[i].addEventListener( 'mouseenter', function( e ) {
                //"this" defined by .bind() at the end of function which binds the element index
                changeFeatured(this);
            }.bind(i));
        }
    //Timed events for mobile users
    } else {
        setInterval( function( ) {
            currentIndex = ( currentIndex < (heroListItems.length - 1) ) ? currentIndex + 1 : 0;
            changeFeatured( currentIndex );
        }, 2800);
    }
    
}());