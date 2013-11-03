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
$errors = $project->errors[$this['step']] ?: array();
$okeys  = $project->okeys[$this['step']] ?: array();

$images = array();
foreach ($project->gallery as $image) {
    $images[] = array(
        'type'  => 'html',
        'class' => 'inline gallery-image',
        'html'  => is_object($image) ?
                   $image . '<img src="'.SRC_URL.'/image/'.$image->id.'/128/128" alt="Imagen" /><button class="image-remove weak" type="submit" name="gallery-'.$image->id.'-remove" title="Quitar imagen" value="remove"></button>' :
                   ''
    );

}


$categories = array();

foreach ($this['categories'] as $value => $label) {
    $categories[] =  array(
        'value'     => $value,
        'label'     => $label,
        'checked'   => in_array($value, $project->categories)
        );            
}

$currently = array();

foreach ($this['currently'] as $value => $label) {
    $currently[] =  array(
        'value'     => $value,
        'label'     => $label        
        );            
}

$scope = array();

foreach ($this['scope'] as $value => $label) {
    $scope[] =  array(
        'value'     => $value,
        'label'     => $label
        );
}

// media del proyecto
if (!empty($project->media->url)) {
    $media = array(
            'type'  => 'media',
            'title' => Text::_("Vista previa"),
            'class' => 'inline media',
            'type'  => 'html',
            'html'  => !empty($project->media) ? $project->media->getEmbedCode($project->media_usubs) : ''
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
            'html'  => !empty($project->video) ? $project->video->getEmbedCode($project->video_usubs) : ''
    );
} else {
    $video = array(
        'type'  => 'hidden',
        'class' => 'inline'
    );
}


