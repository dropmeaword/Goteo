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
<div class="widget board">
    <!-- superform -->
    <form action="<?php echo $this['form']['action']; ?>" method="post" enctype="multipart/form-data">
        <dl>
            <?php foreach ($this['form']['fields'] as $Id=>$field) : ?>
                <dt><label for="<?php echo $Id; ?>"><?php echo $field['label']; ?></label></dt>
                <dd><?php switch ($field['type']) {
                    case 'text': ?>
                        <input type="text" id="<?php echo $Id; ?>" name="<?php echo $field['name']; ?>" <?php echo $field['properties']; ?> value="<?php $name = $field['name']; echo $this['data']->$name; ?>" />
                    <?php break;
                    case 'hidden': ?>
                        <input type="hidden" name="<?php echo $field['name']; ?>" <?php echo $field['properties']; ?> value="<?php $name = $field['name']; echo $this['data']->$name; ?>" />
                    <?php break;
                    case 'textarea': ?>
                        <textarea id="<?php echo $Id; ?>" name="<?php echo $field['name']; ?>" <?php echo $field['properties']; ?>><?php $name = $field['name']; echo $this['data']->$name; ?></textarea>
                    <?php break;
                    case 'image':
                         $name = $field['name'];
                        ?>
                        <input type="file" id="<?php echo $Id; ?>" name="<?php echo $field['name']; ?>" <?php echo $field['properties']; ?> value="<?php $name = $field['name']; echo $this['data']->$name; ?>" /> <br />
                        <?php if (!empty($this['data']->$name)) : ?>
                            <img src="<?php echo SRC_URL ?>/image/<?php echo $this['data']->$name; ?>/110/110" alt="<?php echo $field['name']; ?>" /><br />
                            <input type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo $this['data']->$name; ?>" />
                            <input type="submit" name="image-<?php echo $this['data']->$name; ?>-remove" value="<?php echo Text::_("Quitar"); ?>" />
                        <?php endif; ?>
                    <?php break;
                } ?></dd>

            <?php endforeach; ?>
        </dl>
        <input type="submit" name="<?php echo $this['form']['submit']['name']; ?>" value="<?php echo $this['form']['submit']['label']; ?>" />
    </form>
</div>