# Components

## Template

```yaml
---
js:
  - vendor.bootstrap-4.carousel
css:
  - vendor.bootstrap-4.modal
examples:
  - [clients/mantra] f394edb6 Add SEO to pages
simian: 4908031f Use BootstrapDatepicker component to render the datepicker
```

## Phone

```php+HTML
<?php echo $this->element('components/phone'); ?>
```

```php+HTML
<?php
echo $this->element('components/phone', [
	'id' => 'contact-phone',
	'class' => 'd-flex',
	'icon' => false,
	'title' => 'Teléfono'
]);
?>
```

```php+HTML
<?php
echo $this->element('components/phone', [
	'icon' => false,
	'title' => 'T. {{ phone }}'
]);
?>
```

## Address

```php+HTML
<?php echo $this->element('components/address'); ?>
```

```php+HTML
<?php
echo $this->element('components/address',[
  	'id' => 'contact-address',
	'class' => 'd-inline-flex',
  	'icon' => true,
  	'address' => '1098 Henry Ford Avenue'
]);
?>
```

```php+HTML
<?php
echo $this->element('components/address',[
  	'id' => 'contact-address',
	'class' => 'd-inline-flex',
  	'icon' => true,
  	'title' => '1098 Henry Ford Avenue'
  	'url' => 'https://goo.gl/maps/8nP68JvssaKWByqP9'
]);
?>
```

## WhatsApp

```php+HTML
<?php echo $this->element('components/whatsapp'); ?>
```

```php+HTML
<?php
echo $this->element('components/whatsapp', [
	'id' => 'contact-whatsapp',
	'class' => 'd-flex',
	'icon' => false,
	'phone' => '9992422094',
	'title' => 'WhatsApp',
	'message' => 'Nobody ever figures out what life is all about, and it doesn\'t matter. Explore the world.'
]);
?>
```

```php+HTML
<?php
echo $this->element('components/whatsapp', [
	'icon' => false,
	'title' => 'W. {{ phone }}'
]);
?>
```

## Email

```php+HTML
<?php echo $this->element('components/email'); ?>
```

```php+HTML
<?php
echo $this->element('components/email', [
	'id' => 'contact-email',
	'class' => 'd-flex',
	// true, false, ['value' => 'far fa-envelope'], ['type' => 'image', 'value' => 'admin/simian.svg']
	'icon' => false,
	'email' => 'luissquall@gmail.com',
	'title' => 'Correo electrónico'
]);
?>
```

```php+HTML
<?php
echo $this->element('components/email', [
	'icon' => false,
	'title' => 'C. {{ email }}'
]);
?>
```

### Set email attributes

```php+HTML
<?php
$body = '¡Hola!

Mi nombre es ____ y estoy interesad@ en los siguientes servicios de affenbits: _______

Muchas gracias por sus atenciones.';

echo $this->element('components/email', [
	'email' => [
		'to' => 'hi@affenbits.com',
		'cc' => 'feyman@affenbits.com',
		'bcc' => 'marketing@affenbits.com,sales@affenbits.com',
		'subject' => 'Hola monos',
		'body' => $body
	]
]);
?>
```

## reCAPTCHA

```php+HTML
<?php echo $this->element('components/recaptcha'); ?>
```

```php+HTML
<?php
echo $this->element('components/recaptcha', [
	'class' => 'd-flex justify-content-center',
	// dark, light
	'theme' => 'light',
	// https://developers.google.com/recaptcha/docs/language
	'locale' => 'es-419'
]);
?>
```

## Google Global site tag (gtag.js)

```php+HTML
<?php
echo $this->element('components/google_gtag', [
	'product' => 'Google Analytics',
	'targetId' => 'UA-157543623-1',
	'config' => []
]);
?>
```

### Extract targetId from `$config`

```php+HTML
<?php
echo $this->element('components/google_gtag', [
	'product' => 'Google Analytics'
]);
?>
```

###  Add additional configuration

```php+HTML
<?php
echo $this->element('components/google_gtag', [
	'product' => 'Google Analytics',
	'config' => [
		'transport_type' => 'beacon'
	]
]);
?>
```

## Video

