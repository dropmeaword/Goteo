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

?>
<p><strong><?php echo $this['template']->name; ?></strong>: <?php echo $this['template']->purpose; ?></p>

<div class="widget board">
    <form method="post" action="/admin/templates/edit/<?php echo $this['template']->id; ?>">
        <p>
            <label for="tpltitle"><?php echo Text::_("Título:"); ?></label><br />
            <input id="tpltitle" type="text" name="title" size="120" value="<?php echo $this['template']->title; ?>" />
        </p>

        <p>
            <label for="tpltext"><?php echo Text::_("Contenido:"); ?></label><br />
            <textarea id="tpltext" name="text" cols="100" rows="20"><?php echo $this['template']->text; ?></textarea>
        </p>

        <input type="submit" name="save" value="<?php echo Text::_("Guardar"); ?>" />
    </form>
</div>
