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
    Goteo\Library\SuperForm;

define('ADMIN_NOAUTOSAVE', true);


$errors = $this['errors'];
$preferences = $this['preferences'];

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


?>
<form method="post" action="/dashboard/profile/preferences" class="project" >

<?php
echo new SuperForm(array(

    'level'         => 3,
    'method'        => 'post',
    'hint'          => Text::_("Marca ''Sí'' en las notificaciones automáticas que quieras bloquear"),
    'footer'        => array(
        'view-step-overview' => array(
            'type'  => 'submit',
            'label' => Text::_("Aplicar"),
            'class' => 'next',
            'name'  => 'save-userPreferences'
        )
    ),
    'elements'      => array(

        'updates' => array(
            'title'     => Text::_("Bloquear notificaciones de novedades sobre los proyectos que apoyo"),
            'type'      => 'slider',
            'options'   => $allow,
            'class'     => 'currently cols_' . count($allow),
            'hint'      => ,
            'errors'    => array(),
            'value'     => (int) $preferences->updates
        ),
        'threads' => array(
            'title'     => Text::_("Bloquear notificaciones de respuestas en los mensajes que yo inicio"),
            'type'      => 'slider',
            'options'   => $allow,
            'class'     => 'currently cols_' . count($allow),
            'hint'      => ,
            'errors'    => array(),
            'value'     => (int) $preferences->threads
        ),
        'rounds' => array(
            'title'     => Text::_("Bloquear notificaciones de progreso de los proyectos que apoyo"),
            'type'      => 'slider',
            'options'   => $allow,
            'class'     => 'currently cols_' . count($allow),
            'hint'      => ,
            'errors'    => array(),
            'value'     => (int) $preferences->rounds
        ),
        'mailing' => array(
            'title'     => Text::_("Bloquear el envio de newsletter"),
            'type'      => 'slider',
            'options'   => $allow,
            'class'     => 'currently cols_' . count($allow),
            'hint'      => ,
            'errors'    => array(),
            'value'     => (int) $preferences->mailing
        )

    )

));

?>
</form>
