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


namespace Goteo\Controller {

	use Goteo\Core\ACL,
        Goteo\Core\View,
        Goteo\Core\Redirection,
        Goteo\Model,
	    Goteo\Library\Feed,
	    Goteo\Library\Message,
	    Goteo\Library\Text,
	    Goteo\Library\Page,
	    Goteo\Library\Content,
		Goteo\Library\Lang;

	class Translate extends \Goteo\Core\Controller {

        public function index ($table = '', $action = 'list', $id = null) {

            if (empty($_SESSION['translator_lang'])) {
                $_SESSION['translator_lang'] = 'en';
//                $errors[] = 'Selecciona el idioma de traducción';
//                return new View('view/translate/index.html.php', array('menu'=>self::menu()));
            }

            if ($table == '') {
                return new View('view/translate/index.html.php', array('menu'=>self::menu()));
            }

            // para el breadcrumbs segun el contenido
            $section = ($table == 'news' || $table == 'promote') ? 'home' : 'contents';

            $BC = self::menu(array(
                'section' => $section,
                'option' => $table,
                'action' => $action,
                'id' => $id
            ));

            define('ADMIN_BCPATH', $BC);

            $errors = array();

            // la operación según acción
            switch($table)  {
                case 'texts':
                    // comprobamos los filtros
                    $filters = array();
                    $fields = array('idfilter', 'group', 'text');
                    foreach ($fields as $field) {
                        if (isset($_GET[$field])) {
                            $filters[$field] = $_GET[$field];
                        }
                    }

                    $filter = "?idfilter={$filters['idfilter']}&group={$filters['group']}&text={$filters['text']}";

                    // si llega post, vamos a guardar los cambios
                    if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {

                        if (Text::save(array(
                                        'id'   => $id,
                                        'text' => $_POST['text'],
                                        'lang' => $_POST['lang']
                                    ), $errors)) {

                            // Evento Feed
                            $log = new Feed();
                            $log->populate(Text::_('texto traducido (traductor)'), '/translate/texts',
                                \vsprintf(Text::_('El traductor %s ha %s el texto %s al %s')), array(
                                    Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                    Feed::item('relevant', Text::_('Traducido')),
                                    Feed::item('blog', $id),
                                    Feed::item('relevant', Lang::get($_POST['lang'])->name)
                            ));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Info('Texto <strong>'.$id.'</strong> traducido correctamente al <strong>'.Lang::get($_POST['lang'])->name.'</strong>');

                            throw new Redirection("/translate/texts/$filter&page=".$_GET['page']);
                        } else {
                            // Evento Feed
                            $log = new Feed();
                            $log->populate(Text::_('texto traducido (traductor)'), '/translate/texts',
                                \vsprintf(Text::_('Al traductor %s  le ha %s el texto %s al %s')), array(
                                    Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                    Feed::item('relevant', Text::_('Fallado al traducir')),
                                    Feed::item('blog', $id),
                                    Feed::item('relevant', Lang::get($_POST['lang'])->name)
                            ));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Error(Text::_('Ha habido algun ERROR al traducir el Texto').' <strong>'.$id.'</strong> al <strong>'.Lang::get($_POST['lang'])->name.'</strong><br />' . implode('<br />', $errors));
                        }
                    }

                    // sino, mostramos la lista
                    return new View(
                        'view/translate/index.html.php',
                        array(
                            'section' => 'texts',
                            'action'  => $action,
                            'id'      => $id,
                            'filter' => $filter,
                            'filters' => $filters,
                            'errors'  => $errors
                        )
                     );
                    break;
                case 'pages':
                    // si llega post, vamos a guardar los cambios
                    if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
                        if (Page::update($id, $_POST['lang'], $_POST['content'], $errors)) {

                            // Evento Feed
                            $log = new Feed();
                            $log->populate(Text::_('pagina traducida (traductor)'), '/translate/pages',
                                \vsprintf(Text::_('El traductor %s ha %s la página %s al %s'), array(
                                Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                Feed::item('relevant', Text::_('Traducido')),
                                Feed::item('blog', $id),
                                Feed::item('relevant', Lang::get($_POST['lang'])->name)
                            )));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Info(Text::_('Contenido de la Pagina ').'<strong>'.$id.'</strong>'.Text::_( 'traducido correctamente al ').'<strong>'.Lang::get($_POST['lang'])->name.'</strong>');

                            throw new Redirection("/translate/pages");
                        } else {
                            // Evento Feed
                            $log = new Feed();
                            $log->populate('pagina traducida (traductor)', '/translate/pages',
                                \vsprintf('Al traductor %s le ha %s la página %s al %s', array(
                                Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                Feed::item('relevant', 'Fallado al traducir'),
                                Feed::item('blog', $id),
                                Feed::item('relevant', Lang::get($_POST['lang'])->name)
                            )));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Error(Text::_('Ha habido algun ERROR al traducir el contenido de la pagina ').'<strong>'.$id.'</strong> al <strong>'.Lang::get($_POST['lang'])->name.'</strong><br />' . implode('<br />', $errors));
                        }
                    }

                    // sino, mostramos la lista
                    return new View(
                        'view/translate/index.html.php',
                        array(
                            'section' => 'pages',
                            'action' => $action,
                            'id' => $id,
                            'errors'=>$errors
                        )
                     );
                    break;
                default:
                    // comprobamos los filtros
                    $filters = array();
                    $fields = array('type', 'text');
                    foreach ($fields as $field) {
                        if (isset($_GET[$field])) {
                            $filters[$field] = $_GET[$field];
                        }
                    }

                    $filter = "?type={$filters['type']}&text={$filters['text']}";

                    // si llega post, vamos a guardar los cambios
                    if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {

                        if (!in_array($table, \array_keys(Content::$tables))) {
                            $errors[] = Text::_("Tabla $table desconocida");
                            break;
                        }

                        if (Content::save($_POST, $errors)) {

                            // Evento Feed
                            $log = new Feed();
                            $log->populate(Text::_('contenido traducido (traductor)'), '/translate/'.$table,
                                \vsprintf(Text::_('El traductor %s ha %s el contenido del registro %s de la tabla %s al %s'), array(
                                Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                Feed::item('relevant', Text::_('Traducido')),
                                Feed::item('blog', $id),
                                Feed::item('blog', $table),
                                Feed::item('relevant', Lang::get($_SESSION['translator_lang'])->name)
                            )));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Info(Text::_('Contenido del registro').' <strong>'.$id.'</strong> '.Text::_('de la tabla').' <strong>'.$table.'</strong> '.Text::_('traducido correctamente al ').'<strong>'.Lang::get($_POST['lang'])->name.'</strong>');

                            throw new Redirection("/translate/$table/$filter&page=".$_GET['page']);
                        } else {
                            // Evento Feed
                            $log = new Feed();
                            $log->populate(Text::_('contenido traducido (traductor)'), '/translate/'.$table,
                                \vsprintf(Text::_('El traductor %s le ha %s el contenido del registro %s de la tabla %s al %s'), array(
                                Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                                Feed::item('relevant', Text::_('Fallado al traducir')),
                                Feed::item('blog', $id),
                                Feed::item('blog', $table),
                                Feed::item('relevant', Lang::get($_SESSION['translator_lang'])->name)
                            )));
                            $log->doAdmin('admin');
                            unset($log);

                            Message::Error(Text::_('Ha habido algun ERROR al traducir el contenido del registro').' <strong>'.$id.'</strong> ' .Text::_('de la tabla').' <strong>'.$table.'</strong> al <strong>'.Lang::get($_POST['lang'])->name.'</strong><br />' . implode('<br />', $errors));
                        }
                    }

                    // sino, mostramos la lista
                    return new View(
                        'view/translate/index.html.php',
                        array(
                            'section' => 'contents',
                            'action'  => $action,
                            'table'  => $table,
                            'id'      => $id,
                            'filter' => $filter,
                            'filters' => $filters,
                            'errors'  => $errors
                        )
                     );
            }