```php+HTML
<?php
echo $this->element('components/video', [
	'id' => 'intro-video',
	'class' => '',
	// YouTube (https://www.youtube.com/watch?v=4kpDg7MjHps)
	// Vimeo (https://vimeo.com/392102662)
	// Facebook
	// Local video (videos/intro-640x350.mp4)
	'source' => 'https://www.youtube.com/watch?v=4kpDg7MjHps'
	// '21by9', '16by9', '4by3', '1by1', false
	'aspect' => '16by9',
	'controls' => true,
	'autoplay' => false, // Sets autoplay, muted & playsinline html attributes
	'loop' => false,
	'poster' => ''
]);
?>
```

### Local video

```php+HTML
<?php
echo $this->element('components/video', [
	'source' => '/videos/intro-640x350.mp4'
]);
?>
```

### Autoplay & loop video

```bash
<?php
echo $this->element('components/video', [
	'source' => '/videos/intro-640x350.mp4',
	'autoplay' => true,
	'loop' => true,
	'controls' => false,
	'poster' => '/img/poster.png'
]);
?>
```

## Carousel

```yaml
---
js:
  - vendor.bootstrap-4.carousel
```

```php+HTML
<?php
$items = [
	[
		'source' => '/img/site/home-1.jpg',
	],
	[
		'source' => '/img/site/home-2.jpg',
		'class' => '',
		'contain' => false,
		//'contain' => ['class' => 'd-flex align-items-center h-100'],
		'title' => 'Somos una empresa con nivel nacional.',
		'description' => 'Nos respaldan 5 años de experiencia y con más de 200 empresas en diferentes estados a nivel nacional.'
	],
	[
		'source' => [
			'url' => '/img/site/affenbits.svg',
			'alt' => 'affenbits'
		]
	]
];

echo $this->element('components/carousel', [
	'id' => 'main-carousel',
	'class' => 'gallery-carousel',
	'interval' => 0, // Disable cycling
	'controls' => true,
	'indicators' => true,
	'layout' => null,
	'items' => $items
]);
?>
```

```php+HTML
<?php
$items = [
	[
		'source' => '/img/site/demo/apartment.jpg'
	],
	[
		'source' => '/img/site/demo/apartment-2.jpg'
	]
];

echo $this->element('components/carousel', [
	'class' => 'main-carousel',
	'layout' => 'cover',
	'items' => $items
]);
?>
```

### Gallery

```php
// PagesController.php
	public function home() {
		// Gallery
		$this->loadModel('Gallery');

		$gallery = $this->Gallery->find('first', [
			'conditions' => ['Gallery.key' => 'gallery'],
			'contain' => ['Media']
		]);

		$this->set(compact('gallery'));
	}
```

```php+HTML
<?php
$items = [];

if (!empty($gallery['MediaImage'])) {
	foreach ($gallery['MediaImage'] as $key => $image) {
		$items[$image['id']] = [
			'id' => $image['id'],
			'source' => sprintf(
				'/files/media/image/main_%s.%s',
				$image['key'],
				$image['format']
			),
			'title' => $image['title'],
			'description' => $image['subtitle'],
			'width' => $image['width'],
			'height' => $image['height']
		];
	}
}

if (!empty($items)) {
	echo $this->element('components/carousel', [
		'class' => 'gallery-carousel',
		'items' => $items
	]);
}
?>
```

### Custom content

```php+HTML
<?php
$items = [];

if (!empty($images)) {
	foreach ($images as $key => $image) {
		// Buffer content
		ob_start();
?>
	<!-- Content -->
	<?php
	if (!empty($image['MediaLogo']['id'])) {
		echo $this->Html->image(
			sprintf(
				'/files/media/image/logo_%s.%s',
				$image['MediaLogo']['key'],
				$image['MediaLogo']['format']
			),
			['class' => 'carousel-logo']
		);
	}
	?>

	<?php if (!empty($image['MainImage']['name'])): ?>
	<div class='carousel-description'>
		<?php echo $image['MainImage']['name']; ?>
	</div>
	<?php endif; ?>

	<?php
	if (!empty($image['MainImage']['button_label']) && !empty($image['MainImage']['button_link'])) {
		echo $this->Html->link(
			$image['MainImage']['button_label'],
			$image['MainImage']['button_link'],
			[
				'class' => 'btn btn-light carousel-btn'
			]
		);
	}
	?>
	<!-- End Content -->
<?php
		$content = ob_get_clean();
		$items[$image['MediaImage']['id']] = [
			'class' => '',
			'content' => $content
		];
	}
}

if (!empty($items)) {
	echo $this->element('components/carousel', [
		'class' => 'cover-carousel',
		'layout' => 'cover',
		'items' => $items
	]);
}
?>
```

