<?php
date_default_timezone_set("Asia/Tokyo");
// グルーバル変数セット
// ページ共通
global $favicon_img;
global $ogp_img;
global $search_consol_tag;
global $analytics_tag;
global $ads_tag;
global $cast_recruit_tel_tag;
global $cast_recruit_line_tag;
global $staff_recruit_tel_tag;
global $staff_recruit_line_tag;
global $staff_recruit_page_exsitance_flg;
global $staff_recruit_url;
global $calendar_page_exsitance_flg;
global $course_menu_page_exsitance_flg;
global $coupon_page_exsitance_flg;
global $contact_page_exsitance_flg;
global $no_img;
global $shop_id;
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
global $in_the_store_today_bg_color;
global $in_the_store_today_text_color;
global $in_the_store_today_border_color;
global $working_hours_bg_color;
global $working_hours_color;
global $schedule_link_button_text;
global $sns_thema_type;
global $sns_link_button_text;
global $schedule_cast_name_text_color;
global $schedule_cast_name_bg_color;
global $shop_photo_thema_type;
global $shop_photo_link_button_text;
global $map_iframe;
global $footer_thema_type;
global $footer_bg_color;
global $footer_logo;
global $footer_logo_width;
global $sp_footer_logo_width;
global $footer_text_color;
global $footer_nav_border_color;
global $footer_tel_icon_color;
global $footer_tel_icon_bg_color;
global $tel;
global $tel_font;
global $location;
global $business_hours_open_time;
global $business_hours_store_holiday;
global $footer_sns_icon_color;
global $footer_sns_icon_bg_color;
global $group_ten_mother_logo;
global $group_ten_mother_url;
global $group_sister_store;
global $group_sister_store_column_count;
global $sp_group_sister_store_column_count;
global $group_sister_store_column_int;
global $sp_group_sister_store_column_int;
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
global $modal_sns_icon_bg_color;
global $schedule_exsitance_status;
// グローバルカスタムフィールドセット
$favicon_img = scf::get('ファビコン画像', 34);
$ogp_img = scf::get('OGP画像', 34);
$search_consol_tag = scf::get('サーチコンソールタグ埋め込み', 34);
$analytics_tag = scf::get('アナリティクスタグ埋め込み', 34);
$ads_tag = scf::get('コンバージョンタグ埋め込み', 34);
$cast_recruit_tel_tag = scf::get('キャスト求人電話用コンバージョンタグ', 593);
$cast_recruit_line_tag = scf::get('キャスト求人LINE用コンバージョンタグ', 593);
$staff_recruit_tel_tag = scf::get('スタッフ求人電話用コンバージョンタグ', 714);
$staff_recruit_line_tag = scf::get('スタッフ求人LINE用コンバージョンタグ', 714);
$staff_recruit_page_exsitance_flg = scf::get('スタッフ求人ページが存在', 34);
$use_group_staff_recruit = scf::get('グループ店ホームページのスタッフ求人ページの利用', 34);
$calendar_page_exsitance_flg = '';
$coupon_page_exsitance_flg = '';
$calendar_page_exsitance_flg = scf::get('カレンダーページあり', 352);
$coupon_page_exsitance_flg = scf::get('クーポンページあり', 522);
if ($coupon_page_exsitance_flg !== false) {
    $coupon_page_exsitance_flg = 1;
}
if ($calendar_page_exsitance_flg !== false) {
    $calendar_page_exsitance_flg = 1;
}
$schedule_exsitance_flg = '';
$schedule_exsitance_flg = scf::get('スケジュールブロックあり', 364);
if ($schedule_exsitance_flg !== false) {
    $schedule_exsitance_flg = 1;
}else{
    $schedule_exsitance_status = "schedule";
}

