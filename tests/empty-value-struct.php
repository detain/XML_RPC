<?php

/**
 * Tests how the XML_RPC server handles a parameter with an empty struct without
 * any spaces in the XML after the empty value.
 *
 * If you are running this test from a SVN checkout, you must rename the working
 * directory from "XML_RPC" to "XML".
 *
 * PHP versions 4 and 5
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  2005-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/XML_RPC
 * @since      File available since Release 1.4.4
 */

/*
 * If the package version number is found in the left hand
 * portion of the if() expression below, that means this file has
 * come from the PEAR installer.  Therefore, let's test the
 * installed version of XML_RPC which should be in the include path.
 * 
 * If the version has not been substituted in the if() expression,
 * this file has likely come from a SVN checkout or a .tar file.
 * Therefore, we'll assume the tests should use the version of
 * XML_RPC that has come from there as well.
 */
if ('@package_version@' != '@'.'package_version'.'@') {
    /**
     * Get the needed class from the PEAR installation
     */
    require_once 'XML/RPC/Server.php';
} else {
    if (substr(dirname(__FILE__), -9, -6) != 'XML') {
        echo "The parent directory must be named 'XML'.\n";
        exit;
    }

    ini_set('include_path', '../../'
            . PATH_SEPARATOR . '.' . PATH_SEPARATOR
            . ini_get('include_path')
    );

    /**
     * Get the needed class from the parent directory
     */
    require_once '../Server.php';
}

$GLOBALS['HTTP_RAW_POST_DATA'] = <<<EOPOST
<?xml version="1.0"?>
<methodCall>
 <methodName>allgot</methodName>
  <params>
   <param>
    <value>
     <struct>
      <member>
      <name>fld1</name><value></value></member></struct></value>
   </param>
  </params>
 </methodCall>
EOPOST;

$expect = <<<EOEXP
<?xml version="1.0" encoding="UTF-8"?>
<methodResponse>
<params>
<param>
<value><string>param 0: array (
  'fld1' =&gt; '',
)
</string></value>
</param>
</params>
</methodResponse>
EOEXP;

include './allgot.inc';
