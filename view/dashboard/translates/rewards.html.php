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

$social_rewards = array();
$individual_rewards = array();

if (!empty($project->social_rewards)) {
    foreach ($project->social_rewards as $social_reward) {

        // a ver si es el que estamos editando o no
        if (!empty($this["social_reward-{$social_reward->id}-edit"])) {

            $original = \Goteo\Model\Project\Reward::get($social_reward->id);

            // a este grupo le ponemos estilo de edicion
            $social_rewards["social_reward-{$social_reward->id}"] = array(
                    'type'      => 'group',
                    'class'     => 'reward social_reward editsocial_reward',
                    'children'  => array(
                        "social_reward-{$social_reward->id}-reward-orig" => array(
                            'title'     => Text::_("Retorno"),
                            'type'      => 'html',
                            'html'     => $original->reward
                        ),
                        "social_reward-{$social_reward->id}-reward" => array(
                            'title'     => '',
                            'type'      => 'textbox',
                            'class'     => 'inline',
                            'value'     => $social_reward->reward,
                            'errors'    => array(),
                            'ok'        => array(),
                            'hint'      => Text::_("Intenta que el título sea lo más descriptivo posible. Recuerda que puedes añadir más recompensas a continuación.")
                        ),
                        "social_reward-{$social_reward->id}-description-orig" => array(
                            'type'      => 'html',
                            'title'     => Text::_("Descripción"),
                            'html'     => nl2br($original->description)
                        ),
                        "social_reward-{$social_reward->id}-description" => array(
                            'type'      => 'textarea',
                            'title'     => '',
                            'cols'      => 100,
                            'rows'      => 4,
                            'class'     => 'inline reward-description',
                            'value'     => $social_reward->description,
                            'errors'    => array(),
                            'ok'        => array(),
                            'hint'      => Text::_("Explica brevemente el tipo de retorno colectivo que ofrecerá o permitirá el proyecto.")
                        ),
                        "social_reward-{$social_reward->id}-buttons" => array(
                            'type' => 'group',
                            'class' => 'buttons',
                            'children' => array(
                                "social_reward-{$social_reward->id}-ok" => array(
                                    'type'  => 'submit',
                                    'label' => Text::_("Aceptar"),
                                    'class' => 'inline ok'
                                )
                            )
                        )
                    )
                );
                                
        } else {

            $social_rewards["social_reward-{$social_reward->id}"] = array(
                'class'     => 'reward social_reward',
                'view'      => 'view/dashboard/translates/rewards/reward.html.php',
                'data'      => array('reward' => $social_reward, 'licenses' => $this['licenses']),
            );

        }

    }
}

if (!empty($project->individual_rewards)) {
    foreach ($project->individual_rewards as $individual_reward) {

        // a ver si es el que estamos editando o no
        if (!empty($this["individual_reward-{$individual_reward->id}-edit"])) {

            $original = \Goteo\Model\Project\Reward::get($individual_reward->id);

            // a este grupo le ponemos estilo de edicion
            $individual_rewards["individual_reward-{$individual_reward->id}"] = array(
                    'type'      => 'group',
                    'class'     => 'reward individual_reward editindividual_reward',
                    'children'  => array(
                        "individual_reward-{$individual_reward->id}-reward-orig" => array(
                            'title'     => Text::_("Recompensa"),
                            'type'      => 'html',
                            'html'      => $original->reward
                        ),
                        "individual_reward-{$individual_reward->id}-reward" => array(
                            'title'     => '',
                            'type'      => 'textbox',
                            'size'      => 100,
                            'class'     => 'inline',
                            'value'     => $individual_reward->reward,
                            'errors'    => array(),
                            'ok'        => array(),
                            'hint'      => Text::_("Intenta que el título sea lo más descriptivo posible. Recuerda que puedes añadir más recompensas a continuación.")
                        ),
                        "individual_reward-{$individual_reward->id}-description-orig" => array(
                            'type'      => 'html',
                            'title'     => Text::_("Descripción"),
                            'html'      => $original->description
                        ),
                        "individual_reward-{$individual_reward->id}-description" => array(
                            'type'      => 'textarea',
                            'title'     => '',
                            'cols'      => 100,
                            'rows'      => 4,
                            'class'     => 'inline reward-description',
                            'value'     => $individual_reward->description,
                            'errors'    => array(),
                            'ok'        => array(),
                            'hint'      => Text::_("Explica brevemente en qué consistirá la recompensa para quienes cofinancien con este importe el proyecto.")
                        ),
                        "individual_reward-{$individual_reward->id}-buttons" => array(
                            'type' => 'group',
                            'class' => 'buttons',
                            'children' => array(
                                "individual_reward-{$individual_reward->id}-ok" => array(
                                    'type'  => 'submit',
                                    'label' => Text::_("Aceptar"),
                                    'class' => 'inline ok'
                                )
                            )
                        )
                    )
                );

        } else {

            $individual_rewards["individual_reward-{$individual_reward->id}"] = array(
                'class'     => 'reward individual_reward',
                'view'      => 'view/dashboard/translates/rewards/reward.html.php',
                'data'      => array('reward' => $individual_reward),
            );

        }
    }
}

