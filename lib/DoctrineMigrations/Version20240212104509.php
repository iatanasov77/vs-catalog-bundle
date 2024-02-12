<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212104509 extends AbstractMigration
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
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD currency_id INT DEFAULT NULL, ADD order_item_id INT DEFAULT NULL, ADD price NUMERIC(8, 2) NOT NULL');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A038248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A0E415FB15 FOREIGN KEY (order_item_id) REFERENCES VSPAY_OrderItem (id)');
        $this->addSql('CREATE INDEX IDX_EA3E01A038248176 ON VSCAT_PricingPlanSubscriptions (currency_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA3E01A0E415FB15 ON VSCAT_PricingPlanSubscriptions (order_item_id)');
        $this->addSql('ALTER TABLE VSCAT_Products ADD average_rating DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type ENUM(\'discount_coupon\', \'payment_coupon\')');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status ENUM(\'shopping_cart\', \'paid_order\', \'pending_order\', \'failed_order\')');
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
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A038248176');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A0E415FB15');
        $this->addSql('DROP INDEX IDX_EA3E01A038248176 ON VSCAT_PricingPlanSubscriptions');
        $this->addSql('DROP INDEX UNIQ_EA3E01A0E415FB15 ON VSCAT_PricingPlanSubscriptions');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP currency_id, DROP order_item_id, DROP price');
        $this->addSql('ALTER TABLE VSCAT_Products DROP average_rating');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
