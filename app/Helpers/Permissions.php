<?php

namespace App\Helpers;
/*
 * Tüm yetkiler kombinasyonel olarak planlanmıştır buradaki kilit nokta seviyelerdir.
 * Örneğin: TEACHER ve CREATE yetkisine sahip olan her bir kulanıcı öğretmen oluşturabilir ancak
 * INSTITUTION ve CREATE yetkisine sahip kullancı için LEVEL_2 veya LEVEL_3 yetki lazımdır
 * Burada tüm kurumlara CRUD ve SUBJE yetkileri verilebilir ancak seviyeler mutlaka kurumun seviyesinde olmalıdır
 */

class Permissions
{

    public const ALL = '*';
    public const LEVEL_3 = 'level.3';
    public const LEVEL_2 = 'level.2';
    public const LEVEL_1 = 'level.1';

    private const CREATE = 'create';
    private const DELETE = 'delete';
    private const UPDATE = 'update';
    private const LIST = 'list';
    private const SHOW = 'show';
    private const UPLOAD = 'upload';

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

    public const TEACHER_CREATE = self::TEACHER . '.' . self::CREATE;
    public const TEACHER_UPDATE = self::TEACHER . '.' . self::UPDATE;
    public const TEACHER_DELETE = self::TEACHER . '.' . self::DELETE;
    public const TEACHER_LIST = self::TEACHER . '.' . self::LIST;
    public const TEACHER_SHOW = self::TEACHER . '.' . self::SHOW;
    public const TEACHER_UPLOAD = self::TEACHER . '.' . self::UPLOAD;

    public const BRANCH_CREATE = self::BRANCH . '.' . self::CREATE;
    public const BRANCH_UPDATE = self::BRANCH . '.' . self::UPDATE;
    public const BRANCH_DELETE = self::BRANCH . '.' . self::DELETE;
    public const BRANCH_LIST = self::BRANCH . '.' . self::LIST;

    public const TEAM_CREATE = self::TEAM . '.' . self::CREATE;
    public const TEAM_UPDATE = self::TEAM . '.' . self::UPDATE;
    public const TEAM_DELETE = self::TEAM . '.' . self::DELETE;
    public const TEAM_LIST = self::TEAM . '.' . self::LIST;

    public const INSTITUTION_CREATE = self::INSTITUTION . '.' . self::CREATE;
    public const INSTITUTION_UPDATE = self::INSTITUTION . '.' . self::UPDATE;
    public const INSTITUTION_DELETE = self::INSTITUTION . '.' . self::DELETE;
    public const INSTITUTION_LIST = self::INSTITUTION . '.' . self::LIST;
    public const INSTITUTION_UPLOAD = self::INSTITUTION . '.' . self::UPLOAD;

    public const PLAN_CREATE = self::PLAN . '.' . self::CREATE;
    public const PLAN_UPDATE = self::PLAN . '.' . self::UPDATE;
    public const PLAN_DELETE = self::PLAN . '.' . self::DELETE;
    public const PLAN_LIST = self::PLAN . '.' . self::LIST;

    public const ACTIVITY_CREATE = self::ACTIVITY . '.' . self::CREATE;
    public const ACTIVITY_UPDATE = self::ACTIVITY . '.' . self::UPDATE;
    public const ACTIVITY_DELETE = self::ACTIVITY . '.' . self::DELETE;
    public const ACTIVITY_LIST = self::ACTIVITY . '.' . self::LIST;

    public const REPORT_CREATE = self::REPORT . '.' . self::CREATE;
    public const REPORT_UPDATE = self::REPORT . '.' . self::UPDATE;
    public const REPORT_DELETE = self::REPORT . '.' . self::DELETE;
    public const REPORT_LIST = self::REPORT . '.' . self::LIST;

    public const THEME_CREATE = self::THEME . '.' . self::CREATE;
    public const THEME_UPDATE = self::THEME . '.' . self::UPDATE;
    public const THEME_DELETE = self::THEME . '.' . self::DELETE;
    public const THEME_LIST = self::THEME . '.' . self::LIST;

    public const DISTRICT_CREATE = self::DISTRICT . '.' . self::CREATE;
    public const DISTRICT_UPDATE = self::DISTRICT . '.' . self::UPDATE;
    public const DISTRICT_DELETE = self::DISTRICT . '.' . self::DELETE;  // Burada soft delete olabilir
    public const DISTRICT_LIST = self::DISTRICT . '.' . self::LIST;

    public const PARTNER_CREATE = self::PARTNER . '.' . self::CREATE;
    public const PARTNER_UPDATE = self::PARTNER . '.' . self::UPDATE;
    public const PARTNER_DELETE = self::PARTNER . '.' . self::DELETE;
    public const PARTNER_LIST = self::PARTNER . '.' . self::LIST;

