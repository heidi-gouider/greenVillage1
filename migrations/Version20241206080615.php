<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206080615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_68C58ED9FB88E14F (utilisateur_id), INDEX IDX_68C58ED94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED94584665A FOREIGN KEY (product_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9FB88E14F');
        // $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED94584665A');
        // $this->addSql('DROP TABLE favorite');
    }
}
