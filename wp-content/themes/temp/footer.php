<?php
global $staff_recruit_page_exsitance_flg;
global $calendar_page_exsitance_flg;
global $coupon_page_exsitance_flg;
global $course_menu_page_exsitance_flg;
global $contact_page_exsitance_flg;
global $no_img;
global $shop_id;
global $staff_recruit_url;
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
global $tel_icon_margin_top;
global $sp_tel_icon_margin_top;
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
global $group_sister_store_column_int;
global $sp_group_sister_store_column_int;
global $store_name;
global $page_top_button_color;
global $page_top_button_bg_color;
?>
<?php
require("setting.php");
?>
<style type="text/css">
  .footer_bg_color {
    background-color: <?php echo $footer_bg_color; ?>;
  }

  .footer_logo_width {
    width: <?php echo $footer_logo_width; ?>px;
  }

  .sp_footer_logo_width {
    width: <?php echo $sp_footer_logo_width; ?>px;
  }

  .footer_text_color {
    color: <?php echo $footer_text_color; ?>
  }

  .footer_nav_border_color {
    border-color: <?php echo $footer_nav_border_color; ?>
  }

  <?php
  switch ($tel_font) {
    case 'CenturyGothicPro-Regular':
      $tel_icon_margin_top = '6px';
      $sp_tel_icon_margin_top = '2px';
      break;
    case 'Ballinger-Regular':
      $tel_icon_margin_top = '2px';
      $sp_tel_icon_margin_top = '9px';
      break;
    case 'Baskerville-SSi-Regular':
      $tel_icon_margin_top = '6px';
      $sp_tel_icon_margin_top = '2px';
      break;
  }
  ?>@media only screen and (min-width: 768px) {
    .footer_tel_icon_style {
      fill: <?php echo $footer_tel_icon_color; ?>;
      background-color: <?php echo $footer_tel_icon_bg_color; ?>;
      margin-top: <?php echo $tel_icon_margin_top; ?>;
    }
  }

  @media only screen and (max-width: 767.9px) {
    .footer_tel_icon_style {
      fill: <?php echo $footer_tel_icon_color; ?>;
      background-color: <?php echo $footer_tel_icon_bg_color; ?>;
      margin-top: <?php echo $sp_tel_icon_margin_top; ?>;
    }
  }

  .footer_tel_text_style {
    font-family: "<?php echo $tel_font; ?>";
  }

  .footer_sns_icon_color {
    fill: <?php echo $footer_sns_icon_color; ?>;
  }

  .footer_sns_icon_bg_color {
    background-color: <?php echo $footer_sns_icon_bg_color; ?>;
  }

  @media only screen and (min-width: 768px) {
    div.group_store_list ul {
      width: <?php echo $group_sister_store_column_int; ?>px;
    }
  }

  @media only screen and (max-width: 767.9px) {
    div.group_store_list ul {
      width: <?php echo $sp_group_sister_store_column_int; ?>px;
    }
  }

  span#page_top {
    fill: <?php echo $page_top_button_color; ?>;
    background-color: <?php echo $page_top_button_bg_color; ?>;
  }
</style>

<section class="map">
  <div class="map__inner">
    <?php echo $map_iframe; ?>
  </div> <!-- /map__inner -->
</section> <!-- /map -->

</article> <!-- /article -->

</div> <!-- /container -->

