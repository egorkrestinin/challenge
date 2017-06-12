<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170612012728 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE characters (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', tile_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', health INT NOT NULL, strength INT NOT NULL, abilities LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', type INT NOT NULL, experience INT NOT NULL, INDEX IDX_3A29410E638AF48B (tile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE world_tiles (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', world_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', x INT NOT NULL, y INT NOT NULL, INDEX IDX_9D7556B48925311C (world_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE turns (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', character_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', tile_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_F3963B2D1136BE75 (character_id), INDEX IDX_F3963B2D638AF48B (tile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worlds (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', world_size_x INT NOT NULL, world_size_y INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E638AF48B FOREIGN KEY (tile_id) REFERENCES world_tiles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE world_tiles ADD CONSTRAINT FK_9D7556B48925311C FOREIGN KEY (world_id) REFERENCES worlds (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE turns ADD CONSTRAINT FK_F3963B2D1136BE75 FOREIGN KEY (character_id) REFERENCES characters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE turns ADD CONSTRAINT FK_F3963B2D638AF48B FOREIGN KEY (tile_id) REFERENCES world_tiles (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE turns DROP FOREIGN KEY FK_F3963B2D1136BE75');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E638AF48B');
        $this->addSql('ALTER TABLE turns DROP FOREIGN KEY FK_F3963B2D638AF48B');
        $this->addSql('ALTER TABLE world_tiles DROP FOREIGN KEY FK_9D7556B48925311C');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE world_tiles');
        $this->addSql('DROP TABLE turns');
        $this->addSql('DROP TABLE worlds');
    }
}
