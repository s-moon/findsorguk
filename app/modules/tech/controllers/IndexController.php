<?php
/** Controller for index of Tech section
 *
 * @category   Pas
 * @package    Pas_Controller
 * @subpackage ActionAdmin
 * @author     Mary Chester-Kadwell <mchester-kadwell@britismuseum.org>
 * @copyright  Mary Chester-Kadwell <mchester-kadwell@britismuseum.org>
 * @license    GNU General Public License
 */
class Tech_IndexController extends Pas_Controller_Action_Admin
{

    /** Setup the contexts by action and the ACL.
     */
    public function init(){
        $this->_helper->acl->allow('public', null);
    }
    /** Display content of our linked data page.
     */
    public function indexAction(){
        $content = new Content();
        $this->view->contents = $content->getFrontContent('tech');
    }

}