<?php 


Vendor('taobaoke.lotusphp_runtime.Logger.Logger');
Vendor("taobaoke.top.TopClient");
Vendor('taobaoke.top.RequestCheckUtil');

class ApiModel extends Model{
	private $appkey = "21453309";
	private $secretKey = "8b08f5194620e2ed9f5c2d8ce5cb5bbf";
	private $c;
	private $nick = "nantmpeter";

	function __construct()
	{
		$this->c = new TopClient();		
		$this->c->appkey = "21453309";
		$this->c->secretKey = "8b08f5194620e2ed9f5c2d8ce5cb5bbf";
	}

	function getGoodsDetail($ids){
		Vendor("taobaoke.top.request.TaobaokeItemsDetailGetRequest");
		$req = new TaobaokeItemsDetailGetRequest();
		$req->setFields("title,pic_url,click_url,price,num_iid,item_location");
		$req->setNick($this->nick);
		$req->setNumIids($ids);
		$resp = $this->c->execute($req);
		$list = $resp->taobaoke_item_details->taobaoke_item_detail;
		foreach ($list as $key => $value) {
			var_dump($value);
			//$arr[] = $this->objectToArray($value);
 		}
		var_dump($arr);
	}

	function getGoods($keyWord,$pagesize = 20,$page = 1){
		Vendor("taobaoke.top.request.TaobaokeItemsGetRequest");
		$req = new TaobaokeItemsGetRequest();
		$req->setFields("title,pic_url,click_url,price,num_iid,item_location");
		$req->setNick($this->nick);
		//$req->setPid(123456);
		$req->setKeyword($keyWord);
		//$req->setCid(123);
		$req->setStartCommissionRate("1234");
		$req->setPageNo($page);
		$req->setPageSize($pagesize);
		$req->setReferType(1);
		$resp = $this->c->execute($req);
		var_dump($resp);
		$list = $resp->taobaoke_items->taobaoke_item;
		$goods = array();
		$i = 0;
		foreach ($list as $key => $value) {
			$goods[] = $this->objectToArray($value);
			//$goods->add($this->objectToArray($value));
		}
		return $goods;
	}

	private function objectToArray($e){ 
	$e=(array)$e; 
	foreach($e as $k=>$v){ 
	if( gettype($v)=='resource' ) return; 
		if( gettype($v)=='object' || gettype($v)=='array' ) 
			$e[$k]=(array)objectToArray($v); 
		} 
	return $e; 
	}
}

 ?>