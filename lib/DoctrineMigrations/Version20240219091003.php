<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219091003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSPAY_CustomerGroups (id INT AUTO_INCREMENT NOT NULL, taxon_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D3A9BC4DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSPAY_CustomerGroups ADD CONSTRAINT FK_8D3A9BC4DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSUM_Users ADD customer_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_Users ADD CONSTRAINT FK_CAFDCD03D2919A68 FOREIGN KEY (customer_group_id) REFERENCES VSPAY_CustomerGroups (id)');
        $this->addSql('CREATE INDEX IDX_CAFDCD03D2919A68 ON VSUM_Users (customer_group_id)');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSUM_Users DROP FOREIGN KEY FK_CAFDCD03D2919A68');
        $this->addSql('ALTER TABLE VSPAY_CustomerGroups DROP FOREIGN KEY FK_8D3A9BC4DE13F470');
        $this->addSql('DROP TABLE VSPAY_CustomerGroups');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('DROP INDEX IDX_CAFDCD03D2919A68 ON VSUM_Users');
        $this->addSql('ALTER TABLE VSUM_Users DROP customer_group_id');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
