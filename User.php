<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class User {
	protected $database;
	protected $dbname = "users";

	public function __construct(){
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/secret/php-tutorial-23f25-2570f541ed2b.json');
        $firebase = (new Factory)->withServiceAccount($acc)->create();
        $this->database = $firebase->getDatabase();
    }


	public function get(int $userId = NULL) {
		if(empty($userId) || !isset($userId)) { return flase; }

		if($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userId)) {
			return $this->database->getReference($this->dbname)->getChild($userId)->getValue();
		} else {
			return false;
		}
	}

	public function insert(array $data) {
		if(empty($data) || !isset($data)) { return false; }

		foreach ($data as $key => $value) {
			$this->database->getReference()->getChild($this->dbname)->getChild($key)->set($value);
		}

		return true;
	}

	public function delete(int $userId) {
		if(empty($userId) || !isset($userId)) { return false; }

		if($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userId)) {
			$this->database->getReference($this->dbname)->getChild($userId)->remove();
			return true;
		} else {
			return false;
		}
	}
}

$user = new User();

// var_dump($user->insert([
// 	'1' => 'john',
// 	'2' => 'Doe',
// 	'3' => 'smith'
// ]));

// var_dump($user->get('2'));

// var_dump($user->delete('2'));

// var_dump($user->insert([
// 	'1' => 'brij',
// 	'2' => 'Doe',
// 	'3' => 'smith'
// ]));