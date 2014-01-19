<?php
/*
Plugin Name: PlayerZBR
Description: PlayerZBR is a player HTML 5 audio streaming.
Version: 1.3
Author: Pedro Laxe
Author URI: http://www.phpsec.com.br/
License: GPLv2

*/

/*      
 *      Copyright 2013 Pedro Laxe <pedrolaxe@gmail.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.

 */

add_action( 'init', 'plx_option' );

function plx_option(){

/**
 * Function Activeate PlayerZBR 
 *
 * @since 1.0
 *
 */

register_activation_hook( __FILE__, 'plx_install_hook' );

/**
 * Function Compare Version of WP else Desactive Plugin
 *
 * @since 1.0
 *
 */
function plx_install_hook() {


  if ( version_compare( PHP_VERSION, '5.2.1', '<' )

    or version_compare( get_bloginfo( 'version' ), '3.3', '<' ) ) {

      deactivate_plugins( basename( __FILE__ ) );

  }

  // Vamos criar um opção para ser guardada na base-de-dados

  // e incluir um valor por defeito.

  add_option( 'plx_option', 'valor_por_defeito' );

}

}
/**
 * Function Add Styles in Header
 *
 * @since 1.3
 *
 */
function Addstyles(){
	$stl = '
<style type="text/css">
/* PlayerZBR CSS */
audio #pl1{
	width:'.get_option('wid').'px;
    height:auto;
		  }

audio{
	width:'.get_option('wid').'px;
    height:auto;
	 }

</style>
';
	echo $stl;
}
add_action('wp_head', 'Addstyles');
/**
 * Function to Create PlayerZBR 
 *
 * @since 1.0
 *
 */
function add_player(){

	$player1 = '

<div class="playerzbr">

	<audio controls '.get_option('autoplay').'>

  <source src="'.get_option('url').'" type="audio/mpeg">

  <source src="'.get_option('url').'" type="audio/ogg">

  Your browser does not support the audio element.

	</audio>

</div>

	';

	return $player1;

}
/**
 * Admin Page Functions
 *
 * @since 1.0
 *
 */
if ( is_admin() )
{
	add_action('admin_menu', 'plx_pagina_opcoes');

}
/**
 * Function add Page Options in WP Menu 
 *
 * @since 1.0
 *
 */
function plx_pagina_opcoes() {

  add_menu_page( 'PlayerZBR', 'PlayerZBR', 'manage_options', 'PlayerZBR-options', 'plx_pagina_opcoes_content' );

  add_submenu_page('PlayerZBR-options', 'Plugin Information', 'Plugin Information', 8, 'PlayerZBR-info' ,'plx_pag_info');  

}
/**
 * Function include PlayerZBR Info Page
 *
 * @since 1.2
 *
 */
function plx_pag_info(){

	include "info.php";

}

/**
 * Function add Shortcode of PlayerZBR 
 *
 * @since 1.0
 *
 */

add_shortcode('playerzbr', 'add_player');

/**
 * Admin Page Options
 *
 * @since 1.0
 *
 */

function plx_pagina_opcoes_content() {

?>
<link rel="stylesheet" href="<?php echo plugins_url( 'js/bootstrap.min.css' , __FILE__ ); ?>" type="text/css">
<script type="text/javascript" src="<?php echo plugins_url( 'js/bootstrap.min.js' , __FILE__ ); ?>"></script>
<div class="corpo">
  <?php screen_icon( 'plugins' ); ?>
  <h2>PlayerZBR Options</h2>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>
    <p>
    <table width="800" border="0">
      <tr>
        <td><font size="2"><strong>URL of Streaming:</strong></font></td>
        <td><font size="2">
          <input type="text" name="url" class="input-xxlarge" placeholder="You URL Here" value="<?php echo get_option('url'); ?>" />
          </font></td>
      </tr>
      <tr>
        <td><font size="2"><strong>Autoplay:</strong></font></td>
        <td><font size="2">
          <select name="autoplay" class="input-mini">
            <option value="autoplay" <?php if(get_option('autoplay')=="autoplay"){echo 'selected="selected"';} ?>>yes</option>
            <option value="" <?php if(get_option('autoplay')==""){echo 'selected="selected"';} ?>>no</option>
          </select>
          &nbsp;Choice for yes or no</font></td>
      </tr>
      <tr>
        <td><font size="2"><strong>Width of Player:</strong></font></td>
        <td><font size="2">
          <input type="text" name="wid" class="input-mini" maxlength="4" placeholder="400" value="<?php echo get_option('wid');?>" />
          PX</font></td>
      </tr>
      <br />
      <tr>
        <td><font size="2">
          <input type="submit" name="botenvia" value="Save Modifications" class="btn btn-primary" />
          </font></td>
      </tr>
    </table>
    <br />
    <br />
    </font>
    </p>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="url,autoplay,wid" />
  </form>
  <br />
  <p>Developed by Pedro Laxe &copy; <?php echo date('Y'); ?> - <a href="http://twitter.com/pedrolaxe">Twitter</a>&nbsp;- <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6WQ566DAC4YF8">Donate Here</a></p>
</div>
<?php
}