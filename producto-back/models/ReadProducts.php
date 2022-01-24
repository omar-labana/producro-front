<?php
class ReadProducts
{
	private function readTable($conn, $tableName)
	{
		$sql = "SELECT * FROM Products INNER JOIN " . $tableName . " ON Products.id = " . $tableName . ".product_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function readAll($conn)
	{
		$dvds = $this->readTable($conn, 'DVDS');
		$books = $this->readTable($conn, 'Books');
		$furniture = $this->readTable($conn, 'Furniture');
		$allProducts = array_merge($dvds, $books, $furniture);

		usort($allProducts, function ($a, $b) {
			return $a['id'] - $b['id'];
		});

		$obj = new stdClass;
		$obj->data = $allProducts;
		echo json_encode($obj);
	}
}
