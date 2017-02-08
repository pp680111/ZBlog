<?php 
	namespace app\index\model;
	use think\Model;

	class Article extends Model
	{
		protected $table = 'article';

		protected $type = [
			'create_time' => 'datetime',
			'last_edit_time' => 'datetime'
		];

		protected $createTime = 'create_time';
		protected $updateTime = 'last_edit_time';
		
		public function reply()
		{
			return $this->hasMany('Reply','articleid');
		}

		protected function getReplyNumAttr($value,$data)
		{
			return $this->reply()->count();
		}
	}
 ?>