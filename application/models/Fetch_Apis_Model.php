<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fetch_Apis_Model extends CI_Model
{

  public function getprofile($userid)
  {
    $query = $this->db->select('firstName,lastName,emailId,mobileNumber,regDate')
      ->where('id', $userid)
      ->from('tblusers')
      ->get();
    return $query->row();
  }

  public function get_statewise_data($table_name, $limit, $start, $search = '')
  {

    // SUM(CASE WHEN status LIKE '%UP%' THEN 1 ELSE 0 END) AS status_up,
    // SUM(CASE WHEN status LIKE '%DOWN%' THEN 1 ELSE 0 END) AS status_down

    $this->db->select(
      "stateName, COUNT(*) as state_count,
    SUM(CASE WHEN status LIKE '%UP%' THEN 1 ELSE 0 END) AS status_up,
    SUM(CASE WHEN status LIKE '%DOWN%' THEN 1 ELSE 0 END) AS status_down,
    SUM(CASE WHEN status LIKE '%NOC' THEN 1 ELSE 0 END) AS others

        "
    );
    $this->db->from($table_name);

    if (!empty($search)) {
      $this->db->like('stateName', $search);
    }

    $this->db->group_by('stateName');
    $this->db->limit($limit, $start);
    return $this->db->get()->result();
  }


  public function get_statewise_count($stateName = '', $table_name, $search = '')
  {
    $this->db->from($table_name);

    if (!empty($search)) {
      $this->db->like('stateName', $search);
    }

    if (!empty($stateName)) {
      $this->db->where('stateName', $stateName);
      return $this->db->count_all_results();
    } else {
      $this->db->select('COUNT(DISTINCT stateName) as count');
      $result = $this->db->get()->row();
      return $result ? (int)$result->count : 0;
    }
  }

  public function get_total_state_gp_count($table_name, $search = '')
  {
    $this->db->select('COUNT(*) as total');
    $this->db->from($table_name);

    if (!empty($search)) {
      $this->db->like('stateName', $search);
    }

    $result = $this->db->get()->row();
    return $result ? (int)$result->total : 0;
  }





  public function get_state_data($stateName, $table_name)
  {
    return $this->db->get_where($table_name, ['stateName' => $stateName])->result();
  }



  // public function get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length)
  // {
  //   $this->db->from($tableName);
  //   // $this->db->select('*')->from("`$table_name`");

  //   if (!empty($stateName) && !empty($status)) {
  //     $this->db->where('stateName', $stateName);
  //     $this->db->where('status', $status);
  //   }

  //   if (!empty($stateName)) {
  //     $this->db->where('stateName', $stateName);

  //     if (!empty($distName)) {
  //       $this->db->where('districtName', $distName);

  //       if (!empty($blockName)) {
  //         $this->db->where('blockName', $blockName);
  //       }
  //     }
  //   }

  //   $this->db->order_by('stateName ASC');
  //   $this->db->limit($length, $start);
  //   return $this->db->get()->result_array();
  // }


  // public function get_state_data_count($status, $blockName, $distName, $stateName, $tableName)
  // {
  //   $this->db->from($tableName);

  //   if (!empty($stateName) && !empty($status)) {
  //     $this->db->where('stateName', $stateName);
  //     $this->db->where('status', $status);
  //   }

  //   if (!empty($stateName)) {
  //     $this->db->where('stateName', $stateName);

  //     if (!empty($distName)) {
  //       $this->db->where('districtName', $distName);

  //       if (!empty($blockName)) {
  //         $this->db->where('blockName', $blockName);
  //       }
  //     }
  //   }

  //   return $this->db->count_all_results();
  // }

  public function get_state_data_paginated($status = null, $blockName = null, $distName = null, $stateName = null, $tableName, $start = 0, $length = 10)
  {
    $this->db->from($tableName);

    // Flexible WHERE conditions
    if (!empty($stateName)) {
      $this->db->where('stateName', $stateName);
    }
    if (!empty($distName)) {
      $this->db->where('districtName', $distName);
    }
    if (!empty($blockName)) {
      $this->db->where('blockName', $blockName);
    }
    // if (!empty($status)) {
    //   $this->db->where('status', $status);
    // }
    if (!empty($status)) {
      $this->db->like('status', $status);
    }


    $this->db->order_by('stateName', 'ASC');
    $this->db->limit($length, $start);

    return $this->db->get()->result_array();
  }

  public function get_state_data_count($status = null, $blockName = null, $distName = null, $stateName = null, $tableName)
  {
    $this->db->from($tableName);

    // Flexible WHERE conditions
    if (!empty($stateName)) {
      $this->db->where('stateName', $stateName);
    }
    if (!empty($distName)) {
      $this->db->where('districtName', $distName);
    }
    if (!empty($blockName)) {
      $this->db->where('blockName', $blockName);
    }
    if (!empty($status)) {
      $this->db->like('status', $status);
    }
    // if (!empty($status)) {
    //   $this->db->where('status', $status);
    // }

    return $this->db->count_all_results();
  }



  public function get_districtwise_data($stateName, $table_name)
  {
    $this->db->select('districtName, COUNT(*) as district_count');
    $this->db->from($table_name);
    $this->db->where('stateName', $stateName);
    $this->db->group_by('districtName');

    // Check if 'length' and 'start' are set (DataTables uses them)
    $length = isset($_GET['length']) ? (int) $_GET['length'] : -1;
    $start = isset($_GET['start']) ? (int) $_GET['start'] : 0;

    if ($length != -1) {
      $this->db->limit($length, $start);
    }

    return $this->db->get()->result();
  }


  public function count_all_districts($stateName, $table_name)
  {
    $this->db->select('districtName');
    $this->db->from($table_name);
    $this->db->where('stateName', $stateName);
    $this->db->group_by('districtName');
    return $this->db->count_all_results();
  }

  public function count_filtered_districts($stateName, $table_name)
  {
    return $this->count_all_districts($stateName, $table_name); // If no search/filter applied
  }

  public function get_block_data($stateName, $districtName, $tableName, $start, $length)
  {
    $query = $this->db->query("
        SELECT blockName, COUNT(*) AS block_count
        FROM `$tableName`
        WHERE `stateName` = ? AND `districtName` = ?
        GROUP BY blockName
        LIMIT ?, ?", [$stateName, $districtName, $start, $length]);

    $records = $query->result_array();

    // Total count without limit
    $count_query = $this->db->query("
        SELECT COUNT(DISTINCT blockName) AS cnt
        FROM `$tableName`
        WHERE `stateName` = ? AND `districtName` = ?", [$stateName, $districtName]);

    $total = $count_query->row()->cnt;

    // Add hyperlink
    foreach ($records as $i => $row) {
      $safeBlock = str_replace(['/', ' '], ['_slash_', '_'], $row['blockName']);
      $safeTable = str_replace(['/', ' '], ['_slash_', '_'], $tableName);
      $safeState = str_replace(['/', ' '], ['_slash_', '_'], $stateName);
      $safeDist = str_replace(['/', ' '], ['_slash_', '_'], $districtName);

      $records[$i] = array(
        'id' => $start + $i + 1,
        'blockName' => "{$row['blockName']}</a>",
        'block_count' => "<a href='" . site_url("user/Fetchallindata/block_count_data/$safeBlock/$safeDist/$safeState/$safeTable") . "'>{$row['block_count']}</a>"
      );
    }


    return ['records' => $records, 'total' => $total];
  }

  public function get_all_export_data($distName, $stateName, $tableName, $blockName = null)
  {
    $this->db->from($tableName);

    if (!empty($stateName)) {
      $this->db->where('stateName', $stateName);
    }

    if (!empty($distName)) {
      $this->db->where('districtName', $distName);
    }

    if (!empty($blockName)) {
      $this->db->where('blockName', $blockName);
    }

    return $this->db->get()->result_array();
  }
}
