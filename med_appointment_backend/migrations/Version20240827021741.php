<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827021741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, beneficiario_id INT NOT NULL, medico_id INT NOT NULL, hospital_id INT NOT NULL, data DATE NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_A6FE3FDE4B64ABC7 (beneficiario_id), INDEX IDX_A6FE3FDEA7FB1C0C (medico_id), INDEX IDX_A6FE3FDE63DBB69 (hospital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE4B64ABC7 FOREIGN KEY (beneficiario_id) REFERENCES beneficiario (id)');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA7FB1C0C FOREIGN KEY (medico_id) REFERENCES medico (id)');
        $this->addSql('ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE4B64ABC7');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA7FB1C0C');
        $this->addSql('ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE63DBB69');
        $this->addSql('DROP TABLE consulta');
    }
}