$sfid = 'sf-project-rewards';

?>

<form method="post" action="<?php echo SITE_URL ?>/dashboard/translates/rewards/save" class="project" enctype="multipart/form-data">

<?php echo new SuperForm(array(

    'id'            => $sfid,

    'action'        => '',
    'level'         => 3,
    'method'        => 'post',
    'title'         => '',
    'hint'          => Text::_("<strong>En este apartado puedes especificar qué otras ayudas, aparte de financiación, se necesitan para llevar a cabo el proyecto.</strong><br><br> Pueden ser tareas o acciones a cargo de otras personas (traducciones, gestiones, difusión, etc), o bien préstamos específicos (de material, transporte, hardware, etc)."),
    'class'         => 'aqua',
    'footer'        => array(
        'view-step-preview' => array(
            'type'  => 'submit',
            'name'  => 'save-rewards',
            'label' => Text::_("Guardar"),
            'class' => 'next'
        )
    ),
    'elements'      => array(
        'process_rewards' => array (
            'type' => 'hidden',
            'value' => 'rewards'
        ),

        'social_rewards' => array(
            'type'      => 'group',
            'title'     => Text::_("Retornos colectivos"),
            'hint'      => Text::_("Define el tipo de retorno o retornos del proyecto a los que se podrá acceder abiertamente, y la licencia que los debe regular. Si tienes dudas sobre qué opción escoger o lo que se adaptaría mejor a tu caso, <a href="http://www.goteo.org/contact" target="new">contáctanos</a> y te asesoraremos en este punto."),
            'class'     => 'rewards',
            'errors'    => array(),
            'ok'        => array(),
            'children'  => $social_rewards
        ),

        'individual_rewards' => array(
            'type'      => 'group',
            'title'     => Text::_("Recompensas individuales"),
            'hint'      => Text::_("Aquí debes especificar la recompensa para quien apoye el proyecto, vinculada a una cantidad de dinero concreta. Elige bien lo que ofreces, intenta que sean productos/servicios atractivos o ingeniosos pero que no generen gastos extra de producción. Si no hay más remedio que tener esos gastos extra, calcula lo que cuesta producir esa recompensa (tiempo, materiales, envíos, etc) y oferta un número limitado. Piensa que tendrás que cumplir con todos esos compromisos al final de la producción del proyecto. "),
            'class'     => 'rewards',
            'errors'    => array(),
            'ok'        => array(),
            'children'  => $individual_rewards
        )
    )

));
?>
</form>
<script type="text/javascript">
$(function () {

    /* social rewards buttons */
    var socials = $('div#<?php echo $sfid ?> li.element#social_rewards');

    socials.delegate('li.element.social_reward input.edit', 'click', function (event) {
        var data = {};
        data[this.name] = '1';
        Superform.update(socials, data);
        event.preventDefault();
    });

    socials.delegate('li.element.editsocial_reward input.ok', 'click', function (event) {
        var data = {};
        data[this.name.substring(0, 18) + 'edit'] = '0';
        Superform.update(socials, data);
        event.preventDefault();
    });

    /* individual_rewards buttons */
    var individuals = $('div#<?php echo $sfid ?> li.element#individual_rewards');

    individuals.delegate('li.element.individual_reward input.edit', 'click', function (event) {
        var data = {};
        data[this.name] = '1';
        Superform.update(individuals, data);
        event.preventDefault();
    });

    individuals.delegate('li.element.editindividual_reward input.ok', 'click', function (event) {
        var data = {};
        data[this.name.substring(0, 22) + 'edit'] = '0';
        Superform.update(individuals, data);
        event.preventDefault();
    });

});
</script>