## Modal

```yaml
---
requires:
  js:
    - vendor.bootstrap-4.modal
  css:
    - vendor.bootstrap-4.modal
```

```php+HTML
<?php
echo $this->element('components/modal', [
	'id' => 'modal',
	'centered' => true,
	'size' => 'lg',
	'header' => [
		'title' => 'Plan de estudio 2010',
		'close' => false
	],
	'body' => '<p>Modal body text goes here.</p>',
	'footer' => "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button><button type='button' class='btn btn-primary'>Save changes</button>"
]);
?>
```

#### Buffer the body

```php+HTML
<?php ob_start(); ?>
<h1>Modal body title</h1>
<p>Modal body text goes here.</p>
<?php $body = ob_get_clean(); ?>

<?php
echo $this->element('components/modal', [
	'body' => [
		'class' => 'd-flex justify-content-center align-items-center text-center',
		'content' => $body
	]
]);
?>
```

## Nav

```yaml
---
js:
  - vendor.bootstrap-4.collapse
  # Required by 'track' attribute
  - component.nav
css:
  - component.nav
```

```php
<?php
echo $this->element('components/nav', [
	'id' => 'main-navbar-nav',
	'class' => '',
	'track' => false,
	'items' => [
		'contact' =>	[
			'name' => 'Contact',
			'url' => ['controller' => 'pages', 'action' => 'contact']
		],
		'about' => [
			'name' => 'About',
			'url' => '#',
			'target' => '_blank',
			'children' => []
		],
		'location' => [
			'name' => 'Location',
			'icon' => 'far fa-map-marker-alt fa-fw',
			'url' => ['controller' => 'pages', 'action' => 'contact']
		]
	],
	'toggle' => null, // 'dropdown'. Requires vendor.bootstrap-4.dropdown js
	// Active item key
	'active' => null,
	'separator' => '|'
]);
?>
```

```php+HTML
<?php
echo $this->element('components/nav', [
	'id' => 'header-menu',
	'class' => '',
	'items' => $menus['header'],
	'depth' => 1
]);
?>
```

### Navbar

```php+HTML
<!-- Add navbar-light class to style navbar-toggler-icon -->
<nav id='main-navbar' class='navbar navbar-expand-lg'>
	<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#main-navbar-collapse' aria-controls='main-navbar-collapse' aria-expanded='true' aria-label='<?php echo __('Abre y cierra menú'); ?>'>
		<?php
		echo $this->Html->image(
			'site/icons/bars.svg',
			[
				'alt' => __('Menú')
			]
		);
		?>
		<!-- <span class='navbar-toggler-icon'></span> -->
	</button>

	<div id='main-navbar-collapse' class='collapse navbar-collapse order-lg-0'>
		<?php
		echo $this->element('components/nav', [
			'id' => 'main-nav',
			'items' => [
				'home' => [
					'name' => 'Home',
					'url' => ['controller' => 'pages', 'action' => 'home']
				],
				'about' => [
					'name' => 'About us',
					'url' => '#about-us'
				],
				'contact' => [
					'name' => 'Contact',
					'url' => ['controller' => 'pages', 'action' => 'contact']
				]
			]
		]);
		?>
	</div>
</nav>
```

### Icons

```php+HTML
<?php
$icons = [];
$networks = [
	'instagram' => 'fab fa-instagram fa-fw',
	'facebook' => 'fab fa-facebook-f fa-fw'
];

foreach ($networks as $network => $icon) {
	if (!empty($config['App']['configurations']['socialnetworks-' . $network])) {
		$icons[] = [
			'icon' => $icon,
			'url' => $config['App']['configurations']['socialnetworks-' . $network],
			'target' => '_blank'
		];
	}
}
$icons[] = [
	'icon' => 'far fa-map-marker-alt fa-fw',
	'url' => 'https://goo.gl/maps/GrKHsRBPKZ7imxqg6',
	'target' => '_blank'
];

echo $this->element('components/nav', [
	'class' => 'icons-nav flex-row',
	'items' => $icons
]);
?>
```

