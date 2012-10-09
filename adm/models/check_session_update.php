<?php
/**
 * Include file for INSERT, UPDATE and DELETE models
 * 
 * @author Daniel Lee <daniellee@northwestern.edu>
 * @version 1.0
 * @package main
 */

$session = new SessionManager();

/**
 * Not logged on
 */
if ($session->checkAuthentication(false) == false)
{
    print 'Error;The session has been expired. Please sign out and sign in again.';
    exit;
}

// Check the key value is set correctly
if (empty($_REQUEST['id']))
{
    print 'Error;Invalid parameter passed [Null]'; exit;
}
?>