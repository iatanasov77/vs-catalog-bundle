<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213085224 extends AbstractMigration
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
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A0E415FB15');
        $this->addSql('DROP INDEX UNIQ_EA3E01A0E415FB15 ON VSCAT_PricingPlanSubscriptions');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP order_item_id');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type ENUM(\'discount_coupon\', \'payment_coupon\')');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status ENUM(\'shopping_cart\', \'paid_order\', \'pending_order\', \'failed_order\')');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD subscription_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C9A1887DC FOREIGN KEY (subscription_id) REFERENCES VSCAT_PricingPlanSubscriptions (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C4584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)');
        $this->addSql('CREATE INDEX IDX_1C9B655C9A1887DC ON VSPAY_OrderItem (subscription_id)');
        $this->addSql('CREATE INDEX IDX_1C9B655C4584665A ON VSPAY_OrderItem (product_id)');
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
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD order_item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A0E415FB15 FOREIGN KEY (order_item_id) REFERENCES VSPAY_OrderItem (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA3E01A0E415FB15 ON VSCAT_PricingPlanSubscriptions (order_item_id)');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C9A1887DC');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C4584665A');
        $this->addSql('DROP INDEX IDX_1C9B655C9A1887DC ON VSPAY_OrderItem');
        $this->addSql('DROP INDEX IDX_1C9B655C4584665A ON VSPAY_OrderItem');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP subscription_id, DROP product_id');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
