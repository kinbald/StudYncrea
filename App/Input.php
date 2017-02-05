<?php
/**
 * Created by IntelliJ IDEA.
 * User: chamayou
 * Date: 16/12/16
 * Time: 15:13
 */

namespace App;


class Input
{
    private $data;
    private $errors = [];

    public function __construct($data, $max_size = 0,$extension = 0,$length_pseudo_password = 0)
    {
        $this->data = $data;
        $this->max_size = $max_size;
        $this->extension = $extension;
        $this->length_pseudo_password =$length_pseudo_password;
    }

    private function getField($field,$type)
    {
        if (!isset($this->data[$field])) {
            $this->errors[$type] = "Le champ n'est pas rempli.";
            return null;
        }
        return $this->data[$field];
    }

    public function check_email($fieldName,$type)
    {
        $regex1 = "#^[a-z0-9._-]+@yncrea.fr#";
        $regex2 = "#^[a-z0-9._-]+@isen.yncrea.fr#";

        $field = $this->getField($fieldName, $type);

        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            if (preg_match($regex1, $field) || preg_match($regex2, $field)) {
                $infos = $this->email($field);
                return $infos;
            } else {
                $this->errors[$type] = "L'adresse email n'est pas de type @isen.yncrea.fr ou @yncrea.fr . ";
                return false;
            }
        } else {
            $this->errors[$type] = "L'adresse email n'est pas correcte.";
            return false;
        }
    }

    public function check_text($field,$type){
        if(is_string($field)){
            return true;
        }
        else{
            $this->errors[$type] = "Ce n'est pas du texte.";
            return false;
        }

    }

    public function check_int($field,$type){
        if(is_int($field)){
            return true;
        }
        else{
            $this->errors[$type] = "Ce n'est pas un entier.";
            return false;
        }

    }

    public function check_float($field,$type){
        if(is_float($field)){
            return true;
        }
        else{
            $this->errors[$type] = "Ce n'est pas un nombre décimal.";
            return false;
        }

    }

    public function check_file($field,$max_size,$extension,$type){
        if($_FILES[$field]['size'] > 0){
            if($_FILES[$field]['size']<=$max_size){
                $extension_upload = strtolower(  substr(  strrchr($_FILES[$field]['name'], '.')  ,1)  );
                if ( in_array($extension_upload,$extension) ){
                    return $extension_upload;
                }else{
                    $this->errors[$type] = "Extension incorrect.";
                    return false;
                }
            }else{
                $this->errors[$type] = "Taille du fichier trop grande.";
                return false;
            }
        }else{
            $this->errors[$type] = "Aucun fichier séléctionné ou erreur du transfert.";
            return false;
        }

    }

    public function check_pseudo_password($fieldName,$length_pseudo_password,$type)
    {
        $field = $this->getField($fieldName, $type);
        $field = $this->pseudo_password($field);
        if($this->check_text($field,$type)) {
            if (strlen($field) >= $length_pseudo_password) {
                return true;
            } else {
                $this->errors[$type] = "Taille du mot de passe trop courte (min = 5 charactères).";
                return false;
            }
        }else{
            $this->errors[$type] = "Ce n'est pas du texte.";
            return false;
        }
    }

    public function check_date($field, $type)
    {
        if($this->check_text($field, $type))
        {
            $date = explode('/', $field);
            if(count($date) === 3) {
                if (checkdate($date[1], $date[0], $date[2]) === TRUE) {
                    return true;
                }
            }
            else
            {
                $this->errors[$type] = 'Cette date est incorrecte';
                return false;
            }
        }else{
            $this->errors[$type] = "Ce n'est pas du texte.";
            return false;
        }
    }

    public function text($fieldName)
    {
        $field = $this->getField($fieldName, 'text');
        return filter_var($field,FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function pseudo_password($field){
        return str_replace(' ','',$field);
    }

    public function email($field){
        $email_tmp1 = explode('.', $field);
        $email_tmp2 = explode('@',$email_tmp1[1]);
        $info['prenom'] = ucfirst($email_tmp1[0]);
        $info['nom'] = ucfirst($email_tmp2[0]);
        return $info;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
