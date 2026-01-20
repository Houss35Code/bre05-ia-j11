<?php

class Controller extends AbstractController
{
	// ...

	public function home() : void
	{
		$query = $this->db->prepare('SELECT * FROM users');
		$parameters = [

		];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
	}

	// ...
}