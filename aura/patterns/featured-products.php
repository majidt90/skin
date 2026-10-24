<?php
/**
 * Title: Featured Products Grid
 * Slug: aura/featured-products
 * Categories: aura-sections
 * Keywords: products, grid, shop, woocommerce, featured
 * Description: Four latest products in a Product Collection block. Change the query, columns and card content in the block settings.
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"wide","className":"aura-section aura-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide aura-section aura-reveal is-layout-constrained" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"className":"aura-section__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group aura-section__head is-layout-flex is-wrapped is-content-justification-space-between is-vertically-aligned-bottom"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-layout-constrained"><!-- wp:paragraph {"className":"aura-eyebrow"} -->
<p class="aura-eyebrow">Bestsellers</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Featured products</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/shop/">View all</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":1,"query":{"perPage":4,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxonomy":"","isProductCollectionBlock":true,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"featured":false},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill","fixedWidth":""},"queryContextIncludes":["collection"],"align":"wide"} -->
<div class="wp-block-woocommerce-product-collection alignwide"><!-- wp:woocommerce/product-template -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail"} -->
<!-- wp:woocommerce/product-sale-badge {"align":"right"} /-->
<!-- /wp:woocommerce/product-image -->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium","__woocommerceNamespace":"woocommerce/product-title","style":{"typography":{"lineHeight":"1.4"}}} /-->

<!-- wp:woocommerce/product-price {"fontSize":"small"} /-->

<!-- wp:woocommerce/product-button {"fontSize":"small"} /-->
<!-- /wp:woocommerce/product-template -->

<!-- wp:woocommerce/product-collection-no-results -->
<!-- wp:paragraph -->
<p>No products to show yet.</p>
<!-- /wp:paragraph -->
<!-- /wp:woocommerce/product-collection-no-results --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group -->
