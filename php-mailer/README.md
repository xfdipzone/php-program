# php-mailer

php 电邮发送类

## 介绍

php 实现的电邮发送类，用于发送电子邮件

可设置发件人，回复人，收件人，抄送收件人，密件抄送收件人，附件等

---

## 功能

- 设置发件人

- 设置回复人（多个）

- 设置收件人（多个）

- 设置抄送收件人（多个）

- 设置密件抄送收件人（多个）

- 设置附件（多个）

- 设置电邮格式 (text/html)

- 发送电邮

---

## 类说明

**PHPMailer** `Mail/Core/PHPMailer.php`

内部电邮发送核心类

**SMTP** `Mail/Core/SMTP.php`

支持 SMTP 协议的内部电邮发送类

**Mailer** `Mail/Mailer.php`

电邮发送器，用于设置发件人，收件人，附件等，并执行发送

**ServerConfig** `Mail/ServerConfig.php`

电邮服务器配置

**Sender** `Mail/Sender.php`

电邮发件人结构类

**Recipient** `Mail/Recipient.php`

电邮收件人结构类，用于收件人，抄送收件人，密件抄送收件人，回复人

**Attachment** `Mail/Attachment.php`

电邮附件结构类

**Utils** `Mail/Utils.php`

通用方法集合类

---

## 演示

```php
// 自定义测试账号与测试电邮地址
$private_config = array(
    'smtp_host' => 'your smtp host',
    'smtp_username' => 'your smtp username',
    'smtp_password' => 'your smtp password',
    'from_email' => 'your from email',
    'from_name' => 'your from name',
    'replier_email' => 'your replier email',
    'replier_name' => 'your replier name',
    'recipient_email' => 'your recipient email',
    'recipient_name' => 'your recipient name',
    'cc_recipient_email' => 'your cc reciopient email',
    'cc_recipient_name' => 'your cc recipient name',
    'bcc_recipient_email' => 'your bcc recipient email',
    'bcc_recipient_name' => 'your bcc recipient name'
);

$smtp_host = $private_config['smtp_host'];
$smtp_username = $private_config['smtp_username'];
$smtp_password = $private_config['smtp_password'];
$server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
$mailer = new \Mail\Mailer($server_config);

// sender
$from_email = $private_config['from_email'];
$from_name = $private_config['from_name'];
$sender = new \Mail\Sender($from_email, $from_name);
$mailer->setSender($sender);

// replier
$replier_email = $private_config['replier_email'];
$replier_name = $private_config['replier_name'];
$replier = new \Mail\Recipient($replier_email, $replier_name);
$mailer->addReplier($replier);

// recipients
$recipient_email = $private_config['recipient_email'];
$recipient_name = $private_config['recipient_name'];
$recipient = new \Mail\Recipient($recipient_email, $recipient_name);
$mailer->addRecipient($recipient);

// cc recipients
$cc_recipient_email = $private_config['cc_recipient_email'];
$cc_recipient_name = $private_config['cc_recipient_name'];
$cc_recipient = new \Mail\Recipient($cc_recipient_email, $cc_recipient_name);
$mailer->addCcRecipient($cc_recipient);

// bcc recipients
$bcc_recipient_email = $private_config['bcc_recipient_email'];
$bcc_recipient_name = $private_config['bcc_recipient_name'];
$bcc_recipient = new \Mail\Recipient($bcc_recipient_email, $bcc_recipient_name);
$mailer->addBccRecipient($bcc_recipient);

// attachments
$attachment_file = '/tmp/attachment.txt';
file_put_contents($attachment_file, 'attachment file');

$attachment_name = '附件.txt';
$attachment = new \Mail\Attachment($attachment_file, $attachment_name);
$mailer->addAttachment($attachment);

// html
$mailer->setIsHtml(true);

// send
$subject = '测试电邮标题';
$body = '测试电邮内容';
$ret = $mailer->send($subject, $body);
var_dump($ret);
```

更多功能演示可参考单元测试代码 [Mailer Unit Test](<../tests/Mail>)

执行 `Mailer` 发送方法的单元测试，需要在 `tests/Mail/` 目录中手动创建 `private.config` 文件

private.config 文件内容格式如下，可自行设置账号密码及测试使用的电邮地址

```json
{
    "smtp_host": "your smtp host",
    "smtp_username": "your smtp username",
    "smtp_password": "your smtp password",
    "from_email": "your from email",
    "from_name": "your from name",
    "replier_email": "your replier email",
    "replier_name": "your replier name",
    "recipient_email": "your recipient email",
    "recipient_name": "your recipient name",
    "cc_recipient_email": "your cc reciopient email",
    "cc_recipient_name": "your cc recipient name",
    "bcc_recipient_email": "your bcc recipient email",
    "bcc_recipient_name": "your bcc recipient name"
}
```
