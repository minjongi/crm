<?php
/**
 * Created by PhpStorm.
 * User: dhseo
 * Date: 19. 6. 12
 * Time: 오전 11:28
 */

namespace App\Exceptions;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApplicationException extends \Exception implements Responsable
{
    // 요청 관련 10000~10099
    const REQUEST_PARAM = 10000;
    const UNAUTHENTICATED = 10001;
    const LOGIN_FAIL = 10002;


    private $errMessages = [
        self::REQUEST_PARAM => '요청 파라메터 에러',
        self::UNAUTHENTICATED => '인증에러',
        self::LOGIN_FAIL => '계정정보를 확인해주세요.',
    ];

    public function __construct(int $code = 0, $errMessages=null, Throwable $previous = null)
    {

        if (!is_null($errMessages)) {
            parent::__construct($errMessages, $code, $previous);
        } else if(Arr::has($this->errMessages, $code)){
            parent::__construct(trans($this->errMessages[$code]), $code, $previous);
        } else {
            parent::__construct("", $code, $previous);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $resp = response()->json([
            'status' => 'fail',
            'data' => [
                'code' => $this->getCode(),
                'message' => trans($this->getMessage())
            ]
        ]);

        if ($this->getCode()==self::UNAUTHENTICATED){
            return $resp->setStatusCode(403);
        }else if ($this->getCode()==self::LOGIN_FAIL){
            return $resp->setStatusCode(422);
        } else if($this->getCode() < 10100) {
            return $resp->setStatusCode(400);
        }
        return $resp->setStatusCode(500);
    }
}
