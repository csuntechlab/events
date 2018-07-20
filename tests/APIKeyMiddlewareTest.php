<?php


//class APIKeyMiddleware
//{
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//
//        if (!$request->has('api_key')) {
//
//            return response('Check API key');
//
//        }
//
//        return $next($request);
//
//    }
//}
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 7/19/2018
 * Time: 8:11 PM
 */

use App\Http\Middleware\APIKeyMiddleware;
use Illuminate\Http\Request;

class APIKeyMiddlewareTest extends TestCase
{
//    /** @test */
//    public function has_APIKey()
//    {
//        $response = $this->get('/');
//        $response->assertStatus(200);
//    }

    public function has_APIKey(){

        $response = Mockery::mock(APIKeyMiddleware::class);

        $response->shouldReceive('api_key')
            ->once()
            ->andReturn('has api kay')
            ->getMock();

        $middleware = new App\Http\Middleware\APIKeyMiddleware();

        $this->assertEquals('has api key', $response);

    }

    public function teardown()
    {
        Mockery::close();
    }
}