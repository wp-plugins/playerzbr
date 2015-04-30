<?php

/*

Plugin Name: PlayerZBR

Description: PlayerZBR is the best HTML5 responsive player.

Version: 1.5.1

Author: Pedro Laxe

Author URI: http://www.phpsec.com.br/

License: GPLv2

*/

/*      

 *      Copyright 2015 Pedro Laxe <pedrolaxe@gmail.com>

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

$versionzbr = '1.5.1';

add_action( 'init', 'plx_option' );

function plx_option(){

/**

 * Function Activate PlayerZBR 

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

 * Function to Create PlayerZBR 

 *

 * @since 1.0

 *

 * Update 1.4 - Create multiples players on shortcode method
 * Update 1.5.1 - Added preload function to fix chrome bug

 */

 function ver_autoplay($autoplay){

	 if($autoplay=="no"){
		 }elseif($autoplay=="yes"){
		 	return "autoplay";
		}

 }

function add_player($atts, $content = null) {

    extract(shortcode_atts(array(

        'url' => '',

		'autoplay' => '',

                    ), $atts));

    if (empty($url)) {

        return '<div style="color:red;font-weight:bold;">Playerzbr Error! You must enter the mp3 file URL OR URL of streaming parameter in this shortcode. Please check the documentation and correct the mistake.</div>';

    }if(empty($autoplay)){

		$autoplay = 'no';

	}

	$player = '
	<audio controls '.ver_autoplay($autoplay).' preload="auto">
  <source src="'.$url.'" type="audio/mpeg">
  <source src="'.$url.'" type="audio/ogg">
  Your browser does not support the audio element.
	</audio>
	';

	return $player;

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

}

/**
*
* Scripts on Footer
*
* @since 1.5
*/
function Activate_player() {
    echo '
<script type="text/javascript">
$( "audio" ).audioPlayer(
{
    classPrefix: "audioplayer",
    strPlay: "Play",
    strPause: "Pause",
    strVolume: "Volume"
});
</script>
	
	';
}
add_action('wp_footer', 'Activate_player');
/**

 * Function add Shortcode of PlayerZBR 

 *

 * @since 1.0

 *

 */

add_shortcode('playerzbr', 'add_player');

/**
*
* Function Add Scripts
*
* @since 1.5
*/
function Playerzbr_scripts()
{
    // Deregister the included library
    wp_deregister_script( 'jquery' );
     
    // Register the library again from Google's CDN
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', array(), null, false );
     
    // Register the script like this for a plugin:
    wp_register_script( 'playerzbr-script', plugins_url( '/js/playerzbr.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    wp_register_script( 'playerzbr-scriptt', get_template_directory_uri() . '/js/playerzbr.js', array( 'jquery' ) );
 
	wp_register_style('playerzbr-script', plugins_url('css/playerzbr.css',__FILE__ ));
	wp_enqueue_style('playerzbr-script');
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'playerzbr-script' );
	
}
add_action( 'wp_enqueue_scripts', 'Playerzbr_scripts' );
/**

 * Admin Page Options

 *

 * @since 1.0

 *

 */



function plx_pagina_opcoes_content() {

?>

<div class="corpo">
<?php screen_icon( 'plugins' ); ?>
<h2>PlayerZBR Options</h2>
<div class="corpo-info" style="margin-left:10px; margin-top:10px;">
  <p align="center">
  <table width="250" border="0">
    <tr>
      <td><strong>Plugin Developer:</strong></td>
      <td><a href="http://phpsec.com.br">Pedro Laxe</a></td>
    </tr>
    <tr>
      <td><strong>Plugin Version:</strong></td>
      <td><?php global $versionzbr; echo $versionzbr; ?></td>
    </tr>
    <tr>
      <td><strong>Wordpress version:</strong></td>
      <td><?php global $wp_version; echo $wp_version; ?></td>
    </tr>
    <tr>
      <td><strong>MySQL Version:</strong></td>
      <td><?php echo mysql_get_server_info(); ?></td>
    </tr>
    <tr>
      <td><strong>PHP Version:</strong></td>
      <td><?php echo phpversion(); ?></td>
    </tr>
    <tr>
  </table>
  <br />
  <table width="800" border="0">
    <tr>
      <td><font size="2"><strong>Usage methods:</strong></font></td>
      <td><p><font size="2">Text mode: &#91;playerzbr url="Your URL"&#93; &nbsp;&nbsp;|&nbsp;&nbsp; PHP mode: &#60;?php echo do_shortcode( '&#91;playerzbr url="Your URL"&#93;' ); ?&#62;</font></p></td>
    </tr>
    <tr>
      <td><strong>Options:</strong></td>
      <td><p>For Autoplay option use: [playerzbr url="YOUR URL" autoplay="yes"]<br>
          For Music only use: [playerzbr url="Your URL"] </p></td>
    </tr>
  </table>
  <br />
  <br />
  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6WQ566DAC4YF8"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="donate"></a>
  </p>
</div>
<?php
}