<footer class="footer footer_bg_color">

  <div class="footer__inner--<?php echo $footer_thema_type; ?>">
    <?php if ($footer_thema_type == 'pop') : ?>
      <ul class="footer-nav__list--<?php echo $footer_thema_type; ?>  footer_nav_border_color" itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
        <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
          <a class="footer_text_color" itemprop="url" href="<?= site_url(); ?>/">
            トップ</a>
        </li>
        <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
          <a class="footer_text_color" itemprop="url" href="<?= site_url('news'); ?>/">
            最新ニュース</a>
        </li>
        <?php if ($shop['event_privacy'] == 1) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('calendar'); ?>/">
              カレンダー</a>
          </li>
        <?php endif ?>
        <?php if ($casts_count['count(id)'] > 0) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('cast'); ?>/">
              キャスト一覧</a>
          </li>
        <?php endif ?>
        <?php if ($for_count_photos) { ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('shop-photo'); ?>/">店内写真
            </a>
          </li>
        <?php } ?>
        <?php if ($course_menu_page_exsitance_flg) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('course-menu'); ?>/">コースメニュー
            </a>
          </li>
        <?php endif ?>
        <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
          <a class="footer_text_color" itemprop="url" href="<?= site_url('fee-system'); ?>/">料金システム
          </a>
        </li>
        <?php if ($shop['coupon_privacy'] == 1) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('coupon'); ?>/">クーポン
            </a>
          </li>
        <?php endif ?>
        <?php if ($shop['cast_recruit_privacy'] == 1) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('cast-recruit'); ?>/">キャスト求人情報
            </a>
          </li>
        <?php endif ?>
        <?php if ($shop['staff_recruit_privacy'] == 1) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <!-- 20221110 kanai-mod-s -->
            <a class="footer_text_color" itemprop="url" href="<?php echo $staff_recruit_url; ?>">スタッフ求人情報
            </a>
          </li>
        <?php endif ?>
        <?php if ($contact_page_exsitance_flg) : ?>
          <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
            <a class="footer_text_color" itemprop="url" href="<?= site_url('contact'); ?>/">お問合せ
            </a>
          </li>
        <?php endif ?>
        <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
          <a class="footer_text_color" itemprop="url" href="<?= site_url('privacy'); ?>/">個人情報保護方針
          </a>
        </li>
      </ul>
    <?php endif; ?>

    <!--PC用フッターロゴ-->
    <div class="footer__inner-logo--<?php echo $footer_thema_type; ?> footer_logo_width pc">
      <h2>
        <a href="<?= site_url(); ?>/">
          <img src="<?php echo wp_get_attachment_url($footer_logo);  ?>" alt="<?php echo $store_name;; ?>のフッターロゴ" />
        </a>
      </h2>
    </div> <!-- /footer__inner-logo -->
    <!--SP用フッターロゴ-->
    <div class="footer__inner-logo--<?php echo $footer_thema_type; ?> sp_footer_logo_width sp">
      <h2>
        <a href="<?= site_url(); ?>/">
          <img src="<?php echo wp_get_attachment_url($footer_logo);  ?>" alt="スマホ版<?php echo $store_name;; ?>のフッターロゴ" />
        </a>
      </h2>
    </div> <!-- /footer__inner-logo -->

    <div class="footer__inner-wrap--<?php echo $footer_thema_type; ?>">
      <div class="footer__tel--<?php echo $footer_thema_type; ?>">
        <!-- <a <?php //wp_reset_query();
            //if (is_page('staff-recruit') || is_page('cast-recruit')) { ?>onclick="return gtag_report_conversion('tel:<?php //echo $shop['phone_number']; ?>');" <?php //} ?> href="tel:<?php //echo $shop['phone_number']; ?>"> -->
        <a href="tel:<?= $shop['phone_number']; ?>">
          <div class="footer__tel-icon--<?php echo $footer_thema_type; ?> footer_tel_icon_style">
            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="20.068" height="29.857" viewBox="0 0 20.068 29.857">
              <defs>
                <clipPath id="a">
                  <rect width="20.068" height="29.857" />
                </clipPath>
              </defs>
              <g class="a">
                <path d="M15.375,10.192c-.58-.967-1.4-2.854-2.319-2.416L11.587,9.243s-1.431,1.334,1.227,2.4c0,0,.659.714-1.388,2.613-1.9,2.047-2.612,1.387-2.612,1.387-1.064-2.657-2.4-1.225-2.4-1.225L4.947,15.883C4.51,16.8,6.4,17.623,7.363,18.2c.9.538,2.672.2,5.359-2.29l.011.015.368-.368-.015-.011c2.488-2.685,2.828-4.461,2.29-5.358M16.4,0H3.67A3.67,3.67,0,0,0,0,3.67V26.186a3.67,3.67,0,0,0,3.67,3.671H16.4a3.671,3.671,0,0,0,3.671-3.671V3.67A3.671,3.671,0,0,0,16.4,0m1.375,22.044a1.992,1.992,0,0,1-1.99,1.99H4.285a1.992,1.992,0,0,1-1.99-1.99V4.682a1.992,1.992,0,0,1,1.99-1.99h11.5a1.992,1.992,0,0,1,1.99,1.99Z" />
              </g>
            </svg>
          </div> <!-- /footer__tel-icon -->
          <address class="footer_text_color footer_tel_text_style"><?php echo $shop['phone_number']; ?></address>
        </a>
      </div> <!-- /footer__tel -->
      <?php if ($footer_thema_type == 'pop') : ?>
        <ul class="footer__sns-list">
          <?php
          $svg_list = [
            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>',

            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>',

            '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>',

            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>'
          ];
          ?>
          <?php
          if (!empty($shop_sns_list['instagram_account_url'])) {
          ?>
            <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
              <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['instagram_account_url']; ?>" target="_blank">
                <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
                  <?php echo $svg_list[0]; ?>
                </i>
              </a>
            </li>
          <?php
          }
          if (!empty($shop_sns_list['youtube_account_url'])) {
          ?>
            <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
              <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['youtube_account_url']; ?>" target="_blank">
                <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
                  <?php echo $svg_list[1]; ?>
                </i>
              </a>
            </li>
          <?php
          }
          if (!empty($shop_sns_list['twitter_account_url'])) {
          ?>
            <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
              <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['twitter_account_url']; ?>" target="_blank">
                <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
                  <?php echo $svg_list[2]; ?>
                </i>
              </a>
            </li>
          <?php
          }
          if (!empty($shop_sns_list['tiktok_account_url'])) {
          ?>
            <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
              <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['tiktok_account_url']; ?>" target="_blank">
                <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
                  <?php echo $svg_list[3]; ?>
                </i>
              </a>
            </li>
          <?php
          }
          ?>
        </ul>
      <?php endif; ?>

      <address class="footer__location footer_text_color"><?php echo $shop['shop_address']; ?></address>

      <div class="footer__business-hours">
        <dl class="footer__business-hours-open-time">
          <dt class="footer_text_color">OPEN.</dt>
          <dd class="footer_text_color"><?php echo $shop['business_hours']; ?></dd>
        </dl>
        <dl class="footer__business-hours-store-holiday">
          <dt class="footer_text_color">CLOSE.</dt>
          <dd class="footer_text_color"><?php echo $shop['regular_holiday']; ?></dd>
        </dl>
      </div> <!-- /footer__business-hours -->

      <?php if ($footer_thema_type == 'stylish' || $footer_thema_type == 'luxury') : ?>


      <?php endif; ?>


      <?php
      switch ($footer_thema_type):
        case 'pop':
      ?>
    </div> <!-- /footer__inner-wrap -->

    <?php break; ?>
  <?php
        case 'stylish': ?>
  <?php
        case 'luxury': ?>
    <ul class="footer__sns-list">
      <?php
          $svg_list = [
            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="22" height="20" viewBox="0 0 22 20"><defs><clipPath id="a"><rect class="a" width="22" height="20"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="a" d="M14.179,20.037H5.857A5.865,5.865,0,0,1,0,14.179V5.857A5.864,5.864,0,0,1,5.857,0h8.322a5.864,5.864,0,0,1,5.857,5.857v8.322a5.865,5.865,0,0,1-5.857,5.858M5.857,1.868A3.994,3.994,0,0,0,1.868,5.857v8.322a3.993,3.993,0,0,0,3.989,3.989h8.322a3.993,3.993,0,0,0,3.989-3.989V5.857a3.994,3.994,0,0,0-3.989-3.989Zm9.515,1.558a1.249,1.249,0,1,0,1.249,1.249,1.249,1.249,0,0,0-1.249-1.249M10.019,15.2A5.179,5.179,0,1,1,15.2,10.019,5.184,5.184,0,0,1,10.019,15.2m0-8.49a3.311,3.311,0,1,0,3.31,3.312,3.316,3.316,0,0,0-3.31-3.312" transform="translate(0.952 -0.086)"></path></g></svg>',

            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="19.424" height="13.686" viewBox="0 0 19.424 13.686"><defs><clipPath id="a"></clipPath></defs><g class="a"><path class="b" d="M19.019,2.138A2.44,2.44,0,0,0,17.3.409C15.786,0,9.713,0,9.713,0S3.638,0,2.123.409A2.44,2.44,0,0,0,.405,2.138,25.626,25.626,0,0,0,0,6.843a25.638,25.638,0,0,0,.405,4.706,2.442,2.442,0,0,0,1.718,1.729c1.515.408,7.59.408,7.59.408s6.074,0,7.589-.408a2.442,2.442,0,0,0,1.718-1.729,25.638,25.638,0,0,0,.405-4.706,25.626,25.626,0,0,0-.405-4.705M7.726,9.731V3.955L12.8,6.843Z" transform="translate(0)"></path></g></svg>',

            '<svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="250 250 1500 1500" width="95%"><defs><clipPath id="a" /></defs><g class="a" transform="translate(0 0)"><path class="cls-1" d="M1479.3,1455.9l-375.6-545.7-42.5-61.7-268.7-390.4-22.3-32.4h-330.1l80.5,117,357.3,519.1,42.5,61.6,287.1,417.1,22.3,32.3h330.2l-80.7-116.9ZM1268.9,1498.2l-298.2-433.3-42.5-61.7-346-502.8h148.8l279.9,406.6,42.5,61.7,364.4,529.5h-148.9Z" transform="translate(0 0)" /><polygon class="cls-1" points="928.2 1003.2 970.7 1064.9 920.4 1123.5 534.1 1572.9 438.8 1572.9 877.9 1061.9 928.2 1003.2" /><polygon class="cls-1" points="1520.1 425.8 1103.7 910.2 1053.4 968.7 1010.9 907.1 1061.2 848.5 1343.3 520.2 1424.8 425.8 1520.1 425.8" /></g></svg>',

            '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="17.691" height="20.736" viewBox="0 0 17.691 20.736"><defs><style></style><clipPath id="a"><rect class="a" width="17.691" height="20.736"></rect></clipPath></defs><g class="b" transform="translate(0 0)"><path class="c" d="M12.806,0V.017c0,.316.094,4.88,4.883,5.164,0,4.246,0,0,0,3.526a8.39,8.39,0,0,1-4.89-1.73L12.8,13.841c.043,3.108-1.687,6.157-4.927,6.771a7.021,7.021,0,0,1-3.1-.109C-3.13,18.139-.5,6.418,7.431,7.673c0,3.784,0,0,0,3.784-3.278-.482-4.374,2.245-3.5,4.2a2.914,2.914,0,0,0,5.195-.345,6.617,6.617,0,0,0,.194-1.679V0Z" transform="translate(0 0)"></path></g></svg>'
          ];
      ?>
      <?php
          if (!empty($shop_sns_list['instagram_account_url'])) {
      ?>
        <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
          <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['instagram_account_url']; ?>" target="_blank">
            <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
              <?php echo $svg_list[0]; ?>
            </i>
          </a>
        </li>
      <?php
          }
          if (!empty($shop_sns_list['youtube_account_url'])) {
      ?>
        <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
          <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['youtube_account_url']; ?>" target="_blank">
            <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
              <?php echo $svg_list[1]; ?>
            </i>
          </a>
        </li>
      <?php
          }
          if (!empty($shop_sns_list['twitter_account_url'])) {
      ?>
        <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
          <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['twitter_account_url']; ?>" target="_blank">
            <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
              <?php echo $svg_list[2]; ?>
            </i>
          </a>
        </li>
      <?php
          }
          if (!empty($shop_sns_list['tiktok_account_url'])) {
      ?>
        <li class="footer__sns-list-item--<?php echo $footer_thema_type; ?>">
          <a class="footer__sns-list-item-link--<?php echo $footer_thema_type; ?> footer_sns_icon_bg_color" href="<?php echo $shop_sns_list['tiktok_account_url']; ?>" target="_blank">
            <i class="footer__sns-list-item-instagram-icon--<?php echo $footer_thema_type; ?> footer_sns_icon_color">
              <?php echo $svg_list[3]; ?>
            </i>
          </a>
        </li>
      <?php
          }
      ?>
    </ul>
  </div> <!-- /footer__inner-wrap -->

  <ul class="footer-nav__list--<?php echo $footer_thema_type; ?>  footer_nav_border_color" itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement">
    <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
      <a class="footer_text_color" itemprop="url" href="<?= site_url(); ?>/">
        トップ</a>
    </li>
    <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
      <a class="footer_text_color" itemprop="url" href="<?= site_url('news'); ?>/">
        最新ニュース</a>
    </li>
    <?php if ($shop['event_privacy'] == 1) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('calendar'); ?>/">
          カレンダー</a>
      </li>
    <?php endif ?>
    <?php if ($casts_count['count(id)'] > 0) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('cast'); ?>/">
          キャスト一覧</a>
      </li>
    <?php endif ?>
    <?php if ($for_count_photos) { ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('shop-photo'); ?>/">店内写真
        </a>
      </li>
    <?php } ?>
    <?php if ($course_menu_page_exsitance_flg) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('course-menu'); ?>/">コースメニュー
        </a>
      </li>
    <?php endif ?>
    <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
      <a class="footer_text_color" itemprop="url" href="<?= site_url('fee-system'); ?>/">料金システム
      </a>
    </li>
    <?php if ($shop['coupon_privacy'] == 1) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('coupon'); ?>/">クーポン
        </a>
      </li>
    <?php endif ?>
    <?php if ($shop['cast_recruit_privacy'] == 1) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('cast-recruit'); ?>/">キャスト求人情報
        </a>
      </li>
    <?php endif ?>
    <?php if ($shop['staff_recruit_privacy'] == 1) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?php echo $staff_recruit_url; ?>">スタッフ求人情報
        </a>
      </li>
    <?php endif ?>
    <?php if ($contact_page_exsitance_flg) : ?>
      <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
        <a class="footer_text_color" itemprop="url" href="<?= site_url('contact'); ?>/">お問合せ
        </a>
      </li>
    <?php endif ?>
    <li class="footer-nav__list-item--<?php echo $footer_thema_type; ?> footer_nav_border_color" itemprop="name">
      <a class="footer_text_color" itemprop="url" href="<?= site_url('privacy'); ?>/">個人情報保護方針
      </a>
    </li>
  </ul>

  <?php break; ?>
