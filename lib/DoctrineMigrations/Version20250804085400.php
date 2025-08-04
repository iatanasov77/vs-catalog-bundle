<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250804085400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans ADD position INT DEFAULT 0');
        $this->addSql('ALTER TABLE VSCMS_SlidersItemsPhotos ADD CONSTRAINT FK_A9581A697E3C61F9 FOREIGN KEY (owner_id) REFERENCES VSCMS_SlidersItems (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C8D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C9A1887DC FOREIGN KEY (subscription_id) REFERENCES VSCAT_PricingPlanSubscriptions (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C4584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)');
        $this->addSql('ALTER TABLE VSPAY_PromotionActions CHANGE configuration configuration JSON NOT NULL');
        $this->addSql('ALTER TABLE VSPAY_PromotionRules CHANGE configuration configuration JSON NOT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans DROP position');
        $this->addSql('ALTER TABLE VSCMS_SlidersItemsPhotos DROP FOREIGN KEY FK_A9581A697E3C61F9');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C8D9F6D38');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C9A1887DC');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C4584665A');
        $this->addSql('ALTER TABLE VSPAY_PromotionActions CHANGE configuration configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE VSPAY_PromotionRules CHANGE configuration configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
