<?php

namespace App\Libs\Api;

use App\Models\Customer;
use Illuminate\Support\Facades\Request;

class RestApi
{

    protected $success;
    protected $error;
    protected $content;
    protected $totalReg;

    /**
     * @return mixed
     */
    public function getTotalReg()
    {
        return $this->totalReg;
    }

    /**
     * @param mixed $totalReg
     */
    public function setTotalReg($totalReg)
    {
        $this->totalReg = $totalReg;
    }

    /**
     * RestApi constructor.
     */
    public function __construct()
    {
        $this->success = 'true';
        $this->error = '';
        $this->content = '';
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
        $this->success = 'false';
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->success = 'true';
        $this->totalReg = count($content);
    }

    /**render output
     * @return mixed
     */
    public function responseJson()
    {
        $out = array();

        $out["success"] = $this->success;
        if ($out["success"] == 'false') {
            $out["error"] = $this->error;
            $out["totalreg"] = 0;
        } else {
            $out["content"] = $this->content;
            $out["totalreg"] = $this->totalReg;
        }

        return response()->json($out); /// json
    }

    public function hasAuthorization()
    {
        $accessToken = Request::header('Authorization');

        if (!empty($accessToken)) {

            $cliente = new Customer();
            $existe = $cliente->getCustomerByToken($accessToken);
            $result = ($existe > 0) ? true : false;
        } else {
            $result = false;
        }

        return $result;

    }


}