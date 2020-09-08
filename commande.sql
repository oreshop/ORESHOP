/***********************
TT LES COMMANDES
*******************/ 
select
    p.ID as order_id,
    p.post_date,
     max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_email,
    max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_first_name,
    max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_last_name,
    max( CASE WHEN pm.meta_key = '_billing_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_1,
    max( CASE WHEN pm.meta_key = '_billing_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_2,
    max( CASE WHEN pm.meta_key = '_billing_city' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_city,
    max( CASE WHEN pm.meta_key = '_billing_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_state,
    max( CASE WHEN pm.meta_key = '_billing_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_postcode,
    max( CASE WHEN pm.meta_key = '_shipping_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_first_name,
    max( CASE WHEN pm.meta_key = '_shipping_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_last_name,
    max( CASE WHEN pm.meta_key = '_shipping_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_1,
    max( CASE WHEN pm.meta_key = '_shipping_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_2,
    max( CASE WHEN pm.meta_key = '_shipping_city' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_city,
    max( CASE WHEN pm.meta_key = '_shipping_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_state,
    max( CASE WHEN pm.meta_key = '_shipping_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_postcode,
    max( CASE WHEN pm.meta_key = '_order_total' and p.ID = pm.post_id THEN pm.meta_value END ) as order_total,
    max( CASE WHEN pm.meta_key = '_order_tax' and p.ID = pm.post_id THEN pm.meta_value END ) as order_tax,
    max( CASE WHEN pm.meta_key = '_paid_date' and p.ID = pm.post_id THEN pm.meta_value END ) as paid_date,
    ( select group_concat( order_item_name separator '|' ) from wp_woocommerce_order_items where order_id = p.ID ) as order_items
from
    wp_posts as p,
    wp_postmeta as pm,
    wp_term_relationships as wptr
where
    post_type = 'shop_order' and
    p.ID = pm.post_id and
    post_date BETWEEN '2019-01-31' AND '2019-08-01'
group by
 p.ID


 /********
 TT LES PRODUTIS
 ***********/
 SELECT * FROM `wp_posts` WHERE `post_type` ='product' ORDER BY `post_type` DESC

 /***************
 PROCDUCTS x STOCKS
 *****************/
SELECT
	wp_posts.post_title AS Product,
	wp_postmeta1.meta_value AS SKU,
	wp_postmeta2.meta_value AS Price,
	GROUP_CONCAT( wp_terms.name ORDER BY wp_terms.name SEPARATOR ', ' ) AS ProductCategories
FROM wp_posts
LEFT JOIN wp_postmeta wp_postmeta1
	ON wp_postmeta1.post_id = wp_posts.ID
	AND wp_postmeta1.meta_key = '_sku'
LEFT JOIN wp_postmeta wp_postmeta2
	ON wp_postmeta2.post_id = wp_posts.ID
	AND wp_postmeta2.meta_key = '_regular_price'
LEFT JOIN wp_term_relationships
	ON wp_term_relationships.object_id = wp_posts.ID
LEFT JOIN wp_term_taxonomy
	ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	AND wp_term_taxonomy.taxonomy = 'product_cat'
LEFT JOIN wp_terms
	ON wp_term_taxonomy.term_id = wp_terms.term_id
WHERE wp_posts.post_type = 'product'
AND wp_posts.post_status = 'publish'
GROUP BY wp_posts.ID
ORDER BY wp_posts.post_title ASC