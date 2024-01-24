<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * External functions for returning course information.
 *
 * @package    local_prueba_jhoan
 * @copyright  2024 Jhoan Avila
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/lib/externallib.php');

/**
 * Returns a user's courses based on username.
 *
 * @package    local_prueba_jhoan
 * @copyright  2024 Jhoan Avila
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_prueba_jhoan_external extends external_api {
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function get_courses_by_pagination_parameters() {
        return new external_function_parameters(
                array(
                    'page' => new external_value(PARAM_INT, 'Numero de paginacion'),
                    'per_page' => new external_value(PARAM_INT, 'Cursos por pagina'),
                )
        );
    }

    /**
     * Get data courses moodle.
     * Obtenemos una cantidad de cursos segun los paramatros de paginacion.
     *
     * @param string $page       Pagina de consulta
     * @param string $per_page   Cursos por pagina
     * @return array
     */
    public static function get_courses_by_pagination($page, $per_page) {
        global $DB;
        
        $total_paginas = 0;
        $data_courses = array();
        //Obtenemos total de cursos en BD
        $count_courses = $DB->get_record_sql("SELECT COUNT(*) AS total_courses FROM {course} ", array());
        $total_cursos = $count_courses->total_courses;
        
        //Validamos si existen cursos en BD, la pagina consultada es yor a cero y los cursos por pagina es superior a cero
        if ($page > 0 && $per_page > 0 && $total_cursos > 0) {
            $start = ($page - 1) * $per_page; //Calculamos indice de curso por pagina
            $total_paginas = ceil($total_cursos / $per_page);//Calculamos total de paginas
            //Obtenemos curso por paginacion
            $courses = $DB->get_records_sql("SELECT * FROM {course} LIMIT ".$start.",".$per_page, array());
            if ( !empty($courses) ) {
                foreach ($courses as $course) {
                    //Obtenemos categoria de curso
                    $category = $DB->get_record('course_categories', array('id' => $course->category));
                    //Ordenamos datos del curso
                    $course_array = array(
                        'id' => $course->id,
                        'fullname' => $course->fullname,
                        'shortname' => $course->shortname,
                        'summary' => $course->summary,
                        'startdate' => date("d M Y, g:i a", $course->startdate),
                        'enddate' => date("d M Y, g:i a", $course->enddate),
                        'category' => $category->name,
                    );
                    array_push($data_courses,$course_array);
                }
            }
        }

        $result = new stdClass();
        $result->total = $total_cursos;
        $result->page = $page;
        $result->per_page = $per_page;
        $result->total_pages = $total_paginas;
        $result->data = $data_courses;
        return $result;
    }

    /**
     * Returns description of get_courses_by_pagination_returns() result value.
     *
     * @return \external_description
     */
    public static function get_courses_by_pagination_returns() {
        return new external_single_structure(
            array(
                'total'       => new external_value(PARAM_INT, 'Total de cursos encontrados'),
                'page'        => new external_value(PARAM_INT, 'Número de página actual'),
                'per_page'    => new external_value(PARAM_INT, 'Cantidad de cursos por página'),
                'total_pages' => new external_value(PARAM_INT, 'Total de páginas disponibles'),
                'data'        => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'id'        => new external_value(PARAM_INT, 'Identificador del curso'),
                            'fullname'  => new external_value(PARAM_RAW, 'Nombre completo del curso'),
                            'shortname' => new external_value(PARAM_RAW, 'Nombre corto del curso'),
                            'summary'   => new external_value(PARAM_RAW, 'Resumen del curso'),
                            'startdate' => new external_value(PARAM_RAW, 'Fecha de inicio del curso'),
                            'enddate'   => new external_value(PARAM_RAW, 'Fecha de finalización del curso'),
                            'category'  => new external_value(PARAM_RAW, 'Categoría del curso'),
                        )
                    )
                ),
            )
            
        );
    }
}