<?php endswitch; ?>

<!-- kanai-mod-s -->

<div class="group_store_list">

  <?php if ($group_ten_mother_logo || $group_ten_mother_url) : ?>
    <h3>
      <a href="<?php echo $group_ten_mother_url; ?>" target="_blank">
        <?php if ($group_ten_mother_logo) : ?>
          <!-- 20220923 kanai-mod-s -->
          <img src="<?php echo wp_get_attachment_url($group_ten_mother_logo); ?>" alt="<?php echo $store_name; ?>が所属するグループのロゴ" />
          <!-- 20220923 kanai-mod-e -->
        <?php else : ?>
          <!-- 20220923 kanai-mod-s -->
          <img src="<?php echo wp_get_attachment_url($no_img);  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
          <!-- 20220923 kanai-mod-e -->
        <?php endif; ?>
      </a>
    </h3>
  <?php endif; ?>

  <ul>

    <!-- 20220923 kanai-mod-s -->
    <?php
    $count = 1;
    foreach ($group_sister_store as $fields) {
      $imgurl = wp_get_attachment_image_src($fields['グループ姉妹店のロゴ'], 'full');
      $link_url = $fields['グループ姉妹店のURL'];
    ?>
      <?php if (!$imgurl && !$link_url) { ?>
        <!-- 画像もURLリンクもインサートがない場合は何も出力しない -->
      <?php } elseif (!$imgurl) { ?>
        <!-- 画像がない場合 -->
        <li>
          <a href="<?php echo $link_url; ?>" target="_blank">
            <img src="<?php echo wp_get_attachment_url($no_img); ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー" />
          </a>
        </li>
      <?php } else { ?>
        <!-- 画像がある場合通常表示 -->
        <li>
          <a href="<?php echo $link_url; ?>" target="_blank">
            <img src="<?php echo $imgurl[0]; ?>" alt="<?php echo $store_name; ?>の姉妹店ロゴ<?php echo $count; ?>">
          </a>
        </li>
      <?php
      }
      ?>
    <?php
      $count++;
    }
    ?>
    <!-- 20220923 kanai-mod-e -->

  </ul>

