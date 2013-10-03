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
    Goteo\Model;

?>
<?php if (!empty($this['reviews'])) : ?>
<h2 class="title"><?php echo Text::_("Mis revisiones anteriores");?></h2>
    <?php foreach ($this['reviews'] as $review) : ?>
        <div class="widget">
<p><?php echo Text::_("El proyecto");?> <strong><?php echo $review->name; ?></strong> <?php echo Text::_("de");?> <strong><?php echo $review->owner_name; ?></strong></p>
<p><?php echo Text::_("La edición del proyecto alcanzó el");?> <strong><?php echo $review->progress; ?>%</strong><?php echo Text::_(", la puntuación de la revisión fue de");?> <strong><?php echo $review->score; ?>/<?php echo $review->max; ?></strong></p>
<p><a href="/review/history/details/<?php echo $review->id; ?>"><?php echo Text::_("Ver detalles de la revisión");?></a></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>