<?php

/** The coin summary controller.
 * This is used for adding coin summaries for the hoard record.
 * @author Mary Chester-Kadwell <mchester-kadwell at britishmuseum.org>
 * @author Daniel Pett <dpett at britishmuseum.org>
 * @category   Pas
 * @package Pas_Controller_Action
 * @subpackage Admin
 * @copyright  Copyright (c) 2014 Mary Chester-Kadwell
 * @copyright  Copyright (c) 2011 DEJ Pett dpett @ britishmuseum . org
 * @license http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero GPL v3.0
 * @version 1
 */
class Database_SummaryController extends Pas_Controller_Action_Admin
{

    /** The redirect for index */
    const REDIRECT = '/';

    /** The form
     * @access protected
     */
    protected $_form;

    /** Get the Summary model
     * @access protected
     * @var
     */
    protected $_model;

    /** Get the form
     * @return \CoinSummaryForm
     */
    public function getForm()
    {
        $this->_form = new CoinSummaryForm();
        return $this->_form;
    }

    /** Get the model
     * @access public
     * @return \CoinSummary
     */
    public function getModel()
    {
        $model = new CoinSummary();
        return $model;
    }

    /** Init all the permissions in ACL.
     * @access public
     * @return void
     */
    public function init()
    {
        $this->_helper->_acl->deny('public', null);
        $this->_helper->_acl->allow('member', array('index'));
        $this->_helper->_acl->allow('member', array('add', 'delete', 'edit'));
    }

    /** Index action for coin summary
     * @return void
     * @access public
     */
    public function indexAction()
    {
        $this->getFlash()->addMessage('You cannot access the summary index.');
        $this->getResponse()->setHttpResponseCode(301)
            ->setRawHeader('HTTP/1.1 301 Moved Permanently');
        $this->redirect(self::REDIRECT);
    }

    /** Action for adding coin summary
     * @access public
     */
    public function addAction()
    {
        $form = $this->getForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())) {
            // Get the data to add
            $this->getModel()->add($form->getValues());
            $this->getFlash()->addMessage('You have added a summary record');
            $this->redirect();
        } else {
            $form->populate($this->_request->getPost());
        }
    }

    /** Edit action for coin summary
     * @access public
     */
    public function editAction()
    {
        if ($this->_getParam('id', false)) {
            $form = $this->getForm();
            $this->view->form = $form;
            if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())) {
                //Where array
                $where = array();
                $where[] = $this->getModel()->getAdapter()->quoteInto('id = ?', $this->_getParam('id'));
                //Set up auditing
                $oldData = $this->getModel()->fetchRow('id=' . $this->_getParam('id'))->toArray();

                //Get the data and update based on where value
                $this->getModel()->update($form->getValues(), $where);
                $this->_helper->audit(
                    $updateData,
                    $oldData,
                    'SummaryAudit',
                    $this->_getParam('id'),
                    $this->_getParam('id')
                );
                $this->getFlash()->addMessage('You have edited data successfully');
                $this->redirect();
            } else {
                $form->populate($this->_request->getPost());
            }

        } else {
            throw new Pas_Exception($this->_missingParameter, 500);
        }
    }

    /** Delete action for coin summary
     */
    public function deleteAction()
    {

    }
}