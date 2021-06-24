<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624124754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_picture');
        $this->addSql('ALTER TABLE picture ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F894584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F894584665A ON picture (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_picture (product_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_C7025439EE45BDBF (picture_id), INDEX IDX_C70254394584665A (product_id), PRIMARY KEY(product_id, picture_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C70254394584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C7025439EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F894584665A');
        $this->addSql('DROP INDEX IDX_16DB4F894584665A ON picture');
        $this->addSql('ALTER TABLE picture DROP product_id');
    }
}
