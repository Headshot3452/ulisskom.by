<?php
/**
 * A email extension for yii
 *
 * Based on php mail configure
 *
 * @link      http://github.com/tlikai/YiiMailer
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.youyuge.com/license New BSD License
 */

require dirname(__FILE__) . DIRECTORY_SEPARATOR .  'Mailer.php';

class PhpMailer extends Mailer
{
    public $from='';

    public $html=false;

    public function getHeaders()
    {
        if ($this->html===false)
        {
            $contentType='text/plain';
        }
        else
        {
            $contentType='text/html';
        }
        return array(
            'X-Priority: 3',
            'X-Mailer: Yii mailer',
            'MIME-Version: 1.0',
            'Content-type: '.$contentType.'; charset=' . Yii::app()->charset,
            'From: '.$this->from,
            'Reply-To: '.$this->from,
        );
    }

    public function isHtml($boolean)
    {
        $this->html=$boolean;

        return $this;
    }

    public function setFrom($from)
    {
        $this->from=$from;

        return $this;
    }

    public function send($to, $subject, $message)
    {
        $to = is_array($to) ? implode(',', $to) : $to;
        $headers = implode($this->crlf, $this->headers);
        return mail($to, $subject, $message, $headers);
    }
}
