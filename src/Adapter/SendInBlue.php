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


    /**
     * @param EmailTemplatedMessage $emailMessage
     * @return Result
     */
    public function sendTemplateEmail(EmailTemplatedMessage $emailMessage)
    {

        $data = $this->buildData($emailMessage);
        $result = $this->client->send_transactional_template($data);
        return $this->builtResult($result);

    }

    protected function buildData(EmailTemplatedMessage $emailTemplatedMessage)
    {

        $data = array(
            "id" => $emailTemplatedMessage->getTemplate(),
            "to" => $this->getListOfEmails($emailTemplatedMessage->getToEmailAddresses()),
            "cc" => $this->getListOfEmails($emailTemplatedMessage->getCcEmailAddresses()),
            "bcc" => $this->getListOfEmails($emailTemplatedMessage->getBccEmailAddresses()),
            "attr" => $this->getMergeFields(
                $emailTemplatedMessage->getMergeFields(),
                $emailTemplatedMessage->getSubject()
            ),
//			"attachment_url" => "",
//			"attachment" => array("myfilename.pdf" => "your_pdf_files_base64_encoded_chunk_data"),
			"headers" => $this->getHeaders($emailTemplatedMessage->getMergeFields()),
        );
        return $data;
    }

    protected function getListOfEmails($emailAddressList)
    {
        $emails = [];

        array_walk($emailAddressList, function (EmailAddress $email) use ($emails) {
            $emails[] = $email->getEmailAddress();
        });

        return implode('|', $emails);
    }
    
    protected function getMergeFields($mergeFields, $subject){
        $attr = [];
        
        $attr['SUBJECT'] = $subject;
        
        array_walk($mergeFields, function ($value, $key) use($attr){
            $attr[strtoupper($key)] = $value;
        });
        
    }
    protected function getHeaders($headers){
        $response = [];

        array_walk($headers, function ($value, $key) use($response){
            $response[$key] = $value;
        });
    }


    protected function builtResult($result){
        return Result::create(
            ($result['code'] == 'success'?true:false),
            $result['data']['message-id'],
            $result['message']
        );
    }
}