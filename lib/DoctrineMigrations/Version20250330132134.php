<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330132134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories ADD CONSTRAINT FK_10C2B955727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_PricingPlanCategories (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions DROP active
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories ADD CONSTRAINT FK_7ADE9A79727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_ProductCategories (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories DROP FOREIGN KEY FK_10C2B955727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanCategories ADD CONSTRAINT FK_10C2B955727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_PricingPlanCategories (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_PricingPlanSubscriptions ADD active TINYINT(1) DEFAULT 0 NOT NULL COMMENT 'One Active Subscription for an User and for PaidService. Wnen the Payment succeed set active true and set active false for previous active for this paid service.'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories DROP FOREIGN KEY FK_7ADE9A79727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSCAT_ProductCategories ADD CONSTRAINT FK_7ADE9A79727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCAT_ProductCategories (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
