<?php
$this->Package->assign('view', 'js', array(
    'app.pages.projects'
));
$this->Package->assign('view', 'css', array(
    'view.pages.project'
));

// Page properties
$this->assign('title', __('page-title',  $project['Project']['name'], $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'project');
?>

<section class="section-project">
    <div class="container">
        <!-- row video -->
        <div class="row row-video">
            <div class="col-12">
                <div class="main-media">
                    <?php
                    $project['MediaCover']['url'] = sprintf(
                        '/files/media/image/index_%s.%s',
                        $project['MediaCover']['key'],
                        $project['MediaCover']['format']
                    );

                    $videoSrc = sprintf(
                        '/files/media/video/file_%s.%s',
                        $project['MediaCover']['key'],
                        $project['MediaCover']['format']
                    );
                    ?>
                    <?php if ($project['MediaCover']['format'] != 'mp4') : ?>
                        <img class="img-fluid w-100 media" src="<?= $project['MediaCover']['url'] ?>" alt="<?= $project['MediaCover']['alt'] ?>">
                    <?php else : ?>
                        <?php
                        $coverPoster = '';
                        if (!empty($project['MediaCover']['poster_key'])) {
                            $coverPoster = '/files/media/image/poster_' . $project['MediaCover']['poster_key'] . '.' . $project['MediaCover']['poster_format'];
                        }
                        ?>
                        <video class="img-fluid w-100 media" src="<?= $videoSrc ?>" controls<?= !empty($coverPoster) ? ' poster="' . $coverPoster . '"' : '' ?>></video>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- row information -->
        <div class="row row-information  justify-content-lg-center" data-aos="fade-up" data-aos-duration="1000" >
            <div class="col-lg-10 col-info">
                <div class="name-company text-lg-center">
                    <?= $project['Project']['company'] ?>
                </div>
                <div class="title-project text-lg-center">
                    <?= $project['Project']['name'] ?>
                </div>
                <?php if ($project['Project']['url']) : ?>
                    <a href="<?= $project['Project']['url'] ?>" class="text-green small url-project text-lg-center d-block" target='_blank'>
                        <small><small><strong>Ir a página del proyecto &raquo;</strong></small></small>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-description col-lg-10">
                <div class="description">
                    <?= $project['Project']['description'] ?>
                </div>
            </div>
        </div>

        <!-- row gallery -->
        <div class="row row-gallery">
            <div class="col-lg-1 col-scroll">
                <div class="scroll">
                    <div class="container-icons">
                        <div class="star"></div>
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-11 col-gallery">
               
                <?php foreach ($project['MediaGallery'] as $key => $image) : ?>
                    <?php
                    $project['MediaGallery'][$key]['source'] = sprintf(
                        '/files/media/image/index_%s.%s',
                        $project['MediaGallery'][$key]['key'],
                        $project['MediaGallery'][$key]['format']
                    );
                    $videoSrc = sprintf(
                        '/files/media/video/file_%s.%s',
                        $project['MediaGallery'][$key]['key'],
                        $project['MediaGallery'][$key]['format']
                    );
                    $classMargin = ($key == 1) ? 'card-margin' : '';
                    ?>
                    <!-- validate mp4 -->
                    <?php if ($project['MediaGallery'][$key]['format'] != 'mp4') : ?>
                        <?php
                        echo $this->Html->image(
                            $project['MediaGallery'][$key]['source'],
                            [
                                'class' => 'img-fluid w-100 media-gallery' . ' ' . $classMargin,
                                'alt' =>   $project['MediaGallery'][$key]['alt'],
                                'data-aos' => 'fade-up',
                                'data-aos-duration' => '1000'

                            ]
                        );
                        ?>
                    <?php else : ?>
                        <?php
                        $galleryPoster = '';
                        if (!empty($project['MediaGallery'][$key]['poster_key'])) {
                            $galleryPoster = '/files/media/image/poster_' . $project['MediaGallery'][$key]['poster_key'] . '.' . $project['MediaGallery'][$key]['poster_format'];
                        }
                        ?>
                        <video data-aos="fade-up" data-aos-duration="1000" class="img-fluid w-100 media-gallery <?= $classMargin ?>" src="<?= $videoSrc ?>" controls<?= !empty($galleryPoster) ? ' poster="' . $galleryPoster . '"' : '' ?>></video>
                    <?php endif; ?>

                <?php endforeach; ?>

               
            </div>


        </div>
        
        <!-- row final text -->
        <?php if (!empty($project['Project']['final_text'])) { ?>
           <div class="row final-text" data-aos="fade-up" data-aos-duration="1500">
                <div class="col-lg-10 offset-lg-1">
                    <div class="end-text w-100 content">
                        <?=$project['Project']['final_text']?>
                    </div>
                </div>
           </div>
        <?php } ?>

        <div class="row foot <?=(!empty($project['Project']['final_text'])) ? 'mt-4' : ''?>">
            <div class="col-lg-11 offset-lg-1 d-flex justify-content-center">
                <a class="btn-view-more d-flex align-items-center justify-content-center text-center" href='<?= $this->Html->url(['action' => 'projects']) ?>'>
                    <div>VER MÁS <br />
                    PROYECTOS</div>
                </a>
            </div>
        </div>

    </div>
</section>