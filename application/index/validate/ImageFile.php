<?php 
	namespace app\index\validate;

	use \think\Validate;

	class ImageFile extends Validate
	{
		protected $rule = [
			['image', 'require|image','请选择上传文件|非法图像文件']
		];
	}
?>