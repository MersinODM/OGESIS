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
    public const TEACHER_CREATE_LEVEL_3 = 'teacher.create.level3';
    public const TEACHER_CREATE_LEVEL_2 = 'teacher.create.level2';
    public const TEACHER_CREATE_LEVEL_1 = 'teacher.create.level1';
    public const TEACHER_UPDATE_LEVEL_3 = 'teacher.update.level3';
    public const TEACHER_UPDATE_LEVEL_2 = 'teacher.update.level2';
    public const TEACHER_UPDATE_LEVEL_1 = 'teacher.update.level1';
    public const TEACHER_DELETE_LEVEL_3 = 'teacher.delete.level3';
    public const TEACHER_DELETE_LEVEL_2 = 'teacher.delete.level2';
    public const TEACHER_DELETE_LEVEL_1 = 'teacher.delete.level1';
    public const TEACHER_LIST_LEVEL_3 = 'teacher.list.level3';
    public const TEACHER_LIST_LEVEL_2 = 'teacher.list.level2';
    public const TEACHER_LIST_LEVEL_1 = 'teacher.list.level1';
    // Takım işlmeleri ile ilgili yetkiler
    public const TEAM_CREATE_LEVEL_3 = 'team.create.level3';
    public const TEAM_CREATE_LEVEL_2 = 'team.create.level2';
    public const TEAM_CREATE_LEVEL_1 = 'team.create.level1';
    public const TEAM_UPDATE_LEVEL_3 = 'team.update.level3';
    public const TEAM_UPDATE_LEVEL_2 = 'team.update.level2';
    public const TEAM_UPDATE_LEVEL_1 = 'team.update.level1';
    public const TEAM_DELETE_LEVEL_3 = 'team.delete.level3';
    public const TEAM_DELETE_LEVEL_2 = 'team.delete.level2';
    public const TEAM_DELETE_LEVEL_1 = 'team.delete.level1';
    public const TEAM_LIST_LEVEL_3 = 'team.list.level3';
    public const TEAM_LIST_LEVEL_2 = 'team.list.level2';
    public const TEAM_LIST_LEVEL_1 = 'team.list.level1';
    public const TEAM_ADD_MEMBER_LEVEL_3 = 'team.add-member.level3';
    public const TEAM_ADD_MEMBER_LEVEL_2 = 'team.add-member.level2';
    public const TEAM_ADD_MEMBER_LEVEL_1 = 'team.add-member.level1';
    public const TEAM_REMOVE_MEMBER_LEVEL_3 = 'team.remove-member.level3';
    public const TEAM_REMOVE_MEMBER_LEVEL_2 = 'team.remove-member.level2';
    public const TEAM_REMOVE_MEMBER_LEVEL_1 = 'team.remove-member.level1';
    // Kurum izinleri
    public const INSTITUTION_CREATE_LEVEL_3 = 'institution.create.level3';
    public const INSTITUTION_CREATE_LEVEL_2 = 'institution.create.level2';
    public const INSTITUTION_UPDATE_LEVEL_3 = 'institution.update.level3';
    public const INSTITUTION_UPDATE_LEVEL_2 = 'institution.update.level2';
    public const INSTITUTION_DELETE_LEVEL_3 = 'institution.delete.level3';
    public const INSTITUTION_DELETE_LEVEL_2 = 'institution.delete.level2';
    public const INSTITUTION_IMPORT_LIST = 'institution.import-list';
    public const INSTITUTION_LIST_LEVEL_3 = 'institution.list.level3';
    public const INSTITUTION_LIST_LEVEL_2 = 'institution.list.level2';
    // Plan izinleri
    public const PLAN_CREATE_LEVEL_3 = 'plan.create.level3';
    public const PLAN_UPDATE_LEVEL_3 = 'plan.update.level3';
    public const PLAN_DELETE_LEVEL_3 = 'plan.delete.level3';
    // Aktivite izinleri
    public const ACTIVITY_CREATE_LEVEL_3 = 'activity.create.level3';
    public const ACTIVITY_CREATE_LEVEL_2 = 'activity.create.level2';
    public const ACTIVITY_CREATE_LEVEL_1 = 'activity.create.level1';
    public const ACTIVITY_UPDATE_LEVEL_3 = 'activity.update.level3';
    public const ACTIVITY_UPDATE_LEVEL_2 = 'activity.update.level2';
    public const ACTIVITY_UPDATE_LEVEL_1 = 'activity.update.level1';
    public const ACTIVITY_DELETE_LEVEL_3 = 'activity.delete.level3';
    public const ACTIVITY_DELETE_LEVEL_2 = 'activity.delete.level2';
    public const ACTIVITY_DELETE_LEVEL_1 = 'activity.delete.level1';
    public const ACTIVITY_LIST_LEVEL_3 = 'activity.list.level3';
    public const ACTIVITY_LIST_LEVEL_2 = 'activity.list.level2';
    public const ACTIVITY_LIST_LEVEL_1 = 'activity.list.level1';
    //Rapor yetkileri
    public const REPORT_UPLOAD = 'report.upload';
    public const REPORT_DELETE_LEVEL_3 = 'report.delete.level3';
    public const REPORT_DELETE_LEVEL_2 = 'report.delete.level2';
    public const REPORT_DELETE_LEVEL_1 = 'report.delete.level1';
    public const REPORT_LIST_LEVEL_3 = 'report.list.level3';
    public const REPORT_LIST_LEVEL_2 = 'report.list.level2';
    public const REPORT_LIST_LEVEL_1 = 'report.list.level1';



    public static function getPermissions(): array
    {
        return [


            //name                          // slug
            //Burada hiyerarşi yetkileri tanımlandı
            self::ALL => 'Tüm izinler',
            self::LEVEL_3 => 'İl Müdürlüğü Seviyesinde Yetki',
            self::LEVEL_2 => 'İlçe Müdürlüğü Seviyesinde Yetki',
            self::LEVEL_1 => 'Okul Müdürlüğü Seviyesinde Yetki',

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

            // Öğetmen yetkileri
            self::TEACHER_CREATE_LEVEL_3 => 'Öğretmen Oluşturma(İl Yetkisi)',
            self::TEACHER_CREATE_LEVEL_2 => 'Öğretmen Oluşturma(İlçe Yetkisi)',
            self::TEACHER_CREATE_LEVEL_1 => 'Öğretmen Oluşturma(Okul Yetkisi)',
            self::TEACHER_UPDATE_LEVEL_3 => 'Öğretmen Güncelleme(İl Yetkisi)',
            self::TEACHER_UPDATE_LEVEL_2 => 'Öğretmen Güncelleme(İlçe Yetkisi)',
            self::TEACHER_UPDATE_LEVEL_1 => 'Öğretmen Güncelleme(Okul Yetkisi)',
            self::TEACHER_DELETE_LEVEL_3 => 'Öğretmen Silme(İl Yetkisi)',
            self::TEACHER_DELETE_LEVEL_2 => 'Öğretmen Silme(İlçe Yetkisi)',
            self::TEACHER_DELETE_LEVEL_1 => 'Öğretmen Silme(Okul Yetkisi)',
            self::TEACHER_LIST_LEVEL_3 => 'Öğretmen Listeleme(İl Yetkisi)',
            self::TEACHER_LIST_LEVEL_2 => 'Öğretmen Listeleme(İlçe Yetkisi)',
            self::TEACHER_LIST_LEVEL_1 => 'Öğretmen Listeleme(Okul Yetkisi)',
            // Takım yetkileri
            self::TEAM_CREATE_LEVEL_3 => 'Takım Oluşturma(İl Yetkisi)',
            self::TEAM_CREATE_LEVEL_2 => 'Takım Oluşturma(İlçe Yetkisi)',
            self::TEAM_CREATE_LEVEL_1 => 'Takım Oluşturma(Okul Yetkisi)',
            self::TEAM_UPDATE_LEVEL_3 => 'Takım Güncelleme(İl Yetkisi)',
            self::TEAM_UPDATE_LEVEL_2 => 'Takım Güncelleme(İlçe Yetkisi)',
            self::TEAM_UPDATE_LEVEL_1 => 'Takım Güncelleme(Okul Yetkisi)',
            self::TEAM_DELETE_LEVEL_3 => 'Takım Silme(İl Yetkisi)',
            self::TEAM_DELETE_LEVEL_2 => 'Takım Silme(İlçe Yetkisi)',
            self::TEAM_DELETE_LEVEL_1 => 'Takım Silme(Okul Yetkisi)',
            self::TEAM_LIST_LEVEL_3 => 'Takım Listeleme(İl Yetkisi)',
            self::TEAM_LIST_LEVEL_2 => 'Takım Listeleme(İlçe Yetkisi)',
            self::TEAM_LIST_LEVEL_1 => 'Takım Listeleme(Okul Yetkisi)',
            self::TEAM_ADD_MEMBER_LEVEL_3 => 'Takıma Üye Ekleme(İl Yetkisi)',
            self::TEAM_ADD_MEMBER_LEVEL_2 => 'Takıma Üye Ekleme(İlçe Yetkisi)',
            self::TEAM_ADD_MEMBER_LEVEL_1 => 'Takıma Üye Ekleme(Okul Yetkisi)',
            self::TEAM_REMOVE_MEMBER_LEVEL_3 => 'Takıma Üye Ekleme(İl Yetkisi)',
            self::TEAM_REMOVE_MEMBER_LEVEL_2 => 'Takıma Üye Ekleme(İlçe Yetkisi)',
            self::TEAM_REMOVE_MEMBER_LEVEL_1 => 'Takıma Üye Ekleme(Okul Yetkisi)',
            // Kurum izinleri
            self::INSTITUTION_CREATE_LEVEL_3 => 'Kurum Oluşturma(İl Yetkisi)',
            self::INSTITUTION_CREATE_LEVEL_2 => 'Kurum Oluşturma(İlçe Yetkisi)',
            self::INSTITUTION_UPDATE_LEVEL_3 => 'Kurum Güncelleme(İl Yetkisi)',
            self::INSTITUTION_UPDATE_LEVEL_2 => 'Kurum Güncelleme(İlçe Yetkisi)',
            self::INSTITUTION_DELETE_LEVEL_3 => 'Kurum Silme(İl Yetkisi)',
            self::INSTITUTION_DELETE_LEVEL_2 => 'Kurum Silme(İlçe Yetkisi)',
            self::INSTITUTION_IMPORT_LIST => 'Toplu Kurum Ekleme',
            self::INSTITUTION_LIST_LEVEL_3 => 'Kurum Listeleme(İl Yetkisi)',
            self::INSTITUTION_LIST_LEVEL_2 => 'Kurum Listeleme(İlçe Yetkisi)',
            // Plan izinleri
            self::PLAN_CREATE_LEVEL_3 => 'Gelişim Planı Oluşturma(İl Yetkisi)',
            self::PLAN_UPDATE_LEVEL_3 => 'Gelişim Planı Güncelleme(İl Yetkisi)',
            self::PLAN_DELETE_LEVEL_3 => 'Gelişim Planı Silme(İl Yetkisi)',
            // Aktivite izinleri
            self::ACTIVITY_CREATE_LEVEL_3 => 'Aktivite Oluşturma(İl Yetkisi)',
            self::ACTIVITY_CREATE_LEVEL_2 => 'Aktivite Oluşturma(İlçe Yetkisi)',
            self::ACTIVITY_CREATE_LEVEL_1 => 'Aktivite Oluşturma(Okul Yetkisi)',
            self::ACTIVITY_UPDATE_LEVEL_3 => 'Aktivite Güncelleme(İl Yetkisi)',
            self::ACTIVITY_UPDATE_LEVEL_2 => 'Aktivite Güncelleme(İlçe Yetkisi)',
            self::ACTIVITY_UPDATE_LEVEL_1 => 'Aktivite Güncelleme(Okul Yetkisi)',
            self::ACTIVITY_DELETE_LEVEL_3 => 'Aktivite Silme (İl Yetkisi)',
            self::ACTIVITY_DELETE_LEVEL_2 => 'Aktivite Silme(İlçe Yetkisi)',
            self::ACTIVITY_DELETE_LEVEL_1 => 'Aktivite Silme(Okul Yetkisi)',
            self::ACTIVITY_LIST_LEVEL_3 => 'Aktivite Listeleme(İl Yetkisi)',
            self::ACTIVITY_LIST_LEVEL_2 => 'Aktivite Listeleme(İlçe Yetkisi)',
            self::ACTIVITY_LIST_LEVEL_1 => 'Aktivite Listeleme(Okul Yetkisi)',
            // Rapor izinleri
            self::REPORT_DELETE_LEVEL_3 => 'Rapor Silme(İl Yetkisi)',
            self::REPORT_DELETE_LEVEL_2 => 'Rapor Silme(İlçe Yetkisi)',
            self::REPORT_DELETE_LEVEL_1 => 'Rapor Silme(Okul Yetkisi)',
            self::REPORT_LIST_LEVEL_3 => 'Rapor Listeleme(İl Yetkisi)',
            self::REPORT_LIST_LEVEL_2 => 'Rapor Listeleme(İlçe Yetkisi)',
            self::REPORT_LIST_LEVEL_1 => 'Rapor Listeleme(Okul Yetkisi)',
            self::REPORT_UPLOAD => 'Rapor Yükleme'
        ];
    }
}