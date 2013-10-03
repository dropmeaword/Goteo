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

<a href="/admin/footer/add" class="button red">Nueva entrada al pie</a>

<div class="widget board">
    <?php if (!empty($this['posts'])) : ?>
    <table>
        <thead>
            <tr>
                <th><?php echo Text::_("Título"); ?></th> <!-- title -->
                <th><?php echo Text::_("Posición"); ?></th> <!-- order -->
                <td><!-- <?php echo Text::_("Move up"); ?> --></td>
                <td><!-- <?php echo Text::_("Move down"); ?> --></td>
                <td><!-- <?php echo Text::_("Remove"); ?> --></td>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this['posts'] as $post) : ?>
            <tr>
                <td><?php echo $post->title; ?></td>
                <td><?php echo $post->order; ?></td>
                <td><a href="/admin/footer/up/<?php echo $post->id ?>/footer">[&uarr;]</a></td>
                <td><a href="/admin/footer/down/<?php echo $post->id ?>/footer">[&darr;]</a></td>
                <td><a href="/admin/footer/remove/<?php echo $post->id ?>/footer">[<?php echo Text::_("Quitar del footer"); ?>]</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    <?php else : ?>
    <p><?php echo Text::_("No se han encontrado registros"); ?></p>
    <?php endif; ?>
</div>