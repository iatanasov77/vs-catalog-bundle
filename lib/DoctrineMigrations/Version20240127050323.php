<?php

declare(strict_types=1);

namespace Vankosoft\CatalogBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127050323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSCAT_AssociationTypes (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7F20F79077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_ProductAssociations (id INT AUTO_INCREMENT NOT NULL, association_type_id INT NOT NULL, product_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_559D3973B1E1C39 (association_type_id), INDEX IDX_559D39734584665A (product_id), UNIQUE INDEX product_association_idx (product_id, association_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCAT_Product_Associations (association_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_D832974EFB9C8A5 (association_id), INDEX IDX_D8329744584665A (product_id), PRIMARY KEY(association_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSCAT_ProductAssociations ADD CONSTRAINT FK_559D3973B1E1C39 FOREIGN KEY (association_type_id) REFERENCES VSCAT_AssociationTypes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCAT_ProductAssociations ADD CONSTRAINT FK_559D39734584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCAT_Product_Associations ADD CONSTRAINT FK_D832974EFB9C8A5 FOREIGN KEY (association_id) REFERENCES VSCAT_ProductAssociations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCAT_Product_Associations ADD CONSTRAINT FK_D8329744584665A FOREIGN KEY (product_id) REFERENCES VSCAT_Products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type ENUM(\'discount_coupon\', \'payment_coupon\')');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status ENUM(\'shopping_cart\', \'paid_order\', \'pending_order\', \'failed_order\')');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCAT_ProductAssociations DROP FOREIGN KEY FK_559D3973B1E1C39');
        $this->addSql('ALTER TABLE VSCAT_ProductAssociations DROP FOREIGN KEY FK_559D39734584665A');
        $this->addSql('ALTER TABLE VSCAT_Product_Associations DROP FOREIGN KEY FK_D832974EFB9C8A5');
        $this->addSql('ALTER TABLE VSCAT_Product_Associations DROP FOREIGN KEY FK_D8329744584665A');
        $this->addSql('DROP TABLE VSCAT_AssociationTypes');
        $this->addSql('DROP TABLE VSCAT_ProductAssociations');
        $this->addSql('DROP TABLE VSCAT_Product_Associations');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSPAY_Coupons CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSPAY_Order CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