$superform = array(
    'level'         => $this['level'],
    'action'        => '',
    'method'        => 'post',
    'title'         => Text::_("Descripción del proyecto"),
    'hint'          => Text::_("<strong>Éste es el apartado donde explicar con detalle los aspectos conceptuales del proyecto. </strong><br><br>Es lo primero con lo que cualquier usuario de la red se encontrará, así que cuida la redacción y evita las faltas de ortografía. Verás que hay campos obligatorios como incluir un vídeo o subir imágenes. Esto es así porque los consideramos imprescindibles para empezar con éxito una campaña de recaudación de fondos mediante Goteo.<br><br>\r\nTen en cuenta que lo más valorado en Goteo es: la información o conocimiento libre de interés general que tu proyecto aportará a la comunidad,  la originalidad, aspirar a resolver una demanda social,  el potencial para atraer a una comunidad amplia de personas interesadas, dejar claro que el equipo promotor posee las capacidades y experiencia para poder llevarlo a buen puerto. Así que no pierdas de vista informar sobre esos aspectos."),
    'class'         => 'aqua',        
    'elements'      => array(
        'process_overview' => array (
            'type' => 'hidden',
            'value' => 'overview'
        ),
        
        'name' => array(
            'type'      => 'textbox',
            'title'     => Text::_("Título del proyecto"),
            'required'  => true,
            'hint'      => Text::_("Escribe un nombre para titular el proyecto. Cuanto más breve mejor, para hacerlo más descriptivo puedes ampliarlo en el siguiente apartado."),
            'value'     => $project->name,
            'errors'    => !empty($errors['name']) ? array($errors['name']) : array(),
            'ok'        => !empty($okeys['name']) ? array($okeys['name']) : array()
        ),
        
        'subtitle' => array(
            'type'      => 'textbox',
            'title'     => Text::_("Frase de resumen"),
            'required'  => false,
            'value'     => $project->subtitle,
            'hint'      => Text::_("Define con una frase un subtítulo que acabe de explicar en qué consistirá la iniciativa, que permita hacerse una idea mínima de para qué sirve o en qué consiste. Aparecerá junto al título del proyecto."),
            'errors'    => !empty($errors['subtitle']) ? array($errors['subtitle']) : array(),
            'ok'        => !empty($okeys['subtitle']) ? array($okeys['subtitle']) : array()
        ),

        'images' => array(        
            'title'     => Text::_("Imágenes del proyecto"),
            'type'      => 'group',
            'required'  => true,
            'hint'      => Text::_("Pueden ser esquemas, pantallazos, fotografías, ilustraciones, storyboards, etc. (su licencia de autoría debe ser compatible con la que selecciones en el apartado 5). Te recomendamos que sean diversas y de buena resolución. Puedes subir tantas como quieras!"),
            'errors'    => !empty($errors['image']) ? array($errors['image']) : array(),
            'ok'        => !empty($okeys['image']) ? array($okeys['image']) : array(),
            'class'     => 'images',
            'children'  => array(
                'image_upload'    => array(
                    'type'  => 'file',
                    'label' => Text::_("Subir imagen"),
                    'class' => 'inline image_upload',
                    'hint'  => Text::_("Pueden ser esquemas, pantallazos, fotografías, ilustraciones, storyboards, etc. (su licencia de autoría debe ser compatible con la que selecciones en el apartado 5). Te recomendamos que sean diversas y de buena resolución. Puedes subir tantas como quieras!")
                )
            )
        ),        
        'gallery' => array(
            'type'  => 'group',
            'title' => Text::_("Imágenes actuales"),
            'class' => 'inline',
            'children'  => $images
        ),

        'description' => array(            
            'type'      => 'textarea',
            'title'     => Text::_("Breve descripción "),
            'required'  => true,
            'hint'      => Text::_("Describe el proyecto con un mínimo de 80 palabras (con menos marcará error). Explícalo de modo que sea fácil de entender para cualquier persona. Intenta darle un enfoque atractivo y social, resumiendo sus puntos fuertes, qué lo hace único, innovador o especial."),
            'value'     => $project->description,            
            'errors'    => !empty($errors['description']) ? array($errors['description']) : array(),
            'ok'        => !empty($okeys['description']) ? array($okeys['description']) : array()
        ),
        'description_group' => array(
            'type' => 'group',
            'children'  => array(                
                'about' => array(
                    'type'      => 'textarea',       
                    'title'     => Text::_("Características básicas"),
                    'required'  => true,
                    'hint'      => Text::_("Describe brevemente el proyecto de modo conceptual, técnico o práctico. Por ejemplo detallando sus características de funcionamiento, o en qué partes consistirá. Piensa en cómo será una vez acabado y todo lo que la gente podrá hacer con él."),
                    'errors'    => !empty($errors['about']) ? array($errors['about']) : array(),
                    'ok'        => !empty($okeys['about']) ? array($okeys['about']) : array(),
                    'value'     => $project->about
                ),
                'motivation' => array(
                    'type'      => 'textarea',       
                    'title'     => Text::_("Motivación y a quién va dirigido el proyecto"),
                    'required'  => true,
                    'hint'      => Text::_("Explica qué motivos o circunstancias te han llevado a idear el proyecto, así como las comunidades o usuarios a las que va destinado. Te ayudará a conectar con personas movidas por ese mismo tipo de intereses, problemáticas o gustos."),
                    'errors'    => !empty($errors['motivation']) ? array($errors['motivation']) : array(),
                    'ok'        => !empty($okeys['motivation']) ? array($okeys['motivation']) : array(),
                    'value'     => $project->motivation
                ),
                // video motivacion
                'video' => array(
                    'type'      => 'textbox',
                    'required'  => false,
                    'title'     => Text::_("Vídeo adicional sobre motivación"),
                    'hint'      => Text::_("Considera aquí la posibilidad de publicar y enlazar un vídeo (en Youtube o Vimeo) donde expliques brevemente a la cámara el porqué de tu proyecto. Se trata de algo que pueda complementar el vídeo principal, con una persona que transmita su necesidad u originalidad, del modo más directo posible. Si te da corte hablar a la cámara, también puede ser alguna persona que conoces y sigue el proyecto o la idea y pueda hacer esta aportación como "fan". La empatía y necesidad de ver a alguien al otro lado del proyecto es muy importante para determinado tipo de cofinanciadores. "),
                    'errors'    => !empty($errors['video']) ? array($errors['video']) : array(),
                    'ok'        => !empty($okeys['video']) ? array($okeys['video']) : array(),
                    'value'     => (string) $project->video
                ),

                'video-upload' => array(
                    'name' => "upload",
                    'type'  => 'submit',
                    'label' => Text::_("Enviar"),
                    'class' => 'inline media-upload'
                ),

                'video-preview' => $video,
                
                // universal subtitles video motivacion
                'video_usubs' => array(
                    'type'      => 'checkbox',
                    'class'     => 'inline cols_1',
                    'required'  => false,
                    'name'      => 'video_usubs',
                    'label'     => Text::_("Cargar con Universal Subtitles"),
                    'hint'      => Text::_("Marca la casilla en caso de que hayas subtitulado a otros idiomas el vídeo mediante Universal Subtitles: http://www.universalsubtitles.org/"),
                    'errors'    => array(),
                    'ok'        => array(),
                    'value'     => 1,
                    'checked'   => (bool) $project->video_usubs
                ),
                // fin video motivacion
                'goal' => array(
                    'type'      => 'textarea',
                    'title'     => Text::_("Objetivos de la campaña de crowdfunding"),
                    'hint'      => Text::_("Enumera las metas principales del proyecto, a corto y largo plazo, en todos los aspectos que consideres importante destacar. Se trata de otra oportunidad para contactar y conseguir el apoyo de gente que simpatice con esos objetivos."),
                    'errors'    => !empty($errors['goal']) ? array($errors['goal']) : array(),
                    'ok'        => !empty($okeys['goal']) ? array($okeys['goal']) : array(),
                    'value'     => $project->goal
                ),
                'related' => array(
                    'type'      => 'textarea',
                    'title'     => Text::_("Experiencia previa y equipo"),
                    'hint'      => Text::_("Resume tu trayectoria o la del grupo impulsor del proyecto. ¿Qué experiencia tiene relacionada con la propuesta? ¿Con qué equipo de personas, recursos y/o infraestructuras cuenta? "),
                    'errors'    => !empty($errors['related']) ? array($errors['related']) : array(),
                    'ok'        => !empty($okeys['related']) ? array($okeys['related']) : array(),
                    'value'     => $project->related
                ),
            )
        ),
       
        'category' => array(    
            'type'      => 'checkboxes',
            'name'      => 'categories[]',
            'title'     => Text::_("Categorías"),
            'required'  => true,
            'class'     => 'cols_3',
            'options'   => $categories,
            'hint'      => Text::_("Selecciona tantas categorías como creas necesario para describir el proyecto, basándote en todo lo que has descrito arriba. Mediante estas palabras clave lo podremos hacer llegar a diferentes usuarios de Goteo."),
            'errors'    => !empty($errors['categories']) ? array($errors['categories']) : array(),
            'ok'        => !empty($okeys['categories']) ? array($okeys['categories']) : array()
        ),       

        'keywords' => array(
            'type'      => 'textbox',
            'title'     => Text::_("Palabras clave del proyecto"),
            'required'  => true,
            'hint'      => Text::_("A medida que introduzcas texto el sistema te sugerirá palabras clave que ya han escrito otros usuarios. Estas categorías ayudan a vincular tu proyecto con personas afines."),
            'errors'    => !empty($errors['keywords']) ? array($errors['keywords']) : array(),
            'ok'        => !empty($okeys['keywords']) ? array($okeys['keywords']) : array(),
            'value'     => $project->keywords
        ),

        'media' => array(
            'type'      => 'textbox',
            'required'  => true,
            'title'     => Text::_("Vídeo de presentación"),
            'hint'      => Text::_("Copia y pega la dirección URL de un vídeo de presentación del proyecto, publicado previamente en Youtube o Vimeo. Esta parte es fundamental para atraer la atención de potenciales cofinanciadores y colaboradores, y cuanto más original sea mejor. Te recomendamos que tenga una duración de entre 2 y 4 minutos. "),
            'errors'    => !empty($errors['media']) ? array($errors['media']) : array(),
            'ok'        => !empty($okeys['media']) ? array($okeys['media']) : array(),
            'value'     => (string) $project->media
        ),

        'media-upload' => array(
            'name' => "upload",
            'type'  => 'submit',
            'label' => Text::_("Enviar"),
            'class' => 'inline media-upload'
        ),
        
        'media-preview' => $media,
        
        // universal subtitles video principal
        'media_usubs' => array(
            'type'      => 'checkbox',
            'class'     => 'inline cols_1',
            'required'  => false,
            'label'     => Text::_("Cargar con Universal Subtitles"),
            'name'      => 'media_usubs',
            'hint'      => Text::_("Marca la casilla en caso de que hayas subtitulado a otros idiomas el vídeo mediante Universal Subtitles: http://www.universalsubtitles.org/"),
            'errors'    => array(),
            'ok'        => array(),
            'checked'   => (bool) $project->media_usubs,
            'value'     => 1
        ),
        // fin media

        'currently' => array(    
            'title'     => Text::_("Estado actual"),
            'type'      => 'slider',
//            'required'  => true,
            'options'   => $currently,
            'class'     => 'currently cols_' . count($currently),
            'hint'      => Text::_("Indica en qué fase se encuentra el proyecto actualmente respecto a su proceso de creación o ejecución."),
            'errors'    => !empty($errors['currently']) ? array($errors['currently']) : array(),
            'ok'        => !empty($okeys['currently']) ? array($okeys['currently']) : array(),
            'value'     => $project->currently
        ),

        'location' => array(
            'type'      => 'textbox',
            'name'      => 'project_location',
            'title'     => Text::_("Ubicación"),
            'required'  => true,
            'hint'      => Text::_("Indica el lugar donde se desarrollará el proyecto, en qué población o poblaciones se encuentra su impulsor o impulsores principales."),
            'errors'    => !empty($errors['project_location']) ? array($errors['project_location']) : array(),
            'ok'        => !empty($okeys['project_location']) ? array($okeys['project_location']) : array(),
            'value'     => $project->project_location
        ),

        'scope' => array(
            'title'     => Text::_("Alcance del proyecto"),
            'type'      => 'slider',
//            'required'  => true,
            'options'   => $scope,
            'class'     => 'scope cols_' . count($currently),
            'hint'      => Text::_("Indica el impacto geográfico que aspira a tener el proyecto (cada categoría incluye la anterior). "),
            'errors'    => !empty($errors['scope']) ? array($errors['scope']) : array(),
            'ok'        => !empty($okeys['scope']) ? array($okeys['scope']) : array(),
            'value'     => $project->scope
        ),
        
        'footer' => array(
            'type'      => 'group',
            'children'  => array(
                'errors' => array(
                    'title' => Text::_("Errores"),
                    'view'  => new View('view/project/edit/errors.html.php', array(
                        'project'   => $project,
                        'step'      => $this['step']
                    ))                    
                ),
                'buttons'  => array(
                    'type'  => 'group',
                    'children' => array(
                        'next' => array(
                            'type'  => 'submit',
                            'name'  => 'view-step-costs',
                            'label' => Text::_("Siguiente"),
                            'class' => 'next'
                        )
                    )
                )
            )
        
        )

    )

);


foreach ($superform['elements'] as $id => &$element) {
    
    if (!empty($this['errors'][$this['step']][$id])) {
        $element['errors'] = arrray();
    }
    
}

echo new SuperForm($superform);