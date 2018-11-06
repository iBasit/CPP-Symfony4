<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181106141936 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, league_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, strip VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE INDEX fk_league_idx ON team (league_id)');
        $this->addSql('CREATE TABLE league (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE league');
    }
}
