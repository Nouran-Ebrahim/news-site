<?php


if (!function_exists('apiResponse')) {
    function apiResponse($status, $msg, $data = null)
    {
        $rsponce = [
            'status' => $status,
            'msg' => $msg,
        ];
        if ($data) {
            $rsponce['data'] = $data;
        }

        return response()->json(
            $rsponce,
            $status
        );
    }

}
