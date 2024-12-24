<?php


function eiliyah_get_product_stock($product_id)
{
    return get_post_meta($product_id, '_total_stocks', true);
}

function eiliyah_get_product_sold($product_id)
{
    return get_post_meta($product_id, '_total_sold', true);
}
