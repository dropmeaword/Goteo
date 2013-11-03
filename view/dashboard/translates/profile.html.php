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

$user = $this['user'];
$errors = $this['errors'];

$original = \Goteo\Model\User::get($user->id);

$sfid = 'sf-project-profile';
?>

<?php if (isset($this['ownprofile'])) : ?>
<div class="widget"><?php echo Text::_("Estas traduciendo tu perfil personal.")?> <a href="/dashboard/translates/profile"><?php echo Text::_("Volver al perfil del autor del proyecto");?></a></div>
<?php elseif (!isset($this['noowner']) && $user->id != $_SESSION['user']->id && $_SESSION['user']->roles['translator']->id == 'translator') : ?>
<div class="widget"><?php echo Text::_("Estas traduciendo el perfil del autor del proyecto.");?> <a href="/dashboard/translates/profile/own"><?php echo Text::_("Traducir mi perfil personal");?></a></div>
<?php endif; ?>

<form method="post" action="<?php echo SITE_URL ?>/dashboard/translates/profile/save" class="project" enctype="multipart/form-data">

<?php echo new SuperForm(array(
    'id'            => $sfid,
    'action'        => '',
    'level'         => 3,
    'method'        => 'post',
    'title'         => '',
    'hint'          => Text::_("<strong>En este apartado debes introducir los datos para la información pública de tu perfil de usuario. </strong><br><br>Tanto si quieres presentar un proyecto como incorporarte como cofinanciador/a, para formar parte de la comunidad de Goteo te recomendamos que pongas atención en tu texto de presentación, que añadas links relevantes sobre lo que haces y subas una imagen de perfil con la que te identifiques."),
    'footer'        => array(
        'view-step-preview' => array(
            'type'  => 'submit',
            'name'  => 'save-userProfile',
            'label' => Text::_("Guardar"),
            'class' => 'next'
        )
    ),
    'elements'      => array(
        'process_userProfile' => array (
            'type' => 'hidden',
            'value' => 'userProfile'
        ),
        'id' => array (
            'type' => 'hidden',
            'value' => $user->id
        ),
        'about-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Cuéntanos algo sobre ti"),
            'html'     => nl2br($original->about)
        ),
        'about' => array(
            'type'      => 'textarea',
            'cols'      => 40,
            'rows'      => 4,
            'class'     => 'inline',
            'title'     => '',
            'hint'      => Text::_("Como red social, Goteo pretende ayudar a difundir y financiar proyectos interesantes entre el máximo de gente posible. Para eso es importante la información que puedas compartir sobre tus habilidades o experiencia (profesional, académica, aficiones, etc).\r\n"),
            'errors'    => array(),
            'ok'        => array(),
            'value'     => $user->about
        ),
        'keywords-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Temas que te interesan"),
            'html'     => $original->keywords
        ),
        'keywords' => array(
            'type'      => 'textbox',
            'size'      => 20,
            'class'     => 'inline',
            'title'     => '',
            'hint'      => Text::_("A medida que introduzcas texto el sistema te sugerirá palabras clave que ya han escrito otros usuarios. Estas categorías ayudan a vincular tu perfil con otras personas y con proyectos concretos."),
            'errors'    => array(),
            'ok'        => array(),
            'value'     => $user->keywords
        ),
        'contribution-orig' => array(
            'type'      => 'html',
            'title'     => Text::_("Qué puedes aportar a Goteo"),
            'html'     => nl2br($original->contribution)
        ),
        'contribution' => array(
            'type'      => 'textarea',
            'cols'      => 40,
            'rows'      => 4,
            'class'     => 'inline',
            'title'     => '',
            'hint'      => Text::_("Explica brevemente tus habilidades o los ámbitos en que podrías ayudar a un proyecto (traduciendo, difundiendo, testeando, programando, enseñando, etc)."),
            'errors'    => array(),
            'ok'        => array(),
            'value'     => $user->contribution
        )
    )
));
?>
</form>
