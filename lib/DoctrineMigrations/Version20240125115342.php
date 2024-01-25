<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125115342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSCAT_PricingPlanCategories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, taxon_id INT DEFAULT NULL, INDEX IDX_10C2B955727ACA70 (parent_id), UNIQUE INDEX UNIQ_10C2B955DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_PricingPlanSubscriptions (id INT AUTO_INCREMENT NOT NULL, pricing_plan_id INT DEFAULT NULL, user_id INT DEFAULT NULL, recurring_payment TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, expires_at DATETIME DEFAULT NULL COMMENT \'Is Updated when create a  New payment for this subscription.\', gateway_attributes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', active TINYINT(1) DEFAULT 0 NOT NULL COMMENT \'One Active Subscription for an User and for PaidService. Wnen the Payment succeed set active true and set active false for previous active for this paid service.\', INDEX IDX_EA3E01A029628C71 (pricing_plan_id), INDEX IDX_EA3E01A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_PricingPlans (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, category_id INT NOT NULL, paid_service_id INT NOT NULL, active TINYINT(1) NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, premium TINYINT(1) NOT NULL, discount NUMERIC(8, 2) DEFAULT NULL, price NUMERIC(8, 2) DEFAULT \'0.00\' NOT NULL, gateway_attributes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_615E6C0538248176 (currency_id), INDEX IDX_615E6C0512469DE2 (category_id), INDEX IDX_615E6C0587FFD8A7 (paid_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_ProductCategories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, taxon_id INT DEFAULT NULL, INDEX IDX_7ADE9A79727ACA70 (parent_id), UNIQUE INDEX UNIQ_7ADE9A79DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_ProductPictures (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'The Original Name of the File.\', INDEX IDX_3A0B8B937E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_Products (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, published TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, description VARCHAR(255) DEFAULT NULL, price NUMERIC(8, 2) NOT NULL, UNIQUE INDEX UNIQ_D8F34E8C989D9B62 (slug), INDEX IDX_D8F34E8C38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_Product_Categories (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FA8937394584665A (product_id), INDEX IDX_FA89373912469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Coupons (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, pricing_plan_id INT DEFAULT NULL, code VARCHAR(16) NOT NULL, name VARCHAR(255) DEFAULT NULL, amount_off NUMERIC(8, 2) DEFAULT NULL, percent_off NUMERIC(8, 2) DEFAULT NULL, valid TINYINT(1) NOT NULL, type ENUM(\'discount_coupon\', \'payment_coupon\'), created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_117A76D577153098 (code), INDEX IDX_117A76D538248176 (currency_id), INDEX IDX_117A76D529628C71 (pricing_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'Coupons fields are Inspired by Stripe Coupon Fields\' ');
        $this->addSql('CREATE TABLE VSPAY_Currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8C67285577153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_ExchangeRate (id INT AUTO_INCREMENT NOT NULL, source_currency INT NOT NULL, target_currency INT NOT NULL, ratio NUMERIC(10, 5) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1401B6152A76BEED (source_currency), INDEX IDX_1401B615B3FD5856 (target_currency), UNIQUE INDEX UNIQ_1401B6152A76BEEDB3FD5856 (source_currency, target_currency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_GatewayConfig (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, gateway_name VARCHAR(255) NOT NULL, factory_name VARCHAR(255) NOT NULL, config LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', title VARCHAR(255) DEFAULT \'\' NOT NULL, description VARCHAR(255) DEFAULT NULL, use_sandbox TINYINT(1) NOT NULL, sandbox_config LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_BDE8BA6938248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Order (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, payment_method_id INT DEFAULT NULL, coupon_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, total_amount DOUBLE PRECISION NOT NULL, currency_code VARCHAR(8) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, status ENUM(\'shopping_cart\', \'paid_order\', \'pending_order\', \'failed_order\'), session_id VARCHAR(255) DEFAULT NULL, recurring_payment TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_87954502A76ED395 (user_id), INDEX IDX_879545025AA1164F (payment_method_id), INDEX IDX_8795450266C5951B (coupon_id), UNIQUE INDEX UNIQ_879545024C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_OrderItem (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, subscription_id INT DEFAULT NULL, product_id INT DEFAULT NULL, payable_object_type VARCHAR(255) NOT NULL, price NUMERIC(8, 2) NOT NULL, currency_code VARCHAR(8) NOT NULL, qty INT DEFAULT 1 NOT NULL, INDEX IDX_1C9B655C8D9F6D38 (order_id), INDEX IDX_1C9B655C9A1887DC (subscription_id), INDEX IDX_1C9B655C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_Payment (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, client_email VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, total_amount INT DEFAULT NULL, currency_code VARCHAR(255) DEFAULT NULL, details LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', real_amount NUMERIC(8, 2) DEFAULT \'0.00\' NOT NULL COMMENT \'Need this for Real (Human Readable) Amount.\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_PaymentMethod (id INT AUTO_INCREMENT NOT NULL, gateway_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1CCD1B9F989D9B62 (slug), INDEX IDX_1CCD1B9F577F8E00 (gateway_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSPAY_PaymentTokens (hash VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', after_url LONGTEXT DEFAULT NULL, target_url LONGTEXT NOT NULL, gateway_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(hash)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_MailchimpAudiences (id INT AUTO_INCREMENT NOT NULL, audience_id VARCHAR(16) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_NewsletterSubscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mailchimp_audience_id INT NOT NULL, user_email VARCHAR(64) NOT NULL, date DATETIME NOT NULL, INDEX IDX_E521F0DCA76ED395 (user_id), INDEX IDX_E521F0DCF03423AE (mailchimp_audience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_PayedServiceCategories (id INT AUTO_INCREMENT NOT NULL, taxon_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9E88F124DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_PayedServiceSubscriptionPeriods (id INT AUTO_INCREMENT NOT NULL, payed_service_id INT DEFAULT NULL, subscription_period VARCHAR(64) NOT NULL, title VARCHAR(64) DEFAULT NULL, description LONGTEXT DEFAULT NULL, paid_service_period_code VARCHAR(255) NOT NULL COMMENT \'The Code Used To Find The Subscription Period in Fixture Factory when Creating Pricing Plans.\', INDEX IDX_1018A6BE5139FC0A (payed_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_PayedServices (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, description LONGTEXT NOT NULL, subscription_code VARCHAR(64) NOT NULL COMMENT \'Subscription Code Group Payed Services for an identical parameter but with differents levels(priority).\', subscription_priority INT NOT NULL COMMENT \'Subscription Priority is the level of a Subscription Code.\', INDEX IDX_5E8A244512469DE2 (category_id), UNIQUE INDEX subscription_idx (subscription_code, subscription_priority), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSUS_PayedServicesAttributes (id INT AUTO_INCREMENT NOT NULL, payed_service_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, value VARCHAR(64) NOT NULL, INDEX IDX_685989135139FC0A (payed_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanCategories ADD CONSTRAINT FK_10C2B955727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_PricingPlanCategories (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanCategories ADD CONSTRAINT FK_10C2B955DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A029628C71 FOREIGN KEY (pricing_plan_id) REFERENCES VSCAT_PricingPlans (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A0A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0538248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0512469DE2 FOREIGN KEY (category_id) REFERENCES VSCAT_PricingPlanCategories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0587FFD8A7 FOREIGN KEY (paid_service_id) REFERENCES VSUS_PayedServiceSubscriptionPeriods (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCAT_ProductCategories ADD CONSTRAINT FK_7ADE9A79727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_ProductCategories (id)');
        $this->addSql('ALTER TABLE VSCAT_ProductCategories ADD CONSTRAINT FK_7ADE9A79DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSCAT_ProductPictures ADD CONSTRAINT FK_3A0B8B937E3C61F9 FOREIGN KEY (owner_id) REFERENCES VSCAT_Products (id)');
        $this->addSql('ALTER TABLE VSCAT_Products ADD CONSTRAINT FK_D8F34E8C38248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)');
        $this->addSql('ALTER TABLE VSCAT_Product_Categories ADD CONSTRAINT FK_FA8937394584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)');
        $this->addSql('ALTER TABLE VSCAT_Product_Categories ADD CONSTRAINT FK_FA89373912469DE2 FOREIGN KEY (category_id) REFERENCES VSCAT_ProductCategories (id)');
        $this->addSql('ALTER TABLE VSPAY_Coupons ADD CONSTRAINT FK_117A76D538248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)');
        $this->addSql('ALTER TABLE VSPAY_Coupons ADD CONSTRAINT FK_117A76D529628C71 FOREIGN KEY (pricing_plan_id) REFERENCES VSCAT_PricingPlans (id)');
        $this->addSql('ALTER TABLE VSPAY_ExchangeRate ADD CONSTRAINT FK_1401B6152A76BEED FOREIGN KEY (source_currency) REFERENCES VSPAY_Currency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_ExchangeRate ADD CONSTRAINT FK_1401B615B3FD5856 FOREIGN KEY (target_currency) REFERENCES VSPAY_Currency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSPAY_GatewayConfig ADD CONSTRAINT FK_BDE8BA6938248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_87954502A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_879545025AA1164F FOREIGN KEY (payment_method_id) REFERENCES VSPAY_PaymentMethod (id)');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_8795450266C5951B FOREIGN KEY (coupon_id) REFERENCES VSPAY_Coupons (id)');
        $this->addSql('ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_879545024C3A3BB FOREIGN KEY (payment_id) REFERENCES VSPAY_Payment (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C8D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C9A1887DC FOREIGN KEY (subscription_id) REFERENCES VSCAT_PricingPlanSubscriptions (id)');
        $this->addSql('ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C4584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)');
        $this->addSql('ALTER TABLE VSPAY_PaymentMethod ADD CONSTRAINT FK_1CCD1B9F577F8E00 FOREIGN KEY (gateway_id) REFERENCES VSPAY_GatewayConfig (id)');
        $this->addSql('ALTER TABLE VSUS_NewsletterSubscriptions ADD CONSTRAINT FK_E521F0DCA76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSUS_NewsletterSubscriptions ADD CONSTRAINT FK_E521F0DCF03423AE FOREIGN KEY (mailchimp_audience_id) REFERENCES VSUS_MailchimpAudiences (id)');
        $this->addSql('ALTER TABLE VSUS_PayedServiceCategories ADD CONSTRAINT FK_9E88F124DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSUS_PayedServiceSubscriptionPeriods ADD CONSTRAINT FK_1018A6BE5139FC0A FOREIGN KEY (payed_service_id) REFERENCES VSUS_PayedServices (id)');
        $this->addSql('ALTER TABLE VSUS_PayedServices ADD CONSTRAINT FK_5E8A244512469DE2 FOREIGN KEY (category_id) REFERENCES VSUS_PayedServiceCategories (id)');
        $this->addSql('ALTER TABLE VSUS_PayedServicesAttributes ADD CONSTRAINT FK_685989135139FC0A FOREIGN KEY (payed_service_id) REFERENCES VSUS_PayedServices (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSUM_Users ADD payment_details LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955727ACA70');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955DE13F470');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A029628C71');
        $this->addSql('ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A0A76ED395');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0538248176');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0512469DE2');
        $this->addSql('ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0587FFD8A7');
        $this->addSql('ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79727ACA70');
        $this->addSql('ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79DE13F470');
        $this->addSql('ALTER TABLE VSCAT_ProductPictures DROP FOREIGN KEY FK_3A0B8B937E3C61F9');
        $this->addSql('ALTER TABLE VSCAT_Products DROP FOREIGN KEY FK_D8F34E8C38248176');
        $this->addSql('ALTER TABLE VSCAT_Product_Categories DROP FOREIGN KEY FK_FA8937394584665A');
        $this->addSql('ALTER TABLE VSCAT_Product_Categories DROP FOREIGN KEY FK_FA89373912469DE2');
        $this->addSql('ALTER TABLE VSPAY_Coupons DROP FOREIGN KEY FK_117A76D538248176');
        $this->addSql('ALTER TABLE VSPAY_Coupons DROP FOREIGN KEY FK_117A76D529628C71');
        $this->addSql('ALTER TABLE VSPAY_ExchangeRate DROP FOREIGN KEY FK_1401B6152A76BEED');
        $this->addSql('ALTER TABLE VSPAY_ExchangeRate DROP FOREIGN KEY FK_1401B615B3FD5856');
        $this->addSql('ALTER TABLE VSPAY_GatewayConfig DROP FOREIGN KEY FK_BDE8BA6938248176');
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_87954502A76ED395');
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_879545025AA1164F');
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_8795450266C5951B');
        $this->addSql('ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_879545024C3A3BB');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C8D9F6D38');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C9A1887DC');
        $this->addSql('ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C4584665A');
        $this->addSql('ALTER TABLE VSPAY_PaymentMethod DROP FOREIGN KEY FK_1CCD1B9F577F8E00');
        $this->addSql('ALTER TABLE VSUS_NewsletterSubscriptions DROP FOREIGN KEY FK_E521F0DCA76ED395');
        $this->addSql('ALTER TABLE VSUS_NewsletterSubscriptions DROP FOREIGN KEY FK_E521F0DCF03423AE');
        $this->addSql('ALTER TABLE VSUS_PayedServiceCategories DROP FOREIGN KEY FK_9E88F124DE13F470');
        $this->addSql('ALTER TABLE VSUS_PayedServiceSubscriptionPeriods DROP FOREIGN KEY FK_1018A6BE5139FC0A');
        $this->addSql('ALTER TABLE VSUS_PayedServices DROP FOREIGN KEY FK_5E8A244512469DE2');
        $this->addSql('ALTER TABLE VSUS_PayedServicesAttributes DROP FOREIGN KEY FK_685989135139FC0A');
        $this->addSql('DROP TABLE VSCAT_PricingPlanCategories');
        $this->addSql('DROP TABLE VSCAT_PricingPlanSubscriptions');
        $this->addSql('DROP TABLE VSCAT_PricingPlans');
        $this->addSql('DROP TABLE VSCAT_ProductCategories');
        $this->addSql('DROP TABLE VSCAT_ProductPictures');
        $this->addSql('DROP TABLE VSCAT_Products');
        $this->addSql('DROP TABLE VSCAT_Product_Categories');
        $this->addSql('DROP TABLE VSPAY_Coupons');
        $this->addSql('DROP TABLE VSPAY_Currency');
        $this->addSql('DROP TABLE VSPAY_ExchangeRate');
        $this->addSql('DROP TABLE VSPAY_GatewayConfig');
        $this->addSql('DROP TABLE VSPAY_Order');
        $this->addSql('DROP TABLE VSPAY_OrderItem');
        $this->addSql('DROP TABLE VSPAY_Payment');
        $this->addSql('DROP TABLE VSPAY_PaymentMethod');
        $this->addSql('DROP TABLE VSPAY_PaymentTokens');
        $this->addSql('DROP TABLE VSUS_MailchimpAudiences');
        $this->addSql('DROP TABLE VSUS_NewsletterSubscriptions');
        $this->addSql('DROP TABLE VSUS_PayedServiceCategories');
        $this->addSql('DROP TABLE VSUS_PayedServiceSubscriptionPeriods');
        $this->addSql('DROP TABLE VSUS_PayedServices');
        $this->addSql('DROP TABLE VSUS_PayedServicesAttributes');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSUM_Users DROP payment_details');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
