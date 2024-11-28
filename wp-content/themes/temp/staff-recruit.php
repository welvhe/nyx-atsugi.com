<?php
/*
Template Name:staff-recruit
*/ query_posts('post');
require("setting.php");
$staff_recruit_sql  = "SELECT * FROM `staff_recruits` WHERE `subject_id` = " . $shop_id . " and `cabaweb_privacy` = 1";
$staff_recruit = $pdo->prepare($staff_recruit_sql);
$staff_recruit->execute();
$staff_recruit = $staff_recruit->fetch(PDO::FETCH_ASSOC);

$staff_q_a_sql = "SELECT `priority`,`question`,`answer` FROM `q_a` WHERE `type` = 'staff' AND `subject_id` = " . $shop_id . " AND `subject_name` = 'shop'";
$staff_q_a_list = $pdo->prepare($staff_q_a_sql);
$staff_q_a_list->execute();
$qa_list = $staff_q_a_list->fetchAll(PDO::FETCH_ASSOC);
$sort_key_priority = array_column($qa_list, 'priority');
array_multisort(
  $sort_key_priority,
  SORT_ASC,
  SORT_NUMERIC,
  $qa_list
);

$shop_sql   = "SELECT * FROM `shops` WHERE `id` = " . $shop_id ."";
$shop = $pdo->prepare($shop_sql);
$shop->execute();
$shop = $shop->fetch(PDO::FETCH_ASSOC);

$image_url_sql = "SELECT image_url FROM shop_images WHERE shop_id = :shop_id AND images_subject = 'サムネ' LIMIT 1";

$stmt = $pdo->prepare($image_url_sql);
$stmt->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
$stmt->execute();
$image_url = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php
//google for jobsの設定
//住所の分類
$shop_address = $shop['shop_address'];
if (preg_match('/^(.+?[道||都|府|県])(.+?[区|市|町|村|郡])(.+)/u', $shop_address, $matches)) {
  $addressRegion = $matches[1];
  $addressLocality = $matches[2];
  $streetAddress = $matches[3];
} else {
  $addressRegion = null;
  $addressLocality = null;
  $streetAddress = null;
}

//日付データ取得
$currentYear = date('Y');   // 現在の年を取得
$currentMonth = date('m');  // 現在の月を取得
$dateString = sprintf("20%s-%s-01", substr($currentYear, 2), $currentMonth);

//給与単位と金額
$string = $staff_recruit['salary_text_0'];

$pattern = '/(日給|時給|週給|月給|年給)\s*[\￥]*(\d+(?:,\d{3})*)(万円|千円|円)?\s*[^￥\d]*$/u';

$salaryType = null;
$amount = null;
$unit_type = null;

if (preg_match($pattern, $string, $matches)) {
  $salaryType = $matches[1];
  $amount = $matches[2];
  $currencyType = $matches[3];

  $amount = str_replace([',', '￥'], '', $amount);

  switch ($currencyType) {
    case '万円':
      $amount *= 10000;
      break;
    case '千円':
      $amount *= 1000;
      break;
    case '円':
      break;
    default:
      break;
  }

  // 給与単位によって値を設定
  switch ($salaryType) {
    case '時給':
      $unit_type = 'HOUR';
      break;
    case '日給':
      $unit_type = 'DAY';
      break;
    case '週給':
      $unit_type = 'WEEK';
      break;
    case '月給':
      $unit_type = 'MONTH';
      break;
    case '年給':
      $unit_type = 'YEAR';
      break;
    default:
      $unit_type = null;
      break;
  }
}

