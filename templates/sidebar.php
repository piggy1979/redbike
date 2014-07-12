<?php 
if(is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() || is_woocommerce() ){
//if(is_product()){
dynamic_sidebar('woo-shop'); 
}else{
dynamic_sidebar('sidebar-primary'); 
}


?>
