<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactioMail\Adapter;

use GuyRadford\TransactioMail\EmailTemplatedMessage;
use GuyRadford\TransactioMail\Result;
use GuyRadford\TransactioMail\ValueObject\EmailAddress;

class Mandrill extends AbstractAdapter
{

    /**
     * @var \Mandrill
     */
    private $client;
    /**
     * @var array
     */
    private $config;
    /**
     * @var bool
     */
    private $async;
    /**
     * @var null|string
     */
    private $ipPool;
    /**
     * @var null|string
     */
    private $sendAt;

    private $defaultMessageConfig = [];


    /**
     * Mandrill constructor.
     * @param \Mandrill $client
     * @param array $config
     * @param bool $async
     * @param null|string $ipPool
     * @param null|string $sendAt
     */
    public function __construct(\Mandrill $client, $config = [], $async = false, $ipPool = null, $sendAt = null)
    {
        $this->client = $client;
        $this->config = $config;
        $this->async = $async;
        $this->ipPool = $ipPool;
        $this->sendAt = $sendAt;

        $this->defaultMessageConfig = array_merge([
            'important' => false,
            'track_opens' => null,
            'track_clicks' => null,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true,
            'merge_language' => 'mailchimp',
            'metadata' => [],
            'recipient_metadata' => [],
            'attachments' => [],
            'images' => []
        ], $config);
    }


    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {
        $mergeFields = $this->getMergeFields($emailMessage);
        $message = $this->getMessageData($emailMessage);
        $result = $this->client->messages->sendTemplate(
            $emailMessage->getTemplate(),
            $mergeFields,
            $message,
            $this->async,
            $this->ipPool,
            $this->sendAt
        );
        return $this->builtResult($result);
    }

    protected function getMergeFields(EmailTemplatedMessage $emailMessage)
    {
        $mergeFields = [];

        array_walk($emailMessage->getMergeFields(), function ($value, $key) use ($mergeFields) {
            $mergeFields[] = [
                'name' => $key,
                'content' => $value
            ];
        });

        return $mergeFields;
    }

    protected function getMessageData(EmailTemplatedMessage $emailMessage)
    {
        return array_merge(
            $this->defaultMessageConfig,
            [
                'subject' => $emailMessage->getSubject(),
                'from_email' => $emailMessage->getFrom()->getEmailAddress(),
                'from_name' => $emailMessage->getFrom()->getName(),
                'to' => $this->builtToArray($emailMessage),
                'headers' => $this->getMandrillHeadersAsArray($emailMessage),
            ]
        );
    }

    protected function builtToArray(EmailTemplatedMessage $emailMessage)
    {
        $to = array_merge(
            $this->buildToArrayForType('to', $emailMessage->getTos()),
            $this->buildToArrayForType('cc', $emailMessage->getCcs()),
            $this->buildToArrayForType('bcc', $emailMessage->getBccs())
        );

        return $to;
    }

    protected function buildToArrayForType($type, $emailAddressList)
    {
        $to = [];

        /** @var EmailAddress $emailAddress */
        array_walk($emailAddressList, function ($emailAddress) use ($type, $to) {
            $to[] = [
                'email' => $emailAddress->getEmailAddress(),
                'name' => $emailAddress->getName(),
                'type' => $type
            ];
        });

        return $to;
    }

    protected function getMandrillHeadersAsArray(EmailTemplatedMessage $emailMessage)
    {
        $headers = [];

        if ($emailMessage->getReplyTo()) {
            $headers['Reply-To'] = $emailMessage->getReplyTo();
        }

        $headers = array_merge($headers, $this->getHeadersAsArray($emailMessage));
        return $headers;
    }
}
