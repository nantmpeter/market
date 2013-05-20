<?php 
class GoodsAction extends Action {


	public function manager(){
		$keyword = $_GET['keyword'];
		$a = D('Api');
		$b = D('Goods');
		$ClassName = $_GET['ClassText'];
		$type = $_GET['type'];
		//if ($type = $m) {
			//$this->assign('goods',);
		//}
		//var_dump($ClassName);exit;
		if ($ClassName) {
			$b->addClass($ClassName);
		}
		$page = $_GET['page'];
		if($_GET['page'] == null){$page = 1;}
		$pagesize = $_GET['pagesize']?$_GET['pagesize']:20;
		$this->assign("page",$page);
		$this->assign('classes',$b->getClass());
		$this->assign('keyword',$keyword);
		if ($keyword) {
   			$this->assign('goods',$a->getGoods($keyword,$pagesize,$page));
		}
   		$this->display();
	}

	public function insert(){
		$ids = $_POST['goodId'];
		$class = $_POST['class'];
		$a = D("Goods");
		$r = $a->insert($ids,$class);
		if ($r) {
			echo json_encode(array('state'=>1,'msg'=>"入库成功！"));
		}
	}
}
 ?>