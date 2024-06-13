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
 * version.php - Contains main file file used by block_login_chart.
 *
 * @since Moodle 4.
 * @package    blog_login_chart
 * @copyright  2024 Roy Gitonga https://www.zawingu.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
class block_login_chart extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_login_chart');
    }

    public function get_content() {
        global $USER, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        // SQL query to fetch login data
        $sql = "
            SELECT
                login_date,
                data,
                LPAD(@rownum := @rownum + 1, 2, '0') AS label
            FROM (
                SELECT
                    DATE_FORMAT(FROM_UNIXTIME(l.timecreated), '%Y-%m-%d') AS login_date,
                    COUNT(*) AS data
                FROM
                    {logstore_standard_log} l
                JOIN
                    {user} u ON l.userid = u.id
                WHERE
                    u.id = :userid
                    AND l.action = 'loggedin'
                    AND FROM_UNIXTIME(u.firstaccess) >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                GROUP BY
                    login_date
                ORDER BY
                    login_date
            ) AS subquery,
            (SELECT @rownum := 0) AS r;
        ";

        $logins = $DB->get_records_sql($sql, ['userid' => $USER->id]);

        $labels = [];
        $data = [];

        foreach ($logins as $login) {
            $labels[] = $login->label;
            $data[] = $login->data;
        }

        $labels_json = json_encode($labels);
        $data_json = json_encode($data);

        $this->content = new stdClass;
        $this->content->text = "
            <div>
                <canvas id='points_new'></canvas>
            </div>
            <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('points_new');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: $labels_json,
                            datasets: [{
                                label: '# of Logins',
                                data: $data_json,
                                borderWidth: 1,
                                fill: true,
                                backgroundColor: '#EDF5FF',
                                borderColor: '#1F7BF4'
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        ";

        $this->content->footer = '';

        return $this->content;
    }
}
