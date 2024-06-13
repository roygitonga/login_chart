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
 * version.php - Contains version file used by block_login_chart.
 *
 * @since Moodle 4.
 * @package    blog_login_chart
 * @copyright  2024 Roy Gitonga https://www.zawingu.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2024061300; // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2020110900; // Requires Moodle version 4.0.0 and above.
$plugin->component = 'block_login_chart'; // Full name of the plugin (used for diagnostics).
$plugin->release   = 'v1.0.0'; // Human-readable version name.
$plugin->maturity  = MATURITY_STABLE; // Maturity level: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, or MATURITY_STABLE.
$plugin->cron      = 0; // Set to 1 to enable cron-based processing.

$plugin->dependencies = array(
    'block' => ANY_VERSION
);
