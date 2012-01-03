<?php
/**
 * Gapps Login
 *
 * @package GAppsLogin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
?>
<p>
  <label for="params[domain]"><?php echo elgg_echo('gappslogin:settings:domain');?></label><br/>
  <p> <?php echo elgg_echo('gappslogin:domainexplanation'); ?></p>
  <input type="text" size="50" name="params[domain]" value="<?php echo $vars['entity']->domain;?>"/><br/>
</p>