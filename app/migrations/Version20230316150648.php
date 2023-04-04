<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316150648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D11645DEA9 ON transaction (reference_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C68921FA76ED395 ON wallet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7C68921FA76ED395 ON wallet');
        $this->addSql('DROP INDEX UNIQ_723705D11645DEA9 ON transaction');
    }
}
