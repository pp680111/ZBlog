<?php 
	namespace app\index\model;
	use think\Model;

	class Reply extends Model
	{
		protected $table = 'reply';
		protected $type = [
			'create_time' => 'datetime'
		];
		protected $autoWriteTimestamp = false;

		
		public function article()
		{
			return $this->belongsTo('Article','articleid');
		}
	}
?>