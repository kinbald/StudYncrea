<?php

namespace App;

/**
 * Classe permettant de générer des champs de formulaire rapidement
 *
 * $form = new Form($data[]);  => tableau $data permet de pré-remplir certains champs à l'aide du nom envoyé dans les champs
 * $form->input('text', 'prenom', 'Prénom', true);
 * $form->input('email', 'email', 'Email');
 * $form->submit('Envoyer', 'light-blue', 'input');
 * $form->textArea('message', 'Votre texte');
 * $form->fileInput('annale', 'Veuillez entrer une annale :', true, 'light-blue');
 *
 *
 * $options = [
 *      '1' => 'Post',
 *      '2' => 'Annale'
 *]
 * $form->selectInput('type', 'Type d\'envoi', $options, true)
 *
 * @author Guillaume Desrumaux
 * @date 29/11/16
 */
class Form
{
    /**
     * @var array Champs pré-remplis
     */
    private $_data;

    /**
     * Form constructor.
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->_data = $data;
    }

    /**
     * Permet d'entourer du texte par un tag html (modèle materialize)
     * @param $content string Texte à entourer
     * @return string Texte entouré
     */
    private function surroundWith($content)
    {
        $div = '<div class="input-field col s12">';
        return $div . $content . '</div>';
    }

    /**
     * Fonction permettant de récuperer la valeur pré-remplie d'un champ à l'aide de la valeur 'name'
     * @param $index string Nom du champ
     * @return string|null Valeur du champ
     */
    private function getValue($index)
    {
        return isset($this->_data[$index]) ? $this->_data[$index] : null;
    }

    /**
     * Permet de génerer des champs
     * @param string $type Type du champ
     * @param string $name Nom du champ (aussi ID)
     * @param string $label Label du champ / Texte présenté à côté
     * @param bool $required Choix si nécessaire pour l'envoi
     */
    public function input($type, $name, $label, $required = false)
    {
        if ($required === true) {
            echo $this->surroundWith("<input required name=\"$name\" value=\"" . $this->getValue($name) . "\" id=\"$name\" type=\"$type\" class=\"validate\">
                <label for=\"$name\">$label</label>");

        } else {
            echo $this->surroundWith("<input name=\"$name\" value=\"" . $this->getValue($name) . "\" id=\"$name\" class=\"validate\" type=\"$type\">
                <label for=\"$name\">$label</label>");

        }
    }

    /**
     * Création d'un bouton submit
     * @param string $text Texte du bouton
     * @param string|null $class Classe à ajouter au bouton
     * @param string|null $icon Nom de l'icone à ajouter
     */
    public function submit($text, $class = null, $icon = null)
    {
        if ($icon) {
            echo $this->surroundWith("<button class=\"btn waves-effect waves-light $class\" type=\"submit\">
$text<i class=\"material-icons left\">$icon</i>");
        } else {
            echo $this->surroundWith("<button class=\"btn waves-effect waves-light $class\" type=\"submit\">$text");
        }
    }

    /**
     * Permet d'ajouter une zone de texte
     * @param string $name Nom du champ
     * @param string $label Label du champ
     * @param bool $required Choix si nécessaire pour l'envoi
     */
    public function textArea($name, $label, $required = false)
    {
        if ($required === true) {
            echo $this->surroundWith("<textarea id=\"$name\" required class=\"validate materialize-textarea\">" . $this->getValue($name) . "</textarea>
          <label for=\"$name\">$label</label>");
        } else {
            echo $this->surroundWith("<textarea id=\"$name\" class=\"validate materialize-textarea\">" . $this->getValue($name) . "</textarea>
          <label for=\"$name\">$label</label>");
        }
    }

    /**
     * Fonction permettant de générer un champ de type fichier
     * @param string $name Nom du champ
     * @param string $label Label du champ
     * @param bool $required Choix si nécessaire ou non
     * @param null|string $class Classe CSS à ajouter au bouton
     */
    public function fileInput($name, $label, $required = false, $class = null)
    {
        if ($required === true) {
            echo "<div class=\"file-field input-field\">
                <div class=\"btn $class\">
                    <span>$label</span>
                    <input name=\"$name\" required id=\"$name\"type=\"file\">
                </div>
                <div class=\"file-path-wrapper\">
                    <input class=\"file-path validate\" type=\"text\">
                </div>
               </div>";
        } else {
            echo "<div class=\"file-field input-field\">
                <div class=\"btn $class\">
                    <span>$label</span>
                    <input name=\"$name\" id=\"$name\"type=\"file\">
                </div>
                <div class=\"file-path-wrapper\">
                    <input class=\"file-path validate\" type=\"text\">
                </div>
               </div>";
        }
    }

    /**
     * Fonction permettant de créer un select en envoyant un tableau associatif pour les différents choix
     * @param string $name Nom / Id du select
     * @param string $label Label du select
     * @param array $options Différentes options du select
     * @param bool $required Choix nécessaire ou non à l'envoi du formulaire
     */
    public function selectInput($name, $label, $options, $required = false)
    {
        if ($required === true) {
            echo "<div class=\"input-field col s12\">
                            <select name=\"$name\" required>
                                    <option value=\"0\" disabled selected>$label</option>";
            foreach ($options as $option => $value) {
                echo "<option value=\"$option\">$value</option>";
            }
            echo "</select><label>$label</label></div>";
        } else {
            echo "<div class=\"input-field col s12\">
                            <select name=\"$name\">
                                    <option value=\"\" disabled selected>$label</option>";
            foreach ($options as $option => $value) {
                echo "<option value=\"$option\">$value</option>";
            }
            echo "</select><label>$label</label></div>";
        }
    }

    /**
     * Fonction permettant de créer un select en envoyant un tableau associatif pour les différents choix
     * @param string $name Nom / Id du select
     * @param string $label Label du select
     * @param array $options Différentes options du select
     * @param string $initValue
     * @param string $initName
     * @param bool $required Choix nécessaire ou non à l'envoi du formulaire
     */
    public function selectInputInit($name, $label, $options, $initValue = null, $initName = null, $required = false)
    {

        if ($required === true) {
            if ($initValue != null && $initName != null) {
                echo "<div class=\"input-field col s12\">
                            <select name=\"$name\" required>
                                   <option value=\"$initValue\">$initName</option>";
                foreach ($options as $option => $value) {
                    echo "<option value=\"$option\">$value</option>";
                }
                echo "</select><label>$label</label></div>";
            } else {

                echo "<div class=\"input-field col s12\">
                            <select name=\"$name\" required>
                                    <option value=\"0\" disabled selected>$label</option>";
                foreach ($options as $option => $value) {
                    echo "<option value=\"$option\">$value</option>";
                }
                echo "</select><label>$label</label></div>";
            }
        } else {
            echo "<div class=\"input-field col s12\">
                            <select name=\"$name\">
                                    <option value=\"\" disabled selected>$label</option>";
            foreach ($options as $option => $value) {
                echo "<option value=\"$option\">$value</option>";
            }
            echo "</select><label>$label</label></div>";
        }
    }
}
