<?php
class A
{
	private $a = 1;
	public function c()
	{
		$this->a = 2;
		return $this->a;
	}
}

class B extends A
{
	public function c()
	{
		$res =  parent::c() + 2;
		return $res;
	}
}

$d = new B();
echo $d->c();
