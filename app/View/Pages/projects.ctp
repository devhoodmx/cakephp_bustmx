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

        <?php if (!empty($categories)) : ?>
            <div class="row row-filters">
                <div class="col-12 container-filters">
                    <button class="btn-filter active" data-filter="all">Todos</button>
                    <?php foreach ($categories as $categoryId => $categoryName) : ?>
                        <button class="btn-filter" data-filter="<?= $categoryId ?>"><?= h($categoryName) ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach($projects as $key=>$project):?>
            <?php
                $projectCategoryIds = !empty($project['Category']) ? implode(',', Hash::extract($project['Category'], '{n}.id')) : '';
            ?>
            <div class="row project-item" data-aos="fade-up" data-aos-duration="1000" data-category="<?= $projectCategoryIds ?>">
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
