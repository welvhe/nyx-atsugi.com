<!-- コンセプト -->
<?php
    $concept_img = SCF::get('コンセプト画像', 34);
    $concept_title = scf::get('コンセプトタイトル', 34);
    $concept_detail = scf::get('コンセプト詳細', 34);
    if($concept_img || $concept_title || $concept_detail) {
?>
    <section class="concept">
        <div class="concept__inner <?php $concept_order = scf::get('コンセプト配置');
                                    echo $concept_order; ?>">

            <?php if($concept_img) { ?>
                <img src="<?php
                    echo wp_get_attachment_url($concept_img) ?>" alt onerror = "this.onerror = null; this.src ='';" />
            <?php } ?>

            <?php if($concept_title || $concept_detail) { ?>
            <div class="concept_text">
                <?php if($concept_title) { ?>
                    <p class="title_style"><?= $concept_title; ?></p>
                <?php } ?>
                <?php if($concept_detail) { ?>
                    <p class="detail_style"><?= nl2br($concept_detail); ?></p>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>
