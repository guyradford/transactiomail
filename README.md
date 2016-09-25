# TransactioMail
Transactional Email Service


##SendInBlue



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