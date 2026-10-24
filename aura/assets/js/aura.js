/**
 * Aura: tiny progressive enhancements. No dependencies, deferred.
 *
 * 1. Adds a soft shadow to the sticky header after the page scrolls.
 * 2. Reveals elements with the "aura-reveal" class on scroll (IntersectionObserver).
 *
 * Both respect prefers-reduced-motion and the "Disable animations" Customizer option.
 */
( function () {
	'use strict';

	var root = document.documentElement;
	var body = document.body;
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var animationsOff = body.classList.contains( 'aura-no-animations' ) || reduceMotion;

	// 1. Header elevation.
	var header = document.querySelector( '.aura-header' );
	if ( header ) {
		var onScroll = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
		};
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	// 2. Scroll reveal.
	var items = document.querySelectorAll( '.aura-reveal' );
	if ( ! items.length ) {
		return;
	}

	var showAll = function () {
		items.forEach( function ( el ) {
			el.classList.add( 'is-revealed' );
		} );
	};

	if ( animationsOff || ! ( 'IntersectionObserver' in window ) ) {
		showAll();
		return;
	}

	root.classList.add( 'aura-js' );

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-revealed' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
	);

	items.forEach( function ( el ) {
		if ( el.classList.contains( 'is-revealed' ) ) {
			return;
		}
		observer.observe( el );
	} );
} )();
