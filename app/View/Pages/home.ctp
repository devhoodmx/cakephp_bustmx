<?php
$this->Package->assign('view', 'js', array(
	'vendor.swiper.swiper',
	'app.pages.home',

));
$this->Package->assign('view', 'css', array(
	'vendor.swiper.swiper',
	'view.pages.home',

));


// Page properties
$this->assign('title', $config['App']['configurations']['website-title']);
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'home');
?>

<?php
App::uses('Debugger', 'Utility');
?>


<!-- section intro -->
<section class="section-intro d-flex flex-column justify-content-center">
	<!-- section title -->
	<div class="container container-title d-flex justify-content-center">
		<h1 class="h1 title">
			<strong>WE'</strong> LL HELP YOU T<span class="letter-spinning-star">O</span>
			BEC<span class="letter-circle">O</span>ME A <strong>CULTURE</strong>
			<div class="bg-animation">RELEVANT</div> <span>BRAND</span><strong>.</strong>
		</h1>
	</div>
	<!-- section-networks -->
	<div class="container container-networks">
		<div class="row justify-content-center">
			<div class="col-12 col-links d-flex justify-content-start align-items-center">
				<?php
				echo $this->Html->link(
					'NOSOTROS',
					[
						'controller' => 'pages', 'action' => 'about'
					],
					[
						'class' => 'font-25 text-uppercase item'
					]
				);

				echo $this->Html->link(
					'PORTAFOLIO',
					[
						'controller' => 'pages', 'action' => 'projects'
					],
					[
						'class' => 'font-25 text-uppercase item'
					]
				);

				echo $this->Html->link(
					'SERVICIOS',
					'#servicios',
					[
						'class' => 'font-25 text-uppercase item'
					]
				);

				echo $this->Html->link(
					'Contacto',
					[
						'controller' => 'pages',
						'action' => 'contact',
					],
					[
						'class' => 'font-25 text-uppercase item',
						'escape' => false,
						'data-tab' => 'pills-contact'
					]
				);
				?>

			</div>
		</div>
		<div class="row mt-2 mt-lg-4 justify-content-center">
			<div class="col-12 col-networks  d-flex justify-content-start align-items-center">
				<?php
				$networks = [
					'facebook' => [
						'target' => '_blank',
						'class' => 'icons'
					],
					'instagram' => [
						'target' => '_blank',
						'class' => 'icons'
					],

				];
				foreach ($networks as $network => $attr) :
					if (!empty($config['App']['configurations']['socialnetworks-' . $network])) :
						echo $this->Html->link(
							$this->Html->image('/img/site/bust/icons/' . $network . '.svg', ["alt" => $network]),
							$config['App']['configurations']['socialnetworks-' . $network],
							['target' => $attr['target'], 'class' => $attr['class'], 'escape' => false]
						);
					endif;
				endforeach;
				?>
			</div>
		</div>
	</div>
</section>

