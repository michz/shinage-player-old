<?php
/**
 * Created by solutionDrive GmbH.
 *
 * @author   :  Michael Zapf <mz@solutionDrive.de>
 * @date     :  25.06.17
 * @time     :  09:38
 * @copyright:  2017 solutionDrive GmbH
 */

namespace mztx\ShinagePlayerBundle\Service;

use GuzzleHttp\Exception\ClientException;

class Remote
{
    /** @var UrlBuilder */
    protected $urlBuilder;

    /** @var string */
    protected $uuid;

    /**
     * Remote constructor.
     *
     * @param UrlBuilder $urlBuilder
     * @param string     $uuid
     */
    public function __construct(UrlBuilder $urlBuilder, $uuid)
    {
        $this->urlBuilder = $urlBuilder;
        $this->uuid = $uuid;
    }

    public function getPresentation($id)
    {
        $url = $this->urlBuilder->getControllerUrl('presentation', $id);

        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url);

            $answerJson = $res->getBody();
            return $answerJson;
        } catch (ClientException $ex) {
            return '{"status": "error", "code": "'.$ex->getResponse()->getStatusCode().
                '", "message": "'.$ex->getMessage().'"}';
        } catch (\Exception $ex) {
            return '{"status": "error", "type": "'.get_class($ex).'","message": "'.$ex->getMessage().'"}';
        }
    }
}
