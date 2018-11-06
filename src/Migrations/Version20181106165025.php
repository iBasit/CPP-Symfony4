<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181106165025 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX fk_league_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__team AS SELECT id, league_id, name, strip FROM team');
        $this->addSql('DROP TABLE team');
        $this->addSql('CREATE TABLE team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, league_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL COLLATE BINARY, strip VARCHAR(100) NOT NULL COLLATE BINARY, CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO team (id, league_id, name, strip) SELECT id, league_id, name, strip FROM __temp__team');
        $this->addSql('DROP TABLE __temp__team');
        $this->addSql('CREATE INDEX fk_league_idx ON team (league_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX fk_league_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__team AS SELECT id, league_id, name, strip FROM team');
        $this->addSql('DROP TABLE team');
        $this->addSql('CREATE TABLE team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, league_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, strip VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO team (id, league_id, name, strip) SELECT id, league_id, name, strip FROM __temp__team');
        $this->addSql('DROP TABLE __temp__team');
        $this->addSql('CREATE INDEX fk_league_idx ON team (league_id)');
    }
}
