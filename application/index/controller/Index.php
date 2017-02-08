<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Article;
use app\index\model\Reply;

class Index extends Controller
{
    public function index()
    {
        $this -> assign('articleList',Article::all());
	    return $this->fetch();
    }

    public function article()
    {
    	$article = Article::get($this->request->param('articleid'),'reply');
    	$replys = $article -> reply;
    	$this -> assign('article',$article);
    	$this -> assign('replys',$replys);
    	return $this -> fetch('article');
    	return var_dump($replys);
    }

    public function addReply()
    {
    	//先对回复的内容进行验证，不通过的话返回错误信息
    	$validate = validate('Reply');
    	$result = $validate -> check(['replyer'=>$this->request->param('replyer'),'replyContent'=>$this->request->param('replyContent')]);
    	if(!$result)
    		return json(['status'=>$validate->getError()]);

    	$article = Article::get($this->request->param('articleid'));
    	$replyorder = $article -> reply() -> order('id','desc') -> limit(1) -> find();
        if(isset($replyorder))
            $replyorder = $replyorder->replyorder + 1;
        else $replyorder = 1;
        
    	$reply = new Reply;
    	$reply -> replyer = $this->request->param('replyer');
    	$reply -> content = $this->request->param('replyContent');
    	$reply -> replyorder = $replyorder;
    	$reply -> create_time = time();
    	if($article -> reply() -> save($reply))
    		return json(['status'=>'success']);
    	else return json(['status'=>'保存评论失败，请稍后再试']);
    }

}
