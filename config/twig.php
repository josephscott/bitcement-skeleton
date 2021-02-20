<?php
declare( strict_types = 1 );

use \ParagonIE\AntiCSRF\AntiCRSF;

if ( !defined( 'APP_TWIG_AUTO_RELOAD' ) ) {
	define( 'APP_TWIG_AUTO_RELOAD', true );
}

if ( !defined( 'APP_TWIG_CACHE_DIR' ) ) {
	if ( is_writable( APP_DIR . '/cache/twig' ) ) {
		define( 'APP_TWIG_CACHE_DIR', APP_DIR . '/cache/twig' );
	} else {
		define( 'APP_TWIG_CACHE_DIR', false );
	}
}

$app->inject(
	'twig',
	new \Twig\Environment(
		new \Twig\Loader\FilesystemLoader( APP_DIR . '/templates' ),
		[
			'cache' => APP_TWIG_CACHE_DIR,
			'auto_reload' => APP_TWIG_AUTO_RELOAD
		]
	)
);

$app->use( 'twig' )->addFunction(
	new \Twig\TwigFunction(
		'crsf_token',
		function( $lock_to = null ) {
			static $crsf;

			if ( $crsf === null ) {
				$crsf = new AntiCRSF();
			}

			return $crsf->insertToken( $lock_to, false );
		},
		[ 'is_safe' => [ 'html'] ]
	)
);
