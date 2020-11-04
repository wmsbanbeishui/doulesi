<?php

namespace common\helpers;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\log\FileTarget;

class DataHelper {
	public static function is_json($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public static function getToken($data){
		if(!is_array($data)){
			return '';
		}
		$token="80f5c8e0d6a05289";
		ksort($data);

		$str='';
		foreach($data as $key=>$item){
			if(is_array($item)){
				foreach($item as $k=>$v){
					$str.=md5($v.$token);
				}
			}
			else{
				$str.=md5($token.$item);
			}
		}
		return md5($token.$str);
	}


	public static function saveData($table,$data,$primary,$lock_key){
		if(empty($data) || !isset($primary)){
			return ['error'=>'5','remark'=>'save data empty.'];
		}
		$has=self::checkData($table,$data,$primary,$lock_key);
		if($has==0){
			if($ret=self::addData($table,$data)){
				return ['error'=>-1,'remark'=>'add success.'];
			}
			else{
				return ['error'=>'0','remark'=>'same data,no add.'];
			}
		}
		elseif($has==1){
			if($ret=self::modifyData($table,$data,$primary)){return ['error'=>-2,'remark'=>'change success.'];}
			else{
				return ['error'=>'0','remark'=>'same data,no change.'];
			}
		}
		elseif($has==2){
			return ['error'=>'0','remark'=>'data locked.no need change.'];
		}
	}

	public static function checkData($table,$data,$primary,$locked_key){
		if(is_array($primary)){
			$maps=[];
			foreach($primary as $key){
				$val=$data[$key];
				$maps[]="`$key`='$val'";
			}
			$map_str=implode(' AND ',$maps);
			$getData = Yii::$app->db->createCommand("SELECT * FROM `$table` WHERE  $map_str")->queryOne();
		}
		else{
		$primaryVal=$data[$primary];
		$getData = Yii::$app->db->createCommand("SELECT * FROM `$table` WHERE `$primary`='$primaryVal'")->queryOne();
		}
		if($getData==false){
			return 0;
		}
		else{
			if(isset($getData[$locked_key]) && $getData[$locked_key]==1){
				return 2;
			}
			else{
				return 1;
			}
		}
	}

	public static function addData($table,$data){
		return Yii::$app->db->createCommand()->insert($table, $data)->execute();
	}

	public static function modifyData($table,$data,$primary){
		if(is_array($primary)){
			foreach($primary as $key){
				$val=$data[$key];
				$maps[]="`$key`='$val'";
				unset($data[$key]);
			}
			$map_str=implode(' AND ',$maps);
			$ret= Yii::$app->db->createCommand()->update($table, $data, $map_str)->execute();
		}
		else{
			$primaryVal=$data[$primary];
			unset($data[$primary]);
			$ret= Yii::$app->db->createCommand()->update($table, $data,  "`$primary`='$primaryVal'")->execute();
		}
		return $ret;
	}

	/* */
	public static function rewrite($data){
		$brand=[
			'table_name'=>'car_brand',
			'fields'=>[
				'brand_code'=>'code',
				'brand_name'=>'name',
				'brand_mark'=>'letter_index',
				'brand_logo'=>'logo'
				],
		   	];
		$factory=[
			'table_name'=>'car_factory',
			'fields'=>[
				'brand_code'=>'brand_code',
				'factory_code'=>'code',
				'factory'=>'name',
				],
		   	];
		$series=[
			'table_name'=>'car_family',
			'fields'=>[
				'brand_code'=>'brand_code',
				'factory_id'=>'factory_code',
				'style_code'=>'code',
				'style_name'=>'name',
				],
		   	];
		$spec=[
			'table_name'=>'car',
			'fields'=>[
				'brand_code'=>'brand_code',
				'factory_code'=>'factory_code',
				'style_code'=>'family_code',
				'style_child_code'=>'code',
				'style_child_name'=>'name',
				'factory_price2'=>'factory_price',
				'energy_source'=>'energy_source',
				'car_level'=>'car_level',

				],
		   	];

		$check_list=[
			'car_brand'=>$brand,
			'car_factory'=>$factory,
			'car_style'=>$series,
			'car_style_child'=>$spec,
			];

		$redata=['tablename'=>'','dat'=>[],'primary'=>'','lock'=>''];

		if(!isset($data['tablename'])){
			return ['errno'=>1];
		}

		$key = $data['tablename'];

		$redata['tablename'] = $check_list[$key]['table_name'];
		$fields=$check_list[$key]['fields'];

		foreach($fields as $s_key => $r_key){
			$redata['dat'][$r_key]=$data['dat'][$s_key];
		}
		$prims=$data['primary'];
		if(!is_array($prims)){
			$redata['primary']=$fields[$prims];
		}
		else{
			$redata['primary']=[];
			foreach($prims as $key){
				$redata['primary'][]=$fields[$key];
			}
		}
		$redata['lock']=$data['lock'];
		return $redata;
	}
}
