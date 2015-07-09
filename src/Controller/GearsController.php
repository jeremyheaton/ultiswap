<?php
// src/Controller/TradeablesController.php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;

class GearsController extends AppController {
	public function beforeFilter(Event $event) {
		parent::beforeFilter ( $event );
		// Allow users to register and logout.
		// You should not add the "login" action to allow list. Doing so would
		// cause problems with normal functioning of AuthComponent.
		$this->Auth->allow ( [ 
				'gear',
				'search' 
		] );
	}
	public $helpers = [ 
			'Paginator' => [ 
					'templates' 
			] 
	];
	public $paginate = [ 
			'limit' => 15,
			'order' => [ 
					'Gears.id' => 'asc' 
			] 
	];
	public function initialize() {
		parent::initialize ();
		$this->loadComponent ( 'Paginator' );
	}
	
	// public function isAuthorized($user) {
	// // All registered users can add articles
	// if ($this->request->action === 'add') {
	// return true;
	// }
	
	// // The owner of an article can edit and delete it
	// if (in_array ( $this->request->action, [
	// 'edit',
	// 'delete'
	// ] )) {
	// $articleId = ( int ) $this->request->params ['pass'] [0];
	// if ($this->Articles->isOwnedBy ( $articleId, $user ['id'] )) {
	// return true;
	// }
	// }
	
