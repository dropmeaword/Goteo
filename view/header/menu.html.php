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

 use Goteo\Core\ACL,
    Goteo\Library\Text;
?>
    <div id="menu">
        
        <h2><?php echo Text::_("Menú"); ?></h2>
        
        <ul>
            <li class="home"><a href="/"><?php echo Text::_("Inicio"); ?></a></li>
            <li class="explore"><a class="button red" href="/discover"><?php echo Text::_("Descubre proyectos"); ?></a></li>
            <li class="create"><a class="button aqua" href="/project/create"><?php echo Text::_("Crea un proyecto"); ?></a></li>
            <li class="search">
                <form method="get" action="/discover/results">
                    <fieldset>
                        <legend><?php echo Text::_("Buscar"); ?></legend>
                        <input type="text" name="query"  />
                        <input type="submit" value="Buscar" >
                    </fieldset>
                </form>
            </li>
            <?php if (!empty($_SESSION['user'])): ?>
            <li class="community"><a href="/community"><span><?php echo Text::_("Comunidad"); ?></span></a>
                <div>
                    <ul>
                        <li><a href="/community/activity"><span><?php echo Text::_("Actividad"); ?></span></a></li>
                        <li><a href="/community/sharemates"><span><?php echo Text::_("Compartiendo"); ?></span></a></li>
                    </ul>
                </div>
            </li>
            <?php else: ?>
            <li class="login">
                <a href="/community"><span><?php echo Text::_("Comunidad"); ?></span></a>
            </li>
            <?php endif ?>

            <?php if (!empty($_SESSION['user'])): ?>            
            <li class="dashboard"><a href="/dashboard"><span><?php echo Text::_("Mi panel"); ?></span><img src="<?php echo $_SESSION['user']->avatar->getLink(28, 28, true); ?>" /></a>
                <div>
                    <ul>
                        <li><a href="/dashboard/activity"><span><?php echo Text::_("Mi actividad"); ?></span></a></li>
                        <li><a href="/dashboard/profile"><span><?php echo Text::_("Mi perfil"); ?></span></a></li>
                        <li><a href="/dashboard/projects"><span><?php echo Text::_("Mis proyectos"); ?></span></a></li>
                        <?php if (ACL::check('/translate')) : ?>
                        <li><a href="/translate"><span><?php echo Text::_("Panel traductor"); ?></span></a></li>
                        <?php endif; ?>
                        <?php if (ACL::check('/review')) : ?>
                        <li><a href="/review"><span><?php echo Text::_("Panel revisor"); ?></span></a></li>
                        <?php endif; ?>
                        <?php if (ACL::check('/admin')) : ?>
                        <li><a href="/admin"><span><?php echo Text::_("Panel admin"); ?></span></a></li>
                        <?php endif; ?>
                        <li class="logout"><a href="/user/logout"><span><?php echo Text::_("Cerrar sesión"); ?></span></a></li>
                    </ul>
                </div>
            </li>            
            <?php else: ?>            
            <li class="login">
                <a href="/user/login"><?php echo Text::_("Accede"); ?></a>
            </li>
            
            <?php endif ?>
        </ul>
    </div>