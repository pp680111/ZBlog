<?php 
	namespace app\index\controller;

	use think\Controller;
	use app\index\model\Article;
	use app\index\model\Reply;

	class Admin extends Controller
	{
		public function forTestUse()
		{
			return $this->fetch('');
		}

		public function admin()
	    {
	    	$this -> assign('replyList',Reply::with('article') -> order('create_time','desc')->select());
	    	$this -> assign('articleList',Article::all());
	    	return $this->fetch("admin");
	    }

	    public function newArticle()
	    {
	    	$this -> assign('successURL','/index/admin/admin');
	    	$this -> assign('title','发布新文章');
	    	$this -> assign('titleVal','');
	    	$this -> assign('summaryVal','');
	    	$this -> assign('editorVal','');
	    	$this -> assign('isUpdate','');
	    	$this -> assign('successTip','发表文章成功');
	    	$this -> assign('articleid','');
	    	return $this->fetch("articleEditor");
	    }

	    public function saveArticle()
	    {
	    	if($this->request->param('isUpdate') == 'yes')
	    	{	
	    		$article = Article::get($this->request->param('articleid'));

	    		$data = ['title' => $this->request->param('title'),
	    				 'summary' => $this->request->param('summary'),
	    				 'content' => $this->request->param('content')
	    		];

		    	//验证器和模型同名的话直接食用validate函数就能进行验证了，不用另外传入实例化的验证器对象
		    	//如果验证器和模型名字不一样的话直接在validate函数里传入验证器的名字就行了
	    		if($article->validate(true)->save($data))
	    			return json(['status'=>'success']);
	    		else return json(['status'=>$article->getError()]);
	    	}
	    	else{
	    		$article = new Article();
		    	$data = ['title' => $this->request->param('title'),
	    				 'summary' => $this->request->param('summary'),
	    				 'content' => $this->request->param('content')
	    		];

	    		if($article->validate(true)->save($data))
	    			return json(['status'=>'success']);
	    		else return json(['status'=>$article->getError()]);
	    	}
	    }

	    public function editArticle()
	    {
	    	$articleid = $this->request->param('articleid');
	    	$article = Article::get($articleid);

	    	$this -> assign('successURL','/index/admin/admin');
	    	$this -> assign('title','编辑文章');
	    	$this -> assign('titleVal',$article->title);
	    	$this -> assign('summaryVal',$article->summary);
	    	$this -> assign('editorVal',$article->content);
	    	$this -> assign('isUpdate',"isUpdate:'yes'");
	    	$this -> assign('successTip','更新文章成功');
	    	$this -> assign('articleid',',articleid:'.$article->id);
	    	return $this->fetch("articleEditor");
	    }

	    public function deleteArticle()
	    {
	    	$articleid = $this->request->param('articleid');
	    	$article = Article::get($articleid);
	    	$article->delete();
	    	return json(['status'=>'success']);
	    }

	    public function deleteReply()
	    {
	    	$replyid = $this->request->param('replyid');
	    	$reply = Reply::get($replyid);
	    	$reply->delete();
	    	return json(['status'=>'success']);
	    }

	    public function uploadBGImage()
	    {
	    	$file = $this->request->file('bgImage');
	    	//表单上传文件验证
	    	$validate = validate('ImageFile');
			if(!$validate->check(['image'=>$file]))
	    		return json(['status'=>$validate->getError()]);

	    	$info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'img','previewBG.png');

	    	if($info)
	    		return json(['imgurl'=>$info->getFilename(),'status'=>'success']);
	    	else return json(['status'=>'fail']);
	    }

	    public function confirmChangeBG()
	    {
	    	if(file_exists(__DIR__ . '\..\..\..\public\static\img\previewBG.png'))
	    	{
	    		if(rename(__DIR__ . '\..\..\..\public\static\img\previewBG.png',__DIR__ . '\..\..\..\public\static\img\BG.png'))
	    			return json(['result'=>'更换背景成功']);
	    		else return json(['result'=>'更换背景失败，请稍后再试']);
	    	}
	    	else{
	    		return json(['result'=>'请上传你想要当背景的图片先']);
	    	}
	    }

	    public function confirmPersonalDataSetup()
	    {
	    	$announcement = $this->request->param('announcement');
	    }
	}
 ?>