	// return parent::isAuthorized ( $user );
	// }
	public function search() {
		if ($this->request->is ( 'post' )) {
			return $this->redirect ( '/gears/gear/' . $this->request->data ['search'] );
			
			// ','.shorts.', '.disc.')';
			// if($this->request->data[geartype] = )
			// gears.type in ('jersey','shorts', 'disc') and tags.name like '%swing%'
		}
	}
	public function gear($type = null) {
		$this->loadModel ( "Tags" );
		if ($this->request->is ( 'post' )) {
			$conn = ConnectionManager::get ( 'test' );
			
			$start = "SELECT * from gears join tags on tags.gearid = gears.id where";
			if ($this->request->data ['search'] != '') {
				$start = $start . " tags.name like '%" . $this->request->data ['search'] . "%'";
				if (count ( $this->request->data ) > 1) {
					$start = $start . " and gears.type in ('" . $this->request->data ['type'] [0] . "'";
					if (isset ( $this->request->data ['type'] [1] )) {
						$start = $start . ",'" . $this->request->data ['type'] [1] . "'";
						if (isset ( $this->request->data ['type'] [2] )) {
							$start = $start . ",'" . $this->request->data ['type'] [2] . "')";
						} else {
							$start = $start . ")";
							$gear = $conn->execute ($start);
							$this->set ( 'gear', $gear );
						}
					} else {
						$start = $start . ")";
						$gear = $conn->execute ($start);
						$this->set ( 'gear', $gear );
					}
				}
			} else if (count ( $this->request->data ) > 1) {
				$start = $start . " gears.type in ('" . $this->request->data ['type'] [0] . "'";
				if (isset ( $this->request->data ['type'] [1] )) {
					$start = $start . ",'" . $this->request->data ['type'] [1] . "'";
					if (isset ( $this->request->data ['type'] [2] )) {
						$start = $start . ",'" . $this->request->data ['type'] [2] . "')";
					} else {
						$start = $start . ")";
						$gear = $conn->execute ($start);
						$this->set ( 'gear', $gear );
					}
				} else {
					$start = $start . ")";
					$gear = $conn->execute ($start);
					$this->set ( 'gear', $gear );
				}
			} else {
				$this->set ( 'gear', $this->paginate ( $this->Gears->find ( 'all' ) ) );
				$this->Flash->error ( __ ( 'This type of gear does not exist here yet!' ) );
			}
			
			
		}
		if ($this->request->is ( 'get' )) {
			if (empty ( $type )) {
				
				$this->set ( 'gear', $this->paginate ( $this->Gears->find ( 'all' ) ) );
			} else if ($type == 'jerseys') {
				
				$this->set ( 'gear', $this->paginate ( $this->Gears->findByType ( 'jersey' ) ) );
			} else if ($type == 'disc') {
				
				$this->set ( 'gear', $this->paginate ( $this->Gears->findByType ( 'disc' ) ) );
			} else if ($type) {
				$query = $this->Gears->find ( 'all' )->join ( [ 
						'table' => 'Tags',
						'type' => 'INNER',
						'conditions' => [ 
								'Gears.id = Tags.gearid' 
						] 
				] )->where ( [ 
						'Tags.name' => $type 
				] );
				
				$this->set ( 'gear', $this->paginate ( $query ) );
				// $this->set ( 'gear', );
			} else {
				$this->Flash->error ( __ ( 'This type of gear does not exist here yet!' ) );
			}
		}
	}
	public function view($id) {
		if (! $id) {
			throw new NotFoundException ( __ ( 'This is not the gear you are looking for' ) );
		}
		
		$this->loadModel ( "Users" );
		$gear = $this->Gears->get ( $id );
		
		$user = $this->Users->get ( $gear ['userid'] );
		
		$this->set ( 'gear', $gear );
		$this->set ( 'user', $user );
	}
	public function add() {
		$this->loadModel ( 'Tags' );
		$gear = $this->Gears->newEntity ();
		$tag = $this->Tags->newEntity ();
		
		if ($this->request->is ( 'post' )) {
			
			$gear = $this->Gears->patchEntity ( $gear, $this->request->data );
			
			$target_dir = "C:\\wamp\\www\\ultitrade\\webroot\\uploads\\";
			$_FILES ["fileToUpload"] ["name"] = date ( "dwzms" ) . $_FILES ["fileToUpload"] ["name"];
			$target_file = $target_dir . basename ( $_FILES ["fileToUpload"] ["name"] );
			$uploadOk = 1;
			$uploadOk2 = 1;
			
			$imageFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
			// Check if image file is a actual image or fake image
			if (isset ( $_POST ["submit"] )) {
				$check = getimagesize ( $_FILES ["fileToUpload"] ["tmp_name"] );
				if ($check !== false) {
					$uploadOk = 1;
				} else {
					$this->Flash->error ( __ ( 'File is not an image.' ) );
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists ( $target_file )) {
				$this->Flash->error ( __ ( 'Sorry, file already exists.' ) );
				$uploadOk = 0;
			}
			// Check file size
			// Allow certain file formats
			if ($imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "gif") {
				$this->Flash->error ( __ ( 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.' ) );
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file ( $_FILES ["fileToUpload"] ["tmp_name"], $target_file )) {
					echo "The file " . basename ( $_FILES ["fileToUpload"] ["name"] ) . " has been uploaded.";
				} else {
					echo 'Sorry, there was an error uploading your file.';
					$reason = 'Sorry, there was an error uploading your file.';
					$this->Flash->error ( __ ( 'Sorry, there was an error uploading your file.' ) );
				}
			}
			// second image
			if (! empty ( $_FILES ["fileToUpload2"] ["name"] )) {
				$_FILES ["fileToUpload2"] ["name"] = date ( "dwzms" ) . $_FILES ["fileToUpload2"] ["name"];
				$target_file2 = $target_dir . basename ( $_FILES ["fileToUpload2"] ["name"] );
				$imageFileType2 = pathinfo ( $target_file2, PATHINFO_EXTENSION );
				$gear->imagelocation2 = $_FILES ["fileToUpload2"] ["name"];
				if (isset ( $_POST ["submit"] )) {
					$check = getimagesize ( $_FILES ["fileToUpload2"] ["tmp_name"] );
					if ($check !== false) {
						
						$uploadOk2 = 1;
					} else {
						
						$this->Flash->error ( __ ( 'File is not an image.' ) );
						$uploadOk2 = 0;
					}
				}
				// Check if file already exists
				if (file_exists ( $target_file2 )) {
					$this->Flash->error ( __ ( 'Sorry, file already exists.' ) );
					$uploadOk2 = 0;
				}
				// Allow certain file formats
				if ($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif") {
					$this->Flash->error ( __ ( 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.' ) );
					$uploadOk2 = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk2 == 0) {
					
					// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file ( $_FILES ["fileToUpload2"] ["tmp_name"], $target_file2 )) {
						// echo "The file " . basename ( $_FILES ["fileToUpload2"] ["name"] ) . " has been uploaded.";
					} else {
						echo 'Sorry, there was an error uploading your file.';
						$reason = 'Sorry, there was an error uploading your file.';
						$this->Flash->error ( __ ( 'Sorry, there was an error uploading your file.' ) );
					}
				}
			}
			// Added this line
			
			$taglist = $gear ['tags'];
			$tags = explode ( ",", $taglist );
			$collection = array ();
			
			$tagz = TableRegistry::get ( 'Tags' );
			
			$gear->userid = $this->Auth->user ( 'id' );
			$gear->imagelocation1 = $_FILES ["fileToUpload"] ["name"];
			// You could also do the following
			// $newData = ['user_id' => $this->Auth->user('id')];
			// $article = $this->Articles->patchEntity($article, $newData);
			if ($uploadOk > 0) {
				if ($this->Gears->save ( $gear )) {
					
					foreach ( $tags as $tag ) {
						$tag = trim ( $tag );
						$temp = array (
								'Tags' => array (
										'gearid' => $gear->id,
										'name' => $tag 
								) 
						);
						
						$collection [] = $temp;
					}
					$entities = $tagz->newEntities ( $collection );
					foreach ( $entities as $entity ) {
						$tagz->save ( $entity );
					}
					// $this->Tags->save ();
					$this->Flash->success ( __ ( "Your gear has been added to your collection." ) );
					return $this->redirect ( [ 
							'action' => 'add' 
					] );
				}
				$this->Flash->error ( __ ( 'gear was unable to be added' ) );
			}
		}
	}
	
	
}