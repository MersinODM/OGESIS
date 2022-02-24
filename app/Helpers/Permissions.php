<?php

namespace App\Helpers;

class Permissions
{
    public const ALL = '*';
    public const LEVEL_3 = 'level.3';
    public const LEVEL_2 = 'level.2';
    public const LEVEL_1 = 'level.1';

    public const CREATE = 'create';
    public const DELETE = 'delete';
    public const UPDATE = 'update';
    public const LIST = 'list';
    public const SHOW = 'show';
    public const UPLOAD = 'upload';
    //Öğretmen işlemleri ile ilgili yetkiler

    public const TEACHER = 'teacher';
    public const BRANCH = 'branch';
    public const TEAM = 'team';
    public const INSTITUTION = 'institution';
    public const PLAN = 'plan';
    public const ACTIVITY = 'activity';
    public const REPORT = 'report';
    public const THEME = 'theme';
    public const DISTRICT = 'district';
    public const PARTNER = 'partner';
    public const PERSONAL = 'personal';




    public static function getPermissions(): array
    {
        return [
            //name                          // slug
            //Burada hiyerarşi yetkileri tanımlandı
            self::ALL => 'Tüm izinler',
            self::LEVEL_3 => 'İl Müdürlüğü Yetkisi',
            self::LEVEL_2 => 'İlçe Müdürlüğü Yetkisi',
            self::LEVEL_1 => 'Okul Müdürlüğü Yetkisi',

            //Burada aksiyon yetkileri
            self::CREATE => 'Oluşturma Yetkisi',
            self::UPDATE => 'Güncelleme Yetkisi',
            self::DELETE => 'Silme Yetkisi',
            self::LIST => 'Listeleme Yetkisi',
            self::SHOW => 'Gösterme Yetkisi',
            self::UPLOAD => 'Yükleme Yetkisi',

            //Burada subje yetkileri
            self::TEACHER => 'Öğretmen İşlemleri Yetkisi',
            self::TEAM => 'Takım İşlemleri Yetkisi',
            self::THEME => 'Tema İşlemleri Yetkisi',
            self::INSTITUTION => 'Kurum İşlemleri Yetkisi',
            self::PLAN => 'Gelişim Planı İşlemleri Yetkisi',
            self::ACTIVITY => 'Etkinlik İşlemleri Yetkisi',
            self::REPORT => 'Rapor İşlemleri Yetkisi',
            self::PERSONAL => 'Kişisel İşlemler Yetkisi',
            self::BRANCH => 'Alan/Branş İşlemleri Yetkisi',
            self::DISTRICT => 'İlçe İşlemleri Yetkisi',
            self::PARTNER => 'Partner/Paydaş İşlemleri Yetkisi',
        ];
    }
}