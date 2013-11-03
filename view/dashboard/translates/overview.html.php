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

$project = $this['project'];
$errors = $this['errors'];

$original = \Goteo\Model\Project::get($project->id);

// media del proyecto
if (!empty($project->media->url)) {
    $media = array(
            'type'  => 'media',
            'title' => Text::_("Vista previa"),
            'class' => 'inline media',
            'type'  => 'html',
            'html'  => !empty($project->media) ? $project->media->getEmbedCode() : ''
    );
} else {
    $media = array(
        'type'  => 'hidden',
        'class' => 'inline'
    );
}

// video de motivacion
if (!empty($project->video->url)) {
    $video = array(
            'type'  => 'media',
            'title' => Text::_("Vista previa"),
            'class' => 'inline media',
            'type'  => 'html',
            'html'  => !empty($project->video) ? $project->video->getEmbedCode() : ''
    );
} else {
    $video = array(
        'type'  => 'hidden',
        'class' => 'inline'
    );
}



?>

<form method="post" action="<?php echo SITE_URL ?>/dashboard/translates/overview/save" class="project" enctype="multipart/form-data">

<?php echo new SuperForm(array(
    'level'         => 3,
    'action'        => '',
    'method'        => 'post',
    'title'         => '',
    'hint'          => Text::_("<strong>Éste es el apartado donde explicar con detalle los aspectos conceptuales del proyecto. </strong><br><br>Es lo primero con lo que cualquier usuario de la red se encontrará, así que cuida la redacción y evita las faltas de ortografía. Verás que hay campos obligatorios como incluir un vídeo o subir imágenes. Esto es así porque los consideramos imprescindibles para empezar con éxito una campaña de recaudación de fondos mediante Goteo.<br><br>\r\nTen en cuenta que lo más valorado en Goteo es: la información o conocimiento libre de interés general que tu proyecto aportará a la comunidad,  la originalidad, aspirar a resolver una demanda social,  el potencial para atraer a una comunidad amplia de personas interesadas, dejar claro que el equipo promotor posee las capacidades y experiencia para poder llevarlo a buen puerto. Así que no pierdas de vista informar sobre esos aspectos."),
    'class'         => 'aqua',
    'footer'        => array(
        'view-step-preview' => array(
            'type'  => 'submit',
            'name'  => 'save-overview',
            'label' => Text::_("Guardar"),
            'class' => 'next'
        )
    ),
    'elements'      => array(
        'process_overview' => array (
            'type' => 'hidden',
            'value' => 'overview'
        ),

        /*
        'name' => array(
            'type'      => 'textbox',
            'title'     => Text::_("Título del proyecto"),
            'required'  => true,
            'hint'      => Text::_("Escribe un nombre para titular el proyecto. Cuanto más breve mejor, para hacerlo más descriptivo puedes ampliarlo en el siguiente apartado."),
            'value'     => $project->name,
            'errors'    => !empty($errors['name']) ? array($errors['name']) : array(),
            'ok'        => !empty($okeys['name']) ? array($okeys['name']) : array()
        ),
        */

        'subtitle-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Frase de resumen"),
            'html'     => $original->subtitle
        ),
        'subtitle' => array(
            'type'      => 'textbox',
            'title'     => '',
            'class'     => 'inline',
            'value'     => $project->subtitle,
            'hint'      => Text::_("Define con una frase un subtítulo que acabe de explicar en qué consistirá la iniciativa, que permita hacerse una idea mínima de para qué sirve o en qué consiste. Aparecerá junto al título del proyecto."),
            'errors'    => array(),
            'ok'        => array()
        ),

        'description-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Breve descripción "),
            'html'     => nl2br($original->description)
        ),
        'description' => array(
            'type'      => 'textarea',
            'title'     => '',
            'class'     => 'inline',
            'hint'      => Text::_("Describe el proyecto con un mínimo de 80 palabras (con menos marcará error). Explícalo de modo que sea fácil de entender para cualquier persona. Intenta darle un enfoque atractivo y social, resumiendo sus puntos fuertes, qué lo hace único, innovador o especial."),
            'value'     => $project->description,
            'errors'    => array(),
            'ok'        => array()
        ),
        'description_group' => array(
            'type' => 'group',
            'children'  => array(
                'about-orig' => array(
                    'type'      => 'html',
                    'title'     => Text::_("Características básicas"),
                    'html'     => $original->about
                ),
                'about' => array(
                    'type'      => 'textarea',
                    'title'     => '',
                    'class'     => 'inline',
                    'hint'      => Text::_("Describe brevemente el proyecto de modo conceptual, técnico o práctico. Por ejemplo detallando sus características de funcionamiento, o en qué partes consistirá. Piensa en cómo será una vez acabado y todo lo que la gente podrá hacer con él."),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => $project->about
                ),
                'motivation-orig' => array(
                    'type'      => 'html',
                    'title'     => Text::_("Motivación y a quién va dirigido el proyecto"),
                    'html'     => nl2br($original->motivation)
                ),
                'motivation' => array(
                    'type'      => 'textarea',
                    'title'     => '',
                    'class'     => 'inline',
                    'hint'      => Text::_("Explica qué motivos o circunstancias te han llevado a idear el proyecto, así como las comunidades o usuarios a las que va destinado. Te ayudará a conectar con personas movidas por ese mismo tipo de intereses, problemáticas o gustos."),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => $project->motivation
                ),
                // video motivacion
                'video-orig' => array(
                    'type'      => 'html',
                    'title'     => Text::_("Vídeo adicional sobre motivación"),
                    'html'     => (string) $original->video->url
                ),

                'video' => array(
                    'type'      => 'textbox',
                    'hint'      => Text::_("Considera aquí la posibilidad de publicar y enlazar un vídeo (en Youtube o Vimeo) donde expliques brevemente a la cámara el porqué de tu proyecto. Se trata de algo que pueda complementar el vídeo principal, con una persona que transmita su necesidad u originalidad, del modo más directo posible. Si te da corte hablar a la cámara, también puede ser alguna persona que conoces y sigue el proyecto o la idea y pueda hacer esta aportación como "fan". La empatía y necesidad de ver a alguien al otro lado del proyecto es muy importante para determinado tipo de cofinanciadores. "),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => (string) $project->video
                ),

                'video-upload' => array(
                    'name' => "upload",
                    'type'  => 'submit',
                    'label' => Text::_("Enviar"),
                    'class' => 'inline media-upload'
                ),

                'video-preview' => $video
                ,
                // fin video motivacion
                'goal-orig' => array(
                    'type'      => 'html',
                    'title'     => Text::_("Objetivos de la campaña de crowdfunding"),
                    'html'     => nl2br($original->goal)
                ),
                'goal' => array(
                    'type'      => 'textarea',
                    'title'     => '',
                    'class'     => 'inline',
                    'hint'      => Text::_("Enumera las metas principales del proyecto, a corto y largo plazo, en todos los aspectos que consideres importante destacar. Se trata de otra oportunidad para contactar y conseguir el apoyo de gente que simpatice con esos objetivos."),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => $project->goal
                ),
                'related-orig' => array(
                    'type'      => 'html',
                    'title'     => Text::_("Experiencia previa y equipo"),
                    'html'     => nl2br($original->related)
                ),
                'related' => array(
                    'type'      => 'textarea',
                    'title'     => '',
                    'class'     => 'inline',
                    'hint'      => Text::_("Resume tu trayectoria o la del grupo impulsor del proyecto. ¿Qué experiencia tiene relacionada con la propuesta? ¿Con qué equipo de personas, recursos y/o infraestructuras cuenta? "),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => $project->related
                )
            )
        ),

        'keywords-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Palabras clave del proyecto"),
            'html'     => $original->keywords
        ),
        'keywords' => array(
            'type'      => 'textbox',
            'title'     => '',
            'class'     => 'inline',
            'hint'      => Text::_("A medida que introduzcas texto el sistema te sugerirá palabras clave que ya han escrito otros usuarios. Estas categorías ayudan a vincular tu proyecto con personas afines."),
            'errors'    => array(),
            'ok'        => array(),
            'value'     => $project->keywords
        ),

        'media-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Vídeo de presentación"),
            'html'     => (string) $original->media->url
        ),

        'media' => array(
            'type'      => 'textbox',
            'title'     => '',
            'class'     => 'inline',
            'hint'      => Text::_("Copia y pega la dirección URL de un vídeo de presentación del proyecto, publicado previamente en Youtube o Vimeo. Esta parte es fundamental para atraer la atención de potenciales cofinanciadores y colaboradores, y cuanto más original sea mejor. Te recomendamos que tenga una duración de entre 2 y 4 minutos. "),
            'errors'    => array(),
            'ok'        => array(),
            'value'     => (string) $project->media
        ),

        'media-upload' => array(
            'name' => "upload",
            'type'  => 'submit',
            'label' => Text::_("Enviar"),
            'class' => 'inline media-upload'
        ),

        'media-preview' => $media

    )

));
?>
</form>