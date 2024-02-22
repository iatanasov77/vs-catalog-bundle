<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218204944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSPAY_Adjustments (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, order_item_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, `label` VARCHAR(255) DEFAULT NULL, amount INT NOT NULL, is_neutral TINYINT(1) NOT NULL, is_locked TINYINT(1) NOT NULL, origin_code VARCHAR(255) DEFAULT NULL, details LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_55CA71E28D9F6D38 (order_id), INDEX IDX_55CA71E2E415FB15 (order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Promotion_Orders (order_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_DEAB205F8D9F6D38 (order_id), INDEX IDX_DEAB205F139DF194 (promotion_id), PRIMARY KEY(order_id, promotion_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Promotion_Applications (promotion_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_1D3F36D5139DF194 (promotion_id), INDEX IDX_1D3F36D53E030ACD (application_id), PRIMARY KEY(promotion_id, application_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSPAY_Adjustments ADD CONSTRAINT FK_55CA71E28D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_Adjustments ADD CONSTRAINT FK_55CA71E2E415FB15 FOREIGN KEY (order_item_id) REFERENCES VSPAY_OrderItem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Orders ADD CONSTRAINT FK_DEAB205F8D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Orders ADD CONSTRAINT FK_DEAB205F139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Applications ADD CONSTRAINT FK_1D3F36D5139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Applications ADD CONSTRAINT FK_1D3F36D53E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSPAY_Order ADD promotion_coupon_id INT DEFAULT NULL, ADD items_total INT NOT NULL, ADD adjustments_total INT NOT NULL, ADD total INT NOT NULL, CHANGE status status VARCHAR(32) NOT NULL COMMENT \'NEED THIS BECAUSE ORDER SHOULD BE CREATED BEFORE THE PAYMENT IS PRAPARED AND DONE.\'');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_8795450217B24436 FOREIGN KEY (promotion_coupon_id) REFERENCES VSPAY_PromotionCoupons (id)');
        $this->addSql('CREATE INDEX IDX_8795450217B24436 ON VSPAY_Order (promotion_coupon_id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD adjustments_total INT NOT NULL, ADD total INT NOT NULL, ADD product_name LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSPAY_Adjustments DROP FOREIGN KEY FK_55CA71E28D9F6D38');
        $this->addSql('ALTER TABLE VSPAY_Adjustments DROP FOREIGN KEY FK_55CA71E2E415FB15');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Orders DROP FOREIGN KEY FK_DEAB205F8D9F6D38');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Orders DROP FOREIGN KEY FK_DEAB205F139DF194');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Applications DROP FOREIGN KEY FK_1D3F36D5139DF194');
        $this->addSql('ALTER TABLE VSPAY_Promotion_Applications DROP FOREIGN KEY FK_1D3F36D53E030ACD');
        $this->addSql('DROP TABLE VSPAY_Adjustments');
        $this->addSql('DROP TABLE VSPAY_Promotion_Orders');
        $this->addSql('DROP TABLE VSPAY_Promotion_Applications');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_8795450217B24436');
        $this->addSql('DROP INDEX IDX_8795450217B24436 ON VSPAY_Order');
        $this->addSql('ALTER TABLE VSPAY_Order DROP promotion_coupon_id, DROP items_total, DROP adjustments_total, DROP total, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP adjustments_total, DROP total, DROP product_name');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
