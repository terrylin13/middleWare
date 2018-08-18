<?php 
namespace TerryLin\Middleware;
use Closure;

/**
 * PHP中，中间件概念的简单实现
 *
 */
Class Demo 
{	
	//响应的数据
	public  $response;
	//绑定的中间件
	private $stack = [];

	/**
	 * 执行中间件函数
	 * @param mix $request  请求数据
	 * @param mix $response 响应数据
	 * @param Closure $next 把处理完的结果返回给下一个中间件
	 * @return Closure
	 */
	private function handle( $request, $response, Closure $next )
	{
		return $next($request,$response);
	}


	/**
	 * 绑定中间件
	 */
	public function bind(Closure $middleware)
	{
		$this->stack[]=$middleware;
		return true;
	}

	/**
	 * 执行函数
	 * @param mix $request  请求数据
	 * @param mix $response 响应数据
	 * @return mix
	 */
	public function run($request,$response='')
	{
		$this->response = $response;
		foreach ($this->stack as $key => $value) 
		{
			$this->response = $this->handle($request,$this->response,$value);
		}
		return $this->response;
	}

}

$demo = new Demo();

$demo->bind(
	function($requset,$response){
		$response = $response.$requset.'filter By middleware！';
		return $response;
});

var_dump( $demo->run('someQueryParams') );