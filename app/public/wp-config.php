<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+0foICAPVNvN5cmjBACs7gGvbeNKZw3m6ggwqMZ6fYS+yBJbdIFyz+Nupoues59dv4BN5G9Q5PYJ7ynnjcOVng==');
define('SECURE_AUTH_KEY',  'NdnrGpD9S4Sg0xla9wHbz+elMPw5mBW3G0x4s5h9D42wrMYoByfLMgjU18sBx1Ji48r2jy1hSB9BpD2Kwrhv9Q==');
define('LOGGED_IN_KEY',    'ePPoQ0hhngV1miFfkczJ9txvWEHZMZADJ57iYWNkwcn7Osm+tN1bbDMjk/VTSSilQJf3Glg30j7mjL3sCHsJBg==');
define('NONCE_KEY',        'wGWG+yvVJa+VEAJbSyMXghO/YFH1fBI9Z6x4TalL49OAWnfDg31tzalq3ko9Xg3ngYNYbdFW9vqgaBx8JqqCKA==');
define('AUTH_SALT',        'TfRAopc9xe/vVPmKN+7+GCuyL+/4U4aXwDw4kdm7Bga7W0uBl8DC1/MHlomvVFdcafdzxNNnm9QmdyiBmP8rVg==');
define('SECURE_AUTH_SALT', '9ErD++eTWytNs6BBj6h3bNPqj9Jyzx3e0d1Mowz4yPjiIGVAwxI4WSqmCrMEoYbcmqembyPfszzyOAIdC7H5Og==');
define('LOGGED_IN_SALT',   'LZm3q9r0JB7ZqS5yoq+ESBQDFEfkUb5p9X+/jiVeEzt11HyMLhjpWU9c2aCHe1X/lfpABcwKs+Z7nIS6SonsNQ==');
define('NONCE_SALT',       '6Eqln9ZIRrk9xeP9cxtLcqrjhzCp0yOAPsM1w2qz0H09tK0TD90NVSPILsNRD7AUSzC2jpX768csGC8h4JERSQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
