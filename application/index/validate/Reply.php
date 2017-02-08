<?php 
	namespace app\index\validate;
	use think\Validate;
	class Reply extends Validate
	{
		protected $rule = [
			['replyer','require|max:30','昵称不能为空|昵称的长度不能超过30个字符'],
			['replyContent','require|max:255','回复内容不能为空|昵称内容不能超过255个字符']
		];

	}
 ?>