            // si no pasa nada de esto, a la portada
            return new View('view/translate/index.html.php', array('menu'=>self::menu()));
        }

        public function select ($section = '', $action = '', $id = null) {

            $_SESSION['translator_lang'] = isset($_POST['lang']) ? $_POST['lang'] : null;

            if (!empty($section) && !empty($action)) {

                $filter = "?type={$_GET['type']}&text={$_GET['text']}";

                throw new Redirection("/translate/$section/$action/$id/$filter&page=".$_GET['page']);
            } else {
                return new View('view/translate/index.html.php', array('menu'=>self::menu()));
            }
        }

        /*
         * Gestión de páginas institucionales
         */

        /*
         * Gestión de textos de interficie
         */

        /*
         * proyectos destacados
         */

        /*
         * preguntas frecuentes
         */

        /*
         * criterios de puntuación Goteo
         */

        /*
         * Tipos de Retorno/Recompensa (iconos)
         */

        /*
         * Licencias
         */

        /*
         *  categorias de proyectos / intereses usuarios
         */

        /*
         *  Gestión de tags de blog
         */

        /*
         * Gestión de entradas de blog
         */

        /*
         *  Gestión de noticias
         */

        /*
         *  Menu de secciones, opciones, acciones y config para el panel Translate
         *
         *  ojo! cambian las options para ser directamente el nombre de la tabla menos para textos y contenidos de página
         * cambian tambien las actions solo list y edit (que es editar la traducción)
         */
        private static function menu($BC = array()) {

            // si el breadcrumbs no es un array vacio,
            //   devolveremos el contenido html para pintar el camino de migas de pan
            //   con enlaces a lo anterior

            $menu = array(
                'contents' => array(
                    'label'   => Text::_('Gestión de Textos y Traducciones'),
                    'options' => array (
                        'post' => array(
                            'label' => 'Blog',
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Entrada'), 'item' => true)
                            )
                        ),
                        'texts' => array(
                            'label' => Text::_('Textos interficie'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Texto'), 'item' => true)
                            )
                        ),
                        'faq' => array(
                            'label' => 'FAQs',
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Pregunta'), 'item' => true)
                            )
                        ),
                        'pages' => array(
                            'label' => Text::_('Contenidos institucionales'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo contenido de Página'), 'item' => true)
                            )
                        ),
                        'page' => array(
                            'label' => Text::_('Páginas'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Página'), 'item' => true)
                            )
                        ),
                        'category' => array(
                            'label' => Text::_('Categorias e Intereses'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Categoría'), 'item' => true)
                            )
                        ),
                        'license' => array(
                            'label' => Text::_('Licencias'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Licencia'), 'item' => true)
                            )
                        ),
                        'icon' => array(
                            'label' => Text::_('Tipos de Retorno'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Tipo'), 'item' => true)
                            )
                        ),
                        'tag' => array(
                            'label' => Text::_('Tags de blog'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Tag'), 'item' => true)
                            )
                        ),
                        'criteria' => array(
                            'label' => Text::_('Criterios de revisión'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Criterio'), 'item' => true)
                            )
                        ),
                        'template' => array(
                            'label' => Text::_('Plantillas de email'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Plantilla'), 'item' => true)
                            )
                        ),
                        'glossary' => array(
                            'label' => Text::_('Glosario'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Término'), 'item' => true)
                            )
                        ),
                        'info' => array(
                            'label' => Text::_('Ideas about'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Idea'), 'item' => true)
                            )
                        ),
                        'worthcracy' => array(
                            'label' => Text::_('Meritocracia'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Nivel'), 'item' => true)
                            )
                        )
                    )
                ),
                'home' => array(
                    'label'   => Text::_('Portada'),
                    'options' => array (
                        'news' => array(
                            'label' => Text::_('Micronoticias'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Micronoticia'), 'item' => true)
                            )
                        ),
                        'promote' => array(
                            'label' => Text::_('Proyectos destacados'),
                            'actions' => array(
                                'list' => array('label' => Text::_('Listando'), 'item' => false),
                                'edit' => array('label' => Text::_('Traduciendo Destacado'), 'item' => true)
                            )
                        )
                    )
                )
            );

            if (empty($BC)) {
                return $menu;
            } else {
                // Los últimos serán los primeros
                $path = '';

                // si el BC tiene Id, accion sobre ese registro
                // si el BC tiene Action
                if (!empty($BC['action'])) {

                    // si es una accion no catalogada, mostramos la lista
                    if (!in_array(
                            $BC['action'],
                            array_keys($menu[$BC['section']]['options'][$BC['option']]['actions'])
                        )) {
                        $BC['action'] = 'list';
                        $BC['id'] = null;
                    }

                    $action = $menu[$BC['section']]['options'][$BC['option']]['actions'][$BC['action']];
                    // si es de item , añadir el id (si viene)
                    if ($action['item'] && !empty($BC['id'])) {
                        $path = " &gt; <strong>{$action['label']}</strong> {$BC['id']}";
                    } else {
                        $path = " &gt; <strong>{$action['label']}</strong>";
                    }
                }

                // si el BC tiene Option, enlace a la portada de esa gestión
                if (!empty($BC['option'])) {
                    $option = $menu[$BC['section']]['options'][$BC['option']];
                    $path = ' &gt; <a href="/translate/'.$BC['option'].''.$BC['filter'].'">'.$option['label'].'</a>'.$path;
                }

                // si el BC tiene section, facil, enlace al admin
                if (!empty($BC['section'])) {
                    $section = $menu[$BC['section']];
                    $path = '<a href="/translate#'.$BC['section'].'">'.$section['label'].'</a>' . $path;
                }
                return $path;
            }


        }


	}

}
