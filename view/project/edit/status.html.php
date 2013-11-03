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
    Goteo\Model\Project;
?>            
<div class="status">

    <div id="project-status">
        <h3><?php echo Text::_("Estado del proyecto"); ?></h3>
        <ul>
            <?php foreach (Project::status() as $i => $s): ?>
            <li><?php if ($i == $this['status']) echo '<strong>' ?><?php echo htmlspecialchars($s) ?><?php if ($i == $this['status']) echo '</strong>' ?></li>
            <?php endforeach ?>
        </ul>
    </div>

    <div id="project-score">
        <h3><?php echo Text::_("Evaluación de datos"); ?> <code><?php echo number_format($this['progress'], 0) ?>%</code></h3>
        <p><?php echo Text::_("Este gráfico explica de un modo visual el nivel de datos que has introducido junto con una evaluación básica que hace el sistema. Para poder enviar el proyecto tienes que superar el 80%. Los criterios que hacen subir este "termómetro"  tienen que ver con la información relevante que facilitas, los media, imágenes y links que introduces, si eliges una licencia más abierta que otra, la coherencia de tu presupuesto respecto a las tareas a desarrollar, etc. No pierdas de vista los consejos de la columna derecha, que guían durante todo el proceso.") ?></p>

        <script type="text/javascript">
        // Animated scoremeter
        $(document).ready(function () {

            var progress = <?php echo number_format($this['progress'], 2) ?>,
                code = $('#project-score code'),
                meter = $('<div class="meter">'),
                done = $('<div>').addClass('done').css('width', '0');
                left = $('<div>').addClass('left').css('width', '100%');

            $('#project-score').append(meter);
            meter.append(done, left);

            $(window).load(function() {
                done.animate({
                    width: progress + '%'
                }, {
                    step: function (p) {
                        left.css('width', (100 - p)  + '%');
                        code.text(Math.round(p) + '%');
                    }
                }, 2500);
            });

        });
        </script>

        <noscript>
        <!-- Static scoremeter -->
        <div class="meter">
            <div class="done" style="width: <?php echo number_format($this['progress'], 2) ?>%"></div>
            <div class="left" style="width: <?php echo number_format(100 - $this['progress'], 2) ?>%"></div>
        </div>
        </noscript>

    </div>


</div>
