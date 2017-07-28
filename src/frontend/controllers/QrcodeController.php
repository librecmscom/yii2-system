<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system\frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use dosamigos\qrcode\formats\MailTo;
use dosamigos\qrcode\formats\MailMessage;
use dosamigos\qrcode\formats\Bitcoin;
use dosamigos\qrcode\formats\Geo;
use dosamigos\qrcode\formats\iCal;
use dosamigos\qrcode\formats\MeCard;
use dosamigos\qrcode\formats\Mms;
use dosamigos\qrcode\formats\Phone;
use dosamigos\qrcode\formats\Sms;
use dosamigos\qrcode\formats\Wifi;
use dosamigos\qrcode\formats\vCard;
use dosamigos\qrcode\formats\Youtube;
use dosamigos\qrcode\QrCode;
use dosamigos\qrcode\lib\Enum;


/**
 * Class QrcodeController
 * @package yuncms\system\controllers
 */
class QrcodeController extends Controller
{
    /**
     * @var int
     */
    public $level;

    /**
     * @var int 图像大小
     */
    public $size;

    /**
     * @var int 图像边距
     */
    public $margin;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_RAW;
        $this->level = Yii::$app->request->get('level', Enum::QR_ECLEVEL_H);
        $this->size = Yii::$app->request->get('size', 5);
        $this->margin = Yii::$app->request->get('margin', 1);
    }

    /**
     * @param string $url
     */
    public function actionUrl($url)
    {
        return QrCode::png($url, false, $this->level, $this->size, $this->margin);
    }

    /**
     * wifi二维码
     * @param string $authentication the authentication type. e.g., WPA
     * @param string $ssid
     * @param string $password
     * @param string $hidden hidden SSID (optional; equals false if omitted): either true or false
     */
    public function actionWifi($authentication, $ssid, $password, $hidden = 'false')
    {
        $wifi = new Wifi(['authentication' => $authentication, 'ssid' => $ssid, 'password' => $password, 'hidden' => $hidden]);
        return QrCode::png($wifi->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $title
     */
    public function actionBookMark($title)
    {
        $bookMark = new BookMark(['title' => $title]);
        return QrCode::png($bookMark->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $email
     */
    public function actionMailto($email)
    {
        $mailTo = new MailTo(['email' => $email]);
        return QrCode::png($mailTo->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $subject
     * @param string $body
     */
    public function actionMailMessage($subject, $body)
    {
        $mailMessage = new MailMessage(['subject' => $subject, 'body' => $body]);
        return QrCode::png($mailMessage->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param $address
     * @param $amount
     */
    public function actionBitcoin($address, $amount)
    {
        $bitcoin = new Bitcoin(['address' => $address, 'amount' => $amount]);
        return QrCode::png($bitcoin->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $lat
     * @param string $lng
     * @param string $altitude
     */
    public function actionGeo($lat, $lng, $altitude)
    {
        $geo = new Geo(['lat' => $lat, 'lng' => $lng, 'altitude' => $altitude]);
        return QrCode::png($geo->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $summary
     * @param string $dtStart
     * @param string $dtEnd
     */
    public function actionIcal($summary, $dtStart, $dtEnd)
    {
        $iCal = new iCal(['summary' => $summary, 'dtStart' => $dtStart, 'dtEnd' => $dtEnd]);
        return QrCode::png($iCal->getText(), false, $this->level, $this->size, $this->margin);
    }

    public function actionMeCard($firstName, $lastName, $nickName = null, $address = null, $phone = null, $videoPhone = null, $birthday = null, $note = null, $sound = null)
    {
        $meCard = new MeCard([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'nickName' => $nickName,
            'address' => $address,
            'phone' => $phone,
            'videoPhone' => $videoPhone,
            'birthday' => $birthday,
            'note' => $note,
            'sound' => $sound
        ]);
        return QrCode::png($meCard->getText(), false, $this->level, $this->size, $this->margin);
    }

    public function actionMms($phone = null, $msg = null)
    {
        $mms = new Mms([
            'phone' => $phone,
            'msg' => $msg,
        ]);
        return QrCode::png($mms->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param $phone
     */
    public function actionPhone($phone)
    {
        $phone = new Phone([
            'phone' => $phone,
        ]);
        return QrCode::png($phone->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param $phone
     * @param $msg
     */
    public function actionSms($phone, $msg)
    {
        $sms = new Sms([
            'phone' => $phone,
            'msg' => $msg
        ]);
        return QrCode::png($sms->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param $name
     * @param null $fullName
     * @param null $address
     * @param null $nickName
     * @param null $workPhone
     * @param null $homePhone
     * @param null $birthday
     * @param null $anniversary
     * @param null $gender
     * @param null $categories
     * @param null $impp
     * @param null $photo
     * @param null $role
     * @param null $organization
     * @param null $note
     * @param null $lang
     */
    public function actionVCard($name, $fullName = null, $address = null, $nickName = null, $workPhone = null, $homePhone = null, $birthday = null, $anniversary = null, $gender = null, $categories = null, $impp = null, $photo = null, $role = null, $organization = null, $note = null, $lang = null)
    {
        $vCard = new vCard([
            'name' => $name, 'fullName' => $fullName, 'address' => $address, 'nickName' => $nickName,
            'workPhone' => $workPhone, 'homePhone' => $homePhone, 'birthday' => $birthday,
            'anniversary' => $anniversary, 'gender' => $gender, 'categories' => $categories, 'impp' => $impp,
            'photo' => $photo, 'role' => $role, 'organization' => $organization, 'note' => $note, 'lang' => $lang,
        ]);
        return QrCode::png($vCard->getText(), false, $this->level, $this->size, $this->margin);
    }

    /**
     * @param string $videoId
     */
    public function actionYoutube($videoId)
    {
        $youtube = new Youtube([
            'videoId' => $videoId,
        ]);
        return QrCode::png($youtube->getText(), false, $this->level, $this->size, $this->margin);
    }
}