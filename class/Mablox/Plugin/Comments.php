<?php

namespace Mablox\Plugin

class Comments {

	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function findAll($ref, $ref_id)
	{
		$q = $this->pdo->query("
			SELECT * FROM comments 
			WHERE ref_id = :ref_id 
			    AND ref = :ref 
			ORDER BY created DESC");
		$q->execute(['ref' => $ref, 'ref_id' => $ref_id]);
		return $q->fetchAll();
	}

}

?>