$schemas =[ 
  "@context" => "http://schema.org",
  "@type" => "JobPosting",
  "title" => $staff_recruit['occupation'],
  "description" => join("\n", [
    $staff_recruit['recruit_pr'],"",
    $staff_recruit['salary_title_0'],
    $staff_recruit['salary_text_0'],
    $staff_recruit['salary_remarks_0'],"",
    $staff_recruit['salary_title_1'],
    $staff_recruit['salary_text_1'],
    $staff_recruit['salary_remarks_1'],"",
    $staff_recruit['salary_title_2'],
    $staff_recruit['salary_text_2'],
    $staff_recruit['salary_remarks_2'],"",
    $staff_recruit['salary_title_3'],
    $staff_recruit['salary_text_3'],
    $staff_recruit['salary_remarks_3'],"",
    $staff_recruit['salary_title_4'],
    $staff_recruit['salary_text_4'],
    $staff_recruit['salary_remarks_4'],"",
    $staff_recruit['salary_title_5'],
    $staff_recruit['salary_text_5'],
    $staff_recruit['salary_remarks_5'],"",
    $staff_recruit['salary_title_6'],
    $staff_recruit['salary_text_6'],
    $staff_recruit['salary_remarks_6'],"",
    $staff_recruit['salary_title_7'],
    $staff_recruit['salary_text_7'],
    $staff_recruit['salary_remarks_7'],"",
    $staff_recruit['salary_title_8'],
    $staff_recruit['salary_text_8'],
    $staff_recruit['salary_remarks_8'],"",
    $staff_recruit['salary_title_9'],
    $staff_recruit['salary_text_9'],
    $staff_recruit['salary_remarks_9'],"",
    $staff_recruit['qualification'],"",
    $staff_recruit['working_days'],"",
    $staff_recruit['working_time']
  ]),
  "datePosted" => $dateString,
  "hiringOrganization" => [
    "@type" => "Organization",
    "name" => $shop['name'],
    "sameAs" => $shop['url'].'staff-recruit',
    "logo" => $image_url['image_url']
  ],
  "jobLocation" => [
    "@type" => "Place",
    "address" => [
      "@type" => "PostalAddress",
      "addressCountry" => "JP",
      "postalCode" => $shop['shop_postcode'],
      "addressRegion" => $addressRegion,
      "addressLocality" => $addressLocality,
      "streetAddress" => $streetAddress,
    ]
  ],
  "baseSalary" => [
    "@type" => "MonetaryAmount",
    "currency" => "JPY",
    "value" =>[
      "@type" => "QuantitativeValue",
      "value" => "$amount",
      "unitText" => "$unit_type"
    ]
  ]
];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <?php
  echo $analytics_tag;
  echo PHP_EOL;

  echo $ads_tag;
  echo PHP_EOL;

  echo $staff_recruit_tel_tag;
  echo PHP_EOL;

  echo $staff_recruit_line_tag;
  echo PHP_EOL;
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  $page_title = scf::get('ページタイトル');
  $page_description = scf::get('ページ説明文');
  ?>
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="<?php echo $page_description; ?>">
  <link rel="canonical" href="<?= site_url('staff-recruit'); ?>/">
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/staff-recruit_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/staff-recruit_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/staff-recruit-freelayout_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/staff-recruit-freelayout_sp.css" />
  <link rel="icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="shortcut icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="apple-touch-icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <!-- jquery読込 -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
  <!-- og関連 -->
  <meta property="og:url" content="<?= site_url('staff-recruit'); ?>/" />
  <meta property="og:type" content="website" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="<?php echo $page_title; ?>" />
  <meta property="og:description" content="<?php echo $page_description; ?>" />
  <meta property="og:site_name" content="<?php echo $store_name; ?>のWebサイト" />
  <meta property="og:image" content="<?php echo wp_get_attachment_url($ogp_img); ?>" />

  <?php
  $ua = $_SERVER['HTTP_USER_AGENT'];
  if ((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />';
  } else {
    echo '<meta name="viewport" content="width=1180" />';
  }
  ?>

  <?php
  wp_deregister_style('wp-block-library');
  wp_head();
  ?>

  <script type="application/ld+json">
    <?php echo json_encode($schemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
  </script>
</head>

<?php
// カレンダーページカスタムフィールドセット
$staff_recruit_eyecatch = scf::get('スタッフ求人のアイキャッチ');
$staff_recruit_eyecatch02 = scf::get('スタッフ求人のアイキャッチ②');
$staff_recruit_cont_kingaku_bg_color = scf::get('スタッフ求人のアイキャッチ②背景色');
$staff_recruit_eyecatch = scf::get('スタッフ求人のアイキャッチ');
$staff_recruit_thema_type = scf::get('STAFF-RECRUITのテーマタイプ');
$staff_recruit_faq_thema_type = scf::get('スタッフ求人ページのよくある質問のテーマタイプ');
$staff_recruit_sub_title_text_color = scf::get('スタッフ求人ページのサブタイトルの文字色');
$faq_title_text_font = scf::get('スタッフ求人ページのよくある質問のタイトルのフォント');
if ($faq_title_text_font == 'CenturyGothicPro-Bold') {
  $faq_title_text_font_size = 60;
  $sp_faq_title_text_font_size = 30;
} else {
  $faq_title_text_font_size = 48;
  $sp_faq_title_text_font_size = 21;
}
$faq_title_text = scf::get('スタッフ求人ページのよくある質問のタイトルテキスト');
$faq_title_text_color = scf::get('スタッフ求人ページのよくある質問のタイトルの文字色');
$faq_border_color = scf::get('スタッフ求人のよくある質問の枠線色');
$staff_recruit_basic_border_color = scf::get('スタッフ求人ページの枠線の色');
$staff_recruit_QA_list_bg_color = scf::get('スタッフ求人ページのよくある質問のリスト内側背景色');
$staff_recruit_QA_list_A_bg_color = scf::get('スタッフ求人ページのよくある質問のリストの答え文章内側背景色');
$faq_QA_letter_font = scf::get('スタッフ求人ページのよくある質問のQとAのフォント');
$faq_Q_text_color = scf::get('スタッフ求人ページのよくある質問のQの文字色');
$faq_Q_bg_color = scf::get('スタッフ求人ページのよくある質問のQの背景色');
$faq_A_text_color = scf::get('スタッフ求人ページのよくある質問のAの文字色');
$faq_A_text_bg_color = scf::get('スタッフ求人ページのよくある質問のAの背景色');
$faq_Q_content_text_color = scf::get('スタッフ求人ページのよくある質問のQ内容の文字色');
$faq_A_content_text_color = scf::get('スタッフ求人ページのよくある質問のA内容の文字色');
$faq_button_color = scf::get('スタッフ求人ページのよくある質問の開閉ボタンの色');
$faq_button_bg_color = scf::get('スタッフ求人ページのよくある質問の開閉ボタンの背景色');
$staff_recruit_basic_title_font = scf::get('スタッフ求人ページのよくある質問以外のタイトルのフォント');
$staff_recruit_staff_voice_thema_type = scf::get('スタッフ求人ページのスタッフの声のテーマタイプ');
$staff_recruit_staff_voice_title_text_color = scf::get('スタッフ求人ページのスタッフの声のタイトルの文字色');
$staff_recruit_staff_voice_box_text_color = scf::get('スタッフ求人ページのスタッフの声の文章ボックスの文字色');
$staff_recruit_staff_voice_box_bg_color = scf::get('スタッフ求人ページのスタッフの声の文章ボックスの背景色');
$staff_recruit_staff_voice_odd_block_bg_color = scf::get('スタッフ求人ページのスタッフの声の奇数ブロックの背景色');
$staff_recruit_staff_voice_odd_block_border_color = scf::get('スタッフ求人ページのスタッフの声の奇数ブロックの枠線色');
$staff_recruit_staff_voice_even_block_bg_color = scf::get('スタッフ求人ページのスタッフの声の偶数ブロックの背景色');
$staff_recruit_staff_voice_even_block_border_color = scf::get('スタッフ求人ページのスタッフの声の偶数ブロックの枠線色');
$staff_recruit_movie_thema_type = scf::get('スタッフ求人ページの求人動画のテーマタイプ');
$staff_recruit_movie_title_text_color = scf::get('スタッフ求人の求人動画のタイトルの文字色');
$staff_recruit_movie_border_color = scf::get('スタッフ求人の求人動画の枠線色');
$staff_recruit_table_title_text_color = scf::get('スタッフ求人の募集要項のタイトルの文字色');
$staff_recruit_table_border_color = scf::get('スタッフ求人ページの募集要項の枠線色');
$staff_recruit_table_TH_text_color = scf::get('スタッフ求人ページの募集要項のTHの文字色');
$staff_recruit_table_TH_bg_color = scf::get('スタッフ求人ページの募集要項のTHの背景色');
$staff_recruit_table_TD_text_color = scf::get('スタッフ求人の募集要項テーブルの行の右側の内容の文字色');
$staff_recruit_table_TD_bg_color = scf::get('スタッフ求人の募集要項テーブルの行の右側の内容の背景色');
$staff_recruit_table_TH_inversion_text_color = scf::get('スタッフ求人ページの募集要項の反転文字色');
$staff_recruit_table_treatment_item_text_color = scf::get('スタッフ求人ページの募集要項の待遇アイテムの文字色');
$staff_recruit_table_treatment_item_bg_color = scf::get('スタッフ求人ページの募集要項の待遇アイテムの背景色');
$staff_recruit_table_treatment_item_off_bg_color = scf::get('スタッフ求人の募集要項の待遇アイテムOFFの背景色');
$staff_recruit_article_title_text_color = scf::get('スタッフ求人ページの最下部記事タイトルの文字色');
$staff_recruit_article_title_boder_color = scf::get('スタッフ求人ページの最下部記事タイトルの枠線色');
$staff_recruit_contact_text_color = scf::get('スタッフ求人のお問い合わせバナーの文字色');
$staff_recruit_contact_bg_color = scf::get('スタッフ求人のお問い合わせバナーの背景色');
?>

<?php get_template_part('common-styles'); ?>

<style type="text/css">
  section.cont-kingaku {
    background-color: <?php echo $staff_recruit_cont_kingaku_bg_color; ?>;
  }

  .staff_recruit_sub_title_text_color {
    color: <?php echo $staff_recruit_sub_title_text_color; ?>;
  }

  .faq_title_text_style {
    font-family: <?php echo $faq_title_text_font; ?>;
    font-size: <?php echo $faq_title_text_font_size; ?>px;
    color: <?php echo $faq_title_text_color; ?>;
    border-color: <?php echo $staff_recruit_basic_border_color; ?>;
  }

  .sp_faq_title_text_style {
    font-family: <?php echo $faq_title_text_font; ?>;
    font-size: <?php echo $sp_faq_title_text_font_size; ?>px;
    color: <?php echo $faq_title_text_color; ?>;
    border-color: <?php echo $staff_recruit_basic_border_color; ?>;
  }

  .staff_recruit_basic_border_color {
    border-color: <?php echo $staff_recruit_basic_border_color; ?>;
  }

  .faq_border_color {
    border-color: <?php echo $faq_border_color; ?>;
  }

  .faq_Q_letter_style {
    font-family: <?php echo $faq_QA_letter_font; ?>;
    color: <?php echo $faq_Q_text_color; ?>;
    background-color: <?php echo $faq_Q_bg_color; ?>;
    border-color: <?php echo $staff_recruit_basic_border_color; ?>;
    <?php if ($staff_recruit_faq_thema_type == 'stylish') : ?>background: linear-gradient(to top left, transparent 50%, <?php echo $faq_Q_bg_color; ?> 50%);
    <?php endif; ?>
  }

  .faq_A_letter_style {
    font-family: <?php echo $faq_QA_letter_font; ?>;
    color: <?php echo $faq_A_text_color; ?>;
    background-color: <?php echo $faq_A_text_bg_color; ?>;
  }

  .faq_Q_content_style {
    color: <?php echo $faq_Q_content_text_color; ?>;
  }

  .faq_A_content_style {
    color: <?php echo $faq_A_content_text_color; ?>;
  }

  .faq_button_style {
    fill: <?php echo $faq_button_color; ?>;
    background-color: <?php echo $faq_button_bg_color; ?>;
  }

  .staff_recruit_QA_list_bg_color {
    background-color: <?php echo $staff_recruit_QA_list_bg_color; ?>;
  }

  .staff_recruit_QA_list_A_bg_color {
    background-color: <?php echo $staff_recruit_QA_list_A_bg_color; ?>;
  }

  .staff_recruit_staff_voice_title_text_color {
    color: <?php echo $staff_recruit_staff_voice_title_text_color; ?>;
  }

  .staff_recruit_basic_title_font {
    font-family: <?php echo $staff_recruit_basic_title_font; ?>;
  }

  .staff_recruit_staff_voice_box_text_color {
    color: <?php echo $staff_recruit_staff_voice_box_text_color; ?>;
  }

  .staff_recruit_staff_voice_box_bg_color {
    background-color: <?php echo $staff_recruit_staff_voice_box_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) {
    background-color: <?php echo $staff_recruit_staff_voice_odd_block_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) {
    background-color: <?php echo $staff_recruit_staff_voice_even_block_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) div.left {
    fill: <?php echo $staff_recruit_staff_voice_odd_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) div.left {
    fill: <?php echo $staff_recruit_staff_voice_even_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) div {
    border-color: <?php echo $staff_recruit_staff_voice_odd_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) div {
    border-color: <?php echo $staff_recruit_staff_voice_even_block_border_color; ?>;
  }

  .staff_recruit_movie_title_text_color {
    color: <?php echo $staff_recruit_movie_title_text_color; ?>;
  }

  .staff_recruit_movie_border_color {
    border-color: <?php echo $staff_recruit_movie_border_color; ?>
  }

  .staff_recruit_table_title_text_color {
    color: <?php echo $staff_recruit_table_title_text_color; ?>;
  }

  .staff_recruit_table_border_color {
    border-color: <?php echo $staff_recruit_table_border_color; ?>;
  }

  .staff_recruit_table_TH_style {
    background-color: <?php echo $staff_recruit_table_TH_bg_color; ?>;
    color: <?php echo $staff_recruit_table_TH_text_color; ?>;
  }

  .staff_recruit_table_TD_style {
    background-color: <?php echo $staff_recruit_table_TD_bg_color; ?>;
    color: <?php echo $staff_recruit_table_TD_text_color; ?>;
  }

  .staff_recruit_table_TD_text_inversion_color {
    color: <?php echo $staff_recruit_table_TD_text_inversion_color; ?>;
  }

  .staff_recruit_table_TH_inversion_text_color {
    color: <?php echo $staff_recruit_table_TH_inversion_text_color; ?>;
    fill: <?php echo $staff_recruit_table_TH_inversion_text_color; ?>;
  }

  .staff_recruit_table_treatment_item_style {
    color: <?php echo $staff_recruit_table_treatment_item_text_color; ?>;
    background-color: <?php echo $staff_recruit_table_treatment_item_bg_color; ?>;
  }

  .staff_recruit_table_treatment_item_style.deactive {
    background-color: <?php echo $staff_recruit_table_treatment_item_off_bg_color; ?>;
    display: none !important;
  }

  .staff_recruit_article_title_style {
    color: <?php echo $staff_recruit_article_title_text_color; ?>;
    border-color: <?php echo $staff_recruit_article_title_boder_color; ?>;
  }

  .dl_bg_color {
    background-color: <?php echo $sub_color; ?>;
  }

  .staff_recruit_contact_style {
    color: <?php echo $staff_recruit_contact_text_color; ?>;
    fill: <?php echo $staff_recruit_contact_text_color; ?>;
    background-color: <?php echo $staff_recruit_contact_bg_color; ?>;
  }
</style>

<?php get_header(); ?>

<div id="breadcrumbs">
  <ol itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?= site_url(); ?>/">
        <span class="text_style" itemprop="name">TOP</span></a>
      <meta itemprop="position" content="1" />
    </li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?= site_url('staff-recruit'); ?>/">
        <span class="text_style" itemprop="name">STAFF-RECRUIT</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</div>

<div class="wraper">

  <div class="container">

    <article class="main">

      <section class="staff-recruit">
        <div class="staff-recruit__inner--<?php echo $staff_recruit_faq_thema_type; ?>">
          <h2 class="title_style">S T A F F&nbsp;&nbsp;R E C R U I T</h2>
          <h3 class="sub_title_style">求人情報</h3>
        </div> <!-- /staff-recruit__inner-- -->
      </section> <!-- /calendar-- -->

      <?php
      switch ($shop['industry_id']) {
        case '1':
          $for_alt_text = 'キャバクラ';
          break;
        case '2':
          $for_alt_text = 'ガールズバー';
          break;
        case '3':
          $for_alt_text = 'コンカフェ';
          break;
        case '4':
          $for_alt_text = 'スナック';
          break;
        case '5':
          $for_alt_text = 'ラウンジ';
          break;
        default:
          $for_alt_text = '未指定';
          break;
      }
      if ($staff_recruit['eyecatch_image_url']) {
        $staff_recruit['eyecatch_image_url'] = str_replace('http://', 'https://', $staff_recruit['eyecatch_image_url']);
      ?>
        <section class="cont00">
          <img src="<?php echo $staff_recruit['eyecatch_image_url'];  ?>" alt="<?php echo $mono_addressLocality; ?>の<?php echo $for_alt_text; ?>「<?php echo $store_name; ?>」のスタッフ求人アイキャッチ" />
        </section>
      <?php
      }
      if ($staff_recruit['reward']) {
        $staff_recruit['reward'] = str_replace('http://', 'https://', $staff_recruit['reward']);
      ?>
        <section class="cont-kingaku">
          <img src="<?php echo $staff_recruit['reward'];  ?>" alt="「<?php echo $store_name; ?>」のスタッフ求人の金額詳細" />
        </section>
      <?php
      }
      ?>

      <?php get_template_part('staff-recruit-freelayout'); ?>

      <?php
      $total_count = count($qa_list);
      if ($total_count > 0) {
      ?>
        <section class="faq">
          <div class="faq__inner--<?php echo $staff_recruit_faq_thema_type; ?>">
            <h4 class="pc faq_title_text_style faq_border_color staff_recruit_sub_title_text_color"><?php echo $faq_title_text; ?></h4>
            <h4 class="sp sp_faq_title_text_style faq_border_color staff_recruit_sub_title_text_color"><?php echo $faq_title_text; ?></h4>
            <ul>
              <?php
              foreach ($qa_list as $qa) {
              ?>
                <?php if (!empty($qa['question']) && !empty($qa['answer'])) : ?>
                  <li class="staff_recruit_QA_list_bg_color staff_recruit_basic_border_color faq_border_color">
                    <dl class="dl_bg_color">
                      <dt class="staff_recruit_QA_list_bg_color">
                        <span class="faq_Q_letter_style"><i>Q</i></span>
                        <h5 class="text_style faq_Q_content_style"><i><?php echo nl2br($qa['question']); ?></i></h5>
                      </dt>
                      <dd class="staff_recruit_QA_list_A_bg_color">
                        <span class="faq_A_letter_style"><i>A</i></span>
                        <p class="text_style faq_A_content_style"><?php echo nl2br($qa['answer']); ?></p>
                      </dd>
                    </dl>
                    <b class="faq_button_style staff_recruit_basic_border_color">
                      <svg class="open display-block pop" xmlns="https://www.w3.org/2000/svg" width="14.574" height="8.05" viewBox="0 0 14.574 8.05">
                        <defs></defs>
                        <g transform="translate(-889.977 -4514.302)">
                          <rect class="a" width="1.085" height="10.3" transform="translate(896.5 4515.069) rotate(-45)" />
                          <rect class="a" width="1.085" height="10.3" transform="translate(897.26 4514.302) rotate(45)" />
                        </g>
                      </svg>
                      <svg class="close pop" xmlns="https://www.w3.org/2000/svg" width="15.823" height="15.823" viewBox="0 0 15.823 15.823">
                        <defs></defs>
                        <g transform="translate(0 0)">
                          <rect class="a" width="15.823" height="1.085" transform="translate(0 7.37)" />
                          <rect class="a" width="1.085" height="15.823" transform="translate(7.369 0.001)" />
                        </g>
                      </svg>
                      <svg class="open display-block stylish" xmlns="https://www.w3.org/2000/svg" width="10.476" height="16.811" viewBox="0 0 10.476 16.811">
                        <defs></defs>
                        <path class="a" d="M0,0V16.811L10.476,8.406Z" />
                      </svg>
                      <svg class="close stylish" xmlns="https://www.w3.org/2000/svg" width="16.811" height="10.476" viewBox="0 0 16.811 10.476">
                        <defs></defs>
                        <path class="a" d="M0,0,8.4,10.476,16.811,0Z" transform="translate(0 0)" />
                      </svg>
                      <svg class="open display-block luxury" xmlns="https://www.w3.org/2000/svg" width="15.823" height="15.823" viewBox="0 0 15.823 15.823">
                        <defs></defs>
                        <g transform="translate(0 0)">
                          <rect class="a" width="15.823" height="1.085" transform="translate(0 7.37)" />
                          <rect class="a" width="1.085" height="15.823" transform="translate(7.369 0.001)" />
                        </g>
                      </svg>
                      <svg class="close luxury" xmlns="https://www.w3.org/2000/svg" width="15.241" height="15.242" viewBox="0 0 15.241 15.242">
                        <defs></defs>
                        <rect class="a" width="20.172" height="1.383" transform="translate(0 14.264) rotate(-45)" />
                        <rect class="a" width="1.383" height="20.172" transform="translate(0 0.978) rotate(-45)" />
                      </svg>
                    </b>
                  </li>
                <?php endif ?>
              <?php
              }
              ?>
            </ul>
          </div> <!-- /faq-- -->
        </section> <!-- /faq -->
      <?php
      }
      ?>
      <?php
      if ((!empty($staff_recruit['interview_title_0']) && !empty($staff_recruit['interview_text_0'])) || (!empty($staff_recruit['interview_title_1']) && !empty($staff_recruit['interview_text_1'])) || (!empty($staff_recruit['interview_title_2']) && !empty($staff_recruit['interview_text_2'])) || (!empty($staff_recruit['interview_title_3']) && !empty($staff_recruit['interview_text_3']))) {
      ?>
        <section class="interview">
          <div class="interview__inner--<?php echo $staff_recruit_staff_voice_thema_type; ?>">
            <ul>
              <?php
              for ($i = 0; $i < 4; $i++) {
                if ($staff_recruit['interview_text_' . $i]) {
              ?>
                  <li>
                    <div class="wrap">
                      <h4 class="staff_recruit_basic_title_font staff_recruit_staff_voice_title_text_color staff_recruit_sub_title_text_color"><?php echo nl2br($staff_recruit['interview_title_' . $i]); ?></h4>
                      <?php
                      if ($staff_recruit['interview_image_url_' . $i]) {
                        $staff_recruit['interview_image_url_' . $i] = str_replace('http://', 'https://', $staff_recruit['interview_image_url_' . $i]);
                      ?>
                        <div class="right staff_recruit_basic_border_color">
                          <img src="<?php echo $staff_recruit['interview_image_url_' . $i]; ?>" alt="" />
                        </div> <!-- /right -->
                      <?php
                      }
                      ?>
                      <div class="left staff_recruit_staff_voice_box_bg_color staff_recruit_basic_border_color">
                        <svg class="left-top" xmlns="https://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
                          <g transform="translate(-350 -5318)">
                            <rect width="2" height="200" transform="translate(367 5318)" />
                            <rect width="200" height="2" transform="translate(350 5335.088)" />
                          </g>
                        </svg>
                        <svg class="right-bottom" xmlns="https://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
                          <g transform="translate(550 5518) rotate(180)">
                            <rect width="2" height="200" transform="translate(367 5318)" />
                            <rect width="200" height="2" transform="translate(350 5335.088)" />
                          </g>
                        </svg>
                        <h4 class="staff_recruit_basic_title_font staff_recruit_staff_voice_title_text_color staff_recruit_sub_title_text_color"><?php echo nl2br($staff_recruit['interview_title_' . $i]); ?></h4>
                        <p class="staff_recruit_staff_voice_box_text_color"><?php echo nl2br($staff_recruit['interview_text_' . $i]); ?></p>
                      </div> <!-- /left -->

                    </div> <!-- /wrap -->
                  </li>
              <?php
                }
              }
              ?>
            </ul>
          </div> <!-- /interview__inner-- -->
        </section> <!-- /interview -->
      <?php
      }
      ?>
      <?php
      if ($staff_recruit['video']) {
      ?>
        <section class="movie">
          <div class="movie__inner--<?php echo $staff_recruit_thema_type; ?>">
            <h4 class="staff_recruit_basic_title_font  staff_recruit_basic_border_color staff_recruit_sub_title_text_color staff_recruit_movie_title_text_color staff_recruit_movie_border_color"><i>求人動画</i></h4>
            <div class="wrap">
              <?php echo $staff_recruit['video']; ?>
            </div> <!-- /wrap -->
          </div> <!-- /movie__inner-- -->
        </section> <!-- /movie -->
      <?php } ?>

      <section class="recruit-table">
        <div class="recruit-table__inner recruit-table__inner--<?php echo $staff_recruit_thema_type; ?>">
          <h4 class="staff_recruit_basic_title_font staff_recruit_table_border_color staff_recruit_sub_title_text_color staff_recruit_basic_border_color staff_recruit_table_title_text_color"><i>募集要項</i></h4>
          <table class="staff_recruit_table_border_color">
            <?php
            for ($i = 0; $i < 10; $i++) {
              if (!empty($staff_recruit['salary_title_' . $i])) {
            ?>
                <tr class="staff_recruit_table_border_color">
                  <?php
                  $flag = 0;
                  if (!empty($staff_recruit['salary_remarks_' . $i])) {
                    $flag = 1;
                  }
                  ?>
                  <th class="staff_recruit_table_TH_style" rowspan="<?php echo 1 + $flag; ?>"><?php echo nl2br($staff_recruit['salary_title_' . $i]); ?></th>
                  <td class="staff_recruit_table_TD_style">
                    <span class="staff_recruit_table_TH_inversion_text_color">
                      <?php
                      echo nl2br($staff_recruit['salary_text_' . $i]);
                      ?>
                    </span>
                  </td>
                </tr>
                <?php
                if ($flag) {
                ?>
                  <tr class="staff_recruit_table_border_color">
                    <td class="staff_recruit_table_TD_style">
                      <?php
                      echo nl2br($staff_recruit['salary_remarks_' . $i]);
                      ?>
                    </td>
                  </tr>
            <?php
                }
              }
            }
            ?>
            <?php if ($staff_recruit['qualification']) : ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style" rowspan="1">資格</th>
                <td class="staff_recruit_table_TD_style">
                  <?php
                  echo nl2br($staff_recruit['qualification']);
                  ?>
                </td>
              </tr>
            <?php endif ?>
            <?php
            $daily_payment  = $staff_recruit['daily_payment'] == 1 ? "" : "deactive";
            $inexperienced  = $staff_recruit['inexperienced'] == 1 ? "" : "deactive";
            $experienced  = $staff_recruit['experienced'] == 1 ? "" : "deactive";
            $trial = $staff_recruit['trial'] == 1 ? "" : "deactive";
            $commision_system = $staff_recruit['commision_system'] ==  1  ? "" : "deactive";
            $bonus = $staff_recruit['bonus'] == 1 ? "" : "deactive";
            $travel_expense = $staff_recruit['travel_expense'] == 1 ? "" : "deactive";
            $parking_area = $staff_recruit['parking_area'] == 1 ? "" : "deactive";
            $prepaid_system = $staff_recruit['prepaid_system'] == 1 ? "" : "deactive";
            $meal = $staff_recruit['meal'] == 1 ? "" : "deactive";
            $nursery = $staff_recruit['nursery'] == 1 ? "" : "deactive";
            $dormitory = $staff_recruit['dormitory'] == 1 ? "" : "deactive";
            $company_insurance = $staff_recruit['company_insurance'] == 1 ? "" : "deactive";
            $company_trip = $staff_recruit['company_trip'] == 1 ? "" : "deactive";
            $independence_support_system = $staff_recruit['independence_support_system'] == 1 ? "" : "deactive";
            $five_day_workweek = $staff_recruit['five_day_workweek'] == 1 ? "" : "deactive";
            $uniform_rental = $staff_recruit['uniform_rental'] == 1 ? "" : "deactive";
            $long_vacation = $staff_recruit['long_vacation'] == 1 ? "" : "deactive";
            $congratulatory_bonus = $staff_recruit['congratulatory_bonus'] == 1 ? "" : "deactive";
            $training_program = $staff_recruit['training_program'] == 1 ? "" : "deactive";
            $company_car = $staff_recruit['company_car'] == 1 ? "" : "deactive";
            $suits_uniforms_provided = $staff_recruit['suits_uniforms_provided'] == 1 ? "" : "deactive";

            if (
              $daily_payment == '' || $inexperienced == '' || $experienced == '' || $trial == '' || $commision_system == '' ||
              $bonus == '' || $travel_expense == '' || $parking_area == '' || $prepaid_system == '' || $meal == '' ||
              $nursery == '' || $dormitory == '' || $company_insurance == '' || $company_trip == '' ||
              $independence_support_system == '' || $five_day_workweek == '' || $uniform_rental == '' || $long_vacation == '' ||
              $congratulatory_bonus == '' || $training_program == '' || $company_car == '' || $suits_uniforms_provided == ''
            ) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">待遇</th>
                <td class="staff_recruit_table_TD_style">
                  <ul class="treatment">
                    <li class="staff_recruit_table_treatment_item_style <?php echo $daily_payment; ?>"><i>日払いOK</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $inexperienced; ?>"><i>未経験者大歓迎</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $experienced; ?>"><i>経験者優遇</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $trial; ?>"><i>体験入社あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $commision_system; ?>"><i>歩合あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $bonus; ?>"><i>賞与あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $travel_expense; ?>"><i>交通費支給</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $parking_area; ?>"><i>駐車場あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $prepaid_system; ?>"><i>前払い制度あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $meal; ?>"><i>食事あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $nursery; ?>"><i>託児あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $dormitory; ?>"><i>寮あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $company_insurance; ?>"><i>社保完備</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $company_trip; ?>"><i>社員旅行あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $independence_support_system; ?>"><i>独立支援制度あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $five_day_workweek; ?>"><i>週休2日制</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $uniform_rental; ?>"><i>制服貸与あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $long_vacation; ?>"><i>長期休暇あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $congratulatory_bonus; ?>"><i>祝い金あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $training_program; ?>"><i>研修制度あり</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $company_car; ?>"><i>社用車完備</i></li>
                    <li class="staff_recruit_table_treatment_item_style <?php echo $suits_uniforms_provided; ?>"><i>スーツ・制服支給</i></li>
                  </ul>
                </td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['industry'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">業種</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['industry']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['occupation'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">職種</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['occupation']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['area'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">エリア</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['area']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['work_location'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">勤務地</th>
                <td class="staff_recruit_table_TD_style">
                  <address><?php echo $staff_recruit['work_location']; ?></address>
                  <?php $staff_recruit['work_location_googlemap'] = str_replace('http://', 'https://', $staff_recruit['work_location_googlemap']); ?>
                  <a class="open_the_map staff_recruit_table_TH_inversion_text_color" href="<?php echo $staff_recruit['work_location_googlemap']; ?>" target="_blank"><svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="10.282" height="15.155" viewBox="0 0 10.282 15.155">
                      <defs>
                        <clipPath id="a">
                          <rect class="a" width="10.282" height="15.155" />
                        </clipPath>
                      </defs>
                      <g class="b">
                        <path class="a" d="M10.282,5.141A5.141,5.141,0,0,0,0,5.141c0,5.022,5.141,10.014,5.141,10.014s5.141-4.991,5.141-10.014M2.9,4.661A2.236,2.236,0,1,1,5.141,6.9,2.235,2.235,0,0,1,2.9,4.661" transform="translate(0 0)" />
                      </g>
                    </svg><i>MAPを開く</i></a>
                </td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['nearest_station'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">最寄駅</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['nearest_station']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['working_days'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">勤務日</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['working_days']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['working_time'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">勤務時間</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['working_time']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['closed_store'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">店休日</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['closed_store']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['tel']) || !empty($staff_recruit['mail']) || !empty($staff_recruit['line_id'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">ご応募<br />お問い合わせ</th>
                <td class="staff_recruit_table_TD_style">
                  <ul class="contact">
                    <?php
                    if (!empty($staff_recruit['tel'])) {
                    ?>
                      <li>
                        <a onclick="return gtag_report_staff_recruit_tel_conversion('tel:<?= $staff_recruit['tel']; ?>');" href="tel:<?= $staff_recruit['tel']; ?>"><span class="staff_recruit_table_TH_inversion_text_color">TEL. <?= $staff_recruit['tel']; ?></span></a>
                      </li>
                    <?php
                    }
                    if (!empty($staff_recruit['mail'])) {
                    ?>
                      <li>
                        <!-- <a onclick="return gtag_report_conversion('mailto:<?php //echo $staff_recruit['mail']; ?>');" href="mailto:<?php //echo $staff_recruit['mail']; ?>"><span class="staff_recruit_table_TH_inversion_text_color">Mail. <?php //echo $staff_recruit['mail']; ?></span></a> -->
                        <a href="mailto:<?= $staff_recruit['mail']; ?>"><span class="staff_recruit_table_TH_inversion_text_color">Mail. <?= $staff_recruit['mail']; ?></span></a>
                      </li>
                    <?php
                    }
                    if (!empty($staff_recruit['line_id']) || !empty($staff_recruit['line_url'])) {
                      $staff_recruit['line_url'] = str_replace('http://', 'https://', $staff_recruit['line_url']);
                    ?>
                      <li>
                        <a onclick="return gtag_report_staff_recruit_line_conversion('<?= $staff_recruit['line_url']; ?>');" href="<?= $staff_recruit['line_url']; ?>" target="_blank">
                          <?php if (!$staff_recruit['line_id']) { ?>
                            <span class="staff_recruit_table_TH_inversion_text_color">LINE友達追加はこちら</span>
                          <?php } else { ?>
                            <span class="staff_recruit_table_TH_inversion_text_color">LINE ID. <?= $staff_recruit['line_id']; ?></span>
                          <?php } ?>
                        </a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['contact_person'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">担当</th>
                <td class="staff_recruit_table_TD_style"><?php echo nl2br($staff_recruit['contact_person']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($staff_recruit['official_site'])) {
            ?>
              <tr class="staff_recruit_table_border_color">
                <th class="staff_recruit_table_TH_style">オフィシャル<br />サイト</th>
                <td class="staff_recruit_table_TD_style">
                  <a class="official_homepege_link02" href="<?php echo $staff_recruit['official_site']; ?>" target="_blank"><span class="staff_recruit_table_TH_inversion_text_color"><?php echo $staff_recruit['official_site']; ?></span></a>
                </td>
              </tr>
            <?php } ?>
          </table>
          <!--       <div class="bottom">
        <ul>
          <?php
          for ($i = 0; $i < 3; $i++) {
          ?>
          <li>
            <h5 class="staff_recruit_article_title_style"><?php echo $staff_recruit['free_subject_' . $i]; ?></h5>
            <p class="staff_recruit_table_border_color text_style"><?php echo $staff_recruit['free_text_' . $i]; ?></p>
          </li>
          <?php
          }
          ?>
        </ul>
      </div> -->
        </div> <!-- /recruit-table__inner-- -->
      </section> <!-- /recruit-table -->

      <?php get_footer(); ?>

      <div id="fix_contact">
        <ul>
          <?php if ($staff_recruit['tel']) { ?>
            <li class="contact_by_tel">
              <a onclick="return gtag_report_staff_recruit_tel_conversion('tel:<?= $staff_recruit['tel']; ?>');" class="staff_recruit_contact_style" href="tel:<?= $staff_recruit['tel']; ?>">
                <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="31.712" height="47.181" viewBox="0 0 31.712 47.181">
                  <defs>
                    <clipPath id="a">
                      <rect class="a" width="31.712" height="47.181" />
                    </clipPath>
                  </defs>
                  <g class="b">
                    <path class="a" d="M24.3,16.105c-.916-1.528-2.212-4.51-3.665-3.819l-2.321,2.32s-2.262,2.108,1.939,3.789c0,0,1.041,1.128-2.194,4.129-3,3.235-4.127,2.192-4.127,2.192-1.681-4.2-3.79-1.936-3.79-1.936L7.818,25.1c-.691,1.456,2.29,2.75,3.817,3.666,1.42.85,4.223.314,8.468-3.618l.017.023.581-.581-.023-.017c3.932-4.244,4.47-7.05,3.618-8.467M25.911,0H5.8A5.8,5.8,0,0,0,0,5.8V41.38a5.8,5.8,0,0,0,5.8,5.8H25.911a5.8,5.8,0,0,0,5.8-5.8V5.8a5.8,5.8,0,0,0-5.8-5.8m2.173,34.835A3.148,3.148,0,0,1,24.94,37.98H6.772a3.148,3.148,0,0,1-3.144-3.144V7.4A3.148,3.148,0,0,1,6.772,4.254H24.94A3.148,3.148,0,0,1,28.084,7.4Z" />
                  </g>
                </svg>
                <h2>電話でご応募</h2>
                <address><?= $staff_recruit['tel']; ?></address>
              </a>
            </li>
          <?php } ?>
          <?php if ($staff_recruit['mail']) { ?>
            <li class="contact_by_mail">
              <!-- <a onclick="return gtag_report_conversion('mailto:<?php //echo $staff_recruit['mail']; ?>');" class="staff_recruit_contact_style" href="mailto:<?php //echo $staff_recruit['mail']; ?>"> -->
              <a class="staff_recruit_contact_style" href="mailto:<?= $staff_recruit['mail']; ?>">
                <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="31.141" height="48.93" viewBox="0 0 31.141 48.93">
                  <defs>
                    <clipPath id="a">
                      <rect class="a" width="31.141" height="48.93" />
                    </clipPath>
                  </defs>
                  <g class="b">
                    <path class="a" d="M6.868,29.174H24.275V17.305H6.868ZM21.227,18.731l-5.657,3.75-5.655-3.75Zm-12.974.595,7.317,4.851,7.319-4.851V27.75H8.253ZM25.445,0H5.7A5.7,5.7,0,0,0,0,5.7V43.233a5.7,5.7,0,0,0,5.7,5.7H25.445a5.7,5.7,0,0,0,5.7-5.7V5.7a5.7,5.7,0,0,0-5.7-5.7m2.134,36.806a3.092,3.092,0,0,1-3.088,3.088H6.65a3.092,3.092,0,0,1-3.087-3.088V7.265A3.092,3.092,0,0,1,6.65,4.177H24.491a3.092,3.092,0,0,1,3.088,3.088Z" transform="translate(0 0)" />
                  </g>
                </svg>
                <h2>MAILでご応募</h2>
              </a>
            </li>
          <?php } ?>
          <?php if ($staff_recruit['line_url']) { ?>
            <li class="contact_by_line">
              <a onclick="return gtag_report_staff_recruit_line_conversion('<?= $staff_recruit['line_url']; ?>');" class="staff_recruit_contact_style" href="<?= $staff_recruit['line_url']; ?>" target="_blank">
                <h2>LINEでご応募</h2>
              </a>
            </li>
          <?php } ?>
        </ul>
      </div> <!-- /fix_contact -->

      <script type="text/javascript">
        $('.faq ul li').on('click', function() {
          $(this).children('dl').children('dd').slideToggle(220);
          $(this).children('b').children('svg').toggleClass('display-block');
          $(this).children('dl').children('dt').children('span').toggleClass('border-bottom-width-on');
        });
      </script>

      <script type="application/ld+json">
        [
          {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "mainEntityOfPage": {
              "@type": "WebPage",
              "@id": "<?= site_url('staff-recruit'); ?>/"
            },
            "inLanguage": "ja",
            "author": {
              "@type": "Organization",
              "@id": "<?= site_url(); ?>/",
              "name": "<?php echo $store_name; ?>",
              "url": "<?= site_url(); ?>/",
              "image": "<?php echo wp_get_attachment_url($logo);  ?>"
            },
            "headline": "スタッフ求人情報",
            "description": "<?php echo $page_description; ?>"
          },
          {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?php echo $store_name; ?>",
            "url": "<?= site_url(); ?>/",
            "logo": "<?php echo wp_get_attachment_url($logo);  ?>",
            "contactPoint": [{
              "@type": "ContactPoint",
              "telephone": "<?php echo $mono_international_tel; ?>",
              "contactType": "customer support"
            }],
            //snsのURL出力
            "sameAs": [
              <?php
              if ($mono_sns01) {
                echo '"' . $mono_sns01 . '"';
              }
              if ($mono_sns02) {
                echo ',' . "\n" . '"' . $mono_sns02 . '"';
              }
              if ($mono_sns03) {
                echo ',' . "\n" . '"' . $mono_sns03 . '"';
              }
              if ($mono_sns04) {
                echo ',' . "\n" . '"' . $mono_sns04 . '"';
              }
              if ($mono_sns05) {
                echo ',' . "\n" . '"' . $mono_sns05 . '"';
              }
              echo "\n";
              ?>
            ]
          },
          {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "<?php echo $store_name; ?>",
            "image": "<?php echo wp_get_attachment_url($logo);  ?>",
            "url": "<?= site_url(); ?>/",
            "priceRange": "<?php echo $mono_priceRange; ?>",
            "telephone": "<?php echo $mono_international_tel; ?>",
            "address": {
              "@type": "PostalAddress",
              "streetAddress": "<?php echo $mono_streetAddress; ?>",
              "addressLocality": "<?php echo $mono_addressLocality; ?>",
              "addressRegion": "<?php echo $mono_addressRegion; ?>",
              "postalCode": "<?php echo $mono_postalCode; ?>",
              "addressCountry": "JP"
            },
            "hasMap": "<?php echo $mono_hasMap; ?>",
            "openingHours": "<?php echo $mono_openingHours; ?>",
            "geo": {
              "@type": "GeoCoordinates",
              "latitude": "<?php echo $mono_latitude; ?>",
              "longitude": "<?php echo $mono_longitude; ?>"
            }
          },
          {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "name": "パンくずリスト",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "item": {
                  "name": "TOP",
                  "@id": "<?= site_url(); ?>/"
                }
              },
              {
                "@type": "ListItem",
                "position": 2,
                "item": {
                  "name": "STAFF-RECRUIT",
                  "@id": "<?= site_url('staff-recruit'); ?>/"
                }
              }
            ]
          }
        ]
      </script>
