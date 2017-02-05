<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 30/01/17
 * Time: 23:48
 */

namespace App\Model;


use Core\Model\Model;

class ChapterModel extends Model
{
    /**
     * @var string Nom de la table
     */
    public static $table = 'CHAPTER';
    private $_idName = 'id_chapter';

    /**
     * Fonction qui retourne un tableau des chapitres
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT * FROM " . static::$table . " ORDER BY name_chapter";
        $result = $this->executeReq($sql);
        $options = [];
        foreach ($result as $donnees) {
            $options[$donnees[$this->_idName]] = $donnees["name_chapter"];
        }
        return $options;
    }

    /**
     * Fonction qui retourne le nom du chapitre correspondant à l'id
     * @param $id_chapter int
     * @return string
     */
    public function findChapterName($id_chapter)
    {
        $sql = "SELECT name_chapter FROM " . static::$table . " WHERE " . $this->_idName . " = :" . $this->_idName;
        $param = [
            ":".$this->_idName => $id_chapter,
        ];
        $result = $this->executeReq($sql, $param, 1);
        $result = $result['name_chapter'];
        return $result;
    }

}