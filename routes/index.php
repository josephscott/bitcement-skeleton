<?php
declare( strict_types = 1 );

echo $app->use( 'twig' )->render( 'header.html' );
echo $app->use( 'twig' )->render( 'footer.html' );
