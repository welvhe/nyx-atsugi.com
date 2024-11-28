<?php
add_theme_support( 'post-thumbnails' );
add_filter('wp_calculate_image_srcset_meta', '__return_null');
//画像アップロード時サムネイルを作らない
function not_create_image($sizes){
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['post-thumbnail']);# 1200x800
    unset($sizes['1536x1536']);
    unset($sizes['twentytwenty-fullscreen']);# 1980x1320
    unset($sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'not_create_image');
add_image_size( 'custom',250, 250, array( 'center', 'center')  );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action('wp_head','rest_output_link_wp_head');
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
add_filter( 'emoji_svg_url', '__return_false' );
add_action( 'wp_enqueue_scripts', 'remove_my_global_styles' );
function remove_my_global_styles() {
    wp_dequeue_style( 'global-styles' );
}
add_action('wp', function(){
    // if(is_home() || is_front_page()) return;
    remove_action('wp_head','wp_oembed_add_discovery_links');
    remove_action('wp_head','wp_oembed_add_host_js');
    function my_deregister_scripts(){
        wp_deregister_script( 'wp-embed' );
    }
    add_action( 'wp_footer', 'my_deregister_scripts' );
});
add_action('wp', function(){
    if(is_page('contact')) return;
    add_filter('wpcf7_load_js', '__return_false');
    add_filter('wpcf7_load_css', '__return_false');
});
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_true' );
// 編集者に設定メニューを追加
// function add_theme_caps(){
//     $role = get_role( 'editor' );
//     $role->remove_cap( 'manage_options' );
// }
// add_action( 'admin_init', 'add_theme_caps' );
// icoを許可
function add_mimes($mimes) {
  $mimes['ico']  = 'image/vnd.microsoft.icon';
  return $mimes;
}
add_filter('upload_mimes','add_mimes');

function get_text($target) {
    $result = preg_split("/\s/",$target);
    return $result;
}
function getParamVal($param) {
    $val = (isset($_GET[$param]) && $_GET[$param] != '') ? $_GET[$param] : '';
    $val = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
    return $val;
}
// shema.orgの所在地項目の自動化
function separate_address(string $address)
{
    if (preg_match('@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u', $address, $matches) !== 1) {
        return [
            'state' => null,
            'city' => null,
            'other' => null
        ];
    }
    return [
        'state' => $matches[1],
        'city' => $matches[2],
        'other' => $matches[3],
    ];
}
?>