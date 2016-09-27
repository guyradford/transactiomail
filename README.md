# TransactioMail
Transactional Email Service

[![Build Status](https://travis-ci.org/guyradford/transactiomail.svg?branch=master)](https://travis-ci.org/guyradford/transactiomail) [![Coverage Status](https://coveralls.io/repos/github/guyradford/transactiomail/badge.svg?branch=master)](https://coveralls.io/github/guyradford/transactiomail?branch=master)

##Feature Table

Adapter Void    SendInBlue  Mandrill
Feature
XX
YY
ZZ


##SendInBlue

https://apidocs.sendinblue.com/tutorial-sending-transactional-email/

```
$mailin = new Mailin("https://api.sendinblue.com/v2.0","your access key");
$adapter = new SendInBlue($mailin);
$transatioMail = new TransactioMail($adapter);
 
$email = new TemplatedEmailMessage()
    ->setFromEmailAddress('from@example.co.uk')
    ->setReplyToEmailAddress('replay@example.co.uk')
    ->addToEmailAddress('to@example.com')
    ->addCcEmailAddress('cc@example.com')
    ->addBccEmailAddress('bcc@example.com')
    ->setSubject('Special Offer') // see note 1
    ->addMergeField('firstname', 'John') // see note 2
    ->addHeader('Content-Type', 'text/html;charset=iso-8859-1');
    
    
$response = $transatioMail->sendTemplate($email);w
 
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
$transatioMail = new TransactioMail($adapter);

##Inspired By

https://github.com/gabrielbull/omnimail
