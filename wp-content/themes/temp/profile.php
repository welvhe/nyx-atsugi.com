<?php
/*
Template Name:profile
*/ query_posts( 'post' );
require("setting.php");
$cast_id = getParamval('cast');
$cast_sql = "SELECT `name`,`work_0`,`work_1`,`work_2`,`work_3`,`work_4`,`work_5`,`work_6`,`time_start_0`,`time_start_1`,`time_start_2`,`time_start_3`,`time_start_4`,`time_start_5`,`time_start_6`,`time_end_0`,`time_end_1`,`time_end_2`,`time_end_3`,`time_end_4`,`time_end_5`,`time_end_6` FROM `casts` WHERE `id` = ".$cast_id;
$cast = $pdo->prepare($cast_sql);
$cast->execute();
$cast = $cast->fetch(PDO::FETCH_ASSOC);
$cast_name = $cast['name'];

$cast_images_sql = "SELECT `image_url`,`subject_id` FROM `cast_images` WHERE `cast_id` = ".$cast_id." AND `subject_id` != 2 AND `image_url` != '' ORDER BY `subject_id` ASC";
$images = $pdo->prepare($cast_images_sql);
$images->execute();
$images = $images->fetchAll(PDO::FETCH_ASSOC);

$sns_sql = "SELECT `main_sns`,`main_sns_set`,`instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url`,`main_sns` FROM `sns` WHERE `subject_id` = ".$cast_id." AND `subject_name` = 'cast' AND `main_sns_set` = 1 limit 1";
$sns = $pdo->prepare($sns_sql);
$sns->execute();
$sns = $sns->fetch(PDO::FETCH_ASSOC);

$questions_sql = "SELECT `answer`,`question` FROM `interviews` INNER JOIN `interview_answers` ON interviews.`id` = interview_answers.`interview_id` WHERE interview_answers.`cast_id` = ".$cast_id." AND interviews.`shop_id` = ".$shop_id." order by interviews.`priority` ASC";
$questions = $pdo->prepare($questions_sql);
$questions->execute();
$questions = $questions->fetchAll(PDO::FETCH_ASSOC);
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
<title>「<?php echo $cast_name;?>」の<?php echo $page_title; ?></title>
<meta name="description" content="<?php echo $page_description; ?>">
<link rel="canonical" href="<?= site_url('profile');?>?cast=<?php echo $cast_id; ?>">
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/admin_sp.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/profile_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/profile_sp.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/schedule-layout_sp.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sns-modal_pc.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/sns-modal_sp.css" />
<link rel="icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<link rel="shortcut icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<link rel="apple-touch-icon" href="<?php echo wp_get_attachment_url( $favicon_img ); ?>">
<!-- jquery読込 -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
<!-- スワイパー -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<!-- og関連 -->
<meta property="og:url" content="<?= site_url('profile');?>?cast=<?php echo $cast_id; ?>" />
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

  <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
</head>
<?php
// プロフィールページカスタムフィールドセット
  $profile_thema_type = scf::get('PROFILEのテーマタイプ');
  $sub_thumnail_list_thema_type = scf::get('サブサムネイルリストのテーマタイプ');
  $cast_name_text_color = scf::get('キャストの名前の文字色');
  $cast_detail_table_border_color = scf::get('キャスト詳細テーブルの枠線色');
  $cast_detail_table_inversion_color = scf::get('キャスト詳細テーブルの背景反転色');
  $cast_detail_table_TH_text_color = scf::get('プロフィールテーブルの行の左側のタイトルの文字色');
  $cast_detail_table_TH_bg_color = scf::get('プロフィールテーブルの行の左側のタイトルの背景色');
  $cast_detail_table_TD_text_color = scf::get('プロフィールテーブルの行の右側の内容の文字色');
  $cast_detail_table_TD_bg_color = scf::get('プロフィールテーブルの行の右側の内容の背景色');
?>

<?php get_template_part('common-styles'); ?>

