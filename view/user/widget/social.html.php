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

$user = $this['user']
?>
<?php if (!empty($user->facebook) || !empty($user->google) || !empty($user->twitter) || !empty($user->identica) || !empty($user->linkedin)): ?>
<div class="widget user-social">
    <h4 class="title"><?php echo Text::_("Social"); ?></h4>
    <ul>
        <?php if (!empty($user->facebook)): ?>
        <li class="facebook"><a href="<?php echo htmlspecialchars($user->facebook) ?>"><?php echo Text::_("Facebook"); ?></a></li>
        <?php endif ?>
        <?php if (!empty($user->google)): ?>
        <li class="google"><a href="<?php echo htmlspecialchars($user->google) ?>"><?php echo Text::_("Google+"); ?></a></li>
        <?php endif ?>
        <?php if (!empty($user->twitter)): ?>
        <li class="twitter"><a href="<?php echo htmlspecialchars($user->twitter) ?>"><?php echo Text::_("Twitter"); ?></a></li>
        <?php endif ?>
        <?php if (!empty($user->identica)): ?>
        <li class="identica"><a href="<?php echo htmlspecialchars($user->identica) ?>"><?php echo Text::_("Identi.ca"); ?></a></li>
        <?php endif ?>
        <?php if (!empty($user->linkedin)): ?>
        <li class="linkedin"><a href="<?php echo htmlspecialchars($user->linkedin) ?>"><?php echo Text::_("LinkedIn"); ?></a></li>
        <?php endif ?>
    </ul>                
</div>            
<?php endif ?>