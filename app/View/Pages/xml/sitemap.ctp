<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
	$routes = [
		['controller' => 'pages', 'action' => 'home']
	];

	// Webpages
	if (!empty($webpages)) {
		foreach ($webpages as $webpage) {
			$routes[] = [
				'controller' => 'web_pages',
				'action' => 'view',
				$webpage['WebPage']['es_key']
			];
		}
	}

	foreach ($routes as $route):
	?>
	<url>
		<loc><?php echo Router::url($route, true); ?></loc>
	</url>
	<?php endforeach; ?>
</urlset>
