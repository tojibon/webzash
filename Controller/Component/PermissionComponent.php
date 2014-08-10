<?php
/**
 * The MIT License (MIT)
 *
 * Webzash - Easy to use web based double entry accounting software
 *
 * Copyright (c) 2014 Prashant Shah <pshah.mumbai@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

App::uses('Component', 'Controller');

/**
 * Webzash Plugin Permission Component
 *
 * @package Webzash
 * @subpackage Webzash.controllers
 */
class PermissionComponent extends Component {

	public $components = array('Session');
/**
 * Check if a role stored in session is allow a particular action
 *
 * @return boolean return true is access is allow, false otherwise
 */
	public function is_allowed($action_name, $role)
	{
		$permissions['manager'] = array(
			'view accounts chart',

			'view entry',
			'add entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',

			'view entrytype',
			'add entrytype',
			'edit entrytype',
			'delete entrytype',

			'add ledger',
			'edit ledger',
			'delete ledger',

			'add group',
			'edit group',
			'delete group',

			'view tag',
			'add tag',
			'edit tag',
			'delete tag',

			'access reports',

			'view log',
			'clear log',

			'change account settings',
			'cf account',
			'backup account',

			'access admin section',
		);
		$permissions['accountant'] = array(
			'view accounts chart',

			'view entry',
			'add entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',

			'add ledger',
			'edit ledger',
			'delete ledger',

			'add group',
			'edit group',
			'delete group',

			'view tag',
			'add tag',
			'edit tag',
			'delete tag',

			'access reports',
		);
		$permissions['dataentry'] = array(
			'view accounts chart',

			'view entry',
			'add entry',
			'edit entry',
			'print entry',
			'email entry',
			'download entry',

			'add ledger',
			'edit ledger',
		);
		$permissions['guest'] = array(
			'view accounts chart',

			'view entry',
			'print entry',
			'email entry',
			'download entry',
		);

		if (!isset($role)) {
			$this->Session->setFlash(__d('webzash', 'Access denied.'), 'error');
			return false;
		}

		/* If user is admin then always allow full access */
		if ($role == 'admin') {
			return true;
		}

		/* If invaid user role then deny access */
		if (!isset($permissions[$role])) {
			$this->Session->setFlash(__d('webzash', 'Access denied.'), 'error');
			return false;
		}

		/* If action is registered then only check if user is logged in */
		if ($action_name == 'registered') {
			if (empty($role)) {
				$this->Session->setFlash(__d('webzash', 'Access denied.'), 'error');
				return false;
			} else {
				return true;
			}
		}

		/* Check if the user role is allowed access */
		if (in_array($action_name, $permissions[$role])) {
			return true;
		} else {
			$this->Session->setFlash(__d('webzash', 'Access denied.'), 'error');
			return false;
		}
	}
}