<section class="section-services bg-black" id="servicios">
	<!-- Container titles -->
	<div class="section-services-title">
		<div class="container">
			<div class="d-flex justify-content-between nav-titles">
				<h3 class="h3 text-uppercase text-bridalHeath title">Servici<span class="letter-o-expanded"></span>s</h3>

				<div class="col-right d-flex flex-column align-items-end justify-content-end flex-xl-row">
					<div class="item text-pampas font-25 text-uppercase">www.bust.mx</div>
					<div class="item text-pampas font-25 text-uppercase"> Marketing digital</div>
				</div>
			</div>
		</div>
	</div>

	<!-- container card services -->
	<div class="container-cards">

		<div class="card-service bg-mintgreen">
			<div class="card-service__title text-uppercase">
				Generación de leads
			</div>

			<div class="container-pills">
				<div class="wrapper-pills">
					<div class="inside-pills">
						<span class="pill"><span class='inner-pill'>CRM</span></span>
						<span class="pill"><span class='inner-pill'>Active Campaign</span></span>
						<span class="pill"><span class='inner-pill'>HubSpot</span></span>
						<span class="pill"><span class='inner-pill'>Soporte</span></span>
						<span class="pill"><span class='inner-pill'>ChatBot</span></span>
						<span class="pill"><span class='inner-pill'>Automatizaciones</span></span>
						<span class="pill"><span class='inner-pill'>Capacitación de ventas</span></span>
						<span class="pill"><span class='inner-pill'>Landing Page</span></span>
						<span class="pill"><span class='inner-pill'>Lead Scoring</span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="card-service bg-pampas">
			<div class="card-service__title text-uppercase">
				Diseño gráfico
			</div>
			<div class="container-pills">
				<div class="wrapper-pills">
					<div class="inside-pills">
						<span class="pill"><span class='inner-pill'>Branding</span></span>
						<span class="pill"><span class='inner-pill'>Brief</span></span>
						<span class="pill"><span class='inner-pill'>Naming</span></span>
						<span class="pill"><span class='inner-pill'>Manual de Marca</span></span>
						<span class="pill"><span class='inner-pill'>Brochure</span></span>
						<span class="pill"><span class='inner-pill'>Web y Landing</span></span>
						<span class="pill"><span class='inner-pill'>Moodboards</span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="card-service bg-cod-gray text-white">
			<div class="card-service__title text-uppercase">
				Inbound Marketing
			</div>

			<div class="container-pills">
				<div class="wrapper-pills">
					<div class="inside-pills">
						<span class="pill"><span class='inner-pill'>Blog</span></span>
						<span class="pill"><span class='inner-pill'>Optimizacion de páginas web</span></span>
						<span class="pill"><span class='inner-pill'>Posicionamiento</span></span>
						<span class="pill"><span class='inner-pill'>Search Console</span></span>
						<span class="pill"><span class='inner-pill'>Métricas</span></span>
						<span class="pill"><span class='inner-pill'>SEO</span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="card-service bg-pampas">
			<div class="card-service__title text-uppercase">
				Campañas
			</div>

			<div class="container-pills">
				<div class="wrapper-pills">
					<div class="inside-pills">
						<span class="pill"><span class='inner-pill'>Facebook Ads</span></span>
						<span class="pill"><span class='inner-pill'>Instragram Ads</span></span>
						<span class="pill"><span class='inner-pill'>Google Ads</span></span>
						<span class="pill"><span class='inner-pill'>Tiktok Ads</span></span>
						<span class="pill"><span class='inner-pill'>Linkedin Ads</span></span>
						<span class="pill"><span class='inner-pill'>Google Display</span></span>
						<span class="pill"><span class='inner-pill'>Métricas</span></span>
						<span class="pill"><span class='inner-pill'>Dashboard</span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="card-service bg-mintgreen">
			<div class="card-service__title text-uppercase">
				Redes sociales
			</div>
			<div class="container-pills">
				<div class="wrapper-pills">
					<div class="inside-pills">
						<span class="pill"><span class='inner-pill'>Social Media Management</span></span>
						<span class="pill"><span class='inner-pill'>Copywriting</span></span>
						<span class="pill"><span class='inner-pill'>Reels</span></span>
						<span class="pill"><span class='inner-pill'>Community Manager</span></span>
						<span class="pill"><span class='inner-pill'>Animación</span></span>
						<span class="pill"><span class='inner-pill'>Producción Audiovisual</span></span>
						<span class="pill"><span class='inner-pill'>Creación de contenido</span></span>
						<span class="pill"><span class='inner-pill'>Fotografía</span></span>
						<span class="pill"><span class='inner-pill'>Diseño</span></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-projects bg-black" id="proyectos">
	<!-- container swiper images -->
	<div class="container container-briefcase position-relative">
		<!-- swiper buttons -->
		<div class="container-controls">
			<div class="swiper-button-prev text-white"></div>
			<div class="swiper-button-next text-white"></div>
		</div>
		<!-- Swiper -->
		<div class="swiper swiper-briefcase">

			<div class="swiper-wrapper">

				<?php foreach ($projects as $key => $project) : ?>
					<?php
					$project['MediaCover']['url'] = sprintf(
						'/files/media/image/card_%s.%s',
						$project['MediaCover']['key'],
						$project['MediaCover']['format']
					);

					$videoSrc = sprintf(
						'/files/media/video/file_%s.%s',
						$project['MediaCover']['key'],
						$project['MediaCover']['format']
					);

					$url = [
						'controller' => 'pages',
						'action' => 'project',
						$project['Project']['id'],
						Utility::Slug(strip_tags($project['Project']['name']))
					]
					?>
					<a class="swiper-slide" href="<?= $this->Html->url($url) ?>">
						<?php if ($project['MediaCover']['format'] != 'mp4') : ?>
							<img class="img-fluid img-project" src="<?= $project['MediaCover']['url'] ?>" alt="<?= $project['MediaCover']['alt'] ?>">
						<?php else : ?>
							<?php
							$coverPoster = '';
							if (!empty($project['MediaCover']['poster_key'])) {
								$coverPoster = '/files/media/image/poster_' . $project['MediaCover']['poster_key'] . '.' . $project['MediaCover']['poster_format'];
							}
							?>
							<video class="video-project" src="<?= $videoSrc ?>" muted loop<?= !empty($coverPoster) ? ' poster="' . $coverPoster . '"' : '' ?>></video>
						<?php endif; ?>
						<div class="name-project mt-2"><?= $project['Project']['name'] ?></div>
					</a>
				<?php endforeach; ?>

			</div>


		</div>
		<div class="row justify-content-center foot">
			<?php
			echo $this->Html->link(
				'Cotiza tu proyecto',
				[
					'controller' => 'pages',
					'action' => 'contact'
				],
				[
					'class' => 'btn btn-outline-primary filter-invert',
					'data-tab' => 'pills-quote'
				]
			);
			?>
		</div>
	</div>
