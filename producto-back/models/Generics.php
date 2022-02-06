<?php
class Generics {
  public function decodeRequest($request) {
    $data = json_decode($request, true);
    return $data;
  }
}