<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214100505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_8795450266C5951B');
        $this->addSql('CREATE TABLE VSPAY_PromotionActions (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_FEEF777139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_PromotionCoupons (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, usage_limit INT DEFAULT NULL, used INT NOT NULL, expires_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FFC2178077153098 (code), INDEX IDX_FFC21780139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_PromotionRules (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_9D727099139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Promotions (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, exclusive TINYINT(1) NOT NULL, usage_limit INT DEFAULT NULL, used INT NOT NULL, coupon_based TINYINT(1) NOT NULL, starts_at DATETIME DEFAULT NULL, ends_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A3DFF5C077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSPAY_PromotionActions ADD CONSTRAINT FK_FEEF777139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)');
        $this->addSql('ALTER TABLE VSPAY_PromotionCoupons ADD CONSTRAINT FK_FFC21780139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)');
        $this->addSql('ALTER TABLE VSPAY_PromotionRules ADD CONSTRAINT FK_9D727099139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)');
        $this->addSql('ALTER TABLE VSPAY_Coupons DROP FOREIGN KEY FK_117A76D538248176');
        $this->addSql('DROP TABLE VSPAY_Coupons');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('DROP INDEX IDX_8795450266C5951B ON VSPAY_Order');
        $this->addSql('ALTER TABLE VSPAY_Order DROP coupon_id, CHANGE status status ENUM(\'shopping_cart\', \'paid_order\', \'pending_order\', \'failed_order\')');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSPAY_Coupons (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, code VARCHAR(16) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, amount_off NUMERIC(8, 2) DEFAULT NULL, percent_off NUMERIC(8, 2) DEFAULT NULL, valid TINYINT(1) NOT NULL, type VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_117A76D538248176 (currency_id), UNIQUE INDEX UNIQ_117A76D577153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'Coupons fields are Inspired by Stripe Coupon Fields\' ');
        $this->addSql('ALTER TABLE VSPAY_Coupons ADD CONSTRAINT FK_117A76D538248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSPAY_PromotionActions DROP FOREIGN KEY FK_FEEF777139DF194');
        $this->addSql('ALTER TABLE VSPAY_PromotionCoupons DROP FOREIGN KEY FK_FFC21780139DF194');
        $this->addSql('ALTER TABLE VSPAY_PromotionRules DROP FOREIGN KEY FK_9D727099139DF194');
        $this->addSql('DROP TABLE VSPAY_PromotionActions');
        $this->addSql('DROP TABLE VSPAY_PromotionCoupons');
        $this->addSql('DROP TABLE VSPAY_PromotionRules');
        $this->addSql('DROP TABLE VSPAY_Promotions');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSPAY_Order ADD coupon_id INT DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_8795450266C5951B FOREIGN KEY (coupon_id) REFERENCES VSPAY_Coupons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8795450266C5951B ON VSPAY_Order (coupon_id)');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
