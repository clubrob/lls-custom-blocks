<?php
/**
 * Plugin Name:     Long Live Simple Custom Blocks
 * Description:     Plugin to provide custom blocks and custom block styles for Wordpress block editor.
 * Version:         0.1.0
 * Author:          Long Live Simple
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     lls-custom-blocks
 *
 * @package         create-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function create_block_lls_custom_blocks_block_init() {
	$dir = __DIR__;

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/lls-custom-blocks" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'create-block-lls-custom-blocks-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'create-block-lls-custom-blocks-block-editor', 'lls-custom-blocks' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-lls-custom-blocks-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-lls-custom-blocks-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'create-block/lls-custom-blocks', array(
		'editor_script' => 'create-block-lls-custom-blocks-block-editor',
		'editor_style'  => 'create-block-lls-custom-blocks-block-editor',
		'style'         => 'create-block-lls-custom-blocks-block',
	) );
}
add_action( 'init', 'create_block_lls_custom_blocks_block_init' );