</div> <!-- /group_store_list -->

<!-- kanai-mod-e -->

<p><small class="footer_text_color">©<?php echo $shop['name']; ?></small></p>

</div> <!-- /footer__inner -->

</footer> <!-- /footer -->

</div> <!-- /wraper -->

<!-- s- 共通JS -->
<span id="page_top"><svg xmlns="https://www.w3.org/2000/svg" width="27.402" height="23.731" viewBox="0 0 27.402 23.731">
    <defs></defs>
    <path class="a" d="M13.7,0,0,23.73l13.7-5.791L27.4,23.73,13.7,0Z" transform="translate(0 0)" />
  </svg></span>
<script src="<?php echo get_template_directory_uri(); ?>/js/page-top.js"></script>

<script type="text/javascript">
  $(function() {
    var flg = 0;
    // var w = $(window).width();
    // if (w <= 767.9){
    //  $('.wraper').css('width', w + 'px');
    // }
    $('#sp-menu-btn').on('click', function(e) {
      if (flg == 0) {
        flg = 1;
        $('.main-nav').addClass('open');
        $('#sp-menu-btn').addClass('open');
        $('#drawer_gray_out').css('display', 'block');
        $('html').css('overflow', 'hidden');
      } else {
        flg = 0;
        $('.main-nav').removeClass('open');
        $('#sp-menu-btn').removeClass('open');
        $('#drawer_gray_out').css('display', 'none');
        $('html').css('overflow', 'auto');
      }
    });
    $('#drawer_gray_out').on('click', function() {
      $('#sp-menu-btn').click()
    });
  });
</script>
<!-- e- 共通JS -->

<?php wp_footer(); ?>

</body>

</html>