</section>

<!-- section reviews -->
<section class="section-reviews bg-black">
	<!-- container reviews -->

	<div class="container container-reviews position-relative">
		<h3 class="h3 text-pampas text-uppercase title">REVIEWS</h3>
		<div class="row pl-lg-5">
			<?php
			foreach ($reviews as $key => $review) :
				$key = $key + 1;
				$classMargin = "";
				$classCard = "";
				if ($key == 1) {
					$classMargin = "col-text-1 col-lg-6";
				} elseif ($key == 2) {
					$classMargin = "offset-lg-3 col-lg-6";
				} elseif ($key == 3) {
					$classMargin = "offset-lg-6 col-lg-6";
					$classCard = "last-text-review";
				}
			?>

				<div class="<?= $classMargin ?> col-text">
					<div class="text-rewiew text-pampas <?= ($classCard) ? $classCard : '' ?>">
						<div data-aos="fade-up" data-aos-duration="1000">
							<?= $review['Review']['description'] ?>
						</div>

						<?php if ($key == 3) : ?>
							<div class="invisible d-none d-lg-block">
								<?= $review['Review']['description'] ?>
							</div>
						<?php endif; ?>
					</div>

				</div>


			<?php endforeach; ?>
		</div>
	</div>

	<!-- constainer plataforms -->
	<div class="container container-plataforms">

		<div class="row">
			<div class="col-12">
				<h3 class="h3 title text-bridalHeath text-uppercase text-center">PLATAFORMAS</h3>
			</div>
		</div>
		<div class="row" data-aos="fade-up" data-aos-duration="1000" class="aos-init aos-animate">
			<div class="col-12 plataforms">
				<?php
				$platforms = [
					[
						'img' => 'Facebook.svg',
						'tooltip' => 'Facebook Ads'
					],
					[
						'img' => 'Instagram.svg',
						'tooltip' => 'Instagram'
					],
					[
						'img' => 'Active_Campaign_Partners.svg',
						'tooltip' => 'Active Campaing Partners (CRM)'
					],
					[
						'img' => 'Google_Ads.svg',
						'tooltip' => 'Google Ads'
					],
					[
						'img' => 'Hubspot.svg',
						'tooltip' => 'Hubspot (CRM)'
					],
					[
						'img' => 'Looker_Studio.svg',
						'tooltip' => 'Looker Studio'
					],
					[
						'img' => 'MailChimp.svg',
						'tooltip' => 'MailChimp'
					],
					[
						'img' => 'ManyChat.svg',
						'tooltip' => 'ManyChat'
					],
					[
						'img' => 'Meta_Bussines_Suite.svg',
						'tooltip' => 'Meta Bussines Suite'
					],
					[
						'img' => 'Odoo.svg',
						'tooltip' => 'Odoo (CRM)'
					],
					[
						'img' => 'Tiktok.svg',
						'tooltip' => 'Tiktok'
					],
					[
						'img' => 'Wix.svg',
						'tooltip' => 'Wix'
					],
					[
						'img' => 'WordPress.svg',
						'tooltip' => 'WordPress'
					],
					[
						'img' => 'Zapier.svg',
						'tooltip' => 'Zapier'
					],
					[
						'img' => 'Adara_Partners.svg',
						'tooltip' => 'Adara Partners (CRM)'
					]
				];
				?>
				<?php foreach ($platforms as $key => $platform) : ?>
					<div class="icons">
						<?= $this->Html->image('/img/site/platforms/' . $platform['img'], ["alt" => $platform['tooltip']]) ?>
						<div class="tooltip"><?= $platform['tooltip'] ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php
