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

$user = $this['user'];

$roles = $user->roles;
array_walk($roles, function (&$role) { $role = $role->name; });
?>
<div class="widget">
    <dl>
        <dt><?php echo Text::_('Nombre de usuario:'); ?></dt>
        <dd><?php echo $user->name ?></dd>
    </dl>
    <dl>
        <dt><?php echo Text::_('Login de acceso:'); ?></dt>
        <dd><strong><?php echo $user->id ?></strong></dd>
    </dl>
    <dl>
        <dt>Email:</dt>
        <dd><?php echo $user->email ?></dd>
    </dl>
    <dl>
        <dt><?php echo Text::_('Roles actuales:'); ?></dt>
        <dd>
            <?php echo implode(', ', $roles); ?><br />
            <?php if (in_array('checker', array_keys($user->roles))) : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/nochecker"; ?>" class="button red"><?php echo Text::_('Quitarlo de revisor'); ?></a>
            <?php else : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/checker"; ?>" class="button"><?php echo Text::_('Hacerlo revisor'); ?></a>
            <?php endif; ?>

            <?php if (in_array('translator', array_keys($user->roles))) : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/notranslator"; ?>" class="button red"><?php echo Text::_('Quitarlo de traductor'); ?></a>
            <?php else : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/translator"; ?>" class="button"><?php echo Text::_('Hacerlo traductor'); ?></a>
            <?php endif; ?>

            <!--
            <?php # if (in_array('admin', array_keys($user->roles))) : ?>
                <a href="<?php # echo "/admin/users/manage/{$user->id}/noadmin"; ?>" class="button weak"><?php echo Text::_('Quitarlo de admin'); ?></a>
            <?php # else : ?>
                <a href="<?php # echo "/admin/users/manage/{$user->id}/admin"; ?>" class="button"><?php echo Text::_('Hacerlo admin'); ?></a>
            <?php # endif; ?>
            -->
        </dd>
    </dl>
    <dl>
        <dt><?php echo Text::_('Estado de la cuenta:'); ?></dt>
        <dd>
            <strong><?php echo $user->active ? 'Activa' : 'Inactiva'; ?></strong>
            <?php if ($user->active) : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/ban"; ?>" class="button"><?php echo Text::_('Desactivar'); ?></a>
            <?php else : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/unban"; ?>" class="button red"><?php echo Text::_('Activar'); ?></a>
            <?php endif; ?>
        </dd>
    </dl>
    <dl>
        <dt><?php echo Text::_('Visibilidad:'); ?></dt>
        <dd>
            <strong><?php echo $user->hide ? 'Oculto' : 'Visible'; ?></strong>
            <?php if (!$user->hide) : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/hide"; ?>" class="button"><?php echo Text::_('Ocultar'); ?></a>
            <?php else : ?>
                <a href="<?php echo "/admin/users/manage/{$user->id}/show"; ?>" class="button red"><?php echo Text::_('Mostrar'); ?></a>
            <?php endif; ?>
        </dd>
    </dl>
    <!--
    <p>
        <a href="<?php echo "/admin/users/manage/{$user->id}/delete"; ?>" class="button weak" onclick="return confirm('Estas seguro de que quieres eliminar este usuario y todos sus registros asociados (proyectos, mensajes, aportes...)')">Eliminar</a>
    </p>
    -->

</div>

