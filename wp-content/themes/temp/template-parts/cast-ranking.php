<!-- ランキング -->
<?php
    require(__DIR__ . '/../setting.php');
    $cast_ranking_sql = "
        SELECT 
            cast_rankings.*, 
            ranking_categories.category, 
            ranking_categories.title, 
            casts.name AS cast_name, 
            casts.post AS cast_post, 
            casts.performance AS cast_performance, 
            cast_images.image_url AS cast_image, 
            shops.name AS shop_name
        FROM 
            cast_rankings
        JOIN 
            ranking_categories 
            ON cast_rankings.ranking_category_id = ranking_categories.id
        JOIN 
            casts 
            ON cast_rankings.cast_id = casts.id
        LEFT JOIN 
            cast_images 
            ON casts.id = cast_images.cast_id 
            AND cast_images.subject_id = 1 
        JOIN 
            shops 
            ON cast_rankings.subject_id = shops.id
        WHERE 
            cast_rankings.subject_id = " . $shop_id . "
        AND 
            cast_rankings.subject_name = 'shop'
        ORDER BY 
            ranking_categories.priority ASC, 
            cast_rankings.rank ASC
    ";
    $cast_ranking_list = $pdo->prepare($cast_ranking_sql);
    $cast_ranking_list->execute();
    $cast_ranking_list = $cast_ranking_list->fetchAll(PDO::FETCH_ASSOC);

    $categories = array_unique(array_column($cast_ranking_list, 'category'));
    
    $sr_max_initial_display = 7; // 初期表示数
    $sr_increment_count = 4; // 追加表示数

    // to script.php
    $sr_num = array(
        'sr_max_initial_display' => $sr_max_initial_display,
        'sr_increment_count' => $sr_increment_count,
    );
    set_query_var('sr_num', $sr_num);
?>

    <?php if($cast_ranking_list && $change_content == "ranking") { ?>
    <section class="ranking">
        <div class="ranking__inner">
            <h2 class="title_style">O F F I C I A L&nbsp;&nbsp;R A N K I N G</h2>
            <h3 class="sub_title_style">オフィシャルランキング</h3>

            <div class="tab">
                <ul>
                    <?php 
                    $category_tabs = array_unique(array_column($cast_ranking_list, 'category'));
                    foreach ($category_tabs as $index => $category) { 
                        $first_rank = current(array_filter($cast_ranking_list, function($rank) use ($category) {
                            return $rank['category'] === $category;
                        }));
                        ?>
                        <li>
                            <a href="#" class="tab-link cast-tab-link" data-index="<?= $index; ?>" data-title="<?= htmlspecialchars($first_rank['title']); ?>">
                                <?= htmlspecialchars($category); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="rank_container">
                <h2 id="ranking-title" class="cast-ranking-title"><?= htmlspecialchars($cast_ranking_list[0]['title']); ?></h2>
                <?php foreach ($category_tabs as $index => $category) { ?>
                    <div class="rank_content tab-content cast-rank-content" data-index="<?= $index; ?>" style="display: none;">
                        <?php
                        $filtered_ranks = array_filter($cast_ranking_list, function($rank) use ($category) {
                            return $rank['category'] === $category;
                        });

                        $current_rank = 1;
                        $rank_counter = 0;
                        $sr_total_ranks = count($filtered_ranks);

                        foreach ($filtered_ranks as $rank) {
                            if ($rank_counter >= 15) {
                                break;
                            }

                            while ($current_rank < $rank['rank']) { 
                                if ($rank_counter >= 15) {
                                    break;
                                }
                                ?>
                                <div class="rank_item">
                                    <a href="#" class="no-link">
                                        <h4>No.<span><?= $current_rank; ?></span></h4>
                                        <img src="<?php echo wp_get_attachment_url( $no_img );  ?>" alt="画像未登録時の代替え画像の<?php echo $store_name; ?>のロゴバナー">
                                        <p class="cast_name">No Name</p>
                                    </a>
                                </div>
                                <?php 
                                $current_rank++;
                                $rank_counter++;
                            }
                            if ($rank_counter >= 15) {
                                break;
                            }

                            $sr_visible_class = ($rank_counter < $sr_max_initial_display) ? '' : 'hidden-rank';
                            ?>
                            <div class="rank_item <?= $sr_visible_class; ?>">
                                <a href="<?= site_url('profile');?>/?cast=<?php echo $rank['cast_id'];?>">
                                    <h4>No.<span><?= htmlspecialchars($rank['rank']); ?></span></h4>
                                    <img src="<?= htmlspecialchars($rank['cast_image']) ? htmlspecialchars($rank['cast_image']) : wp_get_attachment_url( $no_img ); ?>" alt="<?= htmlspecialchars($rank['cast_name']); ?>">
                                    <p class="post"><?= htmlspecialchars($rank['cast_post'] ? $rank['cast_post'] : ''); ?></p>
                                    <p class="cast_name"><?= htmlspecialchars($rank['cast_name']); ?></p>
                                </a>
                            </div>
                            <?php
                            $current_rank = $rank['rank'] + 1;
                            $rank_counter++;
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>

            <?php if($before_btn == "view") { ?>
                <a id="sr-view-more-btn" class="ranking__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="#"><span>view more</span></a>

                <?php if($after_btn == "ranking") { ?>
                    <a id="sr-after-btn" class="ranking__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('ranking'); ?>/"><span>ranking page</span></a>
                <?php } else { ?>
                    <a id="sr-after-btn" class="ranking__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('cast'); ?>/"><span>staff page</span></a>
                <?php } ?>
            <?php } else { ?>
                <a class="ranking__arcives-link--<?php echo $button_shape_thema_type; ?> button_style border_color" href="<?= site_url('cast'); ?>/"><span>staff page</span></a>
            <?php } ?>
        </div>
    </section>
<?php } ?>
