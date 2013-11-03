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
    Goteo\Library\SuperForm,
    Goteo\Core\View;

$project = $this['project'];
$user = $this['user'];

/*
if (!empty($user->avatar) && is_object($user->avatar))
    $image ["avatar-{$user->avatar->id}-remove"] = array(
        'type'  => 'submit',
        'label' => Text::_("Quitar"),
        'class' => 'inline remove image-remove weak'
    );
*/


$interests = array();

$errors = $project->errors[$this['step']] ?: array();
$okeys  = $project->okeys[$this['step']] ?: array();

foreach ($this['interests'] as $value => $label) {
    $interests[] =  array(
        'value'     => $value,
        'label'     => $label,
        'checked'   => in_array($value, $user->interests)
        );
}

$user_webs = array();

foreach ($user->webs as $web) {

    $ch = array();

    // a ver si es el que estamos editando o no
    if (!empty($this["web-{$web->id}-edit"])) {

        $user_webs["web-{$web->id}"] = array(
            'type'      => 'group',
            'class'     => 'web editweb',
            'children'  => array(
                    "web-{$web->id}-edit" => array(
                        'type'  => 'hidden',
                        'class' => 'inline',
                        'value' => '1'
                    ),
                    'web-' . $web->id . '-url' => array(
                        'type'      => 'textbox',
                        'required'  => true,
                        'title'     => Text::_("URL"),
                        'value'     => $web->url,
                        'hint'      => Text::_("Indica las direcciones URL de páginas personales o de otro tipo vinculadas a ti."),
                        'errors'    => !empty($errors['web-' . $web->id . '-url']) ? array($errors['web-' . $web->id . '-url']) : array(),
                        'ok'        => !empty($okeys['web-' . $web->id . '-url']) ? array($okeys['web-' . $web->id . '-url']) : array(),
                        'class'     => 'web-url inline'
                    ),
                    "web-{$web->id}-buttons" => array(
                        'type' => 'group',
                        'class' => 'inline buttons',
                        'children' => array(
                            "web-{$web->id}-ok" => array(
                                'type'  => 'submit',
                                'label' => Text::_("Aceptar"),
                                'class' => 'inline ok'
                            ),
                            "web-{$web->id}-remove" => array(
                                'type'  => 'submit',
                                'label' => Text::_("Quitar"),
                                'class' => 'inline remove weak'
                            )
                        )
                    )
                )
        );

    } else {

        $user_webs["web-{$web->id}"] = array(
            'class'     => 'web',
            'view'      => 'view/project/edit/webs/web.html.php',
            'data'      => array('web' => $web),
        );

    }

}

$sfid = 'sf-project-profile';