### Track same page links

```php+HTML
<?php
// Script required: component.nav
echo $this->element('components/nav', [
	'id' => 'main-nav',
	'track' => true,
	'items' => $items
]);
?>
```

## Breadcrumb

```yaml
---
css:
  - vendor.bootstrap-4.breadcrumb
```

```php+HTML
<?php
echo $this->element('components/breadcrumb', [
	'id' => 'breadcrumb',
	'class' => '',
	'current' => true, // Optional
	'items' => [
		[
			'name' => 'Home',
			'url' => ['controller' => 'pages', 'action' => 'home']
		],
		[
			'name' => 'Products',
			'url' => ['controller' => 'pages', 'action' => 'products']
		]
	]
]);
?>
```

## Brand

```php+HTML
<?php echo $this->element('components/brand'); ?>
```

```php+HTML
<?php
echo $this->element('components/brand', [
	'name' => 'simian',
	'image' => 'admin/simian.svg',
	'url' => ['controller' => 'users', 'action' => 'login', 'admin' => true],
	'class' => ''
]);
?>
```

## Pagination

```yaml
---
css:
  - vendor.bootstrap-4.pagination
```

```php
<?php
echo $this->element('components/pagination', [
	'class' => 'blog-pagination',
	'options' => [], // Sets all the options for the Paginator Helper
	'numbers' => [], // Paginator Helper numbers options
	'prev' => true, // true, false, "<i class='fa fa-chevron-left'></i>"
	'next' => true // true, false, "<i class='fa fa-chevron-right'></i>"
]);
?>
```

## Dropdown

```yaml
---
js:
  - vendor.popper.popper
css:
  - vendor.bootstrap-4.dropdown
```

```php+HTML
<?php
echo $this->element('components/dropdown', [
	'id' => 'dropdown', // Optional
	'class' => '', // Optional
	'toggle' => [
		'title' => 'Title',
		'class' => ''
	], // Optional. Options: 'Title', []
	'items' => [
		'home' => [
			'name' => 'Home',
			'url' => ['controller' => 'pages', 'action' => 'home']
		],
		'products' => [
			'name' => 'Products',
			'url' => ['controller' => 'pages', 'action' => 'products']
		]
	],
	'active' => 'home' // Active item key
]);
?>
```

### Use active item to set toggle title

```php+HTML
<?php
echo $this->element('components/dropdown', [
	'items' => [
		'home' => [
			'name' => 'Home',
			'url' => ['controller' => 'pages', 'action' => 'home']
		],
		'products' => [
			'name' => 'Products',
			'url' => ['controller' => 'pages', 'action' => 'products']
		]
	],
	'active' => 'home' // Active item key
]);
?>
```

## Locales

```yaml
---
css:
  # Required by 'separator' attribute
  - component.nav
```

```php
<?php
echo $this->element('components/nav/locales', [
	'locales' => ['es', 'en']
]);
?>
```

```php
<?php
echo $this->element('components/nav/locales', [
	'class' => 'flex-row',
	'locales' => [
		'es' => 'ESP',
		'en' => 'ENG'
	],
	//'locales' => ['es', 'en'],
	'separator' => '|' // Requires component.nav css
]);
?>
```

#### Override default URL template

```php
<?php
echo $this->element('components/nav/locales', [
	'locales' => [
		'es' => 'ESP',
		'en' => 'ENG'
	],
	'url' => [
		'controller' => $this->request->controller,
		'action' => $this->request->action,
		1,
		'slug'
	]
]);
?>
```

#### Set an URL per locale

```php
<?php
echo $this->element('components/nav/locales', [
	'locales' => [
		'es' => ['url' => '/inicio'],
		'en' => ['url' => '/home', 'name' => 'ENG']
	]
]);
?>
```

## SEO

```yaml
---
examples:
  - [clients/mantra] f394edb6 Add SEO to pages
```

```php
// SEO
echo $this->element('components/seo', [
	'properties' => [
		'title' => '',
		'description' => '',
		'meta' => '',
		'header_code' => '',
		'footer_code' => ''
	]
]);
?>
```

