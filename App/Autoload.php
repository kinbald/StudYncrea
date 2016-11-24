<?php
/**
 * Created by IntelliJ IDEA.
 * User: Kinbald
 * Date: 14/11/16
 * Time: 16:25
 */
 
/**
 * Charge toutes les classes
 */
function loadClass($class)
{
    require_once $class . '.php';
}
spl_autoload_register('loadClass');
