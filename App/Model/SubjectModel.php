<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 30/01/17
 * Time: 23:48
 */

namespace App\Model;


use Core\Model\Model;

class SubjectModel extends Model
{
    /**
     * @var string Nom de la table
     */
    public static $table = 'SUBJECTS';
    private $_idName = 'id_subject';

    public function getAll()
    {
        $sql = "SELECT * FROM " . static::$table . " ORDER BY name_subject";
        $result = $this->executeReq($sql);
        $options = [];
        foreach ($result as $donnees) {
            $options[$donnees[$this->_idName]] = $donnees["name_subject"];
        }
        return $options;
    }

    public function findSubjectName($id_subject)
    {
        $sql = "SELECT name_subject FROM " . static::$table . " WHERE " . $this->_idName . " = : " . $this->_idName;;
        $param = [
            $this->_idName => $id_subject,
        ];
        $result = $this->executeReq($sql, $param, 1);
        $result = $result['name_subject'];
        return $result;
    }

}