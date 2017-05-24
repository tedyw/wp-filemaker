<?php

namespace FileMaker;

class FileMaker
{

    const ENDPOINT_PREFIX = '/fmi/rest/api/record/';
    private $credentials;
    private $connected = false;

    function __construct()
    {
        if (!defined('FILEMAKER_ACCESS_TOKEN')
            || !defined('FILEMAKER_SOLUTION')
            || !defined('FILEMAKER_HOST')
        ) return;

        $connected = true;
    }

    /**
     * Creates a record in a specified layout.
     * @param $layout
     * @param $id
     * @param $data
     * @return array|bool|\WP_Error
     */
    public function create($layout, $id, $data)
    {
        return $this->request('POST',$layout, $id, $data);
    }

    /**
     * @param $request
     * @param $layout
     * @param $id
     * @param null $data
     * @return array|bool|\WP_Error
     */
    private function request($request, $layout, $id, $data = null)
    {
        if (!$this->connected) return false;

        $url = FILEMAKER_HOST . ENDPOINT_PREFIX . FILEMAKER_SOLUTION.'/'.$layout.'/'.$id;
        $args = array('method' => $request);
        $headers = array('FM-Data-token: '.FILEMAKER_ACCESS_TOKEN);

        if(isset($data)){
            $body = json_encode('{"data":'.$data.'}');
            $args = array('method' => $request, 'body'=>$body);
            array_push($headers, 'Content/Type: application/json');
        }

        return wp_remote_request($url, $args);
    }

    /**
     * Updates a record in a specified layout.
     * @param $layout
     * @param $id
     * @param $data
     * @return array|bool|\WP_Error
     */
    public function update($layout, $id, $data)
    {
        return $this->request('PUT', $layout, $id, $data);
    }

    /**
     * Deletes a record in a specified layout.
     * @param $layout
     * @param $id
     * @return array|bool|\WP_Error
     */
    public function delete($layout, $id)
    {
        return $this->request('DELETE', $layout, $id);
    }

    /**
     * Retrieves a record in a specified layout.
     * @param $layout
     * @param $id
     * @return array|bool|\WP_Error
     */
    public function get($layout, $id)
    {
        return $this->request('GET', $layout, $id);
    }
}