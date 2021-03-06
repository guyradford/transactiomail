<?php
/**
 * Created by PhpStorm.
 * User: GuyRadford
 * Date: 24/09/2016
 * Time: 19:49
 */

namespace GuyRadford\TransactionMail\Adapter;

use GuyRadford\TransactionMail\EmailTemplatedMessage;
use GuyRadford\TransactionMail\Exception\InvalidApiAuthenticationException;
use GuyRadford\TransactionMail\Exception\InvalidTemplateIdException;
use GuyRadford\TransactionMail\Exception\RequiredFieldMissingException;
use GuyRadford\TransactionMail\Result;
use Sendinblue\Mailin;

class SendInBlue extends AbstractAdapter
{


    /**
     * @var Mailin
     */
    protected $client;

    public function __construct(Mailin $client)
    {
        $this->client = $client;
    }

    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {
        $message = $this->getMessageData($emailMessage);
        $result = $this->getClient()->send_transactional_template($message);
        return $this->builtResult($result);
    }

    /**
     * @param EmailTemplatedMessage $emailTemplatedMessage
     * @return array
     */
    protected function getMessageData(EmailTemplatedMessage $emailTemplatedMessage)
    {
        return [
            "id" => $emailTemplatedMessage->getTemplate(),
            "to" => $this->getListOfEmails($emailTemplatedMessage->getTos(), '|'),
            "cc" => $this->getListOfEmails($emailTemplatedMessage->getCcs(), '|'),
            "bcc" => $this->getListOfEmails($emailTemplatedMessage->getBccs(), '|'),
            "attr" => $this->getMergeFields(
                $emailTemplatedMessage->getMergeFields(),
                $emailTemplatedMessage->getSubject()
            ),
            "replyto" => $this->getEmailOrNull($emailTemplatedMessage->getReplyTo()),
//			"attachment_url" => "",
//			"attachment" => array("myfilename.pdf" => "your_pdf_files_base64_encoded_chunk_data"),
            "headers" => $this->getHeadersAsArray($emailTemplatedMessage),
        ];
    }


    /**
     * @param array $mergeFields
     * @param string $subject
     * @return array
     */
    protected function getMergeFields($mergeFields, $subject)
    {
        $attr = [];

        if ($subject)
            $attr['SUBJECT'] = $subject;

        array_walk($mergeFields, function ($value, $key) use (&$attr) {
            $attr[strtoupper($key)] = $value;
        });

        return $attr;
    }


    protected function builtResult($result)
    {

        if ($result['code'] == 'failure') {
            switch ($result['message']) {
                case 'Key Not Found In Database':
                    throw new InvalidApiAuthenticationException();
                    break;
                case 'Invalid template id specified.':
                    throw new InvalidTemplateIdException();
                    break;
                case 'Required field missing':
                    throw new RequiredFieldMissingException();
                default:
                    var_dump($result);
                    throw new \Exception($result['message']);
            }
        }

        return Result::create(
            ($result['code'] == 'success' ? true : false),
            str_replace(['<', '>'], '', $result['data']['message-id']),
            $result['message']
        );
    }
}
