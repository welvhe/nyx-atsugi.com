<?php
/*
Template Name:cast
*/ query_posts( 'post' );
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
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
  $page_title = scf::get('ページタイトル');
  $page_description = scf::get('ページ説明文');
?>
<title><?php echo $page_title; ?></title>
<meta name="description" content="<?php echo $page_description; ?>">
<?php $date = getParamval('date'); ?>
<link rel="canonical" href="<?= site_url('cast');?>/?date=<?php echo $date; ?>">
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_sp.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/cast_sp.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_sp.css" />
<link rel="icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<link rel="shortcut icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<link rel="apple-touch-icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<!-- jquery読込 -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
<!-- スワイパー -->
<script src="<?php echo get_template_directory_uri(); ?>/js/swiper/swiper.min.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/swiper/swiper.min.css" />
<!-- og関連 -->
<meta property="og:url" content="<?= site_url('cast');?>/?date=<?php echo $date; ?>" />
<meta property="og:type" content="website" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $page_title; ?>" />
<meta property="og:description" content="<?php echo $page_description; ?>" />
<meta property="og:site_name" content="<?php echo $store_name; ?>のWebサイト" />
<meta property="og:image" content="<?php echo wp_get_attachment_url( $ogp_img ); ?>" />

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
</head>

<?php get_template_part('common-styles'); ?>

<?php get_header(); ?>

<div id="breadcrumbs">
  <ol itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?= site_url();?>/">
        <span class="text_style" itemprop="name">TOP</span></a>
      <meta itemprop="position" content="1" />
    </li>
    <li itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?= site_url('cast');?>/">
        <span class="text_style" itemprop="name">CAST</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</div>

