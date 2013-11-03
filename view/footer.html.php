<?php
/*
 *  Copyright (C) 2012 Platoniq y Fundación Fuentes Abiertas (see README for details)
 *	This file is part of Goteo.
 *
 *  Goteo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Goteo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with Goteo.  If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

use Goteo\Library\Text,
    Goteo\Model\Category,
    Goteo\Model\Post,
    Goteo\Model\Sponsor;

$lang = (LANG != 'es') ? '?lang='.LANG : '';

$categories = Category::getList();  // categorias que se usan en proyectos
$posts      = Post::getList('footer');
$sponsors   = Sponsor::getList();
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.scroll-pane').jScrollPane({showArrows: true});
});
</script>

    <div id="footer">
		<div class="w940">
        	<div class="block categories">
                <h8 class="title"><?php echo Text::_("Categorías") ?></h8>
                <ul class="scroll-pane">
                <?php foreach ($categories as $id=>$name) : ?>
                    <li><a href="/discover/results/<?php echo $id; ?>"><?php echo $name; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>

            <div class="block projects">
                <h8 class="title"><?php echo Text::_("Proyectos") ?></h8>
                <ul class="scroll-pane">
                    <li><a href="/"><?php echo Text::_("Destacados") ?></a></li>
                    <li><a href="/discover/view/popular"><?php echo Text::_("Más populares") ?></a></li>
                    <li><a href="/discover/view/outdate"><?php echo Text::_("A punto de ser archivado") ?></a></li>
                    <li><a href="/discover/view/recent"><?php echo Text::_("Publicados recientemente") ?></a></li>
                    <li><a href="/discover/view/success"><?php echo Text::_("Exitosos") ?></a></li>
                    <li><a href="/discover/view/archive"><?php echo Text::_("Archivados") ?></a></li>
                    <li><a href="/project/create"><?php echo Text::_("Crea un proyecto") ?></a></li>
                </ul>
            </div>

            <div class="block resources">
                <h8 class="title"><?php echo Text::_("Recursos") ?></h8>
                <ul class="scroll-pane">
                    <li><a href="/faq"><?php echo Text::_("FAQ") ?></a></li>
                    <li><a href="/glossary"><?php echo Text::_("Glosario") ?></a></li>
                    <li><a href="/press"><?php echo Text::_("Prensa") ?></a></li>
                    <?php foreach ($posts as $id=>$title) : ?>
                    <li><a href="/blog/<?php echo $id ?>"><?php echo Text::recorta($title, 50) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
			<script>
				$(function(){
					$('#slides_sponsor').slides({
						container: 'slides_container',
						effect: 'fade', 
						crossfade: false,
						fadeSpeed: 350,
						play: 5000, 
						pause: 1
					});
				});
			</script>
           <div id="slides_sponsor" class="block sponsors">
                <h8 class="title"><?php echo Text::_("Apoyos institucionales") ?></h8>
				<div class="slides_container">
					<?php $i = 1; foreach ($sponsors as $sponsor) : ?>
					<div class="sponsor" id="footer-sponsor-<?php echo $i ?>">
						<a href="<?php echo $sponsor->url ?>" title="<?php echo $sponsor->name ?>" target="_blank"><img src="<?php echo $sponsor->image->getLink(150, 85) ?>" alt="<?php echo $sponsor->name ?>" /></a>
					</div>
					<?php $i++; endforeach; ?>
				</div>
				<div class="slidersponsors-ctrl">
					<a class="prev">prev</a>
					<ul class="paginacion"></ul>
					<a class="next">next</a>
				</div>
            </div>

            <div class="block services">
                
                <h8 class="title"><?php echo Text::_("Servicios") ?></h8>
                <ul>
                    <li><a href="/service/resources"><?php echo Text::_("Capital riego") ?></a></li>
<?php /*                    <li><a href="/service/campaign"><?php echo Text::_("Campañas") ?></a></li>
                    <li><a href="/service/consulting"><?php echo Text::_("Consultoría") ?></a></li>
 *
 */ ?>
                    <li><a href="/service/workshop"><?php echo Text::_("Talleres") ?></a></li>
                </ul>
                
            </div>
         
            <div class="block social" style="border-right:#ebe9ea 2px solid;">
                <h8 class="title"><?php echo Text::_("Síguenos") ?></h8>
                <ul>
                    <li class="twitter"><a href="<?php echo Text::_("http://twitter.com/goteofunding") ?>" target="_blank"><?php echo Text::_("Twitter") ?></a></li>
                    <li class="facebook"><a href="<?php echo Text::_("http://www.facebook.com/pages/Goteo/268491113192109") ?>" target="_blank"><?php echo Text::_("Facebook") ?></a></li>
                    <li class="identica"><a href="<?php echo Text::_("http://identi.ca/goteofunding") ?>" target="_blank"><?php echo Text::_("Identi.ca") ?></a></li>
                    <li class="gplus"><a href="<?php echo Text::_("https://plus.google.com/b/116559557256583965659/") ?>" target="_blank"><?php echo Text::_("Google+") ?></a></li>
                    <li class="rss"><a rel="alternate" type="application/rss+xml" title="RSS" href="/rss<?php echo $lang ?>" target="_blank"><?php echo Text::_("RSS/BLOG"); ?></a></li>

                </ul>
            </div>

		</div>
    </div>

    <div id="sub-footer">
		<div class="w940">
		
           
                
                <ul>
                    <li><a href="/about"><?php echo Text::_("Sobre Goteo"); ?></a></li>
                    <li><a href="/user/login"><?php echo Text::_("Accede"); ?></a></li>
                    <li><a href="/contact"><?php echo Text::_("Contacto"); ?></a></li>
<!--                    <li><a href="/blog"><?php echo Text::_("Blog"); ?></a></li> -->
<!--                    <li><a href="/about/legal"><?php echo Text::_("Términos legales"); ?></a></li> -->
                    <li><a href="/legal/terms"><?php echo Text::_("Condiciones de uso"); ?></a></li>
                    <li><a href="/legal/privacy"><?php echo Text::_("Política de privacidad"); ?></a></li>
                </ul>
    
                <div class="platoniq">
                   <span class="text"><a href="#" class="poweredby"><?php echo Text::_("Una iniciativa de:") ?></a></span>
                   <span class="logo"><a href="http://fuentesabiertas.org" target="_blank" class="foundation">FFA</a></span>
                   <span class="logo"><a href="http://www.youcoop.org" target="_blank" class="growby">Platoniq</a></span>
                </div>
    
       
        </div>

    </div>