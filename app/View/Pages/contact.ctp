<?php
$this->Package->assign('view', 'js', array(
	'app.pages.contact',
	'vendor.underscore.underscore',
	'widget.media-manager',
	'app.pages.inputs-validation'
));
$this->Package->assign('view', 'css', array(
	'view.pages.contact'
));

// Page properties
$this->assign('title', __('page-title', __('Contacto'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'contact');

$action = [
	'controller' => 'pages',
	'action' => 'contact',
	// '#' => __('contacto'),
];

// Faker
$fake = Configure::read('debug') > 1 && $this->request->query('fake') == 1;
$faker = null;

if ($fake) {
	$faker = Faker\Factory::create();
	$action['?']['fake'] = 1;
}
?>
<?php
	$this->validationErrors['Quote']=$validationErrorsQuote;
	$this->validationErrors['RequestVacancy']=$validationErrorsRequestVacancy;
?>
	
<section class="section-contact">
	
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-text">
				<div class="title text-uppercase text-white">Contacto</div>
				<div class="container-items mt-5">
					<?php
						$dataContact = $config['App']['configurations'];
					?>
					<?php
						$textEmail = sprintf("Email:<br />%s",$dataContact['contact-email']);
						echo $this->element('components/email', [
							'id' => 'contact-email',
							'class' => 'item',
							'icon' => false,
							'email' => $dataContact['contact-email'],
							'title' => $textEmail
						]);
					?>
					<?php
						$textWhatsApp = sprintf("WhatsApp:<br />%s",$dataContact['contact-whatsapp']);
						echo $this->element('components/whatsapp', [
							'id' => 'contact-whatsapp',
							'class' => 'item',
							'icon' => false,
							'phone' => $dataContact['contact-whatsapp'],
							'title' => $textWhatsApp,
						]);
					?>

					<div class="item">
						Ubicaci¨®n:<br /><?=$dataContact['contact-address' ]?>
					</div>
					<div class="item">
						Encu¨¦ntranos en el mapa: <a target="_blank" href="https://goo.gl/maps/EJBKa8G9bU3YEyTb7">https://goo.gl/maps/EJBKa8G9bU3YEyTb7</a>
					</div>
				</div>
			</div>
			<div class="col-lg-1 d-none d-lg-flex col-scroll">
				<div class="scroll">
					<div class="container-icons">
						<div class="star"></div>
						<div class="circle"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-tabs" id="contacto">
				<?php echo $this->Flash->render(); ?>
			
				<ul class="nav nav-pills" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="pills-quote-tab" data-toggle="pill" data-target="#pills-quote" type="button" role="tab" aria-controls="pills-quote" aria-selected="true">
							<div class="d-flex flex-column align-items-start container-text">
								Cotiza <span>Tu proyecto</span>
							</div>
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-vacant-tab" data-toggle="pill" data-target="#pills-vacant" type="button" role="tab" aria-controls="pills-vacant" aria-selected="false"><div class="vacant">Aplicar a Vacante</div></button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">General</button>
					</li>
				</ul>
				<div class="container-star w-100">
					<div class="star-green"></div>
				</div>
				<div class="tab-content" id="pills-tabContent">

					<div class="tab-pane show active" id="pills-quote" role="tabpanel" aria-labelledby="pills-quote-tab">
						<!-- form quote -->
						<?php
						echo $this->BootForm->create('Quote', array(
							'id' => 'quote-form',
							'url' => [
								'controller' => 'pages',
								'action' => 'send_quote',
							],
							'novalidate' => true,
							'async' => true,							
						));
						?>
							<?php
							$inputs = [
								'Quote.name' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->firstName : false,
									'label' =>  __d('contact_email', 'name-placeholder')
								],
								'Quote.email' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->username . '@affenbits.com' : false,
									'label' => __d('contact_email', 'email-placeholder')
								],
								'Quote.phone' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->phoneNumber : false,
									'label' => __d('contact_email', 'phone-placeholder')
								],
								'Quote.budget' => [
									'placeholder' => false,
									'label' => __d('contact_email', 'budget-placeholder')
								],
								'Quote.message' => [
									'type' => 'textarea',
									'placeholder' => false,
									'rows' => '8',
									'fake' => $fake ? $faker->realText() : false,
									'label' => __d('contact_email', 'message-placeholder')
								]
							];

							echo $this->element('components/inputs', compact('inputs', 'fake'));
							?>

							<div id='QuoteRecaptcha' class='captcha-input input form-group'>
								<?php echo $this->element('components/recaptcha'); ?>
							</div>

							<?php
							echo $this->BootForm->button(__('Enviar'), array(
								'type' => 'submit',
								'class' => 'btn btn-primary'
							));
							?>
						<?php echo $this->BootForm->end(); ?>
					</div>
					<div class="tab-pane" id="pills-vacant" role="tabpanel" aria-labelledby="pills-vacant-tab">
						<!-- form vacant -->
						<?php
						echo $this->BootForm->create('RequestVacancy', array(
							'id' => 'vacant-form',
							'url' => [
								'controller' => 'pages', 
								'action' => 'save_vacant',
							],
							'novalidate' => true,		
							'data-model' => 'RequestVacancy'
						));
						?>
							<?php
							$inputs = [
								'RequestVacancy.name' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->firstName : false,
									'label' =>  __d('contact_email', 'name-placeholder')
								],

								'RequestVacancy.email' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->username . '@affenbits.com' : false,
									'label' => __d('contact_email', 'email-placeholder')
								],
								'RequestVacancy.phone' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->phoneNumber : false,
									'label' => __d('contact_email', 'phone-placeholder')
								],
								'RequestVacancy.vacancy_id' => [
									'type' => 'select',
									'empty' => 'Posici¨®n*',
									'options' => $vacancies,
									'data-component' => false,
									'label' => false
								],
								'RequestVacancy.message' => [
									'type' => 'textarea',
									'placeholder' => false,
									'rows' => '8',
									'fake' => $fake ? $faker->realText() : false,
									'label' => __d('contact_email', 'message-placeholder')
								],
								// 'RequestVacancy.document' => [
								// 	'type' => 'file',
								// 	'placeholder' => __d('contact_email', 'document-placeholder'),
								// 	'label' => false
								// ],
							];

							echo $this->element('components/inputs', compact('inputs', 'fake'));
							?>
							<?php
							echo $this->element('admin/widgets/form/inputs',[
								'fields' => [
									'document' => ['type' => 'media'],
								],
								'modelkey' => Inflector::singularize('RequestVacancy')
							]);
							?>

							<div id='RequestVacancyRecaptcha' class='captcha-input input form-group'>
								<?php echo $this->element('components/recaptcha'); ?>
							</div>

							<?php
							echo $this->BootForm->button(__('Enviar'), array(
								'type' => 'submit',
								'class' => 'btn btn-primary'
							));
							?>
						<?php echo $this->BootForm->end(); ?>
					</div>
					<div class="tab-pane " id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
						<!-- form general -->
						<?php //echo $this->Flash->render(); ?>

						<?php
						echo $this->BootForm->create('ContactEmail', array(
							'id' => 'contact-form',
							'url' => $action,
							'novalidate' => true,
							'async' => true,
						));
						?>
							<?php
							$inputs = [
								'ContactEmail.name' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->firstName : false,
									'label' => __d('contact_email', 'name-placeholder')
								],
								// 'ContactEmail.last_name' => [
								// 	'placeholder' => __d('contact_email', 'last-name-placeholder'),
								// 	'fake' => $fake ? $faker->lastName : false,
								// 	'label' => false
								// ],
								'ContactEmail.email' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->username . '@affenbits.com' : false,
									'label' => __d('contact_email', 'email-placeholder')
								],
								'ContactEmail.phone' => [
									'placeholder' => false,
									'fake' => $fake ? $faker->phoneNumber : false,
									'label' => __d('contact_email', 'phone-placeholder')
								],
								'ContactEmail.message' => [
									'type' => 'textarea',
									'placeholder' => false,
									'rows' => '8',
									'fake' => $fake ? $faker->realText() : false,
									'label' => __d('contact_email', 'message-placeholder')
								]
							];

							echo $this->element('components/inputs', compact('inputs', 'fake'));
							?>

							<div id='ContactEmailRecaptcha' class='captcha-input input form-group'>
								<?php echo $this->element('components/recaptcha'); ?>
							</div>

							<?php
							echo $this->BootForm->button(__('Enviar'), array(
								'type' => 'submit',
								'class' => 'btn btn-primary'
							));
							?>
						<?php echo $this->BootForm->end(); ?>
					</div>
				</div>	
			</div>
		</div>
	</div>
</section>