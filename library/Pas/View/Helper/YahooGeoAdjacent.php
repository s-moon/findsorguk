<?php
/**
 * A view helper that queries the local geo planet database and returns html
 * of adjacent places
 *
 * An example of use:
 *
 * <code>
 * <?php
 * echo $this->yahooGeoAdjacent()->setWoeid($id);
 * ?>
 * </code>
 *
 * @category Pas
 * @package View
 * @subpackage Helper
 * @version 1
 * @license http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero GPL v3.0
 * @copyright Daniel Pett
 * @since 30 September 2011
 * @uses Zend_View_Helper_Url
 * @uses GeoPlaces
 * @author Daniel Pett <dpett at britishmuseum.org>
 * @example /app/views/scripts/partials/database/findSpot.phtml
 *
 */
class Pas_View_Helper_YahooGeoAdjacent extends Zend_View_Helper_Abstract
{
    /** The woeid to query
     * @access protected
     * @var int
     */
    protected $_woeid;

    /** Get the woeid to query
     * @access public
     * @return int
     */
    public function getWoeid() {
        return $this->_woeid;
    }

    /** Set the woeid to query
     * @access public
     * @return int
     */
    public function setWoeid($woeid) {
        $this->_woeid = $woeid;
        return $this;
    }

    /** Get the places from the model
     * @access public
     * @return array
     */
    public function getPlaces() {
        $adjacent = new GeoPlaces();
        return $adjacent->getAdjacent($this->getWoeid());
    }

    /** The function to return
     * @access public
     * @return \Pas_View_Helper_YahooGeoAdjacent
     */
    public function yahooGeoAdjacent() {
        return $this;
    }

    /** Build the html
     * @access public
     * @return string
     */
    public function buildHtml(){
        $html = '';
        $places = $this->getPlaces();
        if (!empty($places) && !is_null($places[0]['Name'])) {
            $html .= '<h3 class="lead">Adjacent places</h3>';
            $html .= '<ul>';
            $html .= $this->view->partialLoop('partials/database/geodata/yahooAdjacent.phtml', $places);
            $html .= '</ul>';
        }
        return $html;
    }

    /** return the string
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->buildHtml();
    }
}