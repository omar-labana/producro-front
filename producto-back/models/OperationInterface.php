<?php
interface DatabaseInteraction
{
    public function populate($hash);
    public function commitProductToDB($conn);
    public function commitTypeToDB($conn, $product_id);
    public function InitializeTransaction($conn);
}
