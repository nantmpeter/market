<?php 

class ShowAction extends Action {
	public function show(){
		$a = D('Goods');
		$a->selectGoods(6,1,10);
	}
}

?>