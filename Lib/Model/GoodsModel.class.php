<?php
/**
* 
*/

class GoodsModel extends Model
{	


/*	function getList($page,$pagesize = 20){
		$m = M("goods_info");
		$offset = ($page-1) * $pagesize;
		$tmp = $offset.",".$pagesize;
		return $m->limit($tmp)->select();;
	}*/

	function insert($ids,$class){
		$data['class'] = $class;
		$m = M('goods_list');
		foreach ($ids as $key => $value) {
			$data['num_iid'] = $value;
			//var_dump($data);exit;
			$r = $m->add($data);
			if(!$r){
				return false;
			}
		}
		return true;
	}

	function saveGoods(){
		Vendor("phpQuery");
		$goods_info = $this->getList("手绘地图");
		$goods_url = $goods_info->taobaoke_item->keyword_click_url;
		echo $goods_url;

		phpQuery::newDocumentFile($goods_url);
		$com = pq("#bid-form ul")->find("li");
		foreach ($com as $key => $value) {
			echo pq($value)->find("h3 a")->text()."<br>";
		}
		//$goods_html = file_get_contents($goods_url);
	}

	function selectGoods($class,$page=1,$pagesize){
		$page = $page>0?$page:1;
		$a = M("goods_list");
		$b = D("Api");
		$r = $a->limit(($page-1)*$pagesize.",".$pagesize)->select(array("class"=>$class));
		foreach ($r as $key => $value) {
			$ids[] = $value['num_iid'];
		}

		$r = $b->getGoodsDetail(implode(",", $ids));
		var_dump($r);
		return $r;
	}


	function getClassId(){
		Vendor("taobaoke.top.request.TaobaokeItemsGetRequest");
		$req = new TaobaokeItemsGetRequest();
		$req->setFields("title,pic_url,click_url,price,num_iid,item_location");
		//$req->setPid(123456);
		$req->setKeyword("手绘地图");
		//$req->setCid(123);
		$req->setNick($this->nick);
		$req->setStartCommissionRate("1234");
		$req->setReferType(1);
		$resp = $this->c->execute($req);
		$list = $resp->taobaoke_items->taobaoke_item;
		$goods = M("goods_info");
		foreach ($list as $key => $value) {
			$goods->add($this->objectToArray($value));
		}
	}

	function addClass($name){
		$m = M("classes");
		$t = $m->where("name = '$name'")->select();
		if($t){
			return false;
		}
		return $m->add(array("name"=>$name));
	}

	function getClass(){
		$m = M("classes");
		return $m->select();
	}

	 
}
?>