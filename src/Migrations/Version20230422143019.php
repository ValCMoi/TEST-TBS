<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230422143019 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, product INT DEFAULT NULL, contact INT DEFAULT NULL, beginDate DATETIME NOT NULL, endDate DATETIME DEFAULT NULL, INDEX IDX_A3C664D3D34A04AD (product), INDEX IDX_A3C664D34C62E638 (contact), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D34C62E638 FOREIGN KEY (contact) REFERENCES contact (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D34C62E638');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3D34A04AD');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE product');
    }
}
