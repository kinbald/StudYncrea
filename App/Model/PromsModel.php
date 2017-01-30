<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 18:11
 */

namespace App\Model;


use Core\Model\Model;

class PromsModel extends Model
{
    /**
     * @var string Nom de la table
     */
    public static $table = 'PROMS';
    private $_idName = 'id_class';

    /**
     * @return array Classes inscrites dans la BDD
     */
    public function all()
    {
        $proms = $this->executeReq("SELECT * FROM " . static::$table . " ORDER BY name_class");
        $options = [];
        foreach ($proms as $class) {
            $options[$class[$this->_idName]] = $class['name_class'];
        }
        return $options;
    }

    public function findClassName($id_class)
    {
        $sql = "SELECT name_class FROM " . static::$table . " WHERE " . $this->_idName . " = : " . $this->_idName;;
        $param = [
            $this->_idName => $id_class,
        ];
        $result = $this->executeReq($sql, $param, 1);
        $result = $result['name_class'];
        return $result;
    }
}