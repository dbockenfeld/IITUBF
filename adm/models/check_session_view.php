<?php
/**
 * Include file for SELECT models
 * 
 * @author Daniel Lee <daniellee@northwestern.edu>
 * @version 1.0
 * @package main
 */

$session = new SessionManager();

/**
 * If not logged on, display error message
 */
if ($session->checkAuthentication(false) == false)
{
    header("HTTP/1.0 404 Not found error");
    print 'The session has been expired. Please sign out and sign in again.';
    exit;
}
?>