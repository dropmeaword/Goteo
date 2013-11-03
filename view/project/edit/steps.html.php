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

$errors = $this['errors'] ?>

<div id="project-steps">
            
            <fieldset>

                <legend><h3><?php echo Text::_("Ir a"); ?></h3></legend>

                <div class="steps">
                    
                    <span class="step first-off off<?php if ($this['step'] === 'userProfile') echo ' active'; else echo ' activable'; ?>">
                        <button type="submit" name="view-step-userProfile" value="<?php echo Text::_("Perfil"); ?>"><?php echo Text::_("Perfil"); ?>
                        <strong class="number">1</strong></button>                        
                    </span>
                    
                    <span class="step off-off off<?php if ($this['step'] === 'userPersonal') echo ' active'; else echo ' activable'; ?>">
                        <button type="submit" name="view-step-userPersonal" value="<?php echo Text::_("Promotor/a"); ?>"><?php echo Text::_("Promotor/a"); ?>
                        <strong class="number">2</strong></button>
                    </span>
                    
                    <fieldset style="display: inline">
                        
                        <legend><?php echo Text::_("Proyecto nuevo"); ?></legend>
                        
                        <span class="step off-on<?php if ($this['step'] === 'overview') echo ' active'; else echo ' activable'; ?>">
                            <button type="submit" name="view-step-overview" value="<?php echo Text::_("Descripción"); ?>"><?php echo Text::_("Descripción"); ?>
                            <strong class="number">3</strong></button>                            
                        </span>

                        <span class="step on-on<?php if ($this['step'] === 'costs') echo ' active'; else echo ' activable'; ?>">
                            <button type="submit" name="view-step-costs" value="<?php echo Text::_("Costes"); ?>"><?php echo Text::_("Costes"); ?>
                            <strong class="number">4</strong></button>                            
                        </span>

                        <span class="step on-on<?php if ($this['step'] === 'rewards') echo ' active'; else echo ' activable'; ?>">
                            <button type="submit" name="view-step-rewards" value="<?php echo Text::_("Retorno"); ?>"><?php echo Text::_("Retorno"); ?>
                            <strong class="number">5</strong></button>                            
                        </span>

                        <span class="step on-off<?php if ($this['step'] === 'supports') echo ' active'; else echo ' activable'; ?>">
                            <button type="submit" name="view-step-supports" value="<?php echo Text::_("Colaboraciones"); ?>"><?php echo Text::_("Colaboraciones"); ?>
                            <strong class="number">6</strong></button>                            
                        </span>
                        
                    </fieldset>
                    
                    <span class="step off-last off<?php if ($this['step'] === 'preview') echo ' active'; else echo ' activable'; ?>">
                        <button type="submit" name="view-step-preview" value="<?php echo Text::_("Previsualización"); ?>"><?php echo Text::_("Previsualización"); ?>
                        <strong class="number">7</strong></button>                        
                    </span>

                </div>

            </fieldset>
        </div>