$planCards = [
	[
		'name' => 'Bust x Food',
		'price' => '$22,000 + IVA',
		'feature' => '
				<ul>
					<li>Plan enfocado en destacar tu marca entre la multitud.</li>

					<li>Diseñado para atraer a más clientes a tu establecimiento.</li>

					<li>Estrategia orientada a aumentar el posicionamiento, el alcance y el crecimientode tu audiencia.</li>
				</ul>
			',
		'recommended' => '
				<ul>
					<li>Wellness Studios</li>
					<li>Restaurantes</li>
					<li>Proyectos personales</li>
					<li>Despachos legales</li>
					<li>Imagen personal</li>
					<li>Entre otros</li>
				</ul>
			'
	],
	[
		'name' => 'Bust x Sales',
		'price' => '$27,000 + IVA',
		'feature' => '
				<ul>
					<li>La solución perfecta para generar leads y aumentar las ventas.</li>

					<li>Enfoque centrado en la captación de clientes potenciales.</li>

					<li>Incluye una variedad de servicios esenciales para impulsar tu negocio.</li>
				</ul>
			',
		'recommended' => '
				<ul>
					<li>Sector inmobiliario</li>
					<li>Retail</li>
					<li>E-Commerce</li>
					<li>B2B</li>
					<li>Entre otros</li>
				</ul>
			'
	],
	[
		'name' => 'Bust x Enterprise',
		'price' => '$46,900 + IVA',
		'feature' => '
				<ul>
					<li>Nuestro plan más completo.</li>

					<li>Diseñado para empresas medianas y grandes que buscan una presencia sólida en línea.</li>

					<li>Incluye estrategias efectivas para impulsar las acciones del cliente.</li>
				</ul>
			',
		'recommended' => '
				<ul>
					<li>Servicios financieros</li>
					<li>Salud</li>
					<li>Educación</li>
					<li>Viajes y turismo</li>
					<li>Retail</li>
					<li>e-commerce</li>
					<li>Entre otros</li>
				</ul>
			'
	]
];
?>

<!-- seccion planes -->
<section class="section-plans">

	<div class="container position-relative">

		<div class="row">
			<!-- <div class="col-lg-1 col-scroll">
				<div class="scroll">
					<div class="container-icons">
						<div class="star"></div>
						<div class="circle"></div>
					</div>
				</div>
			</div> -->
			<div class="col-12">
				
				<div class="head">
					<div class="line-section">
						<img src="/img/site/pages/about/five-pointed-star.svg" class="five-star filter-invert">

						<img src="/img/site/pages/about/five-pointed-star.svg" class="five-star filter-invert star-animation">

						<div class="green-circle circle-animation"></div>

						<img src="/img/site/bust/twenty-pointed-star.png" class="twenty-star filter-invert">
					</div>
					<h3 class="h3 title text-center text-uppercase text-tuatara">
						PLANES
					</h3>
				</div>

				<div class="body">
					<?php foreach ($planCards as $plan): ?>
						<div class="card">
							<div class="card-header">
								<div class="plan-name text-uppercase">
									<?=$plan['name']?>
								</div>
							</div>
							<div class="card-body">
								<small class="price text-left font-weight-bold">Desde: <?=$plan['price'];?></small>

								<div class="features">
									<div class="features-title">Características</div>
									<div class="content content-format">
										<?=$plan['feature']?>
									</div>
								</div>

								<?php echo $this->Html->link('Ver más',['controller' => 'pages', 'action' => 'contact'],['class' => 'btn btn-view-more btn-block btn-card']); ?>

								<div class="recommended">
									<div class="recommended-title">Recomendado para:</div>
									<div class="list">
										<?= $plan['recommended']; ?>
									</div>
								</div>
							</div>
							
						</div>
					<?php endforeach; ?>
				</div>

				<div class="table">
					<?php echo $this->element('site/components/table_plans'); ?>
				</div>

				</div>

				<div class="foot d-flex flex-column align-items-center">
					<?php

					/*echo $this->Html->link(
						'Perzonaliza tu paquete',
						array('controller' => 'pages', 'action' => 'contact'),
						[
							'class' => 'btn btn-outline-primary btn-personalize',
							'data-tab' => 'pills-contact'
						]
					);*/

					?>
					<div class="wrapper-buttons d-flex  flex-column flex-lg-row justify-content-center btn-group btn-plan-group">
						<?php /* ?><a type="button" class="btn btn-more flex-fill text-center" href='"' data-toggle="modal" data-target="#plansModal">
							Ver detalle de planes
						</a><?php */ ?>
						<?php echo $this->Html->link(
							'Cotiza tu plan',
							[
								'controller' => 'pages',
								'action' => 'contact'
							],
							[
								'class' => 'btn-plan text-center text-uppercase',
								'data-tab' => 'pills-quote'
							]
						); ?>
					</div>

				</div>

			</div>
		</div>
	</div>
</section>


<?php
echo $this->element('components/modal', [
	'id' => 'plansModal',
	'centered' => true,
	'size' => 'xl',
	'header' => false,
	'body' => $this->element('site/components/plan-modal'),
	'footer' => false,
]);
?>