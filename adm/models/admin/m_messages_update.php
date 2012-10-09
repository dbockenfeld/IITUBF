<?php
/**
 * INSERT, UPDATE and DELETE model for eBrochure Department
 * 
 * @author Daniel Lee <daniellee@northwestern.edu>
 * @version 1.0
 * @package main
 */
            
require_once('../../config.php');
require_once('../check_session_update.php');

// connect to the default database
$dbm = DBManager::getInstance();

switch($_POST['oper'])
{
    case 'add': // $_POST['id'] == '_empty'
        $sql  = "INSERT INTO ebr_departments ";
        $sql .= "   SET name = '".$dbm->escapeString($_POST['name'])."', ";
        $sql .= "       category = 'ADD', ";
        $sql .= "       display = '".$dbm->escapeString($_POST['display'])."' ";
        break;
    case 'edit':
        $sql  = "UPDATE ebr_departments ";
        $sql .= "   SET name = '".$dbm->escapeString($_POST['name'])."', ";
        $sql .= "       display = '".$dbm->escapeString($_POST['display'])."' ";
        $sql .= " WHERE id = '".$dbm->escapeString($_POST['id'])."' ";
        break;
    case 'del':
        $sql  = "UPDATE ebr_departments ";
        $sql .= "   SET deleted = '1' ";
        $sql .= " WHERE id = '".$dbm->escapeString($_POST['id'])."' ";
        break;
    default:
        print 'Error;Invalid operation ['.$_POST['oper'].']'; 
        exit;
}
//print 'Error;Invalid operation ['.$sql.']'; exit;
$result = $dbm->doQuery($sql);
if ($result === "SQLERROR")
    print 'Error;The system is unable to process the request. Please try again later.';
?>