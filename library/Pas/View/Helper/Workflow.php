<?php

/**
 * A view helper for displaying workflow icons
 *
 * An example of use:
 * <code>
 * <?php
 * echo $this->workflow()->setWorkflow(1);
 * ?>
 * </code>
 *
 * @author Daniel Pett <dpett at britishmuseum.org>
 * @category   Pas
 * @package    View
 * @subpackage Helper
 * @copyright  Copyright (c) 2011 dpett @ britishmuseum.org
 * @license http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero GPL v3.0
 * @uses Zend_View_Helper_Abstract
 * @uses Zend_Exception
 * @example /app/views/scripts/email/informFinderWorkflow.phtml
 */
class Pas_View_Helper_Workflow extends Zend_View_Helper_Abstract
{

    /** Default workflow status
     * @access protected
     * @var int
     */
    protected $_secwfstage = 1;

    /** Get the workflow stage
     * @access public
     * @return type
     */
    public function getSecwfstage()
    {
        return $this->_secwfstage;
    }

    /** Set the Workflow status
     * @access public
     * @param  int $secwfstage
     * @return \Pas_View_Helper_Workflow
     */
    public function setWorkflow($secwfstage)
    {
        $this->_secwfstage = $secwfstage;
        return $this;
    }

    /** The workflow class
     * @access public
     * @return \Pas_View_Helper_Workflow
     */
    public function workflow()
    {
        return $this;
    }

    /** The magic to string method
     * @access public
     * @return type
     */
    public function __toString()
    {
        return $this->_buildHtml();
    }

    /** Render the html string
     * @access public
     * @return string
     * @throws Zend_Exception
     */
    public function _buildHtml()
    {
        switch ($this->getSecwfstage()) {
            case 1:
                $wf = 'quarantine.png';
                $alt = 'Find in quarantine';
                break;
            case 2:
                $wf = 'flag_red.gif';
                $alt = 'Find on review';
                break;
            case 4:
                $wf = 'flag_orange.gif';
                $alt = 'Find awaiting validation';
                break;
            case 3:
                $wf = 'flag_green.gif';
                $alt = 'Find published';
                break;
            default:
                throw new Zend_Exception('No workflow status set', 500);
        }
        $imageTag = '<img src="';
        $imageTag .= $this->view->serverUrl() . $this->view->baseUrl();
        $imageTag .= '/assets/icons/';
        $imageTag .= $wf;
        $imageTag .= '" width="16" height="16"';
        $imageTag .= 'alt="';
        $imageTag .= $alt;
        $imageTag .= '"/>';

        return $imageTag;
    }
}