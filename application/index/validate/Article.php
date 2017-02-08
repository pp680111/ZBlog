<?php 
	namespace app\index\validate;
	use think\Validate;
	class Article extends Validate
	{
		protected $rule = [
			['title','require|max:50','标题不能为空|标题长度不能超过50个字符'],
			['summary','max:255','文章概要不能超过255个字符'],
			['content','require','文章内容不能为空']
		];		
	}
 ?>