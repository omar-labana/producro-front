<?php
class ReadProducts
{
    function getDVDS($conn)
    {
        $sql = "SELECT * FROM Products INNER JOIN DVDS on Products.id = DVDS.product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getBooks($conn)
    {
        $sql = "SELECT * FROM Products INNER JOIN Books on Products.id = Books.product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getFurniture($conn)
    {
        $sql = "SELECT * FROM Products INNER JOIN Furniture on Products.id = Furniture.product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function readProducts($conn)
    {
        $dvds = $this->getDVDS($conn);
        $books = $this->getBooks($conn);
        $furniture = $this->getFurniture($conn);

        $allProducts = array_merge($dvds, $books, $furniture);
        usort($allProducts, function ($a, $b) {
            return $a['id'] - $b['id'];
        });
        
        $obj = new stdClass;
        $obj->data = $allProducts;
        echo json_encode($obj);
    }
}