    public const PERSONAL_PASSWORD_CHANGE = self::PERSONAL . '.password_change';
    public const PERSONAL_UPDATE = self::PERSONAL . '.' . self::UPDATE;


    public static function getPermissions(): array
    {
        return [
            //name                          // slug
            //Burada hiyerarşi yetkileri tanımlandı
            self::ALL => 'Tüm izinler',
            self::LEVEL_3 => 'İl Müdürlüğü Yetkisi',
            self::LEVEL_2 => 'İlçe Müdürlüğü Yetkisi',
            self::LEVEL_1 => 'Okul Müdürlüğü Yetkisi',

            self::TEACHER_CREATE => 'Öğretmen oluşturma yetkisi',
            self::TEACHER_UPDATE => 'Öğretmen güncelleme yetkisi',
            self::TEACHER_DELETE => 'öğretmen silme yetkisi', // Bu yetki dikkatli kullanılmalı
            self::TEACHER_LIST => 'Öğretmen listeleme yetkisi',
            self::TEACHER_SHOW => 'Öğretmen gösterme yetkisi',
            self::TEACHER_UPLOAD => 'Öğretmenleri toplu yükleme yetkisi',
            self::BRANCH_CREATE => 'Alan/Branş oluşturma yetkisi',
            self::BRANCH_UPDATE => 'Alan/Branş güncelleme yetkisi',
            self::BRANCH_DELETE => 'Alan/Branş silme yetkisi',
            self::BRANCH_LIST => 'Alan/Branş listeleme yetkisi',
            self::TEAM_CREATE => 'Takım/Ekip oluşturma yetkisi',
            self::TEAM_UPDATE => 'Takım/Ekip güncelleme yetkisi',
            self::TEAM_DELETE => 'Takım/Ekip silme yetkisi',
            self::TEAM_LIST => 'Takım listeleme yetkisi',
            self::INSTITUTION_CREATE => 'Kurum listeleme yetkisi',
            self::INSTITUTION_UPDATE => 'Kurum güncelleme yetkisi',
            self::INSTITUTION_DELETE => 'Kurum silme yetkisi', // Kurum silme softdelete şeklinde düşünülmeli vey aktif pasif yapılmalı aynı şey gerçi
            self::INSTITUTION_LIST => 'Kurum listeleme yetkisi',
            self::INSTITUTION_UPLOAD => 'Kurumları toplu yükleme yetkisi',
            self::PLAN_CREATE => 'Plan oluşturma yetkisi',
            self::PLAN_UPDATE => 'Plan güncelleme yetkisi',
            self::PLAN_DELETE => 'Plan silme yetkisi', // Plan girişi yapılmışsa aktarma yapılmalı yeni plana
            self::PLAN_LIST => 'Plan listeleme yetkisi',
            self::ACTIVITY_CREATE => 'Aktivite/Etkinlik oluşturma yetkisi',
            self::ACTIVITY_UPDATE => 'Aktivite/Etkinlik güncelleme yetkisi',
            self::ACTIVITY_DELETE => 'Aktivite/Etkinlik silme yetkisi',
            self::ACTIVITY_LIST => 'Aktivite/Etkinlik listeleme yetkisi',
            self::REPORT_CREATE => 'Rapor oluşturma yetkisi',
            self::REPORT_UPDATE => 'Rapor güncelleme yetkisi',
            self::REPORT_DELETE => 'Rapor silme yetkisi',
            self::REPORT_LIST => 'Rapor listeleme yetkisi',
            self::THEME_CREATE => 'Tema oluşturma yetkisi',
            self::THEME_UPDATE => 'Tema güncelleme yetkisi',
            self::THEME_DELETE => 'Tema silme yetkisi', // Soft delete ya aktif pasif etme durumu söz konusu olabilir
            self::THEME_LIST => 'Tema listeleme yetkisi',
            self::DISTRICT_CREATE => 'İlçe oluşturma yetkisi',
            self::DISTRICT_UPDATE => 'İlçe güncelleme yetkisi',
            self::DISTRICT_DELETE => 'İlçe silme yetkisi',
            self::DISTRICT_LIST => 'İlçe listeleme yetkisi',
            self::PARTNER_CREATE => 'Paydaş/Partner oluşturma yetkisi',
            self::PARTNER_UPDATE => 'Paydaş/Partner güncelleme yetkisi',
            self::PARTNER_DELETE => 'Paydaş/Partner silme yetkisi',
            self::PARTNER_LIST => 'Paydaş/Partner listeleme yetkisi',
            self::PERSONAL_PASSWORD_CHANGE => 'Kişisel şifre değiştirme yetkisi',
            self::PERSONAL_UPDATE => 'Kişisel bilgileri güncelleme yetkisi',
        ];
    }
}