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
    Goteo\Library\SuperForm,
    Goteo\Core\View;
            
$project = $this['project'];
$errors = $project->errors[$this['step']] ?: array();
$okeys  = $project->okeys[$this['step']] ?: array();

$costs = array();


if (!empty($project->costs)) {
    
    foreach ($project->costs as $cost) {     
        
        $req_class = $cost->required ? 'required_cost-yes' : 'required_cost-no';

        $ch = array();
        
        if (!empty($this["cost-{$cost->id}-edit"])) {

            $costTypes = array();

            foreach ($this['types'] as $id => $type) {
                $costTypes["cost-{$cost->id}-type-{$id}"] = array(
                    'name'  => "cost-{$cost->id}-type",
                    'value' => $id,
                    'type'  => 'radio',
                    'class' => "cost-type $id",
                    'label' => $type,
                    'hint'  => Text::get('tooltip-project-cost-type-'.$id),
                    'checked' => $id == $cost->type  ? true : false
                );
            }

            $costs["cost-{$cost->id}"] = array(
                'type'      => 'group',      
                'class'     => 'cost editcost '.$req_class,
                'children'  => array(                         
                    "cost-{$cost->id}-edit" => array(
                        'type'  => 'hidden',
                        'value' => '1'
                    ),
                    "cost-{$cost->id}-cost" => array(
                        'title'     => Text::_("Coste"),
                        'required'  => true,
                        'type'      => 'textbox',
                        'size'      => 100,
                        'class'     => 'inline',
                        'value'     => $cost->cost,
                        'errors'    => !empty($errors["cost-{$cost->id}-cost"]) ? array($errors["cost-{$cost->id}-cost"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-cost"]) ? array($okeys["cost-{$cost->id}-cost"]) : array(),
                        'hint'      => Text::_("Introduce un título lo más descriptivo posible de este coste."),
                    ),
                    "cost-{$cost->id}-type" => array(
                        'title'     => Text::_("Tipo"),
                        'required'  => true,
                        'class'     => 'inline',
                        'type'      => 'group',
                        'children'  => $costTypes,
                        'value'     => $cost->type,
                        'errors'    => !empty($errors["cost-{$cost->id}-type"]) ? array($errors["cost-{$cost->id}-type"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-type"]) ? array($okeys["cost-{$cost->id}-type"]) : array(),
                        'hint'      => Text::_("Aquí debes especificar el tipo de coste: vinculado a una tarea (algo que requiere la habilidad o conocimientos de alguien), la obtención de material (consumibles, materias primas) o bien infraestructura (espacios, equipos, mobiliario)."),
                    ),
                    "cost-{$cost->id}-description" => array(
                        'type'      => 'textarea',
                        'required'  => true,
                        'title'     => Text::_("Descripción"),
                        'cols'      => 100,
                        'rows'      => 4,
                        'class'     => 'inline cost-description',
                        'hint'      => Text::_("Explica brevemente en qué consiste este coste."),
                        'errors'    => !empty($errors["cost-{$cost->id}-description"]) ? array($errors["cost-{$cost->id}-description"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-description"]) ? array($okeys["cost-{$cost->id}-description"]) : array(),
                        'value'     => $cost->description
                    ),                                       
                    "cost-{$cost->id}-amount" => array(
                        'type'      => 'textbox',
                        'required'  => true,
                        'title'     => Text::_("Valor"),
                        'size'      => 8,
                        'class'     => 'inline cost-amount',
                        'hint'      => Text::_("Especifica el importe en euros de lo que consideras que implica este coste. No utilices puntos para las cifras de miles ok?"),
                        'errors'    => !empty($errors["cost-{$cost->id}-amount"]) ? array($errors["cost-{$cost->id}-amount"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-amount"]) ? array($okeys["cost-{$cost->id}-amount"]) : array(),
                        'value'     => $cost->amount
                    ),
                    "cost-{$cost->id}-required"  => array(
                        'required'  => true,
/*                        'title'     => Text::_("Este coste es"),  */
                        'class'     => 'inline cost-required cols_2',
                        'type'      => 'radios',
                        'options'   => array (
                            array(
                                    'value'     => '1',
                                    'class'     => 'required_cost-yes',
                                    'label'     => Text::_("Imprescindible")
                                ),
                            array(
                                    'value'     => '0',
                                    'class'     => 'required_cost-no',
                                    'label'     => Text::_("Adicional")
                                )
                        ),
                        'value'     => $cost->required,
                        'errors'    => !empty($errors["cost-{$cost->id}-required"]) ? array($errors["cost-{$cost->id}-required"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-required"]) ? array($okeys["cost-{$cost->id}-required"]) : array(),
                        'hint'      => Text::_("Este punto es muy importante: en cada coste que introduzcas tienes que marcar si es imprescindible o bien adicional. Todos los costes marcados como imprescindibles se sumarán dando el valor del importe de financiación mínimo para el proyecto. La suma de los costes adicionales, en cambio, se podrá obtener durante la segunda ronda de financiación, después de haber obtenido los fondos imprescindibles."),
                    ),
                    "cost-{$cost->id}-dates" => array(
                        'type'      => 'group',
                        'required'  => $cost->type == 'task' ? true : false,
                        'title'     => Text::_("Fechas"),
                        'class'     => 'inline cost-dates',
                        'errors'    => !empty($errors["cost-{$cost->id}-dates"]) ? array($errors["cost-{$cost->id}-dates"]) : array(),
                        'ok'        => !empty($okeys["cost-{$cost->id}-dates"]) ? array($okeys["cost-{$cost->id}-dates"]) : array(),
                        'hint'      => Text::_("Indica entre qué fechas calculas que se va a llevar a cabo esa tarea o cubrir ese coste. Planifícalo empezando no antes de dos meses a partir de ahora, pues hay que considerar el plazo para revisar la propuesta, publicarla si es seleccionada y los 40 días de la primera financiación. No incluyas en este calendario la agenda de lo desarrollado anteriormente aunque es bueno que lo expliques en la descripción del proyecto. En la agenda sólo nos interesan las fases que quedan por hacer y buscan ser cofinanciadas."),
                        'children'  => array(
                            "cost-{$cost->id}-from"  => array(
                                'class'     => 'inline cost-from',
                                'type'      => 'datebox',
                                'size'      => 8,
                                'title'     => Text::_("Desde"),
                                'value'     => $cost->from
                            ),
                            "cost-{$cost->id}-until"  => array(
                                'class'     => 'inline cost-until',
                                'type'      => 'datebox',
                                'size'      => 8,
                                'title'     => Text::_("Hasta"),
                                'value'     => $cost->until
                            )
                        )
                    ),        
                    "cost-{$cost->id}-buttons" => array(
                        'type' => 'group',
                        'class' => 'buttons',
                        'children' => array(
                            "cost-{$cost->id}-ok" => array(
                                'type'  => 'submit',
                                'label' => Text::_("Aceptar"),
                                'class' => 'inline ok'
                            ),
                            "cost-{$cost->id}-remove" => array(
                                'type'  => 'submit',
                                'label' => Text::_("Quitar"),
                                'class' => 'inline remove weak'
                            )
                        )                        
                    )                    
                )
            );
            
        } else {
            $costs["cost-{$cost->id}"] = array(                
                'class'     => 'cost ' . $req_class,
                'view'      => 'view/project/edit/costs/cost.html.php',
                'data'      => array('cost' => $cost),                
            );
            
        }
        
        
    }    
}

$sfid = 'sf-project-costs';

echo new SuperForm(array(
    
    'id'            => $sfid,

    'action'        => '',
    'level'         => $this['level'],
    'method'        => 'post',
    'title'         => Text::_("Aspectos económicos"),
    'hint'          => Text::_("<strong>En esta sección debes elaborar un pequeño presupuesto basado en los costes que calcules va a tener la realización del proyecto.</strong><br><br>\r\nDebes especificar según tareas, infraestructura o materiales. Intenta ser realista en los costes y explicar brevemente por qué necesitas cubrir cada uno de ellos. Ten en cuenta que por norma general, al menos un 80% del proyecto deberá ser realizado directamente por la persona o equipo que promueve el proyecto, y no subcontratado a terceros.<br><br>\r\n<strong>Muy importante</strong>: En Goteo diferenciamos entre costes imprescindibles y costes adicionales. Los primeros deben lograrse en su totalidad para poder obtener la financiación, mientras que los segundo se solicitan y obtienen directamente en una campaña posterior, una vez está en marcha el proyecto, para poder poder cubrir costes de optimización del mismo (difusión, diseño, alcance, más unidades, etc). Estos costes adicionales no pueden superar la mitad de los costes totales del proyecto."),    
    'class'         => 'aqua',      
    'elements'      => array(        
        'process_costs' => array (
            'type' => 'hidden',
            'value' => 'costs'
        ),

        'costs' => array(
            'type'      => 'group',
            'required'  => true,
            'title'     => Text::_("Desglose de costes"),
            'hint'      => Text::_("Cuanto más precisión en el desglose mejor valorará Goteo la información general del proyecto. "),
            'errors'    => !empty($errors["costs"]) ? array($errors["costs"]) : array(),
            'ok'        => !empty($okeys["costs"]) ? array($okeys["costs"]) : array(),
            'children'  => $costs  + array(
                'cost-add' => array(
                    'type'  => 'submit',
                    'label' => Text::_("Añadir"),
                    'class' => 'add red',
                )                
            )
        ),
        
        'cost-meter' => array(
            'title'     => Text::_("Visualización de costes"),
            'required'  => true,
            'class'     => 'cost-meter',
            'errors'    => !empty($errors["total-costs"]) ? array($errors["total-costs"]) : array(),
            'ok'        => !empty($okeys["total-costs"]) ? array($okeys["total-costs"]) : array(),
            'view'      => new View('view/project/edit/costs/meter.html.php', array(
                'project'   => $project
            )),
            'hint'      => Text::_("Este gráfico muestra la suma de costes imprescindibles (mínimos para realizar el proyecto) y la suma de costes secundarios (importe óptimo) para las dos rondas de financiación. La primera ronda es de 40 días, para conseguir el importe mínimo imprescindible. Sólo si se consigue ese volumen de financiación se puede optar a la segunda ronda, de 40 días más, para llegar al presupuesto óptimo. A diferencia de la primera, en la segunda ronda se obtiene todo lo recaudado (aunque no se haya llegado al mínimo). ")
        ),
        
        'resource' => array(
            'type'      => 'textarea',
            'cols'      => 40,
            'rows'      => 4,
            'title'     => Text::_("Otros recursos"),
            'hint'      => Text::_("Indica aquí si cuentas con recursos adicionales, aparte de los que solicitas, para llevar a cabo el proyecto: fuentes de financiación, recursos propios o bien ya has hecho acopio de materiales. Puede suponer un aliciente para los potenciales cofinanciadores del proyecto."),
            'errors'    => !empty($errors["resource"]) ? array($errors["resource"]) : array(),
            'ok'        => !empty($okeys["resource"]) ? array($okeys["resource"]) : array(),
            'value'     => $project->resource
        ),
        
        'schedule' => array(
            'type'      => 'html',
            'class'     => 'schedule',
            'hint'      => Text::_("Visualización de cómo queda la agenda de producción de tu proyecto. Recuerda que sólo debes señalar las nuevas tareas a realizar, no las que ya se hayan efectuado."),
            'html'      => new View('view/project/widget/schedule.html.php', array('project' => $project))
        ),
        
        'footer' => array(
            'type'      => 'group',
            'children'  => array(
                'errors' => array(
                    'title' => Text::_("Errores"),
                    'view'  => new View('view/project/edit/errors.html.php', array(
                        'project'   => $project,
                        'step'      => $this['step']
                    ))                    
                ),
                'buttons'  => array(
                    'type'  => 'group',
                    'children' => array(
                        'next' => array(
                            'type'  => 'submit',
                            'name'  => 'view-step-rewards',
                            'label' => Text::_("Siguiente"),
                            'class' => 'next'
                        )
                    )
                )
            )
        
        )
        
    )

));
?>
<script type="text/javascript">
$(function () {
    
    var costs = $('div#<?php echo $sfid ?> li.element#costs');    
    
    costs.delegate('li.element.cost input.edit', 'click', function (event) {
        var data = {};
        data[this.name] = '1';
        //Superform.update(this, data);
        Superform.update(costs, data); 
        event.preventDefault();
    });
    
    costs.delegate('li.element.editcost input.ok', 'click', function (event) {
        var data = {};
        data[this.name.substring(0, 9) + 'edit'] = '0';
        //Superform.update($(this).parents('li.element.editcost'), data);        
        Superform.update(costs, data);         
        event.preventDefault();
    });
    
    costs.delegate('li.element.editcost input.remove, li.element.cost input.remove', 'click', function (event) {        
        var data = {};
        data[this.name] = '1';
        Superform.update(costs, data);
        event.preventDefault();
    });
    
    costs.delegate('#cost-add input', 'click', function (event) {
       var data = {};
       data[this.name] = '1';
       Superform.update(costs, data); 
       event.preventDefault();
    });
    
    costs.bind('sfafterupdate', function (ev, el, html) {
        Superform.updateElement($('li#cost-meter'), null, html);
        Superform.updateElement($('li#schedule'), null, html);
    });
        
});
</script>