### Using placeholders

```php
// SEO
echo $this->element('components/seo', [
	'properties' => [
		'title' => 'Hello {{ name }}',
		'description' => '',
		'meta' => '',
		'header_code' => '',
		'footer_code' => ''
	],
	// Placeholders
	'item' => [
		'name' => 'mono'
	]
]);
?>
```

## Social

```yaml
---
css:
  - component.font-awesome-5.brands
  - component.social
```

```php+HTML
<?php
echo $this->element('components/social', array(
	'items' => array(
		array(
			'network' => 'facebook',
			'account' => 'luissquall',
			'icon' => 'fab fa-facebook-f',
			'title' => '{{ account }}'
		),
		array(
			'network' => 'instagram',
			'account' => 'luissquall',
			'icon' => [
				'type' => 'image',
				'source' => sprintf('site/icons/%s.svg', 'instagram')
			]
		),
		array(
			'network' => 'google-plus',
			'account' => 'luissquall'
		),
		array(
			'network' => 'youtube',
			'account' => 'luissquall'
		),
		array(
			'network' => 'twitter',
			'account' => 'luissquall'
		),
		array(
			'network' => 'linkedin',
			'account' => 'luissquall'
		)
	),
	'class' => '',
	'style' => 'square'
));
?>
```

```php+HTML
<?php
$social = [];
$networks = ['facebook', 'instagram', 'youtube', 'twitter'];

foreach ($networks as $network) {
	if (!empty($config['App']['configurations']['socialnetworks-' . $network])) {
		$social[] = [
			'network' => $network,
			'account' => $config['App']['configurations']['socialnetworks-' . $network]
		];
	}
}
?>

<?php
if (!empty($social)) {
	echo $this->element('components/social', [
		'class' => 'd-flex',
		'items' => $social
	]);
}
?>
```

## Map

```php+HTML
<?php
echo $this->element('components/map', [
	'latitude' => '20.9966119',
	'longitude' => '-89.6172316',
	'zoom' => 15,
	'height' => 400,
	// 0, ['zoom', 'mapType', 'scale', 'streetView', 'rotate', 'fullscreen'],
	'controls' => ['zoom', 'fullscreen'],
	// roadmap, satellite, hybrid, terrain
	'type' => 'roadmap',
	'icon' => '/img/site/icons/marker.svg'
]);
?>
```

### Custom map styles

```php+HTML
<?php $this->append('script'); ?>
<script>
	hozen.config.map = {"styles":[]};
</script>
<?php $this->end(); ?>

<?php
$location = explode(',', $config['App']['configurations']['contact-location']);

if (sizeof($location) > 1) {
	echo $this->element('components/map', [
		'latitude' => trim($location[0]),
		'longitude' => trim($location[1]),
		'zoom' => 15,
		'height' => 400
	]);
}
?>
```

### Multiple locations

```php+HTML
<?php
echo $this->element('components/map', [
	'height' => 400,
	'locations' => [
		[
			'title' => 'Mumbai',
			'lat' => 19.0760,
			'lng' => 72.8777,
			'info' => 'Hello monkey!'
		],
		[
			'title' => 'Pune',
			'lat' => 18.5204,
			'lng' => 73.8567
		],
		[
			'title' => 'Bhopal ',
			'lat' => 23.2599,
			'lng' => 77.4126
		],
		[
			'title' => 'Agra',
			'lat' => 27.1767,
			'lng' => 78.0081
		],
		[
			'title' => 'Delhi',
			'lat' => 28.7041,
			'lng' => 77.1025
		]
	]
]);
?>
```

### Focus marker

