<?php
/*
Template Name:front-page
*/ query_posts('post');
require("setting.php");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php
  echo $analytics_tag;
  echo PHP_EOL;
  
  echo $ads_tag;
  echo PHP_EOL;

  echo $search_consol_tag;
  echo PHP_EOL;
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  $page_title = scf::get('ページタイトル', 34);
  $page_description = scf::get('ページ説明文', 34);
  $eyecatch_thema_type = scf::get('アイキャッチのテーマタイプ', 34);
  ?>
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="<?php echo $page_description; ?>">
  <link rel="canonical" href="<?= site_url(); ?>/">
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/front-page_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/front-page_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/front-page-freelayout_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/front-page-freelayout_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sns-modal_pc.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sns-modal_sp.css" />
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/add.css" />
  <link rel="icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="shortcut icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <link rel="apple-touch-icon" href="<?php echo wp_get_attachment_url($favicon_img); ?>">
  <!-- jquery読込 -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
  <!-- スワイパー -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/swiper/swiper.min.css" />
  <?php if ($eyecatch_thema_type === '■モーション01--flash' || $eyecatch_thema_type === '■モーション02--blur' || $eyecatch_thema_type === '■モーション03--zoom-out') { ?>
    <script src="<?php echo get_template_directory_uri(); ?>/js/vegas/vegas.min.js"></script>
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/vegas/vegas.min.css" />
  <?php } ?>
  <!-- og関連 -->
  <meta property="og:url" content="<?= site_url(); ?>/" />
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
    $news_title_length = 12;
    $news_content_length = 62;
  } else {
    echo '<meta name="viewport" content="width=1180" />';
    $news_title_length = 16;
    $news_content_length = 127;
  }
  ?>

  <?php
  wp_deregister_style('wp-block-library');
  wp_head();
  ?>

  <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
</head>
<?php
// トップページカスタムフィールドセット
$eyecatch_imgs_single = scf::get('◆アイキャッチ１枚画像PC版', 34);
$sp_eyecatch_imgs_single = scf::get('◆アイキャッチ１枚画像スマホ版', 34);
$eyecatch_url_single = scf::get('◆アイキャッチ１枚画像につけるリンクURL', 34);
$eyecatch_movie = scf::get('◎アイキャッチ動画', 34);
$eyecatch_movie_sp = scf::get('◎アイキャッチ動画（SP用）', 34);
$eyecatch_movie_sp_aspect_retio = scf::get('◎アイキャッチ動画■モーション画像比率（SP用）', 34);
$eyecatch_imgs_motion01 = scf::get('■モーション画像①', 34);
$eyecatch_imgs_motion02 = scf::get('■モーション画像②', 34);
$eyecatch_imgs_motion03 = scf::get('■モーション画像③', 34);
$eyecatch_imgs_motion04 = scf::get('■モーション画像④', 34);
$eyecatch_imgs_motion05 = scf::get('■モーション画像⑤', 34);
$eyecatch_imgs_motion06 = scf::get('■モーション画像⑥', 34);
$eyecatch_imgs_motion07 = scf::get('■モーション画像⑦', 34);
$eyecatch_imgs_motion08 = scf::get('■モーション画像⑧', 34);
$eyecatch_imgs_motion09 = scf::get('■モーション画像⑨', 34);
$eyecatch_imgs_motion10 = scf::get('■モーション画像⑩', 34);
$eyecatch_imgs_over_motion = scf::get('◎動画■モーションの上にのるロゴ画像', 34);
$eyecatch_imgs_over_motion_width = scf::get('◎動画■モーションの上にのる画像の横幅', 34);
$sp_eyecatch_imgs_over_motion_width = scf::get('◎動画■モーションの上にのるロゴ画像の横幅（SP用）', 34);
$eyecatch_imgs_over_motion_link_url = scf::get('◎動画■モーションの上のロゴにつけるリンクURL', 34);
$eyecatch_display_link = scf::get('◎動画■モーションの上のリンクボタン', 34);
$eyecatch_fv_link = scf::get('◎動画■モーションの上のリンクボタンURL', 34);
$eyecatch_fv_link_txt = scf::get('◎動画■モーションの上のリンクボタンの文章', 34);
$eyecatch_btn_text_color = scf::get('スライダー画像上のリンクボタンの文字色', 34);
$eyecatch_btn_title_bg_color = scf::get('スライダー画像上のリンクボタンの背景色', 34);
$eyecatch_fv_link_width = scf::get('◎動画■モーションの上のリンクボタンの横幅', 34);
$eyecatch_fv_link_width_sp = scf::get('◎動画■モーションの上のリンクボタンの横幅（SP用）', 34);
$eyecatch_fv_link_top = scf::get('◎動画■モーションの上のリンクボタンの位置', 34);
$eyecatch_fv_link_top_sp = scf::get('◎動画■モーションの上のリンクボタンの位置（SP用）', 34);
$overlay = scf::get('オーバレイ', 34);

$news_thema_type = scf::get('NEWSのテーマタイプ', 34);
$news_article_title_text_color = scf::get('NEWSの記事タイトルの文字色', 34);
$news_article_text_color = scf::get('NEWSの記事文章の文字色', 34);
$news_article_title_bg_color = scf::get('NEWSの記事タイトル帯の背景色', 34);
$news_link_icon_color = scf::get('NEWSのリンクアイコン色', 34);
$news_link_icon_bg_color = scf::get('NEWSのリンクアイコン背景色', 34);
$news_link_button_text = scf::get('NEWSのリンクボタンテキスト', 34);

$about_title = scf::get('アバウトタイトル', 34);
$about = scf::get('アバウト', 34);
$about_border = scf::get('アバウト線', 34);
?>
<?php get_template_part('common-styles'); ?>
<style type="text/css">
  .eyecatch--motion img.pc,
  .eyecatch--luxury img.pc {
    width: <?php echo $eyecatch_imgs_over_motion_width; ?>px;
  }

  .eyecatch--motion img.sp,
  .eyecatch--luxury img.sp {
    width: <?php echo $sp_eyecatch_imgs_over_motion_width; ?>px;
  }

  .eyecatch_link_style {
    color: <?php echo $eyecatch_btn_text_color; ?>;
    background-color: <?php echo $eyecatch_btn_title_bg_color; ?>;
  }

  .eyecatch_link_style:hover {
    background-color: <?php echo $eyecatch_btn_text_color; ?>;
    color: <?php echo $eyecatch_btn_title_bg_color; ?>;
  }

  .eyecatch--stylish .swiper-pagination-bullet-active {
    background-color: <?php echo $thema_color; ?> !important;
  }

  .news_link_icon_style {
    fill: <?php echo $news_link_icon_color; ?>;
    background-color: <?php echo $news_link_icon_bg_color; ?>;
  }

  .news_article_title_text_color {
    color: <?php echo $news_article_title_text_color; ?>;
  }

  .news_article_title_bg_color,
  .news_article_title_bg_color h4:after {
    background-color: <?php echo $news_article_title_bg_color; ?>;
  }

  .news_article_text_color {
    color: <?php echo $news_article_text_color; ?>;
  }

  .eyecatch--motion a.eyecatch_link_btn_style,
  .eyecatch--luxury a.eyecatch_link_btn_style {
    top: <?= $eyecatch_fv_link_top; ?>%;
  }

  .eyecatch_link_style {
    color: <?= $eyecatch_btn_text_color; ?>;
    background-color: <?= $eyecatch_btn_title_bg_color; ?>;
    display: inline-block;
    vertical-align: middle;
  }

  .eyecatch_link_btn_style {
    color: <?= $eyecatch_btn_text_color ?>;
    background-color: <?= $eyecatch_btn_title_bg_color; ?>;
    border: 1px solid <?= $eyecatch_btn_text_color ?>;
    width: <?= $eyecatch_fv_link_width; ?>px;
  }

   /* About */
  .about {
    border-top: 1px solid <?= $about_border; ?>;
    border-bottom: 1px solid <?= $about_border; ?>;
  }

  @media only screen and (max-width: 767.9px) {
    div.eyecatch--luxury.aspect-ratio2vs3,
    div.eyecatch--luxury.aspect-ratio2vs3 video,
    .eyecatch--motion.aspect-ratio2vs3 {
      aspect-ratio: 2 / 3 !important;
      height: auto;
      width: 100%;
      object-fit: cover;
    }

    div.eyecatch--luxury.aspect-ratio4vs5,
    div.eyecatch--luxury.aspect-ratio4vs5 video,
    .eyecatch--motion.aspect-ratio4vs5 {
      aspect-ratio: 4 / 5 !important;
      height: auto;
      width: 100%;
      object-fit: cover;
    }

    .eyecatch--motion a.eyecatch_link_btn_style,
    .eyecatch--luxury a.eyecatch_link_btn_style {
      top: <?= $eyecatch_fv_link_top_sp; ?>%;
    }

    .eyecatch_link_btn_style {
      width: <?= $eyecatch_fv_link_width_sp; ?>px;
    }
  }