<style type="text/css">
.cast_name_text_color {
  color: <?php echo $cast_name_text_color; ?>;
}
.cast_detail_table_border_color {
	border-color: <?php echo $cast_detail_table_border_color; ?>;
}
.cast_detail_table_inversion_color {
  background-color: <?php echo $cast_detail_table_inversion_color; ?>;
}
.cast_detail_table_TH_style {
  background-color: <?php echo $cast_detail_table_TH_bg_color; ?>;
}
.cast_detail_table_TH_style span {
  color: <?php echo $cast_detail_table_TH_text_color; ?>;
}
.cast_detail_table_TD_style {
  background-color: <?php echo $cast_detail_table_TD_bg_color; ?>;
}
.cast_detail_table_TD_style span {
  color: <?php echo $cast_detail_table_TD_text_color; ?>;
}
</style>

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
      <a itemprop="item" href="<?= site_url('profile');?>/?cast=<?php echo $cast_id; ?>">
        <span class="text_style" itemprop="name">「<?php echo $cast_name;?>」のプロフィール</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</div>

<div class="wraper">

  <div class="container">

    <article class="main">
      <section class="profile">
        <div class="profile__inner--<?php echo $schedule_thema_type; ?>">
          <div class="left">
            <div class="main-thumnail border_color">
              <?php
                $count_images = count($images);
              ?>
              <?php if ($count_images > 0): ?>
                <?php $images[0]['image_url'] = str_replace('http://', 'https://', $images[0]['image_url']); ?>
                <?php if ($images[0]['image_url'] && $images[0]['subject_id'] == 1) { ?>
                  <img src="<?php echo $images[0]['image_url'];?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast_name;?>」のメイン肖像写真" />
                <?php
                  } else {
                ?>
                  <img src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
                <?php
                  }
                ?>
              <?php else: ?>
                  <img src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
              <?php endif ?>
            </div> <!-- /main-thumnail -->
            <div class="sub-thumnail-wrap--<?php echo $sub_thumnail_list_thema_type; ?> swiper-container-profile">
              <ul class="swiper-wrapper  spotlight-group">
              <?php if ($count_images > 0): ?>
                <?php
                if ($images[0]['subject_id'] == 1) {
                  $j = 1;
                } else {
                  $j = 0;
                }
                ?>
                <?php
                  for($i = $j; $i < $count_images; $i++) {
                ?>
                <?php $images[$i]['image_url'] = str_replace('http://', 'https://', $images[$i]['image_url']); ?>
                <li class="swiper-slide border_color">
                  <div class="sub-thumnail">
                    <a class="spotlight" href="<?php echo $images[$i]['image_url'];?>">
                      <img src="<?php echo $images[$i]['image_url'];?>" alt="<?php echo $store_name; ?>所属キャストの「<?php echo $cast_name;?>」のサブ肖像写真<?php echo $i; ?>番目" />
                    </a>
                  </div> <!-- /sub-thumnail -->
                </li>
                <?php
                  }
                ?>
              <?php endif ?>
              </ul>
            </div> <!-- /sub-thumnail-wrap -->

        <?php
        switch ( $sub_thumnail_list_thema_type ):
            case 'pop':
        ?>
        <!-- スワイパー動かさない -->
        <?php break; ?>
        <?php case 'stylish': ?>
        <!-- スワイパー動かさない -->
        <?php break; ?>
        <?php case 'luxury': ?>
          <script type="text/javascript">
              var mySwiper = new Swiper ('.swiper-container-profile', {
              effect: "slide",
              fadeEffect: {
                crossFade: true
              },
              slidesPerView: 2.452,
              spaceBetween: 11,
              loop: false,
              breakpoints: {
                // 768px以上の場合
                768: {
                  slidesPerView: 3.591,
                  spaceBetween: 11,
                },
              }
              })
          </script>
        <?php break; ?>
        <?php endswitch; ?>

          </div> <!-- /left -->

          <div class="right">
            <h2 class="cast_name_text_color border_color"><?php echo $cast_name;?></h2>
            <div class="wrap">
              <ul class="profile__sns-list">
                <?php
                $text = "本日出勤";
                $instagram_account_url  = !empty($sns['instagram_account_url']) ? $sns['instagram_account_url'] : "";
                $youtube_account_url    = !empty($sns['youtube_account_url'])   ? $sns['youtube_account_url'] : "";
                $twitter_account_url    = !empty($sns['twitter_account_url'])   ? $sns['twitter_account_url'] : "";
                $tiktok_account_url     = !empty($sns['tiktok_account_url'])    ? $sns['tiktok_account_url'] : "";
                if($instagram_account_url != "") {
                ?>
                <li class="profile__sns-list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a class="profile__sns-list-item-link--<?php echo $schedule_thema_type; ?> sns_icon_bg_color" href="<?php echo $instagram_account_url; ?>" target="_blank">
                      <i class="profile__sns-list-item-instagram-icon--<?php echo $schedule_thema_type; ?> sns_icon_color">
                        <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"/></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"/></g></svg>
                      </i>
                    </a>
                </li>
                <?php
                }
                if($youtube_account_url != "") {
                ?>
                <li class="profile__sns-list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a class="profile__sns-list-item-link--<?php echo $schedule_thema_type; ?> sns_icon_bg_color" href="<?php echo $youtube_account_url; ?>" target="_blank">
                      <i class="profile__sns-list-item-youtube-icon--<?php echo $schedule_thema_type; ?> sns_icon_color">
                        <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"/></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"/></g></svg>
                      </i>
                    </a>
                </li>
                <?php
                }
                if($twitter_account_url != "") {
                ?>
                <li class="profile__sns-list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a class="profile__sns-list-item-link--<?php echo $schedule_thema_type; ?> sns_icon_bg_color" href="<?php echo $twitter_account_url; ?>" target="_blank">
                      <i class="profile__sns-list-item-twitter-icon--<?php echo $schedule_thema_type; ?> sns_icon_color">
                        <svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%">
                        <defs>
                            <clipPath id="a" />
                        </defs>
                        <g class="a" transform="translate(0 0)">
                            <path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" />
                            <polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" />
                            <polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" />
                        </g>
                    </svg>
                      </i>
                    </a>
                </li>
                <?php
                }
                if($tiktok_account_url != "") {
                ?>
                <li class="profile__sns-list-item--<?php echo $schedule_thema_type; ?> border_color">
                    <a class="profile__sns-list-item-link--<?php echo $schedule_thema_type; ?> sns_icon_bg_color" href="<?php echo $tiktok_account_url; ?>" target="_blank">
                      <i class="profile__sns-list-item-tiktok-icon--<?php echo $schedule_thema_type; ?> sns_icon_color">
                        <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"/></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"/></g></svg>
                      </i>
                    </a>
                </li>
                <?php
                }
                ?>
              </ul>
              <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>">
              <?php
              $time = (int)$shop['attendance_switching_time'];
              $w = Date("w",strtotime('+'.(0).'day'.' +'.($time).'hours'));
              switch($w) {
                case 0:
                    $work       = $cast['work_0'];
                    $time_start = $cast['time_start_0'];
                    $time_end   = $cast['time_end_0'];
                    break;
                case 1:
                    $work       = $cast['work_1'];
                    $time_start = $cast['time_start_1'];
                    $time_end   = $cast['time_end_1'];
                    break;
                case 2:
                    $work       = $cast['work_2'];
                    $time_start = $cast['time_start_2'];
                    $time_end   = $cast['time_end_2'];
                    break;
                case 3:
                    $work       = $cast['work_3'];
                    $time_start = $cast['time_start_3'];
                    $time_end   = $cast['time_end_3'];
                    break;
                case 4:
                    $work       = $cast['work_4'];
                    $time_start = $cast['time_start_4'];
                    $time_end   = $cast['time_end_4'];
                    break;
                case 5:
                    $work       = $cast['work_5'];
                    $time_start = $cast['time_start_5'];
                    $time_end   = $cast['time_end_5'];
                    break;
                case 6:
                    $work       = $cast['work_6'];
                    $time_start = $cast['time_start_6'];
                    $time_end   = $cast['time_end_6'];
                    break;
              }
              if(!$work) {
                $text = "要確認";
              }
              ?>
              <h5 class="in_the_store_today_style"><span><?php echo $text;?></span></h5>

              <?php if($time_start || $time_end) { ?>
                <?php if($text == "本日出勤") { ?>
                  <h6 class="working_hours_style"><span><?php echo substr($time_start,0,5). " - ". substr($time_end,0,5);?></span></h6>
                <?php } ?>
              <?php } ?>

              </div> <!-- /schedule__list-item-content-bottom -->
            </div> <!-- /wrap -->
            <table>
              <?php
              foreach($questions as $question) {
              ?>
                <?php if ($question['answer']): ?>
                <tr class="cast_detail_table_inversion_color">
                  <th class="cast_detail_table_border_color cast_detail_table_TH_style"><span class="text_style"><?php echo $question['question'];?></span></th>
                  <td class="cast_detail_table_border_color cast_detail_table_TD_style"><span class="text_style"><?php echo $question['answer'];?></span></td>
                </tr>
                <?php endif ?>
              <?php } ?>
            </table>
          </div> <!-- /right -->
          <a class="cast-page-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('cast');?>/">
            <span>back to cast list</span>
          </a>
        </div> <!-- /profile__inner -->
      </section> <!-- /profile -->

      <?php
        if ($sns !== false) {
          $main_sns = $sns['main_sns'];
        } else {
          $main_sns = null;
        }
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
        if (empty($main_sns)) { //何も表示させない
            $sns_type_conditions[] = "sns_posts.`sns_type` = -1";
        }

        $sns_type_condition = implode(" OR ", $sns_type_conditions);

        $sns_list_sql = "SELECT sns_posts.`id` AS `id`, sns.`instagram_account_url` AS `instagram_account_url`, sns.`youtube_account_url` AS `youtube_account_url`, sns.`twitter_account_url` AS `twitter_account_url`, sns.`tiktok_account_url` AS `tiktok_account_url`, sns_posts.`parent_id` AS `parent_id`, sns_posts.`priority` AS `priority`, sns_posts.`subject_id` AS `subject_id`, sns_posts.`subject_name` AS `subject_name`, sns_posts.`sns_type` AS `sns_type`,sns_posts.`guid` AS `guid`, sns_posts.`original_image_url` AS `original_image_url`, sns_posts.`original_video_url` AS `original_video_url`, sns_posts.`image_url` AS `image_url`, sns_posts.`video_url` AS `video_url`, sns_posts.`description` AS `description`, sns_posts.`published_at` AS `published_at`, shops.`id` AS `shop_id`, casts.`id` AS `cast_id` ,casts.`name` AS `name`, casts.`work_0` AS `work_0`,casts.`work_1` AS `work_1`,casts.`work_2` AS `work_2`,casts.`work_3` AS `work_3`,casts.`work_4` AS `work_4`, casts.`work_5` AS `work_5`, casts.`work_6` AS `work_6`, cast_images.`image_url` AS `thumbnail`, shops.`name` AS `shop_name`,sns.`main_sns` AS `main_sns` FROM `sns_posts` JOIN `sns` ON sns.`subject_id` = sns_posts.`subject_id` and sns.`subject_name` = sns_posts.`subject_name` JOIN `casts` ON casts.`id` = sns_posts.`subject_id` JOIN `shops` ON shops.`id` = casts.`shop_id` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`id` = ".$cast_id." AND sns.`cabaweb_privacy` = 1 AND ($sns_type_condition)  ORDER BY `published_at` DESC LIMIT 100";
        $sns_list = $pdo->prepare($sns_list_sql);
        $sns_list->execute();
        $sns_list = $sns_list->fetchAll(PDO::FETCH_ASSOC);

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
              #var_dump($post['id']);
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

            <ul class="sns__list--<?php echo $sns_thema_type; ?>">
            <?php
              $count = 1;
              foreach ($sns_list as $key => $value) {
              if($value[0]['image_url'] != "" || $value[0]['thumbnail']) {
                if ($count == 1) { // ループの初回だけ実行
                  if (strpos($main_sns, '0') !== false) {
                    $main_sns_account_url = $instagram_account_url;
                    $main_sns_name = 'Instagram';
                  } elseif (strpos($main_sns, '3') !== false) {
                    $main_sns_account_url = $tiktok_account_url;
                    $main_sns_name = 'TikTok';
                  } elseif (strpos($main_sns, '1') !== false) {
                    $main_sns_account_url = $youtube_account_url;
                    $main_sns_name = 'Youtube';
                  } elseif (strpos($main_sns, '2') !== false) {
                    $main_sns_account_url = $twitter_account_url;
                    $main_sns_name = 'X';
                  } else {
                    $main_sns_account_url = $instagram_account_url;
                    $main_sns_name = 'Instagram';
                  }
                }
                if ($count == 10) {
                  break;
                } // SNS記事を9件出力したらループ終了
            ?>
              <?php
              //SNS種類による出力切り分けの変数セット
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
              <li class="position<?php echo sprintf('%02d', $count); ?> sns__list-item--<?php echo $sns_thema_type; ?>  border_color" data-cast_id="<?php if($value[0]['cast_id']){ echo $value[0]['cast_id']; } else {echo '0';}?>" data-shop_id="<?php echo $value[0]['shop_id'];?>">
                <div class="sns__list-item-thumnail--<?php echo $sns_thema_type; ?>">
                  <?php
                    $value[0]['image_url'] = str_replace('http://', 'https://', $value[0]['image_url']);
                    $value[0]['thumbnail'] = str_replace('http://', 'https://', $value[0]['thumbnail']);
                  ?>
                  <img class="sns__list-item-thumnail-img--<?php echo $sns_thema_type; ?>" src="<?php if($value[0]['image_url']) { echo $value[0]['image_url']; } elseif($value[0]['thumbnail']) { echo $value[0]['thumbnail']; } else { echo $no_img; } ?>" alt="<?php echo $count; ?>番目のSNSサムネイル、'<?php echo $value[0]['shop_name']; ?>'<?php if($value[0]['subject_name'] == 'cast' ){ echo '所属のキャスト' . $value[0]['name'];}?>の<?php echo $sns_name; ?>投稿" />
                   <span class="sns__list-item-thumnail-snslink--<?php echo $sns_thema_type; ?> sns_icon_bg_color" href="">
                    <i class="sns__list-item-thumnail-<?php echo $sns_name; ?>-icon--<?php echo $sns_thema_type; ?> sns_icon_color">
                      <?php echo $svg; ?>
                    </i>
                  </span>
                </div> <!-- /sns__list-item-thumnail -->
              </li>
            <?php
                }
              $count++;
              } //end_foreach
            ?>
          </ul>
            <a class="sns__more-button--<?php echo $button_shape_thema_type; ?> button_style border_color more" href="<?php echo $main_sns_account_url; ?>" target="_blank"><span><?php echo $cast_name; ?>の<?php echo $main_sns_name; ?>を見る</span></a>
          </ul>
        </div> <!-- /sns__inner -->
      </section> <!-- /sns -->

      <?php
        }
      ?>

      <section class="schedule">
        <div class="schedule__inner--<?php echo $schedule_thema_type; ?>">
          <h2 class="schedule__title-main--<?php echo $schedule_thema_type; ?> title_style">O T H E R&nbsp;&nbsp;C A S T</h2>
          <h3 class="schedule__title-sub--<?php echo $schedule_thema_type; ?> sub_title_style">他の在籍キャスト</h3>

          <ul class="schedule__list--<?php echo $schedule_thema_type; ?>">
            <?php
              $text = "本日出勤";
              $time = (int)$shop['attendance_switching_time'];
              if($time <=12) {
                $time = -$time;
              }
              $casts_sql = "SELECT cast_images.`cast_id`,cast_images.`image_url`,casts.`name`,casts.`work_0`,casts.`work_1`,casts.`work_2`,casts.`work_3`,casts.`work_4`,casts.`work_5`,casts.`work_6`,casts.`time_start_0`,casts.`time_start_1`,casts.`time_start_2`,casts.`time_start_3`,casts.`time_start_4`,casts.`time_start_5`,casts.`time_start_6`,casts.`time_end_0`,casts.`time_end_1`,casts.`time_end_2`,casts.`time_end_3`,casts.`time_end_4`,casts.`time_end_5`,casts.`time_end_6` FROM `casts` JOIN `cast_images` ON casts.`id` = cast_images.`cast_id` WHERE cast_images.`subject_id` = 1 AND casts.`shop_id` = " . $shop_id . " AND casts.`cabaweb_privacy` = 1 ORDER BY casts.`priority` ASC";
              $casts = $pdo->prepare($casts_sql);
      	      $casts->execute();
      	      $casts = $casts->fetchAll(PDO::FETCH_ASSOC);
              $date = Date("w",strtotime('+'.(0).'day'.' +'.($time).'hours'));
              foreach($casts as $cast) {
                switch($date) {
                  case 0:
                      $work       = $cast['work_0'];
                      $time_start = $cast['time_start_0'];
                      $time_end   = $cast['time_end_0'];
                      break;
                  case 1:
                      $work       = $cast['work_1'];
                      $time_start = $cast['time_start_1'];
                      $time_end   = $cast['time_end_1'];
                      break;
                  case 2:
                      $work       = $cast['work_2'];
                      $time_start = $cast['time_start_2'];
                      $time_end   = $cast['time_end_2'];
                      break;
                  case 3:
                      $work       = $cast['work_3'];
                      $time_start = $cast['time_start_3'];
                      $time_end   = $cast['time_end_3'];
                      break;
                  case 4:
                      $work       = $cast['work_4'];
                      $time_start = $cast['time_start_4'];
                      $time_end   = $cast['time_end_4'];
                      break;
                  case 5:
                      $work       = $cast['work_5'];
                      $time_start = $cast['time_start_5'];
                      $time_end   = $cast['time_end_5'];
                      break;
                  case 6:
                      $work       = $cast['work_6'];
                      $time_start = $cast['time_start_6'];
                      $time_end   = $cast['time_end_6'];
                      break;
              }
              $sns_sql = "SELECT DISTINCT `main_sns`,`main_sns_set`,`instagram_account_url`,`youtube_account_url`,`twitter_account_url`,`tiktok_account_url` FROM `sns` WHERE `subject_name` = 'cast' AND subject_id = ".$cast['cast_id']." limit 1";
            		$sns = $pdo->prepare($sns_sql);
            		$sns->execute();
            		$sns = $sns->fetch();
                    $work = $cast['work_'.$date];
                    $time_start = $cast['time_start_'.$date];
                    $time_end = $cast['time_end_'.$date];
            ?>
            <li class="schedule__list-item--<?php echo $schedule_thema_type; ?> border_color">
              <a href="<?= site_url('profile');?>/?cast=<?php echo $cast['cast_id'];?>">
                <div class="schedule__list-item-thumnail--<?php echo $schedule_thema_type; ?>">
                <?php
                  if($cast['image_url'] != "") {
                    $cast['image_url'] = str_replace('http://', 'https://', $cast['image_url']);
                ?>
                  <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo $cast['image_url'];?>" alt="<?php echo $store_name; ?>所属キャストの<?php echo $cast['name'];?>の肖像写真" />
                <?php
                  } else {
                ?>
                  <img class="schedule__list-item-thumnail-img--<?php echo $schedule_thema_type; ?>" src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
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
                        case 0:
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>';
                          break;
                        case 1:
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>';
                          break;
                        case 2:
                          $svg = '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>';
                          break;
                        case 3:
                          $svg = '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>';
                          break;
                        default:
                          $svg = '';
                          break;
                      }
                      if($svg != '' && $sns['main_sns_set'] ) {
                        echo '<span class="schedule__list-item-thumnail-snslink--'.$schedule_thema_type.' sns_icon_bg_color"><i class="schedule__list-item-thumnail-tiktok-icon--'.$schedule_thema_type.' sns_icon_color">'.$svg.'</i></span>';
                      }
                      ?>
                </div> <!-- /schedule__list-item-thumnail -->
                <div class="schedule__list-item-content--<?php echo $schedule_thema_type; ?> schedule_cast_name_bg_color">
                  <h4 class="schedule__list-item-content-title--<?php echo $schedule_thema_type; ?> schedule_cast_name_text_color"><i><?php echo  $cast['name'];?></i></h4>
                <?php
                if($date != "") {
                ?>
                  <div class="schedule__list-item-content-bottom--<?php echo $schedule_thema_type; ?>">
                    <?php
                      if($work) {
                        $text = "本日出勤";
                      } else {
                        $text = "要確認";
                      }
                    ?>
                  </div> <!-- /schedule__list-item-content-bottom -->
                <?php
                }
                ?>
                </div> <!-- /news__list-item-content -->
              </a>
            </li>
            <?php
              }
            ?>
          </ul>
        </div> <!-- /schedule__inner -->
      </section> <!-- /schedule -->

  <?php get_footer(); ?>

  <div id="sns-modal-window">
   <div class="sns-modal-window__inner--<?php echo $modal_thema_type; ?>">
    <ul>
      <?php
        $time = (int)$shop['attendance_switching_time'];
        if($time > 12) {
            $time = 24 - $time;
        } else {
            $time = -$time;
        }
        $date = Date("w",strtotime('+'.(0).'day'.' +'.($time).'hours'));
        $cnt = 1;
        $video_cnt = 1;
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
                    $content .= '<video id="player_'.$video_cnt.'" playsinline controls  muted loop><source src="'.$item['video_url'].'" type="video/mp4"></video>';
                    $video_cnt++;
                  }
                  $content .= '</div>';
                }
                $content .='</div><!-- If we need pagination --><div class="swiper-pagination"></div><!-- If we need navigation buttons --><div class="swiper-button-prev"></div><div class="swiper-button-next"></div><!-- If we need scrollbar --><div class="swiper-scrollbar"></div></div>';
                echo $content;
              } elseif($post[0]["sns_type"] == 3) {
                echo '<video style="width: 100%;" id="player_'.$video_cnt.'" playsinline controls muted loop><source src="'.$post[0]['video_url'].'" type="video/mp4"></video>';
              $video_cnt++;
              } elseif($post[0]["sns_type"] == 1) {
              echo '<iframe width="100%"src="'.$post[0]['original_video_url'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
              } elseif(count($post) == 1) {
                if (is_null($post[0]['video_url']) || $post[0]['video_url'] == '') {
                  echo '<img src="'.$post[0]['image_url'].'" alt=""/>';
                } else {
                  echo '<video id="player_'.$video_cnt.'" playsinline controls muted loop><source src="'.$post[0]['video_url'].'" type="video/mp4"></video>';
                  $video_cnt++;
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

<!-- 写真モーダルjsライブラリ -->
<script src="<?php echo get_template_directory_uri(); ?>/js/spotlight/spotlight.bundle.js"></script>

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
    } else if (position - getPosition(event) < -70){  // 70px以上移動しなければスワイプと判断しない
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
  $("body").css('overflow','hidden');
  var target = $(this).attr('class').split(" ")[0];
    target = "." + target;
  var pos01 = $("#sns-modal-window ul li" + target).position().top;
      $("#sns-modal-window div").scrollTop(pos01 + 20);
});
$('#sns-modal-window div b').on('click', function() {
  $('#sns-modal-window').removeClass('show');
  $("body").css('overflow','auto');
});
$('#sns-modal-window').on('click', function() {
  $('#sns-modal-window').removeClass('show');
  $("body").css('overflow','auto');
});
$('#sns-modal-window div').on('click', function() {
  event.stopPropagation();
});
</script>

<script type="application/ld+json">
[
{
"@context": "https://schema.org",
"@type": "WebSite",
"mainEntityOfPage": {
"@type": "WebPage",
"@id": "<?= site_url('profile');?>/"
},
"inLanguage": "ja",
"author": {
 "@type": "Organization",
 "@id": "<?= site_url();?>/",
 "name": "<?php echo $store_name; ?>",
 "url": "<?= site_url();?>/",
 "image": "<?php echo wp_get_attachment_url( $logo );  ?>"
},
"headline": "キャスト一覧",
"description": "<?php echo $page_description; ?>"
},
{
"@context" : "https://schema.org",
"@type" : "Organization",
"name" : "<?php echo $store_name; ?>",
"url" : "<?= site_url();?>/",
"logo": "<?php echo wp_get_attachment_url( $logo );  ?>",
"contactPoint" : [
{ "@type" : "ContactPoint",
<?php echo $international_tel; ?>
"telephone" : "<?php echo $mono_international_tel; ?>",
"contactType" : "customer support"
} ],
//snsのURL出力
"sameAs" : [
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
"image": "<?php echo wp_get_attachment_url( $logo );  ?>",
"url": "<?= site_url();?>/",
"priceRange":"<?php echo $mono_priceRange; ?>",
"telephone": "<?php echo $international_tel; ?>",
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
"@context":"https://schema.org",
"@type":"BreadcrumbList",
"name":"パンくずリスト",
"itemListElement":[
{
"@type":"ListItem",
"position":1,
"item":{"name":"TOP","@id":"<?= site_url();?>/"}
},
{
"@type":"ListItem",
"position":2,
"item":{"name":"CAST","@id":"<?= site_url('profile');?>/"}
}
]
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
            threshold: 0.5// 50% が見えたら再生・停止を切り替え
        });
        observer_<?php echo $i;?>.observe(video_<?php echo $i;?>);
      }
    });
  <?php endfor; ?>
</script>