```php+HTML
<?php
$locations = [
	[
		'title' => 'Mumbai',
		'lat' => 19.0760,
		'lng' => 72.8777
	],
	[
		'title' => 'Pune',
		'lat' => 18.5204,
		'lng' => 73.8567
	],
	[
		'title' => 'Bhopal ',
		'lat' => 23.2599,
		'lng' => 77.4126
	],
	[
		'title' => 'Agra',
		'lat' => 27.1767,
		'lng' => 78.0081
	],
	[
		'title' => 'Delhi',
		'lat' => 28.7041,
		'lng' => 77.1025,
		'key' => 'delhi'
	]
];

echo $this->element('components/map', [
	'id' => 'map',
	'key' => 'map',
	'height' => 400,
	'locations' => $locations
]);

foreach ($locations as $key => $location) {
	echo $this->Html->link(
		$location['title'],
		'#map', // id
		[
			'class' => 'map-component-marker',
			'data-map' => 'map', // key
			'data-marker' => isset($location['key']) ? $location['key'] : $key
		]
	);
}
?>
```

## Filters

```php+HTML
<?php
echo $this->element('admin/components/filters', [
	'filters' => [
		'q' => [
			'type' => 'hidden'
		],
		'bank_account_id' => [
			'options' => $bankAccounts,
			'empty' => __('Todas')
		],
		'status' => [
			'options' => $statuses,
			'empty' => __('Todas')
		]
	]
]);
?>
```

### Override clear button url

```php+HTML
<?php
echo $this->element('admin/components/filters', [
	'filters' => [
		'q' => [
			'type' => 'hidden'
		],
		'bank_account_id' => [
			'options' => $bankAccounts,
			'empty' => __('Todas')
		],
		'status' => [
			'options' => $statuses,
			'empty' => __('Todas')
		]
	],
	'actions' => [
		'clear' => ['action' => 'review']
	]
]);
?>
```

## Printer

```yaml
---
js:
  - component.printer
examples:
  - [clients/pronatura-quema] a388bb0b Add burn permit report
```

```php
<?php
echo $this->BootForm->button(
	__('Imprimir solicitud'), [
	'type' => 'button',
	'class' => 'btn btn-primary',
	'data-component' => 'printer',
	'data-url' => Router::url([
		'action' => 'print',
		$hash
	])
]);
?>
```

## BootstrapDatepicker

```yaml
---
simian: 4908031f Use BootstrapDatepicker component to render the datepicker
```

```php+HTML
<?php
$this->Package->assign('vendor', 'js', [
	'vendor.bootstrap-datepicker.bootstrap-datepicker',
	'vendor.bootstrap-datepicker.locales.es'
]);
$this->Package->assign('component', 'js', [
	'component.bootstrap-datepicker'
]);

$this->Package->assign('component', 'css', [
	'component.font-awesome-5.regular',
	'component.bootstrap-datepicker'
]);
?>

<?php
echo $this->BootForm->input('ContactEmail.expiration_date', [
	'type' => 'date',
	'language' => 'es'
]);
?>
```

### TODOs

1. Don't require `component.font-awesome-5.regular`

## WhatsHelp

```php+HTML
<?php
echo $this->element('components/whats_help', [
	'apps' => [
		'facebook' => '98270893605', // Facebook page ID
		'whatsapp' => '+529991446702',
		'email' => 'ventas@viacostela.com'
	]
]);
?>
```

```php+HTML
<?php
echo $this->element('components/whats_help', [
	'apps' => [
		'facebook' => '98270893605', // Facebook page ID
		'whatsapp' => '+529991446702',
		'email' => 'ventas@viacostela.com'
	],
	'button_color' => '#FF6550', // Defaults to #FF6550
	'position' => 'left', // Position may be 'right' or 'left'. Defaults to left
]);
?>
```

1. How do I find my Facebook Page ID?, https://www.facebook.com/help/1503421039731588

## Properties plan

`view.ctp`

```php+HTML
<?php
echo $this->element('components/properties_plan', [
	'id' => 'properties-plan',
	'plan' => 'site/properties-plan.jpg',
	// See https://gitlab.affenbits.com/clients/varena/blob/3ad211b9db842d4fb4a5b3114daacfce99657ee2/app/webroot/img/site/properties-map-plan.svg
	// Each property polygon must have the following attributes: class='property' data-key='{{ key }}'. The polygons group <g> must be transparent (fill-opacity='1')
	'areas' => '/img/site/properties-areas.svg',
	// $properties = [['10' => ['id' => 1, key' => '10', 'status' => 'sold']]];
	'properties' => $properties
]);
?>
```

```javascript
var $plan = $('#properties-plan');

$plan.on('properties-plan.property.click', function(event, $property, property) {
});
```

