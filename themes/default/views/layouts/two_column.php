<!-- ******************		HEADER START ****************************** -->
<?php $this->renderPartial('//layouts/header'); ?>
<!-- ******************		HEADER END ******************************** -->

    <!-- Begin page content -->
    <div class="row">
        <div class="col-lg-9">
            <?php echo $content; ?>
        </div>
        <div class="col-lg-3">
            <div class="bs-sidebar affix">
                <?php
                $this->beginClip('navigation_menu_right_top');
                $this->renderPartial('//layouts/navigation_menu_right_top');
                $this->endClip();
                $this->renderClip('navigation_menu_right_top');
                ?>
            </div>
            <div class="bs-sidebar affix">
                <?php
                $this->beginClip('navigation_menu_right_middle');
                $this->renderPartial('//layouts/navigation_menu_right_middle');
                $this->endClip();
                $this->renderClip('navigation_menu_right_middle');
                ?>
            </div>
        </div>
    </div>

<!-- ******************		FOOTER START ****************************** -->
<?php $this->renderPartial('//layouts/footer'); ?>
<!-- ******************		FOOTER END ******************************** -->