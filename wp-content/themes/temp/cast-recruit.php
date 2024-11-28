<?php
/*
Template Name:cast-recruit
*/ query_posts('post');
require("setting.php");
$cast_recruit_sql   = "SELECT * FROM `cast_recruits` WHERE `subject_id` = " . $shop_id . " and `cabaweb_privacy` = 1";
$cast_recruit = $pdo->prepare($cast_recruit_sql);
$cast_recruit->execute();
$cast_recruit = $cast_recruit->fetch(PDO::FETCH_ASSOC);
$cast_q_a_sql = "SELECT `priority`,`question`,`answer` FROM `q_a` WHERE `type` = 'cast' AND `subject_id` = " . $shop_id . " AND `subject_name` = 'shop'";
$cast_q_a_list = $pdo->prepare($cast_q_a_sql);
$cast_q_a_list->execute();
$qa_list = $cast_q_a_list->fetchAll(PDO::FETCH_ASSOC);
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
$string = $cast_recruit['salary_text_0'];

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
  "title" => $cast_recruit['occupation'],
  "description" => join("\n", [
    $cast_recruit['recruit_pr'],"",
    $cast_recruit['salary_title_0'],
    $cast_recruit['salary_text_0'],
    $cast_recruit['salary_remarks_0'],"",
    $cast_recruit['salary_title_1'],
    $cast_recruit['salary_text_1'],
    $cast_recruit['salary_remarks_1'],"",
    $cast_recruit['salary_title_2'],
    $cast_recruit['salary_text_2'],
    $cast_recruit['salary_remarks_2'],"",
    $cast_recruit['salary_title_3'],
    $cast_recruit['salary_text_3'],
    $cast_recruit['salary_remarks_3'],"",
    $cast_recruit['salary_title_4'],
    $cast_recruit['salary_text_4'],
    $cast_recruit['salary_remarks_4'],"",
    $cast_recruit['salary_title_5'],
    $cast_recruit['salary_text_5'],
    $cast_recruit['salary_remarks_5'],"",
    $cast_recruit['salary_title_6'],
    $cast_recruit['salary_text_6'],
    $cast_recruit['salary_remarks_6'],"",
    $cast_recruit['salary_title_7'],
    $cast_recruit['salary_text_7'],
    $cast_recruit['salary_remarks_7'],"",
    $cast_recruit['salary_title_8'],
    $cast_recruit['salary_text_8'],
    $cast_recruit['salary_remarks_8'],"",
    $cast_recruit['salary_title_9'],
    $cast_recruit['salary_text_9'],
    $cast_recruit['salary_remarks_9'],"",
    $cast_recruit['qualification'],"",
    $cast_recruit['working_days'],"",
    $cast_recruit['working_time']
  ]),
  "datePosted" => $dateString,
  "hiringOrganization" => [
    "@type" => "Organization",
    "name" => $shop['name'],
    "sameAs" => $shop['url'].'cast-recruit',
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

  echo $cast_recruit_tel_tag;
  echo PHP_EOL;

  echo $cast_recruit_line_tag;
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
  <link rel="canonical" href="<?= site_url('cast-recruit'); ?>/">
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast-recruit_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast-recruit_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast-recruit-freelayout_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast-recruit-freelayout_sp.css" />
  <link rel="icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="shortcut icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="apple-touch-icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <!-- jquery読込 -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
  <!-- og関連 -->
  <meta property="og:url" content="<?= site_url('cast-recruit'); ?>/" />
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
$cast_recruit_eyecatch = scf::get('キャスト求人のアイキャッチ');
$cast_recruit_eyecatch02 = scf::get('キャスト求人のアイキャッチ②');
$cast_recruit_cont_kingaku_bg_color = scf::get('キャスト求人のアイキャッチ②背景色');
$cast_recruit_thema_type = scf::get('CAST-RECRUITのテーマタイプ');
$cast_recruit_faq_thema_type = scf::get('キャスト求人ページのよくある質問のテーマタイプ');
$faq_title_text_font = scf::get('キャスト求人ページのよくある質問のタイトルのフォント');
if ($faq_title_text_font == 'CenturyGothicPro-Bold') {
  $faq_title_text_font_size = 60;
  $sp_faq_title_text_font_size = 30;
} else {
  $faq_title_text_font_size = 48;
  $sp_faq_title_text_font_size = 21;
}
$faq_title_text = scf::get('キャスト求人ページのよくある質問のタイトルテキスト');
$faq_title_text_color = scf::get('キャスト求人ページのよくある質問のタイトルの文字色');

$faq_border_color = scf::get('キャスト求人のよくある質問の枠線色');
$cast_recruit_basic_border_color = scf::get('キャスト求人ページの枠線の色');
$cast_recruit_QA_list_bg_color = scf::get('キャスト求人ページのよくある質問のリスト内側背景色');
$cast_recruit_QA_list_A_bg_color = scf::get('キャスト求人ページのよくある質問のリストの答え文章内側背景色');
$faq_QA_letter_font = scf::get('キャスト求人ページのよくある質問のQとAのフォント');
$faq_Q_text_color = scf::get('キャスト求人ページのよくある質問のQの文字色');
$faq_Q_bg_color = scf::get('キャスト求人ページのよくある質問のQの背景色');
$faq_A_text_color = scf::get('キャスト求人ページのよくある質問のAの文字色');
$faq_A_text_bg_color = scf::get('キャスト求人ページのよくある質問のAの背景色');
$faq_Q_content_text_color = scf::get('キャスト求人ページのよくある質問のQ内容の文字色');
$faq_A_content_text_color = scf::get('キャスト求人ページのよくある質問のA内容の文字色');
$faq_button_color = scf::get('キャスト求人ページのよくある質問の開閉ボタンの色');
$faq_button_bg_color = scf::get('キャスト求人ページのよくある質問の開閉ボタンの背景色');
$cast_recruit_basic_title_font = scf::get('キャスト求人ページのよくある質問以外のタイトルのフォント');
$cast_recruit_cast_voice_thema_type = scf::get('キャスト求人ページのスタッフの声のテーマタイプ');
$cast_recruit_cast_voice_title_text_color = scf::get('キャスト求人ページのスタッフの声のタイトルの文字色');
$cast_recruit_cast_voice_box_text_color = scf::get('キャスト求人ページのスタッフの声の文章ボックスの文字色');
$cast_recruit_cast_voice_box_bg_color = scf::get('キャスト求人ページのスタッフの声の文章ボックスの背景色');
$cast_recruit_cast_voice_odd_block_bg_color = scf::get('キャスト求人ページのスタッフの声の奇数ブロックの背景色');
$cast_recruit_cast_voice_odd_block_border_color = scf::get('キャスト求人ページのスタッフの声の奇数ブロックの枠線色');
$cast_recruit_cast_voice_even_block_bg_color = scf::get('キャスト求人ページのスタッフの声の偶数ブロックの背景色');
$cast_recruit_cast_voice_even_block_border_color = scf::get('キャスト求人ページのスタッフの声の偶数ブロックの枠線色');
$cast_recruit_sub_title_text_color = scf::get('キャスト求人ページのサブタイトルの文字色');
$cast_recruit_movie_thema_type = scf::get('キャスト求人ページの求人動画のテーマタイプ');
$cast_recruit_movie_title_text_color = scf::get('キャスト求人の求人動画のタイトルの文字色');
$cast_recruit_movie_border_color = scf::get('キャスト求人の求人動画の枠線色');
$cast_recruit_table_title_text_color = scf::get('キャスト求人の募集要項のタイトルの文字色');
$cast_recruit_table_border_color = scf::get('キャスト求人ページの募集要項の枠線色');
$cast_recruit_table_TH_text_color = scf::get('キャスト求人ページの募集要項のTHの文字色');
$cast_recruit_table_TH_bg_color = scf::get('キャスト求人ページの募集要項のTHの背景色');
$cast_recruit_table_TD_text_color = scf::get('キャスト求人の募集要項テーブルの行の右側の内容の文字色');
$cast_recruit_table_TD_bg_color = scf::get('キャスト求人の募集要項テーブルの行の右側の内容の背景色');
$cast_recruit_table_TH_inversion_text_color = scf::get('キャスト求人ページの募集要項の反転文字色');
$cast_recruit_table_treatment_item_text_color = scf::get('キャスト求人ページの募集要項の待遇アイテムの文字色');
$cast_recruit_table_treatment_item_bg_color = scf::get('キャスト求人ページの募集要項の待遇アイテムの背景色');

$cast_recruit_table_treatment_item_off_bg_color = scf::get('キャスト求人の募集要項の待遇アイテムOFFの背景色');
$cast_recruit_article_title_text_color = scf::get('キャスト求人ページの最下部記事タイトルの文字色');
$cast_recruit_article_title_boder_color = scf::get('キャスト求人ページの最下部記事タイトルの枠線色');
$cast_recruit_contact_text_color = scf::get('キャスト求人のお問い合わせバナーの文字色');
$cast_recruit_contact_bg_color = scf::get('キャスト求人のお問い合わせバナーの背景色');
?>

<?php get_template_part('common-styles'); ?>

<style type="text/css">
  section.cont-kingaku {
    background-color: <?php echo $cast_recruit_cont_kingaku_bg_color; ?>;
  }

  .cast_recruit_sub_title_text_color {
    color: <?php echo $cast_recruit_sub_title_text_color; ?>;
  }

  .faq_title_text_style {
    font-family: <?php echo $faq_title_text_font; ?>;
    font-size: <?php echo $faq_title_text_font_size; ?>px;
    color: <?php echo $faq_title_text_color; ?>;
    border-color: <?php echo $cast_recruit_basic_border_color; ?>;
  }

  .sp_faq_title_text_style {
    font-family: <?php echo $faq_title_text_font; ?>;
    font-size: <?php echo $sp_faq_title_text_font_size; ?>px;
    color: <?php echo $faq_title_text_color; ?>;
    border-color: <?php echo $cast_recruit_basic_border_color; ?>;
  }

  .cast_recruit_basic_border_color {
    border-color: <?php echo $cast_recruit_basic_border_color; ?>;
  }

  .faq_border_color {
    border-color: <?php echo $faq_border_color; ?>;
  }

  .faq_Q_letter_style {
    font-family: <?php echo $faq_QA_letter_font; ?>;
    color: <?php echo $faq_Q_text_color; ?>;
    background-color: <?php echo $faq_Q_bg_color; ?>;
    border-color: <?php echo $cast_recruit_basic_border_color; ?>;
    <?php if ($cast_recruit_faq_thema_type == 'stylish') : ?>background: linear-gradient(to top left, transparent 50%, <?php echo $faq_Q_bg_color; ?> 50%);
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

  .cast_recruit_QA_list_bg_color {
    background-color: <?php echo $cast_recruit_QA_list_bg_color; ?>;
  }

  .cast_recruit_QA_list_A_bg_color {
    background-color: <?php echo $cast_recruit_QA_list_A_bg_color; ?>;
  }

  .cast_recruit_cast_voice_title_text_color {
    color: <?php echo $cast_recruit_cast_voice_title_text_color; ?>;
  }

  .cast_recruit_basic_title_font {
    font-family: <?php echo $cast_recruit_basic_title_font; ?>;
  }

  /*.cast_recruit_sub_title_text_color {
  color: <?php echo $cast_recruit_sub_title_text_color; ?>;
}
*/

  .cast_recruit_cast_voice_box_text_color {
    color: <?php echo $cast_recruit_cast_voice_box_text_color; ?>;
  }

  .cast_recruit_cast_voice_box_bg_color {
    background-color: <?php echo $cast_recruit_cast_voice_box_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) {
    background-color: <?php echo $cast_recruit_cast_voice_odd_block_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) {
    background-color: <?php echo $cast_recruit_cast_voice_even_block_bg_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) div.left {
    fill: <?php echo $cast_recruit_cast_voice_odd_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) div.left {
    fill: <?php echo $cast_recruit_cast_voice_even_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n + 1) div div {
    border-color: <?php echo $cast_recruit_cast_voice_odd_block_border_color; ?>;
  }

  section.interview div ul li:nth-of-type(2n) div div {
    border-color: <?php echo $cast_recruit_cast_voice_even_block_border_color; ?>;
  }

  .cast_recruit_movie_title_text_color {
    color: <?php echo $cast_recruit_movie_title_text_color; ?>
  }

  .cast_recruit_movie_border_color {
    border-color: <?php echo $cast_recruit_movie_border_color; ?>
  }

  .cast_recruit_table_title_text_color {
    color: <?php echo $cast_recruit_table_title_text_color; ?>
  }

  .cast_recruit_table_border_color {
    border-color: <?php echo $cast_recruit_table_border_color; ?>;
  }

  .cast_recruit_table_TH_style {
    background-color: <?php echo $cast_recruit_table_TH_bg_color; ?>;
    color: <?php echo $cast_recruit_table_TH_text_color; ?>;
  }

  .cast_recruit_table_TD_style {
    background-color: <?php echo $cast_recruit_table_TD_bg_color; ?>;
    color: <?php echo $cast_recruit_table_TD_text_color; ?>;
  }

  .cast_recruit_table_TH_inversion_text_color {
    color: <?php echo $cast_recruit_table_TH_inversion_text_color; ?>;
    fill: <?php echo $cast_recruit_table_TH_inversion_text_color; ?>;
  }

  .cast_recruit_table_treatment_item_style {
    color: <?php echo $cast_recruit_table_treatment_item_text_color; ?>;
    background-color: <?php echo $cast_recruit_table_treatment_item_bg_color; ?>;
  }

  .cast_recruit_table_treatment_item_style.deactive {
    background-color: <?php echo $cast_recruit_table_treatment_item_off_bg_color; ?>;
    display: none !important;
  }

  .cast_recruit_article_title_style {
    color: <?php echo $cast_recruit_article_title_text_color; ?>;
    border-color: <?php echo $cast_recruit_article_title_boder_color; ?>;
  }

  .dl_bg_color {
    background-color: <?php echo $sub_color; ?>;
  }

  .cast_recruit_contact_style {
    color: <?php echo $cast_recruit_contact_text_color; ?>;
    fill: <?php echo $cast_recruit_contact_text_color; ?>;
    background-color: <?php echo $cast_recruit_contact_bg_color; ?>;
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
      <a itemprop="item" href="<?= site_url('cast-recruit'); ?>/">
        <span class="text_style" itemprop="name">CAST-RECRUIT</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</div>

<div class="wraper">

  <div class="container">
    <article class="main">

      <section class="cast-recruit">
        <div class="cast-recruit__inner--<?php echo $cast_recruit_faq_thema_type; ?>">
          <h2 class="title_style">R E C R U I T</h2>
          <h3 class="sub_title_style">求人情報</h3>
        </div> <!-- /cast-recruit__inner-- -->
      </section> <!-- /cast-recruit-- -->

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
      ?>

      <?php
      if ($cast_recruit['eyecatch_image_url']) {
        $cast_recruit['eyecatch_image_url'] = str_replace('http://', 'https://', $cast_recruit['eyecatch_image_url']);
      ?>

        <section class="cont00">
          <img src="<?php echo $cast_recruit['eyecatch_image_url'];  ?>" alt="<?php echo $mono_addressLocality; ?>の<?php echo $for_alt_text; ?>「<?php echo $store_name; ?>」のキャスト求人アイキャッチ" />
        </section>
      <?php
      }
      ?>
      <?php
      if ($cast_recruit['reward']) {
        $cast_recruit['reward'] = str_replace('http://', 'https://', $cast_recruit['reward']);
      ?>
        <section class="cont-kingaku">
          <img src="<?php echo $cast_recruit['reward']  ?>" alt="「<?php echo $store_name; ?>」のキャスト求人の金額詳細" />
        </section>
      <?php
      }
      ?>

      <?php get_template_part('cast-recruit-freelayout'); ?>

      <?php
      $total_count = count($qa_list);
      if ($total_count > 0) {
      ?>
        <section class="faq">
          <div class="faq__inner--<?php echo $cast_recruit_faq_thema_type; ?>">
            <h4 class="pc cast_recruit_sub_title_text_color faq_title_text_style faq_border_color"><?php echo $faq_title_text; ?></h4>
            <h4 class="sp cast_recruit_sub_title_text_color sp_faq_title_text_style faq_border_color"><?php echo $faq_title_text; ?></h4>
            <ul>
              <?php
              foreach ($qa_list as $qa) {
              ?>
                <?php if (!empty($qa['question']) && !empty($qa['answer'])) : ?>
                  <li class="cast_recruit_QA_list_bg_color cast_recruit_basic_border_color faq_border_color">
                    <dl class="dl_bg_color">
                      <dt class="cast_recruit_QA_list_bg_color">
                        <span class="faq_Q_letter_style"><i>Q</i></span>
                        <h5 class="faq_Q_content_style"><i><?php echo nl2br($qa['question']); ?></i></h5>
                      </dt>
                      <dd class="cast_recruit_QA_list_A_bg_color">
                        <span class="faq_A_letter_style"><i>A</i></span>
                        <p class="faq_A_content_style"><?php echo nl2br($qa['answer']); ?></p>
                      </dd>
                    </dl>
                    <b class="faq_button_style cast_recruit_basic_border_color">
                      <svg class="close pop" xmlns="https://www.w3.org/2000/svg" width="14.574" height="8.05" viewBox="0 0 14.574 8.05">
                        <defs></defs>
                        <g transform="translate(-889.977 -4514.302)">
                          <rect class="a" width="1.085" height="10.3" transform="translate(896.5 4515.069) rotate(-45)" />
                          <rect class="a" width="1.085" height="10.3" transform="translate(897.26 4514.302) rotate(45)" />
                        </g>
                      </svg>
                      <svg class="open display-block pop" xmlns="https://www.w3.org/2000/svg" width="15.823" height="15.823" viewBox="0 0 15.823 15.823">
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
      if ((!empty($cast_recruit['interview_title_0']) && !empty($cast_recruit['interview_text_0'])) || (!empty($cast_recruit['interview_title_1']) && !empty($cast_recruit['interview_text_1'])) || (!empty($cast_recruit['interview_title_2']) && !empty($cast_recruit['interview_text_2'])) || (!empty($cast_recruit['interview_title_3']) && !empty($cast_recruit['interview_text_3']))) {
      ?>

        <section class="interview">
          <div class="interview__inner--<?php echo $cast_recruit_cast_voice_thema_type; ?>">
            <ul>
              <?php
              for ($i = 0; $i < 4; $i++) {
                if ($cast_recruit['interview_title_' . $i] && $cast_recruit['interview_text_' . $i]) {
              ?>
                  <li>
                    <div class="wrap">
                      <h4 class="cast_recruit_basic_title_font cast_recruit_cast_voice_title_text_color cast_recruit_sub_title_text_color"><?php echo nl2br($cast_recruit['interview_title_' . $i]); ?></h4>
                      <?php
                      if ($cast_recruit['interview_image_url_' . $i]) {
                        $cast_recruit['interview_image_url_' . $i] = str_replace('http://', 'https://', $cast_recruit['interview_image_url_' . $i]);
                      ?>
                        <div class="right cast_recruit_basic_border_color">
                          <img src="<?php echo $cast_recruit['interview_image_url_' . $i]; ?>" alt="" />
                        </div> <!-- /right -->
                      <?php
                      }
                      ?>
                      <div class="left cast_recruit_cast_voice_box_bg_color cast_recruit_basic_border_color">
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
                        <h4 class="cast_recruit_basic_title_font cast_recruit_cast_voice_title_text_color cast_recruit_sub_title_text_color"><?php echo $cast_recruit['interview_title_' . $i]; ?></h4>
                        <p class="cast_recruit_cast_voice_box_text_color"><?php echo nl2br($cast_recruit['interview_text_' . $i]); ?></p>
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
      if ($cast_recruit['video']) {
      ?>
        <section class="movie">
          <div class="movie__inner--<?php echo $cast_recruit_thema_type; ?>">
            <h4 class="cast_recruit_basic_title_font  cast_recruit_basic_border_color cast_recruit_sub_title_text_color cast_recruit_movie_title_text_color cast_recruit_movie_border_color"><i>求人動画</i></h4>
            <div class="wrap">
              <?php echo $cast_recruit['video']; ?>
            </div> <!-- /wrap -->
          </div> <!-- /movie__inner-- -->
        </section> <!-- /movie -->
      <?php
      }
      ?>

      <section class="recruit-table">

        <div class="recruit-table__inner recruit-table__inner--<?php echo $cast_recruit_thema_type; ?>">

          <h4 class="cast_recruit_basic_title_font cast_recruit_table_border_color cast_recruit_sub_title_text_color cast_recruit_basic_border_color cast_recruit_table_title_text_color"><i>募集要項</i></h4>

          <table class="cast_recruit_table_border_color cast_recruit_basic_border_color">
            <?php
            for ($i = 0; $i < 10; $i++) {
              if (!empty($cast_recruit['salary_title_' . $i])) {
            ?>
                <tr class="cast_recruit_table_border_color">
                  <?php
                  $flag = 0;
                  if (!empty($cast_recruit['salary_remarks_' . $i])) {
                    $flag = 1;
                  }
                  ?>
                  <th class="cast_recruit_table_TH_style" rowspan="<?php echo 1 + $flag; ?>"><?php echo nl2br($cast_recruit['salary_title_' . $i]); ?></th>
                  <td class="cast_recruit_table_TD_style">
                    <span class="cast_recruit_table_TH_inversion_text_color">
                      <?php
                      echo nl2br($cast_recruit['salary_text_' . $i]);
                      ?>
                    </span>
                  </td>
                </tr>
                <?php
                if ($flag) {
                ?>
                  <tr class="cast_recruit_table_border_color">
                    <td class="cast_recruit_table_TD_style">
                      <?php
                      echo nl2br($cast_recruit['salary_remarks_' . $i]);
                      ?>
                    </td>
                  </tr>
            <?php
                }
              }
            }
            ?>
            <?php
            if (!empty($cast_recruit['qualification'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">資格</th>
                <td class="cast_recruit_table_TD_style">
                  <?php
                  echo nl2br($cast_recruit['qualification']);
                  ?>
                </td>
              </tr>
            <?php } ?>
            <?php
            $daily_payment = $cast_recruit['daily_payment'] == 1 ? "" : "deactive";
            $inexperienced = $cast_recruit['inexperienced'] == 1 ? "" : "deactive";
            $free_attendance = $cast_recruit['free_attendance'] == 1 ? "" : "deactive";
            $costume_rental = $cast_recruit['costume_rental'] == 1 ? "" : "deactive";
            $drop_off = $cast_recruit['drop_off'] == 1 ? "" : "deactive";
            $pick_up = $cast_recruit['pick_up'] == 1 ? "" : "deactive";
            $travel_expense = $cast_recruit['travel_expense'] == 1 ? "" : "deactive";
            $parking_area = $cast_recruit['parking_area'] == 1 ? "" : "deactive";
            $last_train = $cast_recruit['last_train'] == 1 ? "" : "deactive";
            $hair_and_make = $cast_recruit['hair_and_make'] == 1 ? "" : "deactive";
            $nursery = $cast_recruit['nursery'] == 1 ? "" : "deactive";
            $dormitory = $cast_recruit['dormitory'] == 1 ? "" : "deactive";
            $w_work = $cast_recruit['w_work'] == 1 ? "" : "deactive";
            $quota  = $cast_recruit['quota'] == 1 ? "" : "deactive";
            $penalty = $cast_recruit['penalty'] == 1 ? "" : "deactive";
            $personal_locker = $cast_recruit['personal_locker'] == 1 ? "" : "deactive";
            $no_alcohol = $cast_recruit['no_alcohol'] == 1 ? "" : "deactive";
            $student_short_vacation_use = $cast_recruit['student_short_vacation_use'] == 1 ? "" : "deactive";
            $with_friends = $cast_recruit['with_friends'] == 1 ? "" : "deactive";
            $not_a_good_talker = $cast_recruit['not_a_good_talker'] == 1 ? "" : "deactive";

            if (
              $daily_payment == '' || $inexperienced == '' || $free_attendance == '' || $costume_rental == '' || $drop_off == '' ||
              $pick_up == '' || $travel_expense == '' || $parking_area == '' || $last_train == '' || $hair_and_make == '' ||
              $nursery == '' || $dormitory == '' || $w_work == '' || $quota == '' ||
              $penalty == '' || $personal_locker == '' || $no_alcohol == '' || $student_short_vacation_use == '' ||
              $with_friends == '' || $not_a_good_talker == ''
            ) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">待遇</th>
                <td class="cast_recruit_table_TD_style">
                  <ul class="treatment">
                    <li class="cast_recruit_table_treatment_item_style <?php echo $daily_payment; ?>"><i>日払いOK</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $inexperienced; ?>"><i>未経験者大歓迎</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $free_attendance; ?>"><i>自由出勤</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $costume_rental; ?>"><i>レンタル衣装</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $drop_off; ?>"><i>送りあり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $pick_up; ?>"><i>迎えあり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $travel_expense; ?>"><i>交通費支給</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $parking_area; ?>"><i>駐車場あり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $last_train; ?>"><i>終電あがりOK</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $hair_and_make; ?>"><i>ヘアメイクあり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $nursery; ?>"><i>託児あり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $dormitory; ?>"><i>寮あり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $w_work; ?>"><i>WワークOK</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $quota; ?>"><i>ノルマなし</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $penalty; ?>"><i>ペナルティなし</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $personal_locker ?>"><i>個人ロッカーあり</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $no_alcohol; ?>"><i>お酒飲めなくても<br />大丈夫</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $student_short_vacation_use ?>"><i>学生短期休み<br />利用OK</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $with_friends; ?>"><i>お友達と一緒OK</i></li>
                    <li class="cast_recruit_table_treatment_item_style <?php echo $not_a_good_talker; ?>"><i>お話苦手でも<br />大丈夫</i></li>
                  </ul>
                </td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['industry'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">業種</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['industry']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['occupation'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">職種</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['occupation']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['area'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">エリア</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['area']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['work_location'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">勤務地</th>
                <td class="cast_recruit_table_TD_style">
                  <address><?php echo nl2br($cast_recruit['work_location']); ?></address>
                  <?php $cast_recruit['work_location_googlemap'] = str_replace('http://', 'https://', $cast_recruit['work_location_googlemap']); ?>
                  <a class="open_the_map cast_recruit_table_TH_inversion_text_color" href="<?php echo $cast_recruit['work_location_googlemap']; ?>" target="_blank"><svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="10.282" height="15.155" viewBox="0 0 10.282 15.155">
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
            if (!empty($cast_recruit['nearest_station'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">最寄駅</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['nearest_station']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['working_days'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">勤務日</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['working_days']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['working_time'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">勤務時間</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['working_time']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['closed_store'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">店休日</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['closed_store']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['tel']) || !empty($cast_recruit['mail']) || !empty($cast_recruit['line_id'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">ご応募<br />お問い合わせ</th>
                <td class="cast_recruit_table_TD_style">
                  <ul class="contact">
                    <?php
                    if (!empty($cast_recruit['tel'])) {
                    ?>
                      <li>
                        <a onclick="return gtag_report_cast_recruit_tel_conversion('tel:<?= $cast_recruit['tel']; ?>');" href="tel:<?= $cast_recruit['tel']; ?>"><span class="cast_recruit_table_TH_inversion_text_color">TEL. <?= $cast_recruit['tel']; ?></span></a>
                      </li>
                    <?php
                    }
                    if (!empty($cast_recruit['mail'])) {
                    ?>
                      <li>
                        <!-- <a onclick="return gtag_report_conversion('mailto:<?php //echo $cast_recruit['mail']; ?>');" href="mailto:<?php //echo $cast_recruit['mail']; ?>"><span class="cast_recruit_table_TH_inversion_text_color">Mail. <?php //echo $cast_recruit['mail']; ?></span></a> -->
                        <a href="mailto:<?= $cast_recruit['mail']; ?>"><span class="cast_recruit_table_TH_inversion_text_color">Mail. <?= $cast_recruit['mail']; ?></span></a>
                      </li>
                    <?php
                    }
                    if (!empty($cast_recruit['line_id']) || !empty($cast_recruit['line_url'])) {
                      $cast_recruit['line_url'] = str_replace('http://', 'https://', $cast_recruit['line_url']);
                    ?>
                      <li>
                        <a onclick="return gtag_report_cast_recruit_line_conversion('<?= $cast_recruit['line_url']; ?>');" href="<?= $cast_recruit['line_url']; ?>" target="_blank">
                          <?php if (!$cast_recruit['line_id']) { ?>
                            <span class="cast_recruit_table_TH_inversion_text_color">LINE友達追加はこちら</span>
                          <?php } else { ?>
                            <span class="cast_recruit_table_TH_inversion_text_color">LINE ID. <?= $cast_recruit['line_id']; ?></span>
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
            if (!empty($cast_recruit['contact_person'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">担当</th>
                <td class="cast_recruit_table_TD_style"><?php echo nl2br($cast_recruit['contact_person']); ?></td>
              </tr>
            <?php } ?>
            <?php
            if (!empty($cast_recruit['official_site'])) {
            ?>
              <tr class="cast_recruit_table_border_color">
                <th class="cast_recruit_table_TH_style">オフィシャル<br />サイト</th>

                <td class="cast_recruit_table_TD_style">
                  <?php $cast_recruit['official_site'] = str_replace('http://', 'https://', $cast_recruit['official_site']); ?>
                  <a class="official_homepege_link02" href="<?php echo $cast_recruit['official_site']; ?>" target="_blank"><span class="cast_recruit_table_TH_inversion_text_color"><?php echo $cast_recruit['official_site']; ?></span></a>
                </td>
              </tr>
            <?php } ?>
          </table>

          <!--  <div class="bottom">
        <ul>
          <?php
          for ($i = 0; $i < 3; $i++) {
          ?>
          <li>
            <h5 class="cast_recruit_article_title_style"><?php echo $cast_recruit['free_subject_' . $i]; ?></h5>
            <p class="cast_recruit_table_border_color text_style"><?php echo $cast_recruit['free_text_' . $i]; ?></p>
          </li>
          <?php
          }
          ?>
        </ul>
      </div> -->
        </div>

      </section>

      <?php get_footer(); ?>

      <div id="fix_contact">
        <ul>
          <?php if ($cast_recruit['tel']) { ?>
            <li class="contact_by_tel">
              <a onclick="return gtag_report_cast_recruit_tel_conversion('tel:<?= $cast_recruit['tel']; ?>');" class="cast_recruit_contact_style" href="tel:<?= $cast_recruit['tel']; ?>">
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
                <address><?= $cast_recruit['tel']; ?></address>
              </a>
            </li>
          <?php } ?>
          <?php if ($cast_recruit['mail']) { ?>
            <li class="contact_by_mail">
              <!-- <a onclick="return gtag_report_conversion('mailto:<?php //echo $cast_recruit['mail']; ?>');" class="cast_recruit_contact_style" href="mailto:<?php //echo $cast_recruit['mail']; ?>"> -->
              <a class="cast_recruit_contact_style" href="mailto:<?= $cast_recruit['mail']; ?>">
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
          <?php if ($cast_recruit['line_url']) { ?>
            <li class="contact_by_line">
              <a onclick="return gtag_report_cast_recruit_line_conversion('<?= $cast_recruit['line_url']; ?>');" class="cast_recruit_contact_style" href="<?= $cast_recruit['line_url']; ?>" target="_blank">
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
          {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "mainEntityOfPage": {
              "@type": "WebPage",
              "@id": "<?= site_url('cast-recruit'); ?>/"
            },
            "inLanguage": "ja",
            "author": {
              "@type": "Organization",
              "@id": "<?= site_url(); ?>/",
              "name": "<?php echo $store_name; ?>",
              "url": "<?= site_url(); ?>/",
              "image": "<?php echo wp_get_attachment_url($logo);  ?>"
            },
            "headline": "キャスト求人情報",
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
                  "name": "CAST-RECRUIT",
                  "@id": "<?= site_url('cast-recruit'); ?>/"
                }
              }
            ]
          }
        ]
      </script>
