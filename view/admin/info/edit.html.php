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
    Goteo\Model,
    Goteo\Core\Redirection,
    Goteo\Library\SuperForm;

define('ADMIN_NOAUTOSAVE', true);

$post = $this['post'];

if (!$post instanceof Model\Info) {
    throw new Redirection('/admin/info');
}

// Superform
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
                       $image . '<img src="'.SRC_URL.'/image/'.$image->id.'/128/128" alt="'.Text::_("Imagen").'" /><button class="image-remove weak" type="submit" name="gallery-'.$image->id.'-remove" title="'.Text::_("Quitar imagen").'" value="remove"></button>' :
                       ''
        );

    }

?>
<script type="text/javascript" src="/view/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	// Lanza wysiwyg contenido
	CKEDITOR.replace('text_editor', {
		toolbar: 'Full',
		toolbar_Full: [
				['Source','-'],
				['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
				['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
				'/',
				['Bold','Italic','Underline','Strike'],
				['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Link','Unlink','Anchor'],
                ['Image','Format','FontSize'],
			  ],
		skin: 'kama',
		language: 'es',
		height: '300px',
		width: '675px'
	});
});
</script>

<form method="post" action="/admin/info/<?php echo $this['action']; ?>/<?php echo $post->id; ?>" class="project" enctype="multipart/form-data">

    <?php echo new SuperForm(array(

        'action'        => '',
        'level'         => 3,
        'method'        => 'post',
        'title'         => '',
        'hint'          => Text::_("Idea de about: descripción, imágenes y media (vimeo, youtube, presi, slideshare), publiar"),
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
            'order' => array (
                'type' => 'hidden',
                'value' => $post->order
            ),
            'node' => array (
                'type' => 'hidden',
                'value' => $post->node
            ),
            'title' => array(
                'type'      => 'textbox',
                'required'  => true,
                'size'      => 20,
                'title'     => Text::_("Idea"),
                'value'     => $post->title,
            ),
            'text' => array(
                'type'      => 'textarea',
                'required'  => true,
                'cols'      => 40,
                'rows'      => 4,
                'title'     => Text::_("Explicación de la idea"),
                'value'     => $post->text
            ),
            'image' => array(
                'title'     => Text::_("Imagen"),
                'type'      => 'group',
                'hint'      => Text::_("tooltip-updates-image"),
                'errors'    => !empty($errors['image']) ? array($errors['image']) : array(),
                'class'     => 'image',
                'children'  => array(
                    'image_upload'    => array(
                        'type'  => 'file',
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
                'value'     => (string) $post->media,
                'children'  => array(
                    'media-preview' => array(
                        'title' => Text::_("Vista previa"),
                        'class' => 'media-preview inline',
                        'type'  => 'html',
                        'html'  => !empty($post->media) ? $post->media->getEmbedCode() : ''
                    )
                )
            ),
            'legend' => array(
                'type'      => 'textarea',
                'title'     => Text::_("Leyenda"),
                'value'     => $post->legend,
            ),

            'publish' => array(
                'title'     => Text::_("Publicada"),
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