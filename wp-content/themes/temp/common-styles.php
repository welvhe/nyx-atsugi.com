<?php
global $thema_color;
global $sub_color;
global $title_color;
global $title_font;
global $sub_title_color;
global $text_color;
global $text_font;
global $border_color;
global $logo;
global $logo_width;
global $sp_logo_width;
global $header_menu_line_color;
global $header_border_color;
global $main_nav_thematype;
global $main_nav_bg_color;
global $main_nav_boder_color;
global $main_nav_text_underline_color;
global $main_nav_text_color;
global $main_nav_inversion_text_color;
global $main_nav_english_font;
global $main_nav_inversion_color01;
global $main_nav_contact_text_color;
global $main_nav_contact_bg_color;
global $main_nav_sns_icon_color;
global $main_nav_sns_icon_color;
global $button_shape_thema_type;
global $button_color;
global $button_bg_color;
global $button_border_color;
global $schedule_thema_type;
global $schedule_title_text;
global $schedule_period_thema_type;
global $schedule_period;
global $schedule_selector_active_bg_color;
global $schedule_selector_active_text_color;
global $schedule_selector_active_border_color;
global $schedule_period_text_color;
global $schedule_period_bg_color;
global $schedule_period_border_color;
global $sns_icon_color;
global $sns_icon_bg_color;
global $schedule_cast_name_text_color;
global $schedule_cast_name_bg_color;
global $in_the_store_today_bg_color;
global $in_the_store_today_text_color;
global $in_the_store_today_border_color;
global $working_hours_bg_color;
global $working_hours_color;
global $schedule_link_button_text;
global $sns_thema_type;
global $sns_link_button_text;
global $shop_photo_thema_type;
global $shop_photo_link_button_text;
global $modal_thema_type;
global $modal_top_block_text_color;
global $modal_top_block_bg_color;
global $modal_today_attend_text_color;
global $modal_today_attend_bg_color;
global $modal_today_attend_border_color;
global $modal_today_attend_inversion_text_color;
global $modal_today_attend_inversion_bg_color;
global $modal_today_attend_inversion_border_color;
global $modal_sns_icon_color;
global $modal_sns_icon_bg_color;
// コンセプト用フィールド
global $concept_img;
global $concept_title;
global $concept_title_align;
global $concept_title_border;
global $concept_detail;
global $concept_detail_align;
global $concept_order;
global $concept_title_font;
global $concept_detail_font;
?>