</style>

<?php get_header(); ?>

<?php
switch ($eyecatch_thema_type):
  case '◆１枚画像--pop':
    $eyecatch_thema_type_meta = "pop"
?>
    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?> pc">
      <?php if ($eyecatch_url_single) { ?>
        <a href="<?php echo $eyecatch_url_single; ?>">
        <?php } ?>
        <img src="<?php echo wp_get_attachment_url($eyecatch_imgs_single); ?>" alt="アイキャッチ画像">
        <?php if ($eyecatch_url_single) { ?>
        </a>
      <?php } ?>
    </div> <!-- /eyecatch -->
    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?> sp">
      <?php if ($eyecatch_url_single) { ?>
        <a href="<?php echo $eyecatch_url_single; ?>">
        <?php } ?>
        <img src="<?php echo wp_get_attachment_url($sp_eyecatch_imgs_single); ?>" alt="スマホ版アイキャッチ画像">
        <?php if ($eyecatch_url_single) { ?>
        </a>
      <?php } ?>
    </div> <!-- /eyecatch -->
    <?php break; ?>
  <?php
  case '☆スライダー01--stylish':
    $eyecatch_thema_type_meta = "stylish"
  ?>
    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?>">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php
          $now = Date("Y-m-d\TH:i");
          $sliders_sql = "SELECT `image_url`,`link`,`install_button`,`button_text`,`expired_at`
                FROM `sliders`
                WHERE `subject_id` = " . $shop_id . "
                AND `subject_name` = 'shop'
                AND (`expired_at` >= '" . $now . "' OR `expired_at` IS NULL)
                AND (`expired_at` IS NULL OR `expired_at` > '" . $now . "')
                ORDER BY `priority` ASC";
          $sliders = $pdo->prepare($sliders_sql);
          $sliders->execute();
          $sliders = $sliders->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <?php
          foreach ($sliders as $slider) {
            $count = 1;
          ?>
            <div class="swiper-slide">
              <div class="wrap">
                <?php if ($slider['link'] && ($slider['install_button'])) { ?>
                  <?php
                  if (!empty($slider['image_url'])) {
                    $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                  ?>
                    <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                  <?php
                  } else {
                  ?>
                    <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                  <?php
                  }
                  ?>
                  <a class="eyecatch_link_style" href="<?php echo $slider['link']; ?>">
                    <span><?php echo $slider['button_text']; ?></span>
                  </a>
                <?php } elseif ($slider['link'] && (!$slider['install_button'])) { ?>
                  <a class="eyecatch_wrap_link" href="<?php echo $slider['link']; ?>">
                    <?php
                    if (!empty($slider['image_url'])) {
                      $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                    ?>
                      <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                    <?php
                    } else {
                    ?>
                      <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                    <?php
                    }
                    ?>
                  </a>
                <?php } elseif (!$slider['link']) { ?>
                  <?php
                  if (!empty($slider['image_url'])) {
                    $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                  ?>
                    <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                  <?php
                  } else {
                  ?>
                    <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                  <?php
                  }
                  ?>
                <?php } ?>

              </div>
            </div>
            <?php $count++; ?>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <script>
      var swiper = new Swiper('.swiper-container', {
        effect: "coverflow", //"slide", "fade", "cube", "coverflow" or "flip"
        slidesPerView: 1,
        slidesPerGroup: 1,
        loop: true,
        loopAdditionalSlides: 1,
        speed: 500,
        autoHeight: true,
        spaceBetween: 40,
        followFinger: false,
        centeredSlides: true,
        grabCursor: true,
        breakpoints: {
          767: {
            loop: true,
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 40
          },
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'bullets',
          clickable: true,
        },
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
      });
    </script>

    <?php break; ?>
  <?php
  case '☆スライダー02--stylish':
    $eyecatch_thema_type_meta = "stylish"
  ?>
    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?>">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php
          // $sliders_sql        = "SELECT `image_url`,`link`,`install_button`,`button_text`,`expired_at` FROM `sliders` WHERE `subject_id` = " . $shop_id . " AND `subject_name` = 'shop' AND (`expired_at` >= now() OR `expired_at` IS NULL) ORDER BY `priority` ASC";
          $now = Date("Y-m-d\TH:i");
          $sliders_sql = "SELECT `image_url`,`link`,`install_button`,`button_text`,`expired_at`
                FROM `sliders`
                WHERE `subject_id` = " . $shop_id . "
                AND `subject_name` = 'shop'
                AND (`expired_at` >= '" . $now . "' OR `expired_at` IS NULL)
                AND (`expired_at` IS NULL OR `expired_at` > '" . $now . "')
                ORDER BY `priority` ASC";
          $sliders = $pdo->prepare($sliders_sql);
          $sliders->execute();
          $sliders = $sliders->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <?php
          foreach ($sliders as $slider) {
            $count = 1;
          ?>
            <div class="swiper-slide">
              <div class="wrap">
                <?php if ($slider['link'] && ($slider['install_button'])) { ?>
                  <?php
                  if (!empty($slider['image_url'])) {
                    $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                  ?>
                    <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                  <?php
                  } else {
                  ?>
                    <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                  <?php
                  }
                  ?>
                  <a class="eyecatch_link_style" href="<?php echo $slider['link']; ?>">
                    <span><?php echo $slider['button_text']; ?></span>
                  </a>
                <?php } elseif ($slider['link'] && (!$slider['install_button'])) { ?>
                  <a class="eyecatch_wrap_link" href="<?php echo $slider['link']; ?>">
                    <?php
                    if (!empty($slider['image_url'])) {
                      $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                    ?>
                      <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                    <?php
                    } else {
                    ?>
                      <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                    <?php
                    }
                    ?>
                  </a>
                <?php } elseif (!$slider['link']) { ?>
                  <?php
                  if (!empty($slider['image_url'])) {
                    $slider['image_url'] = str_replace('http://', 'https://', $slider['image_url']);
                  ?>
                    <img src="<?php echo $slider['image_url']; ?>" alt="<?php echo $count; ?>番目のスライダー画像" />
                  <?php
                  } else {
                  ?>
                    <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                  <?php
                  }
                  ?>
                <?php } ?>
              </div>
            </div>
            <?php $count++; ?>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <script>
      var swiper = new Swiper('.swiper-container', {
        effect: "slide", //"slide", "fade", "cube", "coverflow" or "flip"
        loop: true,
        loopAdditionalSlides: 1,
        speed: 500,
        autoHeight: true,
        slidesPerView: 1,
        spaceBetween: 40,
        followFinger: false,
        centeredSlides: true,
        grabCursor: true,
        breakpoints: {
          767: {
            slidesPerView: 3,
            spaceBetween: 10
          },
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'bullets',
          clickable: true,
        },
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
      });
    </script>
    <?php break; ?>
  <?php
  case '◎動画--luxury':
    $eyecatch_thema_type_meta = "luxury"
  ?>
    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?> eyecatch_border_color <?= $eyecatch_movie_sp_aspect_retio; ?>">
      <video class="pc" src="<?php echo wp_get_attachment_url($eyecatch_movie); ?>" autoplay muted loop playsinline webkit-playsinline></video>
      <?php if ($eyecatch_movie_sp) { ?>
        <video class="sp" src="<?php echo wp_get_attachment_url($eyecatch_movie_sp); ?>" autoplay muted loop playsinline webkit-playsinline></video>
      <?php } else { ?>
        <video class="sp" src="<?php echo wp_get_attachment_url($eyecatch_movie); ?>" autoplay muted loop playsinline webkit-playsinline></video>
      <?php } ?>
      <?php if ($eyecatch_imgs_over_motion_link_url) { ?>
        <a href="<?php echo $eyecatch_imgs_over_motion_link_url; ?>">
      <?php } ?>
      <?php if ($eyecatch_imgs_over_motion) { ?>
        <img class="pc" src="<?php echo wp_get_attachment_url($eyecatch_imgs_over_motion); ?>" alt="動画の上にのる<?php echo $group_name; ?>のロゴ" />
        <img class="sp" src="<?php echo wp_get_attachment_url($eyecatch_imgs_over_motion); ?>" alt="スマホ版動画の上にのる<?php echo $group_name; ?>のロゴ" />
      <?php } ?>
      <?php if ($eyecatch_imgs_over_motion_link_url) { ?>
        </a>
      <?php } ?>
      <?php if ($eyecatch_display_link == true) { ?>
        <a href="<?php echo $eyecatch_fv_link; ?>" class="eyecatch_link_btn_style">
          <?= $eyecatch_fv_link_txt; ?>
        </a>
      <?php } ?>
    </div>
    <?php break; ?>


  <?php
  case '■モーション01--flash':
  case '■モーション02--blur':
  case '■モーション03--zoom-out':
    $eyecatch_thema_type_meta = "motion"
  ?>

    <div class="eyecatch--<?php echo $eyecatch_thema_type_meta; ?> eyecatch_border_color <?= $eyecatch_movie_sp_aspect_retio; ?>">
      <?php if ($eyecatch_imgs_over_motion_link_url) { ?>
        <a href="<?php echo $eyecatch_imgs_over_motion_link_url; ?>">
        <?php } ?>
        <?php if ($eyecatch_imgs_over_motion) { ?>
        <img class="pc" src="<?php echo wp_get_attachment_url($eyecatch_imgs_over_motion); ?>" alt="モーション画像の上にのる<?php echo $store_name; ?>のロゴ" />
        <img class="sp" src="<?php echo wp_get_attachment_url($eyecatch_imgs_over_motion); ?>" alt="スマホ版モーション画像の上にのる<?php echo $store_name; ?>のロゴ" />
        <?php } ?>
        <?php if ($eyecatch_imgs_over_motion_link_url) { ?>
        </a>
      <?php } ?>
      <?php if ($eyecatch_display_link == true) { ?>
        <a href="<?php echo $eyecatch_fv_link; ?>" class="eyecatch_link_btn_style">
          <?= $eyecatch_fv_link_txt; ?>
        </a>
      <?php } ?>
    </div>

    <?php break; ?>
<?php endswitch; ?>


<!-- テンプレパーツ コンセプト -->
<?php get_template_part('template-parts/concept'); ?>

<div class="wraper">

  <div class="container">

    <article class="main">

      <?php get_template_part('front-page-freelayout'); ?>

      <section class="news swiper-container-news-wrap">
        <div class="news__inner--<?php echo $news_thema_type; ?> swiper-container-news">
          <h2 class="news__title-main--<?php echo $news_thema_type; ?> title_style">N E W S</h2>
          <h3 class="news__title-sub--<?php echo $news_thema_type; ?> sub_title_style">最新ニュース</h3>
          <ul class="news__list--<?php echo $news_thema_type; ?>  swiper-wrapper">
            <?php
            $shop_news_sql = "SELECT `id`,`image_url`,`title`,`text`,`link` FROM `shop_news` where `shop_id` = " . $shop_id . " AND (`expired_at` >= now() OR `expired_at` IS NULL) ORDER BY `priority` ASC limit 4";
            $shop_news = $pdo->prepare($shop_news_sql);
            $shop_news->execute();
            $shop_news = $shop_news->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php
            $count = 1;
            foreach ($shop_news as $news) {
              // ニュース記事を最大4件出力。5回転目でブレイク
            ?>
              <li class="news__list-item--<?php echo $news_thema_type; ?> swiper-slide border_color">
                <a href="<?= site_url('news'); ?>/#news_<?php echo $news['id']; ?>">
                  <div class="news_list-item-imgwrap">
                    <?php if ($news['image_url']) {
                      $news['image_url'] = str_replace('http://', 'https://', $news['image_url']);
                    ?>
                      <img class="news__list-item-img--<?php echo $news_thema_type; ?>" src="<?php echo $news['image_url']; ?>" alt="<?php echo $count; ?>番目のニュース記事「<?php echo $news['title']; ?>の画像" />
                    <?php } else { ?>
                      <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                    <?php } ?>
                  </div>
                  <div class="news__list-item-content--<?php echo $news_thema_type; ?> news_article_title_bg_color">
                    <h4 class="news__list-item-content-title--<?php echo $news_thema_type; ?> news_article_title_text_color"><i><?php if (mb_strlen($news['title']) > $news_title_length) {
                                                                                                                                  $title = mb_substr($news['title'], 0, $news_title_length);
                                                                                                                                  echo $title . "…";
                                                                                                                                } else {
                                                                                                                                  echo $news['title'];
                                                                                                                                } ?></i></h4>
                    <p class="news__list-item-content-text--<?php echo $news_thema_type; ?> news_article_text_color"><?php if (mb_strlen($news['text']) > $news_content_length) {
                                                                                                                        $title = mb_substr($news['text'], 0, $news_content_length);
                                                                                                                        echo $title . "…";
                                                                                                                      } else {
                                                                                                                        echo nl2br($news['text']);
                                                                                                                      } ?></p>
                    <?php
                    switch ($news_thema_type):
                      case 'stylish':
                    ?>
                        <div class="news__list-item-content-linkmark--stylish news_link_icon_style">
                          <svg xmlns="https://www.w3.org/2000/svg" width="7.337" height="8.68" viewBox="0 0 7.337 8.68">
                            <path d="M0,0v8.68L7.337,4.34Z" transform="translate(0 0)" />
                          </svg>
                        </div> <!-- /news__list-item-linkmark--stylish -->
                        <?php break; ?>
                      <?php
                      case 'luxury': ?>
                        <div class="news__list-item-content-linkmark--luxury news_link_icon_style">
                          <svg xmlns="https://www.w3.org/2000/svg" width="7.248" height="12" viewBox="0 0 7.248 12">
                            <defs></defs>
                            <path class="a" d="M.542,0,0,.485,6.164,6,0,11.515.542,12,7.248,6Z" transform="translate(0 0)" />
                          </svg>
                        </div> <!-- /news__list-item-linkmark--luxury -->
                        <?php break; ?>
                    <?php endswitch; ?>
                  </div> <!-- /news__list-item-content -->
                </a>
              </li>
            <?php
              $count++;
            }
            ?>
          </ul>
          <a class="news__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('news'); ?>/"><span><?php echo $news_link_button_text; ?></span></a>
        </div> <!-- /news__inner -->
      </section> <!-- /news -->

      <?php
      switch ($news_thema_type):
        case 'pop':
      ?>
          <!-- 今のところ何もも出さない -->
          <?php break; ?>
        <?php
        case 'stylish': ?>

          <script type="text/javascript">
            var w = $(window).width();
            if (w <= 767.9) {
              var mySwiper = new Swiper('.swiper-container-news', {
                effect: "slide",
                fadeEffect: {
                  crossFade: true
                },
                slidesPerView: 1.335,
                spaceBetween: 15,
                loop: false,
              });
            }
          </script>

          <?php break; ?>
        <?php
        case 'luxury': ?>
          <!-- 今のところ何もも出さない -->

      <?php endswitch; ?>

      <?php
      $casts_count_sql = "SELECT count(id) FROM `casts` WHERE `shop_id` = " . $shop_id . " AND `cabaweb_privacy` = 1";
      $casts_count = $pdo->prepare($casts_count_sql);
      $casts_count->execute();
      $casts_count = $casts_count->fetch(PDO::FETCH_ASSOC);
      ?>

      <?php if ($casts_count['count(id)'] > 0) : ?>

        <section class="schedule" id="<?php echo $schedule_exsitance_status ?>">
          <div class="schedule__inner--<?php echo $schedule_thema_type; ?>">
            <h2 class="schedule__title-main--<?php echo $schedule_thema_type; ?> title_style">&nbsp;<?php echo $schedule_title_text; ?>&nbsp;<span>&nbsp;S C H E D U L E&nbsp;</span></h2>
            <h3 class="schedule__title-sub--<?php echo $schedule_thema_type; ?> sub_title_style">出勤情報</h3>

            <?php if ($schedule_exsitance_flg) : ?>
              <?php
              switch ($schedule_period):
                case 'today':
              ?>
                  <!-- 今のところ何もも出さない -->
                  <?php break; ?>
                <?php
                case 'weekly': ?>

                  <div class="schedule__period-wrap--<?php echo $schedule_period_thema_type; ?>">
                    <div class="swiper-container-schedule--<?php echo $schedule_period_thema_type; ?>">
                      <ul class="schedule__period-list--<?php echo $schedule_period_thema_type; ?> swiper-wrapper">
                        <?php
                        $time = (int)$shop['attendance_switching_time'];
                        if ($time > 12) {
                          $time = 24 - $time;
                        } else {
                          $time = -$time;
                        }
                        $date  = getParamval('date');
                        if (getParamval('date') == "all") {
                          $date = "";
                          $style = 'schedule_selector_active_style';
                        }
                        ?>
                        <li class="schedule__period-list-item--<?php echo $schedule_period_thema_type; ?> border_color swiper-slide schedule_period_style <?php echo $style; ?>">
                          <a class="schedule_period_text_color" href="<?= site_url('cast'); ?>?/">
                            <span>在籍<br />一覧</span>
                          </a>
                        </li>
                        <?php
                        for ($i = 0; $i < 7; $i++) {
                          $week = [
                            '日', //0
                            '月', //1
                            '火', //2
                            '水', //3
                            '木', //4
                            '金', //5
                            '土', //6
                          ];
                          $d = Date("m/d", strtotime('+' . ($i) . 'day ' . ' +' . ($time) . 'hours'));
                          $w = Date("w", strtotime('+' . ($i) . 'day ' . ' +' . ($time) . 'hours'));
                          $style = '';
                          if ($date == $w || ($date == "" && $i == 0)) {
                            $style = 'schedule_selector_active_style';
                          } else {
                            $style = '';
                          }
                        ?>
                          <li class="schedule__period-list-item--<?php echo $schedule_period_thema_type; ?> border_color swiper-slide schedule_period_style <?php echo $style; ?>">
                            <a class="schedule_period_text_color" href="<?= site_url(''); ?>/?date=<?php echo $w; ?>#schedule">
                              <span><?php echo $d; ?><br />（<?php echo $week[$w]; ?>）</span>
                            </a>
                          </li>
                        <?php
                        }
                        ?>
                      </ul>
                    </div> <!-- /swiper-container-schedule -->

                    <?php
                    switch ($schedule_period_thema_type):
                      case 'pop':
                    ?>
                        <div class="swiper-button-schedul-pop-prev schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108">
                            <path d="M21.236,0,0,18.554,21.236,37.108l.875-.765L1.752,18.554,22.112.766Z" transform="translate(0 0)" />
                          </svg></div>
                        <div class="swiper-button-schedul-pop-next schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108">
                            <path d="M.876,0,0,.766,20.36,18.554,0,36.344l.876.765L22.112,18.554Z" transform="translate(0 0)" />
                          </svg></div>

                        <script type="text/javascript">
                          var mySwiper = new Swiper('.swiper-container-schedule--pop', {
                            effect: "slide",
                            fadeEffect: {
                              crossFade: true
                            },
                            slidesPerView: 4.04,
                            spaceBetween: 7,
                            loop: false,
                            navigation: {
                              nextEl: '.swiper-button-schedul-pop-next', //「次へ」ボタンの要素のセレクタ
                              prevEl: '.swiper-button-schedul-pop-prev', //「前へ」ボタンの要素のセレクタ
                            },
                            breakpoints: {
                              // 768px以上の場合
                              768: {
                                spaceBetween: 13,
                              },
                            }
                          })
                        </script>

                        <?php break; ?>
                      <?php
                      case 'stylish': ?>
                        <!-- 何も出さない -->
                        <?php break; ?>

                      <?php
                      case 'luxury': ?>

                        <script type="text/javascript">
                          var w = $(window).width();
                          if (w <= 767.9) {
                            var mySwiper = new Swiper('.swiper-container-schedule--luxury', {
                              effect: "slide",
                              fadeEffect: {
                                crossFade: true
                              },
                              slidesPerView: 3.43,
                              spaceBetween: 0,
                              loop: false,
                            })
                          }
                        </script>

                        </script>
                        <?php break; ?>
                    <?php endswitch; ?>




                  </div> <!-- /schedule__period-wrap -->

                  <?php break; ?>
              <?php endswitch; ?>
              <ul class="schedule__list--<?php echo $schedule_thema_type; ?>">
                <?php
                $param = getParamval('date');
                $date = Date("w", strtotime('+' . (0) . 'day ' . ' +' . ($time) . 'hours'));
                if ($param == "") {
                  $casts_sql = "SELECT cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`work_" . $date . "` = 1 AND casts.`shop_id` = " . $shop_id . " AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC";
                } else {
                  if($date <= $param) {
                    $target = $param - $date;
                  } else {
                    $target = 7 - ($date - $param);
                  }
                  $date = Date("w", strtotime('+' . ($target) . 'day ' . ' +' . ($time) . 'hours'));
                  $casts_sql = "SELECT cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`work_" . $param . "` = 1 AND casts.`shop_id` = " . $shop_id . " AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC";
                }
                $trial_sql = "SELECT `trial_0`,`trial_1`,`trial_2`,`trial_3`,`trial_4`,`trial_5`,`trial_6` FROM `trial_schedules` WHERE `shop_id` = " . $shop_id;
                $trial = $pdo->prepare($trial_sql);
                $trial->execute();
                $trial = $trial->fetch(PDO::FETCH_ASSOC);

                $casts = $pdo->prepare($casts_sql);
                $casts->execute();
                $casts = $casts->fetchAll(PDO::FETCH_ASSOC);
                foreach ($casts as $cast) {
                  $text = "本日出勤";
                  if (getParamval('date') <> "") {
                    $text = "出勤時間";
                  }
                  $sns_sql = "SELECT DISTINCT `main_sns`,`main_sns_set`,`instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url` FROM `sns` WHERE `subject_name` = 'cast' AND subject_id = " . $cast['cast_id'] . " limit 1";
                  $sns  = $pdo->prepare($sns_sql);
                  $sns->execute();
                  $sns = $sns->fetch();
                  $work       = $cast['work_' . $date];
                  $time_start = $cast['time_start_' . $date];
                  $time_end   = $cast['time_end_' . $date];
                ?>
                  <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a href="<?= site_url('profile'); ?>/?cast=<?php echo $cast['cast_id']; ?>">
                      <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                        <?php
                        if ($cast['image_url'] != "") {
                          $cast['image_url'] = str_replace('http://', 'https://', $cast['image_url']);
                        ?>
                          <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo $cast['image_url']; ?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast['name']; ?>」の肖像写真" />
                        <?php
                        } else {
                        ?>
                          <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                        <?php
                        }
                        if(strpos($sns['main_sns'], '0') !== false) {
                          $sns_icon = 0;
                        } elseif(strpos($sns['main_sns'], '3') !== false) {
                          $sns_icon = 3;
                        } elseif(strpos($sns['main_sns'], '1') !== false) {
                          $sns_icon = 1;
                        } elseif(strpos($sns['main_sns'], '2') !== false) {
                          $sns_icon = 2;
                        } else {
                          $sns_icon = -1;
                        }
                        switch($sns_icon) {
                          case 0: //Instagram
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                            break;
                          case 1: //Youtube
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                            break;
                          case 2: //X
                            $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                            break;
                          case 3: //Tiktok
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                            break;
                          default:
                            $svg = '';
                            break;
                        }
                        if ($svg != '' && $sns['main_sns_set']) {
                          echo '<span class="schedule__list-item-thumnail-snslink--' . $schedule_thema_type . ' sns_icon_bg_color"><i class="schedule__list-item-thumnail-tiktok-icon--' . $schedule_thema_type . ' sns_icon_color">' . $svg . '</i></span>';
                        }
                        ?>
                      </div> <!-- /schedule__list-item-thumnail -->
                      <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                        <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i><?php echo $cast['name']; ?></i></h4>
                        <?php
                        if ($date != "" && $shop['time_schedule_function'] == 1) {
                        ?>
                          <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>">
                            <?php
                            if ($work) {
                              // $text = "本日出勤";
                            } else {
                              $text = "要確認";
                            }
                            ?>
                            <?php if($time_start || $time_end) { ?>
                            <h5 class="in_the_store_today_style"><span><?php echo $text; ?></span></h5>
                            <h6 class="working_hours_style"><span><?php echo substr($time_start, 0, 5) . " - " . substr($time_end, 0, 5); ?></span></h6>
                            <?php } ?>
                          </div> <!-- /schedule__list-item-content-bottom -->
                        <?php
                        }
                        ?>
                      </div> <!-- /news__list-item-content -->
                    </a>
                  </li>
                <?php
                }
                $w = Date("w", strtotime('+' . (0) . 'day' . ' +' . ($time) . 'hours'));
                if ($param != "") {
                  $w = Date("w", strtotime('+' . ($param - $w) . 'day' . ' +' . ($time) . 'hours'));
                }
                $number = $trial['trial_' . $w];
                for ($i = 1; $i <= $number; $i++) {
                ?>
                  <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a tabindex="-1">
                      <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                        <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                      </div> <!-- /schedule__list-item-thumnail -->
                      <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                        <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i>体験入店<?php echo $i; ?></i></h4>
                        <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>">
                          <!-- <h5 class="in_the_store_today_style"><span><?php echo $text; ?></span></h5>
                          <h6 class="working_hours_style"><span></span></h6> -->
                        </div> <!-- /schedule__list-item-content-bottom -->
                      </div> <!-- /news__list-item-content -->
                    </a>
                  </li>
                <?php
                }
                ?>
              </ul>

              <!-- スケジュールブロックなしはキャスト上位8名表示 -->
            <?php else : ?>

              <ul class="schedule__list--<?php echo $schedule_thema_type; ?>">
                <?php
                $casts_regular_sql = "SELECT  cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`shop_id` = " . $shop_id . " AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC limit 8";
                $casts_regular = $pdo->prepare($casts_regular_sql);
                $casts_regular->execute();
                foreach ($casts_regular as $cast) {
                  $sns_sql = "SELECT DISTINCT `main_sns`,`main_sns_set`,`instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url` FROM `sns` WHERE `subject_name` = 'cast' AND `subject_id` = " . $cast['cast_id'] . " limit 1";
                  $sns  = $pdo->prepare($sns_sql);
                  $sns->execute();
                  $sns = $sns->fetch();
                ?>
                  <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a href="<?= site_url('profile'); ?>/?cast=<?php echo $cast['cast_id']; ?>">
                      <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                        <?php
                        if ($cast['image_url'] != "") {
                          $cast['image_url'] = str_replace('http://', 'https://', $cast['image_url']);
                        ?>
                          <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo $cast['image_url']; ?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast['name']; ?>」の肖像写真" />
                        <?php
                        } else {
                        ?>
                          <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                        <?php
                        }
                        if(strpos($sns['main_sns'], '0') !== false) {
                          $sns_icon = 0;
                        } elseif(strpos($sns['main_sns'], '3') !== false) {
                          $sns_icon = 3;
                        } elseif(strpos($sns['main_sns'], '1') !== false) {
                          $sns_icon = 1;
                        } elseif(strpos($sns['main_sns'], '2') !== false) {
                          $sns_icon = 2;
                        } else {
                          $sns_icon = -1;
                        }
                        switch ($sns_icon) {
                          case 0: //Instagram
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                            break;
                          case 1: //Youtube
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                            break;
                          case 2: //X
                            $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                            break;
                          case 3: //Tiktok
                            $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                            break;
                          default:
                            $svg = '';
                            break;
                        }
                        if ($svg != '' && $sns['main_sns_set']) {
                          echo '<span class="schedule__list-item-thumnail-snslink--' . $schedule_thema_type . ' sns_icon_bg_color"><i class="schedule__list-item-thumnail-tiktok-icon--' . $schedule_thema_type . ' sns_icon_color">' . $svg . '</i></span>';
                        }
                        ?>
                      </div> <!-- /schedule__list-item-thumnail -->
                      <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                        <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i><?php echo $cast['name']; ?></i></h4>
                      </div> <!-- /news__list-item-content -->
                    </a>
                  </li>
                <?php
                }
                ?>
              </ul>

            <?php endif ?>


            <a class="schedule__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('cast'); ?>/"><span><?php echo $schedule_link_button_text; ?></span></a>
          </div> <!-- /schedule__inner -->
        </section> <!-- /schedule -->

      <?php endif ?>


  <?php
    // キャストのリストを取得
    $casts_query = "SELECT * FROM casts WHERE shop_id = :shop_id";
    $cast_stmt = $pdo->prepare($casts_query);
    $cast_stmt->execute(array(':shop_id' => $shop_id));
    $casts = $cast_stmt->fetchAll(PDO::FETCH_ASSOC);

    $sns_list = array();

    // 各キャストに対してSNS投稿を取得
    foreach($casts as $cast) {
      $sns_sql = "SELECT `main_sns` FROM `sns` WHERE `subject_id` = ".$cast['id']." AND `subject_name` = 'cast' AND `main_sns_set` = 1 LIMIT 1";
      $main_sns_stmt = $pdo->prepare($sns_sql);
      $main_sns_stmt->execute();
      $main_sns = $main_sns_stmt->fetchColumn();

      // main_snsからsns_typeの条件を取得
      $sns_type_conditions = [];

      if (strpos($main_sns, '0') !== false) {
          $sns_type_conditions[] = "sns_posts.`sns_type` = 0";
      }
      if (strpos($main_sns, '1') !== false) {
          $sns_type_conditions[] = "sns_posts.`sns_type` = 1";
      }
      if (strpos($main_sns, '2') !== false) {
          $sns_type_conditions[] = "sns_posts.`sns_type` = 2";
      }
      if (strpos($main_sns, '3') !== false) {
          $sns_type_conditions[] = "sns_posts.`sns_type` = 3";
      }
      if (empty($main_sns)) { // 何も表示させない
          $sns_type_conditions[] = "sns_posts.`sns_type` = -1";
      }
      $sns_type_condition = implode(" OR ", $sns_type_conditions);

      // 各キャストのSNS投稿を取得
      $sns_list_sql = "SELECT sns_posts.`id` AS `id`, sns.`instagram_account_url` AS `instagram_account_url`, sns.`youtube_account_url` AS `youtube_account_url`, sns.`twitter_account_url` AS `twitter_account_url`, sns.`tiktok_account_url` AS `tiktok_account_url`, sns_posts.`parent_id` AS `parent_id`, sns_posts.`priority` AS `priority`, sns_posts.`subject_id` AS `subject_id`, sns_posts.`subject_name` AS `subject_name`, sns_posts.`sns_type` AS `sns_type`,sns_posts.`guid` AS `guid`, sns_posts.`original_image_url` AS `original_image_url`, sns_posts.`original_video_url` AS `original_video_url`, sns_posts.`image_url` AS `image_url`, sns_posts.`video_url` AS `video_url`, sns_posts.`description` AS `description`, sns_posts.`published_at` AS `published_at`, shops.`id` AS `shop_id`, casts.`id` AS `cast_id` ,casts.`name` AS `name`, casts.`work_0` AS `work_0`,casts.`work_1` AS `work_1`,casts.`work_2` AS `work_2`,casts.`work_3` AS `work_3`,casts.`work_4` AS `work_4`, casts.`work_5` AS `work_5`, casts.`work_6` AS `work_6`, cast_images.`image_url` AS `thumbnail`, shops.`name` AS `shop_name`,sns.`main_sns` AS `main_sns` FROM `sns_posts` JOIN `sns` ON sns.`subject_id` = sns_posts.`subject_id` and sns.`subject_name` = sns_posts.`subject_name` JOIN `casts` ON casts.`id` = sns_posts.`subject_id` JOIN `shops` ON shops.`id` = casts.`shop_id` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`id` = ".$cast['id']." AND sns.`cabaweb_privacy` = 1 AND ($sns_type_condition) AND (sns_posts.image_url IS NOT NULL OR sns_posts.image_url != '') ORDER BY `published_at` DESC LIMIT 100";
      $sns_list_stmt = $pdo->prepare($sns_list_sql);
      $sns_list_stmt->execute();
      $sns_list_cast = $sns_list_stmt->fetchAll(PDO::FETCH_ASSOC);

      // 結果を $sns_list にマージ
      $sns_list = array_merge($sns_list, $sns_list_cast);
    }

      // ショップを取得
      $sns_sql_shop = "SELECT `main_sns` FROM `sns` WHERE `subject_id` = ".$shop_id." AND `subject_name` = 'shop' AND `main_sns_set` = 1 LIMIT 1";
      $main_sns_stmt_shop = $pdo->prepare($sns_sql_shop);
      $main_sns_stmt_shop->execute();
      $main_sns_shop = $main_sns_stmt_shop->fetchColumn();

      $sns_type_conditions_shop = [];
      if (strpos($main_sns_shop, '0') !== false) {
            $sns_type_conditions_shop[] = "sns_posts.`sns_type` = 0";
        }
        if (strpos($main_sns_shop, '1') !== false) {
            $sns_type_conditions_shop[] = "sns_posts.`sns_type` = 1";
        }
        if (strpos($main_sns_shop, '2') !== false) {
            $sns_type_conditions_shop[] = "sns_posts.`sns_type` = 2";
        }
        if (strpos($main_sns_shop, '3') !== false) {
            $sns_type_conditions_shop[] = "sns_posts.`sns_type` = 3";
        }
        if (empty($main_sns_shop)) { //何も表示させない
            $sns_type_conditions_shop[] = "sns_posts.`sns_type` = -1";
        }
        $sns_type_condition_shop = implode(" OR ", $sns_type_conditions_shop);

        $sns_list_sql_shop = "SELECT sns_posts.`id` AS `id`, sns.`instagram_account_url` AS `instagram_account_url`, sns.`youtube_account_url` AS `youtube_account_url`, sns.`twitter_account_url` AS `twitter_account_url`, sns.`tiktok_account_url` AS `tiktok_account_url`, sns_posts.`parent_id` AS `parent_id`, sns_posts.`priority` AS `priority`, sns_posts.`subject_id` AS `subject_id`, sns_posts.`subject_name` AS `subject_name`, sns_posts.`sns_type` AS `sns_type`,sns_posts.`guid` AS `guid`, sns_posts.`original_image_url` AS `original_image_url`, sns_posts.`original_video_url` AS `original_video_url`,sns_posts.`image_url` AS `image_url`, sns_posts.`video_url` AS `video_url`, sns_posts.`description` AS `description`, sns_posts.`published_at` AS `published_at`, shops.`id` AS `shop_id`, NULL AS `cast_id`,shops.`name` AS `name`,shops.`name` AS `shop_name`, null as `work_0`,null as `work_1`,null as `work_2`,null as `work_3`,null as `work_4`, null as `work_5`, null as `work_6`, shop_images.`image_url` AS `thumbnail` FROM `sns_posts` JOIN `sns` ON sns.`subject_id` = sns_posts.`subject_id` AND sns.`subject_name` = sns_posts.`subject_name` JOIN `shops` ON shops.`id` = sns_posts.`subject_id` JOIN `shop_images` ON shop_images.`shop_id` = shops.`id` WHERE shop_images.`images_subject` = 'サムネ' AND shops.`id` = " . $shop_id . " AND sns.`cabaweb_privacy` = 1 AND ($sns_type_condition_shop)  AND (sns_posts.image_url IS NOT NULL OR sns_posts.image_url != '') ORDER BY `published_at` DESC LIMIT 100";
        $sns_list_stmt = $pdo->prepare($sns_list_sql_shop);
        $sns_list_stmt->execute();
        $sns_list_shop = $sns_list_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 結果を $sns_list にマージ
        $sns_list = array_merge($sns_list, $sns_list_shop);
        $list = [];
        foreach($sns_list as $post) {
          if(!is_null($post["parent_id"])) {
              // すでに親IDのリストが存在するか確認
              $parent = null;
              foreach(array_keys($list) as $item) {
                if($post["parent_id"] == $item) {
                  $parent = $item;
                  break;
                }
              }

            // 親IDのリストが存在しない場合、新しいリストを作成して追加
            if(is_null($parent)) {
              $list[$post["parent_id"]] = [];
              $list[$post["parent_id"]][] = $post;
            } else {
              $list[$parent][] = $post;
              usort($list[$parent],['Item','sortByPriority']);
            }
          } else {
            $target = null;
            foreach(array_keys($list) as $item) {
              if($item == $post['id']) {
                $target = $item;
                break;
              }
            }
            if(is_null($target)) {
              $list[$post['id']] = [];
              $list[$post['id']][] = $post;
            } else {
              $list[$target][] = $post;
              usort($list[$target],['Item','sortByPriority']);
            }
          }
        }

        $sns_list = $list;
        class Item {
          public static function sortByPriority($a, $b) {
            return $a["priority"] - $b["priority"];
          }
        }

        // 最終的な結果を最新順に並べ替え最新の27件を取得
        usort($sns_list, function($a, $b) {
          $dateA = isset($a[0]['published_at']) ? strtotime($a[0]['published_at']) : 0;
          $dateB = isset($b[0]['published_at']) ? strtotime($b[0]['published_at']) : 0;
          return $dateB - $dateA;
        });
        $sns_list = array_slice($sns_list, 0, 27);
      ?>

      <?php
      //全記事数を変数に代入。
      $total_count = count($sns_list);
      //記事０件ならブロックごと出さない。
      if ($total_count) {
      ?>
        <section class="sns">
          <div class="sns__inner--<?php echo $sns_thema_type; ?>">
            <h2 class="sns__title-main--<?php echo $sns_thema_type; ?> title_style">S N S</h2>
            <h3 class="sns__title-sub--<?php echo $sns_thema_type; ?> sub_title_style">新着インスタ・ティックトック・ユーチューブ・ツイッター</h3>
            <?php
            $count = 1;
            foreach ($sns_list as $value) {
              if ($value[0]['image_url'] != "" || $value[0]['thumbnail']) {
                if ($count % 9 == 1) { // ループの初回だけ実行
                ?>
                  <ul class="sns__list--<?php echo $sns_thema_type; ?>">
                  <?php
                } // ul開始タグ判定
                  ?>
                  <?php
                  //SNS種類による出力切り分けの変数セット
                  $account_url = '';
                  $sns_name = '';
                  $svg = '';
                  switch ($value[0]['sns_type']) {
                    case '0':
                      $sns_name = 'Instagram';
                      $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                      break;
                    case '1':
                      $sns_name = 'YouTube';
                      $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                      break;
                    case '2':
                      $sns_name = 'Twitter';
                      $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                      break;
                    case '3':
                      $sns_name = 'Tiktok';
                      $svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                      break;
                  }
                  ?>
                  <li class="position<?php echo sprintf('%02d', $count); ?> sns__list-item--<?php echo $sns_thema_type; ?>  border_color" data-cast_id="<?php if ($value[0]['cast_id']) {
                                                                                                                                                          echo $value[0]['cast_id'];
                                                                                                                                                        } else {
                                                                                                                                                          echo '0';
                                                                                                                                                        } ?>" data-shop_id="<?php echo $value[0]['shop_id']; ?>">
                    <div class="sns__list-item-thumnail--<?php echo $sns_thema_type; ?>">
                      <?php
                      $value[0]['image_url'] = str_replace('http://', 'https://', $value[0]['image_url']);
                      $value[0]['thumbnail'] = str_replace('http://', 'https://', $value[0]['thumbnail']);
                      ?>
                        <img class="sns__list-item-thumnail-img--<?php echo $sns_thema_type; ?>" src="<?php if ($value[0]['image_url']) {
                                                                                                      echo $value[0]['image_url'];
                                                                                                    } elseif ($value[0]['thumbnail']) {
                                                                                                      echo $value[0]['thumbnail'];
                                                                                                    } else {
                                                                                                      echo $no_img;
                                                                                                    } ?>" alt="<?php echo $count; ?>番目のSNSサムネイル、'<?php echo $value[0]['shop_name']; ?>'<?php if ($value[0]['subject_name'] == 'cast') {
                                                                                                                                                                                        echo '所属のキャスト' . $value[0]['name'];
                                                                                                                                                                                      } ?>の<?php echo $sns_name; ?>投稿" />
                      <span class="sns__list-item-thumnail-snslink--<?php echo $sns_thema_type; ?> sns_icon_bg_color" href="">
                        <i class="sns__list-item-thumnail-<?php echo $sns_name; ?>-icon--<?php echo $sns_thema_type; ?> sns_icon_color">
                          <?php echo $svg; ?>
                        </i>
                      </span>
                    </div> <!-- /sns__list-item-thumnail -->
                  </li>
                  <?php
                  if (($count % 9 == 0) || ($count == $total_count)) {
                  ?>
                  </ul>
                  <?php
                    if ($count != $total_count) {
                  ?>
                    <b class="sns__more-button--<?php echo $button_shape_thema_type; ?> button_style border_color more" href=""><span><?php echo $sns_link_button_text; ?></span></b>
                  <?php
                    } //end_if 最後の1件はもっと見るボタンを出さない
                  ?>
                <?php
                  } //end_if ul閉じタグ9件で1セット判定
                ?>
            <?php
              $count++;
            }
            } //end_foreach
            ?>

          </div> <!-- /sns__inner -->
        </section> <!-- /sns -->
      <?php
      }
      ?>

      <?php
      $shop_photos_sql = "SELECT `image_url` FROM `shop_images` WHERE `shop_id` = " . $shop_id . " AND `images_subject` = 'TOP' ORDER BY `image_number` ASC LIMIT 4";
      $shop_photos        = $pdo->prepare($shop_photos_sql);
      $shop_photos->execute();
      $shop_photos = $shop_photos->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php if (count($shop_photos) > 0 || $for_count_photos > 0) { ?>

        <section class="shop-photo">
          <div class="shop-photo__inner--<?php echo $shop_photo_thema_type; ?>">
            <h2 class="shop-photo__title-main--<?php echo $shop_photo_thema_type; ?> title_style">S H O P&nbsp;&nbsp;P H O T O</h2>
            <h3 class="shop-photo__title-sub--<?php echo $shop_photo_thema_type; ?> sub_title_style">店内写真</h3>

            <?php
            switch ($shop_photo_thema_type):
              case 'pop':
            ?>
                <div class="swiper-container-shop-photo-wrap">
                  <div class="swiper-container-shop-photo">
                    <ul class="shop-photo__list--<?php echo $shop_photo_thema_type; ?> swiper-wrapper spotlight-group">
                      <?php
                      $count = 1;
                      foreach ($shop_photos as $photo) {
                        if (!empty($photo['image_url'])) {
                          $photo['image_url'] = str_replace('http://', 'https://', $photo['image_url']);
                      ?>
                          <li class="shop-photo__list-item--<?php echo $shop_photo_thema_type; ?> swiper-slide border_color">
                            <a class="spotlight" href="<?php echo $photo['image_url']; ?>">
                              <img src="<?php echo $photo['image_url']; ?>" alt="<?php echo $count; ?>番目の店内写真">
                            </a>
                          </li>
                      <?php
                        }
                        $count++;
                      }
                      ?>
                    </ul>
                  </div>
                  <div class="swiper-button-shop-photo-pop-prev schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108">
                      <path d="M21.236,0,0,18.554,21.236,37.108l.875-.765L1.752,18.554,22.112.766Z" transform="translate(0 0)" />
                    </svg></div>
                  <div class="swiper-button-shop-photo-pop-next schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108">
                      <path d="M.876,0,0,.766,20.36,18.554,0,36.344l.876.765L22.112,18.554Z" transform="translate(0 0)" />
                    </svg></div>
                </div> <!-- /swiper-container-shop-photo-wrap -->

                <script type="text/javascript">
                  var mySwiper = new Swiper('.swiper-container-shop-photo', {
                    effect: "slide",
                    fadeEffect: {
                      crossFade: true
                    },
                    slidesPerView: 3,
                    spaceBetween: 12,
                    loop: false,
                    navigation: {
                      nextEl: '.swiper-button-shop-photo-pop-next', //「次へ」ボタンの要素のセレクタ
                      prevEl: '.swiper-button-shop-photo-pop-prev', //「前へ」ボタンの要素のセレクタ
                    },
                  })
                </script>

                <?php break; ?>
              <?php
              case 'stylish': ?>
                <div class="swiper-container-shop-photo-wrap">
                  <div class="swiper-container-shop-photo">
                    <ul class="shop-photo__list--<?php echo $shop_photo_thema_type; ?> swiper-wrapper spotlight-group">
                      <?php
                      $count = 1;
                      foreach ($shop_photos as $photo) {
                        if (!empty($photo['image_url'])) {
                          $photo['image_url'] = str_replace('http://', 'https://', $photo['image_url']);
                      ?>
                          <li class="shop-photo__list-item--<?php echo $shop_photo_thema_type; ?> swiper-slide border_color">
                            <a class="spotlight" href="<?php echo $photo['image_url']; ?>">
                              <img src="<?php echo $photo['image_url']; ?>" alt="<?php echo $count; ?>番目の<?php echo $store_name; ?>のピックアップ店内写真">
                            </a>
                          </li>
                      <?php
                        }
                        $count++;
                      }
                      ?>
                    </ul>
                  </div>
                </div>
                <script type="text/javascript">
                  var w = $(window).width();
                  if (w <= 767.9) {
                    var mySwiper = new Swiper('.swiper-container-shop-photo', {
                      effect: "slide",
                      fadeEffect: {
                        crossFade: true
                      },
                      slidesPerView: 1.57,
                      spaceBetween: 12,
                      loop: false,
                    });
                  }
                </script>
                <?php break; ?>
              <?php
              case 'luxury': ?>
                <div class="swiper-container-shop-photo-wrap">
                  <div class="swiper-container-shop-photo">
                    <ul class="shop-photo__list--<?php echo $shop_photo_thema_type; ?> swiper-wrapper spotlight-group">
                      <?php
                      $count = 1;
                      foreach ($shop_photos as $photo) {
                        if (!empty($photo['image_url'])) {
                          $photo['image_url'] = str_replace('http://', 'https://', $photo['image_url']);
                      ?>
                          <li class="shop-photo__list-item--<?php echo $shop_photo_thema_type; ?> swiper-slide border_color">
                            <a class="spotlight" href="<?php echo $photo['image_url']; ?>">
                              <img src="<?php echo $photo['image_url']; ?>" alt="<?php echo $count; ?>番目の店内写真">
                            </a>
                          </li>
                      <?php
                        }
                        $count++;
                      }
                      ?>
                    </ul>
                  </div>
                </div> <!-- /swiper-container-shop-photo-wrap -->

                <script type="text/javascript">
                  var w = $(window).width();
                  if (w >= 768) {
                    var mySwiper = new Swiper('.swiper-container-shop-photo', {
                      effect: "slide",
                      fadeEffect: {
                        crossFade: true
                      },
                      slidesPerView: 2.9,
                      spaceBetween: 12,
                      loop: false,

                    });
                  }
                </script>

                <?php break; ?>
            <?php
            endswitch;
            ?>
            <?php if ($for_count_photos > 0) { ?>

              <a class="shop-photo__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('shop-photo'); ?>/"><span><?php echo $shop_photo_link_button_text; ?></span></a>

            <?php } ?>

          </div> <!-- /shop-photo__inner -->
        </section> <!-- /shop-photo -->

      <?php
      }
      ?>

       <!-- about -->
      <?php
      if ($about) {
      ?>
        <div class="about">
          <h2><?= nl2br($about_title); ?></h2>
          <p><?= nl2br($about); ?></p>
        </div>
      <?php } ?>

      <?php get_footer(); ?>

      <!-- 店内写真モーダルjsライブラリ -->
      <script src="<?php echo get_template_directory_uri(); ?>/js/spotlight/spotlight.bundle.js"></script>

      <div id="sns-modal-window">
        <div class="sns-modal-window__inner--<?php echo $modal_thema_type; ?>">
          <ul>
            <?php
            $time = (int)$shop['attendance_switching_time'];
            if ($time > 12) {
              $time = 24 - $time;
            } else {
              $time = -$time;
            }
            $date = Date("w", strtotime('+' . (0) . 'day' . ' +' . ($time) . 'hours'));

            $cnt = 1;
            $video_cnt = 1;
            $i =0;
            foreach($sns_list as $post){
              //SNS種類による出力切り分けの変数セット
              $account_url = '';
              $sns_name = '';
              $svg = '';
              $sns_type = $post[0]['sns_type'];
              //当日曜日の出勤有無
              $work = $post[0]['work_' . $date];
              // キャストと店舗の分岐
              $subject_name = $post[0]['subject_name'];
              $for_img_no = $i + 1;
              ?>
              <li class="position<?php echo sprintf("%02d", $cnt); ?>">
                <div class="top modal_top_block_bg_color">
                  <div class="wrap">
                    <div class="left">
                      <?php
                        switch ($subject_name) {
                          case 'cast':
                            $url = site_url('profile') . "/?cast=" . $post[0]['subject_id'];
                            break;
                          default:
                            $url = site_url();
                            break;
                        }
                      ?>
                      <a href="<?php echo $url; ?>">
                        <?php
                          if ($post[0]['thumbnail']) {
                            $post[0]['thumbnail'] = str_replace('http://', 'https://', $post[0]['thumbnail']);
                        ?>
                            <img src="<?php echo $post[0]['thumbnail']; ?>" alt="<?php echo $for_img_no; ?>番目のモーダル版' .$store_name. '所属のキャスト' .$post[0]['name']. 'のSNS写真" />
                        <?php
                          } else {
                        ?>
                            <img src="<?php echo wp_get_attachment_url($no_img); ?>" class="sns_modal_no_img" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                        <?php
                          }
                        ?>
                      </a>
                      <div class="content">
                        <h2 class="modal_top_block_text_color"><?php echo $post[0]['name']; ?></h2>
                        <h3 class="modal_top_block_text_color"><?php echo $post[0]['shop_name']; ?></h3>
                      </div> <!-- /content -->
                    </div> <!-- /left -->
                    <div class="right">
                      <?php
                        if ($subject_name == 'cast') {
                          if ($work) {
                            $text = "本日<br />出勤";
                            $coloring_class = "modal_today_attend_style";
                          } else {
                            $text = "要確認";
                            $coloring_class = "modal_today_attend_inversion_style";
                          }
                      ?>
                        <h5 class="<?php echo $coloring_class; ?>"><span><?php echo $text; ?></span></h5>
                      <?php
                        }

                        if($post[0]["sns_type"] == 0) {
                          $sns_name = 'Instagram';
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                          $account_url = $post[0]['instagram_account_url'];
                        } elseif($post[0]["sns_type"] == 1) {
                          $sns_name = 'YouTube';
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                          $account_url = $post[0]['youtube_account_url'];
                        } elseif($post[0]["sns_type"] == 2) {
                          $sns_name = 'Twitter';
                          $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                          $account_url = $post[0]['twitter_account_url'];
                        } elseif($post[0]["sns_type"] == 3) {
                          $sns_name = 'Tiktok';
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"/></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"/></g></svg>';
                          $account_url = $post[0]['tiktok_account_url'];
                        }
                      ?>
                      <a class="to_sns_link modal_sns_icon_bg_color" href="<?php echo $account_url; ?>" target="_blank">
                        <i class="<?php echo $sns_name; ?>-icon modal_sns_icon_color">
                          <?php echo $svg; ?>
                        </i>
                      </a>
                    </div> <!-- /right -->
                  </div> <!-- /wrap -->
                </div> <!-- /top -->
                <?php
                  if(count($post)>1) {
                    $content =  '<div class="swiper"><!-- Additional required wrapper --><div class="swiper-wrapper"><!-- Slides -->';
                    foreach($post as $item){
                      $content .='<div class="swiper-slide">';
                      if(is_null($item['video_url']) || $item['video_url'] == '') {
                        $content .= '<img src="'.$item['image_url'].'" alt="">';
                      } else {
                        $content .= '<video id="player_'.$video_cnt.'" playsinline controls muted loop><source src="'.$item['video_url'].'" type="video/mp4"></video>';
                        $video_cnt++;
                      }
                      $content .= '</div>';
                    }
                    $content .='</div><!-- If we need pagination --><div class="swiper-pagination"></div><!-- If we need navigation buttons --><div class="swiper-button-prev"></div><div class="swiper-button-next"></div><!-- If we need scrollbar --><div class="swiper-scrollbar"></div></div>';
                    echo $content;
                  } elseif($post[0]["sns_type"] == 3) {
                    echo '<video id="player_'.$cnt.'" playsinline controls muted loop><source src="'.$post[0]['video_url'].'" type="video/mp4"></video>';
                  } elseif($post[0]["sns_type"] == 1) {
                    echo '<iframe width="100%"src="'.$post[0]['original_video_url'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                  } elseif(count($post) == 1) {
                    if (is_null($post[0]['video_url']) || $post[0]['video_url'] == '') {
                      echo '<img src="'.$post[0]['image_url'].'" alt=""/>';
                    } else {
                      echo '<video id="player_'.$cnt.'" playsinline controls muted loop><source src="'.$post[0]['video_url'].'" type="video/mp4"></video>';
                    }
                  }
                ?> <!-- /modal-thumnail -->
                <p class="modal_top_block_text_color modal_top_block_bg_color"><?php echo $post[0]['description']; ?></p>
              </li>
            <?php
              $cnt++;
            }
            ?>
          </ul>
          <b><span>×</span><small>閉じる</small></b>
        </div> <!-- /sns-modal-window__inner -->
      </div> <!-- /sns-modal-window -->

  <?php if ($eyecatch_thema_type === '■モーション01--flash' || $eyecatch_thema_type === '■モーション02--blur' || $eyecatch_thema_type === '■モーション03--zoom-out') { ?>
  <?php for ($i = 1; $i <= 10; $i++) { ?>
    <input id="for_motion<?php echo $i; ?>" type="hidden" name="<?php echo wp_get_attachment_url(${"eyecatch_imgs_motion" . sprintf("%02d", $i)}); ?>">
  <?php } ?>

  <input id="thema_url" type="hidden" name="<?php echo get_template_directory_uri(); ?>">

  <!-- アイキャッチモーション -->
  <script type="text/javascript">
    $(function() {
      var images = [];
      for (var i = 1; i <= 10; i++) {
        var img = $("#for_motion" + i).attr('name');
        if (img) {
          images.push({ src: img });
        }
      }

      var thema_url = $("#thema_url").attr('name');
      thema_url += '/img/overlays/<?php global $overlay; echo $overlay; ?>.png'

      $('.eyecatch--motion').vegas({ //背景画像でスライドショーしたい場所の設定
        <?php if ($eyecatch_thema_type === '■モーション01--flash') { ?>
          slides: images,
          delay: 5000, //スライドまでの時間ををミリ秒単位で設定
          timer: false, //タイマーバーの表示/非表示を切り替え
          overlay: thema_url, //オーバーレイする画像の設定
          animation: 'random', //スライドのアニメーションを設定
          transition: 'flash2', //スライド間のエフェクトを設定
          shuffle: true, //シャッフル
          transitionDuration: 2000 //エフェクト時間をミリ秒単位で設定
        <?php } elseif ($eyecatch_thema_type === '■モーション02--blur') { ?>
          slides: images,
          delay: 5000,
          timer: false,
          overlay: thema_url,
          animation: 'kenburns',
          transition: 'blur',
          shuffle: true,
          transitionDuration: 2000
        <?php } elseif ($eyecatch_thema_type === '■モーション03--zoom-out') { ?>
          slides: images,
          delay: 5000,
          timer: false,
          overlay: thema_url,
          animation: 'kenburns',
          transition: 'zoomOut',
          shuffle: true,
          transitionDuration: 3500
        <?php } ?>
        });
    });
  </script>
<?php } ?>



      <!-- もっとみるボタン -->
      <script type="text/javascript">
        $(function() {
          $('.sns ul:not(ul:first-of-type)').css('display', 'none'); //一番上の要素以外を非表示
          $('.more').nextAll('.more').css('display', 'none'); //ボタンを非表示
          $('.more').on('click', function() {
            $(this).css('display', 'none');
            $(this).next('ul').slideDown('fast');
            $(this).nextAll('.more:first').css('display', 'flex');
          });
        });
      </script>
      <!-- モーダル -->
      <script type="text/javascript">
        //sns_modal
        $(function() {
          $('#sns-modal-window').on('touchstart', onTouchStart); //指が触れたか検知
          $('#sns-modal-window').on('touchmove', onTouchMove); //指が動いたか検知
          // $('#sns-modal-window').on('touchend', onTouchEnd); //指が離れたか検知
          var direction, position;
          //スワイプ開始時の横方向の座標を格納
          function onTouchStart(event) {
            position = getPosition(event);
            direction = ''; //一度リセットする
          }
          //スワイプの方向（left／right）を取得
          function onTouchMove(event) {
            if (position - getPosition(event) > 70) { // 70px以上移動しなければスワイプと判断しない
              direction = 'left'; //左と検知
            } else if (position - getPosition(event) < -70) { // 70px以上移動しなければスワイプと判断しない
              direction = 'right'; //右と検知
            }
          }

          //横方向の座標を取得
          function getPosition(event) {
            return event.originalEvent.touches[0].pageX;
          }
        });
        $('.sns ul li').on('click', function() {
          $('#sns-modal-window').addClass('show');
          $("body").css('overflow', 'hidden');
          var target = $(this).attr('class').split(" ")[0];
          target = "." + target;
          var pos01 = $("#sns-modal-window ul li" + target).position().top;
          $("#sns-modal-window div").scrollTop(pos01 + 20);
        });
        $('#sns-modal-window div b').on('click', function() {
          $('#sns-modal-window').removeClass('show');
          $("body").css('overflow', 'auto');
        });
        $('#sns-modal-window').on('click', function() {
          $('#sns-modal-window').removeClass('show');
          $("body").css('overflow', 'auto');
        });
        $('#sns-modal-window div').on('click', function(event) {
          event.stopPropagation();
        });
      </script>

      <script type="application/ld+json">
        [{
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "<?php echo $store_name; ?>",
            "description": "<?php echo $page_description; ?>",
            "url": "<?= site_url(); ?>/",
            "@id": "<?= site_url(); ?>/",
            "inLanguage": "ja",
            "author": {
              "@type": "Organization",
              "@id": "<?= site_url(); ?>/",
              "name": "<?php echo $store_name; ?>",
              "url": "<?= site_url(); ?>/",
              "image": "<?php echo wp_get_attachment_url($logo);  ?>"
            },
            "potentialAction": {
              "@type": "SearchAction",
              "target": "<?= site_url(); ?>/?s={search_term}",
              "query-input": "required name=search_term"
            }
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
            "itemListElement": [{
              "@type": "ListItem",
              "position": 1,
              "item": {
                "name": "TOP",
                "@id": "<?= site_url(); ?>/"
              }
            }]
          }
        ]
      </script>
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script>
  <?php for ($a = 1; $a <= 27; $a++) : ?>
            var player_<?php echo $a; ?> = new Plyr('#player_<?php echo $a; ?>');
  <?php endfor; ?>
</script>
<script>
  const snsSwiper = new Swiper(".swiper", {
    slidesPerView: 1,
    slidesPerGroup: 1,
    // ページネーションが必要なら追加
    pagination: {
      el: ".swiper-pagination"
    },
    // ナビボタンが必要なら追加
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    }
  });
</script>
<script>
  <?php for($i = 1; $i <= 30; $i++) :?>
    document.addEventListener('DOMContentLoaded', function() {
      var video_<?php echo $i;?> = document.getElementById('player_<?php echo $i;?>');
      if(video_{{$i}}) {
        var observer_<?php echo $i;?> = new IntersectionObserver(function(entries) {
          entries.forEach(entry => {
              if (entry.isIntersecting) {
                  video_<?php echo $i;?>.play().catch(error => {
                      console.log('再生エラー:', error);
                  });
                  video_<?php echo $i;?>.muted = "muted";
              } else {
                  video_<?php echo $i;?>.pause();
                  video_<?php echo $i;?>.muted = "muted";
              }
          });
        }, {
            threshold: 0.5 // 50% が見えたら再生・停止を切り替え
        });
        observer_<?php echo $i;?>.observe(video_<?php echo $i;?>);
      }
    });
  <?php endfor; ?>
</script>
