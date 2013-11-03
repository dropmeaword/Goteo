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

use Goteo\Library\Text;

// aviso para el usuario, puede ser start->hola , ok->gracias o fail->lo sentimos

$user = $this['user'];
$name = $user->name ? $user->name : Text::_("Invitado (no olvides registrarte)");

switch ($this['message']) {
    case 'start':
        $title   = Text::_("Hola") . " $name";
        $message = Text::_("Estás a un paso de ser cofinanciador/a de este proyecto");
        break;
    case 'continue':
        $title   = Text::_("Hola") . " $name";
        $message = Text::_("Elige el modo de pago");
        break;
    case 'ok':
        $title   = Text::_("Gracias") . " {$name}!";
        $message = Text::_("Se ha tramitado tu aportación para cofinanciar este proyecto :)");
        break;
    case 'fail':
        $title   = Text::_("Lo sentimos") . " {$name}";
        $message = Text::_("Algo ha fallado, por favor inténtalo de nuevo");
        break;
}

$level = (int) $this['level'] ?: 3;

?>
<div class="widget invest-message">
    <h2><img src="<?php echo $user->avatar->getLink(50, 50, true); ?>" /><span><?php echo $title; ?></span><br />
    <span class="message"><?php echo $message; ?></span></h2>


</div>
