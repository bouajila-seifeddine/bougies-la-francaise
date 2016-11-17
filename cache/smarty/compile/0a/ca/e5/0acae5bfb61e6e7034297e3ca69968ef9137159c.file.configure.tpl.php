<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:39:58
         compiled from "/home/bougies-la-francaise/public_html/modules/socolissimo/views/templates/admin/configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2077620117582d7aee25a2c9-66036554%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0acae5bfb61e6e7034297e3ca69968ef9137159c' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/socolissimo/views/templates/admin/configure.tpl',
      1 => 1478104348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2077620117582d7aee25a2c9-66036554',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_dir' => 0,
    'colissimo_version' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7aee28bd33_12204600',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7aee28bd33_12204600')) {function content_582d7aee28bd33_12204600($_smarty_tpl) {?>
<div class="panel">
    <div class="row colissimo-header">
        <div class="col-md-1 text-center logo">
            <img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
views/img/colissimo.png" id="colissimo-logo" />
        </div>
        <div class="col-md-6 about">
            <h4><?php echo smartyTranslate(array('s'=>'About Socolissimo Simplicité','mod'=>'socolissimo'),$_smarty_tpl);?>
 <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['colissimo_version']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</h4>
            Une solution gratuite sans développement, facile à implémenter depuis votre back-office Prestashop.
            <ul>
                <li>Une page de livraison « iframe » qui reste dans la continuité du site garantissant ainsi une continuité dans le processus d’achat.</li>
                <li>Un large choix de modes de livraison pour satisfaire vos e-acheteurs.</li>
                <li>Un chiffre d’affaires additionnel grâce à l’offre Colissimo vers l'Europe</li>
                <li>Un accès offert à un espace client dédié sur la « Colissimo Box » et à un outil de suivi de vos expéditions : ColiView.</li>
                <li>Une version mobile du module pour assurer une complémentarité et un relai d’achat tout au long de la journée. Vous captez ainsi des ventes supplémentaires grâce à votre présence multicanale.</li>
            </ul>
            <em class="text-muted small">
                NB : Ce module s’adresse aux marchands disposant d’un numéro SIRET.
            </em>
        </div>

        <div class="col-md-2 text-center subscribe">
            <h5 class="text-branded"><?php echo smartyTranslate(array('s'=>'Subcribe to the Colissimo Simplicity offer','mod'=>'socolissimo'),$_smarty_tpl);?>
</h5>
            <?php echo smartyTranslate(array('s'=>'By phone, Call','mod'=>'socolissimo'),$_smarty_tpl);?>

            <h4 class="text-branded">3634</h4>
            <?php echo smartyTranslate(array('s'=>'By using our','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/>
            <h6><a href="https://www.colissimo.entreprise.laposte.fr/fr/contact" target="_blank"><?php echo smartyTranslate(array('s'=>'Contact formula','mod'=>'socolissimo'),$_smarty_tpl);?>
</a></h6>
        </div>
        <div class="col-md-3 text-center support">
            <h4><?php echo smartyTranslate(array('s'=>'Need support ?','mod'=>'socolissimo'),$_smarty_tpl);?>
</h4>
            <?php echo smartyTranslate(array('s'=>'Don\'t hesitate to read the','mod'=>'socolissimo'),$_smarty_tpl);?>
 
            <h5><a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/readme_fr.pdf" target="_blank"><b><?php echo smartyTranslate(array('s'=>'Vendor manual','mod'=>'socolissimo'),$_smarty_tpl);?>
</b></a></h5> 
            <?php echo smartyTranslate(array('s'=>'to help you to configure the module','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/>
            <p><?php echo smartyTranslate(array('s'=>'You can also call the Hotline at','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/>
                <strong class="text-branded">0825 086 005</strong><br/>
                <em class="text-muted small">
                    <?php echo smartyTranslate(array('s'=>'Monday to Friday, from 8am to 6pm.','mod'=>'socolissimo'),$_smarty_tpl);?>
. <br/>
                    <?php echo smartyTranslate(array('s'=>'Say "Incident", and "Web Solutions" in the voice menu','mod'=>'socolissimo'),$_smarty_tpl);?>

                </em>
            </p>
        </div>

    </div>
</div><?php }} ?>
