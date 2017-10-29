<?php

namespace mztx\ShinagePlayerBundle\Service;

use GuzzleHttp\Exception\ClientException;
use mztx\ShinagePlayerBundle\Entity\HeartbeatAnswer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Heartbeat
{
    /** @var UrlBuilder */
    protected $urlBuilder;

    /** @var string */
    protected $uuid;

    /**
     * Heartbeat constructor.
     *
     * @param UrlBuilder $urlBuilder
     * @param string     $uuid
     */
    public function __construct(UrlBuilder $urlBuilder, $uuid)
    {
        $this->urlBuilder = $urlBuilder;
        $this->uuid = $uuid;
    }


    public function beat()
    {
        $url = $this->urlBuilder->getControllerUrl('heartbeat', $this->uuid);

        try {
            $client = new \GuzzleHttp\Client(['connect_timeout' => 5]);
            $res = $client->request('GET', $url);

            $answerJson = $res->getBody()->getContents();
            #$answerObject = \GuzzleHttp\json_decode($answerJson);

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);
            $answerObject = $serializer->deserialize($answerJson, HeartbeatAnswer::class, 'json');

            return $answerObject;
        } catch (ClientException $ex) {
            return '{"status": "error", "code": "'.$ex->getResponse()->getStatusCode().
                '", "message": "'.$ex->getMessage().'"}';
        } catch (\Exception $ex) {
            return '{"status": "error", "type": "'.get_class($ex).'","message": "'.$ex->getMessage().'"}';
        }
    }
}
