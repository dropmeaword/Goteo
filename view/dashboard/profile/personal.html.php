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
$personal = $this['personal'];
$this['level'] = 3;

?>
<form method="post" action="/dashboard/profile/personal" class="project" enctype="multipart/form-data">

<?php
echo new SuperForm(array(

    'level'         => $this['level'],
    'method'        => 'post',
    'hint'          => Text::_("Sólo debes cumplimentar estos datos si has creado un proyecto y quieres que sea cofinanciado y apoyado mediante Goteo.\r\n\r\nLa información de este apartado es necesaria para contactarte en caso de que obtengas la financiación requerida, y que así se pueda efectuar el ingreso."),
    'footer'        => array(
        'view-step-overview' => array(
            'type'  => 'submit',
            'label' => Text::_("Aplicar"),
            'class' => 'next',
            'name'  => 'save-userPersonal'
        )
    ),
    'elements'      => array(

        'contract_name' => array(
            'type'      => 'textbox',
            'required'  => true,
            'size'      => 20,
            'title'     => Text::_("Nombre y apellidos"),
            'hint'      => Text::_("Deben ser tu nombre y apellidos reales. Ten en cuenta que figurarás como responsable del proyecto."),
            'errors'    => !empty($errors['contract_name']) ? array($errors['contract_name']) : array(),
            'value'     => $personal->contract_name
        ),

        'contract_nif' => array(
            'type'      => 'textbox',
            'required'  => true,
            'title'     => Text::_("Número de NIF / NIE / VAT"),
            'size'      => 15,
            'hint'      => Text::_("Tu número de NIF o NIE con cifras y letra."),
            'errors'    => !empty($errors['contract_nif']) ? array($errors['contract_nif']) : array(),
            'value'     => $personal->contract_nif
        ),

        'phone' => array(
            'type'  => 'textbox',
            'required'  => true,
            'title' => Text::_("Teléfono"),
            'dize'  => 15,
            'hint'  => Text::_("Número de teléfono móvil o fijo, con su prefijo de marcado."),
            'errors'    => !empty($errors['phone']) ? array($errors['phone']) : array(),
            'value' => $personal->phone
        ),

        'address' => array(
            'type'  => 'textbox',
            'required'  => true,
            'title' => Text::_("Dirección"),
            'rows'  => 6,
            'cols'  => 40,
            'hint'  => ,
            'errors'    => !empty($errors['address']) ? array($errors['address']) : array(),
            'value' => $personal->address
        ),

        'zipcode' => array(
            'type'  => 'textbox',
            'required'  => true,
            'title' => Text::_("Código postal"),
            'size'  => 7,
            'hint'  => ,
            'errors'    => !empty($errors['zipcode']) ? array($errors['zipcode']) : array(),
            'value' => $personal->zipcode
        ),

        'location' => array(
            'type'  => 'textbox',
            'required'  => true,
            'title' => Text::_("Localidad"),
            'size'  => 25,
            'hint'  => ,
            'errors'    => !empty($errors['location']) ? array($errors['location']) : array(),
            'value' => $personal->location
        ),

        'country' => array(
            'type'  => 'textbox',
            'required'  => true,
            'title' => Text::_("País"),
            'size'  => 25,
            'hint'  => ,
            'errors'    => !empty($errors['country']) ? array($errors['country']) : array(),
            'value' => $personal->country
        ),

    )

));

?>
</form>
