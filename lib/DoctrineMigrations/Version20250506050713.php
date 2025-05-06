<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506050713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order DROP total_amount
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSPAY_Order ADD total_amount DOUBLE PRECISION NOT NULL
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
    }
}
