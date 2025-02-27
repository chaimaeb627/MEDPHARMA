<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226001853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicament_commande (medicament_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_81D516D1AB0D61F7 (medicament_id), INDEX IDX_81D516D182EA2E54 (commande_id), PRIMARY KEY(medicament_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicament_commande ADD CONSTRAINT FK_81D516D1AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicament_commande ADD CONSTRAINT FK_81D516D182EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit CHANGE prix prix NUMERIC(10, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(10, 2) DEFAULT NULL, CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicament_commande DROP FOREIGN KEY FK_81D516D1AB0D61F7');
        $this->addSql('ALTER TABLE medicament_commande DROP FOREIGN KEY FK_81D516D182EA2E54');
        $this->addSql('DROP TABLE medicament_commande');
        $this->addSql('ALTER TABLE produit CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(7, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(7, 2) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE categorie categorie VARCHAR(100) NOT NULL');
    }
}
