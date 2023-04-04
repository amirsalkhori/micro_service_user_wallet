<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316145431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet ADD before_amount DOUBLE PRECISION DEFAULT NULL, ADD effective_amount DOUBLE PRECISION DEFAULT NULL, ADD after_amount DOUBLE PRECISION DEFAULT NULL, DROP balance');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet ADD balance INT NOT NULL, DROP before_amount, DROP effective_amount, DROP after_amount');
    }
}
