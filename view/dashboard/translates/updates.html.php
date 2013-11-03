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

use Goteo\Core\View,
    Goteo\Library\Text,
    Goteo\Library\SuperForm;

define('ADMIN_NOAUTOSAVE', true);

$blog  = $this['blog'];
$posts = $this['posts'];

$errors = $this['errors'];

?>
<?php if ($this['action'] == 'list') : ?>
<div class="widget">
    <!-- lista -->
    <?php if (!empty($posts)) : ?>
    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <a class="button" href="/dashboard/translates/updates/edit/<?php echo $post->id; ?>"><?php echo Text::_("Editar") ?></a>&nbsp;&nbsp;&nbsp;
            <span><?php echo $post->publish ? Text::_("Publicado") : Text::_("Borrador"); ?></span>
            <strong><?php echo $post->title; ?></strong>
            <span><?php echo $post->date; ?></span>
        </div>
    <?php endforeach; ?>
    <?php else : ?>
        <p><?php echo Text::_("No se ha publicado ninguna entrada ") ?></p>
    <?php endif; ?>

</div>

<?php  else : // sueprform!

        $post  = $this['post']; // si edit
        $original = \Goteo\Model\Blog\Post::get($post->id);


        if (!empty($post->media->url)) {
            $media = array(
                    'type'  => 'media',
                    'title' => Text::_("Vista previa"),
                    'class' => 'inline media',
                    'type'  => 'html',
                    'html'  => !empty($post->media) ? $post->media->getEmbedCode() : ''
            );
        } else {
            $media = array(
                'type'  => 'hidden',
                'class' => 'inline'
            );


        }


    ?>

    <form method="post" action="/dashboard/translates/updates/save/<?php echo $post->id; ?>" class="project" enctype="multipart/form-data">

    <?php echo new SuperForm(array(

        'action'        => '',
        'level'         => 3,
        'method'        => 'post',
        'title'         => '',
        'hint'          => Text::_("<b>Es muy importante que los proyectos mantengan informados a sus cofinanciadores y el resto de personas potencialmente interesadas sobre cómo avanza su campaña. Desde este apartado puedes publicar mensajes de actualización sobre el proyecto, como una especie de blog público.</b>\r\n\r\nEn Goteo además, una vez se han logrado los fondos mínimos, para la segunda ronda de cofinanciación es crítico explicar regularmente cómo ha arrancado la producción, avances, problemas, etc que permitan la mayor transparencia posible y saber cómo evoluciona el inicio del proyecto, para así tratar de generar más interés y comunidad en torno al mismo."),
        'class'         => 'aqua',
        'footer'        => array(
            'view-step-preview' => array(
                'type'  => 'submit',
                'name'  => 'save-post',
                'label' => Text::_("Guardar"),
                'class' => 'next'
            )
        ),
        'elements'      => array(
            'id' => array (
                'type' => 'hidden',
                'value' => $post->id
            ),
            'blog' => array (
                'type' => 'hidden',
                'value' => $post->blog
            ),
            'title-orig' => array(
                'type'      => 'html',
                'title'     => 'Título',
                'html'      => $original->title,
            ),
            'title' => array(
                'type'      => 'textbox',
                'size'      => 20,
                'class'     => 'inline',
                'title'     => '',
                'hint'      => Text::_("tooltip-updates-title"),
                'errors'    => array(),
                'value'     => $post->title,
            ),
            'text-orig' => array(
                'type'      => 'html',
                'title'     => 'Texto de la entrada',
                'html'      => nl2br($original->text)
            ),
            'text' => array(
                'type'      => 'textarea',
                'cols'      => 40,
                'rows'      => 4,
                'class'     => 'inline',
                'title'     => '',
                'hint'      => Text::_("tooltip-updates-text"),
                'errors'    => array(),
                'value'     => $post->text
            ),

            'media-orig' => array(
                'type'      => 'html',
                'title'     => 'Vídeo',
                'html'     => (string) $original->media->url
            ),
            'media' => array(
                'type'      => 'textbox',
                'title'     => '',
                'class'     => 'inline media',
                'hint'      => Text::_("tooltip-updates-media"),
                'errors'    => array(),
                'value'     => (string) $post->media
            ),
            
            'media-upload' => array(
                'name' => "upload",
                'type'  => 'submit',
                'label' => Text::_("Enviar"),
                'class' => 'inline media-upload'
            ),

            'media-preview' => $media,

            'legend-orig' => array(
                'type'      => 'html',
                'title'     => Text::_("Leyenda"),
                'html'     => nl2br($original->legend),
            ),
            'legend' => array(
                'type'      => 'textarea',
                'title'     => '',
                'class'     => 'inline',
                'value'     => $post->legend,
            )

        )

    ));
    ?>

    </form>

<?php endif; ?>