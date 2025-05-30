<?php
defined('BASEPATH') or exit('No direct script access allowed');
class State_Details_Model extends CI_Model
{

    public function statelists()
    {
        $query = $this->db->select('state_name,state_code,Date')
            ->from('state_lists')
            ->order_by('Date', 'DESC')
            ->get();
        return $query->result();
    }

    // NMS RPORT
    public function nmsdetails()
    {
        return $this->db->order_by('id', 'DESC')
            ->get('nms_report')
            ->result();
    }

    // show the state
    public function nmsstate()
    {
        $this->db->select('id, State');
        $this->db->from('nms_report');
        $this->db->group_by('State'); // group by State names
        return $this->db->get()->result_array();
    }

    public function get_nms_by_state($state_id)
    {
        $this->db->where('id', $state_id);
        $query = $this->db->get('nms_report');
        return $query->result();
    }

    // NMS REPORT END



    public function get_datetime_tables()
    {
        $query = $this->db->query("SHOW TABLES");
        $result = $query->result_array();

        $matching_tables = [];

        foreach ($result as $row) {
            $table_name = reset($row); // Get the table name string

            // Match tables like 10_04_2025_17_33_28
            if (preg_match('/^\d{2}_\d{2}_\d{4}_\d{2}_\d{2}_\d{2}$/', $table_name)) {
                $matching_tables[] = $table_name;
            }
        }

        return $matching_tables;
    }

