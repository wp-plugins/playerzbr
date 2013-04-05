<?php
/*
Plugin Name: PlayerZBR
Description: PlayerZBR is a player HTML 5 audio streaming.
Version: 1.2.1
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
// Registamos a função para correr na ativação do plugin
register_activation_hook( __FILE__, 'plx_install_hook' );
//funcao de desativar o plugin
function plx_install_hook() {
  // Vamos testar a versão do PHP e do WordPress
  // caso as versões sejam antigas, desativamos
  // o nosso plugin.
  if ( version_compare( PHP_VERSION, '5.2.1', '<' )
    or version_compare( get_bloginfo( 'version' ), '3.3', '<' ) ) {
      deactivate_plugins( basename( __FILE__ ) );
  }
 
  // Vamos criar um opção para ser guardada na base-de-dados
  // e incluir um valor por defeito.
  add_option( 'plx_option', 'valor_por_defeito' );
 
}
}	
/*** Function add PlayerZBR ***/
function add_player(){
	
	
	$player1 = '
<style type="text/css">

audio #pl1{
	width:'.get_option('wid').'px;
    height:auto;
}

audio{
	width:'.get_option('wid').'px;
    height:auto;
}

</style>
	

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
/*******Admin Functions*******/

if ( is_admin() )

{

	add_action('admin_menu', 'plx_pagina_opcoes');

}

function plx_pagina_opcoes() {
  // criamos a pagina de opções com esta função
  add_menu_page( 'PlayerZBR', 'PlayerZBR', 'manage_options', 'PlayerZBR-options', 'plx_pagina_opcoes_content' );
  add_submenu_page('PlayerZBR-options', 'Plugin Information', 'Plugin Information', 8, 'PlayerZBR-info' ,'plx_pag_info');  
}

function plx_pag_info(){
	include "info.php";
}
//add o shortcode
add_shortcode('playerzbr', 'add_player');
/******* Page Playerzbr options *******/
function plx_pagina_opcoes_content() {
?>
<div class="corpo">
  <?php screen_icon( 'plugins' ); ?>
  <h2>Painel PlayerZBR</h2>
 
 <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?><p>
  <table width="800" border="0">
  <tr>
    <td><font size="2"><strong>URL de Streaming:</strong></font></td>
    <td><font size="2"><input type="text" name="url" size="80" placeholder="You URL Here" value="<?php echo get_option('url'); ?>" /></font></td>
  </tr>
  <tr>
    <td><font size="2"><strong>Autoplay:</strong></font></td>
    <td><font size="2"><select name="autoplay">
                	<option value="autoplay" <?php if(get_option('autoplay')=="autoplay"){echo 'selected="selected"';} ?>>yes</option>
                    <option value="" <?php if(get_option('autoplay')==""){echo 'selected="selected"';} ?>>no</option></select>&nbsp;Choice for yes or no</font>
   </td>
  </tr>
  <tr>
     <td><font size="2"><strong>Width of Player:</strong></font></td>
  	<td><font size="2"><input type="text" name="wid" size="3" maxlength="4" placeholder="400" value="<?php echo get_option('wid');?>" />PX</font></td>
  </tr>
  <br />

  <tr>
    <td><font size="2"><input type="submit" name="botenvia" value="Save Modifications" /></font></td>
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
  <p>Developed by Pedro Laxe &copy; 2013 - <a href="https://facebook.com/pedrolaxe">Facebook</a> - <a href="http://twitter.com/pedrolaxe">Twitter</a>&nbsp;- <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6WQ566DAC4YF8">Donate Here</a></p>
</div>
<?php
}