<?php
/**
 * A view helper for creating a url slug
 * @category   Pas
 * @package    View
 * @subpackage Helper
 * @copyright  Copyright (c) 2011 dpett @ britishmuseum.org
 * @license http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero GPL v3.0
 * @see Zend_View_Helper_Abstract
 */
class Pas_View_Helper_Urlslug extends Zend_View_Helper_Abstract
{
    /** Create a url slug with correct characters and a short length
     *
     * @param string $slug
     */
    public function urlslug($slug)
    {
    $result = strtolower($slug);
    $result = preg_replace("/[^a-z0-9\\s-]/", "", $result);
    $result = trim(preg_replace("/\\s+/", " ", $result));
    $result = trim(substr($result, 0, 45));
    $result = preg_replace("/\\s/", "-", $result);

    return $result;
    }
}
