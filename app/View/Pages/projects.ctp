<?php
$this->Package->assign('view', 'js', array(
	'app.pages.projects'
));
$this->Package->assign('view', 'css', array(
	'view.pages.projects'
));

// Page properties
$this->assign('title', __('page-title', __('Portafolio'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'projects');
?>

<section class="section-projects bg-black">
    <div class="container">
        <?php foreach($projects as $key=>$project):?>
            <div class="row" data-aos="fade-up" data-aos-duration="1000" >
                <div class="col-lg-5 col-info order-1 order-lg-0">
                   <div class="info">
                        <div class="name-company text-white mb-2">
                            <?=$project['Project']['name']?>
                        </div>
                        <div class="title-project text-white">
                            <small><?=$project['Project']['company']?></small>
                        </div>
                        <div class="services text-white">
                            <?=$project['Project']['services']?>
                        </div>
                   </div>
                   <?php
                    echo $this->Html->link(
                        'Ver más',
                        [
                            'controller' => 'pages',
                            'action' => 'project',
                            $project['Project']['id'],
                            Utility::Slug(strip_tags($project['Project']['name']))
                        ],
                        [
                            'class' => 'btn-view-project'

                        ]
                    );
                   ?>

                </div>
                <div class="col-lg-7 col-media order-0 ordr-lg-1">
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
					<div class="card-media">
						<?php if ($project['MediaCover']['format'] != 'mp4') : ?>
							<img class="img-fluid img-project" src="<?= $project['MediaCover']['url'] ?>" alt="<?= $project['MediaCover']['alt'] ?>">
						<?php else : ?>
							<?php
							$coverPoster = '';
							if (!empty($project['MediaCover']['poster_key'])) {
								$coverPoster = '/files/media/image/poster_' . $project['MediaCover']['poster_key'] . '.' . $project['MediaCover']['poster_format'];
							}
							?>
							<video class="video-project" src="<?= $videoSrc ?>" controls<?= !empty($coverPoster) ? ' poster="' . $coverPoster . '"' : '' ?>></video>
						<?php endif; ?>
					</div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</section>