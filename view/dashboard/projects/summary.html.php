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
    Goteo\Model\Project;

$project = $this['project'];

if (!$project instanceof  Goteo\Model\Project) {
    return;
}
?>
<div class="widget">
    <p><strong><?php echo $project->name ?></strong></p>
    <a class="button red" href="/project/edit/<?php echo $project->id ?>"><?php echo Text::_("Editar") ?></a>
    <a class="button" href="/project/<?php echo $project->id ?>" target="_blank"><?php echo Text::_("Página pública") ?></a>
    <?php if ($project->status == 1) : ?>
    <a class="button weak" href="/project/delete/<?php echo $project->id ?>" onclick="return confirm('<?php echo Text::_("¿Seguro que deseas eliminar absoluta y definitivamente este proyecto?") ?>')"><?php echo Text::_("Borrar") ?></a>
    <?php endif ?>
</div>

<div class="status">

    <div id="project-status">
        <h3><?php echo Text::_("Estado del proyecto"); ?></h3>
        <ul>
            <?php foreach (Project::status() as $i => $s): ?>
            <li><?php if ($i == $project->status) echo '<strong>' ?><?php echo htmlspecialchars($s) ?><?php if ($i == $project->status) echo '</strong>' ?></li>
            <?php endforeach ?>
        </ul>
    </div>

</div>

<div id="meter-big" class="widget collapsable">

    <?php echo new View('view/project/meter_hor_big.html.php', $this) ?>
    
</div>

