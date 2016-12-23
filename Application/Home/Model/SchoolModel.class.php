<?php
namespace Home\Model;
use Think\Model;
class SchoolModel extends Model  {
	//获取学校表
	public function getSchoolList(){
	 	$sql = "SELECT * 
			 	FROM resume_school";
	 	return $this->query($sql);
	 }

	 //获取列表
	 public function getSchool($where){
		$school = M("school");
		$list = $school->where($where)->select();
		return $list;
	 }

	 //获取一条
	 public function findSchool($where){
		$school = M("school");
		$id = $school->where($where)->getField('id');
		return $id;
	 }

	 //更新
	 public function gxSchool($id,$param){
		$school = M("school");
		$data['name'] = $param['name'];
		$data['province'] = $param['province'];
		$data['sequence'] = 1;
		$where = "id={$id}";
		return $school->where($where)->save($data); // 根据条件更新记录
	 }

	 //插入
	 public function insertSchool($param){
		$school = M("school");
		$data['name'] = $param['name'];
		$data['province'] = $param['province'];
		$data['sequence'] = 1;
		return $school->data($data)->add();
	 }
}