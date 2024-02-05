<?php
/*
Plugin Name: QR Code Short URLS SVG
Plugin URI: https://yourls.org/
Description: Add .svg to shorturls to display QR Code
Version: 1.0
Author: Alexspi
Author URI: https://alessandrospigno.it/
*/

// Kick in if the loader does not recognize a valid pattern
yourls_add_action('redirect_keyword_not_found', 'alexspi_yourls_qrcode');

function alexspi_yourls_qrcode( $request ) {
        // Get authorized charset in keywords and make a regexp pattern
        $pattern = yourls_make_regexp_pattern( yourls_get_shorturl_charset() );

        // Shorturl is like bleh.svg?
        if( preg_match( "@^([$pattern]+)\.svg?/?$@", $request[0], $matches ) ) {
                // this shorturl exists?
                $keyword = yourls_sanitize_keyword( $matches[1] );
                if( yourls_is_shorturl( $keyword ) ) {
                        // Show the QR code SVG then!
                        header('Location: https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&format=svg&data='.YOURLS_SITE.'/'.$keyword);
                        exit;
                }
        }
}
