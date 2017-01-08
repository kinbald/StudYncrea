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
        $proms = $this->executeReq("SELECT * FROM " . static::$table);
        $options = [];
        foreach ($proms as $class) {
            $options[$class['id_class']] = $class['name_class'];
        }
        return $options;
    }
}