$course_menu_page_exsitance_flg = scf::get('コースメニューページあり', 3154);
$contact_page_exsitance_flg = scf::get('コンタクトページあり', 3180);
$group_staff_recruit_url = scf::get('グループ店ホームページのスタッフ求人ページのURL', 34);
if ($group_staff_recruit_url && $use_group_staff_recruit) {
    $staff_recruit_url = str_replace('http://', 'https://', $group_staff_recruit_url);
} else {
    $staff_recruit_url = site_url('staff-recruit');
}
$no_img = scf::get('画像未登録の時の代替え画像', 34);
$shop_id = scf::get('店舗ID', 34);
$thema_color = scf::get('テーマカラー', 34);
$sub_color = scf::get('サブカラー', 34);
$title_color = scf::get('タイトルの文字色', 34);
$sub_title_color = scf::get('サブタイトルの文字色', 34);
$title_font = scf::get('タイトルのフォント', 34);
$text_color = scf::get('文章の文字色', 34);
$text_font = scf::get('文章のフォント', 34);
$border_color = scf::get('枠線の色', 34);
$logo = scf::get('ロゴ', 34);
$logo_width = scf::get('ロゴの横幅', 34);
$sp_logo_width = ($logo_width * 0.664);
$slider_button_bg = scf::get('スライダーボタン背景', 34);
$slider_button_color = scf::get('スライダーボタン文字色', 34);
$header_menu_line_color = scf::get('メニュー三本ラインの色', 34);
$header_border_color = scf::get('ヘッダー枠線の色', 34);
$main_nav_thematype = scf::get('メインナビのテーマタイプ', 34);
$main_nav_bg_color = scf::get('メインナビの背景色', 34);
$main_nav_boder_color = scf::get('メインナビの枠線色', 34);
$main_nav_text_underline_color = scf::get('メインナビの各ページリンクの下線の色', 34);
$main_nav_text_color = scf::get('メインナビの文字色', 34);
$main_nav_inversion_text_color = scf::get('メインナビのページリンク反転文字色', 34);
$main_nav_english_font = scf::get('メインナビリストの英字フォント', 34);
$main_nav_inversion_color01 = scf::get('メインナビのページリンク背景反転色', 34);
$main_nav_contact_text_color = scf::get('メインナビのお問い合わせ文字色', 34);
$main_nav_contact_bg_color = scf::get('メインナビのお問い合わせ背景色', 34);
$main_nav_sns_icon_color = scf::get('メインナビのSNSアイコン色', 34);
$button_shape_thema_type = scf::get('共通リンクボタン形状のテーマタイプ', 34);
$button_color = scf::get('ボタンの文字色', 34);
$button_bg_color = scf::get('ボタンの背景色', 34);
$button_border_color = scf::get('共通リンクボタンの枠線色', 34);
$schedule_thema_type = scf::get('SCHEDULEのテーマタイプ', 34);
$schedule_title_text = scf::get('SCHEDULEのタイトルテキスト', 34);
$schedule_period_thema_type = scf::get('SCHEDULE期間のテーマタイプ', 34);
$schedule_period = scf::get('SCHEDULE期間', 34);
$schedule_selector_active_text_color = scf::get('スケジュールセレクタアクティブの文字色', 34);
$schedule_selector_active_bg_color = scf::get('スケジュールセレクタアクティブの背景色', 34);
$schedule_selector_active_border_color = scf::get('スケジュールセレクタアクティブの枠線色', 34);
$schedule_period_text_color = scf::get('SCHEDULE期間リストの文字色', 34);
$schedule_period_bg_color = scf::get('SCHEDULE期間リストの背景色', 34);
$schedule_period_border_color = scf::get('SCHEDULE期間リストの枠線色', 34);
$sns_icon_color = scf::get('SNSアイコンの色', 34);
$sns_icon_bg_color = scf::get('SNSアイコンの背景色', 34);
$schedule_cast_name_text_color = scf::get('SCHEDULEのキャストネームの文字色', 34);
$schedule_cast_name_bg_color = scf::get('SCHEDULEのキャストネーム帯の背景色', 34);
$in_the_store_today_bg_color = scf::get('SCHEDULEの本日出勤の背景色', 34);
$in_the_store_today_text_color = scf::get('本日出勤の文字色', 34);
$in_the_store_today_border_color = scf::get('本日出勤の枠線色', 34);
$working_hours_bg_color = scf::get('勤務時間の背景色', 34);
$working_hours_color = scf::get('勤務時間の文字色', 34);
$schedule_link_button_text = scf::get('SCHEDULEのリンクボタンテキスト', 34);
$sns_thema_type = scf::get('SNSセクションのテーマタイプ', 34);
$sns_link_button_text = scf::get('SNSセクションのリンクボタンテキスト', 34);
$shop_photo_thema_type = scf::get('SHOP_PHOTOのテーマタイプ', 34);
$shop_photo_link_button_text = scf::get('SHOP_PHOTOのリンクボタンテキスト', 34);
$map_iframe = scf::get('googlemapからiframeをコピぺ', 34);
$map_iframe = str_replace("!4f13.1", "!4f5.1", $map_iframe);
$footer_thema_type = scf::get('フッターのテーマタイプ', 34);
$footer_bg_color = scf::get('フッターの背景色', 34);
$footer_logo = scf::get('フッターロゴ', 34);
$footer_logo_width = scf::get('フッターロゴの横幅', 34);
$sp_footer_logo_width = scf::get('スマホ版フッターロゴの横幅', 34);
$footer_text_color = scf::get('フッターの文字色', 34);
$footer_nav_border_color = scf::get('フッターナビの枠線色', 34);
$footer_tel_icon_color = scf::get('フッターTELアイコンの色', 34);
$footer_tel_icon_bg_color = scf::get('フッターTELアイコンの背景色', 34);
$tel_font = scf::get('フッター電話番号のフォント', 34);
$footer_sns_icon_color = scf::get('フッターSNSアイコンの色', 34);
$footer_sns_icon_bg_color = scf::get('フッターSNSアイコンの背景色', 34);
$group_ten_mother_logo = scf::get('グループ店母体のロゴ', 34);
$group_ten_mother_url = scf::get('グループ店母体のURL', 34);
$group_ten_mother_url = str_replace('http://', 'https://', $group_ten_mother_url);
$group_sister_store = SCF::get('グループ姉妹店のロゴグループ', 34);
$group_sister_store_column_count = SCF::get('PC版グループ店のレイアウトカラム数', 34);
$sp_group_sister_store_column_count = SCF::get('スマホ版グループ店のレイアウトカラム数', 34);
$group_sister_store_column_int = (110 * $group_sister_store_column_count);
$sp_group_sister_store_column_int = (86.5 * $sp_group_sister_store_column_count);
$page_top_button_color = scf::get('ページトップボタンの色', 34);
$page_top_button_bg_color = scf::get('ページトップボタンの背景色', 34);
$modal_thema_type = scf::get('モーダルのテーマタイプ', 34);
$modal_top_block_text_color = scf::get('モーダルトップブロックの文字色', 34);
$modal_top_block_bg_color = scf::get('モーダルトップブロックの背景色', 34);
$modal_today_attend_text_color = scf::get('モーダル本日出勤の文字色', 34);
$modal_today_attend_bg_color = scf::get('モーダル本日出勤の背景色', 34);
$modal_today_attend_border_color = scf::get('モーダル本日出勤の枠線色', 34);
$modal_today_attend_inversion_text_color = scf::get('モーダル本日出勤の反転文字色', 34);
$modal_today_attend_inversion_bg_color = scf::get('モーダル本日出勤の反転背景色', 34);
$modal_today_attend_inversion_border_color = scf::get('モーダル本日出勤の反転枠線色', 34);
$modal_sns_icon_color = scf::get('モーダルSNSアイコンの色', 34);
$modal_sns_icon_bg_color = scf::get('モーダルSNSアイコンの背景色', 34);

