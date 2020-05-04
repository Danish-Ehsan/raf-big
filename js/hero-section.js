(function () {
    const heroList = document.getElementsByClassName( 'js--hero-list' );
    const heroListCont = document.getElementsByClassName( 'js--hero-list-cont' );
    const heroListItems = document.getElementsByClassName( 'js--hero-list-item' );
    const heroListImages = document.getElementsByClassName( 'js--hero-list-image' );
    
    var currentIndex = Math.ceil( heroListItems.length / 2 ) - 1;
    var animatingList = false;
    var animationCycle = 0;
    var cycleDirection = 'up';
    var currentTargetRect, mousePosX, mousePosY;
    var listEventInterval;
    
    
    //Load all featured background images using the URL stored in the data attribute
    for ( var i = 0; heroListImages.length > i; i++ ) {
        if ( heroListImages[i].dataset.imageSource ) {
            heroListImages[i].style.backgroundImage = 'url(' + heroListImages[i].dataset.imageSource + ')';
            heroListImages[i].removeAttribute('data-image-source');
        }
    }
    
    //get the css transitionend event supported by the current browser
    function whichTransitionEvent(){
        var t,
            el = document.createElement("fakeelement");

        var transitions = {
          "transition"      : "transitionend",
          "OTransition"     : "oTransitionEnd",
          "MozTransition"   : "transitionend",
          "WebkitTransition": "webkitTransitionEnd"
        }

        for (t in transitions){
          if (el.style[t] !== undefined){
            return transitions[t];
          }
        }
    }
    
    var transitionEvent = whichTransitionEvent();
    
    
    heroListCont[0].addEventListener( 'mousemove', function(e) {
         currentTargetRect = e.currentTarget.getBoundingClientRect();
         mousePosX = e.pageX - currentTargetRect.left;
         mousePosY = e.pageY - currentTargetRect.top;
     });

    heroListCont[0].addEventListener( 'mouseenter', function(e) {
        //console.log('mouseenter test');
        animationCycle = 0;
        listEventInterval = setInterval( checkListAnimation, 100 );
    });

    heroListCont[0].addEventListener( 'mouseleave', function() {
        console.log( 'mouseleave test' );
        //debugger;
        clearInterval( listEventInterval );
        if ( animationCycle > 1 ) {
            //value of -1 tells the cycleList function to ease out the next cycle animation to give a slowing down effect
            animationCycle = -1;
            
            //if cursor is moved out in between list cycles, manually cycle the list once more
            if (!animatingList) {
                console.log( 'manually cycle' );
                cycleList(cycleDirection);
            }
        } else {
            animationCycle = 0;
        }
        
    });
    
    
    function checkListAnimation() {
        //console.log('checkListAnimationTest');
        //console.log('animatingList= ' + animatingList);
        if ( !animatingList && mousePosY <= 280 ) {
            cycleDirection = 'down';
            cycleList( 'down' );
        } else if ( !animatingList && mousePosY >= 420 ) {
            cycleDirection = 'up';
            cycleList( 'up' );
        }
    }
    
    
    function cycleList( direction ) {
        var animatingInIndex, animatingOutIndex;
        animatingList = true;
        animationCycle++;
        console.log('animation cycle1= ' + animationCycle);
        //console.log('cycleList test');
        
        if ( direction === 'up' ) {
            animatingInIndex = heroListItems.length - 1;
            animatingOutIndex = 0;
        } else {
            animatingInIndex = 0;
            animatingOutIndex = heroListItems.length - 1;
        }
        
        var cloneItem = heroListItems[animatingOutIndex].cloneNode(true);

        //shift styles to next item before list items are added/removed and then reset index for when list items have been added/removed
        if (direction === 'up') {
            currentIndex++;
            updateListItems();
            currentIndex--;
        } else {
            currentIndex--;
            updateListItems();
            currentIndex++;
        }

        //If the list just started moving or is going to stop make it ease-in or ease-out respectively
        if ( animationCycle === 1 ) {
            //cloneItem.classList.add('hero__list-item--transition-ease-in');
            heroList[0].classList.add('hero__list--transition-ease-in');
        } else if ( animationCycle === 0 ) {
            //cloneItem.classList.add('hero__list-item--transition-ease-out');
            heroList[0].classList.add('hero__list--transition-ease-out');
        }

        cloneItem.setAttribute('style', 'height: 0px; margin: 0');
        //console.log('appending child');

        if ( direction === 'up' ) {
            heroList[0].appendChild(cloneItem);
        } else {
            heroList[0].insertBefore(cloneItem, heroListItems[0]);
        }

        //update animatingInIndex after new item is added
        if ( direction === 'up' ) {
            animatingInIndex = heroListItems.length - 1;
        } else {
            animatingOutIndex = heroListItems.length - 1;
        }

        heroListItems[animatingOutIndex].setAttribute('style', 'height: 0px; margin: 0');

        //getComputedStyle forces opacity 0 to take effect before changing to opacity 1 to activate transition
        window.getComputedStyle(heroListItems[animatingInIndex]).height;
        heroListItems[animatingInIndex].setAttribute('style', 'height: 50px; margin: 25px 0');

        heroListItems[animatingInIndex].addEventListener(transitionEvent, function(e) {
            if (e.propertyName === 'height') {
                //remove current event listener
                this.removeEventListener(transitionEvent, arguments.callee);
                console.log('animationCycle2= ' + animationCycle);
                heroList[0].removeChild(heroListItems[animatingOutIndex]);
                animatingList = false;
                //heroListItems[heroListItems.length - 1].classList.remove('hero__list-item--transition-ease-in', 'hero__list-item--transition-ease-out');
                if (animationCycle === -1) {
                    //debugger;
                    cycleList(cycleDirection);
                    return;
                }
                console.log('class check= ' + heroList[0].classList.contains('hero__list--transition-ease-out'));
                if ( heroList[0].classList.contains('hero__list--transition-ease-out') || animationCycle === 0 ) {
                    const activeListItem = document.getElementsByClassName( 'hero__list-item--active' );
                    changeFeatured( activeListItem[0].dataset.key );
                }
                heroList[0].classList.remove('hero__list--transition-ease-in', 'hero__list--transition-ease-out');
            } 
        });
    }
    
    
    function updateListItems() {
        for ( var i = 0; heroListItems.length > i; i++ ) {
            heroListItems[i].classList.remove( 'hero__list-item--active', 'hero__list-item--white', 'hero__list-item--faded' );
            heroListItems[i].removeEventListener( 'mouseenter', cycleList );
            
            if ( i == currentIndex ) {
                heroListItems[i].classList.add( 'hero__list-item--active' );
            } else if ( i == currentIndex + 2 || i == currentIndex - 2 ) {
                heroListItems[i].classList.add( 'hero__list-item--faded' );
            } else if ( i == currentIndex + 1 || i == currentIndex - 1 ) {
                heroListItems[i].classList.add( 'hero__list-item--white' );
            }
        }
    }
    
    
    function changeFeatured( activeKey ) {
        console.log('changeFeatured test');
        for ( var i = 0; heroListImages.length > i; i++ ) {
            if ( heroListImages[i].dataset.key == activeKey ) {
                heroListImages[i].classList.add( 'hero__image--active' );
            } else {
                heroListImages[i].classList.remove( 'hero__image--active' );
            }
        }
        
    }
    
    
    /*
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
    */
    
}());