echo new SuperForm(array(
    'id'            => $sfid,
    'action'        => '',
    'level'         => $this['level'],
    'method'        => 'post',
    'title'         => Text::_("Datos de perfil"),
    'hint'          => Text::_("<strong>En este apartado debes introducir los datos para la información pública de tu perfil de usuario. </strong><br><br>Tanto si quieres presentar un proyecto como incorporarte como cofinanciador/a, para formar parte de la comunidad de Goteo te recomendamos que pongas atención en tu texto de presentación, que añadas links relevantes sobre lo que haces y subas una imagen de perfil con la que te identifiques."),
    'elements'      => array(
        'process_userProfile' => array (
            'type' => 'hidden',
            'value' => 'userProfile'
        ),
        'user_name' => array(
            'type'      => 'textbox',
            'required'  => true,
            'size'      => 20,
            'title'     => Text::_("Nombre de usuario/a"),
            'hint'      => Text::_("Tu nombre o nickname dentro de Goteo. Lo puedes cambiar siempre que quieras (ojo: no es lo mismo que el login de acceso, que ya no se puede modificar)."),
            'errors'    => !empty($errors['name']) ? array($errors['name']) : array(),
            'ok'        => !empty($okeys['name']) ? array($okeys['name']) : array(),
            'value'     => $user->name
        ),
        'user_location' => array(
            'type'      => 'textbox',
            'required'  => true,
            'size'      => 20,
            'title'     => Text::_("Lugar de residencia habitual"),
            'hint'      => Text::_("Este dato es importante para poderte vincular con un grupo local de Goteo."),
            'errors'    => !empty($errors['location']) ? array($errors['location']) : array(),
            'ok'        => !empty($okeys['location']) ? array($okeys['location']) : array(),
            'value'     => $user->location
        ),
        'user_avatar' => array(
            'type'      => 'group',
            'required'  => true,
            'title'     => Text::_("Imagen de perfil"),
            'hint'      => Text::_("No es obligatorio que pongas una fotografía en tu perfil, pero ayuda a que los demás usuarios te identifiquen."),
            'errors'    => !empty($errors['avatar']) ? array($errors['avatar']) : array(),
            'ok'        => !empty($okeys['avatar']) ? array($okeys['avatar']) : array(),
            'class'     => 'user_avatar',
            'children'  => array(
                'avatar_upload'    => array(
                    'type'  => 'file',
                    'label' => Text::_("Subir imagen"),
                    'class' => 'inline avatar_upload',
                    'hint'  => Text::_("No es obligatorio que pongas una fotografía en tu perfil, pero ayuda a que los demás usuarios te identifiquen."),
                ),
                'avatar-current' => array(
                    'type' => 'hidden',
                    'value' => $user->avatar->id == 1 ? '' : $user->avatar->id,
                ),
                'avatar-image' => array(
                    'type'  => 'html',
                    'class' => 'inline avatar-image',
                    'html'  => is_object($user->avatar) &&  $user->avatar->id != 1 ?
                               $user->avatar . '<img src="'.SRC_URL.'/image/' . $user->avatar->id . '/128/128" alt="Avatar" /><button class="image-remove" type="submit" name="avatar-'.$user->avatar->id.'-remove" title="Quitar imagen" value="remove">X</button>' :
                               ''
                )

            )
        ),

        'user_about' => array(
            'type'      => 'textarea',
            'required'  => true,
            'cols'      => 40,
            'rows'      => 4,
            'title'     => Text::_("Cuéntanos algo sobre ti"),
            'hint'      => Text::_("Como red social, Goteo pretende ayudar a difundir y financiar proyectos interesantes entre el máximo de gente posible. Para eso es importante la información que puedas compartir sobre tus habilidades o experiencia (profesional, académica, aficiones, etc).\r\n"),
            'errors'    => !empty($errors['about']) ? array($errors['about']) : array(),
            'ok'        => !empty($okeys['about']) ? array($okeys['about']) : array(),
            'value'     => $user->about
        ),
        'interests' => array(
            'type'      => 'checkboxes',
            'required'  => true,
            'class'     => 'cols_3',
            'name'      => 'user_interests[]',
            'title'     => Text::_("Qué tipo de proyecto te motiva más"),
            'hint'      => Text::_("Indica el tipo de proyectos que pueden conectar con tus intereses para cofinanciarlos y/o aportar con otros recursos, conocimientos o habilidades. Estas categorías son transversales, puedes seleccionar más de una."),
            'errors'    => !empty($errors['interests']) ? array($errors['interests']) : array(),
            'ok'        => !empty($okeys['interests']) ? array($okeys['interests']) : array(),
            'options'   => $interests
        ),
        'user_keywords' => array(
            'type'      => 'textbox',
            'required'  => true,
            'size'      => 20,
            'title'     => Text::_("Temas que te interesan"),
            'hint'      => Text::_("A medida que introduzcas texto el sistema te sugerirá palabras clave que ya han escrito otros usuarios. Estas categorías ayudan a vincular tu perfil con otras personas y con proyectos concretos."),
            'errors'    => !empty($errors['keywords']) ? array($errors['keywords']) : array(),
            'ok'        => !empty($okeys['keywords']) ? array($okeys['keywords']) : array(),
            'value'     => $user->keywords
        ),
        'user_contribution' => array(
            'type'      => 'textarea',
            'required'  => true,
            'cols'      => 40,
            'rows'      => 4,
            'title'     => Text::_("Qué puedes aportar a Goteo"),
            'hint'      => Text::_("Explica brevemente tus habilidades o los ámbitos en que podrías ayudar a un proyecto (traduciendo, difundiendo, testeando, programando, enseñando, etc)."),
            'errors'    => !empty($errors['contribution']) ? array($errors['contribution']) : array(),
            'ok'        => !empty($okeys['contribution']) ? array($okeys['contribution']) : array(),
            'value'     => $user->contribution
        ),
        'user_webs' => array(
            'type'      => 'group',
            'required'  => true,
            'title'     => Text::_("Mis páginas web"),
            'hint'      => Text::_("Indica las direcciones URL de páginas personales o de otro tipo vinculadas a ti."),
            'class'     => 'webs',
            'errors'    => !empty($errors['webs']) ? array($errors['webs']) : array(),
            'ok'        => !empty($okeys['webs']) ? array($okeys['webs']) : array(),
            'children'  => $user_webs + array(
                'web-add' => array(
                    'type'  => 'submit',
                    'label' => Text::_("Añadir"),
                    'class' => 'add red'
                )
            )
        ),
        'user_social' => array(
            'type'      => 'group',
            'title'     => Text::_("Perfiles sociales"),
            'children'  => array(
                'user_facebook' => array(
                    'type'      => 'textbox',
                    'class'     => 'facebook',
                    'size'      => 40,
                    'title'     => Text::_("Facebook"),
                    'hint'      => Text::_("Esta red social puede ayudar a que difundas proyectos de Goteo que te interesan entre amigos y familiares."),
                    'errors'    => !empty($errors['facebook']) ? array($errors['facebook']) : array(),
                    'ok'        => !empty($okeys['facebook']) ? array($okeys['facebook']) : array(),
                    'value'     => empty($user->facebook) ? Text::_("http://www.facebook.com/") : $user->facebook
                ),
                'user_google' => array(
                    'type'      => 'textbox',
                    'class'     => 'google',
                    'size'      => 40,
                    'title'     => Text::_("Google+"),
                    'hint'      => Text::_("La red social de Google+ es muy nueva pero también puedes indicar tu usuario si ya la usas :)"),
                    'errors'    => !empty($errors['google']) ? array($errors['google']) : array(),
                    'ok'        => !empty($okeys['google']) ? array($okeys['google']) : array(),
                    'value'     => empty($user->google) ? Text::_("https://plus.google.com/") : $user->google
                ),
                'user_twitter' => array(
                    'type'      => 'textbox',
                    'class'     => 'twitter',
                    'size'      => 40,
                    'title'     => Text::_("Twitter"),
                    'hint'      => Text::_("Esta red social puede ayudar a que difundas proyectos de Goteo de manera ágil y viral."),
                    'errors'    => !empty($errors['twitter']) ? array($errors['twitter']) : array(),
                    'ok'        => !empty($okeys['twitter']) ? array($okeys['twitter']) : array(),
                    'value'     => empty($user->twitter) ? Text::_("http://twitter.com/#!/") : $user->twitter
                ),
                'user_identica' => array(
                    'type'      => 'textbox',
                    'class'     => 'identica',
                    'size'      => 40,
                    'title'     => Text::_("Identi.ca"),
                    'hint'      => Text::_("Este canal puede ayudar a que difundas proyectos de Goteo entre la comunidad afín al software libre."),
                    'errors'    => !empty($errors['identica']) ? array($errors['identica']) : array(),
                    'ok'        => !empty($okeys['identica']) ? array($okeys['identica']) : array(),
                    'value'     => empty($user->identica) ? Text::_("http://identi.ca/") : $user->identica
                ),
                'user_linkedin' => array(
                    'type'      => 'textbox',
                    'class'     => 'linkedin',
                    'size'      => 40,
                    'title'     => Text::_("LinkedIn"),
                    'hint'      => Text::_("Esta red social puede ayudar a que difundas proyectos de Goteo que te interesan entre contactos profesionales."),
                    'errors'    => !empty($errors['linkedin']) ? array($errors['linkedin']) : array(),
                    'ok'        => !empty($okeys['linkedin']) ? array($okeys['linkedin']) : array(),
                    'value'     => empty($user->linkedin) ? Text::_("http://es.linkedin.com/in/") : $user->linkedin
                )
            )
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
                            'name'  => 'view-step-userPersonal',
                            'label' => Text::_("Siguiente"),
                            'class' => 'next'
                        )
                    )
                )
            )
        )
    )
));
?>
<script type="text/javascript">
$(function () {

    var webs = $('div#<?php echo $sfid ?> li.element#user_webs');

    webs.delegate('li.element.web input.edit', 'click', function (event) {
        var data = {};
        data[this.name] = '1';
        Superform.update(webs, data);
        event.preventDefault();
    });

    webs.delegate('li.element.editweb input.ok', 'click', function (event) {
        var data = {};
        data[this.name.substring(0, 7) + 'edit'] = '0';
        Superform.update(webs, data);
        event.preventDefault();
    });

    webs.delegate('li.element.editweb input.remove, li.element.web input.remove', 'click', function (event) {
        var data = {};
        data[this.name] = '1';
        Superform.update(webs, data);
        event.preventDefault();
    });

    webs.delegate('#web-add input', 'click', function (event) {
       var data = {};
       data[this.name] = '1';
       Superform.update(webs, data);
       event.preventDefault();
    });

});
</script>
