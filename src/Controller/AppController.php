<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
	public function initialize() {
		$this->loadComponent ( 'Flash' );
		$this->loadComponent ( 'Auth', [ 
				'authorize' => [ 
						'Controller' 
				], // Added this line
				'loginRedirect' => [ 
						'controller' => 'Gears',
						'action' => 'gear' 
				],
				'logoutRedirect' => [ 
						'controller' => 'Gears',
						'action' => 'gear',
						'home' 
				] 
		] );
	}
	public function isAuthorized($user) {
		// All registered users can add articles
		if ($this->request->action === 'add' or 'search' or 'gear') {
			return true;
		}
		
		// The owner of an article can edit and delete it
		if (in_array ( $this->request->action, [ 
				'edit',
				'delete' 
		] )) {
			$articleId = ( int ) $this->request->params ['pass'] [0];
			if ($this->Articles->isOwnedBy ( $articleId, $user ['id'] )) {
				return true;
			}
		}
		
		return parent::isAuthorized ( $user );
	}
	public function beforeFilter(Event $event) {
		$this->Auth->allow ( [ 
				'index',
				'view',
				'display' 
		] );
	}
	
	function get_youtube($url){
	
		$youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";
	
		$curl = curl_init($youtube);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
	
	}
}
