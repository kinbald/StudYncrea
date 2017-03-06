<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 17:06
     */
    
    namespace App\Model;
    
    
    use Core\Model\Model;
    
    class ReportModel extends Model
    {
        public static $table = 'REPORTS';
        private $_idName = 'id_report';
        
        public function deleteReport($id_report)
        {
            if($this->executeReq("SELECT id_report FROM " . static::$table . " WHERE id_report=$id_report", null, -1) != FALSE)
            {
                $this->executeReq("DELETE FROM " . static::$table . " WHERE id_report=?", [$id_report], 0);
            }
        }
        
        public
        function getAllReports()
        {
            $sql = "SELECT * FROM " . static::$table . " ORDER BY date_report DESC";
            return $this->executeReq($sql, null, 2);
        }
        
        public
        function getReport($id_report)
        {
            $sql = "SELECT * FROM " . static::$table . " WHERE id_report=?";
            return $this->executeReq($sql, [$id_report], 1);
        }
        
        public
        function getAllReportsAboutComments()
        {
            $sql = "SELECT * FROM " . static::$table . " WHERE id_post IS NULL ORDER BY date_report DESC";
            return $this->executeReq($sql, null, 2);
        }
        
        public
        function getAllReportsAboutPosts($type = -1)
        {
            if ($type == -1)
            {
                $sql = "SELECT * FROM " . static::$table . " WHERE id_comment IS NULL ORDER BY date_report DESC";
            }
            else
            {
                $sql = "SELECT * FROM " . static::$table . " WHERE id_comment IS NULL AND type_post=$type ORDER BY date_report DESC";
            }
            return $this->executeReq($sql, null, 2);
        }
        
        public
        function addReport($reason, $type_report, $id_user, $id_post = NULL, $id_comment = NULL)
        {
            if ($id_post == NULL && $id_comment == NULL)
            {
                throw new \Exception('Cannot add report');
            }
            $date = date('Y-m-d G:i:s');
            $id_report = $this->lastInsertId($this->getIdName());
            $id_report = $id_report === FALSE ? 1 : $id_report + 1;
            
            $sql = "INSERT INTO " . static::$table . " (id_report, reason, date_report, type_report, id_user, id_post, id_comment) VALUES (?,?,?,?,?,?,?)";
            $params =
                [
                    $id_report,
                    $reason,
                    $date,
                    $type_report,
                    $id_user,
                    $id_post,
                    $id_comment
                ];
            return $this->executeReq($sql, $params, 0);
        }
        
        /**
         * @return string
         */
        public
        function getIdName()
        {
            return $this->_idName;
        }
    }