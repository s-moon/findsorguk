<?php
/** A class to access the MapIt api for point based data
 * @category Pas
 * @package Pas_Geo_Mapit
 * @subpackage Point
 * @version 1
 * @since 6/2/12
 * @author Daniel Pett <dpett at britishmuseum.org>
 * @copyright (c) 2014 Daniel Pett
 * @license http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero GPL v3.0
 * @see http://mapit.mysociety.org/
 *
 * USAGE
 *
 * $mapIt = new Pas_Geo_Mapit_Point();
 * $mapIt->setCoordSystem('BRITISH');
 * $mapIt->setX(400000);
 * $mapIt->setY(300000);
 * $mapIt->setCoordinates();
 * OPTIONAL
 * $mapIt->setBox(true);
 * $mapIt->get();
 * No other formats of response available by this method.
 */
class Pas_Geo_Mapit_Point extends Pas_Geo_Mapit {

    /** The api method used
     *
     * @var string
     */
    const APIMETHOD = 'point';

    /** Decide whether to find records within bounding box
     * @access protected
     * @var string
     */
    protected $_box = null;

    /** Decide on your coordinate system
     * @access protected
     * @var string
     */
    protected $_system;

    /** The coordinate string to query, comma separated string
     * @access protected
     * @var string
     */
    protected $_coordinates;

    /** The x coordinate = float or integer
     * @access protected
     * @var unknown_type
     */
    protected $_x;

    /** The y coordinate = float or integer
     * @access protected
     * @var unknown_type
     */
    protected $_y;

    /** Set the coordinate system to use
     * This has been simplified by me to british,irish or WGS84
     * @access public
     * @param $system
     * @return \Pas_Geo_Mapit_Point
     * @throws Pas_Geo_Mapit_Exception
     */
    public function setCoordSystem($system){
        switch($system){
            case 'BRITISH':
                $SRID = 27700;
                break;
            case 'WGS84':
                $SRID = 4326;
                break;
            case 'IRISH':
                $SRID = 29902;
                break;
            default:
                throw new Pas_Geo_Mapit_Exception('Co-ordinate system not available');
        }
        $this->_system = $SRID;
        return $this;
    }

    /** Get the coordinates system used
     * @access public
     * @return string
     */
    public function getCoordSystem(){
        return $this->_system;
    }

    /** Set the x coordinate
     * @access public
     * @param int|float $x
     * @return string
     */
    public function setX($x){
        if(is_int($x)){
            return $this->_x = $x;
        } else {
            throw new Pas_Geo_Mapit_Exception('The x coordinate is not an integer');
        }
    }

    /** Get the x coordinate
     * @access public
     * @return string
     */
    public function getX(){
        return $this->_x;
    }

    /** Set the y coordinate
     * @access public
     * @param int|float $y
     * @return string
     */
    public function setY($y){
        if(is_int($y)){
            return $this->_y = $y;
        } else {
            throw new Pas_Geo_Mapit_Exception('The y coordinate is not an integer');
        }
    }

    /** Get the Y coordinate
     * @access public
     * @return string
     */
    public function getY(){
        return $this->_y;
    }

    /** Set the coordinates from your values
     * @access public
     * @return string
     * @throws Pas_Geo_Mapit_Exception
     */
    public function setCoordinates(){
        if(isset($this->_y) && isset($this->_x)){
            return $this->_coordinates = $this->_x . ',' . $this->_y;
        } else {
            throw new Pas_Geo_Mapit_Exception('Coordinates are malformed');
        }
    }

    /** Get the coordinates
     * @access public
     * @return string 
     */
    public function getCoordinates(){
        return $this->_coordinates;
    }

    /** decide whether to use the bounding box
     * @access public
     * @param $box
     * @return string
     */
    public function setBox($box){
        if(is_bool($box)){
            return $this->_box = 'box';
        }
    }

    /** Use the parent get function to get data and render
     * @access public
     * @return array
     */
    public function get(){
        $params = array(
            $this->_system,
            $this->_coordinates,
            $this->_box
        );
        return parent::get(self::APIMETHOD, $params);
    }
}