<?php
/**
 * Title: Hero - Split
 * Slug: aura/hero
 * Categories: aura-sections
 * Keywords: hero, banner, intro, landing
 * Description: Split hero with eyebrow, headline, lead text, two buttons and a gradient visual you can replace with an image.
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","className":"aura-hero aura-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aura-hero aura-reveal is-layout-constrained" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"aura-eyebrow"} -->
<p class="aura-eyebrow">New season is here</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Everyday essentials, made to last.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large","textColor":"muted"} -->
<p class="has-muted-color has-text-color has-large-font-size">Thoughtfully made products, fast delivery and simple returns. Find the pieces that fit your life.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/shop/">Shop now</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/shop/">Browse categories</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"aura-hero__visual","style":{"color":{"gradient":"linear-gradient(135deg,#EEF2FF 0%,#C7D2FE 45%,#818CF8 100%)"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group aura-hero__visual has-background is-layout-constrained" style="background:linear-gradient(135deg,#EEF2FF 0%,#C7D2FE 45%,#818CF8 100%)"></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