<style type="text/css">
body {
  font-family: "<?php echo $text_font; ?>";
  color: <?php echo $text_color; ?>;
}
a {
  color: <?php echo $text_color; ?>;
}
.thema_bg_color {
  background-color: <?php echo $thema_color; ?>;
}
.sub_bg_color {
  background-color: <?php echo $sub_color; ?>;
}
.header_border_color {
  border-color: <?php echo $header_border_color; ?>;
}
#sp-menu-btn span {
  background-color: <?php echo $header_menu_line_color; ?>;
}
.drawer_gray_out_bgcolor {
 background-color: <?php echo $sub_color; ?>;
}
.title_style {
  color: <?php echo $title_color ?>;
  font-family: "<?php echo $title_font; ?>";
}
.sub_title_style {
  color: <?php echo $sub_title_color ?>;
}
.text_style {
  color: <?php echo $text_color; ?>;
}
#breadcrumbs ol li:after {
  color: <?php echo $text_color; ?>;
}
.border_color {
  border-color: <?php echo $border_color; ?>;
}
.logo_width {
  width: <?php echo $logo_width; ?>px;
}
.sp_logo_width {
    width: <?php echo $sp_logo_width; ?>px;
}
<?php
$v = str_replace('#', '', $main_nav_bg_color);
$v = str_split($v,2);
$n1 = hexdec($v[0]);
$n2 = hexdec($v[1]);
$n3 = hexdec($v[2]);
?>
.main_nav_bg_color {
  background-color: rgba(<?php echo $n1; ?>, <?php echo $n2; ?>, <?php echo $n3; ?>, 0.85);
}
.main_nav_border_color {
  border-color: <?php echo $main_nav_boder_color; ?>;
}
.main_nav_text_underline_color {
  border-color: <?php echo $main_nav_text_underline_color; ?>;
}
nav.main-nav div ul:first-of-type li a{
  fill: <?php echo $main_nav_text_underline_color; ?>;
}
nav.main-nav div ul li a h2:after {
  background-color: <?php echo $main_nav_text_underline_color; ?>;
}
.main_nav_text_color {
  color: <?php echo $main_nav_text_color; ?>;
}
.main_nav_english_font {
  font-family: "<?php echo $main_nav_english_font; ?>";
}
.main-nav h2::after {
  background-color: <?php echo $main_nav_boder_color; ?>;
}
.main_nav_active {
  background-color: <?php echo $main_nav_inversion_color01; ?>;
  fill: <?php echo $main_nav_inversion_text_color; ?>;
}
.main_nav_active .main_nav_text_color {
  color: <?php echo $main_nav_inversion_text_color; ?>;
}
.main_nav_contact_text_color {
  color: <?php echo $main_nav_contact_text_color; ?>;
}
.main_nav_contact_bg_color {
  background-color: <?php echo $main_nav_contact_bg_color; ?>;
}
.main_nav_contact_icon_color {
  fill: <?php echo $main_nav_contact_text_color; ?>;
}
.main_nav_sns_icon_color {
  fill: <?php echo $main_nav_sns_icon_color; ?>;
}
.button_style {
  color: <?php echo $button_color ?>;
  background-color: <?php echo $button_bg_color; ?>;
  border-color: <?php echo $button_border_color ?>;
}
.schedule_period_text_color {
  color: <?php echo $schedule_period_text_color; ?>;
}
.schedule_period_style {
  background-color: <?php echo $schedule_period_bg_color; ?>;
  border-color: <?php echo $schedule_period_border_color; ?>;
}
.schedule_period_arrow_color {
  fill: <?php echo $schedule_period_text_color; ?>;
}
.schedule_selector_active_style {
  background-color: <?php echo $schedule_selector_active_bg_color; ?>;
  border-color: <?php echo $schedule_selector_active_border_color; ?>;
}
.schedule_selector_active_style a,.schedule_selector_active_style span {
  color: <?php echo $schedule_selector_active_text_color; ?>;
}
.sns_icon_color {
  fill: <?php echo $sns_icon_color; ?>;
}
.sns_icon_bg_color {
  background-color: <?php echo $sns_icon_bg_color; ?>;
}
<?php if($schedule_thema_type == "luxury") { ?>
.sns_modal_no_img {
  object-fit: cover;
  width: 100%;
  height: 100%;
}
<?php } ?>
.schedule_cast_name_text_color {
  color: <?php echo $schedule_cast_name_text_color; ?>;
}
.schedule_cast_name_bg_color {
  background-color: <?php echo $schedule_cast_name_bg_color; ?>;
}
.schedule_cast_name_bg_color h4:after {
  background-color: <?php echo $schedule_cast_name_bg_color; ?>;
}
.in_the_store_today_style {
  background-color: <?php echo $in_the_store_today_bg_color; ?>;
  color: <?php echo $in_the_store_today_text_color; ?>;
  border-color: <?php echo $in_the_store_today_border_color; ?>;
}
.working_hours_style {
  background-color: <?php echo $working_hours_bg_color; ?>;
  color: <?php echo $working_hours_color; ?>;
}
.modal_top_block_text_color {
	color: <?php echo $modal_top_block_text_color; ?>;
}
.modal_top_block_bg_color {
	background-color: <?php echo $modal_top_block_bg_color; ?>;
}
.modal_today_attend_style {
	color: <?php echo $modal_today_attend_text_color; ?>;
	background-color: <?php echo $modal_today_attend_bg_color; ?>;
	border-color: <?php echo $modal_today_attend_border_color; ?>;
}
.modal_today_attend_inversion_style {
	color: <?php echo $modal_today_attend_inversion_text_color; ?>;
	background-color: <?php echo $modal_today_attend_inversion_bg_color; ?>;
	border-color: <?php echo $modal_today_attend_inversion_border_color; ?>;
}
.modal_sns_icon_color {
	fill: <?php echo $modal_sns_icon_color; ?>;
}
.modal_sns_icon_bg_color {
	background-color: <?php echo $modal_sns_icon_bg_color; ?>;
}

/* concept */
.concept__inner .title_style {
    border-bottom: 1px solid <?= $concept_title_border; ?>;
    text-align: <?= $concept_title_align; ?>;
  }

  .concept__inner .detail_style {
    text-align: <?= $concept_detail_align; ?>;
  }

  .concept__inner .title_style,
  .about h2 {
    font-family: <?= $concept_title_font; ?>;
  }

 .concept__inner .detail_style,
  .about p {
    font-family: <?= $concept_detail_font; ?>;
  }
</style>
