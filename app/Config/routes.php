<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

	Router::parseExtensions('rss', 'json', 'xml');

	Router::connect('/acceso-restringido', array('controller' => 'pages', 'action' => 'password_protection', 'admin' => false));

/**
 * Load admin routes
 */
	Router::connect('/admin', array('controller' => 'pages', 'action' => 'home', 'admin' => true));
	Router::connect('/admin/login', array('controller' => 'users', 'action' => 'login', 'admin' => true));
	Router::connect('/admin/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => true));
	Router::connect('/admin/cuenta', array('controller' => 'users', 'action' => 'profile', 'admin' => true));

	Router::connect('/admin/:controller/:action/*', array('admin' => true));
	Router::connect('/admin/:controller', array('action' => 'index', 'admin' => true));

/**
 * Load site routes
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/contacto', array('controller' => 'pages', 'action' => 'contact'));
	Router::connect('/privacidad', array('controller' => 'pages', 'action' => 'privacy'));
	Router::connect('/terminos-y-condiciones', array('controller' => 'pages', 'action' => 'tos'));
	Router::connect('/contact-us', array('controller' => 'pages', 'action' => 'contact', 'locale' => 'en'));
	Router::connect('/descargar/*', array('controller' => 'media', 'action' => 'download'));

	Router::connect('/cdn/:version/download/*', array('controller' => 'media', 'action' => 'share', 'download' => true));
	Router::connect('/cdn/:version/*', array('controller' => 'media', 'action' => 'share'));

	Router::connect('/sitemap', array('controller' => 'pages', 'action' => 'sitemap', 'ext' => 'xml'));

	Router::connect('/nosotros', array('controller' => 'pages', 'action' => 'about'));
	Router::connect('/portafolio', array('controller' => 'pages', 'action' => 'projects'));
	Router::connect('/proyecto/*', array('controller' => 'pages', 'action' => 'project'));
	Router::connect('/gracias', array('controller' => 'pages', 'action' => 'thanks'));

	



	// Pretty urls web pages
	if (Configure::read('App.webpages.active') && Configure::read('App.webpages.pretty-urls')) {
		Router::connect('/*', array('controller' => 'web_pages', 'action' => 'view'));
	}

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