<div class="wraper">

  <div class="container">

    <article class="main">

      <section class="schedule">
        <div class="schedule__inner--<?php echo $schedule_thema_type; ?>">
          <h2 class="schedule__title-main--<?php echo $schedule_thema_type; ?> title_style">C A S T</h2>
          <h3 class="schedule__title-sub--<?php echo $schedule_thema_type; ?> sub_title_style">キャスト一覧</h3>

          <div class="schedule__period-wrap--<?php echo $schedule_period_thema_type; ?>">
            <div class="swiper-container-schedule--<?php echo $schedule_period_thema_type; ?>">

              <?php if ($schedule_exsitance_flg): ?>

              <ul class="schedule__period-list--<?php echo $schedule_period_thema_type; ?> swiper-wrapper">
                <?php
                  $time = (int)$shop['attendance_switching_time'];
                  if($time > 12) {
                    $time = 24 - $time;
                  } else {
                    $time = -$time;
                  }
                  $date  = getParamval('date');
                  if(getParamval('date') == "") {
                    $date = "";
                    $style = 'schedule_selector_active_style';
                  }
                ?>
                <li class="schedule__period-list-item--<?php echo $schedule_period_thema_type; ?> border_color swiper-slide schedule_period_style <?php echo $style;?>">
                  <a class="schedule_period_text_color" href="<?= site_url('cast');?>/">
                    <span>在籍<br />一覧</span>
                  </a>
                </li>
                <?php
                  for($i = 0; $i < 7; $i++) {
                    $week = [
                      '日', //0
                      '月', //1
                      '火', //2
                      '水', //3
                      '木', //4
                      '金', //5
                      '土', //6
                    ];
                    $d = Date("m/d",strtotime('+'.($i).'day'.' +'.($time).'hours'));
                    $w = Date("w",strtotime('+'.($i).'day'.' +'.($time).'hours'));
                    $style = '';
                    if($date == $w) {
                      $target = $date;
                      $style = 'schedule_selector_active_style';
                    }
                ?>
                  <li class="schedule__period-list-item--<?php echo $schedule_period_thema_type; ?> border_color swiper-slide schedule_period_style <?php echo $style;?>">
                    <a class="schedule_period_text_color" href="<?= site_url('cast');?>/?date=<?php echo $w;?>">
                      <span><?php echo $d;?><br />（<?php echo $week[$w];?>）</span>
                    </a>
                  </li>
                <?php
                  }
                ?>
              </ul>
            </div> <!-- /swiper-container-schedule -->

            <?php
            switch ( $schedule_period_thema_type ):
              case 'pop':
            ?>
              <div class="swiper-button-schedul-pop-prev schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108"><path d="M21.236,0,0,18.554,21.236,37.108l.875-.765L1.752,18.554,22.112.766Z" transform="translate(0 0)"/></svg></div>
              <div class="swiper-button-schedul-pop-next schedule_period_arrow_color"><svg xmlns="https://www.w3.org/2000/svg" width="22.112" height="37.108" viewBox="0 0 22.112 37.108"><path d="M.876,0,0,.766,20.36,18.554,0,36.344l.876.765L22.112,18.554Z" transform="translate(0 0)"/></svg></div>

            <script type="text/javascript">
              var mySwiper = new Swiper ('.swiper-container-schedule--pop', {
              effect: "slide",
              fadeEffect: {
                crossFade: true
              },
              slidesPerView: 4.04,
              spaceBetween: 7,
              loop: false,
              navigation: {
                nextEl: '.swiper-button-schedul-pop-next',  //「次へ」ボタンの要素のセレクタ
                prevEl: '.swiper-button-schedul-pop-prev',  //「前へ」ボタンの要素のセレクタ
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

            <?php case 'stylish': ?>
              <!-- 何も出さない -->
            <?php break; ?>

            <?php case 'luxury': ?>

            <script type="text/javascript">
              var w = $(window).width();
              if(w <= 767.9){
                var mySwiper = new Swiper ('.swiper-container-schedule--luxury', {
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

            <?php break; ?>

            <?php endswitch; ?>

          </div> <!-- /schedule__period-wrap -->

          <ul class="schedule__list--<?php echo $schedule_thema_type; ?>">
            <?php
              $param = getParamval('date');
              #$date = Date("w",strtotime('+'.($param).'day '.' +'.($time).'hours'));
              if($param == "") {
                $casts_sql = "SELECT cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`shop_id` = ".$shop_id." AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC";
              } else {
                $casts_sql = "SELECT cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`work_".$param."` = 1 AND casts.`shop_id` = ".$shop_id." AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC";
              }
              $trial_sql = "SELECT `trial_0`,`trial_1`,`trial_2`,`trial_3`,`trial_4`,`trial_5`,`trial_6` FROM `trial_schedules` WHERE `shop_id` = " . $shop_id;
              $trial = $pdo->prepare($trial_sql);
              $trial->execute();
              $trial = $trial->fetch(PDO::FETCH_ASSOC);

              $casts = $pdo->prepare($casts_sql);
              $casts->execute();
              $casts = $casts->fetchAll(PDO::FETCH_ASSOC);
              foreach($casts as $cast) {
                $text = "本日出勤";
                if(getParamval('date') <> "all" && getParamval('date') <> "") {
                  $text = "出勤時間";
                }
                $sns_sql = "SELECT DISTINCT `main_sns`,`main_sns_set`,`instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url` FROM `sns` WHERE `subject_name` = 'cast' AND subject_id = ".$cast['cast_id']." limit 1";
                $sns = $pdo->prepare($sns_sql);
                $sns->execute();
                $sns = $sns->fetch();
                $work = isset($cast['work_' . $date]) ? $cast['work_' . $date] : null;
                $time_start = isset($cast['time_start_' . $date]) ? $cast['time_start_' . $date] : null;
                $time_end = isset($cast['time_end_' . $date]) ? $cast['time_end_' . $date] : null;
            ?>
            <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color" itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
              <a href="<?= site_url('profile');?>/?cast=<?php echo $cast['cast_id'];?>" itemprop="url">
                <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                  <?php
                    if($cast['image_url'] != "") {
                      $cast['image_url'] = str_replace('http://', 'https://', $cast['image_url']);
                  ?>
                    <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo $cast['image_url'];?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast['name'];?>」の肖像写真" itemprop="thumbnailUrl" />
                    <meta itemprop="url" content="<?php echo $cast['image_url'];?>">
                  <?php
                    } else {
                  ?>
                    <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" itemprop="thumbnailUrl" />
                    <meta itemprop="url" content="<?php echo wp_get_attachment_url( $no_img );  ?>">
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
                      case 0: //instagram
                        $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                        break;
                      case 1: //youtube
                        $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                        break;
                      case 2: //X
                        $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                        break;
                      case 3: //tiktok
                        $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                        break;
                      default:
                        $svg = '';
                        break;
                    }
                    if(!empty($svg) && $sns['main_sns_set']) {
                      echo '<span class="schedule__list-item-thumnail-snslink--'.$schedule_thema_type.' sns_icon_bg_color"><i class="schedule__list-item-thumnail-tiktok-icon--'.$schedule_thema_type.' sns_icon_color">'.$svg.'</i></span>';
                    }
                  ?>
                </div> <!-- /schedule__list-item-thumnail -->
                <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                  <h4 class="entry-title schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color" itemprop="name headline"><i><?php echo $cast['name'];?></i></h4>
                  <?php
                    if($date != "" && $shop['time_schedule_function'] == 1) {
                  ?>
                    <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>" itemprop="articleBody">
                      <?php
                        if($work) {
                          // $text = "本日出勤";
                        } else {
                          $text = "要確認";
                        }
                      ?>
                      <?php if(!isset($_GET['date']) || (isset($_GET['date']) && $time_start || $time_end)) { ?>
                        <h5 class="in_the_store_today_style"><span><?php echo $text;?></span></h5>
                      <?php } ?>
                      <?php if (isset($_GET['date']) && ($time_start || $time_end)) { ?>
                        <h6 class="working_hours_style"><span><?php echo substr($time_start,0,5). " - ". substr($time_end,0,5);?></span></h6>
                      <?php } ?>
                    </div> <!-- /schedule__list-item-content-bottom -->
                  <?php
                    }
                  ?>
                </div> <!-- /schedule__list-item-content -->
              </a>
            </li>
            <?php
              }
              $w = Date("w",strtotime('+'.(0).'day'.' +'.($time).'hours'));
              if($param != "") {
                $w = Date("w",strtotime('+'.($param - $w).'day'.' +'.($time).'hours'));
              }
              $number = $trial['trial_'.$w];
              for($i = 1; $i <= $number; $i++) {
            ?>
              <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
                <a tabindex="-1">
                  <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                    <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                  </div> <!-- /schedule__list-item-thumnail -->
                  <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                    <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i>体験入店<?php echo $i;?></i></h4>
                    <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>">
                      <!-- <h5 class="in_the_store_today_style"><span><?php echo $text;?></span></h5>
                      <h6 class="working_hours_style"><span></span></h6> -->
                    </div> <!-- /schedule__list-item-content-bottom -->
                  </div> <!-- /news__list-item-content -->
                </a>
              </li>
            <?php
              }
            ?>
          </ul>

          <!-- スケジュールブロックなしはキャスト一覧表示 -->
          <?php else: ?>
            <ul class="schedule__list--<?php echo $schedule_thema_type; ?>">
              <?php
                $casts_regular_sql          = "SELECT * FROM casts JOIN cast_images ON casts.id = cast_images.cast_id WHERE cast_images.subject_id = 1 AND casts.shop_id = ".$shop_id." AND casts.cabaweb_privacy = 1 ORDER BY casts.priority ASC";
                $casts_regular              = $pdo->prepare($casts_regular_sql);
                $casts_regular->execute();
                foreach($casts_regular as $cast) {
                  $sns_sql = "SELECT DISTINCT * FROM sns WHERE subject_name = 'cast' AND subject_id = ".$cast['cast_id']." limit 1";
                  $sns  = $pdo->prepare($sns_sql);
                  $sns->execute();
                  $sns = $sns->fetch();
              ?>
                  <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a href="<?= site_url('profile');?>/?cast=<?php echo $cast['cast_id'];?>">
                      <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                        <?php
                          if($cast['image_url'] != "") {
                            $cast['image_url'] = str_replace('http://', 'https://', $cast['image_url']);
                        ?>
                            <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo $cast['image_url'];?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast['name'];?>」の肖像写真" />
                        <?php
                          } else {
                        ?>
                            <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                        <?php
                          }

                            // $main_sns = $sns['main_sns'];
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
                              case 0: //instagram
                                $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                                break;
                              case 1://youtube
                                $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                                break;
                              case 2: //X
                                $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                                break;
                              case 3: //tiktok
                                $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                                break;
                              default:
                                $svg = '';
                                break;
                            }
                          if($svg != '' && $sns['main_sns_set']) {
                            echo '<span class="schedule__list-item-thumnail-snslink--'.$schedule_thema_type.' sns_icon_bg_color"><i class="schedule__list-item-thumnail-tiktok-icon--'.$schedule_thema_type.' sns_icon_color">'.$svg.'</i></span>';
                          }
                        ?>
                      </div> <!-- /schedule__list-item-thumnail -->
                      <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                        <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i><?php echo $cast['name'];?></i></h4>
                      </div> <!-- /news__list-item-content -->
                    </a>
                  </li>
              <?php
                }
              ?>
            </ul>
          <?php endif ?>
        </div> <!-- /schedule__inner -->
      </section> <!-- /schedule -->
    </article>
  </div>
</div>

<?php get_footer(); ?>

<script type="application/ld+json">
  [
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?= site_url('cast'); ?>/"
      },
      "inLanguage": "ja",
      "author": {
        "@type": "Organization",
        "@id": "<?= site_url(); ?>/",
        "name": "<?php echo $store_name; ?>",
        "url": "<?= site_url(); ?>/",
        "image": "<?php echo wp_get_attachment_url($logo); ?>"
      },
      "headline": "キャスト一覧",
      "description": "<?php echo $page_description; ?>"
    },
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?php echo $store_name; ?>",
      "url": "<?= site_url(); ?>/",
      "logo": "<?php echo wp_get_attachment_url($logo); ?>",
      "contactPoint": [
        {
          "@type": "ContactPoint",
          "telephone": "<?php echo $mono_international_tel; ?>",
          "contactType": "customer support"
        }
      ],
      "sameAs": [
        <?php
        $sns_urls = [];
        if ($mono_sns01) {
          $sns_urls[] = '"' . $mono_sns01 . '"';
        }
        if ($mono_sns02) {
          $sns_urls[] = '"' . $mono_sns02 . '"';
        }
        if ($mono_sns03) {
          $sns_urls[] = '"' . $mono_sns03 . '"';
        }
        if ($mono_sns04) {
          $sns_urls[] = '"' . $mono_sns04 . '"';
        }
        if ($mono_sns05) {
          $sns_urls[] = '"' . $mono_sns05 . '"';
        }
        echo implode(",\n", $sns_urls);
        ?>
      ]
    },
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?php echo $store_name; ?>",
      "image": "<?php echo wp_get_attachment_url($logo); ?>",
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
      "itemListElement": [
        {
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
            "name": "CAST",
            "@id": "<?= site_url('cast'); ?>/"
          }
        }
      ]
    }
  ]
</script>
