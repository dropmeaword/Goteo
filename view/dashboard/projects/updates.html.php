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

$level = $this['level'] = 3;

$url = '/dashboard/projects/updates';

if ($this['action'] == 'none') return;

?>
<?php if ($this['action'] == 'list') : ?>
<div class="widget">
    <?php if (!empty($blog->id) && $blog->active) : ?>
<a class="button" href="<?php echo $url; ?>/add"><?php echo Text::_("Publicar nueva entrada");?></a>
    <?php endif; ?>

    <!-- lista -->
    <?php if (!empty($posts)) : ?>
    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <a class="button" href="<?php echo $url; ?>/edit/<?php echo $post->id; ?>"><?php echo Text::_("Editar") ?></a>&nbsp;&nbsp;&nbsp;
<a class="remove button weak" href="<?php echo $url; ?>/delete/<?php echo $post->id; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta actualización?');"><?php echo Text::_("Eliminar");?></a>
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
        $allow = array(
            array(
                'value'     => 1,
                'label'     => Text::_("Sí")
                ),
            array(
                'value'     => 0,
                'label'     => Text::_("No")
                )
        );

        $images = array();
        foreach ($post->gallery as $image) {
            $images[] = array(
                'type'  => 'html',
                'class' => 'inline gallery-image',
                'html'  => is_object($image) ?
                           $image . '<img src="'.SRC_URL.'/image/'.$image->id.'/128/128" alt="Imagen" /><button class="image-remove weak" type="submit" name="gallery-'.$image->id.'-remove" title="Quitar imagen" value="remove"></button>' :
                           ''
            );

        }

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

    <form method="post" action="/dashboard/projects/updates/<?php echo $this['action']; ?>/<?php echo $post->id; ?>" class="project" enctype="multipart/form-data">

    <?php echo new SuperForm(array(

        'action'        => '',
        'level'         => $this['level'],
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
            'title' => array(
                'type'      => 'textbox',
                'required'  => true,
                'size'      => 20,
                'title'     => Text::_("Título"),
                'hint'      => Text::_("tooltip-updates-title"),
                'errors'    => !empty($errors['title']) ? array($errors['title']) : array(),
                'value'     => $post->title,
            ),
            'text' => array(
                'type'      => 'textarea',
                'required'  => true,
                'cols'      => 40,
                'rows'      => 4,
                            'title'     => Text::_("Texto de la entrada"),
                'hint'      => Text::_("tooltip-updates-text"),
                'errors'    => !empty($errors['text']) ? array($errors['text']) : array(),
                'value'     => $post->text
            ),
            'image' => array(
                'title'     => 'Imagen',
                'type'      => 'group',
                'hint'      => Text::_("tooltip-updates-image"),
                'errors'    => !empty($errors['image']) ? array($errors['image']) : array(),
                'class'     => 'image',
                'children'  => array(
                    'image_upload'    => array(
                        'type'  => 'file',
                        'label' => Text::_("Subir imagen"),
                        'class' => 'inline image_upload',
                        'title' => Text::_("Subir una imagen"),
                        'hint'  => Text::_("tooltip-updates-image_upload"),
                    )
                )
            ),

            'gallery' => array(
                'type'  => 'group',
                'title' => Text::_("Imágenes actuales"),
                'class' => 'inline',
                'children'  => $images
            ),

            'media' => array(
                'type'      => 'textbox',
                'title'     => Text::_("Vídeo"),
                'class'     => 'media',
                'hint'      => Text::_("tooltip-updates-media"),
                'errors'    => !empty($errors['media']) ? array($errors['media']) : array(),
                'value'     => (string) $post->media
            ),
            
            'media-upload' => array(
                'name' => "upload",
                'type'  => 'submit',
                'label' => Text::_("Enviar"),
                'class' => 'inline media-upload'
            ),

            'media-preview' => $media,

            'legend' => array(
                'type'      => 'textarea',
                'title'     => Text::_("Leyenda"),
                'value'     => $post->legend,
            ),
            "date" => array(
                'type'      => 'datebox',
                'required'  => true,
                'title'     => Text::_("Fecha de publicación"),
                'hint'      => Text::_("tooltip-updates-date"),
                'size'      => 8,
                'value'     => $post->date
            ),
            'allow' => array(
                'title'     => Text::_("Permite comentarios"),
                'type'      => 'slider',
                'options'   => $allow,
                'class'     => 'currently cols_' . count($allow),
                'hint'      => Text::_("tooltip-updates-allow_comments"),
                'errors'    => !empty($errors['allow']) ? array($errors['allow']) : array(),
                'value'     => (int) $post->allow
            ),
            'publish' => array(
                'title'     => 'Publicado',
                'type'      => 'slider',
                'options'   => $allow,
                'class'     => 'currently cols_' . count($allow),
                'hint'      => ,
                'errors'    => !empty($errors['publish']) ? array($errors['publish']) : array(),
                'value'     => (int) $post->publish
            )

        )

    ));
    ?>

    </form>

<?php endif; ?>