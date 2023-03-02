<?php

define( 'WP_CACHE', false );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ahmwbksm_wp62' );

/** Database username */
define( 'DB_USER', 'ahmwbksm_wp62' );

/** Database password */
define( 'DB_PASSWORD', '.ES-N4pq4U(DD()4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1grezzcldeuwguzk9yplvyelif6pik4ccpgfiidffwns7sndye6ltmfh6d0shla8' );
define( 'SECURE_AUTH_KEY',  'njaqzkyagt5bozkhosfhv85o1yddysq9zixs8rbfmb7n97vogydcojj46wcsn4hx' );
define( 'LOGGED_IN_KEY',    'vijfdpn5own12jqbg70ldztscasxzoc5xvyzjwyemmvowq9dxyp0blfa99geas4e' );
define( 'NONCE_KEY',        '6yiderz2acqdrk7t1kof2exic1d0wdjybhyveuciwbhid7bmtlmzj4kmc19nijk1' );
define( 'AUTH_SALT',        '7abz53v39kogulbjal7r9fbpzhpvihxgkqh3fc7kvmjcrk16upqvevwzg3z690rv' );
define( 'SECURE_AUTH_SALT', 'p34keifq6z3pmuqazvm8nbe6x9yhvqkzpsnsrxs6b6m0ydmxsc8w8aqkhjhxb0s4' );
define( 'LOGGED_IN_SALT',   'wdwyefkejoewdzrxjypmjxy1kcj9p1vcmx4ls2nswfckwmc1rqwqqms7qfxi21bi' );
define( 'NONCE_SALT',       '3ynzgvwlajiblqrydrnhfp29dtbokjys5fejzunj54fry4cjatk1w4z8rwxtzei2' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpyu_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
define( 'CONCATENATE_SCRIPTS', false ); 
define( 'SCRIPT_DEBUG', true );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
