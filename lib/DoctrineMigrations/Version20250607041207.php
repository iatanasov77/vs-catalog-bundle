<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607041207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_AssociationTypes (id INT AUTO_INCREMENT NOT NULL, association_strategy VARCHAR(255) DEFAULT 'strategy_associated' NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7F20F79077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_PricingPlanCategories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, taxon_id INT DEFAULT NULL, INDEX IDX_10C2B955727ACA70 (parent_id), UNIQUE INDEX UNIQ_10C2B955DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_PricingPlanSubscriptions (id INT AUTO_INCREMENT NOT NULL, pricing_plan_id INT NOT NULL, user_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, recurring_payment TINYINT(1) DEFAULT 0 NOT NULL, recurring_payment_cancelled TINYINT(1) DEFAULT 0 NOT NULL, price NUMERIC(8, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, expires_at DATETIME DEFAULT NULL COMMENT 'Is Updated when create a  New payment for this subscription.', gateway_attributes JSON DEFAULT NULL, INDEX IDX_EA3E01A029628C71 (pricing_plan_id), INDEX IDX_EA3E01A0A76ED395 (user_id), INDEX IDX_EA3E01A038248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_PricingPlans (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, category_id INT NOT NULL, paid_service_id INT NOT NULL, active TINYINT(1) NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, premium TINYINT(1) NOT NULL, discount NUMERIC(8, 2) DEFAULT NULL, price NUMERIC(8, 2) DEFAULT '0.00' NOT NULL, gateway_attributes JSON DEFAULT NULL, payment_description LONGTEXT DEFAULT NULL, INDEX IDX_615E6C0538248176 (currency_id), INDEX IDX_615E6C0512469DE2 (category_id), INDEX IDX_615E6C0587FFD8A7 (paid_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_ProductAssociations (id INT AUTO_INCREMENT NOT NULL, association_type_id INT NOT NULL, product_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_559D3973B1E1C39 (association_type_id), INDEX IDX_559D39734584665A (product_id), UNIQUE INDEX product_association_idx (product_id, association_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_Product_Associations (association_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_D832974EFB9C8A5 (association_id), INDEX IDX_D8329744584665A (product_id), PRIMARY KEY(association_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_ProductCategories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, taxon_id INT DEFAULT NULL, INDEX IDX_7ADE9A79727ACA70 (parent_id), UNIQUE INDEX UNIQ_7ADE9A79DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_ProductFiles (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) DEFAULT '' NOT NULL COMMENT 'The Original Name of the File.', code VARCHAR(255) NOT NULL, INDEX IDX_F4F29C927E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_ProductPictures (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) DEFAULT '' NOT NULL COMMENT 'The Original Name of the File.', code VARCHAR(255) NOT NULL, INDEX IDX_3A0B8B937E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_Products (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, published TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, in_stock INT DEFAULT 0 NOT NULL, tags VARCHAR(255) DEFAULT '', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, price NUMERIC(8, 2) NOT NULL, average_rating DOUBLE PRECISION DEFAULT '0' NOT NULL, UNIQUE INDEX UNIQ_D8F34E8C989D9B62 (slug), INDEX IDX_D8F34E8C38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSCAT_Product_Categories (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FA8937394584665A (product_id), INDEX IDX_FA89373912469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Adjustments (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, order_item_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, label VARCHAR(255) DEFAULT NULL, amount INT NOT NULL, is_neutral TINYINT(1) NOT NULL, is_locked TINYINT(1) NOT NULL, origin_code VARCHAR(255) DEFAULT NULL, details JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_55CA71E28D9F6D38 (order_id), INDEX IDX_55CA71E2E415FB15 (order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8C67285577153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_CustomerGroups (id INT AUTO_INCREMENT NOT NULL, taxon_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D3A9BC4DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_ExchangeRate (id INT AUTO_INCREMENT NOT NULL, source_currency INT NOT NULL, target_currency INT NOT NULL, ratio NUMERIC(10, 5) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1401B6152A76BEED (source_currency), INDEX IDX_1401B615B3FD5856 (target_currency), UNIQUE INDEX UNIQ_1401B6152A76BEEDB3FD5856 (source_currency, target_currency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_ExchangeRateServices (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, service_id VARCHAR(255) NOT NULL, options JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_GatewayConfig (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, gateway_name VARCHAR(255) NOT NULL, factory_name VARCHAR(255) NOT NULL, config JSON NOT NULL, title VARCHAR(255) DEFAULT '' NOT NULL, description VARCHAR(255) DEFAULT NULL, use_sandbox TINYINT(1) NOT NULL, sandbox_config JSON DEFAULT NULL, INDEX IDX_BDE8BA6938248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Order (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, payment_method_id INT DEFAULT NULL, promotion_coupon_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, currency_code VARCHAR(8) NOT NULL, items_total INT NOT NULL, adjustments_total INT NOT NULL, total INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, status VARCHAR(32) NOT NULL COMMENT 'NEED THIS BECAUSE ORDER SHOULD BE CREATED BEFORE THE PAYMENT IS PRAPARED AND DONE.', session_id VARCHAR(255) DEFAULT NULL, recurring_payment TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_87954502A76ED395 (user_id), INDEX IDX_879545025AA1164F (payment_method_id), INDEX IDX_8795450217B24436 (promotion_coupon_id), UNIQUE INDEX UNIQ_879545024C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Promotion_Orders (order_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_DEAB205F8D9F6D38 (order_id), INDEX IDX_DEAB205F139DF194 (promotion_id), PRIMARY KEY(order_id, promotion_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_OrderItem (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, subscription_id INT DEFAULT NULL, product_id INT DEFAULT NULL, payable_object_type VARCHAR(255) NOT NULL, price NUMERIC(8, 2) NOT NULL, currency_code VARCHAR(8) NOT NULL, qty INT DEFAULT 1 NOT NULL, adjustments_total INT NOT NULL, total INT NOT NULL, product_name LONGTEXT DEFAULT NULL, INDEX IDX_1C9B655C8D9F6D38 (order_id), INDEX IDX_1C9B655C9A1887DC (subscription_id), INDEX IDX_1C9B655C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Payment (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, client_email VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, total_amount INT DEFAULT NULL, currency_code VARCHAR(255) DEFAULT NULL, details JSON NOT NULL, real_amount NUMERIC(8, 2) DEFAULT '0.00' NOT NULL COMMENT 'Need this for Real (Human Readable) Amount.', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_PaymentMethod (id INT AUTO_INCREMENT NOT NULL, gateway_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1CCD1B9F989D9B62 (slug), INDEX IDX_1CCD1B9F577F8E00 (gateway_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_PaymentTokens (hash VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:object)', after_url LONGTEXT DEFAULT NULL, target_url LONGTEXT NOT NULL, gateway_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(hash)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_PromotionActions (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT '(DC2Type:array)', INDEX IDX_FEEF777139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_PromotionCoupons (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, usage_limit INT DEFAULT NULL, used INT NOT NULL, expires_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FFC2178077153098 (code), INDEX IDX_FFC21780139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_PromotionRules (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT '(DC2Type:array)', INDEX IDX_9D727099139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Promotions (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, exclusive TINYINT(1) NOT NULL, usage_limit INT DEFAULT NULL, used INT NOT NULL, coupon_based TINYINT(1) NOT NULL, starts_at DATETIME DEFAULT NULL, ends_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A3DFF5C077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSPAY_Promotion_Applications (promotion_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_1D3F36D5139DF194 (promotion_id), INDEX IDX_1D3F36D53E030ACD (application_id), PRIMARY KEY(promotion_id, application_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSUS_MailchimpAudiences (id INT AUTO_INCREMENT NOT NULL, audience_id VARCHAR(16) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSUS_NewsletterSubscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mailchimp_audience_id INT NOT NULL, user_email VARCHAR(64) NOT NULL, date DATETIME NOT NULL, INDEX IDX_E521F0DCA76ED395 (user_id), INDEX IDX_E521F0DCF03423AE (mailchimp_audience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSUS_PayedServiceSubscriptionPeriods (id INT AUTO_INCREMENT NOT NULL, payed_service_id INT NOT NULL, subscription_period VARCHAR(64) NOT NULL, title VARCHAR(64) DEFAULT NULL, description LONGTEXT DEFAULT NULL, paid_service_period_code VARCHAR(255) NOT NULL COMMENT 'The Code Used To Find The Subscription Period in Fixture Factory when Creating Pricing Plans.', INDEX IDX_1018A6BE5139FC0A (payed_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSUS_PayedServices (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, description LONGTEXT NOT NULL, subscription_code VARCHAR(64) NOT NULL COMMENT 'Subscription Code Group Payed Services for an identical parameter but with differents levels(priority).', subscription_priority INT NOT NULL COMMENT 'Subscription Priority is the level of a Subscription Code.', UNIQUE INDEX subscription_idx (subscription_code, subscription_priority), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VSUS_PayedServicesAttributes (id INT AUTO_INCREMENT NOT NULL, payed_service_id INT NOT NULL, name VARCHAR(64) NOT NULL, value VARCHAR(64) NOT NULL, INDEX IDX_685989135139FC0A (payed_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A029628C71 FOREIGN KEY (pricing_plan_id) REFERENCES VSCAT_PricingPlans (id)
        SQL);
        
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions ADD CONSTRAINT FK_EA3E01A038248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0538248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0512469DE2 FOREIGN KEY (category_id) REFERENCES VSCAT_PricingPlanCategories (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans ADD CONSTRAINT FK_615E6C0587FFD8A7 FOREIGN KEY (paid_service_id) REFERENCES VSUS_PayedServiceSubscriptionPeriods (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductAssociations ADD CONSTRAINT FK_559D3973B1E1C39 FOREIGN KEY (association_type_id) REFERENCES VSCAT_AssociationTypes (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductAssociations ADD CONSTRAINT FK_559D39734584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Associations ADD CONSTRAINT FK_D832974EFB9C8A5 FOREIGN KEY (association_id) REFERENCES VSCAT_ProductAssociations (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Associations ADD CONSTRAINT FK_D8329744584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories ADD CONSTRAINT FK_7ADE9A79727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_ProductCategories (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductFiles ADD CONSTRAINT FK_F4F29C927E3C61F9 FOREIGN KEY (owner_id) REFERENCES VSCAT_Products (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductPictures ADD CONSTRAINT FK_3A0B8B937E3C61F9 FOREIGN KEY (owner_id) REFERENCES VSCAT_Products (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Products ADD CONSTRAINT FK_D8F34E8C38248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Categories ADD CONSTRAINT FK_FA8937394584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Categories ADD CONSTRAINT FK_FA89373912469DE2 FOREIGN KEY (category_id) REFERENCES VSCAT_ProductCategories (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Adjustments ADD CONSTRAINT FK_55CA71E28D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Adjustments ADD CONSTRAINT FK_55CA71E2E415FB15 FOREIGN KEY (order_item_id) REFERENCES VSPAY_OrderItem (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_ExchangeRate ADD CONSTRAINT FK_1401B6152A76BEED FOREIGN KEY (source_currency) REFERENCES VSPAY_Currency (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_ExchangeRate ADD CONSTRAINT FK_1401B615B3FD5856 FOREIGN KEY (target_currency) REFERENCES VSPAY_Currency (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_GatewayConfig ADD CONSTRAINT FK_BDE8BA6938248176 FOREIGN KEY (currency_id) REFERENCES VSPAY_Currency (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_879545025AA1164F FOREIGN KEY (payment_method_id) REFERENCES VSPAY_PaymentMethod (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_8795450217B24436 FOREIGN KEY (promotion_coupon_id) REFERENCES VSPAY_PromotionCoupons (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order ADD CONSTRAINT FK_879545024C3A3BB FOREIGN KEY (payment_id) REFERENCES VSPAY_Payment (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Orders ADD CONSTRAINT FK_DEAB205F8D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Orders ADD CONSTRAINT FK_DEAB205F139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C8D9F6D38 FOREIGN KEY (order_id) REFERENCES VSPAY_Order (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C9A1887DC FOREIGN KEY (subscription_id) REFERENCES VSCAT_PricingPlanSubscriptions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem ADD CONSTRAINT FK_1C9B655C4584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PaymentMethod ADD CONSTRAINT FK_1CCD1B9F577F8E00 FOREIGN KEY (gateway_id) REFERENCES VSPAY_GatewayConfig (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionActions ADD CONSTRAINT FK_FEEF777139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionCoupons ADD CONSTRAINT FK_FFC21780139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionRules ADD CONSTRAINT FK_9D727099139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Applications ADD CONSTRAINT FK_1D3F36D5139DF194 FOREIGN KEY (promotion_id) REFERENCES VSPAY_Promotions (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_NewsletterSubscriptions ADD CONSTRAINT FK_E521F0DCF03423AE FOREIGN KEY (mailchimp_audience_id) REFERENCES VSUS_MailchimpAudiences (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_PayedServiceSubscriptionPeriods ADD CONSTRAINT FK_1018A6BE5139FC0A FOREIGN KEY (payed_service_id) REFERENCES VSUS_PayedServices (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_PayedServicesAttributes ADD CONSTRAINT FK_685989135139FC0A FOREIGN KEY (payed_service_id) REFERENCES VSUS_PayedServices (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_Users ADD customer_group_id INT DEFAULT NULL, ADD payment_details JSON DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_Users ADD CONSTRAINT FK_CAFDCD03D2919A68 FOREIGN KEY (customer_group_id) REFERENCES VSPAY_CustomerGroups (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CAFDCD03D2919A68 ON VSUM_Users (customer_group_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM('mr', 'mrs', 'miss')
        SQL);
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_Users DROP FOREIGN KEY FK_CAFDCD03D2919A68
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955DE13F470
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A029628C71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A0A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions DROP FOREIGN KEY FK_EA3E01A038248176
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0538248176
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0512469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlans DROP FOREIGN KEY FK_615E6C0587FFD8A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductAssociations DROP FOREIGN KEY FK_559D3973B1E1C39
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductAssociations DROP FOREIGN KEY FK_559D39734584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Associations DROP FOREIGN KEY FK_D832974EFB9C8A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Associations DROP FOREIGN KEY FK_D8329744584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79DE13F470
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductFiles DROP FOREIGN KEY FK_F4F29C927E3C61F9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductPictures DROP FOREIGN KEY FK_3A0B8B937E3C61F9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Products DROP FOREIGN KEY FK_D8F34E8C38248176
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Categories DROP FOREIGN KEY FK_FA8937394584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_Product_Categories DROP FOREIGN KEY FK_FA89373912469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Adjustments DROP FOREIGN KEY FK_55CA71E28D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Adjustments DROP FOREIGN KEY FK_55CA71E2E415FB15
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_CustomerGroups DROP FOREIGN KEY FK_8D3A9BC4DE13F470
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_ExchangeRate DROP FOREIGN KEY FK_1401B6152A76BEED
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_ExchangeRate DROP FOREIGN KEY FK_1401B615B3FD5856
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_GatewayConfig DROP FOREIGN KEY FK_BDE8BA6938248176
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_87954502A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_879545025AA1164F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_8795450217B24436
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order DROP FOREIGN KEY FK_879545024C3A3BB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Orders DROP FOREIGN KEY FK_DEAB205F8D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Orders DROP FOREIGN KEY FK_DEAB205F139DF194
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C8D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C9A1887DC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_OrderItem DROP FOREIGN KEY FK_1C9B655C4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PaymentMethod DROP FOREIGN KEY FK_1CCD1B9F577F8E00
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionActions DROP FOREIGN KEY FK_FEEF777139DF194
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionCoupons DROP FOREIGN KEY FK_FFC21780139DF194
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_PromotionRules DROP FOREIGN KEY FK_9D727099139DF194
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Applications DROP FOREIGN KEY FK_1D3F36D5139DF194
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Promotion_Applications DROP FOREIGN KEY FK_1D3F36D53E030ACD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_NewsletterSubscriptions DROP FOREIGN KEY FK_E521F0DCA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_NewsletterSubscriptions DROP FOREIGN KEY FK_E521F0DCF03423AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_PayedServiceSubscriptionPeriods DROP FOREIGN KEY FK_1018A6BE5139FC0A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUS_PayedServicesAttributes DROP FOREIGN KEY FK_685989135139FC0A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_AssociationTypes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_PricingPlanCategories
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_PricingPlanSubscriptions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_PricingPlans
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_ProductAssociations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_Product_Associations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_ProductCategories
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_ProductFiles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_ProductPictures
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_Products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSCAT_Product_Categories
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Adjustments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Currency
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_CustomerGroups
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_ExchangeRate
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_ExchangeRateServices
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_GatewayConfig
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Order
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Promotion_Orders
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_OrderItem
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Payment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_PaymentMethod
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_PaymentTokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_PromotionActions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_PromotionCoupons
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_PromotionRules
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Promotions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSPAY_Promotion_Applications
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSUS_MailchimpAudiences
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSUS_NewsletterSubscriptions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSUS_PayedServiceSubscriptionPeriods
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSUS_PayedServices
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VSUS_PayedServicesAttributes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_CAFDCD03D2919A68 ON VSUM_Users
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_Users DROP customer_group_id, DROP payment_details
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL
        SQL);
    }
}