//management_system
$DB_host        = 'main-test1-db.cbcxa5lv23yo.ap-northeast-1.rds.amazonaws.com';
$DB_database    = 'management_system';
$DB_user        = 'admin';
$DB_password    = 'XdB2atTzPBAtEZrSssXMWnRTuLaKxtJ5';
// error_reporting(0);
// $DB_host        = '127.0.0.1';
// $DB_database    = 'management_system';
// $DB_user        = 'root';
// $DB_password    = '';
$dsn = "mysql:dbname={$DB_database};host={$DB_host}";
try {
    $pdo = new PDO($dsn, $DB_user, $DB_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // echo "接続に成功しました。<br>";
} catch (PDOException $e) {
    // echo "接続に失敗しました。{$e->getMessage()}<br>";
}
$shop_id = scf::get('店舗ID', 34);
$casts_count_sql = "SELECT count(id) FROM `casts` WHERE `shop_id` = " . $shop_id . " AND `cabaweb_privacy` = 1";
$casts_count = $pdo->prepare($casts_count_sql);
$casts_count->execute();
$casts_count = $casts_count->fetch(PDO::FETCH_ASSOC);

$shop_sql = "SELECT * FROM shops WHERE id = " . $shop_id;
$shop = $pdo->prepare($shop_sql);
$shop->execute();
$shop = $shop->fetch(PDO::FETCH_ASSOC);

$for_count_photos_sql = "SELECT `image_url` FROM `shop_images` WHERE `shop_id` = " . $shop_id . " and `images_subject` <> 'TOP' order by `image_number` ASC";
$for_count_photos = $pdo->prepare($for_count_photos_sql);
$for_count_photos->execute();
$for_count_photos = $for_count_photos->fetchAll(PDO::FETCH_ASSOC);
$for_count_photos = count($for_count_photos);

$shop_sns_sql = "SELECT `instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url` FROM `sns` WHERE `subject_id` = " . $shop_id . " and `subject_name` = 'shop' and `main_sns_set` = 1";
$shop_sns_list = $pdo->prepare($shop_sns_sql);
$shop_sns_list->execute();
$shop_sns_list = $shop_sns_list->fetch(PDO::FETCH_ASSOC);

$shop_google_map_sql   = "SELECT `work_location_googlemap` FROM `cast_recruits` WHERE `subject_id` = " . $shop_id . " and `cabaweb_privacy` = 1";
$shop_google_map = $pdo->prepare($shop_google_map_sql);
$shop_google_map->execute();
$shop_google_map = $shop_google_map->fetch(PDO::FETCH_ASSOC);
// $shop_group_cast_q_a_list->execute();
// $shop_group_staff_q_a_list->execute();

// schema.org用
global $store_name;
$store_name = $shop['name'];
global $mono_international_tel;
$mono_international_tel = substr_replace($shop['phone_number'], '+81', 0, 1);
global $mono_sns01;
$mono_sns01 = "";
if (!empty($shop_sns_list['instagram_account_url'])) {
    $mono_sns01 = $shop_sns_list['instagram_account_url'] = str_replace('http://', 'https://', $shop_sns_list['instagram_account_url']);
}
global $mono_sns02;
$mono_sns02 = "";
if (!empty($shop_sns_list['youtube_account_url'])) {
    $mono_sns02 = $shop_sns_list['youtube_account_url'] = str_replace('http://', 'https://', $shop_sns_list['youtube_account_url']);
}
global $mono_sns03;
$mono_sns03 = "";
if (!empty($shop_sns_list['twitter_account_url'])) {
    $mono_sns03 = $shop_sns_list['twitter_account_url'] = str_replace('http://', 'https://', $shop_sns_list['twitter_account_url']);
}
global $mono_sns04;
$mono_sns04 = "";
if (!empty($shop_sns_list['tiktok_account_url'])) {
    $mono_sns04 = $shop_sns_list['tiktok_account_url'] = str_replace('http://', 'https://', $shop_sns_list['tiktok_account_url']);
}
global $mono_sns05;
$mono_sns05 = "";
global $mono_priceRange;
$mono_priceRange = "￥4,000～￥10,000,000";
global $address_array;
$address_full_string = '';
$address_full_string = $shop['shop_address'];
if ($address_full_string) {
    $address_array = separate_address($address_full_string);
}
global $mono_streetAddress;
$mono_streetAddress = $address_array['other'];
global $mono_addressLocality;
$mono_addressLocality = $address_array['city'];
global $mono_addressRegion;
$mono_addressRegion = $address_array['state'];
global $mono_postalCode;
$mono_postalCode = scf::get('キャストの勤務地の郵便番号', 593);
global $mono_cast_hasMap;
$mono_hasMap = $shop_google_map['work_location_googlemap'];
global $mono_openingHours;
$mono_openingHours = "Mo-Fr 14:00-23:00";
global $mono_latitude;
if ($shop_google_map['work_location_googlemap']) {
    $googlemap_full_string = $shop_google_map['work_location_googlemap'];
    $start = mb_strpos($googlemap_full_string, '@') + 1;
    $end = mb_strpos($googlemap_full_string, ',');
    $mono_latitude = mb_substr($googlemap_full_string, $start, $end - $start);
    global $mono_longitude;
    $start = mb_strpos($googlemap_full_string, ',') + 1;
    $end = mb_strpos($googlemap_full_string, ',', strpos($googlemap_full_string, ',') + 1);
    $mono_longitude = mb_substr($googlemap_full_string, $start, $end - $start);
}

// コンセプト用フィールド====================================
global $concept_img;
$concept_img = scf::get('コンセプト画像', 34);

global $concept_title;
$concept_title = scf::get('コンセプトタイトル', 34);

global $concept_title_align;
$concept_title_align = scf::get('コンセプトタイトル段落', 34);

global $concept_title_border;
$concept_title_border = scf::get('コンセプトタイトル下線色', 34);

global $concept_detail;
$concept_detail = scf::get('コンセプト詳細', 34);

global $concept_detail_align;
$concept_detail_align = scf::get('コンセプト詳細段落', 34);

global $concept_order;
$concept_order = scf::get('コンセプト配置');

global $concept_title_font;
$concept_title_font = scf::get('コンセプトタイトルフォント', 34);

global $concept_detail_font;
$concept_detail_font = scf::get('コンセプト詳細フォント', 34);
