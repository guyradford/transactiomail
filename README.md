# TransactionMail
Transactional Email Service

[![Build Status](https://travis-ci.org/guyradford/TransactionMail.svg?branch=master)](https://travis-ci.org/guyradford/transactionMail) [![Coverage Status](https://coveralls.io/repos/github/guyradford/transactionMail/badge.svg?branch=master)](https://coveralls.io/github/guyradford/transactionMail?branch=master)

##Feature Table

|          | Void | Mandrill | SendInBlue | AmazonSES |
|---------:|:----:|:--------:|:----------:|:---------:|
| Template |  Yes |    Yes   |      Yes   |     No    |
|          |      |          |            |           |
|          |      |          |            |           |


##SendInBlue

https://apidocs.sendinblue.com/tutorial-sending-transactional-email/

```
$mailin = new Mailin("https://api.sendinblue.com/v2.0","your access key");
$adapter = new SendInBlue($mailin);
$transationMail = new TransactionMail($adapter);
 
$email = (new EmailTemplatedMessage())
    ->setFromEmailAddress('from@example.co.uk')
    ->setReplyToEmailAddress('replay@example.co.uk')
    ->addToEmailAddress('to@example.com')
    ->addCcEmailAddress('cc@example.com')
    ->addBccEmailAddress('bcc@example.com')
    ->setSubject('Special Offer') // see note 1
    ->addMergeField('firstname', 'John') // see note 2
    ->addHeader('Content-Type', 'text/html;charset=iso-8859-1');
    
    
$response = $transationMail->sendTemplate($email);
 
```


Notes
---

1) Subject is passed to SendInBlue as an attribute called 'SUBJECT'. A merge field with the same name will overwrite this.
2) the case of the field name does not matter but will be changed to UPPER before being sent to SendInBlue.


##Mandril

https://mandrillapp.com/api/docs/messages.php.html

```
$mandrill = new Mandrill('YOUR_API_KEY');
$adapter = new SendInBlue($mandrill);
$transatioMail = new TransactionMail($adapter);

##Inspired By

https://github.com/gabrielbull/omnimail
