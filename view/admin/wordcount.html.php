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
use Goteo\Library\Text;

$wordcount = $this['wordcount'];

/* Secciones */
$sections = array(
    'texts' => array(
        'label'  => Text::_("Textos interficie"),
        'options' => Text::groups()
    ),
    'pages' => array(
        'label' => Text::_("Páginas institucionales"),
        'options' => array(
            'page' => Text::_("Títulos"),
            'page_node' => Text::_("Contenidos"),
        )
    ),
    'contents' => array(
        'label'   => Text::_("Gestión de Textos y Traducciones"),
        'options' => array (
            'post' => Text::_("Blog"),
            'faq' => Text::_("FAQs"),
            'category' => Text::_("Categorias e Intereses"),
            'license' => Text::_("Licencias"),
            'icon' => Text::_("Tipos de Retorno"),
            'tag' => Text::_("Tags de blog"),
            'criteria' => Text::_("Criterios de revisión"),
            'template' => Text::_("Plantillas de email"),
            'glossary' => Text::_("Glosario"),
            'info' => Text::_("Ideas about"),
            'worthcracy' => Text::_("Meritocracia")
        )
    ),
    'home' => array(
        'label'   => Text::_("Portada"),
        'options' => array (
            'news' => Text::_("Micronoticias"),
            'promote' => Text::_("Proyectos destacados")
        )
    )
);

// campos para las tablas que tienen diferentes campos
$fields = array(
  'category' => array('name','description'),
  'criteria' => array('title','description'),
  'post' => array('title','text','legend'),
  'template' => array('title','text'),
  'glossary' => array('title','text','legend'),
  'info' => array('title','text','legend'),
  'faq' => array('title','description'),
  'icon' => array('name','description'),
  'license' => array('name','description'),
  'news' => array('title','description'),
  'page' => array('name','description'),
  'page_node' => array('page','content'),
  'promote' => array('title','description'),
  'purpose' => array('purpose'),
  'tag' => array('name'),
  'worthcracy' => array('name'),
);

$total = 0;
?>
<div class="widget">
    <h3 class="title"><?php echo Text::_("Conteo de palabras"); ?></h3>
<?php foreach ($sections as $sCode=>$section) : ?>
        <h4><?php echo $section['label'] ?></h4>
        <table>
            <thead>
                <tr>
                    <th><?php echo Text::_("Palabras"); ?></th>
                    <th><?php echo Text::_("Seccion"); ?></th>
                    <th><?php echo Text::_("Codigo"); ?></th>
                </tr>
            </thead>
            <?php foreach ($section['options'] as $oCode=>$option) :
                echo '<tr>
                    <td align="right">'.  Text::wordCount($sCode,$oCode,$fields[$oCode], $total).'</td>
                    <td align="center">'.$option.'</td>
                    <td>'.$oCode.'</td>
                </tr>
                ';
            endforeach; ?>
        </table>
        <hr />
<?php endforeach; ?>
        <h4><?php echo Text::_("Total:"); ?> <?php echo $total ?> <?php echo Text::_("palabras"); ?></h4>
</div>
