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
 * Custom web services for this plugin.
 *
 * @package    local_prueba_jhoan
 * @copyright  2024 Jhoan Avila
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$services = array(
    'token_test' => array(
         'functions' => array('local_prueba_jhoan_get_courses_by_pagination'),
         'restrictedusers' => 0,
         'enabled' => 1,
         'timecreated' => time(),
         'shortname' => 'token',
    )
);

$functions = array(
    'local_prueba_jhoan_get_courses_by_pagination' => array(
        'classname'    => 'local_prueba_jhoan_external',
        'methodname'   => 'get_courses_by_pagination',
        'classpath'    => 'local/prueba_jhoan/externallib.php',
        'description'  => 'Get courses by pagination.',
        'type'         => 'read',
        'services'     =>  array('token'),
        'capabilities' => 'moodle/course:view, moodle/course:viewparticipants',
    ),
);
