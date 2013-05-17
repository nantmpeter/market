<?php
// 本类由系统自动生成，仅供测试用途
include './Common/phpQuery-onefile.php';
class IndexAction extends Action {
    public function doit($url){
    	//global $newlist;
    //	$ch=curl_init($url);
    	//curl_exec($ch);
		$a=phpQuery::newDocumentFile($url);
		//var_dump($a);
		
		//$test=pq("input")->html();
		//echo $test."111";
		$list=pq(".ct_sup");
		//var_dump($list);
		foreach ($list as $l){
			$html = pq($l)->html();
			$r='/<a href="(.*)" class="img">/';
			preg_match($r, $html,$result);
		//	var_dump($result[1]);
			//echo substr($result[1], 0,1);
			//var_dump($result);
			if(substr($result[1], 0,1)=="/"){
				//echo "http://www.dianwoba.com".$result[1];
				$this->ag("http://www.dianwoba.com".$result[1]);
			}else{
			//	echo 222222;
			$this->get_store_info($html);
				echo $html;exit;
// 				$newlist[]=$html;
// 				var_dump($newlist);
			}
		}
		
    //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    
    public function index(){
		$this->sql();exit;
     //	$this->doit("http://www.dianwoba.com/dianwoba/grid/liansuo.jsp?lid=100");
//     	$this->doit("http://www.dianwoba.com/dianwoba/grid/skim.jsp?a=a&gp=3");
//     	exit;
	//		$this->getin("http://www.dianwoba.com/order/menu/1090.html");
    	for ($i=1;$i<2;$i++){
    		$link="http://www.dianwoba.com/dianwoba/grid/skim.jsp?a=a&gp=".$i."</br>";
    		$this->doit($link);
    	}
    	//var_dump($newlist);
    }
    
    public function ag($url){
    	$tmp = file_get_contents($url);
		$r='/<input type="hidden" id="liansuoinfos" value="(.*)"/';
		preg_match($r, $tmp,$result);
		$test=str_replace("&nbsp;", "|", $result[1]);
		var_dump($test);
		$e=explode(";", $test);
    }
    
    public function getin($url){
    	$a=phpQuery::newDocumentFile($url);
    	$e = pq(".smclist");
    	//var_dump($e);
    	$lei=pq("h3 strong");
    	$leibie=array();
    	foreach ($lei as $key=>$i){
    			array_push($leibie, pq($i)->html());
    	}
    	foreach ($e as $key=>$t){
    		if ($key==(count($e)-1)){
    			break;
    		}
    		else{
    			echo $leibie[$key];
    			echo pq($t)->html();
    		}
    	}
    	for ($i=0;$i<3;$i++){
    		echo pq($e[1])->html();
    	}
    }
    
    public function get_store_info($urlstr){
    	phpQuery::newDocument($urlstr);
    	$info_array['business hours'] = pq(".sj")->html(); 
    //	echo pq(".text")->html();
//     	echo pq(".text")->html();
//     	echo pq(".text")->html();
//     	echo pq(".text")->html();
    	
    	
    	$info_array=array();
    	//var_dump($urlstr);
//     	preg_match('/<a href=.*class="text">(.*)<\/a>/', $urlstr,$match);
//     	var_dump($match);exit;
// 		echo $urlstr;die;
    	preg_match_all("|<a href=.*class=\"text\">(.*)<\/a>|",$urlstr,$result_store,PREG_PATTERN_ORDER);
    	$info_array['store_name'] = $result_store[1][0];
    //	var_dump($urlstr);
    	preg_match("/<li class=\"dz\">(.*)<\/li>/",$urlstr,$result_else_info);
    	preg_match("/<li class=\"lx\">(.*)<\/li>/",$urlstr,$result_cat_name);
    	preg_match("/<img src=\"(.*)\">/",$urlstr,$result_stoge_logo);
    	preg_match("/<li class=\"tj\">(.*)<\/li>/",$urlstr,$result_rec_goods);
//     	echo '<pre/>';
//     	$result_rec_goods=substr($result_rec_goods[1],6);
//     	print_r($result_rec_goods);die;
    	preg_match_all("|<a class=\"img\"(.*?)><img src=\"(.*?)\"></a>|",$urlstr,$default_image,PREG_PATTERN_ORDER);
    	preg_match_all("|<ul class=\"boxone_right_m\"><li class=\"(.*?)\">推荐：(.*?)</li>(.*?)</ul>|",$urlstr,$rec_goods,PREG_PATTERN_ORDER);
    
    	$info_array['cate_name'] = $result_cat_name[1];
    	//$info_array['business hours'] = $result_else_info[2][1];
    	//$info_array['address'] = $result_else_info[2][2];
    	$info_array['address'] = $result_else_info[1];
    	$info_array['store_logo'] = $result_stoge_logo[1];
    	$result_rec_goods=substr($result_rec_goods[1],6);
//     	$test=str_replace("&#160;", "|", $result_rec_goods);
    	$rec_goods = explode("&#160;&#160;&#160;&#160;",$result_rec_goods);
    	array_pop($rec_goods);
    	$info_array['rec_goods'] = $rec_goods;
    	$info_array['longitude'] = '120.208548';
    	$info_array['latitude'] = '30.283809';
    	$info_array['per_capita'] = '125';
    //	$download = new DownloadFile ();
    	//$download->get_img_file ( 'http://www.dianwoba.com/'.$default_image[2][0] );
    	echo '<pre/>';
    	print_r($info_array);echo '<br/>';
    	return $info_array;
    }
	
	
	function sql(){
		$db=M("news_list");
		 $list=$db->limit(20)->select();
		 var_dump($list);
	}
}