    public function get_dynamic_table_data($table_name, $limit, $start, $search = '', $scope_id, $stateCode = '', $districtCode = '')
    {
        $this->db->select('*')->from("`$table_name`");

        // if ($scope_id == 'STATE' && !empty($stateCode)) {
        //     $this->db->where('stateCode', $stateCode);
        // } elseif ($scope_id == 'STATE & DISTRICT' && !empty($stateCode) && !empty($districtCode)) {
        //     $this->db->where('stateCode', $stateCode);
        //     $this->db->where('districtCode', $districtCode);
        // }
        if ($scope_id == 'STATE' && !empty($stateCode) && empty($districtCode)) {
            // State-only access
            $this->db->where('stateCode', $stateCode);
        } elseif (
            ($scope_id == 'STATE' && !empty($stateCode) && !empty($districtCode)) ||
            ($scope_id == 'STATE & DISTRICT' && !empty($stateCode) && !empty($districtCode))
        ) {
            // Access specific district within the state
            $this->db->where('stateCode', $stateCode);
            $this->db->where('districtCode', $districtCode);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('stateName', $search);
            $this->db->or_like('districtName', $search);
            $this->db->or_like('blockName', $search);
            $this->db->or_like('locationname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function get_dynamic_table_count($table_name, $search = '', $scope_id, $stateCode = '', $districtCode = '')
    {
        $this->db->from("`$table_name`");

        if ($scope_id == 'STATE' && !empty($stateCode) && empty($districtCode)) {
            // State-only access
            $this->db->where('stateCode', $stateCode);
        } elseif (
            ($scope_id == 'STATE' && !empty($stateCode) && !empty($districtCode)) ||
            ($scope_id == 'STATE & DISTRICT' && !empty($stateCode) && !empty($districtCode))
        ) {
            // Access specific district within the state
            $this->db->where('stateCode', $stateCode);
            $this->db->where('districtCode', $districtCode);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('stateName', $search);
            $this->db->or_like('districtName', $search);
            $this->db->or_like('blockName', $search);
            $this->db->or_like('locationname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }



    public function get_all_states()
    {
        return $this->db->get('state_lists')->result_array(); // Assuming 'roles' is the table name
    }

    public function getdistrict_bystate($id)
    {
        $this->db->select('district_code, district_names');
        $this->db->from('district_lists'); // Replace with your actual table name
        $this->db->where('state_code', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_state_up_data($table_name, $state_name)
    {
        $this->db->select("
        bgp.STATE_NAME,
        COUNT(gp.GP_Code) AS Count,
        SUM(CASE WHEN `$table_name`.status LIKE '%UP%' THEN 1 ELSE 0 END) AS up_count,
        ROUND(SUM(CASE WHEN `$table_name`.status LIKE '%UP%' THEN 1 ELSE 0 END) * 100.0 / COUNT(gp.GP_Code), 2) AS up_percentage
    ", FALSE);
        $this->db->from('4012_blocks_gp bgp');
        $this->db->join('4012_gps gp', 'bgp.STATE_NAME = gp.STATE_NAME', 'LEFT');
        $this->db->join("`$table_name`", "gp.GP_Code = `$table_name`.lgdcode", 'LEFT');
        $this->db->where('bgp.STATE_NAME', $state_name);
        $this->db->group_by('bgp.STATE_NAME');

        return $this->db->get()->result_array();
    }


    public function get_copilot_states()
    {
        return $this->db->get('4012_blocks_gp')->result_array(); // Assuming 'roles' is the table name
    }

    public function get_total_count()
    {
        $this->db->select_sum('Count');
        $query = $this->db->get('4012_blocks_gp');
        return $query->row()->Count;
    }


    public function get_state_up_datas($table_name)
    {
        $query = $this->db->query("
        SELECT 
            g.STATE_NAME,
            COUNT(*) AS total_count,
            SUM(CASE WHEN s.status LIKE '%UP%' THEN 1 ELSE 0 END) AS up_count,
            SUM(CASE WHEN s.status LIKE '%DOWN%' THEN 1 ELSE 0 END) AS down_count
        FROM `4012_gps` g
        JOIN (
            SELECT DISTINCT lgdcode, status
            FROM `$table_name`
        ) s ON g.GP_Code = s.lgdcode
        GROUP BY g.STATE_NAME
    ");

        return $query->result_array();
    }


    public function get_down_details_backup($state_Name, $table_name)
    {
        $table_name = $this->db->escape_str($table_name); // Used for table name
        $state_Name_escaped = $this->db->escape($state_Name); // Used for value comparison

        $query = $this->db->query("
        SELECT 
            g.GP_Name,
            s.reasonForDown
        FROM `4012_gps` g
        LEFT JOIN (
            SELECT lgdcode, reasonForDown
            FROM `$table_name`
            WHERE status LIKE '%DOWN%'
        ) s ON g.GP_Code = s.lgdcode
        WHERE g.STATE_NAME = $state_Name_escaped AND s.lgdcode IS NOT NULL
    ");

        return $query->result_array();
    }

    public function get_down_details($state, $table, $prevNdays, $prevMonth, $prevDay, $start = 0, $length = 10)
    {
        $table_name = $this->db->escape_str($table);
        $prevMonthTable = $this->db->escape_str($prevMonth);
        $prevNdaysTable = $this->db->escape_str($prevNdays);
        $prevDayCol = $this->db->escape_str($prevDay);
        $state_escaped = $this->db->escape($state);

        $parts = explode('_', $table);
        $dayPart = intval($parts[0]);
        $monthPart = $parts[1];

        // Count query (used regardless of day)
        $count_query = $this->db->query("
            SELECT COUNT(*) AS cnt
            FROM `4012_gps` g
            INNER JOIN (
                SELECT lgdcode FROM `$table_name` WHERE status LIKE '%DOWN%'
            ) s2 ON g.GP_Code = s2.lgdcode
            WHERE g.STATE_NAME = $state_escaped
        ");
        $totalCount = $count_query->row()->cnt;

        // Prepare main query
        if ($dayPart === 1) {
            $query = $this->db->query("
                SELECT 
                    g.GP_Name,
                    s2.reasonForDown,
                    s1.TOTAL_DOWN_TIME AS PREVIOUSMONTH_DOWN_TIME
                FROM `4012_gps` g
                LEFT JOIN (
                    SELECT SUBSTRING_INDEX(ONT_LOCATION_CODE, '-', -1) AS Code_LastPart, TOTAL_DOWN_TIME
                    FROM `$prevMonthTable`
                ) s1 ON g.GP_Code = s1.Code_LastPart
                INNER JOIN (
                    SELECT lgdcode, reasonForDown
                    FROM `$table_name`
                    WHERE status LIKE '%DOWN%'
                ) s2 ON g.GP_Code = s2.lgdcode
                WHERE g.STATE_NAME = $state_escaped
                LIMIT $length OFFSET $start
            ");
        } else {
            $coalesceClauses = [];
            $selectCols = [];
            for ($i = 1; $i <= $dayPart; $i++) {
                $col = "{$i}_{$monthPart}";
                $selectCols[] = "`$col`";
                $coalesceClauses[] = "COALESCE(s4.`$col`, 0)";
            }

            $columnsList = implode(', ', $selectCols);
            $sumClause = implode(' + ', $coalesceClauses);

            $query = $this->db->query("
                SELECT 
                    g.GP_Name,
                    s2.reasonForDown,
                    s1.TOTAL_DOWN_TIME AS PREVIOUSMONTH_DOWN_TIME,
                    CASE 
                        WHEN s4.`$prevDayCol` = 0 THEN 'NA'
                        ELSE s4.`$prevDayCol`
                    END AS Previous_Day,
                    ROUND(($sumClause)) AS LAST_N_DAY_availability
                FROM `4012_gps` g
                LEFT JOIN (
                    SELECT SUBSTRING_INDEX(ONT_LOCATION_CODE, '-', -1) AS Code_LastPart, TOTAL_DOWN_TIME
                    FROM `$prevMonthTable`
                ) s1 ON g.GP_Code = s1.Code_LastPart
                LEFT JOIN (
                    SELECT SUBSTRING_INDEX(LOCATION_CODE, '-', -1) AS Code_12_days, $columnsList
                    FROM `$prevNdaysTable`
                ) s4 ON g.GP_Code = s4.Code_12_days
                INNER JOIN (
                    SELECT lgdcode, reasonForDown
                    FROM `$table_name`
                    WHERE status LIKE '%DOWN%'
                ) s2 ON g.GP_Code = s2.lgdcode
                WHERE g.STATE_NAME = $state_escaped
                LIMIT $length OFFSET $start
            ");
        }

        return [
            'details' => $query->result_array(),
            'total' => $totalCount,
            'filtered' => $totalCount
        ];
    }



    




    public function get_up_details_query($prev_month = null, $prev_day = null, $prev_ndays = null, $state_name, $table_name, $search, $start, $length)
    {
        $parts = explode('_', $table_name);
        $currentDay = $parts[0];      // e.g., '14'
        $currentMonth = $parts[1];    // e.g., '05'
        $isFirstDay = ($currentDay == '1');

        $params = [$state_name];

        $select_clause = "
            SELECT
                g.GP_Name,
                s1.ONT_AVAILABILITY_per_,
        ";

        $base_query = "
            FROM `4012_gps` g
            LEFT JOIN (
                SELECT SUBSTRING_INDEX(ONT_LOCATION_CODE, '-', -1) AS Code_LastPart, ONT_AVAILABILITY_per_ 
                FROM `$prev_month`
            ) s1 ON g.GP_Code = s1.Code_LastPart
        ";

        if (!$isFirstDay) {
        $start_day = 1;
        $end_day = (int)$currentDay - 1;
        $NDay = $end_day - $start_day + 1;

        $columns_to_select = ["SUBSTRING_INDEX(LOCATION_CODE, '-', -1) AS Code_N_days"];
        $columns_sum_parts = [];

        for ($day = $start_day; $day <= $end_day; $day++) {
            // $day_str = ($day < 10 ? '0' . $day : $day) . '_' . $currentMonth;
            $day_str = $day . '_' . $currentMonth;
            $columns_to_select[] = "`$day_str`";
            $columns_sum_parts[] = "COALESCE(s4.`$day_str`, 0)";
        }

        $columns_select_clause = implode(", ", $columns_to_select);
        $columns_sum = implode(" + ", $columns_sum_parts);

        $avg_expression = "ROUND(($columns_sum) / $NDay, 2) AS avg_ont_availability";
        $hours_expression = "ROUND((24 * $NDay * (($columns_sum) / $NDay) / 100), 2) AS ont_Ndays_hours";
        $prev_day_col_backtick = "`$prev_day`";

        $base_query .= "
            LEFT JOIN (
                SELECT $columns_select_clause
                FROM `$prev_ndays`
            ) s4 ON g.GP_Code = s4.Code_N_days
        ";

        $select_clause .= "
            CASE 
                WHEN s4.$prev_day_col_backtick = 0 THEN 'NA'
                ELSE ROUND(s4.$prev_day_col_backtick)
            END AS ONT_AVAILABILITY,
            $avg_expression,
            $hours_expression,
            ROUND((744 * s1.ONT_AVAILABILITY_per_ / 100), 2) AS ont_monthly__hours,
            CASE 
                WHEN ROUND((24 * s4.$prev_day_col_backtick / 100), 2) = 0.00 THEN 'NA'
                ELSE ROUND((24 * s4.$prev_day_col_backtick / 100), 2)
            END AS ont_Per_day_hour
        ";
    }
        else {
            $select_clause .= "
                'NA' AS ONT_AVAILABILITY,
                'NA' AS avg_ont_availability,
                'NA' AS ont_Ndays_hours,
                ROUND((744 * s1.ONT_AVAILABILITY_per_ / 100), 2) AS ont_monthly__hours,
                'NA' AS ont_Per_day_hour
            ";
        }

        $base_query .= "
            INNER JOIN (
                SELECT lgdcode FROM `$table_name` WHERE status LIKE '%UP%'
            ) s2 ON g.GP_Code = s2.lgdcode
            WHERE g.STATE_NAME = ?
        ";

        if (!empty($search)) {
            $base_query .= " AND g.GP_Name LIKE ?";
            $params[] = "%{$search}%";
        }

        // Get total count
        $total_query = $this->db->query("SELECT COUNT(*) AS total $base_query", $params);
        $total = $total_query->row()->total;

        // Add pagination
        $base_query .= " LIMIT ?, ?";
        $params[] = (int)$start;
        $params[] = (int)$length;

        // Execute final query
        $query = $this->db->query($select_clause . $base_query, $params);

        return [
            'total' => $total,
            'filtered' => $total,
            'data' => $query->result_array()
        ];
    }







    public function get_table_wise_data($table_name)
    {
        $query = $this->db->query("
            SELECT 
                STATE_NAME,
                total_count,
                up_count,
                down_count,
                other_count,
                matched_lgdcode_count,
                unmatched_lgdcode_count
            FROM `$table_name`
        ");
        return $query->result_array();
    }

    public function get_unmatched_details($state_Name, $table_name)
    {
        $table_name = $this->db->escape_str($table_name);
        $state_Name_escaped = $this->db->escape($state_Name);

        $query = $this->db->query("
            SELECT 
                g.STATE_NAME, g.District, g.Block, g.GP_Name, g.GP_Code, 
                g.Latitude, g.Longitude, g.DoT_Nodal_Officer_Name, g.No_of_FTTH_Connections
            FROM `4012_gps` g
            LEFT JOIN `$table_name` s ON g.GP_Code = s.lgdcode
            WHERE g.STATE_NAME = $state_Name_escaped AND s.lgdcode IS NULL
        ");

        return $query->result_array();
    }
















































    public function get_up_details_query_12Days($prev_month = null, $prev_day = null, $prev_ndays = null, $state_name, $table_name, $search, $start, $length)
    {


        $base_query = "
        FROM `4012_gps` g
        LEFT JOIN (
            SELECT SUBSTRING_INDEX(ONT_LOCATION_CODE, '-', -1) AS Code_LastPart, ONT_AVAILABILITY_per_ 
            FROM `$prev_month`
        ) s1 ON g.GP_Code = s1.Code_LastPart
        LEFT JOIN (
            SELECT SUBSTRING_INDEX(LOCATION_CODE, '-', -1) AS Code_Lastday, ONT_AVAILABILITY 
            FROM `$prev_day`
        ) s3 ON g.GP_Code = s3.Code_Lastday

        LEFT JOIN (
            SELECT 
                SUBSTRING_INDEX(LOCATION_CODE, '-', -1) AS Code_N_days, 
                *
            FROM `$prev_ndays`
        ) s4 ON g.GP_Code = s4.Code_N_days

        INNER JOIN (
            SELECT lgdcode FROM `$table_name` WHERE status LIKE '%UP%'
        ) s2 ON g.GP_Code = s2.lgdcode
        WHERE g.STATE_NAME = ?
    ";

        $params = [$state_name];

        if (!empty($search)) {
            $base_query .= " AND g.GP_Name LIKE ?";
            $search_term = "%{$search}%";
            $params[] = $search_term;
        }

        // Get total count
        $total_query = $this->db->query("SELECT COUNT(*) as total $base_query", $params);
        $total = $total_query->row()->total;

        // Pagination
        $base_query .= " LIMIT ?, ?";
        $params[] = (int)$start;
        $params[] = (int)$length;


        preg_match('/(\d+)_to_(\d+)_may25/', $prev_ndays, $matches);
        $start_day = (int)$matches[1];
        $end_day = (int)$matches[2];
        $NDay = $end_day - $start_day + 1;
        $currentMonth = date('m');


        $columns = [];
        foreach (range($start_day, $end_day) as $day) {
            if ($day == $start_day) {
                $columns[] = "COALESCE(s4.ONT_AVAILABILITY_per__{$day}_{$currentMonth}, 0)";
            } else {
                $columns[] = "COALESCE(s4.`{$day}_{$currentMonth}`, 0)";
            }
        }
        $columns_sum = implode(' + ', $columns);

        // Now build the dynamic SELECT part
        $avg_expression = "ROUND(({$columns_sum}) / {$NDay}, 2) AS avg_ont_availability";
        $hours_expression = "ROUND((24 * 12 * (({$columns_sum}) / {$NDay}) / 100), 2) AS ont_Ndays_hours";

        // Final query
        $query = $this->db->query("
        SELECT 
            g.GP_Name, 
            s1.ONT_AVAILABILITY_per_,
            CASE 
            WHEN s3.ONT_AVAILABILITY = 0 THEN 'NA'
            ELSE ROUND(s3.ONT_AVAILABILITY)
            END AS ONT_AVAILABILITY,
            $avg_expression,
            $hours_expression,
            ROUND((744 * s1.ONT_AVAILABILITY_per_ / 100), 2) AS ont_monthly__hours,
            CASE 
            WHEN ROUND((24 * s3.ONT_AVAILABILITY / 100), 2) = 0.00 THEN 'NA'
            ELSE ROUND((24 * s3.ONT_AVAILABILITY / 100), 2)
            END AS ont_Per_day_hour
    $base_query
    ", $params);

        return [
            'total' => $total,
            'filtered' => $total, // You can adjust this if additional filters are applied
            'data' => $query->result_array()
        ];
    }
}
